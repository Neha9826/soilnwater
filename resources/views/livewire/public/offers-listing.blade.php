<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans antialiased">
    <div class="bg-white border-b border-gray-200 pt-6 pb-4 sticky top-0 z-50">
        <div class="max-w-[1400px] mx-auto px-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xs font-black uppercase tracking-tighter text-gray-900">Marketplace Offers</h1>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Exclusive Discounts</p>
            </div>
            <div class="flex items-center bg-gray-100 rounded-xl px-4 py-2 w-full md:w-[400px] border border-transparent focus-within:border-green-500 transition-all">
                <i class="fas fa-search text-gray-400 text-xs mr-3"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search offers..." class="bg-transparent border-none focus:ring-0 text-[11px] font-bold uppercase w-full">
            </div>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 mt-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($offers as $offer)
                <div class="group block bg-white rounded-[1.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative aspect-square overflow-hidden bg-gray-200">
                        <img src="{{ route('ad.display', ['path' => $offer->preview_image]) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-[10px] font-black text-gray-900 uppercase truncate leading-tight">{{ $offer->name }}</h3>
                        <p class="text-[8px] font-bold text-gray-400 uppercase mt-1">Limited Time Deal</p>
                        <button class="w-full mt-4 bg-gray-900 text-white text-[8px] font-black py-2 rounded-lg uppercase group-hover:bg-green-600 transition">Claim Offer</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">{{ $offers->links() }}</div>
    </div>
</div>