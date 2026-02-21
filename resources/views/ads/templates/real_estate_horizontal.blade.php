<div style="width: 100%; height: 100%; background: #1a1a1a; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #333;">
    
    {{-- 1. Background Layer --}}
    <div style="position: absolute; inset: 0; z-index: 1;">
        <img src="{{ !empty($data['image_bg']) ? (Str::startsWith($data['image_bg'], ['http', 'data:', 'blob']) ? $data['image_bg'] : route('image.proxy', ['path' => $data['image_bg']])) : 'https://placehold.co/800x400' }}" 
             style="width: 100%; height: 100%; object-fit: cover; opacity: 0.5;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.95) 35%, transparent 100%);"></div>
    </div>

    {{-- 2. Orange Alignment Bar --}}
    <div style="position: absolute; top: -50px; right: 280px; width: 90px; height: 500px; background: #ff6d00; transform: rotate(30deg); z-index: 2; opacity: 0.9;"></div>

    {{-- 3. Left Side Content --}}
    <div style="position: absolute; top: 0; left: 0; width: 400px; height: 100%; padding: 50px; z-index: 10; display: flex; flex-direction: column; justify-content: center; color: #fff;">
        <div style="text-transform: uppercase; font-size: 14px; font-weight: 700; color: #ff6d00; letter-spacing: 3px; margin-bottom: 5px;">
            {{ $data['tagline'] ?? 'FIND YOUR' }}
        </div>
        <h1 style="margin: 0; font-size: 60px; line-height: 0.85; font-weight: 900; text-transform: uppercase; letter-spacing: -2px;">
            {{ $data['title_main'] ?? 'DREAM HOUSE' }}
        </h1>
        
        <div style="margin: 30px 0; display: flex; align-items: center; gap: 20px;">
            <div style="background: #fff; color: #1a1a1a; padding: 12px 30px; border-radius: 4px; font-weight: 800; font-size: 15px;">BOOK NOW</div>
            <div style="font-size: 13px; opacity: 0.7;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
        </div>

        <div style="font-size: 11px; line-height: 1.8; opacity: 0.8;">
            📍 {{ $data['address'] ?? '456 Elite Residency, Dehradun' }}<br>
            📞 {{ $data['phone'] ?? '+91 99999 88888' }}
        </div>
    </div>

    {{-- 4. Repositioned Price Badge (Between Text and Images) --}}
    <div style="position: absolute; bottom: 80px; left: 340px; background: #ff6d00; color: #fff; padding: 12px 20px; transform: rotate(-5deg); z-index: 20; box-shadow: 0 10px 20px rgba(0,0,0,0.4); border: 2px solid #fff; border-radius: 4px; text-align: center;">
        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase;">Starting At</div>
        <div style="font-size: 22px; font-weight: 900;">{{ $data['price_val'] ?? 'Rs. 4.5M' }}</div>
    </div>

    {{-- 5. THE GEOMETRIC GRID: Perfect 180x180 Squares --}}
    
    @foreach(['image_1' => 'top: 15px; right: 200px;', 'image_2' => 'top: 110px; right: 35px;', 'image_3' => 'bottom: 15px; right: 200px;'] as $imgKey => $pos)
        <div style="position: absolute; {{ $pos }} width: 180px; height: 180px; transform: rotate(30deg); overflow: hidden; border: 6px solid #fff; z-index: 6; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);">
            <div style="transform: rotate(-30deg) scale(1.5); width: 100%; height: 100%;">
                <img src="{{ !empty($data[$imgKey]) ? (Str::startsWith($data[$imgKey], ['http', 'data:', 'blob']) ? $data[$imgKey] : route('image.proxy', ['path' => $data[$imgKey]])) : 'https://placehold.co/400x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    @endforeach
</div>