<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8">Stays in Dehradun</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($hotels as $hotel)
            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 group">
                <div class="h-56 bg-gray-200 relative overflow-hidden">
                     @if($hotel->images)
                        <img src="{{ $hotel->images ? route('ad.display', ['filename' => basename($hotel->images[0])]) : asset('images/placeholder.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @endif
                    <span class="absolute top-3 right-3 bg-white px-2 py-1 text-xs font-bold rounded shadow">
                        ⭐ {{ $hotel->star_rating }}/5
                    </span>
                </div>
                
                <div class="p-5">
                    <span class="text-xs font-bold text-blue-600 uppercase">{{ $hotel->type }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $hotel->name }}</h3>
                    <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $hotel->description }}</p>
                    
                    <div class="flex gap-3 mt-4 text-gray-400 text-sm">
                        @if(in_array('wifi', $hotel->amenities ?? [])) <i class="fas fa-wifi" title="WiFi"></i> @endif
                        @if(in_array('pool', $hotel->amenities ?? [])) <i class="fas fa-swimming-pool" title="Pool"></i> @endif
                        @if(in_array('parking', $hotel->amenities ?? [])) <i class="fas fa-parking" title="Parking"></i> @endif
                    </div>
                    
                    <div class="flex justify-between items-end mt-6 border-t pt-4">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">₹{{ number_format($hotel->price_per_night) }}</span>
                            <span class="text-xs text-gray-500">/ night</span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>