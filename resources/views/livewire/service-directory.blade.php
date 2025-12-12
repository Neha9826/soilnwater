<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 capitalize">
                {{ $category ? str_replace('-', ' ', $category) . 's' : 'Find Professionals' }}
            </h1>
            <p class="text-gray-500 mt-2">Verified Experts for your Construction & Home needs</p>
        </div>

        <div class="max-w-md mx-auto mb-10">
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Search by name (e.g. Sharma Contractors)..." 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($providers as $provider)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col h-full border border-gray-100">
                    
                    <div class="p-6 flex-grow">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded uppercase">
                                    {{ $provider->service_category }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $provider->store_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $provider->name }}</p>
                            </div>
                            
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-lg font-bold text-gray-600">
                                {{ substr($provider->store_name, 0, 1) }}
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mt-4 line-clamp-2">
                            {{ $provider->store_description ?? 'No description provided.' }}
                        </p>

                        @if($provider->service_charge)
                            <div class="mt-4 flex items-center text-gray-700 font-medium">
                                <span class="text-green-600 mr-2">₹{{ number_format($provider->service_charge) }}</span>
                                <span class="text-xs text-gray-400">/ Visit or Consultation</span>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex gap-3">
                        <a href="{{ route('vendor.show', $provider->store_slug) }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                            View Profile
                        </a>
                        <button class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-100">
                            📞 Contact
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">No professionals found in this category yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>