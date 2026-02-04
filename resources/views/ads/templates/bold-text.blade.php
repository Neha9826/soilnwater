@props(['data', 'bgColor'])

<div class="w-full h-full flex flex-col justify-center p-8 text-center border-4 border-black" style="background-color: {{ $bgColor }}">
    
    <h1 class="text-4xl font-black text-black uppercase leading-tight mb-4">
        {{ $data['headline'] ?? 'BIG SALE' }}
    </h1>

    <p class="text-xl text-gray-800 font-bold mb-6">
        {{ $data['subheadline'] ?? 'Limited time offer' }}
    </p>

    <div class="bg-black text-white p-4 rounded-lg inline-block mx-auto mb-6">
        <p class="text-lg font-bold">{{ $data['phone'] ?? '+91 000 000 0000' }}</p>
    </div>

    @if(!empty($data['cta_text']))
        <div class="text-sm font-bold underline cursor-pointer">
            {{ $data['cta_text'] }}
        </div>
    @endif
</div>