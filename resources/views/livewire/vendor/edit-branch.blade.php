<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-5xl mx-auto pb-20">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Manage Branch</h1>
                    <p class="text-gray-500 mt-1">Update details for <span class="text-blue-600 font-bold">{{ $company_name }}</span></p>
                </div>
                <a href="{{ route('vendor.branches') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-sm">
                    <p class="font-bold">Success</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <form wire:submit.prevent="updateBranch" class="space-y-8">
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm">1</span>
                        Basic Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Branch / Company Name</label>
                            <input wire:model="company_name" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition font-bold text-gray-800">
                            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Contact Person</label>
                            <input wire:model="contact_person" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Current Logo</label>
                            <div class="flex items-center gap-4">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-16 w-16 rounded-full object-cover border-2 border-blue-500">
                                @elseif($existing_logo)
                                    <img src="{{ asset('storage/'.$existing_logo) }}" class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                                @else
                                    <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                @endif
                                <input wire:model="logo" type="file" class="text-sm text-gray-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm">2</span>
                        Contact & Location
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone</label>
                            <input wire:model="phone" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                            <input wire:model="whatsapp_number" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input wire:model="email" type="email" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Address</label>
                            <input wire:model="address" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">City</label>
                            <input wire:model="city" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">State</label>
                            <input wire:model="state" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pincode</label>
                            <input wire:model="pincode" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm">3</span>
                        Legal & Info
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">PAN Number</label>
                            <input wire:model="pan_number" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3 uppercase font-bold">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">GST Number</label>
                            <input wire:model="gst_number" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3 uppercase font-bold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" rows="4" class="w-full border-2 border-gray-200 rounded-xl p-3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm">4</span>
                        Gallery
                    </h4>
                    
                    @if(!empty($existing_images))
                        <div class="flex flex-wrap gap-4 mb-4">
                            @foreach($existing_images as $index => $img)
                                <div class="relative group h-24 w-24 rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ asset('storage/'.$img) }}" class="h-full w-full object-cover">
                                    <button type="button" wire:click="removeGalleryImage({{ $index }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition"><i class="fas fa-times"></i></button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <label class="block text-sm font-bold text-gray-700 mb-2">Add New Images</label>
                    <input wire:model="images" type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg text-lg">
                        Update Branch Details
                    </button>
                    
                    <button type="button" wire:click="deleteBranch" wire:confirm="Are you sure? This cannot be undone." class="w-full bg-red-50 text-red-600 font-bold py-3 rounded-xl hover:bg-red-100 transition border border-red-100">
                        <i class="fas fa-trash-alt mr-2"></i> Delete This Branch Permanently
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>