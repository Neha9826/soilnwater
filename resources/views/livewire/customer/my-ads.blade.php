<div class="w-full bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
            <div class="w-full md:w-auto">
                <h1 class="text-3xl font-extrabold text-gray-900">My Ads</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your classified ads and fixed-template promotions.</p>
            </div>

            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                {{-- Search Bar --}}
                <div class="relative w-full sm:w-72">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Search ads..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm">
                </div>

                <div class="flex gap-2 flex-shrink-0">
                    {{-- Post Button --}}
                    <a href="{{ route('customer.ad.create') }}" class="h-[42px] flex items-center gap-2 bg-blue-600 text-white px-6 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition">
                        <i class="fas fa-plus"></i>
                        <span>Create Ad</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="min-h-[400px]">
            @if($ads->count() > 0)
                {{-- DYNAMIC GRID VIEW: Supports 1x1, 2x1, 2x2 --}}
                {{--  --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-[300px] grid-flow-row-dense">
                    @foreach($ads as $ad)
                        @php
                            // 1. Determine Grid Spans from Ad Tier
                            $w = $ad->template->tier->grid_width;
                            $h = $ad->template->tier->grid_height;
                            
                            $spanClass = ($w > 1 ? 'md:col-span-'.$w : 'col-span-1') . ' ' . 
                                         ($h > 1 ? 'md:row-span-'.$h : 'row-span-1');

                            // 2. Map Dynamic Values to Array for Template
                            $data = $ad->values->mapWithKeys(function ($item) {
                                return [$item->field->field_name => $item->value];
                            })->toArray();
                        @endphp

                        <div class="{{ $spanClass }} bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative group">
                            
                            {{-- 3. Render the Specific Design Template --}}
                            <div class="w-full h-full">
                                @include($ad->template->blade_path, [
                                    'data' => $data, 
                                    'ad' => $ad,
                                    'bg_color' => $ad->bg_color ?? '#ffffff'
                                ])
                            </div>

                            {{-- Hover Actions Overlay --}}
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-3">
                                <div class="bg-white text-gray-900 px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                                    Status: {{ $ad->status }}
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="delete({{ $ad->id }})" 
                                            onclick="confirm('Delete this ad?') || event.stopImmediatePropagation()" 
                                            class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">{{ $ads->links() }}</div>
            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="bg-gray-50 rounded-full h-24 w-24 flex items-center justify-center mb-4"><i class="fas fa-bullhorn text-4xl text-gray-400"></i></div>
                    <h3 class="text-xl font-bold text-gray-900">No Ads Found</h3>
                    <p class="text-gray-500 mt-2 mb-6 max-w-sm text-center">You haven't posted any classified ads or fixed-template promotions yet.</p>
                    <a href="{{ route('customer.ad.create') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg">
                        Create Your First Ad
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>