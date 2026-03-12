<div class="w-full flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        {{-- AUTO-HIDING SUCCESS MESSAGE --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 5000)" 
                 x-show="show" 
                 x-transition.duration.500ms
                 class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded shadow-md flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('message') }}</span>
                </div>
                <button @click="show = false" class="text-green-700 hover:text-green-900 text-2xl line-height-0">&times;</button>
            </div>
        @endif
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
                <div class="space-y-6 pt-6 border-t border-gray-100">
            <h3 class="text-xs font-black uppercase text-gray-400 tracking-widest">Amenities & Facilities</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($available_amenities as $amenity) {{-- Fixed variable name --}}
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                        <input type="checkbox" wire:model="selected_amenities" value="{{ $amenity->id }}" class="rounded text-leaf-green focus:ring-leaf-green border-gray-300">
                        <span class="text-[11px] font-bold text-gray-700 uppercase">{{ $amenity->name }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Custom Amenity Input --}}
            <div class="flex gap-2">
                <input type="text" wire:model="new_amenity_name" placeholder="Add custom amenity (e.g. Helipad)" class="flex-1 bg-gray-50 border-none rounded-xl px-4 py-2 text-xs font-bold">
                <button type="button" wire:click="addCustomAmenity" class="bg-gray-900 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase">Add</button>
            </div>
        </div>

                {{-- Media --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">Media</h3>
                    
                    {{-- Images --}}
                    {{-- SECTION: IMAGE MANAGEMENT --}}
                    <div class="bg-purple-50 p-6 rounded-xl border border-purple-100 mb-8">
                        <h3 class="text-lg font-bold text-purple-900 mb-4 pb-2 border-b border-purple-200">Project Gallery</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            {{-- 1. Show Existing Images --}}
                            @foreach($existing_images as $index => $path)
                                <div class="relative group aspect-square rounded-xl overflow-hidden border-2 border-white shadow-sm">
                                    <img src="{{ route('ad.display', ['path' => $path]) }}" class="w-full h-full object-cover">
                                    <button type="button" wire:click="removeImage({{ $index }})" 
                                            class="absolute top-2 right-2 bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[8px] text-center py-1 opacity-0 group-hover:opacity-100">EXISTING</div>
                                </div>
                            @endforeach

                            {{-- 2. Preview New Uploads (Before Saving) --}}
                            @if($new_images)
                                @foreach($new_images as $image)
                                    <div class="relative aspect-square rounded-xl overflow-hidden border-2 border-leaf-green shadow-sm animate-pulse">
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover opacity-70">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="bg-leaf-green text-white text-[8px] font-black px-2 py-1 rounded">PENDING</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- 3. The Upload Input --}}
                        <div class="relative">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-purple-700 rounded-xl shadow-sm border border-purple-200 cursor-pointer hover:bg-purple-50 transition">
                                <i class="fas fa-cloud-upload-alt text-3xl mb-2"></i>
                                <span class="text-sm font-bold">Click to add more photos</span>
                                <input type="file" wire:model="new_images" multiple class="hidden">
                            </label>
                            <div wire:loading wire:target="new_images" class="mt-2 text-xs text-purple-600 font-bold">
                                <i class="fas fa-spinner fa-spin"></i> Uploading to server...
                            </div>
                        </div>
                    </div>

                <div class="pt-10 grid grid-cols-3 gap-4">
            {{-- Smaller Go Back Button (1/3 Width) --}}
            <a href="{{ route('customer.listings') }}" 
               class="col-span-1 bg-gray-100 text-gray-500 font-black py-5 rounded-2xl hover:bg-gray-200 transition uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> <span class="hidden md:inline">Back</span>
            </a>

            {{-- Larger Update Button (2/3 Width) --}}
            <button type="submit" wire:loading.attr="disabled" 
                    class="col-span-2 bg-green-600 text-white font-black py-5 rounded-2xl hover:bg-green-700 transition shadow-lg uppercase tracking-[0.2em] text-[10px] flex items-center justify-center gap-3">
                <span wire:loading.remove wire:target="update">Update Project Details</span>
                <span wire:loading wire:target="update" class="flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i> Saving...
                </span>
            </button>
        </div>

            </form>
        </div>
    </div>
</div>