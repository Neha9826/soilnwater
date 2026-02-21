<div style="width: 100%; height: 100%; background-color: {{ $data['bg_color'] ?? '#ffffff' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd; color: #000;">
    
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 260px; overflow: hidden; z-index: 1;">
        <img src="{{ Str::startsWith($data['image_bg'] ?? '', ['http', 'data:', 'blob']) ? $data['image_bg'] : route('image.proxy', ['path' => $data['image_bg'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7);">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255,255,255,0.2), rgba(255,255,255,1) 95%);"></div>
    </div>

    <div style="position: absolute; top: 25px; width: 100%; text-align: center; z-index: 50; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
        <p style="text-transform: uppercase; letter-spacing: 2px; font-weight: 600; font-size: 14px; margin: 0;">{{ $data['name'] ?? 'Fradel and Spies' }}</p>
    </div>

    <div style="position: absolute; top: 120px; width: 100%; display: flex; justify-content: center; align-items: flex-end; z-index: 40; padding: 0 20px; box-sizing: border-box;">
        <div style="width: 140px; height: 140px; border-radius: 50%; border: 4px solid #fff; overflow: hidden; background: #eee; box-shadow: 0 10px 20px rgba(0,0,0,0.15); margin-right: -25px;">
            <img src="{{ Str::startsWith($data['image_1'] ?? '', ['http', 'data:', 'blob']) ? $data['image_1'] : route('image.proxy', ['path' => $data['image_1'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="width: 190px; height: 190px; border-radius: 50%; border: 6px solid #fff; overflow: hidden; background: #eee; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 45;">
            <img src="{{ Str::startsWith($data['image_2'] ?? '', ['http', 'data:', 'blob']) ? $data['image_2'] : route('image.proxy', ['path' => $data['image_2'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="width: 140px; height: 140px; border-radius: 50%; border: 4px solid #fff; overflow: hidden; background: #eee; box-shadow: 0 10px 20px rgba(0,0,0,0.15); margin-left: -25px;">
            <img src="{{ Str::startsWith($data['image_3'] ?? '', ['http', 'data:', 'blob']) ? $data['image_3'] : route('image.proxy', ['path' => $data['image_3'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    <div style="position: absolute; bottom: 0; width: 100%; height: 210px; background: #fff; z-index: 30; text-align: center; padding-top: 20px;">
        <h1 style="color: {{ $data['heading_color'] ?? '#000' }}; font-size: 52px; margin: 0; font-weight: 900; line-height: 1; letter-spacing: -1px;">GRAND OPENING</h1>
        <p style="font-size: 13px; color: #666; width: 80%; margin: 10px auto; line-height: 1.4;">{{ $data['description'] ?? 'We\'re serving up excitement at the grand opening!' }}</p>
        <div style="background: #000; color: #fff; display: inline-block; padding: 8px 30px; border-radius: 2px; font-weight: bold; font-size: 14px; margin: 5px 0 15px 0;">{{ $data['date_time'] ?? 'Saturday, 27 June' }}</div>
        
        <div style="position: absolute; bottom: 20px; width: 100%; display: flex; justify-content: center; gap: 15px; font-size: 11px; font-weight: bold; color: #333; z-index: 100;">
            <span><i class="fas fa-map-marker-alt"></i> {{ $data['address'] ?? '123 Anywhere St.' }}</span>
            <span><i class="fas fa-phone"></i> {{ $data['phone'] ?? '+123-456' }}</span>
            <span><i class="fas fa-globe"></i> {{ $data['link'] ?? 'www.reallygreatsite.com' }}</span>
        </div>
    </div>
</div>