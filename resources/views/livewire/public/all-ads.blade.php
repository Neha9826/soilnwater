<div class="max-w-[1440px] mx-auto py-12 px-6">
    <h1 class="text-4xl font-black text-gray-900 mb-10">All Promotions & Offers</h1>

    {{-- Unlimited Grid --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-flow: dense; gap: 24px; grid-auto-rows: 280px;">
        @foreach($ads as $ad)
            @php
                $w = (int)($ad->template->tier->grid_width ?? 1);
                $h = (int)($ad->template->tier->grid_height ?? 1);
                $style = "grid-column: span {$w}; grid-row: span {$h};";
            @endphp
            <div style="{{ $style }}" class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 group">
                <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
            </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $ads->links() }}
    </div>
</div>