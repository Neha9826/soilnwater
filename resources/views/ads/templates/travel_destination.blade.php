<div style="width: 400px; height: 800px; background: #f4f1ea; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    
    {{-- 1. Full Background Layer --}}
    <div style="position: absolute; inset: 0; z-index: 1;">
        <img src="{{ !empty($data['image_bg']) ? (Str::startsWith($data['image_bg'], ['http', 'blob']) ? $data['image_bg'] : asset('storage/' . $data['image_bg'])) : 'https://placehold.co/400x800?text=Background' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.2);"></div>
    </div>

    {{-- 2. Grid Paper Texture Overlay --}}
    <div style="position: absolute; inset: 0; z-index: 2; opacity: 0.3; pointer-events: none; background-image: radial-gradient(#d1d1d1 1px, transparent 1px); background-size: 20px 20px;"></div>

    {{-- 3. Top SMALL Square (Parallel to Middle) --}}
    <div style="position: absolute; top: -10px; right: 60px; width: 180px; height: 180px; transform: rotate(45deg); overflow: hidden; border: 8px solid #fff; z-index: 5; border-radius: 30px; box-shadow: -5px 5px 15px rgba(0,0,0,0.2);">
        <div style="transform: rotate(-45deg) scale(1.5); width: 100%; height: 100%;">
            <img src="{{ !empty($data['image_1']) ? (Str::startsWith($data['image_1'], ['http', 'blob']) ? $data['image_1'] : asset('storage/' . $data['image_1'])) : 'https://placehold.co/300x300?text=Top' }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- 4. Right LARGE Square (The Diamond Anchor) --}}
    <div style="position: absolute; top: 190px; right: -150px; width: 380px; height: 380px; transform: rotate(45deg); overflow: hidden; border: 12px solid #fff; z-index: 4; border-radius: 50px; box-shadow: -10px 10px 30px rgba(0,0,0,0.4);">
        <div style="transform: rotate(-45deg) scale(1.4); width: 100%; height: 100%;">
            <img src="{{ !empty($data['image_3']) ? (Str::startsWith($data['image_3'], ['http', 'blob']) ? $data['image_3'] : asset('storage/' . $data['image_3'])) : 'https://placehold.co/500x500?text=Right' }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- 5. Bottom SMALL Square (Parallel to Middle) --}}
    <div style="position: absolute; bottom: -10px; right: 60px; width: 180px; height: 180px; transform: rotate(45deg); overflow: hidden; border: 8px solid #fff; z-index: 5; border-radius: 30px; box-shadow: -5px 5px 15px rgba(0,0,0,0.2);">
        <div style="transform: rotate(-45deg) scale(1.5); width: 100%; height: 100%;">
            <img src="{{ !empty($data['image_4']) ? (Str::startsWith($data['image_4'], ['http', 'blob']) ? $data['image_4'] : asset('storage/' . $data['image_4'])) : 'https://placehold.co/300x300?text=Bottom' }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- 6. Circular Venice Image (Centered relative to the new length) --}}
    <div style="position: absolute; bottom: 200px; left: 30px; width: 220px; height: 220px; border-radius: 50%; border: 6px solid #fff; overflow: hidden; z-index: 10; box-shadow: 0 15px 35px rgba(0,0,0,0.3);">
        <img src="{{ !empty($data['image_2']) ? (Str::startsWith($data['image_2'], ['http', 'blob']) ? $data['image_2'] : asset('storage/' . $data['image_2'])) : 'https://placehold.co/400x400?text=Circle' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 7. Content Area (Pushed slightly lower for the 2:1 ratio) --}}
    <div style="position: absolute; top: 120px; left: 45px; z-index: 20;">
        <div style="background: #fff; color: #111; padding: 4px 15px; border-radius: 20px; display: inline-block; font-size: 13px; font-weight: 700; margin-bottom: 20px;">
            {{ $data['tagline_top'] ?? '@reallygreatsite' }}
        </div>
        <h1 style="font-size: 62px; font-weight: 900; line-height: 0.82; margin: 0; text-transform: uppercase; letter-spacing: -3px; color: #fff; text-shadow: 0 4px 12px rgba(0,0,0,0.8);">
            {{ $data['title_top'] ?? 'Travel' }}<br>
            <span style="font-weight: 700; opacity: 0.95;">{{ $data['title_bottom'] ?? 'Destination' }}</span>
        </h1>
        <p style="font-size: 12px; margin-top: 25px; line-height: 1.6; max-width: 200px; font-weight: 600; color: #fff; text-shadow: 0 2px 5px rgba(0,0,0,0.9);">
            {{ $data['description'] ?? 'Discover breathtaking landscapes and hidden gems with our expert guides.' }}
        </p>
    </div>

    {{-- 8. Refined Discount Circle (Repositioned lower per user arrow) --}}
    <div style="position: absolute; top: 480px; right: 120px; width: 110px; height: 110px; background: #261e1a; color: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 30; border: 4px solid #fff; box-shadow: 0 12px 25px rgba(0,0,0,0.5);">
        <span style="font-size: 26px; font-weight: 900; line-height: 1;">{{ $data['discount'] ?? '30%' }}</span>
        <span style="font-size: 15px; font-weight: 400; letter-spacing: 1px;">OFF</span>
    </div>

    {{-- 9. Footer CTA --}}
    <div style="position: absolute; bottom: 60px; left: 45px; z-index: 20;">
        <div style="background: #261e1a; color: #fff; padding: 12px 35px; border-radius: 25px; display: inline-block; font-size: 16px; font-weight: 900; margin-bottom: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            BOOK NOW
        </div>
        <div style="color: #fff; font-size: 13px; font-weight: 600; text-shadow: 0 2px 6px rgba(0,0,0,1);">
            {{ $data['website'] ?? 'www.reallygreatsite.com' }}
        </div>
    </div>
</div>