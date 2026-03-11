<div class="bg-[#f2f5f4] min-h-screen py-4" x-data="{ toast: null }" @notify.window="toast = $event.detail; setTimeout(() => toast = null, 3000)">
    
    {{-- Toast Notification --}}
    <div x-show="toast" x-transition class="fixed top-24 right-10 z-[999] bg-black text-white px-6 py-3 rounded-xl shadow-2xl font-bold flex items-center gap-3">
        <i class="fas fa-check-circle text-green-400"></i> <span x-text="toast.message"></span>
    </div>
    <div class="max-w-[1440px] mx-auto px-4">
        {{-- Breadcrumbs --}}
        <nav class="flex text-[10px] font-bold text-gray-400 uppercase mb-4 gap-2">
            <a href="/" class="hover:text-leaf-green">Home</a> / 
            <a href="/marketplace" class="hover:text-leaf-green">Marketplace</a> / 
            <span class="text-gray-600 truncate">{{ $product->name }}</span>
        </nav>

        <div style="display: flex; flex-wrap: nowrap; gap: 20px; align-items: flex-start;">
            
            {{-- COLUMN 1: IMAGE (35%) --}}
            <div style="flex: 0 0 38%; max-width: 38%;" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sticky top-20">
                <!-- <div class="relative w-full aspect-square border border-gray-100 rounded-lg overflow-hidden bg-white mb-4 flex items-center justify-center"> -->
                    <img src="{{ route('ad.display', ['path' => $mainImage]) }}" 
                         class="max-h-[450px] w-auto object-contain p-4">
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-600 text-white text-[10px] font-black px-2 py-1 rounded shadow-sm italic">Top Seller</span>
                    </div>
                <!-- </div> -->
                <div class="flex gap-2 overflow-x-auto no-scrollbar">
                    @foreach($product->images as $img)
                        <button wire:click="$set('mainImage', '{{ $img }}')" class="h-16 w-16 border-2 rounded-lg overflow-hidden flex-shrink-0 {{ $mainImage == $img ? 'border-leaf-green' : 'border-gray-100' }}">
                            <img src="{{ route('ad.display', ['path' => $img]) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- COLUMN 2: PRODUCT DETAIL (38%) --}}
            <div style="flex: 0 0 38%; max-width: 38%;" class="flex flex-col gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h1 class="text-2xl font-black text-gray-900 leading-tight mb-2 uppercase">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 underline cursor-pointer">4.5 (24 Reviews)</span>
                    </div>

                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-3xl font-black text-gray-900">₹{{ number_format($product->discounted_price ?? $product->price) }}</span>
                        @if($product->discount_percentage > 0)
                            <span class="text-sm text-gray-400 line-through font-bold">₹{{ number_format($product->price) }}</span>
                            <span class="text-leaf-green text-xs font-black">{{ $product->discount_percentage }}% OFF</span>
                        @endif
                    </div>

                    {{-- Dynamic Bulk Pricing Blocks --}}
                    @if(!empty($product->tiered_pricing))
                    <div class="mb-6">
                        <p class="text-[10px] font-black text-gray-900 uppercase mb-3 tracking-widest">Buy More & Save More (Click to Select)</p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($product->tiered_pricing as $tier)
                            <div wire:click="selectBulkTier({{ $tier['min_qty'] }})" class="border rounded-lg p-2 text-center bg-gray-50 border-gray-200 cursor-pointer hover:border-leaf-green hover:bg-green-50 transition shadow-sm">
                                <p class="text-[9px] font-bold text-gray-500">Qty {{ $tier['min_qty'] }}+</p>
                                <p class="text-xs font-black text-gray-900">₹{{ number_format($tier['unit_price']) }}/pc</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="space-y-6 pt-4 border-t border-gray-50">
                        <h3 class="text-sm font-black text-gray-900 uppercase border-l-4 border-leaf-green pl-2">About This Product</h3>
                        <p class="text-[11px] leading-relaxed text-gray-600">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-black text-gray-900 mb-4 uppercase">Product Specifications</h3>
                    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3"> -->
                        @if($product->colors)
            <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                <span class="text-[10px] text-gray-400 font-bold uppercase">Color</span>
                <div class="flex items-center gap-2">
                    {{-- Comma separated text --}}
                    <span class="text-[10px] text-gray-900 font-black uppercase">
                        {{ is_array($product->colors) ? implode(', ', $product->colors) : $product->colors }}
                    </span>
                    {{-- Visual Color Circles --}}
                    <div class="flex gap-1">
                        @foreach((is_array($product->colors) ? $product->colors : [$product->colors]) as $color)
                            <span class="w-3 h-3 rounded-full border border-gray-200" style="background-color: {{ strtolower($color) }};"></span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Size Display --}}
        @if($product->sizes)
            <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                <span class="text-[10px] text-gray-400 font-bold uppercase">Available Sizes</span>
                <span class="text-[10px] text-gray-900 font-black uppercase">
                    {{ is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes }}
                </span>
            </div>
        @endif

                        {{-- Other Specifications --}}
                        @foreach($product->specifications ?? [] as $spec)
                        <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                            <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $spec['key'] }}</span>
                            <span class="text-[10px] text-gray-900 font-black uppercase">{{ $spec['value'] }}</span>
                        </div>
                        @endforeach
                    <!-- </div> -->
                </div>
            </div>

            {{-- COLUMN 3: CART/BUY (27%) --}}
            <div style="flex: 0 0 22%; max-width: 22%;" class="flex flex-col gap-4 sticky top-24">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                    {{-- TOTALS DISPLAY --}}
                    <div class="mb-6 space-y-2 border-b pb-4">
                        <div class="flex justify-between text-xs font-bold text-gray-400 italic">
                            <span>GST (18%)</span>
                            <span>₹{{ number_format($gst) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Incl. of all taxes</span>
                            <span class="text-2xl font-black text-gray-900">₹{{ number_format($totalAmount) }}</span>
                        </div>
                    </div>
                    
                    {{-- QTY CONTROL OR ADD BUTTON --}}
                    <div class="mb-6">
                        @if($cartItem)
                            <div class="bg-gray-50 rounded-lg p-4 border border-leaf-green">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-600 uppercase">Qty in Cart</span>
                                    <div class="flex items-center gap-4 bg-white border border-leaf-green rounded-lg px-2">
                                        <button wire:click="decrement({{ $cartItem->id }})" class="text-leaf-green font-black text-xl px-2">-</button>
                                        <span class="font-black text-sm">{{ $cartItem->quantity }}</span>
                                        <button wire:click="increment({{ $cartItem->id }})" class="text-leaf-green font-black text-xl px-2">+</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <button wire:click="addToCart({{ $product->id }})" 
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $product->id }})"
                                    style="display: block !important; opacity: 1 !important; visibility: visible !important;" 
                                    class="w-full bg-[#2D5A27] text-white text-[9px] font-black py-4 rounded-lg hover:bg-soil-green transition flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart" wire:loading.remove wire:target="addToCart({{ $product->id }})"></i>
                                <i class="fas fa-spinner fa-spin" wire:loading wire:target="addToCart({{ $product->id }})"></i>
                                ADD TO CART
                            </button>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <button wire:click="buyNow" 
                                style="display: block !important; opacity: 1 !important; visibility: visible !important; background-color: #bc6c10 !important;" 
                                class="w-full text-white font-black py-4 rounded-xl hover:bg-red-700 transition uppercase text-xs tracking-widest shadow-lg">
                            BUY NOW
                        </button>
                    </div>
                </div>
            </div>

        </div>
        {{-- BOTTOM: CATEGORY SLIDER --}}
        <div class="mt-12">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-12">
                <h2 class="text-lg font-black text-gray-900 uppercase mb-6 border-b pb-4">Similar Products from this category</h2>
                <div class="flex gap-4 overflow-x-auto no-scrollbar pb-4">
                    @foreach(range(1, 8) as $item)
                        <div class="w-[165px] flex-shrink-0 group cursor-pointer">
                            <div class="aspect-square bg-white rounded-xl mb-3 flex items-center justify-center p-4 border border-gray-100 group-hover:border-leaf-green transition-all">
                                <img src="https://via.placeholder.com/150" class="max-h-full w-auto object-contain">
                            </div>
                            <p class="text-[10px] font-black text-gray-900 truncate uppercase">Industrial Product {{ $item }}</p>
                            <p class="text-xs font-black text-leaf-green mt-1">₹{{ number_format($product->price * 0.9) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RATINGS & REVIEWS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                @for($i=0; $i<2; $i++)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center font-black text-leaf-green uppercase">JD</div>
                            <div>
                                <p class="text-[11px] font-black text-gray-900 uppercase">Verified Customer</p>
                                <div class="flex text-yellow-400 text-[8px] mt-0.5">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-gray-400">Mar 2026</span>
                    </div>
                    <p class="text-[11px] text-gray-600 font-medium italic">"Excellent build quality. The bulk pricing saved us a lot for our construction project."</p>
                </div>
                @endfor
            </div>
            <div class="text-center pb-12">
                <button class="bg-white border-2 border-leaf-green text-leaf-green px-10 py-3 rounded-xl font-black text-xs uppercase hover:bg-green-50">View More Reviews</button>
            </div>
        </div>
    </div>
</div>