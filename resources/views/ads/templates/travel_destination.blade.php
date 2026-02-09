<div style="width: 400px; height: 600px; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    
    {{-- Top Diagonal Image --}}
    <div style="position: absolute; top: -50px; right: -50px; width: 400px; height: 400px; transform: rotate(45deg); overflow: hidden; border: 8px solid #fff; z-index: 1; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div style="transform: rotate(-45deg) scale(1.4); width: 100%; height: 100%;">
            <img src="{{ !empty($data['image_1']) ? (Str::startsWith($data['image_1'], ['http', 'blob']) ? $data['image_1'] : asset('storage/' . $data['image_1'])) : 'https://placehold.co/400x400?text=Mountain' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- Center Content Area --}}
    <div style="position: absolute; top: 180px; left: 30px; z-index: 10; width: 250px;">
        <div style="background: rgba(255,255,255,0.8); padding: 5px 15px; display: inline-block; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 10px;">
            {{ $data['tagline_top'] ?? '@reallygreatsite' }}
        </div>
        <h1 style="font-size: 50px; font-weight: 800; line-height: 0.9; color: #333; margin: 0;">
            {{ $data['title_top'] ?? 'Travel' }}<br><span style="color: #444;">{{ $data['title_bottom'] ?? 'Destination' }}</span>
        </h1>
        <p style="font-size: 11px; color: #666; margin-top: 15px; line-height: 1.5;">
            {{ $data['description'] ?? 'Discover breathtaking landscapes and hidden gems with our expert guides.' }}
        </p>
    </div>

    {{-- Bottom Circular Image --}}
    <div style="position: absolute; bottom: 100px; left: 40px; width: 180px; height: 180px; border-radius: 50%; border: 8px solid #fff; overflow: hidden; z-index: 5; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <img src="{{ !empty($data['image_2']) ? (Str::startsWith($data['image_2'], ['http', 'blob']) ? $data['image_2'] : asset('storage/' . $data['image_2'])) : 'https://placehold.co/180x180?text=City' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Discount Badge --}}
    <div style="position: absolute; bottom: 220px; right: 40px; width: 90px; height: 90px; background: #1a1a1a; color: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 15; border: 4px solid #fff;">
        <span style="font-size: 20px; font-weight: 800;">{{ $data['discount'] ?? '30%' }}</span>
        <span style="font-size: 12px; font-weight: 600;">OFF</span>
    </div>

    {{-- Footer with Book Now --}}
    <div style="position: absolute; bottom: 0; width: 100%; height: 120px; background-color: #333; z-index: 1;">
        <div style="position: absolute; bottom: 20px; left: 30px; display: flex; align-items: center; gap: 15px; z-index: 10;">
            <div style="background: #fff; color: #1a1a1a; padding: 10px 25px; border-radius: 10px; font-weight: 800; font-size: 14px;">BOOK NOW</div>
            <div style="color: #fff; font-size: 11px; font-weight: 500;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
        </div>
    </div>
</div>