<div class="flex w-full h-full" style="background-color: {{ $bg_color ?? '#ffffff' }};">
    {{-- Image Side (50% Width) --}}
    <div class="w-1/2 h-full overflow-hidden">
        @if(isset($data['main_image']))
            <img src="{{ asset('storage/' . $data['main_image']) }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                <i class="fas fa-image text-5xl"></i>
            </div>
        @endif
    </div>

    {{-- Content Side (50% Width) --}}
    <div class="w-1/2 p-6 flex flex-col justify-center">
        <h2 class="text-2xl font-black text-gray-900 leading-tight uppercase">
            {{ $data['headline'] ?? 'Your Headline Here' }}
        </h2>
        
        <p class="text-sm text-gray-600 mt-2 line-clamp-3">
            {{ $data['description'] ?? 'Add a compelling description for your business or offer here.' }}
        </p>

        <div class="mt-4 flex items-center gap-2">
            <div class="bg-red-600 text-white px-3 py-1 font-bold rounded-md">
                {{ $data['cta_text'] ?? 'BOOK NOW' }}
            </div>
            @if(isset($data['price']))
                <span class="text-lg font-bold text-gray-800">₹{{ $data['price'] }}</span>
            @endif
        </div>

        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            <i class="fas fa-map-marker-alt text-red-500"></i>
            {{ $data['location'] ?? 'Anywhere St., Any City' }}
        </div>
    </div>
</div>