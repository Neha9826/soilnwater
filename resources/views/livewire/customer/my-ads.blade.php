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
                {{-- Standardize on a 4-column base. auto-rows ensures '1 unit' is exactly 180px --}}
<div class="grid grid-cols-2 md:grid-cols-4 grid-flow-dense gap-6 p-4 auto-rows-[180px]">
    @foreach($ads as $ad)
        @php
            // Pull units directly from the Tier table
            $w = $ad->template->tier->grid_width ?? 1;
            $h = $ad->template->tier->grid_height ?? 1;

            // Generate specific span classes to prevent 'Banner-to-Rectangle' distortion
            // Banner (4x1) will take up all 4 columns but only 1 row.
            // Full Page (4x2) will take up all 4 columns and 2 full rows.
            $colSpan = "col-span-{$w}";
            $rowSpan = "row-span-{$h}";
            
            // Mobile safety: Ensure wide ads don't exceed the 2-column mobile grid
            $mobileCol = ($w > 2) ? 'col-span-2' : "col-span-{$w}";
        @endphp

        <div class="{{ $mobileCol }} md:{{ $colSpan }} {{ $rowSpan }} relative group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Use the generated design image. object-cover ensures it fills the calculated box --}}
            <img src="{{ asset('storage/' . $ad->preview_image) }}" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                 alt="Ad Design">

            {{-- Action Overlay --}}
            <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <button class="bg-white text-gray-900 px-5 py-2 rounded-xl font-bold text-xs shadow-lg uppercase tracking-wider">
                    Edit Ad
                </button>
            </div>
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