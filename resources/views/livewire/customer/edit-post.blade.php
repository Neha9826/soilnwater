<div class="w-full flex flex-col items-center justify-start min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Edit Property</h1>
                <p class="mt-2 text-gray-600">Update your ad details.</p>
            </div>
            <a href="{{ route('customer.my-posts') }}" class="text-gray-500 hover:text-gray-800 font-bold flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <i class="fas fa-times"></i> Close
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full">
            <form wire:submit.prevent="update" class="p-8 space-y-8">

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
                            <input wire:model="title" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹) *</label>
                            <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">I want to *</label>
                            <select wire:model="listing_type" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="Sale">Sell it</option>
                                <option value="Rent">Rent it out</option>
                                <option value="PG">List as PG</option>
                                <option value="Share a Space">Share Space</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Property Type *</label>
                            <select wire:model="type" class="w-full border-gray-300 rounded-lg p-3 border-2 bg-white">
                                <option value="Apartment">Apartment</option>
                                <option value="Villa">Villa</option>
                                <option value="Plot">Plot</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Penthouse">Penthouse</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-3 border-2"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Location</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Address *</label>
                            <input wire:model="address" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
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
                            <input wire:model="google_map_link" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        @foreach($available_amenities as $amenity)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input wire:model="selected_amenities" value="{{ $amenity->id }}" type="checkbox" class="rounded text-blue-600 h-5 w-5 border-gray-300">
                                <span class="text-gray-700 text-sm">{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <input wire:model="new_amenity_name" type="text" placeholder="Add custom amenity..." class="flex-1 border-gray-300 rounded-lg p-2.5 text-sm">
                        <button type="button" wire:click="addCustomAmenity" class="bg-gray-800 text-white px-4 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-900">Add +</button>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Photos</h3>
                    
                    @if(!empty($existing_images))
                        <div class="grid grid-cols-3 md:grid-cols-5 gap-4 mb-4">
                            @foreach($existing_images as $index => $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/'.$img) }}" class="h-24 w-full object-cover rounded-lg border">
                                    <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-1 right-1 bg-red-500 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs shadow hover:bg-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                        <input wire:model="new_images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-sm font-bold text-gray-600">Click to add new photos</p>
                    </div>
                    
                    @if($new_images)
                        <div class="flex gap-4 mt-4 overflow-x-auto pb-2">
                            @foreach($new_images as $img)
                                <img src="{{ $img->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg shadow border">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- NEW VIDEO SECTION --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Video</h3>
                    
                    {{-- 1. Display Existing Video --}}
                    @if($existing_video && !$new_video)
                        <div class="mb-4 relative group max-w-sm">
                            <video src="{{ asset('storage/'.$existing_video) }}" controls class="w-full h-48 rounded-lg border bg-black"></video>
                            <button type="button" wire:click="removeVideo" class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded text-xs font-bold shadow hover:bg-red-700">
                                Remove Video
                            </button>
                        </div>
                    @endif

                    {{-- 2. Upload New Video --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                        <input wire:model="new_video" type="file" accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center">
                            <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm font-bold text-gray-600">
                                @if($existing_video) Replace Video @else Upload Video Tour @endif
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Max 50MB (MP4, MOV)</p>
                        </div>
                    </div>
                    @error('new_video') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    {{-- 3. Preview New Upload --}}
                    @if($new_video)
                        <div class="mt-4">
                            <p class="text-xs text-green-600 font-bold mb-1">New Video Selected:</p>
                            <video src="{{ $new_video->temporaryUrl() }}" controls class="w-full max-w-xs h-32 rounded-lg border bg-black"></video>
                        </div>
                    @endif
                </div>

                <div class="pt-6 border-t flex flex-col md:flex-row gap-4 justify-between items-center">
                    <button type="button" wire:click="delete" 
                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                            class="text-red-500 hover:text-red-700 font-bold px-6 py-3">
                        Delete Ad
                    </button>

                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-10 rounded-xl hover:bg-blue-700 shadow-lg flex items-center gap-2">
                        <span wire:loading.remove>Update Property</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>