<div class="bg-white min-h-screen pb-20">
    <div class="max-w-[1440px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            {{-- Left Side: Image Gallery --}}
            <div class="space-y-6">
                <div class="aspect-square rounded-[3rem] overflow-hidden bg-gray-50 border border-gray-100 shadow-sm">
                    <img src="{{ $mainImage ? route('ad.display', ['path' => $mainImage]) : asset('images/placeholder.png') }}" 
                         class="w-full h-full object-cover transition-all duration-500">
                </div>

                @if(is_array($product->images) && count($product->images) > 1)
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        @foreach($product->images as $img)
                            <button wire:click="setMainImage('{{ $img }}')" 
                                    class="flex-shrink-0 w-24 h-24 rounded-2xl overflow-hidden border-2 {{ $mainImage == $img ? 'border-[#4CAF50]' : 'border-transparent' }} transition">
                                <img src="{{ route('ad.display', ['path' => $img]) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Right Side: Product Info --}}
            <div class="flex flex-col">
                <nav class="flex text-xs font-black uppercase tracking-widest text-gray-400 mb-4 gap-2">
                    <a href="/" class="hover:text-[#4CAF50]">Home</a>
                    <span>/</span>
                    <a href="{{ route('public.products.index') }}" class="hover:text-[#4CAF50]">Marketplace</a>
                    <span>/</span>
                    <span class="text-[#2D5A27]">{{ $product->category->name ?? 'General' }}</span>
                </nav>

                <h1 class="text-4xl font-black text-gray-900 leading-tight mb-4 uppercase">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="text-3xl font-black text-gray-900">₹{{ number_format($product->discounted_price ?: $product->price) }}</div>
                    @if($product->discounted_price)
                        <div class="text-lg text-gray-400 line-through">₹{{ number_format($product->price) }}</div>
                        <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-black">{{ $product->discount_percentage }}% OFF</div>
                    @endif
                </div>

                <div class="prose prose-sm text-gray-500 mb-8 max-w-none">
                    <h4 class="text-gray-900 font-black uppercase text-sm tracking-widest mb-2">Description</h4>
                    <p>{{ $product->description }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                    <button class="bg-[#2D5A27] text-white font-black py-5 rounded-2xl shadow-xl hover:bg-[#1E461A] transition transform active:scale-95 flex items-center justify-center gap-3">
                        <i class="fas fa-shopping-bag"></i> BUY NOW
                    </button>
                    <button class="bg-white border-2 border-gray-100 text-gray-900 font-black py-5 rounded-2xl hover:bg-gray-50 transition flex items-center justify-center gap-3">
                        <i class="far fa-heart"></i> WISHLIST
                    </button>
                </div>

                {{-- Vendor Info Card --}}
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex items-center gap-4">
                    <div class="h-14 w-14 rounded-full bg-[#4CAF50] flex items-center justify-center text-white font-black text-xl">
                        {{ substr($product->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xs font-black text-gray-400 uppercase tracking-widest">Sold By</div>
                        <div class="text-lg font-bold text-gray-900">{{ $product->user->name }}</div>
                    </div>
                    <a href="#" class="ml-auto text-[#4CAF50] font-black text-xs hover:underline uppercase">View Store</a>
                </div>
            </div>
        </div>
    </div>
</div>