<div class="w-full flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-purple-900">Edit Project</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full">
            <form wire:submit.prevent="update" class="p-8 space-y-8">

                {{-- Basic Details --}}
                <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
                    <h3 class="text-lg font-bold text-purple-900 mb-4 pb-2 border-b border-purple-200">Project Info</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Project Title *</label>
                            <input wire:model="title" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
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
                                <option value="Land / Plot">Land / Plotted Development</option>
                                <option value="Apartment Society">Apartment Society</option>
                                <option value="Villa Community">Villa Community</option>
                                <option value="Commercial Complex">Commercial Complex</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-3 border-2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Location</h3>
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
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Google Map Link</label>
                            <input wire:model="google_map_link" type="text" class="w-full border-gray-300 rounded-lg p-3 border-2">
                        </div>
                    </div>
                </div>

                {{-- Amenities --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Project Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        @foreach($available_amenities as $amenity)
                            <label class="flex items-center space-x-2 cursor-pointer bg-gray-50 p-2 rounded">
                                <input wire:model="selected_amenities" value="{{ $amenity->id }}" type="checkbox" class="rounded text-purple-600 h-5 w-5">
                                <span class="text-gray-700 text-sm">{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2">
                        <input wire:model="new_amenity_name" type="text" placeholder="Add custom amenity..." class="border-gray-300 rounded-lg p-2 text-sm">
                        <button type="button" wire:click="addCustomAmenity" class="bg-gray-800 text-white px-3 py-2 rounded-lg text-sm">Add</button>
                    </div>
                </div>

                {{-- Media --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Media</h3>
                    
                    {{-- Images --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Images</label>
                        
                        @if($existing_images)
                            <div class="flex gap-2 mb-2 overflow-x-auto">
                                @foreach($existing_images as $index => $img)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/'.$img) }}" class="h-20 w-20 object-cover rounded shadow">
                                        <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs">x</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <input wire:model="new_images" type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-purple-700 text-white font-bold py-4 rounded-xl hover:bg-purple-800 shadow-lg text-lg flex justify-center items-center gap-2">
                        <span wire:loading.remove>Update Project</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>