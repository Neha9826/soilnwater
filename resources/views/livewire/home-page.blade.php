<div class="min-h-screen">
    
    

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