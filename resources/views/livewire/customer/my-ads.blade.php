<div class="w-full bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">My Ads</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your professional template promotions.</p>
            </div>
            <a href="{{ route('customer.ad.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Create New Ad
            </a>
        </div>

        <div class="min-h-[400px]">
            @if($ads->count() > 0)
                {{-- DYNAMIC GRID: Using auto-rows to prevent overlap --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 auto-rows-[350px]">
                    @foreach($ads as $ad)
                        @php
                            $w = $ad->template->tier->grid_width ?? 1;
                            $h = $ad->template->tier->grid_height ?? 1;
                            
                            $spanClass = ($w > 1 ? 'md:col-span-'.$w : 'col-span-1') . ' ' . 
                                         ($h > 1 ? 'md:row-span-'.$h : 'row-span-1');

                            // Mapping dynamic user values
                            $data = $ad->values->mapWithKeys(function ($item) {
                                return [$item->field->field_name => $item->value];
                            })->toArray();
                        @endphp

                        <div class="{{ $spanClass }} bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative group flex flex-col">
                            
                            {{-- THE SCALED PREVIEW: Scaling 500px down to fit container --}}
                            <div class="relative flex-1 bg-gray-100 flex items-center justify-center overflow-hidden">
                                <div style="transform: scale(0.55); transform-origin: center;" class="pointer-events-none">
                                    @include($ad->template->blade_path, ['data' => $data])
                                </div>

                                {{-- Action Overlay: Now clearly visible on top --}}
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-4 z-50">
                                    <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                        Status: {{ $ad->status }}
                                    </span>
                                    
                                    {{-- Fixed Delete Button --}}
                                    {{-- In my-ads.blade.php --}}
<button wire:click="deleteAd({{ $ad->id }})" 
        wire:confirm="Are you sure you want to delete this design?"
        class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700">
    <i class="fas fa-trash"></i>
</button>
                                </div>
                            </div>

                            {{-- Title Info Bar --}}
                            <div class="p-3 border-t border-gray-100 bg-white">
                                <h4 class="text-xs font-bold text-gray-800 truncate">{{ $ad->title }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">{{ $ads->links() }}</div>
            @else
                {{-- EMPTY STATE (Kept as is) --}}
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <i class="fas fa-bullhorn text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900">No Ads Found</h3>
                </div>
            @endif
        </div>
    </div>
</div>