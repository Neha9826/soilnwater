<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8"> {{-- Root Tag --}}
    <div class="max-w-7xl mx-auto">
        
        {{-- Progress Navigation --}}
        <nav class="flex items-center justify-center mb-10 space-x-4 text-sm font-medium">
            <span class="{{ $step == 1 ? 'text-orange-600 font-bold' : 'text-gray-400' }}">1. Select Size</span>
            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            <span class="{{ $step == 2 ? 'text-orange-600 font-bold' : 'text-gray-400' }}">2. Choose Design</span>
            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            <span class="{{ $step == 3 ? 'text-orange-600 font-bold' : 'text-gray-400' }}">3. Customize & Save</span>
        </nav>

        @if($step == 1)
            {{-- STEP 1: SHAPE & PRICE SELECTOR --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Choose Your Ad Size</h2>
                <p class="mt-4 text-lg text-gray-600">Select the dimensions and price point for your campaign.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($tiers as $tier)
                    <div wire:key="tier-{{ $tier->id }}" wire:click="selectTier({{ $tier->id }})" 
                         class="group cursor-pointer bg-white border-2 border-gray-100 hover:border-orange-500 rounded-2xl shadow-sm hover:shadow-xl transition-all p-8 text-center flex flex-col items-center">
                        
                        <div class="mb-6 flex items-center justify-center bg-gray-50 rounded-xl p-4 w-full h-40">
                            @if(Str::contains(strtolower($tier->name), 'square'))
                                <div class="w-24 h-24 border-4 border-orange-500 rounded shadow-sm bg-white"></div>
                            @elseif(Str::contains(strtolower($tier->name), 'vertical'))
                                <div class="w-20 h-32 border-4 border-orange-500 rounded shadow-sm bg-white"></div>
                            @elseif(Str::contains(strtolower($tier->name), 'horizontal'))
                                <div class="w-32 h-20 border-4 border-orange-500 rounded shadow-sm bg-white"></div>
                            @else
                                <div class="w-24 h-24 border-4 border-dashed border-gray-300 rounded bg-white"></div>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 uppercase tracking-wide">{{ $tier->name }}</h3>
                        <div class="mt-2 text-4xl font-black text-gray-900">₹{{ $tier->price }}</div>
                        
                        <button class="mt-6 w-full bg-gray-900 text-white py-3 rounded-xl font-bold group-hover:bg-orange-600 transition-colors">
                            Select This Shape
                        </button>
                    </div>
                @endforeach
            </div>

        {{-- STEP 2: TEMPLATE SELECTOR --}}
        @elseif($step == 2)
            <div class="mb-10 flex items-center justify-between">
                <button wire:click="$set('step', 1)" class="flex items-center text-sm text-orange-600 font-bold hover:underline bg-white px-4 py-2 rounded-lg shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Sizes
                </button>
            </div>

            <h2 class="text-2xl font-black text-gray-900 mb-8 text-center uppercase tracking-widest">Select Your Design</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @foreach($templates as $template)
                    <div wire:key="select-{{ $template->id }}" wire:click="selectTemplate({{ $template->id }})" 
                         class="group cursor-pointer bg-white rounded-2xl border-2 border-gray-100 hover:border-orange-500 p-6 shadow-sm hover:shadow-lg transition-all flex items-center justify-between">
                        <div>
                            <span class="block text-lg font-bold text-gray-800">{{ $template->name }}</span>
                            <span class="text-[10px] text-orange-500 font-black uppercase tracking-widest">Click to Edit</span>
                        </div>
                        <div class="bg-orange-50 p-3 rounded-full group-hover:bg-orange-600 transition-colors">
                            <i class="fas fa-magic text-orange-600 group-hover:text-white"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mt-12">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-eye mr-3 text-orange-500"></i> Design Reference Gallery
                    </h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($templates as $template)
                        <div class="space-y-3 group">
                            <div class="flex items-center gap-2 border-l-4 border-orange-500 pl-3">
                                <span class="text-[11px] font-bold text-gray-900 uppercase tracking-tight truncate">{{ $template->name }}</span>
                            </div>

                            <div class="relative aspect-square rounded-xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 group-hover:shadow-2xl transition-all duration-300">
                                @php
                                    $imageName = match(trim($template->name)) {
                                        'Beauty Salon Square small' => 'beauty_square.png',
                                        'Grand Opening'             => 'grand_square.png',
                                        'Modern Furniture'          => 'modern_square.png',
                                        default                     => 'placeholder.png'
                                    };
                                @endphp
                                <img src="{{ asset('images/samples/' . $imageName) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                     onerror="this.src='{{ asset('images/placeholder-ad.jpg') }}'">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif($step == 3 && $selectedTemplate)
            {{-- STEP 3: THE EDITOR & LIVE PREVIEW --}}
            <div class="mb-6 flex items-center justify-between">
                <button wire:click="$set('step', 2)" class="flex items-center text-sm text-orange-600 font-bold hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Templates
                </button>
                <button wire:click="save" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-black shadow-lg transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>SUBMIT FOR APPROVAL</span>
                </button>
            </div>

            <div class="flex flex-col lg:flex-row gap-10 items-start">
                {{-- LEFT SIDE: CUSTOMIZATION FORM --}}
                <div class="w-full lg:w-1/3 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">Customize Content</h3>
                    <div class="space-y-6">
                        @foreach($selectedTemplate->fields as $field)
                            <div wire:key="field-{{ $field->id }}" class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">{{ $field->label }}</label>
                                @if($field->type === 'color')
                                    <input type="color" wire:model.live="inputs.{{ $field->id }}" class="h-10 w-20 cursor-pointer rounded border-gray-200">
                                @elseif($field->type === 'textarea')
                                    <textarea wire:model.live="inputs.{{ $field->id }}" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 text-sm"></textarea>
                                @elseif($field->type === 'image')
                                    <input type="file" wire:model="image_uploads.{{ $field->id }}" class="text-xs">
                                    <div wire:loading wire:target="image_uploads.{{ $field->id }}" class="text-xs text-orange-500 font-bold mt-1">Uploading...</div>
                                @else
                                    <input type="text" wire:model.live="inputs.{{ $field->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 text-sm">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RIGHT SIDE: LIVE PREVIEW CANVAS --}}
                {{-- RIGHT SIDE PREVIEW CANVAS --}}
