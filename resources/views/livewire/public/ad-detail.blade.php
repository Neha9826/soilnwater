<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans antialiased">
    <div class="bg-white border-b border-gray-200 py-3 shadow-sm mb-6">
        <div class="max-w-[1100px] mx-auto px-4">
            <nav class="flex text-[10px] font-black uppercase tracking-tight text-gray-400">
                <a href="/" class="hover:text-green-600">Home</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="/promotions" class="hover:text-green-600">Promotions</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900">{{ $ad->title }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-[1100px] mx-auto px-4">
        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            {{-- Media Column (65%) --}}
            <div style="flex: 0 0 65%; max-width: 65%;" class="space-y-6">
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-200 p-2">
                    @php
                        // Dynamically set detail view ratio based on ad ratio
                        $detailRatio = 'aspect-square'; 
                        if($ad->aspect_ratio === '9:16') $detailRatio = 'aspect-[9/16] max-h-[800px] mx-auto';
                        if($ad->aspect_ratio === '16:9') $detailRatio = 'aspect-[16/9]';
                    @endphp
                    <div class="{{ $detailRatio }} rounded-[2rem] overflow-hidden">
                        <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            {{-- Info Column (35%) --}}
            <div style="flex: 0 0 32%; max-width: 32%; position: sticky; top: 20px;">
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl">
                    <span class="bg-gray-900 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase mb-4 inline-block tracking-widest">Sponsored</span>
                    <h1 class="text-2xl font-black text-gray-900 uppercase leading-tight mb-4">{{ $ad->title }}</h1>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-tight leading-relaxed mb-8">
                        Discover this exclusive offer from our verified marketplace partners.
                    </p>

                    <div class="space-y-3">
                        <button class="w-full bg-green-600 text-white font-black py-4 rounded-2xl uppercase text-[10px] hover:bg-gray-900 transition shadow-lg">Contact Advertiser</button>
                        <button class="w-full border-2 border-gray-100 text-gray-900 font-black py-4 rounded-2xl uppercase text-[10px] hover:bg-gray-50 transition">Save for Later</button>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-50 text-center">
                        <p class="text-[8px] font-black text-gray-300 uppercase mb-2">Campaign Category</p>
                        <span class="text-[10px] font-bold text-gray-700 uppercase">{{ $ad->category ?? 'General Promotion' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  