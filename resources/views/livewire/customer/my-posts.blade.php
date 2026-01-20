<div class="w-full min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
            
            <div class="w-full md:w-auto">
                <h1 class="text-3xl font-extrabold text-gray-900">My Ads</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your active listings.</p>
            </div>

            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                
                <div class="relative w-full sm:w-72">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Search ads..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    
                </div>

                <div class="flex gap-2 flex-shrink-0">
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

                    <a href="{{ route('post.choose-category') }}" 
                       class="h-[42px] flex items-center gap-2 bg-blue-600 text-white px-6 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition whitespace-nowrap">
                        <i class="fas fa-plus"></i>
                        <span>Post New Ad</span>
                    </a>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
                <span class="font-medium"><i class="fas fa-check-circle mr-2"></i>{{ session('message') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-700"><i class="fas fa-times"></i></button>
            </div>
        @endif

        <div class="min-h-[400px]">
            @if($posts->count() > 0)
                
                @if($viewType === 'grid')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($posts as $post)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow border border-gray-200 overflow-hidden flex flex-col h-full group">
                                <a href="{{ route('customer.post.edit', $post->id) }}" class="block flex-1">
                                    <div class="h-64 w-full bg-gray-200 relative overflow-hidden">
                                        @if(!empty($post->images) && count($post->images) > 0)
                                            <img src="{{ asset('storage/'.$post->images[0]) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                                                <i class="fas fa-image text-4xl mb-2 opacity-30"></i><span class="text-xs">No Image</span>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3"><span class="bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase">Active</span></div>
                                        <div class="absolute bottom-3 right-3"><span class="bg-gray-900/80 text-white text-sm font-bold px-3 py-1.5 rounded-lg shadow-sm">₹{{ number_format($post->price) }}</span></div>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex gap-2 mb-3">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase rounded border border-blue-100">{{ $post->type }}</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase rounded border border-gray-200">{{ $post->listing_type }}</span>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-1 group-hover:text-blue-600 transition">{{ $post->title }}</h3>
                                        <p class="text-sm text-gray-500 flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-gray-400"></i> {{ $post->city }}</p>
                                    </div>
                                </a>
                                <div class="px-5 py-4 bg-gray-50 border-t flex justify-between items-center text-xs text-gray-500">
                                    <span>Posted {{ $post->created_at->diffForHumans() }}</span>
                                    <button wire:click="delete({{ $post->id }})" onclick="confirm('Delete this ad?') || event.stopImmediatePropagation()" class="text-gray-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-full"><i class="fas fa-trash-alt text-sm"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @elseif($viewType === 'list')
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row group hover:shadow-md transition">
                                <a href="{{ route('customer.post.edit', $post->id) }}" class="w-full md:w-56 h-48 md:h-auto bg-gray-200 relative flex-shrink-0">
                                    @if(!empty($post->images) && count($post->images) > 0)
                                        <img src="{{ asset('storage/'.$post->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100"><i class="fas fa-image text-3xl opacity-30"></i></div>
                                    @endif
                                </a>
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition"><a href="{{ route('customer.post.edit', $post->id) }}">{{ $post->title }}</a></h3>
                                            <span class="text-xl font-extrabold text-gray-900">₹{{ number_format($post->price) }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500 flex items-center gap-1 mb-3"><i class="fas fa-map-marker-alt text-gray-400"></i> {{ $post->city }}, {{ $post->state }}</p>
                                        <div class="flex gap-2">
                                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded text-xs font-bold border border-blue-100">{{ $post->type }}</span>
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold border border-gray-200">{{ $post->listing_type }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                        <span class="text-xs text-gray-500">Added {{ $post->created_at->format('d M, Y') }}</span>
                                        <div class="flex gap-3">
                                            <a href="{{ route('customer.post.edit', $post->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold flex items-center gap-1"><i class="fas fa-edit"></i> Edit</a>
                                            <button wire:click="delete({{ $post->id }})" onclick="confirm('Delete?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1"><i class="fas fa-trash-alt"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="mt-8">{{ $posts->links() }}</div>

            @else
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="bg-gray-50 rounded-full h-24 w-24 flex items-center justify-center mb-4"><i class="fas fa-search text-4xl text-gray-300"></i></div>
                    <h3 class="text-xl font-bold text-gray-900">No Ads Found</h3>
                    <a href="{{ route('post.choose-category') }}" class="mt-6 bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-lg flex items-center gap-2"><i class="fas fa-plus"></i> Post New Ad</a>
                </div>
            @endif
        </div>
    </div>
</div>