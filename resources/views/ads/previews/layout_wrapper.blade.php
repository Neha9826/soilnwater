<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; background: white; overflow: hidden; }
        /* Ensure the container matches the expected capture size */
        .ad-capture-container { width: 1080px; height: 1080px; position: relative; }
    </style>
</head>
<body>
    <div class="ad-capture-container">
        @include($template, ['data' => $data])
    </div>
</body>
</html>