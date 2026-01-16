<div>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>.trix-button-group--file-tools { display: none !important; }</style>

    <div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
        <x-vendor-sidebar />

        <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
            <div class="max-w-6xl mx-auto pb-20">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900">Manage Website</h1>
                        <p class="text-gray-500 mt-1">Customize your public landing page.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('public.store', $slug) }}" target="_blank" class="bg-white text-gray-700 font-bold py-2.5 px-6 rounded-xl border border-gray-300 shadow-sm hover:bg-gray-50 flex items-center gap-2">
                            <i class="fas fa-eye"></i> Live Preview
                        </a>
                        <button wire:click="save" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                            <span wire:loading.remove><i class="fas fa-save"></i> Save Changes</span>
                            <span wire:loading><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                        </button>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                        <strong>Success!</strong> {{ session('message') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-images text-blue-500"></i> Hero Banner</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Main Heading</label>
                                        <input wire:model.blur="header_title" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Sub Heading</label>
                                        <input wire:model.blur="header_subtitle" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Banner Images (Slider)</label>
                                    @if(!empty($header_images))
                                        <div class="grid grid-cols-3 gap-4 mb-4">
                                            @foreach($header_images as $index => $img)
                                                <div class="relative group aspect-video bg-gray-100 rounded-lg overflow-hidden border">
                                                    <img src="{{ asset('storage/'.$img) }}" class="w-full h-full object-cover">
                                                    <button wire:click="removeHeaderImage({{ $index }})" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded shadow hover:bg-red-600"><i class="fas fa-trash text-xs"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative">
                                        <input wire:model="new_header_images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">Click to upload new slides</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="font-bold text-gray-800 text-lg">Custom Page Sections</h3>
                                <button wire:click="addSection" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-bold hover:bg-blue-100 transition"><i class="fas fa-plus"></i> Add Section</button>
                            </div>

                            @foreach($page_sections as $index => $section)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative" wire:key="section-{{ $section['id'] ?? $index }}">
                                    <button wire:click="removeSection({{ $index }})" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition z-10"><i class="fas fa-trash"></i></button>

                                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                                        
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Section Image</label>
                                            
                                            <div class="h-40 w-full bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 relative overflow-hidden hover:bg-gray-100 transition"
                                                wire:key="img-container-{{ $index }}">
                                                
                                                @if(isset($page_sections[$index]['new_image']) && $page_sections[$index]['new_image'])
                                                    <img src="{{ $page_sections[$index]['new_image']->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                                
                                                @elseif(!empty($page_sections[$index]['image_path']))
                                                    <img src="{{ asset('storage/'.$page_sections[$index]['image_path']) }}?v={{ time() }}" 
                                                        class="absolute inset-0 w-full h-full object-cover">
                                                
                                                @else
                                                    <div class="flex flex-col items-center pointer-events-none">
                                                        <i class="fas fa-cloud-upload-alt text-3xl mb-1 text-gray-300"></i>
                                                        <span class="text-xs font-bold text-gray-400">Click to Upload</span>
                                                    </div>
                                                @endif

                                                <input type="file" wire:model.live="page_sections.{{ $index }}.new_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                            
                                            <div wire:loading wire:target="page_sections.{{ $index }}.new_image" class="text-xs text-blue-500 mt-1 font-bold text-center">
                                                <i class="fas fa-spinner fa-spin"></i> Uploading...
                                            </div>
                                        </div>

                                        <div class="md:col-span-2 space-y-4">
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Section Title</label>
                                                <input wire:model.blur="page_sections.{{ $index }}.title" type="text" class="w-full border-gray-300 rounded-lg p-2 border focus:border-blue-500">
                                            </div>
                                            
                                            <div wire:ignore>
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Content</label>
                                                <input id="trix-{{ $index }}" type="hidden" name="content-{{ $index }}" value="{{ $section['description'] }}">
                                                
                                                <trix-editor input="trix-{{ $index }}" 
                                                             class="trix-content min-h-[150px] border-gray-300 rounded-lg"
                                                             x-data 
                                                             x-on:trix-blur="@this.set('page_sections.{{ $index }}.description', $event.target.value)"></trix-editor>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Business Info</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Display Name</label>
                                <input wire:model.blur="name" type="text" class="w-full border-gray-300 rounded-lg p-2 border-2">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Logo</label>
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 bg-gray-100 rounded-lg border overflow-hidden">
                                        @if ($newLogo)
                                            <img src="{{ $newLogo->temporaryUrl() }}" class="h-full w-full object-cover">
                                        @elseif($logo)
                                            <img src="{{ asset('storage/'.$logo) }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <input wire:model="newLogo" type="file" class="text-sm text-gray-500 w-full">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">URL Slug</label>
                                <div class="flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-xs">/store/</span>
                                    <input wire:model.blur="slug" type="text" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 border-2 text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Contact Details</h3>
                            <div class="space-y-3">
                                <input wire:model.blur="phone" type="text" placeholder="Phone" class="w-full border-gray-300 rounded-lg p-2 border">
                                <input wire:model.blur="email" type="email" placeholder="Email" class="w-full border-gray-300 rounded-lg p-2 border">
                                <input wire:model.blur="city" type="text" placeholder="City" class="w-full border-gray-300 rounded-lg p-2 border">
                                <textarea wire:model.blur="address" placeholder="Address" rows="2" class="w-full border-gray-300 rounded-lg p-2 border"></textarea>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Social Links</h3>
                            <div class="space-y-3">
                                <input wire:model.blur="facebook" type="text" placeholder="Facebook URL" class="w-full border-gray-300 rounded-lg p-2 border text-sm">
                                <input wire:model.blur="instagram" type="text" placeholder="Instagram URL" class="w-full border-gray-300 rounded-lg p-2 border text-sm">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>