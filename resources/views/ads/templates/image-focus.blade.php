@props(['data', 'bgColor'])

<div class="w-full h-full flex flex-col p-6" style="background-color: {{ $bgColor }}">
    {{-- Main Image Area --}}
    <div class="w-full flex-grow bg-gray-200 rounded-lg overflow-hidden mb-4 relative">
        @if(isset($data['image']) && method_exists($data['image'], 'temporaryUrl'))
            <img src="{{ $data['image']->temporaryUrl() }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <i class="fas fa-image text-4xl"></i>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $data['headline'] ?? 'Your Headline Here' }}</h2>
        
        @if(!empty($data['cta_text']))
            <button class="bg-black text-white px-6 py-2 rounded-full font-bold text-sm mt-2">
                {{ $data['cta_text'] }}
            </button>
        @endif
    </div>
</div>