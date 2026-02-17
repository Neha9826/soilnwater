<div style="width: 800px; height: 400px; background: {{ $data['bg_color'] ?? '#faddba' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd; display: flex;">
    
    {{-- Background Grid Texture --}}
    <div style="position: absolute; inset: 0; opacity: 0.1; pointer-events: none; background-image: radial-gradient(#d1d1d1 1px, transparent 1px); background-size: 20px 20px;"></div>

    {{-- Left Side: The 5-Circle Cloud Gallery (Shifted Left to avoid overlap) --}}
    <div style="width: 50%; height: 100%; position: relative; z-index: 5;">
        
        {{-- Circle: Top Left --}}
        <div style="position: absolute; top: 15px; left: 40px; width: 130px; height: 130px; border-radius: 50%; border: 6px solid #fff; overflow: hidden; z-index: 2; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            <img src="{{ !empty($data['image_2']) ? (Str::startsWith($data['image_2'], ['http', 'blob']) ? $data['image_2'] : asset('storage/' . $data['image_2'])) : 'https://placehold.co/200x200?text=Top+Left' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        {{-- Circle: Main Center --}}
        <div style="position: absolute; top: 50px; left: 140px; width: 250px; height: 250px; border-radius: 50%; border: 10px solid #fff; overflow: hidden; z-index: 5; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
            <img src="{{ !empty($data['image_1']) ? (Str::startsWith($data['image_1'], ['http', 'blob']) ? $data['image_1'] : asset('storage/' . $data['image_1'])) : 'https://placehold.co/400x400?text=Main+Gallery' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        {{-- Circle: Bottom Left --}}
        <div style="position: absolute; bottom: 15px; left: 20px; width: 170px; height: 170px; border-radius: 50%; border: 7px solid #fff; overflow: hidden; z-index: 3; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            <img src="{{ !empty($data['image_3']) ? (Str::startsWith($data['image_3'], ['http', 'blob']) ? $data['image_3'] : asset('storage/' . $data['image_3'])) : 'https://placehold.co/300x300?text=Bottom+Left' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        {{-- Circle: Right Top (Shifted left to clear text area) --}}
        <div style="position: absolute; top: 20px; left: 360px; width: 150px; height: 150px; border-radius: 50%; border: 6px solid #fff; overflow: hidden; z-index: 2; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            <img src="{{ !empty($data['image_4']) ? (Str::startsWith($data['image_4'], ['http', 'blob']) ? $data['image_4'] : asset('storage/' . $data['image_4'])) : 'https://placehold.co/200x200?text=Right+Top' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        {{-- Circle: Bottom Center --}}
        <div style="position: absolute; bottom: 40px; left: 300px; width: 120px; height: 120px; border-radius: 50%; border: 5px solid #fff; overflow: hidden; z-index: 4; box-shadow: 0 8px 15px rgba(0,0,0,0.1);">
            <img src="{{ !empty($data['image_5']) ? (Str::startsWith($data['image_5'], ['http', 'blob']) ? $data['image_5'] : asset('storage/' . $data['image_5'])) : 'https://placehold.co/200x200?text=Detail' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- Right Side: Content (Higher z-index to stay on top) --}}
    <div style="width: 50%; padding: 0 60px 0 0; display: flex; flex-direction: column; justify-content: center; text-align: right; position: relative; z-index: 10;">
        <h1 style="margin: 0; font-size: 48px; font-weight: 800; line-height: 0.9; color: #1a1a1a; text-transform: uppercase; letter-spacing: 2px;">
            {{ $data['title_top'] ?? 'DESIGN' }}<br>
            <span style="font-weight: 300; letter-spacing: 6px; color: #444;">{{ $data['title_bottom'] ?? 'INTERIOR' }}</span>
        </h1>

        <div style="height: 3px; background: #1a1a1a; width: 80px; margin: 30px 0 30px auto;"></div>

        <p style="font-size: 13px; color: #666; font-weight: 500; line-height: 1.6; margin: 0 0 40px auto; max-width: 220px;">
            {{ $data['description'] ?? 'Modern interior solutions for your luxury home and office spaces.' }}
        </p>

        {{-- Contact Block --}}
        <div style="font-size: 11px; color: #222; font-weight: 700; line-height: 1.8;">
            <div>📍 {{ $data['address'] ?? '123 Anywhere St., Any City' }}</div>
            <div style="margin: 5px 0;">📞 {{ $data['phone'] ?? '+91 12345 67890' }}</div>
            <div style="text-decoration: underline;">{{ $data['website'] ?? 'WWW.REALLYGREATSITE.COM' }}</div>
        </div>
    </div>
</div>