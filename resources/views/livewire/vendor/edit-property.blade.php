<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="max-w-5xl mx-auto pb-20">
            
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <a href="{{ route('vendor.properties') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 mb-2 inline-block"><i class="fas fa-arrow-left"></i> Back to List</a>
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Project</h1>
                    <p class="text-sm text-gray-500">Update your portfolio details.</p>
                </div>
            </div>

            <form wire:submit.prevent="update" class="space-y-8">
                
                {{-- 1. BASIC DETAILS --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Basic Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Project / Property Title *</label>
                            <input wire:model="title" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Property Category *</label>
                            <select wire:model="type" class="w-full border-gray-300 rounded-lg p-2.5 border-2 bg-white focus:ring-blue-500">
                                <option value="">Select Category</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Villa">Villa / Independent House</option>
                                <option value="Commercial">Commercial / Office</option>
                                <option value="Plot">Plot / Land</option>
                                <option value="Penthouse">Penthouse</option>
                                <option value="Studio">Studio Apartment</option>
                            </select>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-2.5 border-2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. LOCATION --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Location & Maps</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Address *</label>
                            <input wire:model="address" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">City</label>
                            <input wire:model="city" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">State</label>
                            <input wire:model="state" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                        </div>
                        
                        <div class="col-span-2 border-t mt-2 pt-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1"><i class="fas fa-map-marker-alt text-red-500"></i> Google Map Link (Share Link)</label>
                            <input wire:model="google_map_link" type="url" placeholder="https://maps.app.goo.gl/..." class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                            <p class="text-xs text-gray-400 mt-1">Paste the "Share" link from Google Maps here.</p>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1"><i class="fas fa-code text-blue-500"></i> Google Map Embed Code (HTML)</label>
                            <input wire:model="google_embed_link" type="text" placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>' class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                            <p class="text-xs text-gray-400 mt-1">Paste the full <code>&lt;iframe&gt;</code> code from Google Maps "Share -> Embed a map".</p>
                        </div>
                    </div>
                </div>

                {{-- 3. PHOTOS & VIDEOS --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Photos & Videos</h3>
                    
                    {{-- Images --}}
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Property Images</label>
                        
                        {{-- Existing Images List --}}
                        @if(count($existing_images) > 0)
                            <div class="flex gap-4 overflow-x-auto pb-4 mb-4">
                                @foreach($existing_images as $key => $img)
                                    <div class="relative group flex-shrink-0 w-24 h-24">
                                        <img src="{{ asset('storage/'.$img) }}" class="w-full h-full object-cover rounded-lg border shadow-sm">
                                        <button type="button" wire:click="removeImage({{ $key }})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center text-xs shadow-md hover:bg-red-600 transition z-10 border-2 border-white">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:bg-gray-50 bg-gray-50 relative">
                            <input wire:model="new_images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                            <p class="font-bold text-gray-500 text-sm">Click to Add New Photos</p>
                            <p class="text-xs text-gray-400 mt-1">Max 2MB per image</p>
                        </div>
                        
                        {{-- New Upload Preview --}}
                        @if($new_images)
                            <div class="flex gap-2 mt-2">
                                @foreach($new_images as $img)
                                    <img src="{{ $img->temporaryUrl() }}" class="h-16 w-16 object-cover rounded border">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    {{-- Videos --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Property Videos</label>
                        
                        {{-- Existing Videos List --}}
                        @if(count($existing_videos) > 0)
                            <div class="space-y-2 mb-4">
                                @foreach($existing_videos as $key => $vid)
                                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded border border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-video text-blue-500"></i>
                                            <span class="text-xs text-gray-600 truncate w-48">Video {{ $key + 1 }}</span>
                                        </div>
                                        <button type="button" wire:click="removeVideo({{ $key }})" class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:bg-gray-50 bg-gray-50 relative">
                            <input wire:model="new_videos" type="file" multiple accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <i class="fas fa-video text-3xl text-gray-400 mb-2"></i>
                            <p class="font-bold text-gray-500 text-sm">Click to Add New Videos</p>
                            <p class="text-xs text-gray-400 mt-1">MP4, AVI (Max 20MB)</p>
                        </div>
                        <div wire:loading wire:target="new_videos" class="text-xs text-blue-500 mt-2 font-bold"><i class="fas fa-spinner fa-spin"></i> Uploading Videos...</div>
                    </div>
                </div>

                {{-- 4. FLOOR PLANS (Using the Partial we created) --}}
                @include('livewire.vendor.partials.floor-plans')

                {{-- 5. AMENITIES --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        @foreach($available_amenities as $amenity)
                            <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition">
                                <input wire:model="selected_amenities" value="{{ $amenity->id }}" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5 border-gray-300">
                                <span class="text-gray-700 text-sm font-medium">{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 border-t pt-4 bg-gray-50 p-3 rounded-lg">
                        <input wire:model="new_amenity_name" type="text" placeholder="Add custom amenity..." class="border-gray-300 rounded-lg p-2 text-sm w-full md:w-64">
                        <button type="button" wire:click="createNewAmenity" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-900 transition">Add</button>
                    </div>
                </div>

                {{-- 6. DOCUMENTATION --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Documentation</h3>
                    <label class="block font-bold text-sm text-gray-700 mb-2">Upload Legal Docs / Brochures</label>
                    
                    {{-- Existing Docs --}}
                    @if(count($existing_documents) > 0)
                        <div class="space-y-2 mb-4">
                            @foreach($existing_documents as $key => $doc)
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded border border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <span class="text-xs text-gray-600 truncate w-48">{{ basename($doc) }}</span>
                                    </div>
                                    <button type="button" wire:click="removeDocument({{ $key }})" class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50">
                                        <i class="fas fa-trash-alt mr-1"></i> Remove
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition relative bg-gray-50">
                        <input wire:model="new_documents" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class="fas fa-file-pdf text-3xl text-red-400 mb-2"></i>
                        <p class="text-sm text-gray-600 font-medium">Drag & Drop PDF/DOCX here</p>
                    </div>
                    
                    {{-- New Uploads List --}}
                    @if($new_documents)
                        <ul class="mt-4 space-y-2 bg-white rounded-lg border p-4">
                            @foreach($new_documents as $doc)
                                <li class="text-sm text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i> {{ $doc->getClientOriginalName() }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex justify-end pt-4 pb-12">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 shadow-lg flex items-center gap-2 transform transition hover:-translate-y-1">
                        <span wire:loading.remove>Update Project</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>