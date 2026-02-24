<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg p-8 mb-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center text-3xl font-bold text-blue-600">
                {{ substr($vendor->store_name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $vendor->store_name }}</h1>
                <p class="text-gray-500">{{ $vendor->store_description ?? 'Authorized Vendor on SoilNWater' }}</p>
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mt-2">✅ Verified Seller</span>
            </div>
        </div>

        <div class="text-center">
            <p class="text-xs text-gray-400 mb-2">Scan to Share</p>
            @if($vendor->qr_code_path)
                <img src="{{ $vendor->qr_code_path ? route('ad.display', ['filename' => basename($vendor->qr_code_path)]) : '' }}" class="w-24 h-24 border border-gray-200 p-1">
            @endif
        </div>
    </div>

    <h3 class="text-xl font-bold mb-6">Products by {{ $vendor->store_name }}</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white border p-4 rounded-lg">
                <h4 class="font-bold">{{ $product->name }}</h4>
                <p class="text-blue-600">₹{{ number_format($product->price) }}</p>
            </div>
        @endforeach
    </div>
</div>