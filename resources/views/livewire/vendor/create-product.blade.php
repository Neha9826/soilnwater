<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8 md:pl-64">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-7xl mx-auto pb-20">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Add New Product</h1>
                    <p class="text-gray-500 mt-1">Fill in the details to list your item.</p>
                </div>
                <a href="{{ route('vendor.products') }}" class="text-gray-500 font-bold hover:text-gray-800">Cancel</a>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Basic Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Product Name *</label>
                                    <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-2 focus:ring-blue-500">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Brand</label>
                                        <input wire:model="brand" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">SKU (Optional)</label>
                                        <input wire:model="sku" type="text" placeholder="Auto-generated if empty" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                                    <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-2.5 border"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Product Images</h3>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 transition cursor-pointer relative">
                                <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-sm font-bold text-gray-700">Click to upload images</p>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                            @if($images)
                                <div class="flex gap-4 mt-4 overflow-x-auto pb-2">
                                    @foreach($images as $img)
                                        <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                            <img src="{{ $img->temporaryUrl() }}" class="h-full w-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-bold text-gray-900">Specifications</h3>
                                <button type="button" wire:click="addSpec" class="text-sm text-blue-600 font-bold hover:underline">+ Add Row</button>
                            </div>
                            <div class="space-y-3">
                                @foreach($specs as $index => $spec)
                                    <div class="flex gap-3 items-center">
                                        <input wire:model="specs.{{ $index }}.key" type="text" placeholder="Feature (e.g. Material)" class="flex-1 border-gray-300 rounded-lg p-2 border text-sm">
                                        <input wire:model="specs.{{ $index }}.value" type="text" placeholder="Value (e.g. Cotton)" class="flex-1 border-gray-300 rounded-lg p-2 border text-sm">
                                        @if($loop->index > 0)
                                            <button type="button" wire:click="removeSpec({{ $index }})" class="text-red-500 hover:text-red-700"><i class="fas fa-times"></i></button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Price & Stock</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Selling Price (₹) *</label>
                                    <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border font-bold text-lg">
                                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Stock Qty *</label>
                                    <input wire:model="stock_quantity" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    @error('stock_quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Categorization</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Category *</label>
                                    <select wire:model.live="category_id" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                        <option value="other" class="font-bold text-blue-600">+ Other (Request New)</option>
                                    </select>
                                    @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                @if($is_other_category)
                                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                        <label class="block text-xs font-bold text-blue-800 mb-1">New Category Name</label>
                                        <input wire:model="new_category_name" type="text" class="w-full border-blue-300 rounded-lg p-2 border text-sm">
                                    </div>
                                @endif

                                @if(!$is_other_category && !empty($subcategories))
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Subcategory</label>
                                        <select wire:model="subcategory_id" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                            <option value="">Select Subcategory</option>
                                            @foreach($subcategories as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Variations</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Colors (Comma separated)</label>
                                    <input wire:model="colors" type="text" placeholder="Red, Blue" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Sizes (Comma separated)</label>
                                    <input wire:model="sizes" type="text" placeholder="S, M, L" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Shipping</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                     <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Weight (kg)</label>
                                        <input wire:model="weight" type="number" step="0.01" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Dimensions</label>
                                        <input wire:model="dimensions" type="text" placeholder="10x10x5 cm" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-black text-white font-bold py-4 px-12 rounded-xl hover:bg-gray-800 shadow-xl transition transform hover:-translate-y-1 text-lg flex items-center gap-2">
                        <span wire:loading.remove>Save Product</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>