<div class="w-full bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
            <div class="w-full md:w-auto">
                <h1 class="text-3xl font-extrabold text-gray-900">My Ads</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your classified ads and paid promotions.</p>
            </div>

            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                
                {{-- Search Bar --}}
                <div class="relative w-full sm:w-72">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Search ads..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                <div class="flex gap-2 flex-shrink-0">
                    {{-- View Toggles --}}
                    <div class="bg-white border border-gray-300 rounded-lg p-1 flex items-center shadow-sm h-[42px]">
                        <button type="button" wire:click.prevent="setView('grid')" 
                                class="w-10 h-full flex items-center justify-center rounded transition-colors {{ $viewType === 'grid' ? 'bg-blue-100 text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <i class="fas fa-th-large text-lg"></i>
                        </button>
                        <button type="button" wire:click.prevent="setView('list')" 
                                class="w-10 h-full flex items-center justify-center rounded transition-colors {{ $viewType === 'list' ? 'bg-blue-100 text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <i class="fas fa-list text-lg"></i>
                        </button>
                    </div>

                    {{-- Post Button --}}
                    <a href="{{ route('customer.ad.create') }}" class="h-[42px] flex items-center gap-2 bg-blue-600 text-white px-6 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition whitespace-nowrap">
                        <i class="fas fa-plus"></i>
                        <span>Create Ad</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="min-h-[400px]">
            @if($ads->count() > 0)
                {{-- GRID VIEW --}}
                @if($viewType === 'grid')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($ads as $ad)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow border border-gray-200 overflow-hidden flex flex-col h-full group">
                                <div class="h-48 w-full bg-gray-200 relative overflow-hidden">
                                    @if($ad->image)
                                        <img src="{{ asset('storage/'.$ad->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-bullhorn text-4xl opacity-30"></i></div>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase">Ad</span>
                                </div>
                                <div class="p-5">
                                    <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-1">{{ $ad->title }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $ad->description }}</p>
                                </div>
                                <div class="px-5 py-4 bg-gray-50 border-t flex justify-between items-center text-xs text-gray-500">
                                    <span>{{ $ad->created_at->diffForHumans() }}</span>
                                    <button wire:click="delete({{ $ad->id }})" onclick="confirm('Delete?') || event.stopImmediatePropagation()" class="text-gray-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-full"><i class="fas fa-trash-alt text-sm"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($viewType === 'list')
                    {{-- LIST VIEW --}}
                    <div class="space-y-4">
                        @foreach($ads as $ad)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row group hover:shadow-md transition">
                                <div class="w-full md:w-56 h-48 md:h-auto bg-gray-200 relative flex-shrink-0">
                                    @if($ad->image)
                                        <img src="{{ asset('storage/'.$ad->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100"><i class="fas fa-bullhorn text-3xl opacity-30"></i></div>
                                    @endif
                                </div>
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ad->title }}</h3>
                                        <p class="text-sm text-gray-500 line-clamp-2">{{ $ad->description }}</p>
                                    </div>
                                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                        <span class="text-xs text-gray-500">Posted {{ $ad->created_at->format('d M, Y') }}</span>
                                        <button wire:click="delete({{ $ad->id }})" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="mt-8">{{ $ads->links() }}</div>
            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="bg-gray-50 rounded-full h-24 w-24 flex items-center justify-center mb-4"><i class="fas fa-bullhorn text-4xl text-gray-400"></i></div>
                    <h3 class="text-xl font-bold text-gray-900">No Ads Found</h3>
                    <p class="text-gray-500 mt-2 mb-6 max-w-sm text-center">You haven't posted any classified ads or paid promotions yet.</p>
                    <a href="{{ route('customer.ad.create') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-plus"></i> Create New Ad
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>