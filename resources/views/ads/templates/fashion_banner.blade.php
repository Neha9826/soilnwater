<div style="width: 800px; height: 200px; background: #fdfaf5; font-family: 'Playfair Display', serif; position: relative; overflow: hidden; border: 1px solid #eee; display: flex;">
    {{-- Left Content --}}
    <div style="width: 50%; display: flex; flex-direction: column; justify-content: center; padding-left: 60px;">
        <h1 style="margin: 0; font-size: 48px; line-height: 1; color: #222; letter-spacing: -1px;">FASHION<br>COLLECTION</h1>
        <p style="font-size: 12px; margin: 15px 0; font-family: sans-serif; font-weight: 700; color: #666; letter-spacing: 1px;">ENJOY BIG DISCOUNT AND FANTASTIC DEALS</p>
        <div style="font-size: 13px; font-family: sans-serif; border-bottom: 2px solid #222; display: inline-block; padding-bottom: 3px; width: fit-content;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
    </div>

    {{-- Right: Slanted Grid --}}
    <div style="width: 50%; height: 100%; position: relative; transform: rotate(-15deg) translateY(-20px);">
        <div style="display: grid; grid-template-columns: repeat(3, 100px); gap: 15px;">
            @foreach(['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6'] as $key)
                <div style="width: 100px; height: 100px; background: #ddd; border-radius: 15px; overflow: hidden;">
                    <img src="{{ $data[$key] ?? 'https://placehold.co/100x100' }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endforeach
        </div>
    </div>
</div>