<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            margin: 0;
            width: 1080px;
            height: 1080px;
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
        }

        .wrapper {
            width: 100%;
            height: 100%;
            padding: 60px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .title {
            font-size: 52px;
            font-weight: bold;
            color: #111;
            margin-bottom: 20px;
        }

        .content {
            display: flex;
            gap: 40px;
        }

        .text {
            flex: 1;
            font-size: 28px;
            line-height: 1.4;
            color: #333;
        }

        .image {
            width: 420px;
            height: 420px;
            border-radius: 12px;
            overflow: hidden;
        }

        .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer {
            font-size: 22px;
            color: #666;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div>
        <div class="title">{{ $ad->title }}</div>

        <div class="content">
            <div class="text">
                @foreach ($data as $key => $value)
                    @if(!Str::startsWith($value, 'ads/'))
                        <div><strong>{{ ucfirst(str_replace('_',' ', $key)) }}:</strong> {{ $value }}</div>
                        <br>
                    @endif
                @endforeach
            </div>

            @if($image)
                <div class="image">
                    <img src="{{ $image }}">
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        Powered by Soil & Water
    </div>
</div>

</body>
</html>
