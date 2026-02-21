<div style="width: 100%; height: 100%; background: #fff; font-family: 'Arial Black', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    {{-- Background Collage Layers (Using Percentages to scale with 1600px width) --}}
    <div style="position: absolute; top: 5%; left: 5%; width: 20%; height: 40%; overflow: hidden; border-radius: 4px;">
        <img src="{{ Str::startsWith($data['image_1'] ?? '', ['http', 'data:', 'blob']) ? $data['image_1'] : route('image.proxy', ['path' => $data['image_1'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; bottom: 5%; left: 10%; width: 25%; height: 35%; overflow: hidden; border-radius: 4px;">
        <img src="{{ Str::startsWith($data['image_2'] ?? '', ['http', 'data:', 'blob']) ? $data['image_2'] : route('image.proxy', ['path' => $data['image_2'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; top: 10%; right: 5%; width: 20%; height: 40%; overflow: hidden; border-radius: 4px;">
        <img src="{{ Str::startsWith($data['image_3'] ?? '', ['http', 'data:', 'blob']) ? $data['image_3'] : route('image.proxy', ['path' => $data['image_3'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; bottom: 10%; right: 8%; width: 22%; height: 38%; overflow: hidden; border-radius: 4px;">
        <img src="{{ Str::startsWith($data['image_4'] ?? '', ['http', 'data:', 'blob']) ? $data['image_4'] : route('image.proxy', ['path' => $data['image_4'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Center Content --}}
    <div style="position: relative; z-index: 10; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <span style="font-size: 1.5vw; letter-spacing: 4px; color: #666; font-weight: 700;">UP TO 50% OFF</span>
        <h1 style="font-size: 8vw; margin: 10px 0; line-height: 0.9; color: #111;">FASHION SALE</h1>
        <div style="background: #111; color: #fff; padding: 15px 45px; font-size: 18px; margin-top: 20px; font-family: sans-serif; font-weight: 900;">SHOP NOW</div>
    </div>
</div>