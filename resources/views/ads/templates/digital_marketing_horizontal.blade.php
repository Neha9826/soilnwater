<div style="width: 800px; height: 400px; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; border: 1px solid #eee; display: flex;">
    
    {{-- 1. Left Side: Content Section --}}
    <div style="width: 50%; padding: 40px 0 40px 50px; z-index: 10; display: flex; flex-direction: column; justify-content: center;">
        
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <div style="width: 25px; height: 25px; background: #333; border-radius: 4px;"></div>
            <span style="font-size: 12px; font-weight: 700; color: #666; letter-spacing: 1px;">{{ $data['agency_name'] ?? 'TRUSTED AGENCY' }}</span>
        </div>

        <h1 style="margin: 0; font-size: 52px; line-height: 0.95; font-weight: 900; color: #111; letter-spacing: -1px;">
            DIGITAL<br>MARKETING
        </h1>
        <h2 style="margin: 5px 0 25px 0; font-family: 'Dancing Script', cursive; font-size: 32px; color: #333; font-weight: 400;">
            Agency
        </h2>

        {{-- Services Grid --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #444;">
                <div style="width: 18px; height: 18px; border: 2px solid #111; border-radius: 50%;"></div> {{ $data['service_1'] ?? 'SOCIAL MEDIA' }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #444;">
                <div style="width: 18px; height: 18px; border: 2px solid #111; border-radius: 50%;"></div> {{ $data['service_2'] ?? 'PAY PER CLICK' }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #444;">
                <div style="width: 18px; height: 18px; border: 2px solid #111; border-radius: 50%;"></div> {{ $data['service_3'] ?? 'MARKETING STRATEGY' }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #444;">
                <div style="width: 18px; height: 18px; border: 2px solid #111; border-radius: 50%;"></div> {{ $data['service_4'] ?? 'BUSINESS ANALYSIS' }}
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="background: #111; color: #fff; padding: 12px 35px; border-radius: 30px; font-weight: 900; font-size: 14px; letter-spacing: 1px;">CONTACT</div>
            <div style="font-size: 11px; font-weight: 600; color: #111;">
                CALL FOR MORE INFO<br>
                <span style="font-size: 14px; font-weight: 900;">{{ $data['phone'] ?? '+123 4567 890' }}</span>
            </div>
        </div>
    </div>

    {{-- 2. Right Side: 3D Stacked Beams & Hexagon --}}
    <div style="width: 50%; height: 100%; position: relative; z-index: 5; background: #f9f9f9;">
        
        {{-- Diagonal 3D Beams --}}
        <div style="position: absolute; top: -50px; right: 180px; width: 60px; height: 250px; background: #222; transform: rotate(35deg); border-radius: 30px; box-shadow: 10px 10px 0 rgba(0,0,0,0.1);"></div>
        <div style="position: absolute; bottom: -50px; right: 280px; width: 60px; height: 250px; background: #222; transform: rotate(35deg); border-radius: 30px; box-shadow: 10px 10px 0 rgba(0,0,0,0.1);"></div>
        <div style="position: absolute; bottom: -100px; right: 80px; width: 60px; height: 350px; background: #222; transform: rotate(35deg); border-radius: 30px; box-shadow: 10px 10px 0 rgba(0,0,0,0.1);"></div>

        {{-- Main Hero Hexagon (Parallel to beams) --}}
        <div style="position: absolute; top: 60px; right: 60px; width: 280px; height: 280px; transform: rotate(30deg); overflow: hidden; z-index: 10; border: 10px solid #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.2); clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);">
            <div style="transform: rotate(-30deg) scale(1.4); width: 100%; height: 100%;">
                <img src="{{ !empty($data['image_main']) ? (Str::startsWith($data['image_main'], ['http', 'blob']) ? $data['image_main'] : asset('storage/' . $data['image_main'])) : 'https://placehold.co/400x400?text=Team+Meeting' }}" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        {{-- Floating Dots Decor --}}
        <div style="position: absolute; top: 40px; right: 350px; width: 60px; height: 40px; background-image: radial-gradient(#ccc 2px, transparent 2px); background-size: 10px 10px; z-index: 1;"></div>
    </div>
</div>