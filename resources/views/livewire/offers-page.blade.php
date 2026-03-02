<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-black text-gray-900 mb-4">Latest Offers & Deals</h1>
            <p class="text-gray-500 text-lg">Grab the best discounts from our verified vendors</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($offers as $offer)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden group border border-gray-100 transition hover:shadow-2xl">
                    <div class="relative h-56">
                        <img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 left-4 bg-red-600 text-white font-black px-4 py-1 rounded-full text-sm shadow-lg">
                            {{ $offer->discount_tag }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $offer->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $offer->description }}</p>
                        
                        @if($offer->coupon_code)
                            <div class="bg-blue-50 border-2 border-dashed border-blue-200 p-3 text-center rounded-2xl mb-4">
                                <span class="text-[10px] uppercase font-bold text-blue-400 block">Copy Coupon Code</span>
                                <div class="text-lg font-mono font-black text-blue-700 tracking-widest">{{ $offer->coupon_code }}</div>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <span>Ends: {{ $offer->valid_until ? \Carbon\Carbon::parse($offer->valid_until)->format('d M') : 'Limited Time' }}</span>
                            <span class="text-blue-600">Verified Deal</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <i class="fas fa-percentage text-6xl text-gray-200 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-400">No active offers at the moment.</h2>
                </div>
            @endforelse
        </div>
    </div>
</div>