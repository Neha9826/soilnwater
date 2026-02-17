<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ad;
use App\Models\AdTier;
use App\Models\AdTemplate;
use App\Models\AdValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AdPreviewGenerator;

class CreateAd extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $tiers;
    public $templates = [];
    public $selectedTierId;
    public $selectedTemplateId;
    public $selectedTemplate;

    public $inputs = [];
    public $image_uploads = [];

    public function mount()
    {
        $this->tiers = AdTier::all();
    }

    public function selectTier($id)
    {
        $this->selectedTierId = $id;
        $this->templates = AdTemplate::where('ad_tier_id', $id)
            ->where('is_active', true)
            ->get();

        $this->step = 2;
    }

    public function selectTemplate($id)
    {
        $this->selectedTemplateId = $id;
        $this->selectedTemplate = AdTemplate::with('fields')->findOrFail($id);

        $this->inputs = [];
        foreach ($this->selectedTemplate->fields as $field) {
            $this->inputs[$field->id] = $field->default_value;
        }

        $this->step = 3;
    }

    public function save()
    {
        $this->validate([
            'selectedTemplateId' => 'required',
            'inputs.*' => 'nullable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 1. CREATE AD
        |--------------------------------------------------------------------------
        */
        $ad = Ad::create([
            'user_id'         => Auth::id(),
            'ad_template_id'  => $this->selectedTemplateId,
            'title'           => $this->selectedTemplate->name . ' - User ' . Auth::id(),
            'status'          => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. SAVE AD VALUES
        |--------------------------------------------------------------------------
        */
        foreach ($this->selectedTemplate->fields as $field) {

            $value = $this->inputs[$field->id] ?? $field->default_value;

            if ($field->type === 'image' && isset($this->image_uploads[$field->id])) {
                $value = $this->image_uploads[$field->id]
                    ->store('ads/content', 'public');
            }

            AdValue::create([
                'ad_id'    => $ad->id,
                'field_id' => $field->id,
                'value'    => $value,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. GENERATE PREVIEW IMAGE
        |--------------------------------------------------------------------------
        */
        try {
            Log::info('AdPreviewGenerator: calling generate()', ['ad_id' => $ad->id]);

            $previewPath = AdPreviewGenerator::generate($ad);

if ($previewPath) {
    $ad->preview_image = $previewPath;
    $ad->save();

    \Log::info('Preview image generated & stored', [
        'ad_id' => $ad->id,
        'path'  => $previewPath,
    ]);
} else {
    \Log::warning('Preview image generation failed', [
        'ad_id' => $ad->id,
    ]);
}

        } catch (\Throwable $e) {
            Log::error('Ad preview generation failed', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);
        }

        session()->flash('message', 'Ad submitted for approval!');
        return redirect()->route('customer.listings');
    }

    /*
    |--------------------------------------------------------------------------
    | LEGACY METHOD (NOT USED – KEEP AS IS)
    |--------------------------------------------------------------------------
    */
    public function saveAd()
    {
        // This is NOT used by your UI
        // Safe to keep for now
    }

    public function render()
    {
        $previewData = [];

        if ($this->selectedTemplate) {
            foreach ($this->selectedTemplate->fields as $field) {
                if ($field->type === 'image' && isset($this->image_uploads[$field->id])) {
                    try {
                        $previewData[$field->field_name] =
                            $this->image_uploads[$field->id]->temporaryUrl();
                    } catch (\Exception $e) {
                        $previewData[$field->field_name] =
                            asset('images/placeholder.jpg');
                    }
                } else {
                    $previewData[$field->field_name] =
                        $this->inputs[$field->id] ?? $field->default_value;
                }
            }
        }

        return view('livewire.customer.create-ad', [
            'previewData' => $previewData,
        ])->layout('layouts.app');
    }
}
