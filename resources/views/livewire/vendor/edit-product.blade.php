<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div class="max-w-7xl mx-auto pb-20">
            
            <div class="flex justify-between items-center mb-8 border-b pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Product</h1>
                    <p class="text-gray-500 mt-1">Update your listing details for <span class="text-blue-600 font-bold">{{ $name }}</span></p>
                </div>
                <a href="{{ route('vendor.products') }}" class="text-gray-600 hover:text-black font-bold flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        {{-- Basic Info --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Basic Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Product Name *</label>
                                    <input wire:model="name" type="text" class="w-full border-2 border-gray-300 rounded-lg p-2.5 font-bold">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Brand</label>
                                        <input wire:model="brand" type="text" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">SKU</label>
                                        <input wire:model="sku" type="text" class="w-full border-2 border-gray-300 rounded-lg p-2.5 bg-gray-50 cursor-not-allowed" readonly>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                                    <textarea wire:model="description" rows="4" class="w-full border-2 border-gray-300 rounded-lg p-2.5"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Pricing & B2B --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Pricing & B2B</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹) *</label>
                                        <input wire:model.live="price" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5 font-bold">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Discount (%)</label>
                                        <input wire:model.live="discount_percentage" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5 text-green-600">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Final Price</label>
                                        <input value="{{ $discounted_price }}" type="text" readonly class="w-full bg-gray-100 border-2 border-gray-300 rounded-lg p-2.5 font-extrabold text-blue-700">
                                    </div>
                                </div>

                                {{-- B2B Tiers --}}
                                <div class="bg-blue-50 p-5 rounded-xl border border-blue-200">
                                    <div class="flex justify-between items-center mb-3">
                                        <label class="text-sm font-bold text-blue-900">B2B Tiered Pricing</label>
                                        <button type="button" wire:click="addTier" class="text-xs bg-blue-600 text-white px-3 py-1 rounded">+ Add Tier</button>
                                    </div>
                                    @foreach($tiered_pricing as $index => $tier)
                                        <div class="flex gap-3 mb-2">
                                            <input wire:model="tiered_pricing.{{ $index }}.min_qty" type="number" placeholder="Min Qty" class="flex-1 p-2 rounded border">
                                            <input wire:model="tiered_pricing.{{ $index }}.unit_price" type="number" placeholder="Price" class="flex-1 p-2 rounded border">
                                            <button type="button" wire:click="removeTier({{ $index }})" class="text-red-500"><i class="fas fa-trash"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Media Section with Previews --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Media</h3>
                            
                            {{-- Existing Images Preview --}}
                            @if(!empty($existingImages))
                                <label class="block text-sm font-bold text-gray-700 mb-2">Current Images (Click 'x' to remove)</label>
                                <div class="flex gap-4 mb-4 overflow-x-auto py-2">
                                    @foreach($existingImages as $index => $path)
                                        <div class="relative h-24 w-24 flex-shrink-0 group shadow-sm rounded-lg border overflow-hidden">
                                            {{-- Serve via the path proxy we verified in web.php --}}
                                            <img src="{{ route('ad.display', ['path' => $path]) }}" class="h-full w-full object-cover">
                                            
                                            {{-- Remove Button --}}
                                            <button type="button" 
                                                wire:click="removeExistingImage({{ $index }})" 
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition shadow-md"
                                                title="Remove Image">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label class="block text-sm font-bold text-gray-700 mb-2">Upload New Images</label>
                            <input wire:model="images" type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700">
                        </div>
                    </div>

                    <div class="space-y-8">
                        {{-- Categorization Logic --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Categorization</h3>
                            <div class="space-y-4">
                                {{-- Category --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700">Category *</label>
                                    <select wire:model.live="product_category_id" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                        <option value="other" class="text-blue-600 font-bold">+ Suggest Other</option>
                                    </select>
                                </div>

                                @if($is_other_category)
                                    <input wire:model="new_category_name" type="text" placeholder="Custom Category Name" class="w-full border-2 border-blue-300 rounded-lg p-2">
                                @endif

                                {{-- Subcategory --}}
                                @if($product_category_id && !$is_other_category)
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700">Subcategory</label>
                                        <select wire:model.live="product_sub_category_id" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                            <option value="">Select Subcategory</option>
                                            @foreach($subcategories as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                            @endforeach
                                            <option value="other" class="text-blue-600 font-bold">+ Suggest Other</option>
                                        </select>
                                    </div>
                                @endif

                                @if($is_other_subcategory)
                                    <input wire:model="new_subcategory_name" type="text" placeholder="Custom Subcategory Name" class="w-full border-2 border-blue-300 rounded-lg p-2">
                                @endif
                            </div>
                        </div>

                        {{-- Stock & Visibility --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Inventory</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Stock Quantity</label>
                                    <input wire:model="stock_quantity" type="number" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                </div>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model.live="is_sellable" class="w-5 h-5 text-green-600 rounded">
                                    <span class="font-bold text-gray-700">Active for Sale</span>
                                </label>
                            </div>
                        </div>
                        {{-- Variations Section --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Variations</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Colors</label>
                                    <input wire:model="colors" type="text" placeholder="Red, Blue" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    <p class="text-xs text-gray-400 mt-1">Separate with commas</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Sizes</label>
                                    <input wire:model="sizes" type="text" placeholder="S, M, L" class="w-full border-2 border-gray-300 rounded-lg p-2.5">
                                    <p class="text-xs text-gray-400 mt-1">Separate with commas</p>
                                </div>
                            </div>
                        </div>

                        {{-- Specs Section --}}
                        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-bold text-gray-900">Technical Specs</h3>
                                <button type="button" wire:click="addSpec" class="text-xs font-bold text-blue-600 hover:underline">+ Add Row</button>
                            </div>
                            <div class="space-y-2">
                                @foreach($specs as $index => $spec)
                                    <div class="flex gap-2 w-full">
                                        <input wire:model="specs.{{ $index }}.key" type="text" placeholder="Feature" class="flex-1 min-w-0 border-gray-300 rounded p-2 text-xs border">
                                        <input wire:model="specs.{{ $index }}.value" type="text" placeholder="Value" class="flex-1 min-w-0 border-gray-300 rounded p-2 text-xs border">
                                        @if($index > 0)
                                            <button type="button" wire:click="removeSpec({{ $index }})" class="text-red-500 hover:text-red-700 flex-shrink-0">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <button type="submit" class="bg-black text-white font-bold py-4 px-12 rounded-xl hover:bg-gray-800 shadow-xl flex items-center gap-2 transition">
                        <span wire:loading.remove>Update Product Details</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>