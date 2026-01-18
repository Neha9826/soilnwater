<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">My Properties</h1>
                    <p class="text-sm text-gray-500">Manage your listings and check their status.</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input wire:model.live="search" type="text" placeholder="Search properties..." class="pl-10 pr-4 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="bg-white border rounded-lg p-1 flex items-center shadow-sm">
                        <button wire:click="$set('viewType', 'grid')" 
                                class="p-2 rounded {{ $viewType === 'grid' ? 'bg-blue-100 text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button wire:click="$set('viewType', 'list')" 
                                class="p-2 rounded {{ $viewType === 'list' ? 'bg-blue-100 text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <a href="{{ route('vendor.properties.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 shadow-lg flex items-center gap-2 transition transform hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i> Add New
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
            
            @if($viewType === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-200 overflow-hidden group flex flex-col h-full">
                            
                            <div class="h-48 w-full bg-gray-200 relative overflow-hidden">
                                @if(!empty($property->images) && count($property->images) > 0)
                                    <img src="{{ asset('storage/'.$property->images[0]) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-4xl"></i>
                                    </div>
                                @endif
                                
                                <span class="absolute top-3 left-3 px-2 py-1 text-xs font-bold uppercase rounded 
                                    {{ $property->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $property->is_active ? 'Active' : 'Inactive' }}
                                </span>

                                <span class="absolute bottom-3 right-3 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    ₹{{ number_format($property->price) }}
                                </span>
                            </div>

                            <div class="p-5 flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs font-bold text-blue-600 uppercase mb-1">
                                            {{ $property->type }} • {{ $property->listing_type ?? 'Sale' }}
                                        </p>
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2 line-clamp-1" title="{{ $property->title }}">
                                            {{ $property->title }}
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> {{ $property->city }}, {{ $property->state }}
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 border-t flex justify-between items-center">
                                <span class="text-xs text-gray-400">Added {{ $property->created_at->diffForHumans() }}</span>
                                
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('vendor.properties.edit', $property->id) }}" class="text-gray-500 hover:text-blue-600 bg-white border border-gray-300 hover:border-blue-500 p-2 rounded-lg shadow-sm transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button wire:click="delete({{ $property->id }})" 
                                            onclick="confirm('Are you sure you want to delete this property?') || event.stopImmediatePropagation()"
                                            class="text-gray-500 hover:text-red-600 bg-white border border-gray-300 hover:border-red-500 p-2 rounded-lg shadow-sm transition" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @elseif($viewType === 'list')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b">
                            <tr>
                                <th class="p-4">Property</th>
                                <th class="p-4">Category</th>
                                <th class="p-4">Price</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Date</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($properties as $property)
                                <tr class="hover:bg-gray-50 transition group">
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-12 w-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                                @if(!empty($property->images) && count($property->images) > 0)
                                                    <img src="{{ asset('storage/'.$property->images[0]) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $property->title }}</h4>
                                                <p class="text-xs text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $property->city }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        {{ $property->type }} <span class="text-xs text-gray-400">({{ $property->listing_type ?? 'Sale' }})</span>
                                    </td>
                                    <td class="p-4 font-bold text-gray-900 text-sm">
                                        ₹{{ number_format($property->price) }}
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 text-xs font-bold uppercase rounded 
                                            {{ $property->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $property->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-xs text-gray-500">
                                        {{ $property->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#" class="text-blue-600 hover:bg-blue-50 p-2 rounded transition">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="delete({{ $property->id }})" 
                                                    onclick="confirm('Delete this property?')" 
                                                    class="text-red-500 hover:bg-red-50 p-2 rounded transition">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(count($properties) == 0)
                <div class="text-center py-20">
                    <div class="bg-gray-100 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fas fa-home text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No Properties Found</h3>
                    <p class="text-gray-500 mb-6">You haven't listed any properties yet.</p>
                    <a href="{{ route('vendor.properties.create') }}" class="text-blue-600 font-bold hover:underline">List your first property</a>
                </div>
            @endif

            <div class="mt-8">
                {{ $properties->links() }}
            </div>

        </div>
    </main>
</div>