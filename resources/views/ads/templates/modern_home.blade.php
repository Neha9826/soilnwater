<div style="width: 500px; height: 500px; background-color: {{ $data['bg_color'] ?? '#ffffff' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee; color: {{ $data['accent_color'] ?? '#3c5064' }};">
    
    {{-- Decorative Waves --}}
    <div style="position: absolute; top: -50px; left: -50px; width: 300px; height: 180px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border-radius: 0 0 100% 0; opacity: 0.9; z-index: 5;"></div>
    <div style="position: absolute; bottom: -80px; right: -50px; width: 450px; height: 250px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border-radius: 100% 0 0 0; opacity: 1; z-index: 5;"></div>

    {{-- Main Circular Image Mask --}}
    <div style="position: absolute; top: 120px; right: -50px; width: 380px; height: 380px; border-radius: 50%; border: 12px solid {{ $data['accent_light'] ?? '#f2f2f2' }}; overflow: hidden; z-index: 10; background: #eee; box-shadow: -10px 10px 30px rgba(0,0,0,0.1);">
        @if(isset($data['image_1']))
            <img src="{{ is_string($data['image_1']) ? asset('storage/' . $data['image_1']) : $data['image_1']->temporaryUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
        @endif
    </div>

    {{-- Dynamic OFF Badge --}}
    <div style="position: absolute; top: 130px; right: 40px; width: 85px; height: 85px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border: 4px solid #fff; border-radius: 50%; display: flex; flex-direction: column; items: center; justify-content: center; z-index: 30; color: #fff; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        <span style="font-size: 22px; font-weight: 300; line-height: 1;">{{ $data['off_amount'] ?? '50%' }}</span>
        <span style="font-size: 18px; font-weight: 700; text-transform: uppercase;">OFF</span>
    </div>

    {{-- Typography Section - SPACING FIXED --}}
    <div style="position: absolute; top: 55px; left: 40px; z-index: 20; width: 250px;">
        {{-- High Visibility 'MODERN' --}}
        <h1 style="margin: 0; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 1; text-transform: uppercase; color: {{ $data['accentx_color'] ?? '#02394f' }};">
            {{ $data['brand'] ?? 'MODERN' }}
        </h1>
        
        {{-- Added Margin Top to create space between the two words --}}
        <h2 style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 60px; margin: 5px 0 0 0; font-weight: 400; color: #020f17; line-height: 1;">
            {{ $data['sub_brand'] ?? 'Furniture' }}
        </h2>

        <p style="margin-top: 15px; font-size: 14px; line-height: 1.4; color: #666; font-weight: 500;">
            {{ $data['description'] ?? 'Refresh a single room or revamp your entire home, our talented team is here to bring your vision to life.' }}
        </p>

        {{-- Available Color dots --}}
        <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 8px;">
            <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #888;">Available Color</span>
            <div style="display: flex; gap: 8px;">
                <div style="width: 14px; height: 14px; border-radius: 50%; background: {{ $data['dot_1'] ?? '#5d4037' }}; border: 1px solid #ddd;"></div>
                <div style="width: 14px; height: 14px; border-radius: 50%; background: {{ $data['dot_2'] ?? '#a1887f' }}; border: 1px solid #ddd;"></div>
                <div style="width: 14px; height: 14px; border-radius: 50%; background: {{ $data['dot_3'] ?? '#3c5064' }}; border: 1px solid #ddd;"></div>
                <div style="width: 14px; height: 14px; border-radius: 50%; background: {{ $data['dot_4'] ?? '#90a4ae' }}; border: 1px solid #ddd;"></div>
            </div>
        </div>

        {{-- Shop Now Button --}}
        <div style="margin-top: 25px;">
            <div style="background: {{ $data['accent_color'] ?? '#3c5064' }}; color: #fff; padding: 10px 30px; border-radius: 4px; display: inline-block; font-weight: 800; font-size: 14px; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                {{ $data['btn_text'] ?? 'SHOP NOW' }}
            </div>
        </div>
    </div>

    {{-- Footer Contact Info --}}
    <div style="position: absolute; bottom: 25px; left: 40px; z-index: 50; background: rgba(255,255,255,0.9); color: #000000; font-size: 11px; font-weight: 700; line-height: 1.8; padding: 10px 15px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-phone-alt"></i> {{ $data['phone'] ?? '+123-456-7890' }}
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-map-marker-alt"></i> {{ $data['address'] ?? '123 Anywhere St., Any City' }}
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-globe"></i> {{ $data['link'] ?? 'www.reallygreatsite.com' }}
        </div>
    </div>
</div>