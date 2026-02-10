{{-- resources/views/ads/templates/adventure_trekking.blade.php --}}
<div style="width: 400px; height: 800px; background: #fff; font-family: 'Arial Black', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee;">
    
    {{-- 1. Main Background Image (Extended Height) --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 450px; z-index: 1;">
        <img src="{{ !empty($data['image_top']) ? (Str::startsWith($data['image_top'], ['http', 'blob']) ? $data['image_top'] : asset('storage/' . $data['image_top'])) : 'https://placehold.co/400x450?text=Trekker+Image' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 2. Crumpled Paper Texture --}}
    <div style="position: absolute; inset: 0; z-index: 2; opacity: 0.8; pointer-events: none; background: url('https://www.transparenttextures.com/patterns/p-6.png');"></div>

    {{-- 3. The "Torn Paper" Content Container (Repositioned) --}}
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

            <div style="font-size: 16px; font-weight: 700; color: #444;">
                {{ $data['location'] ?? '123 ANYWHERE ST., ANY CITY' }}
            </div>
        </div>
    </div>

    {{-- 4. Bottom Landscape Image (Restored) --}}
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 200px; z-index: 1;">
        <img src="{{ !empty($data['image_bottom']) ? (Str::startsWith($data['image_bottom'], ['http', 'blob']) ? $data['image_bottom'] : asset('storage/' . $data['image_bottom'])) : 'https://placehold.co/400x200?text=Landscape' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 5. Floating Leaves (Restored and Repositioned) --}}
    <div style="position: absolute; top: 180px; left: 15px; width: 60px; z-index: 10; filter: blur(1px);"><img src="https://pngimg.com/uploads/leaves/leaves_PNG1205.png" style="width: 100%;"></div>
    <div style="position: absolute; top: 480px; right: -20px; width: 85px; z-index: 10; transform: rotate(45deg);"><img src="https://pngimg.com/uploads/leaves/leaves_PNG1205.png" style="width: 100%;"></div>

    {{-- 6. Price Badge (Pushed to bottom section) --}}
    <div style="position: absolute; bottom: 100px; right: 30px; width: 115px; height: 115px; background: #222; border-radius: 50%; border: 4px double #fff; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 50; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
         <span style="font-size: 28px; font-weight: 900;">₹{{ $data['price_val'] ?? '200' }}</span>
        <span style="font-size: 11px; font-weight: 700;">/PERSON</span>
    </div>

    {{-- 7. Footer Booking Info --}}
    <div style="position: absolute; bottom: 25px; width: 100%; text-align: center; z-index: 40; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.9);">
        <div style="font-size: 15px; font-weight: 900;">{{ $data['website'] ?? 'WWW.REALLYGREATSITE.COM' }}</div>
    </div>
</div>