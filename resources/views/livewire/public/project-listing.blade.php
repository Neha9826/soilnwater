<div class="min-h-screen bg-[#f4f7f6] pb-20">
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-[1536px] mx-auto px-6 h-20 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Upcoming Projects</h1>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">New Builder Launches</p>
            </div>
            <div class="flex items-center gap-4">
                <select wire:model.live="sort" class="bg-gray-50 border-none rounded-xl px-4 py-2.5 text-[10px] font-black uppercase">
                    <option value="latest">Sort: Newest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>
                <button wire:click="toggleFilters" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl font-black text-[10px] uppercase flex items-center gap-2 hover:bg-green-600 transition">
                    <i class="fas fa-sliders-h"></i> Filters
                </button>
            </div>
        </div>
        
        <div x-show="$wire.showFilters" x-collapse x-cloak class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-[1536px] mx-auto px-8 py-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <label class="text-[10px] font-black uppercase text-gray-400 mb-3 block">Project Name / City</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..." class="w-full bg-white border-none rounded-2xl px-5 py-4 text-xs font-bold shadow-sm focus:ring-2 focus:ring-green-600">
                </div>
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 mb-3 block">Budget Range (₹)</label>
                    <div class="flex items-center gap-4">
                        <input type="number" wire:model.live="minPrice" placeholder="Min" class="flex-1 bg-white border-none rounded-2xl px-5 py-4 text-xs font-bold shadow-sm">
                        <span class="text-gray-300 font-bold">TO</span>
                        <input type="number" wire:model.live="maxPrice" placeholder="Max" class="flex-1 bg-white border-none rounded-2xl px-5 py-4 text-xs font-bold shadow-sm">
                    </div>
                </div>
                <div class="flex items-end"><button wire:click="$set('search', ''); $set('minPrice', ''); $set('maxPrice', '')" class="w-full bg-white border-2 border-gray-100 text-gray-400 font-black py-4 rounded-2xl text-[10px] uppercase hover:bg-red-50 transition">Reset</button></div>
            </div>
        </div>
    </div>

    <div class="max-w-[1536px] mx-auto px-6 py-12">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
            @foreach($projects as $project)
                <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 group flex flex-col">
                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                        @php $pImgs = is_array($project->images) ? $project->images : json_decode($project->images, true); @endphp
                        <img src="{{ route('ad.display', ['path' => $pImgs[0] ?? '']) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4 bg-leaf-green text-white text-[7px] font-black px-3 py-1 rounded-full uppercase">{{ $project->project_status }}</div>
                    </div>
                    <div class="p-5 flex-grow">
                        <h3 class="text-xs font-black text-gray-900 truncate uppercase mb-1">{{ $project->title }}</h3>
                        <p class="text-[9px] font-bold text-gray-400 mb-4 uppercase truncate"><i class="fas fa-map-marker-alt text-green-500"></i> {{ $project->city }}</p>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                            <span class="text-sm font-black text-gray-900">₹{{ number_format($project->price) }}</span>
                            <a href="{{ route('public.project.detail', $project->slug) }}" class="text-[9px] font-black text-gray-400 border border-gray-100 px-4 py-2 rounded-full hover:bg-green-600 hover:text-white transition uppercase">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-16">{{ $projects->links() }}</div>
    </div>
</div>