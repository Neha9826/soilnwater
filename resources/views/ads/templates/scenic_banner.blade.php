<div style="width: 100%; height: 100%; background: #fff; font-family: 'Montserrat', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    {{-- Background Center --}}
    <div style="position: absolute; inset: 0; z-index: 1; opacity: 0.2;">
        <img src="{{ !empty($data['image_bg']) ? (Str::startsWith($data['image_bg'], ['http', 'data:', 'blob']) ? $data['image_bg'] : route('image.proxy', ['path' => $data['image_bg']])) : 'https://placehold.co/1600x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Left & Right Curves (Kept absolute but scaled up for banner) --}}
    <div style="position: absolute; left: -80px; top: -20px; width: 350px; height: 350px; border-radius: 50%; border: 12px solid #fff; overflow: hidden; z-index: 5;">
        <img src="{{ !empty($data['image_left']) ? (Str::startsWith($data['image_left'], ['http', 'data:', 'blob']) ? $data['image_left'] : route('image.proxy', ['path' => $data['image_left']])) : 'https://placehold.co/400x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; right: -80px; top: -20px; width: 350px; height: 350px; border-radius: 50%; border: 12px solid #fff; overflow: hidden; z-index: 5;">
        <img src="{{ !empty($data['image_right']) ? (Str::startsWith($data['image_right'], ['http', 'data:', 'blob']) ? $data['image_right'] : route('image.proxy', ['path' => $data['image_right']])) : 'https://placehold.co/400x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Center Content (Using percentage padding for 4-column span) --}}
    <div style="position: relative; z-index: 10; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0 25%;">
        <h2 style="margin: 0; font-size: 4vw; font-weight: 900; color: #111;">TRAVEL THE WORLD</h2>
        <p style="font-size: 1.2vw; margin: 15px 0; color: #444; line-height: 1.4;">{{ $data['description'] ?? 'Explore hidden gems and beautiful landscapes with our tours.' }}</p>
    </div>
</div>