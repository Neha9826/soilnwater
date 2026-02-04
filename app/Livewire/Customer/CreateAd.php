<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ad;
use App\Models\AdTier;
use App\Models\AdTemplate;
use App\Models\AdValue;
use Illuminate\Support\Facades\Auth;

class CreateAd extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $tiers;
    public $templates = [];
    public $selectedTierId;
    public $selectedTemplateId;
    public $selectedTemplate;
    
    // Dynamic Inputs
    public $inputs = [];
    public $image_uploads = []; // Store multiple images dynamically

    public function mount()
    {
        $this->tiers = AdTier::all();
    }

    public function selectTier($id)
    {
        $this->selectedTierId = $id;
        $this->templates = AdTemplate::where('ad_tier_id', $id)->where('is_active', true)->get();
        $this->step = 2;
    }

    public function selectTemplate($id)
    {
        $this->selectedTemplateId = $id;
        $this->selectedTemplate = AdTemplate::with('fields')->find($id);
        
        $this->inputs = [];
        foreach ($this->selectedTemplate->fields as $field) {
            // PRE-FILL with Admin's Master Content
            $this->inputs[$field->id] = $field->default_value;
        }
        
        $this->step = 3;
    }

    public function save()
    {
        $this->validate([
            'selectedTemplateId' => 'required',
            'inputs.*' => 'nullable' 
        ]);

        // 1. Create Ad Instance (Header)
        $ad = Ad::create([
            'user_id' => Auth::id(),
            'ad_template_id' => $this->selectedTemplateId,
            'title' => $this->inputs[$this->selectedTemplate->fields->first()->id] ?? 'New Ad',
            'status' => 'pending',
        ]);

        // 2. Save Dynamic Values
        foreach ($this->selectedTemplate->fields as $field) {
            $value = $this->inputs[$field->id];

            // Handle Dynamic Image Upload
            if ($field->type === 'image' && isset($this->image_uploads[$field->id])) {
                $value = $this->image_uploads[$field->id]->store('ads/content', 'public');
            }

            AdValue::create([
                'ad_id' => $ad->id,
                'field_id' => $field->id,
                'value' => $value
            ]);
        }

        session()->flash('message', 'Ad submitted for approval!');
        return redirect()->route('customer.listings');
    }

    public function saveAd()
    {
        // 1. Validate the user input based on the template's required fields
        $this->validate();

        // 2. Handle Image Uploads (Convert temporary paths to permanent storage)
        $processedData = $this->inputs;
        foreach ($this->selectedTemplate->fields as $field) {
            if ($field->type === 'image' && isset($this->inputs[$field->id])) {
                // Store the file in the 'ads' folder and keep the path
                $path = $this->inputs[$field->id]->store('ads', 'public');
                $processedData[$field->id] = $path;
            }
        }

        // 3. Create the unique Ad record for the authenticated user
        auth()->user()->ads()->create([
            'ad_template_id' => $this->selectedTemplate->id,
            'ad_tier_id' => $this->selectedTemplate->ad_tier_id,
            'content_data' => $processedData, // This stores your colors, text, and image paths
            'status' => 'pending', // Usually goes to "Approvals Center" next
        ]);

        session()->flash('message', 'Your advertisement has been saved successfully!');
        return redirect()->route('customer.my-ads');
    }

    public function render()
    {
        return view('livewire.customer.create-ad')->layout('layouts.app');
    }
}