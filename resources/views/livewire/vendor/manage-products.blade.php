<div class="max-w-7xl mx-auto py-10 px-4">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Products</h1>
            <p class="text-sm text-gray-500">Manage your inventory and prices.</p>
        </div>
        
        @if(!$showForm)
        <button wire:click="create" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 shadow-md">
            + Add New Product
        </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border border-green-400 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    @if(!$showForm)
        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                            <div class="h-12 w-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden border border-gray-200">
                                @if(!empty($product->images) && is_array($product->images))
                                    <img src="{{ asset('storage/'.$product->images[0]) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $product->name }}</span>
                                <span class="text-xs text-gray-500 uppercase">{{ $product->category }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-bold">
                            ₹{{ number_format($product->price) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $product->id }})" class="text-blue-600 hover:text-blue-900 mr-4 font-bold">Edit</button>
                            <button wire:click="delete({{ $product->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                                <p>No products found. Start selling today!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t">
                {{ $products->links() }}
            </div>
        </div>
    
    @else
        <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl mx-auto border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 pb-4 border-b flex items-center gap-2">
                <i class="fas fa-tag text-blue-600"></i>
                {{ $isEditing ? 'Edit Product' : 'Add New Product' }}
            </h2>
            
            <form wire:submit.prevent="save" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Product Name</label>
                        <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹)</label>
                        <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500">
                        @error('price') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                    <select wire:model="category" class="w-full border-gray-300 rounded-lg p-3 border bg-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a Category...</option>
                        <option value="safety">Safety Equipment</option>
                        <option value="power-tools">Power Tools</option>
                        <option value="pumps">Pumps & Motors</option>
                        <option value="office">Office Supplies</option>
                        <option value="paints">Paints & Chemicals</option>
                        <option value="hardware">General Hardware</option>
                        <option value="real-estate">Real Estate</option>
                    </select>
                    @error('category') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('description') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Product Images</label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-blue-50 transition cursor-pointer relative">
                        <input wire:model="images" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="prod-img">
                        <div class="text-gray-500">
                            <i class="fas fa-cloud-upload-alt text-3xl mb-2 text-blue-500"></i><br> 
                            <span class="font-bold text-blue-600">Click to Upload</span> or drag and drop
                        </div>
                    </div>

                    <div wire:loading wire:target="images" class="text-blue-600 text-xs font-bold mt-2">
                        <i class="fas fa-spinner fa-spin"></i> Uploading images...
                    </div>

                    @error('images.*') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }} (Max 2MB)</span> @enderror
                    @error('images') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror

                    @if($images)
                    <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                        @foreach($images as $img)
                           <div class="relative flex-shrink-0">
                               <img src="{{ $img->temporaryUrl() }}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                           </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input wire:model="is_active" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500 w-5 h-5">
                        <span class="text-sm font-bold text-gray-700">Active (Visible)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input wire:model="in_stock" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500 w-5 h-5">
                        <span class="text-sm font-bold text-gray-700">In Stock</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input wire:model="on_sale" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500 w-5 h-5">
                        <span class="text-sm font-bold text-gray-700">On Sale</span>
                    </label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t">
                    <button type="button" wire:click="cancel" class="bg-gray-100 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-200 transition">
                        Cancel
                    </button>
                    
                    <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditing ? 'Update Product' : 'Create Product' }}
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin"></i> Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>