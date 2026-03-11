<div class="min-h-screen bg-[#f4f7f6] pb-20">
    {{-- 1. ADS BANNER (Fetched from Ads table) --}}
    <div class="bg-white border-b border-gray-200 py-6 mb-8 shadow-sm">
        <div class="max-w-[1440px] mx-auto px-6">
            <h3 class="text-[11px] font-black uppercase text-gray-400 mb-4 tracking-[0.2em]">Featured Promotions</h3>
            <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar snap-x">
                @foreach($bannerAds as $ad)
                <div class="flex-none w-48 h-48 rounded-2xl overflow-hidden snap-start shadow-sm border border-gray-100 hover:border-leaf-green transition-all">
                    <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto flex gap-8 px-6">
        {{-- 2. STICKY SIDEBAR --}}
        <aside class="w-1/4 hidden lg:block">
            <div class="sticky top-28 bg-white rounded-[2rem] border border-gray-200 p-8 shadow-sm z-30">
                <h3 class="text-xs font-black uppercase mb-8 flex items-center gap-3">
                    <i class="fas fa-sliders-h text-leaf-green"></i> Filter Gallery
                </h3>
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group py-1">
                            <input type="checkbox" wire:model.live="category" value="{{ $cat->id }}" class="rounded text-leaf-green focus:ring-leaf-green border-gray-300">
                            <span class="text-xs font-bold text-gray-600 group-hover:text-leaf-green transition uppercase">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- 3. PRODUCT GRID --}}
        <main class="w-full lg:w-4/5">
            {{-- Main Grid --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
    @foreach($products as $product)
        <div class="bg-white rounded-xl border border-gray-200 hover:border-leaf-green hover:shadow-md transition-all p-2 flex flex-col group relative">
            <div class="absolute top-2 left-2 bg-red-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded z-10 italic">30% OFF</div>
            
            <a href="{{ route('public.product.detail', $product->slug) }}" class="block w-full h-32 overflow-hidden rounded-lg bg-gray-50 mb-2">
                <img src="{{ route('ad.display', ['path' => $product->images[0] ?? '']) }}" 
                     class="h-full w-full object-contain p-2 group-hover:scale-105 transition duration-300">
            </a>

            <div class="flex-grow px-1">
                <h3 class="text-[10px] font-bold text-gray-800 line-clamp-2 leading-tight min-h-[24px] mb-2">{{ $product->name }}</h3>
                <div class="flex items-center gap-1.5 mb-3">
                    <span class="text-sm font-black text-leaf-green">₹{{ number_format($product->price) }}</span>
                    <span class="text-[8px] text-gray-400 line-through">₹{{ number_format($product->price * 1.3) }}</span>
                </div>
            </div>

            {{-- RESTORED QUANTITY CONTROL FOR LISTING --}}
            @php
                $cartItem = auth()->check() 
                    ? \App\Models\Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first() 
                    : null;
            @endphp

            @if($cartItem)
                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-0.5 border border-leaf-green">
                    <button wire:click="decrement({{ $cartItem->id }})" class="w-8 h-8 flex items-center justify-center bg-white rounded shadow-sm font-black text-leaf-green hover:bg-leaf-green hover:text-white transition">-</button>
                    <span class="font-black text-xs">{{ $cartItem->quantity }}</span>
                    <button wire:click="increment({{ $cartItem->id }})" class="w-8 h-8 flex items-center justify-center bg-white rounded shadow-sm font-black text-leaf-green hover:bg-leaf-green hover:text-white transition">+</button>
                </div>
            @else
                <button wire:click="addToCart({{ $product->id }})" 
                    wire:loading.attr="disabled"
                    wire:target="addToCart({{ $product->id }})"
                    class="w-full bg-[#2D5A27] text-white text-[9px] font-black py-2.5 rounded-lg hover:bg-soil-green transition flex items-center justify-center gap-2"
                >
                    <i class="fas fa-shopping-cart" wire:loading.remove wire:target="addToCart({{ $product->id }})"></i>
                    <i class="fas fa-spinner fa-spin" wire:loading wire:target="addToCart({{ $product->id }})"></i>
                    ADD TO CART
                </button>
            @endif
        </div>
    @endforeach
</div>
            <div class="mt-8">{{ $products->links() }}</div>
        </main>
    </div>
</div>