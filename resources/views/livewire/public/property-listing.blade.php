<div class="min-h-screen bg-gray-50 pb-20">
    <div class="bg-white border-b border-gray-200 py-10 mb-10">
        <div class="max-w-[1440px] mx-auto px-6">
            <h1 class="text-4xl font-black text-gray-900 uppercase">Property Classifieds</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest mt-2">Direct User Listings & Resale</p>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-6 flex gap-8">
        <aside class="w-1/4 hidden lg:block sticky top-28 h-fit">
            <input type="text" wire:model.live="search" placeholder="Search locations..." class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-4 text-xs font-bold shadow-sm">
        </aside>

        <main class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div class="bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition flex flex-col group">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ route('ad.display', ['path' => $property->thumbnail]) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-black text-gray-900 truncate uppercase mb-1">{{ $property->title }}</h3>
                        <p class="text-[9px] font-bold text-gray-400 mb-4 uppercase"><i class="fas fa-map-marker-alt"></i> {{ $property->location }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-black text-leaf-green">₹{{ number_format($property->price) }}</span>
                            <a href="{{ route('public.property.detail', $property->id) }}" class="text-[9px] font-black bg-gray-900 text-white px-4 py-2 rounded-full">VIEW</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </main>
    </div>
</div>