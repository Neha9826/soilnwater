@props(['data', 'bgColor'])

<div class="w-full h-full relative flex overflow-hidden font-sans" style="background-color: {{ $bgColor }}">
    {{-- Left Content --}}
    <div class="w-[45%] h-full flex flex-col justify-center pl-8 pr-2 z-10 relative">
        <h3 class="text-4xl font-thin uppercase tracking-[0.1em] text-slate-700 leading-none mb-0">{{ $data['headline'] ?? 'MODERN' }}</h3>
        <h1 class="text-6xl font-normal font-serif italic text-slate-800 mb-4 leading-none -ml-1">{{ $data['subheadline'] ?? 'Furniture' }}</h1>
        <p class="text-[11px] text-slate-500 mb-6 leading-relaxed font-medium pr-4">{{ $data['description'] ?? 'Refresh a single room or revamp your entire home.' }}</p>
        
        <div class="mb-10">
            <span class="bg-[#37474F] text-white text-[10px] font-bold py-3 px-8 rounded-sm shadow-lg uppercase tracking-widest">{{ $data['cta_text'] ?? 'SHOP NOW' }}</span>
        </div>

        {{-- Dynamic Contact Info --}}
        <div class="text-[10px] font-bold text-slate-600 space-y-2 border-l-2 border-slate-300 pl-4">
            <div class="flex items-center gap-2"><i class="fas fa-phone-alt text-slate-400"></i> {{ $data['phone'] ?? '+123-456-7890' }}</div>
            <div class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-slate-400"></i> {{ $data['address'] ?? '123 Anywhere St.' }}</div>
            <div class="flex items-center gap-2"><i class="fas fa-globe text-slate-400"></i> {{ $data['website'] ?? 'www.website.com' }}</div>
        </div>
    </div>

    {{-- Right Image --}}
    <div class="absolute top-0 right-0 w-[60%] h-full">
        <div class="w-full h-full relative">
            <div class="absolute inset-0 bg-slate-200 z-0 overflow-hidden" style="clip-path: ellipse(150% 100% at 100% 50%); border-left: 15px solid white;">
                @if(isset($data['image']) && is_object($data['image']) && method_exists($data['image'], 'temporaryUrl'))
                    <img src="{{ $data['image']->temporaryUrl() }}" class="w-full h-full object-cover">
                @elseif(isset($data['image']) && is_string($data['image']) && !empty($data['image']))
                    <img src="{{ asset('storage/'.$data['image']) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400"><i class="fas fa-couch text-6xl opacity-20"></i></div>
                @endif
            </div>
            <div class="absolute top-12 right-12 z-30 bg-[#37474F] text-white w-24 h-24 rounded-full flex flex-col items-center justify-center border-[5px] border-white shadow-2xl">
                <span class="text-2xl font-serif italic font-bold leading-none">50%</span><span class="text-[10px] uppercase tracking-widest mt-1">OFF</span>
            </div>
        </div>
    </div>
</div>