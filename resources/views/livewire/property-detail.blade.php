<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <nav class="text-sm mb-6 text-gray-500">
        <a href="/" class="hover:text-blue-600">Home</a> <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $property->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2">
            <div class="bg-gray-200 rounded-lg overflow-hidden h-96 mb-6">
                @if($property->images)
                    <img src="{{ asset('storage/' . $property->images[0]) }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                @endif
            </div>

            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                    <p class="text-gray-500 mt-1">📍 {{ $property->address }}, {{ $property->city }}</p>
                </div>
                <div class="text-right">
                    <span class="block text-3xl font-bold text-blue-600">
                        ₹{{ number_format($property->price) }}
                    </span>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-2 uppercase font-semibold">
                        {{ $property->type }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-y border-gray-100 py-6 mb-6">
                <div class="text-center">
                    <span class="block text-gray-400 text-sm">Bedrooms</span>
                    <span class="text-xl font-bold">{{ $property->bedrooms ?? '-' }}</span>
                </div>
                <div class="text-center border-l border-gray-100">
                    <span class="block text-gray-400 text-sm">Bathrooms</span>
                    <span class="text-xl font-bold">{{ $property->bathrooms ?? '-' }}</span>
                </div>
                <div class="text-center border-l border-gray-100">
                    <span class="block text-gray-400 text-sm">Area</span>
                    <span class="text-xl font-bold">{{ $property->area_sqft ?? '-' }} sqft</span>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">About this property</h3>
                <div class="prose max-w-none text-gray-600">
                    {{ $property->description }}
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Interested?</h3>
                <p class="text-sm text-gray-500 mb-6">Contact the seller to schedule a visit.</p>
                
                <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                    📞 Show Phone Number
                </button>
                <button class="w-full mt-3 bg-white border border-blue-600 text-blue-600 font-bold py-3 rounded-lg hover:bg-blue-50 transition">
                    💬 Chat with Seller
                </button>
            </div>
        </div>
    </div>
</div>