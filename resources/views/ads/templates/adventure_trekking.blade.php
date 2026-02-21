{{-- We keep your 400x800 base because your internal "top/left" math depends on it --}}
<div style="width: 100%; height: 100%; background: #fff; font-family: 'Arial Black', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee;">
    
    {{-- 1. Main Background Image --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 450px; z-index: 1;">
        {{-- FIX: Using the Proxy Route for the live server image --}}
        <img src="{{ Str::startsWith($data['image_top'] ?? '', ['http', 'data:', 'blob']) ? $data['image_top'] : route('image.proxy', ['path' => $data['image_top'] ?? '']) }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 2. Texture --}}
    <div style="position: absolute; inset: 0; z-index: 2; opacity: 0.8; pointer-events: none; background: url('https://www.transparenttextures.com/patterns/p-6.png');"></div>

    {{-- 3. Content Container (Kept exactly as your original) --}}
    <div style="position: absolute; top: 320px; left: -10%; width: 120%; height: 420px; background: #fff; z-index: 3; transform: rotate(-3deg); box-shadow: 0 -10px 30px rgba(0,0,0,0.15);">
        <div style="transform: rotate(3deg); padding-top: 50px; text-align: center; width: 80%; margin: 0 auto;">
            <h1 style="margin: 0; font-size: 58px; line-height: 0.8; color: {{ $data['text_color_main'] ?? '#333' }}; letter-spacing: -3px; text-transform: uppercase;">
                {{ $data['title_1'] ?? 'ADVENTURE' }}
            </h1>
            <h2 style="margin: 5px 0 0 0; font-size: 38px; color: {{ $data['text_color_accent'] ?? '#2d5a27' }}; letter-spacing: -1px; text-transform: uppercase;">
                {{ $data['title_2'] ?? 'TREKKING' }}
            </h2>
            <p style="font-family: 'Georgia', serif; font-style: italic; font-size: 18px; margin: 15px 0; color: #555;">
                {{ $data['tagline'] ?? 'Enjoy Your Life With Nature' }}
            </p>
            <div style="font-size: 18px; font-weight: 900; color: {{ $data['text_color_accent'] ?? '#2d5a27' }}; letter-spacing: 2px; margin-bottom: 20px;">
                {{ $data['activities'] ?? 'CLIMBING | BONFIRE | CAMPING' }}
            </div>
            <div style="border: 3px solid #444; display: inline-block; padding: 8px 25px; font-size: 18px; font-weight: 900; color: #333; margin-bottom: 20px;">
                {{ $data['event_date'] ?? 'DECEMBER 9-10, 2026' }}
            </div>
        </div>
    </div>

    {{-- 4. Bottom Image --}}
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 200px; z-index: 1;">
        <img src="{{ Str::startsWith($data['image_bottom'] ?? '', ['http', 'data:', 'blob']) ? $data['image_bottom'] : route('image.proxy', ['path' => $data['image_bottom'] ?? '']) }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 5. Price Badge --}}
    <div style="position: absolute; bottom: 100px; right: 30px; width: 115px; height: 115px; background: #222; border-radius: 50%; border: 4px double #fff; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 50; transform: rotate(5deg);">
         <span style="font-size: 28px; font-weight: 900;">₹{{ $data['price_val'] ?? '100' }}</span>
        <span style="font-size: 11px; font-weight: 700;">/PERSON</span>
    </div>

    {{-- 6. Footer --}}
    <div style="position: absolute; bottom: 25px; width: 100%; text-align: center; z-index: 40; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.9);">
        <div style="font-size: 15px; font-weight: 900;">{{ $data['website'] ?? 'WWW.REALLYGREATSITE.COM' }}</div>
    </div>
</div>