<div style="width: 100%; height: 100%; background: #fff; font-family: 'Montserrat', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    {{-- Background Center --}}
    <div style="position: absolute; inset: 0; z-index: 1; opacity: 0.2;">
        <img src="{{ !empty($data['image_bg']) ? (Str::startsWith($data['image_bg'], ['http', 'data:', 'blob']) ? $data['image_bg'] : route('image.proxy', ['path' => $data['image_bg']])) : 'https://placehold.co/800x200' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Left Curve --}}
    <div style="position: absolute; left: -50px; top: -10px; width: 220px; height: 220px; border-radius: 50%; border: 8px solid #fff; overflow: hidden; z-index: 5;">
        <img src="{{ !empty($data['image_left']) ? (Str::startsWith($data['image_left'], ['http', 'data:', 'blob']) ? $data['image_left'] : route('image.proxy', ['path' => $data['image_left']])) : 'https://placehold.co/220x220' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Right Curve --}}
    <div style="position: absolute; right: -50px; top: -10px; width: 220px; height: 220px; border-radius: 50%; border: 8px solid #fff; overflow: hidden; z-index: 5;">
        <img src="{{ !empty($data['image_right']) ? (Str::startsWith($data['image_right'], ['http', 'data:', 'blob']) ? $data['image_right'] : route('image.proxy', ['path' => $data['image_right']])) : 'https://placehold.co/220x220' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Center Content --}}
    <div style="position: relative; z-index: 10; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0 180px;">
        <h2 style="margin: 0; font-size: 32px; font-weight: 900; color: #111;">TRAVEL THE WORLD</h2>
        <p style="font-size: 11px; margin: 10px 0; color: #444; line-height: 1.4;">{{ $data['description'] ?? 'Explore hidden gems and beautiful landscapes with our tours.' }}</p>
        <div style="font-size: 12px; font-weight: 700; color: #2c5266;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
    </div>
</div>