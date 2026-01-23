<div class="w-full flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">Promote Your Project</h1>
            <p class="mt-2 text-gray-600">Post upcoming lands, societies, or pre-launch projects.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full">
            <form wire:submit.prevent="save" class="p-8 space-y-8">

                {{-- 1. BASIC DETAILS --}}
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-blue-200">Project Info</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Project Title *</label>
                            <input wire:model="title" type="text" placeholder="e.g. Green Valley Phase 1" class="w-full border-gray-300 rounded-lg p-3 border-2 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Starting Price (₹) *</label>
                            <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Project Status *</label>
                            <select wire:model="project_status" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="Upcoming">Upcoming / Pre-Launch</option>
                                <option value="Under Construction">Under Construction</option>
                                <option value="Ready to Move">Ready to Move</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Project Type *</label>
                            <select wire:model="type" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="">Select Type</option>
                                <option value="Land / Plot">Land / Plotted Development</option>
                                <option value="Apartment Society">Apartment Society</option>
                                <option value="Villa Community">Villa Community</option>
                                <option value="Commercial Complex">Commercial Complex</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-3 border-2" placeholder="Describe the project..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. LOCATION & MAPS --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Location & Maps</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Address</label>
                            <input wire:model="address" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">City *</label>
                            <input wire:model="city" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">State</label>
                            <input wire:model="state" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        
                        {{-- Google Map Link --}}
                        <div class="col-span-2 mt-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Google Map Link (Optional)</label>
                            <input wire:model="google_map_link" type="text" placeholder="Paste Share Link from Maps" class="w-full border-gray-300 rounded-lg p-3 border-2">
                            <p class="text-xs text-gray-400 mt-1">Paste the "Share" link from Google Maps here.</p>
                        </div>

                        {{-- Google Embed Link --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Google Map Embed Code (HTML)</label>
                            <input wire:model="google_embed_link" type="text" placeholder='<iframe src="..."></iframe>' class="w-full border-gray-300 rounded-lg p-3 border-2">
                            <p class="text-xs text-gray-400 mt-1">Paste the full <code>&lt;iframe&gt;</code> code from Google Maps "Share -> Embed a map".</p>
                        </div>
                    </div>
                </div>

                {{-- 3. AMENITIES --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Project Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        @foreach($available_amenities as $amenity)
                            <label class="flex items-center space-x-2 cursor-pointer bg-gray-50 p-2 rounded hover:bg-gray-100 transition">
                                <input wire:model="selected_amenities" value="{{ $amenity->id }}" type="checkbox" class="rounded text-blue-600 h-5 w-5 border-gray-300">
                                <span class="text-gray-700 text-sm">{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <input wire:model="new_amenity_name" type="text" placeholder="Can't find it? Add custom amenity..." class="flex-1 border-gray-300 rounded-lg p-2.5 text-sm focus:border-blue-500">
                        <button type="button" wire:click="addCustomAmenity" class="bg-gray-800 text-white px-4 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-900 transition">
                            Add <i class="fas fa-plus ml-1"></i>
                        </button>
                    </div>
                </div>

                {{-- 4. MEDIA --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Media</h3>
                    
                    {{-- Images Dropzone --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Project Images</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                            <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center">
                                <i class="fas fa-images text-4xl text-gray-400 mb-3"></i>
                                <p class="text-sm font-bold text-gray-600">Click to upload photos</p>
                                <p class="text-xs text-gray-500 mt-1">Max 5MB per image</p>
                            </div>
                        </div>
                        @if($images)
                            <div class="flex gap-4 mt-4 overflow-x-auto pb-2">
                                @foreach($images as $img)
                                    <img src="{{ $img->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg shadow border">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Videos Dropzone --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Promo Video</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                            <input wire:model="videos" type="file" multiple accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center">
                                <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                                <p class="text-sm font-bold text-gray-600">Click to upload video</p>
                                <p class="text-xs text-gray-500 mt-1">Max 50MB (MP4, MOV)</p>
                            </div>
                        </div>
                        <div wire:loading wire:target="videos" class="text-xs text-blue-500 mt-2 font-bold">
                            <i class="fas fa-spinner fa-spin"></i> Uploading...
                        </div>
                    </div>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 shadow-lg text-lg flex justify-center items-center gap-2 transition transform hover:-translate-y-1">
                        <span wire:loading.remove>Post Project</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>