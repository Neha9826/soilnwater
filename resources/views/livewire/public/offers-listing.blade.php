<div class="min-h-screen bg-orange-50/30 pb-20">
    <div class="bg-white border-b border-orange-100 py-10 mb-10">
        <div class="max-w-[1440px] mx-auto px-6">
            <h1 class="text-4xl font-black text-gray-900 uppercase italic"><i class="fas fa-fire text-orange-500"></i> Hot Offers</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest mt-2">Exclusive Deals & Industrial Vouchers</p>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($offers as $offer)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-orange-100 flex flex-col group relative">
                    <div class="h-40 bg-orange-50 flex items-center justify-center p-6 border-b border-dashed border-orange-200">
                        <div class="text-center">
                            <span class="text-4xl font-black text-orange-600 uppercase">{{ $offer->discount_percentage }}%</span>
                            <p class="text-[10px] font-black text-orange-400 tracking-tighter uppercase">OFF YOUR PURCHASE</p>
                        </div>
                    </div>
                    <div class="p-6 flex-grow">
                        <h3 class="font-black text-gray-900 uppercase truncate mb-2">{{ $offer->title }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 line-clamp-2 mb-4 uppercase">{{ $offer->description }}</p>
                        <div class="flex justify-between items-center text-[10px] font-black">
                            <span class="text-gray-400">EXPIRES: {{ $offer->expires_at?->format('d M Y') ?? 'LTD TIME' }}</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg">CLAIM DEAL</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">{{ $offers->links() }}</div>
    </div>
</div>