<div style="width: 100%; height: 100%; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; display: flex; border: 1px solid #eee;">
    {{-- Left: Stacked Polaroids --}}
    <div style="width: 45%; height: 100%; position: relative; background: #e8dcc4;">
        @foreach(['image_1' => 'rotate(-10deg); top: 20px; left: 30px;', 'image_2' => 'rotate(5deg); top: 35px; left: 110px;', 'image_3' => 'rotate(-5deg); top: 15px; left: 200px;'] as $imgKey => $rotate)
            <div style="position: absolute; width: 110px; height: 130px; background: #fff; padding: 8px; transform: {{ $rotate }}; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <img src="{{ !empty($data[$imgKey]) ? (Str::startsWith($data[$imgKey], ['http', 'data:', 'blob']) ? $data[$imgKey] : route('image.proxy', ['path' => $data[$imgKey]])) : 'https://placehold.co/100x100' }}" style="width: 100%; height: 80%; object-fit: cover;">
            </div>
        @endforeach
    </div>

    {{-- Right: Content --}}
    <div style="width: 55%; background: #2c5266; color: #fff; display: flex; flex-direction: column; justify-content: center; padding-left: 40px;">
        <h4 style="margin: 0; font-size: 14px; letter-spacing: 2px; opacity: 0.8;">IT'S TIME TO</h4>
        <h1 style="margin: 0; font-size: 42px; font-weight: 900; line-height: 1;">TRAVEL THE<br>WORLD</h1>
        <div style="margin-top: 15px; font-size: 12px; opacity: 0.9;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
    </div>
</div>