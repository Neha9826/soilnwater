{{-- resources/views/ads/templates/travel_agency.blade.php --}}
<div style="width: 100%; height: 100%; background: {{ $data['bg_color'] ?? '#2c5266' }}; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #ddd;">
    
    {{-- Main Background Image (Extended) --}}
    <div style="position: absolute; inset: 0; opacity: 0.3;">
        <img src="{{ !empty($data['image_main']) ? (Str::startsWith($data['image_main'], ['http', 'data:', 'blob']) ? $data['image_main'] : route('image.proxy', ['path' => $data['image_main']])) : 'https://placehold.co/400x800' }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- Smartphone Frame (Shifted Higher) --}}
    <div style="position: absolute; top: 80px; right: 20px; width: 250px; height: 500px; border: 12px solid #111; border-radius: 40px; overflow: hidden; z-index: 10; background: #fff; box-shadow: 0 25px 50px rgba(0,0,0,0.4);">
        <img src="{{ !empty($data['image_phone']) ? (Str::startsWith($data['image_phone'], ['http', 'data:', 'blob']) ? $data['image_phone'] : route('image.proxy', ['path' => $data['image_phone']])) : 'https://placehold.co/250x500' }}" style="width: 100%; height: 100%; object-fit: cover;">
        
        {{-- Larger Torn Paper Circle Overlay --}}
        <div style="position: absolute; bottom: -30px; right: -30px; width: 180px; height: 180px; border-radius: 50%; border: 10px solid #fff; background: #eee; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
            <img src="{{ !empty($data['image_circle']) ? (Str::startsWith($data['image_circle'], ['http', 'data:', 'blob']) ? $data['image_circle'] : route('image.proxy', ['path' => $data['image_circle']])) : 'https://placehold.co/180x180' }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    {{-- Text Content Area (Pushed lower to balance the frame) --}}
    <div style="position: absolute; top: 320px; left: 25px; width: 220px; z-index: 30; color: #fff;">
        <h1 style="font-family: 'Dancing Script', cursive; font-size: 60px; line-height: 0.9; margin: 0; text-shadow: 2px 4px 6px rgba(0,0,0,0.4);">
            {{ $data['title_top'] ?? 'Travel' }}<br>
            {{ $data['title_bottom'] ?? 'Agency' }}
        </h1>
        
        <p style="font-size: 12px; line-height: 1.5; margin: 20px 0; opacity: 0.95;">
            {{ $data['description'] ?? 'Discover the world with our exclusive tour packages and flight deals.' }}
        </p>
        
        <div style="font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
            OUR SERVICES:
        </div>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 12px; font-weight: 500;">
            <li style="margin-bottom: 8px;">✓ {{ $data['service_1'] ?? 'Flight Booking' }}</li>
            <li style="margin-bottom: 8px;">✓ {{ $data['service_2'] ?? 'Hotel Reservations' }}</li>
            <li style="margin-bottom: 8px;">✓ {{ $data['service_3'] ?? 'Tour Packages' }}</li>
        </ul>
    </div>

    {{-- Repositioned Discount Badge --}}
    <div style="position: absolute; top: 220px; right: 230px; width: 90px; height: 90px; background: #004d40; color: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 40; border: 3px solid #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
        <span style="font-size: 20px; font-weight: 900;">{{ $data['discount'] ?? '30%' }}</span>
        <span style="font-size: 11px; font-weight: 700;">OFF</span>
    </div>

    {{-- Footer Bar (Higher for 2:1 Ratio) --}}
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100px; background: #fff; display: flex; align-items: center; padding: 0 30px; gap: 20px; z-index: 5;">
        <div style="background: #004d40; color: #fff; padding: 12px 25px; font-weight: 900; font-size: 15px; border-radius: 6px;">BOOK NOW</div>
        <div style="font-size: 12px; color: #333; font-weight: 600;">
            {{ $data['phone'] ?? '+123-456-7890' }}<br>
            <span style="color: #666;">{{ $data['website'] ?? 'WWW.TRAVELAGENCY.COM' }}</span>
        </div>
    </div>
</div>