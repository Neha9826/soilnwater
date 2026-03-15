<div class="w-full bg-gray-50 min-h-screen pb-20 font-sans antialiased">
    {{-- Smart Action Bar --}}
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm mb-8">
        <div class="max-w-[1536px] mx-auto px-6 h-20 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Promotions</h1>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Live Brand Campaigns</p>
            </div>
            <button wire:click="toggleFilters" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl font-black text-[10px] uppercase">
                <i class="fas fa-search mr-2"></i> {{ $showFilters ? 'Hide' : 'Search' }}
            </button>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        @if($ads->count() > 0)
            {{-- THE EXACT GRID --}}
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-flow: dense; gap: 15px; grid-auto-rows: 280px;" class="w-full p-4">
                @foreach($ads as $ad)
                    @php
                        $w = (int)($ad->template->tier->grid_width ?? 1);
                        $h = (int)($ad->template->tier->grid_height ?? 1);
                        $gridItemStyle = "grid-column: span {$w}; grid-row: span {$h};";
                        
                        // FIX: Use full path instead of basename to match ad.display route
                        $imagePath = $ad->preview_image; 
                    @endphp

                    <div style="{{ $gridItemStyle }}" class="relative group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <a href="{{ route('public.ad.detail', $ad->id) }}" class="block w-full h-full relative">
                            @if($imagePath)
                                {{-- Use 'path' parameter to match your route definition --}}
                                <img src="{{ route('ad.display', ['path' => $imagePath]) }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    loading="lazy"
                                    alt="{{ $ad->title }}">
                            @else
                                <div class="w-full h-full bg-gray-50 flex items-center justify-center text-[10px] font-bold text-gray-400">
                                    No Preview
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- INFINITE SCROLL TRIGGER --}}
            <div x-data="{
                observe() {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadMore')
                            }
                        })
                    }, { threshold: 0.1 });
                    observer.observe(this.$el);
                }
            }" x-init="observe()" class="h-10 w-full flex items-center justify-center mt-10">
                <div wire:loading class="text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <i class="fas fa-spinner fa-spin mr-2"></i> Loading More Promotions...
                </div>
            </div>

        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 uppercase">No Ads Found</h3>
            </div>
        @endif
    </div>
</div>