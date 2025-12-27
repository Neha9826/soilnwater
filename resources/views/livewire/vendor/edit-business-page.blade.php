<div class="max-w-5xl mx-auto py-10 px-4">
    
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    
    <style>
        .trix-button-group--file-tools { display: none !important; }
        .trix-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; }
        .trix-content ol { list-style-type: decimal !important; padding-left: 1.5rem !important; }
        .trix-content blockquote { border-left: 4px solid #ccc; padding-left: 1rem; }
    </style>

    <div class="flex justify-between items-end mb-8 border-b pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Website Builder</h1>
            <p class="text-gray-500 mt-1">Design your public page block by block.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ url('/v/'.Auth::user()->store_slug) }}" target="_blank" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg transition">
                <i class="fas fa-eye"></i> Preview Page
            </a>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline py-2 px-2">Back to Dashboard</a>
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-paint-brush text-blue-500"></i> Branding & Header
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-1 text-center">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Company Logo</label>
                    <div class="relative w-32 h-32 mx-auto bg-gray-100 rounded-full overflow-hidden border-4 border-white shadow-lg group">
                        @if ($store_logo) 
                            <img src="{{ $store_logo->temporaryUrl() }}" class="object-cover w-full h-full">
                        @elseif($existing_logo)
                            <img src="{{ asset('storage/'.$existing_logo) }}" class="object-cover w-full h-full">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-300">
                                <i class="fas fa-camera text-3xl"></i>
                            </div>
                        @endif
                        
                        <label for="logo-upload" class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition">
                            <span class="text-xs font-bold">Change</span>
                        </label>
                        <input wire:model="store_logo" type="file" id="logo-upload" class="hidden">
                    </div>
                </div>

                <div class="col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Page Title (Hero Text)</label>
                        <input wire:model="header_title" type="text" placeholder="e.g. Building Tomorrow, Today" class="w-full mt-1 border-gray-300 rounded-lg p-2.5 border focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Subtitle</label>
                        <input wire:model="header_subtitle" type="text" placeholder="e.g. Premium Construction Materials in Dehradun" class="w-full mt-1 border-gray-300 rounded-lg p-2.5 border">
                    </div>
                     <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Banner Images (Slideshow)</label>
                        <input wire:model="header_images" type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        
                        <div class="flex gap-2 mt-2">
                             @foreach($existing_headers as $index => $img)
                                <div class="relative h-12 w-16 group">
                                    <img src="{{ asset('storage/'.$img) }}" class="h-full w-full object-cover rounded">
                                    <button type="button" wire:click="removeHeaderImage({{ $index }})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow opacity-0 group-hover:opacity-100 transition">&times;</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-layer-group text-purple-500"></i> Content Sections
                </h2>
                <button type="button" wire:click="addSection" class="text-sm bg-purple-50 text-purple-700 font-bold py-2 px-4 rounded-lg hover:bg-purple-100 transition">
                    + Add New Section
                </button>
            </div>

            <div class="space-y-8">
                @foreach($sections as $index => $section)
                    <div wire:key="section-{{ $index }}" class="bg-gray-50 p-6 rounded-xl border border-gray-200 relative group transition hover:shadow-md">
                        
                        <button type="button" wire:click="removeSection({{ $index }})" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition z-10 bg-white p-2 rounded-full shadow-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div class="col-span-1">
                                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Section Image</label>
                                
                                <div class="relative h-40 bg-white border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center overflow-hidden">
                                    @if(isset($sections[$index]['new_image']) && $sections[$index]['new_image'])
                                        <img src="{{ $sections[$index]['new_image']->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                    @elseif(isset($section['image_path']) && $section['image_path'])
                                        <img src="{{ asset('storage/'.$section['image_path']) }}" class="absolute inset-0 w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-image text-3xl text-gray-300 mb-2"></i>
                                        <span class="text-xs text-gray-400">Upload Image</span>
                                    @endif
                                    
                                    <input type="file" wire:model="sections.{{ $index }}.new_image" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>

                            <div class="col-span-2 space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Section Title</label>
                                    <input wire:model.defer="sections.{{ $index }}.title" type="text" class="w-full mt-1 bg-white border-gray-300 rounded-lg p-2 border focus:ring-purple-500" placeholder="e.g. Our History">
                                </div>
                                
                                <div wire:ignore>
                                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Description Content</label>
                                    <trix-editor input="desc-{{ $index }}" class="bg-white border-gray-300 rounded-lg min-h-[150px] formatted-content"></trix-editor>
                                    <input id="desc-{{ $index }}" type="hidden" value="{{ $section['description'] }}" onchange="@this.set('sections.{{ $index }}.description', this.value)">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-address-card text-green-500"></i> Contact Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Company / Store Name</label>
                    <input wire:model="store_name" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Full Address</label>
                    <input wire:model="address" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Facebook Page Link</label>
                    <input wire:model="facebook" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Instagram Profile Link</label>
                    <input wire:model="instagram" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-blue-600 text-white font-bold py-4 px-10 rounded-xl hover:bg-blue-700 shadow-lg transition transform hover:-translate-y-1">
                Save & Publish Website
            </button>
        </div>

    </form>
</div>