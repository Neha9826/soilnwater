<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ad Preview</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1080px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
        }

        .ad-box {
            width: 1000px;
            height: 1000px;
            border: 2px solid #ddd;
            padding: 40px;
            box-sizing: border-box;
        }

        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        p {
            font-size: 28px;
            line-height: 1.4;
        }

        img {
            max-width: 100%;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="ad-box">
        <h1>{{ $ad->title }}</h1>

        @foreach ($values as $value)
            @if(Str::startsWith($value->value, 'ads/'))
                <img src="{{ public_path('storage/' . $value->value) }}">
            @else
                <p>{{ $value->value }}</p>
            @endif
        @endforeach
    </div>
</body>
</html>