<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans antialiased">
    {{-- 1. Slim Navigation Bar --}}
    <div class="bg-white border-b border-gray-200 py-2 shadow-sm mb-6">
        <div class="max-w-[1100px] mx-auto px-4 flex justify-between items-center">
            <nav class="flex text-[10px] font-bold uppercase tracking-tight text-gray-400">
                <a href="/" class="hover:text-green-600">Home</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-700 truncate max-w-[200px]">{{ $property->title }}</span>
            </nav>
            <span class="text-[9px] font-bold text-gray-400 border px-2 py-0.5 rounded">ID: #PRO-{{ $property->id }}</span>
        </div>
    </div>

    {{-- 2. MAIN CONTENT AREA --}}
    <div class="max-w-[1100px] mx-auto px-4">
        {{-- FORCED FLEX ROW --}}
        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            {{-- LEFT COLUMN: Media & Details (65%) --}}
            <div style="flex: 0 0 65%; max-width: 65%;" class="space-y-6">
                @php 
                    $images = is_array($property->images) ? $property->images : json_decode($property->images, true);
                    $images = $images ?: [];
                @endphp

                <div x-data="{ active: 0 }">
                    {{-- SQUARE IMAGE RATIO (1:1) --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 aspect-square">
                        @if(count($images) > 0)
                            <img :src="'{{ route('ad.display') }}?path=' + {{ json_encode($images) }}[active]" 
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    <div class="flex gap-2 mt-4 overflow-x-auto pb-1">
                        @foreach($images as $index => $path)
                            <button @click="active = {{ $index }}" 
                                    :class="active === {{ $index }} ? 'ring-2 ring-green-600' : 'opacity-60'"
                                    class="w-16 h-16 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0">
                                <img src="{{ route('ad.display', ['path' => $path]) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Property Overview --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4 border-b pb-3">Property Overview</h2>
                    <div class="text-gray-600 text-[12px] leading-relaxed mb-8">
                        {!! nl2br(e($property->description)) !!}
                    </div>

                    {{-- AMENITIES MOVED HERE --}}
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4 border-b pb-3">Key Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($property->amenities as $amenity)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500 text-[9px]"></i>
                                <span class="text-[10px] font-bold text-gray-700 uppercase">{{ $amenity->name }}</span>
                            </div>
                        @empty
                            <p class="text-[10px] text-gray-400 italic">No amenities listed.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Sticky Price & CTA (35%) --}}
            <div style="flex: 0 0 32%; max-width: 32%; position: sticky; top: 20px;" class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xl">
                    <div class="mb-6">
                        <span class="bg-blue-600 text-white text-[8px] font-black px-2 py-0.5 rounded uppercase inline-block mb-3">Verified Builder</span>
                        <h1 class="text-base font-black text-gray-900 uppercase leading-none mb-2">{{ $property->title }}</h1>
                        <p class="text-[9px] font-bold text-gray-400 uppercase flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-green-500"></i> {{ $property->location }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                        <p class="text-[8px] font-black text-gray-400 uppercase mb-0.5">Price Range</p>
                        <span class="text-2xl font-black text-green-600 tracking-tighter">₹{{ number_format($property->price) }}</span>
                    </div>

                    <div class="flex flex-col gap-2 mb-8">
                        <button class="w-full bg-gray-900 text-white font-black py-4 rounded-xl uppercase text-[10px] hover:bg-green-600 transition shadow-md">Inquire Now</button>
                        <button class="w-full border border-gray-200 text-gray-900 font-black py-4 rounded-xl uppercase text-[10px] hover:bg-gray-50 transition">Save Property</button>
                    </div>

                    {{-- Listing Stats --}}
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-100 text-[9px] font-bold uppercase">
                        <div>
                            <span class="text-gray-300 text-[8px] block mb-1">Posted By</span>
                            <span class="text-gray-900 truncate">{{ $property->user->name ?? 'Builder' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-300 text-[8px] block mb-1">Property Type</span>
                            <span class="text-gray-900">Residential</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>