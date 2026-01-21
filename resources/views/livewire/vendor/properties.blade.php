<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8 relative">
        
        {{-- SELL MODAL --}}
        @if($isSellModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Sell via SoilNWater</h3>
                <p class="text-sm text-gray-500 mb-4">Set a price to list this property in the main marketplace for buyers to see.</p>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Selling Price (₹)</label>
                    <input wire:model="sellingPrice" type="number" placeholder="e.g. 5000000" class="w-full border-gray-300 rounded-lg p-3 border-2 focus:border-blue-500 text-lg font-bold">
                    @error('sellingPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 justify-end">
                    <button wire:click="closeSellModal" class="px-4 py-2 text-gray-600 font-bold hover:bg-gray-100 rounded-lg transition">Cancel</button>
                    <button wire:click="activateSale" class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-md transition">
                        <i class="fas fa-check-circle mr-1"></i> List for Sale
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">My Projects & Portfolio</h1>
                    <p class="text-sm text-gray-500">Manage your showcase projects. Sell them directly if needed.</p>
                </div>
                {{-- Search & View Toggle (Same as before) --}}
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input wire:model.live="search" type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-lg text-sm w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <a href="{{ route('vendor.properties.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 shadow-lg flex items-center gap-2 transition transform hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i> Add Project
                    </a>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
                <p>{{ session('message') }}</p>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i class="fas fa-times"></i></button>
            </div>
        @endif

        <div class="max-w-7xl mx-auto pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-200 overflow-hidden group flex flex-col h-full relative">
                        
                        <div class="h-48 w-full bg-gray-200 relative overflow-hidden">
                            @if(!empty($property->images) && count($property->images) > 0)
                                <img src="{{ asset('storage/'.$property->images[0]) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-4xl"></i></div>
                            @endif

                            {{-- STATUS BADGE --}}
                            <div class="absolute top-3 left-3 flex gap-2">
                                @if($property->sell_via_us)
                                    <span class="bg-green-600 text-white px-2 py-1 text-xs font-bold uppercase rounded shadow-sm">
                                        <i class="fas fa-shopping-cart"></i> On Market
                                    </span>
                                @else
                                    <span class="bg-gray-800 text-white px-2 py-1 text-xs font-bold uppercase rounded shadow-sm">
                                        <i class="fas fa-briefcase"></i> Portfolio
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 flex-1">
                            <p class="text-xs font-bold text-blue-600 uppercase mb-1">{{ $property->type }}</p>
                            <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2 line-clamp-1">{{ $property->title }}</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> {{ $property->city }}</p>
                            
                            {{-- PRICE DISPLAY --}}
                            @if($property->sell_via_us)
                                <div class="bg-green-50 p-2 rounded-lg border border-green-100 text-center mb-2">
                                    <span class="text-xs text-green-600 font-bold block uppercase">Selling Price</span>
                                    <span class="text-lg font-extrabold text-green-700">₹{{ number_format($property->price) }}</span>
                                </div>
                            @else
                                <div class="bg-gray-50 p-2 rounded-lg border border-gray-100 text-center mb-2 text-gray-400 text-sm italic">
                                    Not listed for direct sale
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 border-t flex justify-between items-center gap-2">
                            {{-- EDIT/DELETE --}}
                            <div class="flex gap-2">
                                <a href="{{ route('vendor.properties.edit', $property->id) }}" class="text-gray-500 hover:text-blue-600 p-2 rounded hover:bg-white transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="delete({{ $property->id }})" class="text-gray-500 hover:text-red-600 p-2 rounded hover:bg-white transition" onclick="confirm('Delete?') || event.stopImmediatePropagation()">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                            {{-- SELL ACTION --}}
                            @if($property->sell_via_us)
                                <button wire:click="deactivateSale({{ $property->id }})" class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg font-bold hover:bg-red-200 transition">
                                    Stop Selling
                                </button>
                            @else
                                <button wire:click="openSellModal({{ $property->id }})" class="text-xs bg-blue-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-blue-700 shadow-sm transition">
                                    Sell via Us
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $properties->links() }}
        </div>
    </main>
</div>