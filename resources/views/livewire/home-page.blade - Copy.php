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
        {{-- The main container with 1/4 (ad) and 3/4 (products) split --}}
        <section class="max-w-[1440px] mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
            
            {{-- Left Side: The Vertical Ad (Stays constant) --}}
            <div class="md:col-span-1" x-data="{ active: 0, timer: null }" 
                x-init="timer = setInterval(() => { active = (active + 1) % {{ $verticalAds->count() ?: 1 }} }, 4000)">
                <div class="relative h-[720px] rounded-[3rem] overflow-hidden shadow-lg border border-gray-100">
                    @foreach($verticalAds as $index => $ad)
                        <div x-show="active === {{ $index }}" 
                            x-transition:enter="transition duration-1000"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0">
                            <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Side: Products + Offers (Fills the height) --}}
            <div class="md:col-span-3 space-y-10">
                
                {{-- Section 1: Compact Product Grid (12 Items) --}}
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black uppercase mb-6">Trending Products</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                        @foreach($trendingProducts as $product)
                            <a href="{{ route('public.product.detail', $product->slug) }}" class="group flex flex-col items-center">
                                <div class="w-full h-28 bg-gray-50 rounded-2xl overflow-hidden mb-2">
                                    <img src="{{ route('ad.display', ['path' => $product->images[0] ?? '']) }}" class="h-full w-full object-contain p-2">
                                </div>
                                <h4 class="text-[10px] font-bold line-clamp-1 text-center">{{ $product->name }}</h4>
                                <span class="text-xs font-black text-leaf-green">₹{{ number_format($product->price) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Section 2: Horizontal Offers Scroller (Fills the Gap) --}}
                <div class="bg-[#FFF5F5] p-6 rounded-[2.5rem] border border-red-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-red-600 uppercase">🔥 Limited Time Offers</h3>
                        <div class="flex items-center gap-4" x-data="{ 
                            expiry: new Date().setHours(24,0,0,0),
                            remaining: null,
                            init() {
                                setInterval(() => {
                                    let diff = this.expiry - new Date().getTime();
                                    let h = Math.floor(diff / (1000 * 60 * 60));
                                    let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                    let s = Math.floor((diff % (1000 * 60)) / 1000);
                                    this.remaining = `${h}h : ${m}m : ${s}s`;
                                }, 1000);
                            }
                        }">
                            <span class="text-[10px] font-black bg-red-600 text-white px-3 py-1 rounded-full animate-pulse">ENDS IN</span>
                            <span class="font-mono font-black text-red-600" x-text="remaining">00h : 00m : 00s</span>
                        </div>
                        <a href="#" class="text-xs font-bold text-red-600 underline">View All</a>
                    </div>
                    
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        @foreach($offers as $offer)
                            <div class="min-w-[200px] bg-white p-4 rounded-3xl shadow-sm flex flex-col gap-3">
                                <div class="h-24 bg-gray-100 rounded-2xl overflow-hidden">
                                    <img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-[11px] font-black leading-tight">{{ $offer->title }}</p>
                                    <span class="text-[10px] text-red-500 font-bold">{{ $offer->discount_tag }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>

        <section class="max-w-[1440px] mx-auto px-4 py-4 grid grid-cols-4 md:grid-cols-8 gap-3">
    @foreach($squareAds as $ad)
        <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-white hover:shadow-md transition">
            <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
        </div>
    @endforeach
</section>
        
        {{-- EXCLUSIVE OFFERS: Horizontal Scroll --}}
        <div class="max-w-[1440px] mx-auto px-4 py-6" x-data="{ scroll: () => $refs.cont.scrollBy({left: 300, behavior: 'smooth'}) }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-black text-gray-800">🔥 Exclusive Offers</h2>
        <a href="#" class="text-xs font-bold text-red-600">VIEW ALL</a>
        <div class="flex gap-2">
            <button @click="back()" class="h-10 w-10 rounded-full border border-red-200 text-red-600 hover:bg-red-50 flex items-center justify-center transition">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button @click="scroll()" class="h-10 w-10 rounded-full border border-red-200 text-red-600 hover:bg-red-50 flex items-center justify-center transition">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    {{-- Snap container configured for 3 items on desktop --}}
    <div x-ref="cont" class="flex gap-3 overflow-x-auto scrollbar-hide snap-x">
        @foreach($offers as $offer)
            <div class="min-w-[45%] md:min-w-[16%] snap-start bg-white p-3 rounded-2xl border border-red-50 shadow-sm text-center">
                <div class="h-28 bg-gray-50 rounded-xl overflow-hidden mb-2">
                    <img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="w-full h-full object-contain">
                </div>
                <h3 class="font-bold text-[10px] line-clamp-1 uppercase">{{ $offer->title }}</h3>
                <span class="text-xs font-black text-red-600">{{ $offer->discount_tag }}</span>
            </div>
        @endforeach
    </div>
</div>

        <section class="max-w-[1440px] mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-black uppercase">Verified Properties</h2>
        <a href="#" class="text-xs font-bold text-leaf-green">VIEW ALL</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-8 gap-3">
        @foreach($userProperties as $property)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition p-2">
                <div class="h-20 rounded-lg overflow-hidden bg-gray-50 mb-2">
                    <img src="{{ route('ad.display', ['path' => $property->images[0]]) }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-[9px] truncate text-gray-800">{{ $property->title }}</h3>
                <p class="text-[10px] font-black text-leaf-green">₹{{ number_format($property->price) }}</p>
            </div>
        @endforeach
    </div>
</section>

        {{-- ADS & PROMOTIONS: Refined Grid --}}
        <div class="mb-20 relative py-12 px-6 rounded-[40px] overflow-hidden shadow-inner bg-gradient-to-b from-white to-[#f0f9f0]">
            
            {{-- Leaf Pattern Background --}}
            <div class="absolute inset-0 opacity-20 pointer-events-none" 
                style="background-image: url('{{ asset('images/hero_trans_leaves.png') }}'); background-repeat: repeat; background-size: 200px;">
            </div>

            <div class="max-w-[1440px] mx-auto relative z-10">
                <div class="flex justify-between items-end mb-10">
                    
                    {{-- Update this link to your dedicated ads page route --}}
                    <a href="{{ route('public.ads.index') }}" class="text-sm font-bold text-[#4CAF50] hover:text-[#2D5A27] transition flex items-center gap-1">
                        See All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                {{-- Horizontal Ad Grid: 2 Columns on Desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4 py-4">
    @foreach($horizontalAds as $ad)
        <div class="relative h-[200px] rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-white">
            <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
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

        {{-- FULL PAGE SIZE ADS SECTION --}}
        <section class="max-w-[1440px] mx-auto px-6 py-12">
            @foreach($fullPageAds as $ad)
                <div class="w-full h-[400px] md:h-[500px] rounded-[4rem] overflow-hidden shadow-2xl border border-gray-100 mb-12 relative group">
                    <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" 
                        class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-105">
                    
                    {{-- Dark gradient overlay for text readability --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent flex items-center px-12 md:px-24">
                        <div class="max-w-xl text-white">
                            <h2 class="text-4xl md:text-6xl font-black leading-tight mb-6 uppercase">Mega Construction Sale</h2>
                            <p class="text-lg text-white/80 mb-8 font-medium">Get up to 40% off on all heavy machinery and industrial tools this week.</p>
                            <a href="#" class="inline-block bg-white text-gray-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-leaf-green hover:text-white transition shadow-xl">Shop Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        {{-- REAL ESTATE SECTION --}}
        <div class="mb-20">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-black text-gray-900">Real Estate</h2>
                <a href="#" class="text-sm font-bold text-blue-600 hover:underline">EXPLORE PROPERTIES</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-8 gap-3 px-4 py-4">
    @foreach($userProperties as $property)
        <div class="bg-white rounded-xl p-2 border border-gray-100 shadow-sm flex flex-col items-center">
            <div class="h-20 w-full bg-gray-50 rounded-lg overflow-hidden mb-2">
                <img src="{{ route('ad.display', ['path' => $property->images[0] ?? '']) }}" class="h-full w-full object-cover">
            </div>
            <h4 class="text-[9px] font-bold line-clamp-1 text-gray-800">{{ $property->title }}</h4>
            <p class="text-[10px] font-black text-leaf-green">₹{{ number_format($property->price) }}</p>
        </div>
    @endforeach
</div>
        </div>

        <section class="max-w-[1440px] mx-auto px-6 py-12">
            @isset($upcomingProjects)
                <section class="max-w-[1440px] mx-auto px-6 py-12">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                            <i class="fas fa-city text-blue-600"></i> Upcoming Projects
                        </h2>
                        <a href="#" class="text-sm font-bold text-blue-600 hover:underline">VIEW ALL PROJECTS</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-4 py-4">
    @foreach($upcomingProjects as $project)
        <div class="bg-white rounded-[2rem] p-3 border border-gray-100 shadow-sm flex gap-3 items-center">
            <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0">
                <img src="{{ route('ad.display', ['path' => $project->thumbnail]) }}" class="w-full h-full object-cover">
            </div>
            <div class="overflow-hidden">
                <h3 class="text-xs font-black text-gray-900 truncate">{{ $project->name }}</h3>
                <p class="text-[9px] text-gray-500 truncate">{{ $project->location }}</p>
                <p class="text-[10px] font-bold text-leaf-green mt-1">₹{{ number_format($project->starting_price) }}</p>
            </div>
        </div>
    @endforeach
</div>
                </section>
            @endisset

    </div>
</div>