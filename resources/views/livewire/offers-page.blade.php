<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-red-600">🔥 Exclusive Offers</h1>
        <p class="text-gray-500 mt-2">Grab the best deals on Construction Materials & Services</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($offers as $offer)
            <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden relative transform hover:-translate-y-1 transition duration-300">
                
                <div class="absolute top-0 right-0 bg-red-600 text-white font-bold px-4 py-2 rounded-bl-xl z-10">
                    {{ $offer->discount_tag }}
                </div>

                <div class="h-48 bg-gray-100">
                    @if($offer->image)
                        <img src="{{ asset('storage/' . $offer->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-100">
                            <span class="text-4xl">🎁</span>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $offer->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $offer->description }}</p>

                    @if($offer->coupon_code)
                        <div class="bg-gray-100 border border-dashed border-gray-400 rounded-lg p-3 flex justify-between items-center">
                            <span class="font-mono font-bold text-gray-700 tracking-wider">{{ $offer->coupon_code }}</span>
                            <button class="text-xs text-blue-600 font-bold uppercase hover:text-blue-800">Copy Code</button>
                        </div>
                    @endif

                    @if($offer->valid_until)
                        <p class="text-xs text-red-500 mt-4 font-semibold">
                            ⏳ Valid until {{ $offer->valid_until->format('d M, Y') }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>