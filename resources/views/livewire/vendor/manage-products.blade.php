<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-sm flex justify-between items-center">
                <div>
                    <p class="font-bold">Success</p>
                    <p>{{ session('message') }}</p>
                </div>
                <button wire:click="$set('isCreating', false)" class="text-green-700 font-bold hover:underline">View List</button>
            </div>
        @endif

        <div class="max-w-7xl mx-auto pb-20">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 border-b border-gray-200 pb-6 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Product Inventory</h1>
                    <p class="text-gray-500 mt-1">Manage your catalog, stock, and variations.</p>
                </div>
                <div>
                    @if($isCreating)
                        <button wire:click="$set('isCreating', false)" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-6 rounded-lg transition shadow-sm">Cancel</button>
                    @else
                        <a href="{{ route('vendor.products.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 font-bold py-2 px-6 rounded-lg transition shadow-md flex items-center gap-2"> <i class="fas fa-plus"></i> Add New Product </a>
                    @endif
                </div>
            </div>

            @if(!$isCreating)
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    @if($products->isEmpty())
                        <div class="text-center py-16">
                            <h3 class="text-lg font-bold text-gray-900">No Products Yet</h3>
                            <button wire:click="$set('isCreating', true)" class="text-blue-600 font-bold hover:underline">Create First Product</button>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                                    <tr><th class="p-4">Product</th><th class="p-4">Price</th><th class="p-4">Stock</th><th class="p-4 text-right">Actions</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="p-4 font-bold">{{ $product->name }}</td>
                                        <td class="p-4">₹{{ number_format($product->price) }}</td>
                                        <td class="p-4">{{ $product->stock_quantity }}</td>
                                        <td class="p-4 text-right"><button class="text-blue-600"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         </div>
                    @endif
                 </div>
            @endif

            

        </div>
    </main>
</div>