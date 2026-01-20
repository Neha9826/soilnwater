<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SoilNWater') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @livewireStyles
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-blue-700">
                Soil<span class="text-green-600">N</span>Water
            </h1>
        </div>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-xl">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>