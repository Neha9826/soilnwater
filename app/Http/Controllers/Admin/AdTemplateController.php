<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdTier;
use App\Models\AdTemplate;
use App\Models\AdTemplateField;
use Illuminate\Http\Request;

class AdTemplateController extends Controller
{
    // List all Master Templates
    public function index() {
        $templates = AdTemplate::with('tier')->get();
        return view('admin.ads.templates.index', compact('templates'));
    }

    // Form to create a New Master Template (Like Master Itinerary)
    public function create() {
        $tiers = AdTier::all(); // Admin chooses the shape/price here
        return view('admin.ads.templates.create', compact('tiers'));
    }

    // Store the Master Template and its Dynamic Fields
    public function store(Request $request) {
        $template = AdTemplate::create([
            'ad_tier_id' => $request->tier_id,
            'name' => $request->name,
            'blade_path' => 'ads.templates.' . $request->layout_name,
            'is_active' => true
        ]);

        // Just like adding 'Days' to an itinerary, we add 'Fields' to a template
        foreach ($request->fields as $field) {
            AdTemplateField::create([
                'ad_template_id' => $template->id,
                'field_name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
                'is_required' => isset($field['required']),
            ]);
        }

        return redirect()->route('admin.templates.index')->with('success', 'Master Template Created');
    }
}