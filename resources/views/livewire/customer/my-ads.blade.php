<div class="w-full bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">My Ads</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your professional template promotions.</p>
            </div>
            <a href="{{ route('customer.ad.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Create New Ad
            </a>
        </div>

        <div class="min-h-[400px]">
            @if($ads->count() > 0)
               {{-- Master Container: 4 Columns --}}
{{-- Reduced auto-rows to 280px for a more compact 'at a glance' view --}}
<div style="display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            grid-auto-flow: dense; 
            gap: 15px; 
            grid-auto-rows: 280px;" 
     class="w-full p-4">
     
    @foreach($ads as $ad)
        @php
            $w = (int)($ad->template->tier->grid_width ?? 1);
            $h = (int)($ad->template->tier->grid_height ?? 1);

            // Inline CSS to force the correct spans across all shapes
            $gridItemStyle = "grid-column: span {$w}; grid-row: span {$h};";
            $imageFilename = $ad->preview_image ? basename($ad->preview_image) : null;
        @endphp

        <div style="{{ $gridItemStyle }}" class="relative group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($imageFilename)
                <img src="{{ route('ad.display', ['filename' => $imageFilename]) }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-50 flex items-center justify-center text-[10px] font-bold text-gray-400">
                    Ratio {{ $w }}:{{ $h }}
                </div>
            @endif
        </div>
    @endforeach
</div>
                <div class="mt-8">{{ $ads->links() }}</div>
            @else
                {{-- EMPTY STATE (Kept as is) --}}
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <i class="fas fa-bullhorn text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900">No Ads Found</h3>
                </div>
            @endif
        </div>
    </div>
</div>