<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-7xl mx-auto pb-20">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-gray-200 pb-6 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Add New Product</h1>
                    <p class="text-gray-500 mt-1">Fill in the details to list your item.</p>
                </div>
                
                <label class="flex items-center gap-3 bg-white px-5 py-3 rounded-xl border-2 {{ $is_sellable ? 'border-green-500 bg-green-50' : 'border-gray-300' }} cursor-pointer shadow-sm transition hover:shadow-md">
                    <input type="checkbox" wire:model.live="is_sellable" class="w-5 h-5 text-green-600 rounded focus:ring-green-500 border-gray-300">
                    <div class="flex flex-col text-left">
                        <span class="font-bold {{ $is_sellable ? 'text-green-800' : 'text-gray-700' }} text-sm">List for Online Sale</span>
                        <span class="text-xs text-gray-500">Enable 'Buy Now' button</span>
                    </div>
                </label>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Basic Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Product Name *</label>
                                    <input wire:model="name" type="text" class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:border-blue-500 font-bold">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Brand</label>
                                        <input wire:model="brand" type="text" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">SKU</label>
                                        <input wire:model="sku" type="text" placeholder="Auto-generated" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                                    <textarea wire:model="description" rows="4" class="w-full border-2 border-gray-300 rounded-lg p-2.5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Pricing & Logistics</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Base Price (₹) *</label>
                                        <input wire:model.live="price" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5 text-lg font-bold">
                                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Discount (%)</label>
                                        <input wire:model.live="discount_percentage" type="number" min="0" max="100" class="w-full border-2 border-gray-300 rounded-lg p-2.5 text-green-600 font-bold">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Final Price</label>
                                        <input wire:model="discounted_price" type="text" readonly class="w-full bg-gray-100 border-2 border-gray-300 rounded-lg p-2.5 font-extrabold text-lg text-blue-700 cursor-not-allowed">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Stock Quantity</label>
                                        <input wire:model="stock_quantity" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Shipping Charges (₹)</label>
                                        <input wire:model="shipping_charges" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5" placeholder="0 for Free">
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-5 rounded-xl border border-blue-200">
                                    <div class="flex justify-between items-center mb-3">
                                        <label class="block text-sm font-bold text-blue-900"><i class="fas fa-layer-group"></i> Bulk Quantity Pricing (B2B)</label>
                                        <button type="button" wire:click="addTier" class="text-xs font-bold text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700 shadow">+ Add Tier</button>
                                    </div>
                                    
                                    @foreach($tiered_pricing as $index => $tier)
                                    <div class="flex gap-3 mb-2 items-center">
                                        <div class="flex-1 flex items-center gap-2">
                                            <span class="text-xs text-gray-600 font-bold">Buy Min</span>
                                            
                                            <input wire:model="tiered_pricing.{{ $index }}.min_qty" 
                                                wire:change="calculateTierPrice({{ $index }})"
                                                type="number" 
                                                placeholder="10" 
                                                class="w-full border-2 border-white focus:border-blue-500 rounded p-2 text-sm">
                                        </div>
                                        <div class="flex-1 flex items-center gap-2">
                                            <span class="text-xs text-gray-600 font-bold">Price ₹</span>
                                            <input wire:model="tiered_pricing.{{ $index }}.unit_price" 
                                                type="number" 
                                                placeholder="Unit Price" 
                                                class="w-full border-2 border-white focus:border-blue-500 rounded p-2 text-sm">
                                        </div>
                                        @if($index > 0)
                                            <button type="button" wire:click="removeTier({{ $index }})" class="text-red-500 hover:text-red-700 bg-white p-2 rounded border border-gray-200"><i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                @endforeach
                                    <p class="text-xs text-blue-600 mt-2">Example: Buy 10+ @ ₹90/unit (Discounted from Base Price)</p>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Special Offer</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model.live="has_special_offer" class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                                    <span class="text-gray-700 font-bold text-sm">Mark as Active Offer</span>
                                </label>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Offer Text</label>
                                    <input wire:model="special_offer_text" type="text" placeholder="e.g. Buy 2 Get 1 Free for Diwali!" class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:border-purple-500">
                                    <p class="text-xs text-gray-500 mt-1">Enter promotion details here. Check the box above to activate it on the website.</p>
                                </div>
                            </div>
                        </div> -->

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Media</h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Product Images</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative bg-gray-50">
                                    <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-xs font-bold text-gray-600">Click to upload (Max 5)</p>
                                </div>
                                @if($images)
                                    <div class="flex gap-2 mt-2 overflow-x-auto py-2">
                                        @foreach($images as $img)
                                            <div class="h-16 w-16 flex-shrink-0 rounded border border-gray-300 overflow-hidden">
                                                <img src="{{ $img->temporaryUrl() }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Product Video</label>
                                <div class="mb-3">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Upload File (MP4)</span>
                                    <input wire:model="video" type="file" accept="video/mp4,video/x-m4v,video/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-1">
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-500 uppercase">OR YouTube Link</span>
                                    <input wire:model="video_url" type="text" placeholder="https://youtube.com/watch?v=..." class="w-full border-2 border-gray-300 rounded-lg p-2 mt-1 text-sm">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Categorization</h3>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Category *</label>
            <select wire:model.live="product_category_id" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
                <option value="other" class="font-bold text-blue-600">+ Other (Suggest New)</option>
            </select>
            @error('product_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($is_other_category)
            <div>
                <label class="block text-sm font-bold text-blue-700 mb-1">New Category Name</label>
                <input wire:model="new_category_name" type="text" placeholder="e.g. Industrial Machinery" class="w-full border-2 border-blue-300 rounded-lg p-2 font-bold animate-pulse">
                @error('new_category_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- Activate subcategory selection only if parent category is selected and not "other" --}}
        @if(!$is_other_category && $product_category_id)
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Subcategory</label>
                <select wire:model.live="product_sub_category_id" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                    <option value="other" class="font-bold text-blue-600">+ Other (Suggest New)</option>
                </select>
            </div>
        @endif

        {{-- Show subcategory input if "other" is selected OR if the category itself is new --}}
        @if($is_other_subcategory)
            <div>
                <label class="block text-sm font-bold text-blue-700 mb-1">New Subcategory Name</label>
                <input wire:model="new_subcategory_name" type="text" placeholder="e.g. Hydraulic Pumps" class="w-full border-2 border-blue-300 rounded-lg p-2 font-bold animate-pulse">
                @error('new_subcategory_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif
    </div>
</div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Variations</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Colors</label>
                                    <input wire:model="colors" type="text" placeholder="Red, Blue" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Sizes</label>
                                    <input wire:model="sizes" type="text" placeholder="S, M, L" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-bold text-gray-900">Specs</h3>
                                <button type="button" wire:click="addSpec" class="text-xs font-bold text-blue-600 hover:underline">+ Add Row</button>
                            </div>
                            <div class="space-y-2">
                                @foreach($specs as $index => $spec)
                                    <div class="flex gap-2 w-full">
                                        <input wire:model="specs.{{ $index }}.key" type="text" placeholder="Feature" class="flex-1 min-w-0 border-gray-300 rounded p-2 text-xs border">
                                        <input wire:model="specs.{{ $index }}.value" type="text" placeholder="Value" class="flex-1 min-w-0 border-gray-300 rounded p-2 text-xs border">
                                        @if($loop->index > 0)
                                            <button type="button" wire:click="removeSpec({{ $index }})" class="text-red-500 hover:text-red-700 flex-shrink-0"><i class="fas fa-times"></i></button>
                                        @endif
                                    </div>
                                @endforeach
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