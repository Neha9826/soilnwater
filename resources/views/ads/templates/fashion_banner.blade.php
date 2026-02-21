<div style="width: 100%; height: 100%; background: #fdfaf5; font-family: 'Playfair Display', serif; position: relative; overflow: hidden; border: 1px solid #eee; display: flex;">
    {{-- Left Content: Scaled Typography --}}
    <div style="width: 50%; display: flex; flex-direction: column; justify-content: center; padding-left: 5%;">
        <h1 style="margin: 0; font-size: 5vw; line-height: 1; color: #222; letter-spacing: -1px;">FASHION<br>COLLECTION</h1>
        <p style="font-size: 1.1vw; margin: 15px 0; font-family: sans-serif; font-weight: 700; color: #666; letter-spacing: 1px;">ENJOY BIG DISCOUNT AND FANTASTIC DEALS</p>
        <div style="font-size: 1.2vw; font-family: sans-serif; border-bottom: 2px solid #222; display: inline-block; padding-bottom: 3px; width: fit-content;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
    </div>

    {{-- Right: Fluid Slanted Grid --}}
    <div style="width: 50%; height: 100%; position: relative; transform: rotate(-15deg) translateY(-5%);">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; width: 100%; height: 120%;">
            @foreach(['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6'] as $key)
                <div style="width: 100%; aspect-ratio: 1; background: #ddd; border-radius: 15px; overflow: hidden;">
                    <img src="{{ !empty($data[$key]) ? (Str::startsWith($data[$key], ['http', 'data:', 'blob']) ? $data[$key] : route('image.proxy', ['path' => $data[$key]])) : 'https://placehold.co/200x200' }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endforeach
        </div>
    </div>
</div>