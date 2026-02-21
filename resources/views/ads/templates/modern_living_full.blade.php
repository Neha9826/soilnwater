<div style="width: 100%; height: 100%; background: #fff; font-family: 'Poppins', sans-serif; position: relative; overflow: hidden; display: flex; border: 1px solid #eee;">
    {{-- Left: Main Hero Image --}}
    <div style="width: 55%; height: 100%; position: relative;">
        <img src="{{ !empty($data['image_main']) ? (Str::startsWith($data['image_main'], ['http', 'data:', 'blob']) ? $data['image_main'] : route('image.proxy', ['path' => $data['image_main']])) : 'https://placehold.co/440x400' }}" style="width: 100%; height: 100%; object-fit: cover;">
        {{-- Text Overlay Box --}}
        <div style="position: absolute; top: 50px; left: 40px; background: rgba(255,255,255,0.9); padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h1 style="margin: 0; font-size: 42px; line-height: 1.1; color: #111;">Modern<br>Living Room<br>Design</h1>
        </div>
    </div>

    {{-- Right: Details Grid --}}
    <div style="width: 45%; padding: 40px; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            @foreach(['image_1', 'image_2', 'image_3', 'image_4'] as $key)
                <div style="width: 100%; aspect-ratio: 1; background: #f4f4f4; border-radius: 15px; overflow: hidden;">
                    {{-- Rectified detail grid images --}}
                    <img src="{{ !empty($data[$key]) ? (Str::startsWith($data[$key], ['http', 'data:', 'blob']) ? $data[$key] : route('image.proxy', ['path' => $data[$key]])) : 'https://placehold.co/150x150' }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endforeach
        </div>
        <div>
            <p style="font-size: 14px; color: #666; margin-bottom: 5px;">Get up to 20% discount on orders</p>
            <div style="font-size: 14px; font-weight: 700; color: #111;">{{ $data['website'] ?? 'www.reallygreatsite.com' }}</div>
        </div>
    </div>
</div>