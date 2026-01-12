<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-5xl mx-auto pb-20">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Add New Branch</h1>
                    <p class="text-gray-500 mt-1">Expanding your business? Add another location details below.</p>
                </div>
                <a href="{{ route('vendor.branches') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>

            <form wire:submit.prevent="saveBranch" class="space-y-8">
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b pb-4">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm">1</span>
                        Basic Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Branch / Company Name <span class="text-red-500">*</span></label>
                            <input wire:model="company_name" type="text" placeholder="e.g. SoilNWater Dehradun Branch" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition font-bold text-gray-800">
                            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Contact Person</label>
                            <input wire:model="contact_person" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Branch Logo</label>
                            <input wire:model="logo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                            <input wire:model="phone" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                            <input wire:model="whatsapp_number" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input wire:model="email" type="email" class="w-full border-2 border-gray-200 rounded-xl p-3">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Address <span class="text-red-500">*</span></label>
                            <input wire:model="address" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">City <span class="text-red-500">*</span></label>
                            <input wire:model="city" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                        Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select wire:model.live="category_type" class="w-full border-2 border-gray-200 rounded-xl p-3 bg-white">
                                <option value="">Select Category</option>
                                @foreach($dbCategories as $cat)
                                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                @endforeach
                                <option value="Other" class="text-blue-600 font-bold">+ Other</option>
                            </select>
                            @error('category_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        @if($category_type === 'Other')
                            <div>
                                <label class="block text-sm font-bold text-blue-700 mb-2">Specify Category</label>
                                <input wire:model="custom_category" type="text" class="w-full border-2 border-blue-200 rounded-xl p-3">
                            </div>
                        @endif
                        
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
                    <label class="block text-sm font-bold text-gray-700 mb-2">Upload Images</label>
                    <input wire:model="images" type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end pt-4 pb-12">
                    <button type="submit" class="bg-black text-white font-bold py-4 px-12 rounded-xl hover:bg-gray-800 shadow-xl transition transform hover:-translate-y-1 text-lg flex items-center gap-2">
                        <span wire:loading.remove wire:target="saveBranch">Create Branch</span>
                        <span wire:loading wire:target="saveBranch"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>