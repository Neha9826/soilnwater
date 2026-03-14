<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans antialiased">
    <div class="bg-white border-b border-gray-200 pt-6 pb-4 sticky top-0 z-50">
        <div class="max-w-[1400px] mx-auto px-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xs font-black uppercase tracking-tighter text-gray-900">Used Properties</h1>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Direct User Postings</p>
            </div>
            <div class="flex items-center bg-gray-100 rounded-xl px-4 py-2 w-full md:w-[400px] border border-transparent focus-within:border-green-500 transition-all">
                <i class="fas fa-search text-gray-400 text-xs mr-3"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search location or title..." class="bg-transparent border-none focus:ring-0 text-[11px] font-bold uppercase w-full">
            </div>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 mt-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($properties as $property)
                <a href="{{ route('public.property.detail', $property->id) }}" class="group block bg-white rounded-[1.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative aspect-square overflow-hidden bg-gray-200">
                        @php $images = is_array($property->images) ? $property->images : json_decode($property->images, true); @endphp
                        <img src="{{ route('ad.display', ['path' => $images[0] ?? '']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-4">
                        <h3 class="text-[10px] font-black text-gray-900 uppercase truncate leading-tight">{{ $property->title }}</h3>
                        <p class="text-[8px] font-bold text-gray-400 uppercase mt-1 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-green-500"></i> {{ $property->city }}, {{ $property->state }}
                        </p>
                        <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-[11px] font-black text-green-600">₹{{ number_format($property->price) }}</span>
                            <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <i class="fas fa-arrow-right text-[8px] text-gray-400 group-hover:text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-12">{{ $properties->links() }}</div>
    </div>
</div>