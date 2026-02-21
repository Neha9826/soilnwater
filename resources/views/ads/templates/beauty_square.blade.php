<div style="width: 100%; height: 100%; background-color: {{ $data['bg_color'] ?? '#f9f5f0' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee;">
    <div style="position: absolute; top: -110px; right: -60px; width: 480px; height: 300px; background: {{ $data['accent_color'] ?? '#8d5524' }}; border-radius: 45% 55% 44% 56% / 30% 30% 70% 70%; transform: rotate(-8deg); opacity: 0.9;"></div>
    
    <div style="position: absolute; top: 55px; left: 45px; z-index: 50; width: 280px;">
        <h2 style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 34px; margin: 0; color: {{ $data['offer_font_color'] ?? '#d4a373' }}; font-weight: 400;">{{ $data['offer_name'] ?? 'Special Today' }}</h2>
        <h1 style="margin: -5px 0 0 0; font-size: 62px; font-weight: 900; line-height: 0.82; text-transform: uppercase; color: {{ $data['title_color'] ?? '#402a23' }};">BEAUTY<br>CLINIC</h1>
        <div style="margin-top: 25px;">
            <p style="font-weight: 800; font-size: 19px; text-transform: uppercase; color: #402a23;">Our Services</p>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 15px; font-weight: 600; color: {{ $data['service_color'] ?? '#8d5524' }};">
                <li>• {{ $data['service_1'] ?? 'Skin Care' }}</li>
                <li>• {{ $data['service_2'] ?? 'Facial Treatment' }}</li>
                <li>• {{ $data['service_3'] ?? 'Body Treatment' }}</li>
            </ul>
        </div>
    </div>

    @foreach(['image_1' => 'top: 35px; right: 40px; width: 155px; height: 155px;', 'image_2' => 'top: 195px; right: 15px; width: 175px; height: 175px;', 'image_3' => 'bottom: -15px; right: 105px; width: 210px; height: 210px;'] as $key => $style)
    <div style="position: absolute; {{ $style }} border-radius: 50%; border: 6px solid {{ $data['accent_color'] ?? '#8d5524' }}; overflow: hidden; z-index: 20;">
        <img src="{{ Str::startsWith($data[$key] ?? '', ['http', 'data:', 'blob']) ? $data[$key] : route('image.proxy', ['path' => $data[$key] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    @endforeach

    <div style="position: absolute; bottom: 20px; left: 25px; width: 180px; z-index: 100;">
        <div style="background: {{ $data['accent_color'] ?? '#8d5524' }}; color: #fff; padding: 3px 10px; font-size: 11px; font-weight: 800; display: inline-block;">MORE INFO</div>
        <div style="font-size: 13px; font-weight: 700; color: #402a23; margin-top: 5px;">
            {{ $data['phone'] ?? '+91-0987654321' }}<br>
            <span style="font-weight: 500; font-size: 12px;">{{ $data['address'] ?? 'Your Address Here' }}</span>
        </div>
    </div>
</div>