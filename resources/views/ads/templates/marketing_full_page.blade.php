<div style="width: 100%; height: 100%; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; display: flex;">
    {{-- Left: Content Area (Grows to fill space) --}}
    <div style="flex: 1; padding: 5%; display: flex; flex-direction: column; justify-content: center; min-width: 400px;">
        <h1 style="font-size: 5vw; line-height: 0.9; font-weight: 900; margin: 0; letter-spacing: -2px;">DIGITAL<br>MARKETING</h1>
        <p style="font-family: 'Dancing Script', cursive; font-size: 3vw; margin: 5px 0 25px 0;">Agency</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div style="font-size: 14px; font-weight: 700; color: #444;">● SOCIAL MEDIA</div>
            <div style="font-size: 14px; font-weight: 700; color: #444;">● PAY PER CLICK</div>
            <div style="font-size: 14px; font-weight: 700; color: #444;">● STRATEGY</div>
            <div style="font-size: 14px; font-weight: 700; color: #444;">● ANALYSIS</div>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="background: #111; color: #fff; padding: 12px 30px; border-radius: 5px; font-weight: 800;">CONTACT</div>
            <div style="font-size: 14px; line-height: 1.2;"><b>{{ $data['phone'] ?? '+123 456 789' }}</b><br>Call for more info</div>
        </div>
    </div>

    {{-- Right: 3D Graphic Area (Fixed proportion) --}}
    <div style="width: 45%; position: relative; background: #f4f4f4; flex-shrink: 0;">
        {{-- Hexagon stays centered regardless of ad width --}}
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(30deg); width: 350px; height: 350px; overflow: hidden; border: 10px solid #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.2); clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);">
             <div style="transform: rotate(-30deg) scale(1.4); width: 100%; height: 100%;">
                <img src="{{ Str::startsWith($data['image_main'] ?? '', ['http', 'data:', 'blob']) ? $data['image_main'] : route('image.proxy', ['path' => $data['image_main'] ?? '']) }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</div>