<div class="w-full lg:w-2/3 flex justify-center items-start bg-gray-100 p-4 sm:p-8 rounded-3xl min-h-[500px] border-2 border-dashed border-gray-200 overflow-hidden">
    @php
        // 1. Get the real generation dimensions
        $baseUnit = 400; 
        $actualW = (int)($selectedTemplate->tier->grid_width * $baseUnit);
        $actualH = (int)($selectedTemplate->tier->grid_height * $baseUnit);
        
        // 2. Calculate the scale factor to prevent overflowing
        // We want the preview to be roughly 500px-600px wide maximum in the UI
        $maxUiWidth = 600; 
        $scaleFactor = $actualW > $maxUiWidth ? ($maxUiWidth / $actualW) : 1;

        // 3. Map Data for the include
        $previewData = [];
        foreach($selectedTemplate->fields as $f) {
            if ($f->type === 'image' && isset($image_uploads[$f->id])) {
                $previewData[$f->field_name] = $image_uploads[$f->id]->temporaryUrl();
            } else {
                $previewData[$f->field_name] = $inputs[$f->id] ?? $f->default_value;
            }
        }
    @endphp

    {{-- The 'Container' stays the REAL size, but 'transform' shrinks it for the eye --}}
    <div style="width: {{ $actualW }}px; height: {{ $actualH }}px; transform: scale({{ $scaleFactor }}); transform-origin: top center; transition: all 0.3s ease-in-out;" 
         class="shadow-2xl bg-white flex-shrink-0">
        @include($selectedTemplate->blade_path, ['data' => $previewData])
    </div>
</div>
            </div>
        @endif
    </div>
</div>