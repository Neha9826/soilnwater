<div style="width: 100%; height: 100%; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; display: flex; border: 1px solid #eee;">
    {{-- Left: Fluid Stacked Polaroids --}}
    <div style="width: 45%; height: 100%; position: relative; background: #e8dcc4;">
        @php
            $positions = [
                'image_1' => 'rotate(-10deg); top: 15%; left: 10%;',
                'image_2' => 'rotate(5deg); top: 25%; left: 35%;',
                'image_3' => 'rotate(-5deg); top: 10%; left: 60%;'
            ];
        @endphp
        @foreach($positions as $imgKey => $style)
            <div style="position: absolute; width: 25%; height: 70%; background: #fff; padding: 1%; {{ $style }} box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <img src="{{ !empty($data[$imgKey]) ? (Str::startsWith($data[$imgKey], ['http', 'data:', 'blob']) ? $data[$imgKey] : route('image.proxy', ['path' => $data[$imgKey]])) : 'https://placehold.co/300x400' }}" style="width: 100%; height: 85%; object-fit: cover;">
            </div>
        @endforeach
    </div>

    {{-- Right: Fluid Content --}}
    <div style="width: 55%; background: #2c5266; color: #fff; display: flex; flex-direction: column; justify-content: center; padding-left: 6%;">
        <h4 style="margin: 0; font-size: 1.5vw; letter-spacing: 2px; opacity: 0.8;">IT'S TIME TO</h4>
        <h1 style="margin: 0; font-size: 5vw; font-weight: 900; line-height: 1;">TRAVEL THE<br>WORLD</h1>
        <div style="margin-top: 15px; font-size: 1.2vw; opacity: 0.9;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
    </div>
</div>