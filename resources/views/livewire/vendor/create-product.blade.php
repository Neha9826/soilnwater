<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-7xl mx-auto pb-20">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Add New Product</h1>
                    <p class="text-gray-500 mt-1">Fill in the details to list your item.</p>
                </div>
                
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-sm">
                    <span class="text-sm font-bold text-gray-700">List for Online Sale?</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_sellable" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
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
                                        <label class="block text-sm font-bold text-gray-700 mb-1">SKU</label>
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
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Pricing & Discounts</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Base Price (₹) *</label>
                                        <input wire:model.live="price" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border font-bold text-lg">
                                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Discount (%)</label>
                                        <input wire:model.live="discount_percentage" type="number" min="0" max="100" class="w-full border-gray-300 rounded-lg p-2.5 border text-green-600 font-bold">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Final Price</label>
                                        <input wire:model="discounted_price" type="text" readonly class="w-full bg-gray-50 border-gray-300 rounded-lg p-2.5 border font-extrabold text-lg text-blue-700 cursor-not-allowed">
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-bold text-blue-900"><i class="fas fa-layer-group"></i> Bulk Quantity Pricing (B2B)</label>
                                        <button type="button" wire:click="addTier" class="text-xs font-bold text-blue-600 hover:underline">+ Add Tier</button>
                                    </div>
                                    
                                    @foreach($tiered_pricing as $index => $tier)
                                        <div class="flex gap-3 mb-2 items-center">
                                            <div class="flex-1 flex items-center gap-2">
                                                <span class="text-xs text-gray-500 font-bold">Buy</span>
                                                <input wire:model="tiered_pricing.{{ $index }}.min_qty" type="number" placeholder="Qty (e.g. 10)" class="w-full border-blue-200 rounded p-2 text-sm">
                                            </div>
                                            <div class="flex-1 flex items-center gap-2">
                                                <span class="text-xs text-gray-500 font-bold">@</span>
                                                <input wire:model="tiered_pricing.{{ $index }}.unit_price" type="number" placeholder="₹ Unit Price" class="w-full border-blue-200 rounded p-2 text-sm">
                                            </div>
                                            @if($index > 0)
                                                <button type="button" wire:click="removeTier({{ $index }})" class="text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4 border-b pb-2">
                                <h3 class="text-lg font-bold text-gray-900">Special Offer</h3>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="has_special_offer" class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            
                            @if($has_special_offer)
                                <div class="animate-fade-in-down">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Offer Details</label>
                                    <input wire:model="special_offer_text" type="text" placeholder="e.g. Buy 2 Get 1 Free for Diwali!" class="w-full border-purple-300 rounded-lg p-3 border focus:ring-purple-500">
                                    <p class="text-xs text-gray-500 mt-1">This text will be highlighted on the product page.</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 italic">Enable this to add a promotional tag to your product.</p>
                            @endif
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Product Images</h3>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 transition cursor-pointer relative">
                                <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-sm font-bold text-gray-700">Click to upload</p>
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
                        </div>

                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Stock & Logistics</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Stock Quantity</label>
                                    <input wire:model="stock_quantity" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Shipping Charges (₹)</label>
                                    <input wire:model="shipping_charges" type="number" class="w-full border-gray-300 rounded-lg p-2.5 border" placeholder="0 for Free Shipping">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                     <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Weight (kg)</label>
                                        <input wire:model="weight" type="number" step="0.01" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Dims (cm)</label>
                                        <input wire:model="dimensions" type="text" placeholder="LxWxH" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                    </div>
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
                                        <option value="other" class="font-bold text-blue-600">+ Other</option>
                                    </select>
                                </div>
                                @if($is_other_category)
                                    <input wire:model="new_category_name" type="text" placeholder="New Category Name" class="w-full border-blue-300 rounded-lg p-2 border">
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
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Colors</label>
                                    <input wire:model="colors" type="text" placeholder="Red, Blue" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Sizes</label>
                                    <input wire:model="sizes" type="text" placeholder="S, M, L" class="w-full border-gray-300 rounded-lg p-2.5 border">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-black text-white font-bold py-4 px-12 rounded-xl hover:bg-gray-800 shadow-xl transition transform hover:-translate-y-1 text-lg flex items-center gap-2">
                        <span wire:loading.remove>Save & List Product</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>