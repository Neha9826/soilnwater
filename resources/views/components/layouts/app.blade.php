<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SoilNWater Marketplace' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Moglix uses tight fonts */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <div class="bg-gray-900 text-gray-300 text-xs py-2">
        <div class="max-w-[1400px] mx-auto px-4 flex justify-between items-center">
            <div class="space-x-4 hidden md:block">
                <span><i class="fas fa-truck"></i> Fast Delivery</span>
                <span><i class="fas fa-shield-alt"></i> Buyer Protection</span>
            </div>
            <div class="flex space-x-4 items-center">
                 <a href="#" class="hover:text-white">Track Order</a>
            </div>
        </div>
    </div>

    <livewire:partials.navbar />

    {{-- app.blade.php --}}
    <main class="flex-grow w-full overflow-x-hidden"> {{-- Added overflow-x-hidden to prevent shaking --}}
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-white mt-12 py-12 text-sm">
        <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4">SoilNWater</h4>
                <p class="text-gray-400">Your one-stop destination for construction materials, tools, and real estate.</p>
            </div>
            </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} SoilNWater. All rights reserved.
        </div>
    </footer>
</body>
</html>