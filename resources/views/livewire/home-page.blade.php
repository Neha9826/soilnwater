<div class="min-h-screen bg-[#FDFDFD]">

    <div class="max-w-[1440px] mx-auto ">

        {{-- Remove 'max-w' and 'px-6' from here to make the background hit the screen edges --}}
        <section class="relative bg-gradient-to-b from-[#4CAF50] to-[#ffffff] w-full py-10 overflow-hidden">
            
            {{-- 1. OUTER LEAF PATTERN: This fills the 'Red Marked' area in your screenshot --}}
            <div class="absolute w-full inset-0 opacity-30 pointer-events-none" 
                style="background-image: url('{{ asset('images/hero_trans_leaves.png') }}'); background-repeat: repeat; background-size: 200px;">
            </div>

            {{-- 2. THE BANNER CONTAINER: Centered with max-width --}}
            <div class="max-w-[1440px] mx-auto px-6 relative z-10">
                <div class="relative h-[280px] w-full rounded-[35px] overflow-hidden shadow-2xl group border border-green-100/20"
                    x-data="{ 
                        active: 0, 
                        loop() { setInterval(() => { this.active = (this.active + 1) % {{ $heroBanners->count() ?: 1 }} }, 5000) } 
                    }" 
                    x-init="loop()">
                    
                    {{-- Base Gradient & Patterns (Stay consistent behind the slider) --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-[#2D5A27] via-[#3d7a35] to-[#4CAF50]"></div>
                    <div class="absolute inset-0 opacity-10 pointer-events-none" 
                        style="background-image: url('{{ asset('images/hero_trans_leaves.png') }}'); background-repeat: repeat;">
                    </div>

                    {{-- THE SLIDER: Fetches only the banner ad images --}}
                    @forelse($heroBanners as $index => $banner)
                        <div x-show="active === {{ $index }}" 
                            x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-1000"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute inset-0 w-full h-full">
                            
                            {{-- Ad Image using secure route for Hostinger compatibility --}}
                            <img src="{{ route('ad.display', ['path' => $banner->preview_image]) }}" 
                                class="w-full h-full object-cover">
                        </div>
                    @empty
                        {{-- Fallback: Displays your original static text if no banner ads exist --}}
                        <div class="absolute inset-0 flex items-center px-16 z-10">
                            <div class="text-white max-w-lg">
                                <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 inline-block border border-white/30">
                                    Featured Solutions
                                </span>
                                <h1 class="text-4xl md:text-5xl font-black leading-tight mb-2">Green Energy Solutions</h1>
                                <p class="text-sm text-white/90 mb-6">Explore sustainable products and professional services for your next project.</p>
                                <a href="#" class="bg-white text-[#2D5A27] px-8 py-3 rounded-2xl font-black text-sm shadow-lg">Explore Now</a>
                            </div>
                        </div>
                    @endforelse

                    {{-- 3. THE GRAPHIC: Kept in front of the slider images for branding --}}
                    

                    {{-- Slider Indicators (Navigation Dots) --}}
                    @if($heroBanners->count() > 1)
                        <div class="absolute bottom-6 left-0 right-0 z-30 flex justify-center gap-2">
                            @foreach($heroBanners as $index => $banner)
                                <button @click="active = {{ $index }}" 
                                        :class="active === {{ $index }} ? 'bg-white w-8' : 'bg-white/40 w-2'"
                                        class="h-2 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- TRENDING PRODUCTS: Refined Grid with Badges --}}
        <div class="max-w-[1440px] mx-auto px-6 pb-12">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-gray-900">Trending Industrial Products</h2>
                <a href="#" class="text-sm font-bold text-[#4CAF50] hover:underline">SEE ALL PRODUCTS</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @foreach($products as $product)
                    <div class="bg-white border border-gray-100 rounded-[28px] p-5 hover:shadow-2xl transition group relative">
                        <div class="h-44 flex items-center justify-center mb-4 bg-gray-50 rounded-2xl overflow-hidden p-4">
                            @php $pImg = is_string($product->images) ? json_decode($product->images, true) : $product->images; @endphp
                            <img src="{{ !empty($pImg) ? route('ad.display', ['path' => $pImg[0]]) : asset('images/placeholder.png') }}" 
                                class="max-h-full max-w-full object-contain group-hover:scale-110 transition duration-500">
                        </div>

                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $product->brand ?? 'Industrial' }}</div>
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-2 h-10 leading-tight mb-3">{{ $product->name }}</h3>

                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg font-black text-[#2D5A27]">₹{{ number_format($product->price) }}</span>
                            <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded">20% OFF</span>
                        </div>

                        <button class="w-full py-2.5 border-2 border-[#4CAF50] text-[#4CAF50] rounded-xl font-bold text-xs hover:bg-[#4CAF50] hover:text-white transition-all transform active:scale-95">
                            ADD TO CART
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        
        {{-- EXCLUSIVE OFFERS: Horizontal Scroll --}}
        <div class="max-w-[1440px] mx-auto px-6 py-12">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                    <span class="text-red-600">🔥</span> Exclusive Offers
                </h2>
                <a href="#" class="text-sm font-bold text-red-600 hover:underline">VIEW ALL OFFERS</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($offers as $offer)
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-red-50 hover:shadow-xl transition-all group relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-red-600 text-white px-4 py-1.5 rounded-bl-2xl font-bold text-xs">
                            {{ $offer->discount_tag ?? 'Special Deal' }}
                        </div>
                        <div class="h-40 bg-gray-50 rounded-2xl mb-4 overflow-hidden">
                            <img src="{{ $offer->image ? route('ad.display', ['path' => $offer->image]) : asset('images/offer_placeholder.png') }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $offer->title }}</h3>
                        <p class="text-gray-500 text-xs mb-4 line-clamp-1">{{ $offer->description }}</p>
                        <button class="w-full py-2 bg-[#2D5A27] text-white rounded-xl font-bold text-sm hover:bg-[#4CAF50] transition">Claim Deal</button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ADS & PROMOTIONS: Refined Grid --}}
        <div class="mb-20 relative py-12 px-6 rounded-[40px] overflow-hidden shadow-inner bg-gradient-to-b from-white to-[#f0f9f0]">
            
            {{-- Leaf Pattern Background --}}
            <div class="absolute inset-0 opacity-20 pointer-events-none" 
                style="background-image: url('{{ asset('images/hero_trans_leaves.png') }}'); background-repeat: repeat; background-size: 200px;">
            </div>

            <div class="max-w-[1440px] mx-auto relative z-10">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900">Ads & Promotions</h2>
                        <div class="h-1.5 w-20 bg-[#4CAF50] mt-2 rounded-full"></div>
                    </div>
                    {{-- Update this link to your dedicated ads page route --}}
                    <a href="{{ route('public.ads.index') }}" class="text-sm font-bold text-[#4CAF50] hover:text-[#2D5A27] transition flex items-center gap-1">
                        See All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                {{-- Grid Container: Fixed 4 columns and 2 rows --}}
                <div style="display: grid; 
                            grid-template-columns: repeat(4, 1fr); 
                            grid-template-rows: repeat(2, 280px); 
                            grid-auto-flow: dense; 
                            gap: 24px; 
                            overflow: hidden;">
                    
                    @foreach($promotedAds as $ad)
                        @php
                            $w = (int)($ad->template->tier->grid_width ?? 1);
                            $h = (int)($ad->template->tier->grid_height ?? 1);
                            $style = "grid-column: span {$w}; grid-row: span {$h};";
                        @endphp
                        <div style="{{ $style }}" class="relative group bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                            {{-- Secure image route for Hostinger --}}
                            <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            
                            {{-- Glassmorphism Overlay on Hover --}}
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-[#2D5A27] shadow-lg">View Offer</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- FEATURED SERVICE PROVIDERS & CONSULTANTS --}}
        <section class="max-w-[1440px] mx-auto px-6 py-20 border-t border-gray-100">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-gray-900">Featured on SoilNWater</h2>
                <p class="text-gray-500 mt-2">Connect with verified experts for your construction and design needs.</p>
                <div class="h-1.5 w-24 bg-[#4CAF50] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10">
                @foreach($experts as $expert)
                    <a href="{{ route('public.store', $expert->store_slug) }}" class="group flex flex-col items-center text-center">
                        {{-- Circular Profile Image --}}
                        <div class="h-32 w-32 rounded-full p-1.5 border-2 border-transparent group-hover:border-[#4CAF50] transition-all duration-500 mb-4 bg-white shadow-md">
                            <div class="h-full w-full rounded-full overflow-hidden bg-gray-50 border border-gray-100">
                                @if($expert->store_logo)
                                    {{-- Use secure route for live server --}}
                                    <img src="{{ route('ad.display', ['path' => $expert->store_logo]) }}" 
                                        class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-[#2D5A27] font-black text-2xl">
                                        {{ substr($expert->store_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Expert Details --}}
                        <h4 class="font-bold text-gray-900 group-hover:text-[#4CAF50] transition-colors line-clamp-1">
                            {{ $expert->store_name }}
                        </h4>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mt-1">
                            {{ $expert->service_category ?? 'Expert' }}
                        </p>
                        
                        {{-- Verified Badge --}}
                        <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-green-50 text-green-700 text-[9px] font-black px-2 py-0.5 rounded-full border border-green-100">
                                <i class="fas fa-check-circle mr-1"></i>VERIFIED
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- REAL ESTATE SECTION --}}
        <div class="mb-20">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-black text-gray-900">Real Estate</h2>
                <a href="#" class="text-sm font-bold text-blue-600 hover:underline">EXPLORE PROPERTIES</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($properties as $property)
                    <div class="bg-white rounded-[28px] overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 group">
                        <div class="h-56 bg-gray-100 relative overflow-hidden">
                             @if($property->images)
                                <img src="{{ route('ad.display', ['path' => $property->images[0]]) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-md text-[#2D5A27] text-[10px] font-black px-3 py-1 rounded-full uppercase shadow-sm">
                                    {{ $property->type }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 text-lg truncate mb-1">{{ $property->title }}</h3>
                            <p class="text-gray-400 text-xs mb-4 flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-[#4CAF50]"></i> {{ $post->city ?? 'Dehradun' }}
                            </p>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                                <span class="text-2xl font-black text-[#2D5A27]">₹{{ number_format($property->price) }}</span>
                                <a href="#" class="h-10 w-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-[#4CAF50] hover:text-white transition">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>