<div style="width: 400px; height: 600px; background: {{ $data['bg_color'] ?? '#2c5266' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    
    {{-- Main Background Image --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3;">
        <img src="{{ !empty($data['image_main']) ? (Str::startsWith($data['image_main'], ['http', 'blob']) ? $data['image_main'] : asset('storage/' . $data['image_main'])) : 'https://placehold.co/400x600?text=Sky+Background' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Smartphone Frame --}}
    <div style="position: absolute; top: 60px; right: 20px; width: 230px; height: 460px; border: 10px solid #111; border-radius: 35px; overflow: hidden; z-index: 10; background: #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        <img src="{{ !empty($data['image_phone']) ? (Str::startsWith($data['image_phone'], ['http', 'blob']) ? $data['image_phone'] : asset('storage/' . $data['image_phone'])) : 'https://placehold.co/230x460?text=Destination' }}" style="width: 100%; height: 100%; object-fit: cover;">
        
        {{-- Torn Paper Circle Overlay on Phone --}}
        <div style="position: absolute; bottom: -20px; right: -20px; width: 150px; height: 150px; border-radius: 50%; border: 8px solid #fff; overflow: hidden; background: #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            <img src="{{ !empty($data['image_circle']) ? (Str::startsWith($data['image_circle'], ['http', 'blob']) ? $data['image_circle'] : asset('storage/' . $data['image_circle'])) : 'https://placehold.co/150x150?text=Person' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- Floating Plane Illustration --}}
    <div style="position: absolute; top: 30px; left: -30px; width: 260px; z-index: 20; transform: rotate(-10deg);">
        <img src="https://pngimg.com/uploads/plane/plane_PNG101211.png" style="width: 100%;">
    </div>

    {{-- Left Side Text Content --}}
    <div style="position: absolute; top: 220px; left: 25px; width: 190px; z-index: 30; color: #fff;">
        <h1 style="font-family: 'Dancing Script', cursive; font-size: 50px; line-height: 0.9; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            {{ $data['title_top'] ?? 'Travel' }}<br>
            {{ $data['title_bottom'] ?? 'Agency' }}
        </h1>
        
        <p style="font-size: 10px; line-height: 1.4; margin: 15px 0; opacity: 0.9;">
            {{ $data['description'] ?? 'Discover the world with our exclusive tour packages and flight deals.' }}
        </p>
        
        <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
            OUR SERVICES:
        </div>
        <ul style="list-style: none; padding: 0; margin: 10px 0; font-size: 11px; font-weight: 500;">
            <li style="margin-bottom: 5px;">✓ {{ $data['service_1'] ?? 'Flight Booking' }}</li>
            <li style="margin-bottom: 5px;">✓ {{ $data['service_2'] ?? 'Hotel Reservations' }}</li>
            <li style="margin-bottom: 5px;">✓ {{ $data['service_3'] ?? 'Tour Packages' }}</li>
        </ul>
    </div>

    {{-- 30% OFF Badge --}}
    <div style="position: absolute; top: 130px; right: 210px; width: 70px; height: 70px; background: #004d40; color: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 40; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 2px solid #fff;">
        <span style="font-size: 18px; font-weight: 900;">{{ $data['discount'] ?? '30%' }}</span>
        <span style="font-size: 10px; font-weight: 700;">OFF</span>
    </div>

    {{-- Footer Bar --}}
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 85px; background: #fff; display: flex; align-items: center; padding: 0 25px; gap: 15px; z-index: 5;">
        <div style="background: #004d40; color: #fff; padding: 10px 20px; font-weight: 900; font-size: 14px; border-radius: 4px;">BOOK NOW</div>
        <div style="font-size: 11px; color: #333; font-weight: 600; line-height: 1.3;">
            {{ $data['phone'] ?? '+123-456-7890' }}<br>
            <span style="color: #666;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</span>
        </div>
    </div>
</div>