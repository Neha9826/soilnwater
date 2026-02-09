{{-- resources/views/ads/templates/adventure_trekking.blade.php --}}
<div style="width: 400px; height: 600px; background: #fff; font-family: 'Arial Black', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee;">
    
    {{-- 1. Main Background Image (Top) --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 300px; z-index: 1;">
        <img src="{{ !empty($data['image_top']) ? (Str::startsWith($data['image_top'], ['http', 'blob']) ? $data['image_top'] : asset('storage/' . $data['image_top'])) : 'https://placehold.co/400x300?text=Trekker+Image' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 2. Crumpled Paper Texture Overlay --}}
    <div style="position: absolute; inset: 0; z-index: 2; opacity: 0.8; pointer-events: none; background: url('https://www.transparenttextures.com/patterns/p-6.png');"></div>

    {{-- 3. The "Torn Paper" Effect Container --}}
    <div style="position: absolute; top: 180px; left: -10%; width: 120%; height: 350px; background: #fff; z-index: 3; transform: rotate(-3deg); box-shadow: 0 -10px 30px rgba(0,0,0,0.15);">
        <div style="transform: rotate(3deg); padding-top: 40px; text-align: center; width: 83%; margin: 0 auto;">
            <h1 style="margin: 0; font-size: 55px; line-height: 0.8; color: {{ $data['text_color_main'] ?? '#333' }}; letter-spacing: -3px; text-transform: uppercase;">
                {{ $data['title_1'] ?? 'ADVENTURE' }}
            </h1>
            
            <h2 style="margin: -5px 0 0 0; font-size: 35px; color: {{ $data['text_color_accent'] ?? '#2d5a27' }}; letter-spacing: -1px; text-transform: uppercase;">
                {{ $data['title_2'] ?? 'TREKKING' }}
            </h2>
            
            <p style="font-family: 'Georgia', serif; font-style: italic; font-size: 16px; margin: 10px 0; color: #555;">
                {{ $data['tagline'] ?? 'Enjoy Your Life With Nature' }}
            </p>

            <div style="font-size: 18px; font-weight: 900; color: {{ $data['text_color_accent'] ?? '#2d5a27' }}; letter-spacing: 2px; margin-bottom: 15px;">
                {{ $data['activities'] ?? 'CLIMBING | BONFIRE | CAMPING' }}
            </div>

            <div style="border: 3px solid #444; display: inline-block; padding: 5px 20px; font-size: 18px; font-weight: 900; color: #333; margin-bottom: 15px;">
                {{ $data['event_date'] ?? 'DECEMBER 9-10, 2026 AT 3 PM' }}
            </div>

            <div style="font-size: 16px; font-weight: 700; color: #444;">
                {{ $data['location'] ?? '123 ANYWHERE ST., ANY CITY' }}
            </div>
        </div>
    </div>

    {{-- 4. Bottom Landscape Image --}}
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 150px; z-index: 1;">
        <img src="{{ !empty($data['image_bottom']) ? (Str::startsWith($data['image_bottom'], ['http', 'blob']) ? $data['image_bottom'] : asset('storage/' . $data['image_bottom'])) : 'https://placehold.co/400x150?text=Landscape' }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- 5. Floating Leaves --}}
    <div style="position: absolute; top: 150px; left: 10px; width: 60px; z-index: 10; filter: blur(1px);"><img src="https://pngimg.com/uploads/leaves/leaves_PNG1205.png" style="width: 100%;"></div>
    <div style="position: absolute; top: 350px; right: -20px; width: 80px; z-index: 10; transform: rotate(45deg);"><img src="https://pngimg.com/uploads/leaves/leaves_PNG1205.png" style="width: 100%;"></div>

    {{-- 6. Price Badge --}}
    <div style="position: absolute; bottom: 40px; right: 20px; width: 100px; height: 100px; background: #222; border-radius: 50%; border: 4px double #fff; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 50; transform: rotate(5deg); box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <!-- <span style="font-size: 26px; font-weight: 900;">₹{{ $data['price_val'] ?? '200' }}</span> -->
         <span style="font-size: 26px;">₹{{ $data['price_val'] ?? '200' }}</span>
        <span style="font-size: 11px; font-weight: 700;">/PERSON</span>
    </div>

    {{-- 7. Footer Booking Info --}}
    <div style="position: absolute; bottom: 15px; width: 100%; text-align: center; z-index: 40; color: #fff; text-shadow: 0 1px 3px rgba(0,0,0,0.8);">
        <div style="font-size: 14px; font-weight: 900;">{{ $data['website'] ?? 'WWW.REALLYGREATSITE.COM' }}</div>
    </div>
</div>