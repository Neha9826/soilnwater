<div class="bg-gray-50 min-h-screen pb-20">
    <div class="max-w-[1440px] mx-auto px-6 py-10">
        
        {{-- Header & Filters --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-black text-gray-900 uppercase">Marketplace</h1>
                <p class="text-gray-500 font-bold">Verified industrial tools and construction materials.</p>
            </div>
            
            <div class="flex gap-4 w-full md:w-auto">
                <select wire:model.live="category" class="bg-white border-2 border-gray-100 rounded-2xl px-6 py-3 font-bold text-sm outline-none focus:border-[#4CAF50]">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-500 flex flex-col">
                    {{-- Image Area --}}
                    <div class="relative h-64 overflow-hidden bg-gray-50">
                        @php $img = is_array($product->images) && count($product->images) > 0 ? $product->images[0] : null; @endphp
                        <img src="{{ $img ? route('ad.display', ['path' => $img]) : asset('images/placeholder.png') }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        
                        @if($product->discount_percentage > 0)
                            <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-lg">
                                {{ $product->discount_percentage }}% OFF
                            </div>
                        @endif
                    </div>

                    {{-- Info Area --}}
                    <div class="p-6 flex-grow flex flex-col">
                        <span class="text-[10px] font-black text-[#4CAF50] uppercase tracking-widest mb-1">{{ $product->category->name ?? 'General' }}</span>
                        <a href="{{ route('public.product.detail', $product->slug) }}" class="block">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">{{ $product->name }}</h3>
                        </a>
                        
                        <div class="mt-auto">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-gray-900">₹{{ number_format($product->discounted_price ?: $product->price) }}</span>
                                @if($product->discounted_price)
                                    <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            
                            {{-- Updated Button with wire:click --}}
                            @php
    // Check if the product is already in the cart for the logged-in user
    $cartItem = auth()->check() 
        ? \App\Models\Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first() 
        : null;
@endphp

<div class="w-full mt-4">
    @if($cartItem)
        {{-- Quantity Controls --}}
        <div class="flex items-center justify-between bg-gray-100 rounded-xl p-1 border-2 border-[#2D5A27]">
            <button wire:click="decrement({{ $cartItem->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-lg shadow-sm font-black text-[#2D5A27]">-</button>
            <span class="font-black text-lg">{{ $cartItem->quantity }}</span>
            <button wire:click="increment({{ $cartItem->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-lg shadow-sm font-black text-[#2D5A27]">+</button>
        </div>
    @else
        {{-- Add to Cart Button --}}
        <button 
    wire:click="addToCart({{ $product->id }})" 
    wire:loading.attr="disabled"
    wire:target="addToCart({{ $product->id }})" {{-- CRITICAL: Only target this specific ID --}}
    class="w-full mt-4 bg-[#2D5A27] text-white font-black py-3 rounded-xl hover:bg-[#1E461A] transition transform active:scale-95 shadow-md flex items-center justify-center gap-2"
>
    <i class="fas fa-shopping-cart text-sm" wire:loading.remove wire:target="addToCart({{ $product->id }})"></i>
    <i class="fas fa-spinner fa-spin text-sm" wire:loading wire:target="addToCart({{ $product->id }})"></i>
    <span>Add to Cart</span>
</button>
    @endif
</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-200">
                    <i class="fas fa-box-open text-6xl text-gray-200 mb-4"></i>
                    <h2 class="text-2xl font-black text-gray-400 uppercase">No Products Found</h2>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>