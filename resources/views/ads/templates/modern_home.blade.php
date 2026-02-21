<div style="width: 100%; height: 100%; background-color: {{ $data['bg_color'] ?? '#ffffff' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee; color: {{ $data['accent_color'] ?? '#3c5064' }};">
    
    <div style="position: absolute; top: -50px; left: -50px; width: 300px; height: 180px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border-radius: 0 0 100% 0; opacity: 0.9; z-index: 5;"></div>
    <div style="position: absolute; bottom: -80px; right: -50px; width: 450px; height: 250px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border-radius: 100% 0 0 0; opacity: 1; z-index: 5;"></div>

    <div style="position: absolute; top: 120px; right: -50px; width: 380px; height: 380px; border-radius: 50%; border: 12px solid {{ $data['accent_light'] ?? '#f2f2f2' }}; overflow: hidden; z-index: 10; background: #eee;">
        <img src="{{ !empty($data['image_1']) ? (Str::startsWith($data['image_1'], ['http', 'data:', 'blob']) ? $data['image_1'] : route('image.proxy', ['path' => $data['image_1']])) : 'https://placehold.co/400x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; top: 130px; right: 40px; width: 85px; height: 85px; background: {{ $data['accent_color'] ?? '#294a5d' }}; border: 4px solid #fff; border-radius: 50%; display: flex; flex-direction: column; items: center; justify-content: center; z-index: 30; color: #fff; text-align: center;">
        <span style="font-size: 22px; font-weight: 300;">{{ $data['off_amount'] ?? '50%' }}</span>
        <span style="font-size: 18px; font-weight: 700;">OFF</span>
    </div>

    <div style="position: absolute; top: 55px; left: 40px; z-index: 20; width: 250px;">
        <h1 style="margin: 0; font-size: 48px; font-weight: 400; letter-spacing: 4px; color: {{ $data['accentx_color'] ?? '#02394f' }};">{{ $data['brand'] ?? 'MODERN' }}</h1>
        <h2 style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 60px; margin: 5px 0 0 0; color: #020f17; line-height: 1;">{{ $data['sub_brand'] ?? 'Furniture' }}</h2>
        <p style="margin-top: 15px; font-size: 14px; line-height: 1.4; color: #666;">{{ $data['description'] ?? 'Talented team is here to bring your vision to life.' }}</p>

        <div style="margin-top: 25px;">
            <div style="background: {{ $data['accent_color'] ?? '#3c5064' }}; color: #fff; padding: 10px 30px; border-radius: 4px; display: inline-block; font-weight: 800; font-size: 14px;">{{ $data['btn_text'] ?? 'SHOP NOW' }}</div>
        </div>
    </div>

    <div style="position: absolute; bottom: 25px; left: 40px; z-index: 50; background: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; font-size: 11px; font-weight: 700;">
        <div><i class="fas fa-phone-alt"></i> {{ $data['phone'] ?? '+123-456-7890' }}</div>
        <div><i class="fas fa-map-marker-alt"></i> {{ $data['address'] ?? '123 Anywhere St.' }}</div>
        <div><i class="fas fa-globe"></i> {{ $data['link'] ?? 'www.reallygreatsite.com' }}</div>
    </div>
</div>