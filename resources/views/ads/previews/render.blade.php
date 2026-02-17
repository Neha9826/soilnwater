<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Arial, sans-serif;
        }

        .ad-wrapper {
            width: 600px;
            height: 600px;
            padding: 30px;
            box-sizing: border-box;
            background: {{ $data['bg_color'] ?? '#ffffff' }};
            position: relative;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: {{ $data['accent_color'] ?? '#000' }};
        }

        .description {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        .cta {
            display: inline-block;
            padding: 12px 20px;
            background: {{ $data['accent_color'] ?? '#000' }};
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .image {
            position: absolute;
            bottom: 30px;
            right: 30px;
            width: 220px;
        }

        .image img {
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="ad-wrapper">
    <h1>{{ $data['brand'] ?? 'Your Brand' }}</h1>

    <div class="description">
        {{ $data['description'] ?? '' }}
    </div>

    <a class="cta">
        {{ $data['btn_text'] ?? 'Learn More' }}
    </a>

    @if(!empty($data['image']))
        <div class="image">
            <img src="{{ asset('storage/'.$data['image']) }}">
        </div>
    @endif
</div>

</body>
</html>
