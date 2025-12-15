<div class="min-h-screen">
    
    <div class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-[1400px] mx-auto px-4 py-3 flex items-center gap-6">
            
            <a href="/" class="text-2xl font-bold text-blue-700 flex-shrink-0">
                Soil<span class="text-green-600">N</span>Water
            </a>

            <div class="flex-grow relative">
                <div class="flex">
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search for 'Cement', 'Drill Machine', '3BHK'..." 
                        class="w-full border border-gray-300 rounded-l-md px-4 py-2.5 focus:outline-none focus:border-blue-500 text-sm"
                    >
                    <button class="bg-orange-500 text-white px-8 rounded-r-md font-bold hover:bg-orange-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-6 text-gray-600 text-sm font-medium flex-shrink-0">
                @auth
                    <div class="relative group">
                        <button class="flex flex-col items-center hover:text-blue-600 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold mb-1">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>Account</span>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                            <div class="px-4 py-2 border-b text-xs text-gray-500">
                                Signed in as<br>
                                <span class="font-bold text-gray-900 truncate block">{{ Auth::user()->name }}</span>
                            </div>
                            
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Dashboard</a>
                            
                            <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/admin/login" class="flex flex-col items-center hover:text-blue-600">
                        <i class="fas fa-user text-lg"></i>
                        <span>Login</span>
                    </a>
                @endauth

                <a href="#" class="flex flex-col items-center hover:text-blue-600">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </div>
        </div>

        <div class="border-t border-gray-200">
            <div class="max-w-[1400px] mx-auto px-4 py-2 flex gap-8 text-sm text-gray-700 font-medium overflow-x-auto whitespace-nowrap">
                <a href="#" class="hover:text-blue-600">Safety</a>
                <a href="#" class="hover:text-blue-600">Power Tools</a>
                <a href="#" class="hover:text-blue-600">Pumps & Motors</a>
                <a href="#" class="hover:text-blue-600">Real Estate</a>
                <a href="#" class="hover:text-blue-600">Office Supplies</a>
                <a href="#" class="hover:text-blue-600 text-orange-600">View All Categories</a>
            </div>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 py-6">

        @if(!$search)
        <div class="bg-gray-200 h-64 rounded-lg mb-8 flex items-center justify-center border border-gray-300">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-700">Big Republic Sale</h2>
                <p class="text-gray-500">Up to 60% Off on Construction Materials</p>
            </div>
        </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Best Selling Industrial Products</h2>
            <a href="#" class="text-blue-600 text-sm font-semibold">VIEW ALL</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-12">
            @foreach($products as $product)
                <div class="bg-white border border-gray-200 rounded hover:shadow-lg transition p-4 relative group">
                    
                    <div class="h-40 flex items-center justify-center mb-3">
                        @if($product->images)
                            <img src="{{ asset('storage/' . $product->images[0]) }}" class="max-h-full max-w-full object-contain">
                        @else
                            <div class="text-gray-300"><i class="fas fa-box fa-3x"></i></div>
                        @endif
                    </div>

                    <div class="text-xs text-gray-400 mb-1">{{ $product->brand ?? 'Generic' }}</div>
                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2 h-10 mb-2 leading-snug">
                        {{ $product->name }}
                    </h3>

                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg font-bold text-gray-900">₹{{ number_format($product->price) }}</span>
                        <span class="text-xs text-gray-400 line-through">₹{{ number_format($product->price * 1.2) }}</span>
                        <span class="text-xs text-green-600 font-bold">20% OFF</span>
                    </div>

                    <button class="w-full border border-orange-500 text-orange-500 text-sm font-bold py-1.5 rounded hover:bg-orange-50 transition">
                        ADD TO CART
                    </button>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mb-4 border-t pt-8">
            <h2 class="text-xl font-bold text-gray-800">Featured Properties</h2>
            <a href="#" class="text-blue-600 text-sm font-semibold">VIEW ALL</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($properties as $property)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gray-100 relative">
                         @if($property->images)
                            <img src="{{ asset('storage/' . $property->images[0]) }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute bottom-2 left-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                            {{ $property->type }}
                        </span>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 truncate">{{ $property->title }}</h3>
                        <p class="text-gray-500 text-sm mb-3">📍 {{ $property->city }}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-blue-700">₹{{ number_format($property->price) }}</span>
                            <a href="{{ route('property.show', $property->slug) }}" class="text-orange-600 text-sm font-bold">DETAILS ></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>