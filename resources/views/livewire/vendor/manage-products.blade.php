<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-sm animate-fade-in-down">
                <p class="font-bold">Success</p>
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <div class="max-w-7xl mx-auto pb-20">
            
            <div class="flex flex-col gap-6 mb-8">
                <div class="flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900">Product Inventory</h1>
                        <p class="text-gray-500 mt-1">Manage your catalog, stock, and variations.</p>
                    </div>
                    <a href="{{ route('vendor.products.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 font-bold py-2.5 px-6 rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fas fa-plus"></i> <span class="hidden md:inline">Add Product</span>
                    </a>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <div class="relative w-full md:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input wire:model.live.debounce.300ms="search" 
                               type="text" 
                               placeholder="Search name, category, price, date..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-lg">
                        <button wire:click="$set('viewType', 'list')" class="px-4 py-2 rounded-md text-sm font-bold transition {{ $viewType === 'list' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="fas fa-list mr-1"></i> List
                        </button>
                        <button wire:click="$set('viewType', 'grid')" class="px-4 py-2 rounded-md text-sm font-bold transition {{ $viewType === 'grid' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            <i class="fas fa-th-large mr-1"></i> Cards
                        </button>
                    </div>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <div class="bg-gray-50 h-20 w-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fas fa-box-open text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No Products Found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search or add a new item.</p>
                    <a href="{{ route('vendor.products.create') }}" class="text-blue-600 font-bold hover:underline">Create First Product</a>
                </div>
            @else
                
                @if($viewType === 'list')
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                                    <tr>
                                        <th class="p-4 w-16">#</th>
                                        <th class="p-4 w-20">Image</th>
                                        <th class="p-4">Product Info</th>
                                        <th class="p-4">Category</th>
                                        <th class="p-4">Price</th>
                                        <th class="p-4">Stock</th>
                                        <th class="p-4 text-center">Online?</th>
                                        <th class="p-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($products as $index => $product)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-4 text-gray-500 font-bold">
                                                {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                            </td>
                                            
                                            <td class="p-4">
                                                @php
                                                    // Handle array image storage
                                                    $img = is_array($product->images) && !empty($product->images) ? $product->images[0] : null;
                                                @endphp
                                                <div class="h-12 w-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                                                    @if($img)
                                                        <img src="{{ route('ad.display', ['path' => $img]) }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="p-4">
                                                <div class="font-bold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $product->created_at->format('d M, Y') }}</div>
                                            </td>

                                            <td class="p-4">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-md text-xs font-bold">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>

                                            <td class="p-4 font-bold text-gray-900">₹{{ number_format($product->price) }}</td>
                                            
                                            <td class="p-4">
                                                <span class="{{ $product->stock_quantity < 10 ? 'text-red-600 font-bold' : 'text-green-600 font-bold' }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>

                                            <td class="p-4 text-center">
                                                <button wire:click="toggleStatus({{ $product->id }})" 
                                                        class="transition {{ $product->is_sellable ? 'text-green-500 hover:text-green-700' : 'text-gray-300 hover:text-gray-500' }}"
                                                        title="Toggle Online Sale">
                                                    <i class="fas fa-eye{{ $product->is_sellable ? '' : '-slash' }} text-xl"></i>
                                                </button>
                                            </td>

                                            <td class="p-4 text-right">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('vendor.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 p-2 rounded-lg transition" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button wire:click="deleteProduct({{ $product->id }})" 
                                                            wire:confirm="Are you sure you want to delete {{ $product->name }}?"
                                                            class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if($viewType === 'grid')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
                                <div class="h-48 bg-gray-100 relative">
                                    @php $img = is_array($product->images) && !empty($product->images) ? $product->images[0] : null; @endphp
                                    @if($img)
                                        <img src="{{ $img ? route('storage.bridge', ['path' => $img]) : asset('images/placeholder.png') }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-300"><i class="fas fa-image text-3xl"></i></div>
                                    @endif
                                    
                                    <div class="absolute top-2 right-2">
                                        @if($product->is_sellable)
                                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">Online</span>
                                        @else
                                            <span class="bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">Hidden</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="text-xs text-blue-600 font-bold mb-1">{{ $product->category->name ?? 'General' }}</div>
                                    <h3 class="font-bold text-gray-900 truncate mb-1">{{ $product->name }}</h3>
                                    <div class="flex justify-between items-center mt-3">
                                        <span class="font-extrabold text-lg">₹{{ number_format($product->price) }}</span>
                                        <span class="text-xs text-gray-500 font-medium">Stock: {{ $product->stock_quantity }}</span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 flex justify-between border-t border-gray-100">
                                    <button wire:click="toggleStatus({{ $product->id }})" class="text-gray-500 hover:text-green-600 text-sm font-bold flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Visibility
                                    </button>
                                    <div class="flex gap-2">
                                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteProduct({{ $product->id }})" wire:confirm="Delete this item?" class="text-red-500 hover:bg-red-100 p-1.5 rounded"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            @endif
        </div>
    </main>
</div>