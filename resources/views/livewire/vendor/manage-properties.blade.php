<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="max-w-7xl mx-auto pb-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">My Properties</h1>
                    <p class="text-gray-500 mt-1">Manage your real estate listings.</p>
                </div>
                <a href="{{ route('vendor.properties.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 font-bold py-2.5 px-6 rounded-xl shadow-md flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Property
                </a>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input wire:model.live="search" type="text" placeholder="Search by title, city, or type..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            @if($properties->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <i class="fas fa-building text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900">No Properties Listed</h3>
                    <a href="{{ route('vendor.properties.create') }}" class="text-blue-600 font-bold hover:underline">List your first property</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $prop)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-md transition">
                            <div class="h-48 bg-gray-100 relative">
                                @if(!empty($prop->images))
                                    <img src="{{ asset('storage/'.$prop->images[0]) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400"><i class="fas fa-image text-3xl"></i></div>
                                @endif
                                
                                <span class="absolute top-2 right-2 bg-black/70 text-white text-xs font-bold px-2 py-1 rounded">
                                    For {{ ucfirst($prop->type) }}
                                </span>
                                
                                @if($prop->is_approved)
                                    <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">Approved</span>
                                @else
                                    <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">Pending</span>
                                @endif
                            </div>

                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 text-lg truncate mb-1">{{ $prop->title }}</h3>
                                <p class="text-gray-500 text-sm mb-3"><i class="fas fa-map-marker-alt mr-1"></i> {{ $prop->city }}, {{ $prop->state }}</p>
                                
                                <div class="flex items-center gap-4 text-xs text-gray-600 font-bold mb-4">
                                    <span><i class="fas fa-bed"></i> {{ $prop->bedrooms ?? '-' }} Beds</span>
                                    <span><i class="fas fa-bath"></i> {{ $prop->bathrooms ?? '-' }} Baths</span>
                                    <span><i class="fas fa-ruler-combined"></i> {{ $prop->area_sqft ?? '-' }} Sqft</span>
                                </div>

                                <div class="flex justify-between items-center border-t pt-3">
                                    <span class="font-extrabold text-blue-700 text-lg">₹{{ number_format($prop->price) }}</span>
                                    
                                    <div class="flex gap-2">
                                        <button wire:click="toggleStatus({{ $prop->id }})" title="Toggle Visibility" class="{{ $prop->is_active ? 'text-green-500' : 'text-gray-300' }} hover:text-green-700">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:click="deleteProperty({{ $prop->id }})" wire:confirm="Delete this listing?" class="text-red-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $properties->links() }}</div>
            @endif
        </div>
    </main>
</div>