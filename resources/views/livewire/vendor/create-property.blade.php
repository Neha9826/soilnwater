<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between items-center">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="max-w-5xl mx-auto pb-20">
            
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <a href="{{ route('vendor.properties') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 mb-2 inline-block"><i class="fas fa-arrow-left"></i> Back to List</a>
                    <h1 class="text-3xl font-extrabold text-gray-900">List New Property</h1>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Basic Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Property Title *</label>
                            <input wire:model="title" type="text" placeholder="e.g. 3BHK Luxury Apartment in Rajpur Road" class="w-full border-gray-300 rounded-lg p-2.5 border-2 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹) *</label>
                            <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border-2">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Property Type *</label>
                            <select wire:model="type" class="w-full border-gray-300 rounded-lg p-2.5 border-2 bg-white">
                                <option value="">Select Type</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Villa">Villa</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Plot">Plot</option>
                                <option value="Share a Space">Share a Space / Co-living</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-2.5 border-2" placeholder="Describe the property..."></textarea>
                        </div>
                    </div>
                </div>

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

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Photos & Videos</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Property Images</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:bg-gray-50 bg-gray-50 relative">
                                <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                                <p class="font-bold text-gray-500 text-sm">Click to Upload Photos</p>
                                <p class="text-xs text-gray-400 mt-1">Max 2MB per image</p>
                            </div>
                            @if($images)
                                <div class="flex gap-2 mt-4 overflow-x-auto pb-2">
                                    @foreach($images as $img)
                                        <img src="{{ $img->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg border flex-shrink-0">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Property Videos</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:bg-gray-50 bg-gray-50 relative">
                                <input wire:model="videos" type="file" multiple accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i class="fas fa-video text-3xl text-gray-400 mb-2"></i>
                                <p class="font-bold text-gray-500 text-sm">Click to Upload Videos</p>
                                <p class="text-xs text-gray-400 mt-1">MP4, AVI (Max 20MB)</p>
                            </div>
                            <div wire:loading wire:target="videos" class="text-xs text-blue-500 mt-2 font-bold"><i class="fas fa-spinner fa-spin"></i> Uploading Videos...</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Floor Plans</h3>
                        <button type="button" wire:click="addFloor" class="text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-lg font-bold hover:bg-blue-100 transition flex items-center gap-2">
                            <i class="fas fa-plus"></i> Add Floor
                        </button>
                    </div>

                    <div class="space-y-6">
                        @foreach($floors as $index => $floor)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 relative group" wire:key="floor-{{ $floor['id'] }}">
                                <button type="button" wire:click="removeFloor({{ $index }})" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 bg-white rounded-full p-1 shadow-sm transition">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-1">
                                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Name</label>
                                        <input wire:model="floors.{{ $index }}.floor_name" placeholder="e.g. Ground Floor" type="text" class="w-full border-gray-300 rounded-lg p-2 text-sm">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Area (sqft)</label>
                                        <input wire:model="floors.{{ $index }}.area_sqft" type="text" class="w-full border-gray-300 rounded-lg p-2 text-sm">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Rooms</label>
                                        <input wire:model="floors.{{ $index }}.rooms" type="number" class="w-full border-gray-300 rounded-lg p-2 text-sm">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Plan Image</label>
                                        <input wire:model="floors.{{ $index }}.new_image" type="file" class="text-xs w-full text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                    <div class="md:col-span-4">
                                        <input wire:model="floors.{{ $index }}.description" placeholder="Short description of this floor..." type="text" class="w-full border-gray-300 rounded-lg p-2 text-sm">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

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
                        <input wire:model="new_amenity_name" type="text" placeholder="Can't find it? Add custom amenity..." class="border-gray-300 rounded-lg p-2 text-sm w-full md:w-64">
                        <button type="button" wire:click="createNewAmenity" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-900 transition whitespace-nowrap">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Documentation</h3>
                    <label class="block font-bold text-sm text-gray-700 mb-2">Upload Legal Docs / Brochures</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition relative bg-gray-50">
                        <input wire:model="documents" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class="fas fa-file-pdf text-3xl text-red-400 mb-2"></i>
                        <p class="text-sm text-gray-600 font-medium">Drag & Drop PDF/DOCX here</p>
                    </div>
                    @if($documents)
                        <ul class="mt-4 space-y-2 bg-white rounded-lg border p-4">
                            @foreach($documents as $doc)
                                <li class="text-sm text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i> {{ $doc->getClientOriginalName() }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex justify-end pt-4 pb-12">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 shadow-lg flex items-center gap-2 transform transition hover:-translate-y-1">
                        <span wire:loading.remove>Publish Property</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>