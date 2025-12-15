<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="bg-white rounded-xl shadow p-6 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $user->name }}</h1>
                <p class="text-gray-500">
                    Account Type: 
                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded uppercase">
                        {{ $user->profile_type }}
                    </span>
                    @if($user->is_vendor)
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded ml-2">Verified Partner</span>
                    @endif
                </p>
            </div>
            
            @if($user->profile_type == 'vendor')
                <button class="bg-orange-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-orange-700">
                    + Add New Product
                </button>
            @elseif($user->profile_type == 'dealer')
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">
                    + List New Property
                </button>
            @elseif($user->profile_type == 'service')
                <a href="{{ route('vendor.show', $user->store_slug) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-purple-700">
                    View My Microsite
                </a>
            @endif
        </div>

        @if($user->profile_type == 'customer')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-lg mb-4">My Orders</h3>
                    <p class="text-gray-400 text-sm">No recent orders found.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-lg mb-4">Saved Properties / Wishlist</h3>
                    <p class="text-gray-400 text-sm">Your wishlist is empty.</p>
                </div>
            </div>

        @elseif($user->profile_type == 'vendor')
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h3 class="font-bold text-lg mb-4 border-b pb-2">My Shop Inventory</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase">
                            <tr>
                                <th class="p-3">Product Name</th>
                                <th class="p-3">Price</th>
                                <th class="p-3">Stock</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->products as $product)
                            <tr class="border-b">
                                <td class="p-3 font-medium">{{ $product->name }}</td>
                                <td class="p-3">₹{{ $product->price }}</td>
                                <td class="p-3">{{ $product->stock_quantity }} units</td>
                                <td class="p-3 text-green-600">Active</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($user->products->isEmpty())
                        <div class="text-center py-8 text-gray-400">You haven't added any products yet.</div>
                    @endif
                </div>
            </div>

        @elseif($user->profile_type == 'dealer')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <span class="text-blue-500 text-sm font-bold">Total Properties</span>
                    <p class="text-2xl font-bold text-gray-800">{{ $user->properties->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <span class="text-green-500 text-sm font-bold">Active Leads</span>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-bold text-lg mb-4">My Property Listings</h3>
                @foreach($user->properties as $property)
                    <div class="flex justify-between items-center border-b py-3 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-gray-200 rounded overflow-hidden">
                                @if($property->images) <img src="{{ asset('storage/'.$property->images[0]) }}" class="w-full h-full object-cover"> @endif
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $property->title }}</p>
                                <p class="text-xs text-gray-500">{{ $property->city }}</p>
                            </div>
                        </div>
                        <span class="text-green-600 text-xs font-bold uppercase">{{ $property->type }}</span>
                    </div>
                @endforeach
                @if($user->properties->isEmpty())
                    <p class="text-gray-400 text-sm text-center py-4">No properties listed.</p>
                @endif
            </div>

        @endif

    </div>
</div>