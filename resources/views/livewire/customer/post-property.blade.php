{{-- WRAPPER: Centers content and handles scrolling --}}
<div class="w-full flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="w-full max-w-4xl">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">Post Your Property</h1>
            <p class="mt-2 text-gray-600">Fill in the details to list your property for sale or rent.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full">
            <form wire:submit.prevent="save" class="p-8 space-y-8">

                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <span class="block text-sm font-bold text-gray-700 mb-2">You are listing as:</span>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input wire:model="poster_type" type="radio" value="Owner" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700 font-medium">Owner</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input wire:model="poster_type" type="radio" value="Broker" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700 font-medium">Broker</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center h-5">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input wire:model="is_govt_registered" type="checkbox" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="font-bold text-gray-700 text-sm">Govt. Registered Property</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Property Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Ad Title *</label>
                            <input wire:model="title" type="text" placeholder="e.g. 3BHK Flat for Rent in Rajpur Road" class="w-full border-gray-300 rounded-lg p-3 border-2 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹) *</label>
                            <input wire:model="price" type="number" placeholder="e.g. 15000" class="w-full border-gray-300 rounded-lg p-3 border-2">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">I want to *</label>
                            <select wire:model="listing_type" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="">Select Option</option>
                                <option value="Sale">Sell it</option>
                                <option value="Rent">Rent it out</option>
                                <option value="PG">List as PG</option>
                                <option value="Share a Space">Share Space</option>
                            </select>
                            @error('listing_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Property Type *</label>
                            <select wire:model="type" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="">Select Category</option>
                                <option value="Apartment">Apartment / Flat</option>
                                <option value="Villa">Villa / Independent House</option>
                                <option value="Plot">Plot / Land</option>
                                <option value="Commercial">Commercial / Office Space</option>
                                <option value="Penthouse">Penthouse</option>
                                <option value="Studio">Studio Apartment</option>
                                <option value="Farmhouse">Farmhouse</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" placeholder="Describe your property..." class="w-full border-gray-300 rounded-lg p-3 border-2"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Location</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Address *</label>
                            <input wire:model="address" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">City *</label>
                            <input wire:model="city" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">State *</label>
                            <input wire:model="state" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                        
                        <div class="col-span-2 mt-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Google Map Link (Optional)</label>
                            <input wire:model="google_map_link" type="text" placeholder="Paste Share Link from Maps" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Amenities</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                    @error('new_amenity_name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Photos</h3>
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

                {{-- NEW VIDEO SECTION --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Video</h3>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                        <input wire:model="video" type="file" accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center">
                            <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm font-bold text-gray-600">Click to upload a video tour</p>
                            <p class="text-xs text-gray-500 mt-1">Max 50MB (MP4, MOV)</p>
                        </div>
                    </div>
                    @error('video') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    @if($video)
                        <div class="mt-4">
                            <p class="text-xs text-green-600 font-bold mb-1">Video Selected:</p>
                            <video src="{{ $video->temporaryUrl() }}" controls class="w-full max-w-xs h-32 rounded-lg border bg-black"></video>
                        </div>
                    @endif
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 shadow-lg text-lg flex justify-center items-center gap-2 transition transform hover:-translate-y-1">
                        <span wire:loading.remove>Post Property Ad</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>