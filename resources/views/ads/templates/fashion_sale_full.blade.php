<div style="width: 800px; height: 400px; background: #fff; font-family: 'Arial Black', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    {{-- Background Collage Layers --}}
    <div style="position: absolute; top: 20px; left: 20px; width: 140px; height: 200px; overflow: hidden; border-radius: 4px;">
        <img src="{{ $data['image_1'] ?? 'https://placehold.co/140x200' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div style="position: absolute; bottom: 20px; left: 80px; width: 180px; height: 140px; overflow: hidden; border-radius: 4px;">
        <img src="{{ $data['image_2'] ?? 'https://placehold.co/180x140' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div style="position: absolute; top: 40px; right: 20px; width: 140px; height: 180px; overflow: hidden; border-radius: 4px;">
        <img src="{{ $data['image_3'] ?? 'https://placehold.co/140x180' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div style="position: absolute; bottom: 30px; right: 60px; width: 200px; height: 150px; overflow: hidden; border-radius: 4px;">
        <img src="{{ $data['image_4'] ?? 'https://placehold.co/200x150' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Center Content --}}
    <div style="position: relative; z-index: 10; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <span style="font-size: 14px; letter-spacing: 4px; color: #666; font-weight: 700;">UP TO 50% OFF</span>
        <h1 style="font-size: 72px; margin: 10px 0; line-height: 0.9; color: #111;">FASHION<br>SALE</h1>
        <div style="background: #111; color: #fff; padding: 10px 30px; font-size: 14px; margin-top: 20px;">SHOP NOW</div>
        <p style="margin-top: 15px; font-size: 12px; font-family: sans-serif; color: #444;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</p>
    </div>
</div>