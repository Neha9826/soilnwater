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
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border border-green-400">
            {{ session('message') }}
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
                            <div class="h-10 w-10 bg-gray-100 rounded flex-shrink-0 overflow-hidden">
                                @if(!empty($product->images))
                                    <img src="{{ asset('storage/'.$product->images[0]) }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs text-gray-400 p-1">No Img</span>
                                @endif
                            </div>
                            <span class="font-medium text-gray-900">{{ $product->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            ₹{{ number_format($product->price) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $product->id }})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                            <button wire:click="delete({{ $product->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            No products found. Click "Add New Product" to start selling!
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
        <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 pb-4 border-b">{{ $isEditing ? 'Edit Product' : 'Add New Product' }}</h2>
            
            <form wire:submit.prevent="save" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Product Name</label>
                        <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹)</label>
                        <input wire:model="price" type="number" class="w-full border-gray-300 rounded-lg p-3 border">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" rows="4" class="w-full border-gray-300 rounded-lg p-3 border"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Product Images</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50">
                        <input wire:model="images" type="file" multiple class="hidden" id="prod-img">
                        <label for="prod-img" class="cursor-pointer text-blue-600 font-bold hover:text-blue-800">
                            <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i><br> Upload Photos
                        </label>
                    </div>
                    @if($images)
                    <div class="flex gap-2 mt-4 overflow-x-auto">
                        @foreach($images as $img)
                           <img src="{{ $img->temporaryUrl() }}" class="h-20 w-20 object-cover rounded border">
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-8 p-4 bg-gray-50 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-bold text-gray-700">Active (Visible)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="in_stock" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-bold text-gray-700">In Stock</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="on_sale" type="checkbox" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-bold text-gray-700">On Sale</span>
                    </label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t">
                    <button type="button" wire:click="cancel" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700">
                        {{ $isEditing ? 'Update Product' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>