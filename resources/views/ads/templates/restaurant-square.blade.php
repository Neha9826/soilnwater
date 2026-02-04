@props(['data', 'bgColor'])

<div class="w-full h-full relative bg-white flex flex-col font-sans" style="background-color: {{ $bgColor }}">
    
    {{-- TOP IMAGES (The 3 Circles) --}}
    <div class="h-[55%] w-full relative flex items-start justify-center pt-8 bg-gradient-to-b from-black/80 to-transparent">
        
        {{-- Background Image (Optional Blur) --}}
        <div class="absolute inset-0 z-0 opacity-20">
             @if(isset($data['image_2']) && method_exists($data['image_2'], 'temporaryUrl'))
                <img src="{{ $data['image_2']->temporaryUrl() }}" class="w-full h-full object-cover blur-sm">
             @endif
        </div>

        {{-- Left Circle --}}
        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden relative z-10 -mr-6 mt-4 grayscale hover:grayscale-0 transition">
             @if(isset($data['image_1']) && method_exists($data['image_1'], 'temporaryUrl'))
                <img src="{{ $data['image_1']->temporaryUrl() }}" class="w-full h-full object-cover">
             @else <div class="w-full h-full bg-gray-300"></div> @endif
        </div>

        {{-- Center Circle (Big & Front) --}}
        <div class="w-48 h-48 rounded-full border-[6px] border-white shadow-2xl overflow-hidden relative z-20 bg-white">
             @if(isset($data['image_2']) && method_exists($data['image_2'], 'temporaryUrl'))
                <img src="{{ $data['image_2']->temporaryUrl() }}" class="w-full h-full object-cover">
             @else <div class="w-full h-full bg-gray-400"></div> @endif
        </div>

        {{-- Right Circle --}}
        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden relative z-10 -ml-6 mt-4 grayscale hover:grayscale-0 transition">
             @if(isset($data['image_3']) && method_exists($data['image_3'], 'temporaryUrl'))
                <img src="{{ $data['image_3']->temporaryUrl() }}" class="w-full h-full object-cover">
             @else <div class="w-full h-full bg-gray-300"></div> @endif
        </div>
    </div>
    
    {{-- BOTTOM CONTENT (Curved Footer) --}}
    <div class="h-[45%] relative mt-[-40px] pt-12 flex flex-col items-center justify-between pb-0 z-10">
        
        {{-- White Background Curve --}}
        <div class="absolute inset-0 bg-white" style="clip-path: ellipse(120% 100% at 50% 100%); z-index: -1;"></div>

        <div class="text-center px-8">
            <h1 class="text-4xl font-black text-black uppercase tracking-tight mb-2">
                {{ $data['headline'] ?? 'GRAND OPENING' }}
            </h1>
            <p class="text-[11px] text-gray-600 leading-tight max-w-xs mx-auto mb-6">
                {{ $data['subheadline'] ?? 'We’re serving up excitement at the grand opening of our brand-new restaurant spot! Come for the food, stay for the flavor.' }}
            </p>
            
            {{-- Date/Time Box --}}
            <div class="bg-black text-white px-8 py-3 text-xs font-bold uppercase tracking-widest inline-block shadow-lg">
                {{ $data['date'] ?? 'Saturday, 27 June' }} <span class="mx-1 text-gray-500">|</span> {{ $data['time'] ?? '09:00 PM' }}
            </div>
        </div>

        {{-- Footer --}}
        <div class="w-full flex justify-between items-end px-6 pb-6 mt-4 text-[9px] font-bold text-gray-800 opacity-80">
            <div class="flex items-center"><i class="fas fa-map-marker-alt mr-1"></i> {{ $data['address'] ?? '123 Street, City' }}</div>
            <div class="flex items-center"><i class="fas fa-globe mr-1"></i> {{ $data['website'] ?? 'www.website.com' }}</div>
        </div>
        
        {{-- Gold Accents --}}
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-[#C5A059]" style="clip-path: polygon(0 100%, 100% 100%, 0 0);"></div>
        <div class="absolute bottom-0 right-0 w-16 h-16 bg-[#C5A059]" style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"></div>
    </div>
</div>