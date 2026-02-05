{{-- resources/views/ads/templates/beauty_square.blade.php --}}
<div style="width: 500px; height: 500px; background-color: {{ $data['bg_color'] ?? '#f9f5f0' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee;">
    
    <div style="position: absolute; top: -110px; right: -60px; width: 480px; height: 300px; background: {{ $data['accent_color'] ?? '#8d5524' }}; border-radius: 45% 55% 44% 56% / 30% 30% 70% 70%; transform: rotate(-8deg); opacity: 0.9;"></div>
    <div style="position: absolute; bottom: -80px; left: -40px; width: 520px; height: 220px; background: {{ $data['accent_color'] ?? '#8d5524' }}; border-radius: 50% 50% 0 0 / 100% 100% 0 0; transform: rotate(3deg); opacity: 0.9;"></div>

    <div style="position: absolute; top: 55px; left: 45px; z-index: 50; width: 280px;">
        <h2 style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 34px; margin: 0; color: {{ $data['offer_font_color'] ?? '#d4a373' }}; font-weight: 400; line-height: 1.2;">
            {{ $data['offer_name'] ?? 'Special Today' }}
        </h2>
        <h1 style="margin: -5px 0 0 0; font-size: 62px; font-weight: 900; line-height: 0.82; text-transform: uppercase; color: {{ $data['title_color'] ?? '#402a23' }}; letter-spacing: -1px;">
            BEAUTY<br>CLINIC
        </h1>
        <div style="margin-top: 25px;">
            <p style="font-weight: 800; font-size: 19px; text-transform: uppercase; margin-bottom: 6px; color: #402a23;">Our Services</p>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 15px; font-weight: 600; color: {{ $data['service_color'] ?? '#8d5524' }}; line-height: 1.5;">
                <li>• {{ $data['service_1'] ?? 'Skin Care' }}</li>
                <li>• {{ $data['service_2'] ?? 'Facial Treatment' }}</li>
                <li>• {{ $data['service_3'] ?? 'Body Treatment' }}</li>
            </ul>
        </div>
    </div>

    {{-- Circle 1 --}}
    <div style="position: absolute; top: 35px; right: 40px; width: 155px; height: 155px; border-radius: 50%; border: 6px solid {{ $data['accent_color'] ?? '#8d5524' }}; overflow: hidden; z-index: 20; background: #eee;">
        <img src="{{ !empty($data['image_1']) ? (Str::startsWith($data['image_1'], 'http') ? $data['image_1'] : asset('storage/' . $data['image_1'])) : asset('images/placeholder.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Circle 2 --}}
    <div style="position: absolute; top: 195px; right: 15px; width: 175px; height: 175px; border-radius: 50%; border: 6px solid {{ $data['accent_color'] ?? '#8d5524' }}; overflow: hidden; z-index: 15; background: #eee;">
        <img src="{{ !empty($data['image_2']) ? (Str::startsWith($data['image_2'], 'http') ? $data['image_2'] : asset('storage/' . $data['image_2'])) : asset('images/placeholder.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Circle 3 --}}
    <div style="position: absolute; bottom: -15px; right: 105px; width: 210px; height: 210px; border-radius: 50%; border: 6px solid {{ $data['accent_color'] ?? '#8d5524' }}; overflow: hidden; z-index: 10; background: #eee;">
        <img src="{{ !empty($data['image_3']) ? (Str::startsWith($data['image_3'], 'http') ? $data['image_3'] : asset('storage/' . $data['image_3'])) : asset('images/placeholder.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="position: absolute; top: 220px; left: 240px; width: 90px; height: 90px; background: {{ $data['accent_color'] ?? '#8d5524' }}; border: 2px dashed rgba(255,255,255,0.8); border-radius: 50%; display: flex; flex-direction: column; items: center; justify-content: center; z-index: 60; color: #fff; text-align: center;">
        <span style="font-size: 24px; font-weight: 900; line-height: 1;">50%</span>
        <span style="font-size: 15px; font-weight: 700; text-transform: uppercase;">OFF</span>
    </div>

    <div style="position: absolute; bottom: 20px; left: 25px; width: 180px; background: transparent; padding: 15px; border-radius: 6px; z-index: 100;">
        <div style="background: {{ $data['accent_color'] ?? '#8d5524' }}; color: #fff; padding: 3px 10px; display: inline-block; font-size: 11px; font-weight: 800; border-radius: 2px; margin-bottom: 8px;">MORE INFO</div>
        <div style="font-size: 13px; font-weight: 700; color: #fffaf8; line-height: 1.3;">
            {{ $data['phone'] ?? '+91-0987654321' }}<br>
            <span style="color: #f7f3f3; font-weight: 500; font-size: 12px;">{{ $data['address'] ?? 'Your Address Here' }}</span><br>
            <span style="font-size: 11px; font-weight: 600;">{{ $data['link'] ?? 'www.reallygreatsite.com' }}</span>
        </div>
    </div>
</div>