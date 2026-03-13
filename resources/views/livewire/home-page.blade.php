<div class="min-h-screen bg-[#FDFDFD]">
    <div class="max-w-[1440px] mx-auto">
        
        {{-- HERO SECTION: Tightened Padding --}}
        <section class="relative bg-gradient-to-b from-[#4CAF50] to-[#ffffff] w-full py-6 overflow-hidden">
            <div class="absolute w-full inset-0 opacity-30 pointer-events-none" 
                style="background-image: url('{{ asset('images/hero_trans_leaves.png') }}'); background-repeat: repeat; background-size: 200px;">
            </div>

            <div class="max-w-[1440px] mx-auto px-6 relative z-10">
                <div class="relative h-[280px] w-full rounded-[35px] overflow-hidden shadow-2xl group border border-green-100/20"
                    x-data="{ active: 0, loop() { setInterval(() => { this.active = (this.active + 1) % {{ $heroBanners->count() ?: 1 }} }, 5000) } }" 
                    x-init="loop()">
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-[#2D5A27] via-[#3d7a35] to-[#4CAF50]"></div>
                    @forelse($heroBanners as $index => $banner)
                        <div x-show="active === {{ $index }}" 
                            x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0 w-full h-full">
                            <img src="{{ route('ad.display', ['path' => $banner->preview_image]) }}" class="w-full h-full object-cover">
                        </div>
                    @empty
                        <div class="absolute inset-0 flex items-center px-16 z-10">
                            <div class="text-white max-w-lg">
                                <h1 class="text-4xl md:text-5xl font-black leading-tight mb-2">Green Energy Solutions</h1>
                                <p class="text-sm text-white/90 mb-6">Explore sustainable products and professional services.</p>
                            </div>
                        </div>
                    @endforelse

                    @if($heroBanners->count() > 1)
                        <div class="absolute bottom-6 left-0 right-0 z-30 flex justify-center gap-2">
                            @foreach($heroBanners as $index => $banner)
                                <button @click="active = {{ $index }}" :class="active === {{ $index }} ? 'bg-white w-8' : 'bg-white/40 w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- VERTICAL AD + TRENDING PRODUCTS SECTION --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4 grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <div class="md:col-span-1" x-data="{ active: 0, timer: null }" x-init="timer = setInterval(() => { active = (active + 1) % {{ $verticalAds->count() ?: 1 }} }, 4000)">
                <div class="relative h-[680px] rounded-[2.5rem] overflow-hidden shadow-lg border border-gray-100">
                    @foreach($verticalAds as $index => $ad)
                        <div x-show="active === {{ $index }}" x-transition:enter="transition duration-1000" class="absolute inset-0">
                            <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="md:col-span-3 space-y-6">
                {{-- TRENDING PRODUCTS --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black uppercase mb-4">Trending Products</h2>
                    <a href="{{ route('public.products.index') }}" class="bg-leaf-green text-white text-[10px] font-black px-6 py-2 rounded-full uppercase shadow-md hover:bg-soil-green transition">
                        View All
                    </a>
                    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                        @foreach($trendingProducts as $product)
                            <div class="bg-white rounded-2xl border border-gray-100 p-3 hover:shadow-lg transition flex flex-col">
                                <div class="aspect-square rounded-xl overflow-hidden bg-gray-50 mb-3">
                                    @php 
                                        // Safely handle both array and JSON string formats for product images
                                        $images = $product->images;
                                        $imagesArray = is_string($images) ? json_decode($images, true) : $images;
                                        $firstProductImage = (is_array($imagesArray) && count($imagesArray) > 0) ? $imagesArray[0] : null;
                                    @endphp

                                    <img src="{{ $firstProductImage ? route('ad.display', ['path' => $firstProductImage]) : asset('images/placeholder.png') }}" 
                                        class="w-full h-full object-contain">
                                </div>

                                <div class="flex-grow">
                                    <h3 class="text-xs font-bold text-gray-900 truncate uppercase">{{ $product->name }}</h3>
                                    <p class="text-[10px] font-black text-leaf-green mt-1">₹{{ number_format($product->price) }}</p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- LIMITED OFFERS WITH TIMER --}}
                <div class="bg-[#FFF5F5] p-6 rounded-[2rem] border border-red-100">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-4" x-data="{ expiry: new Date().setHours(24,0,0,0), remaining: null, init() { setInterval(() => { let diff = this.expiry - new Date().getTime(); let h = Math.floor(diff / (1000 * 60 * 60)); let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)); let s = Math.floor((diff % (1000 * 60)) / 1000); this.remaining = `${h}h : ${m}m : ${s}s`; }, 1000); } }">
                            <h3 class="text-lg font-black text-red-600 uppercase">🔥 Hot Deals</h3>
                            <span class="text-[10px] font-black bg-red-600 text-white px-3 py-1 rounded-full animate-pulse">ENDS IN</span>
                            <span class="font-mono font-black text-red-600" x-text="remaining">00h : 00m : 00s</span>
                        </div>
                        <a href="#" class="text-xs font-bold text-red-600 underline uppercase">View All</a>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide snap-x">
                        @foreach($offers as $offer)
                            <div class="min-w-[160px] snap-start bg-white p-3 rounded-2xl shadow-sm">
                                <img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="h-20 w-full object-cover rounded-xl mb-2">
                                <p class="text-[9px] font-black leading-tight line-clamp-1">{{ $offer->title }}</p>
                                <span class="text-[10px] text-red-500 font-bold">{{ $offer->discount_tag }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- SQUARE ADS: 8 Cards Per Row, 2 Rows --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4 grid grid-cols-4 md:grid-cols-8 gap-3">
            @foreach($squareAds as $ad)
                <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-white hover:shadow-md transition">
                    <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </section>
        
        {{-- EXCLUSIVE OFFERS SLIDER: 6 Per Row --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4" x-data="{ scroll: () => $refs.cont.scrollBy({left: 400, behavior: 'smooth'}), back: () => $refs.cont.scrollBy({left: -400, behavior: 'smooth'}) }">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-black text-gray-800 uppercase">🔥 Exclusive Offers</h2>
                <div class="flex gap-2">
                    <button @click="back()" class="h-8 w-8 rounded-full border border-gray-200 hover:bg-gray-50 flex items-center justify-center transition"><i class="fas fa-chevron-left text-xs"></i></button>
                    <button @click="scroll()" class="h-8 w-8 rounded-full border border-gray-200 hover:bg-gray-50 flex items-center justify-center transition"><i class="fas fa-chevron-right text-xs"></i></button>
                </div>
            </div>
            <div x-ref="cont" class="flex gap-3 overflow-x-auto scrollbar-hide snap-x">
                @foreach($offers as $offer)
                    <div class="min-w-[45%] md:min-w-[16%] snap-start bg-white p-3 rounded-2xl border border-red-50 shadow-sm text-center group">
                        <div class="h-28 bg-gray-50 rounded-xl overflow-hidden mb-2"><img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="w-full h-full object-contain group-hover:scale-105 transition"></div>
                        <h3 class="font-bold text-[10px] line-clamp-1 uppercase">{{ $offer->title }}</h3>
                        <span class="text-xs font-black text-red-600">{{ $offer->discount_tag }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- NEW REAL ESTATE SECTION (Builder Projects) --}}
        {{-- resources/views/livewire/home-page.blade.php --}}
<section class="py-10 px-6 bg-white">
    <div class="max-w-[1440px] mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Premium Real Estate</h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Verified Builder Projects</p>
            </div>
            {{-- Fixed View All Button --}}
            <a href="{{ route('public.realestate.index') }}" 
               class="inline-flex items-center bg-green-600 text-white text-[10px] font-black px-8 py-3 rounded-full uppercase shadow-xl hover:bg-green-700 transition transform hover:-translate-y-1">
                View all <i class="fas fa-arrow-right ml-2 text-[8px]"></i>
            </a>
        </div>

        {{-- 6 CARDS IN A ROW ON DESKTOP --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($builderProperties as $property)
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition group">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-50">
                        @php 
                            $propertyImages = is_array($property->images) ? $property->images : json_decode($property->images, true);
                            $displayImg = (is_array($propertyImages) && count($propertyImages) > 0) ? $propertyImages[0] : null;
                        @endphp
                        <img src="{{ $displayImg ? route('ad.display', ['path' => $displayImg]) : asset('images/placeholder.png') }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-2 left-2 bg-blue-600 text-white text-[8px] font-black px-2 py-0.5 rounded-full uppercase">Verified</div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-[11px] font-black text-gray-900 truncate uppercase mb-1">{{ $property->title }}</h3>
                        <p class="text-[9px] text-gray-400 font-bold mb-2 truncate"><i class="fas fa-map-marker-alt"></i> {{ $property->location }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-leaf-green">₹{{ number_format($property->price) }}</span>
                            <a href="{{ route('public.property.detail', $property->id) }}" class="text-[9px] font-black text-gray-400 hover:text-leaf-green">DETAILS</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

        {{-- HORIZONTAL ADS: 3 Cards Per Row --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($horizontalAds as $ad)
                <div class="relative h-[200px] rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-white group">
                    <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                </div>
            @endforeach
        </section>

        {{-- VERIFIED PROPERTIES: 8 Per Row, 2 Rows --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-black uppercase">Verified Properties</h2>
                <a href="#" class="text-xs font-bold text-leaf-green uppercase underline">View All</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-8 gap-3">
                @foreach($userProperties as $property)
                    <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition p-2">
                        <div class="h-20 rounded-lg overflow-hidden bg-gray-50 mb-2"><img src="{{ route('ad.display', ['path' => $property->images[0] ?? '']) }}" class="w-full h-full object-cover"></div>
                        <h3 class="font-bold text-[9px] truncate text-gray-800">{{ $property->title }}</h3>
                        <p class="text-[10px] font-black text-leaf-green">₹{{ number_format($property->price) }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FULL PAGE ADS: High Impact --}}
        <section class="max-w-[1440px] mx-auto px-6 py-4">
            @foreach($fullPageAds as $ad)
                <div class="w-full h-[400px] rounded-[3rem] overflow-hidden shadow-xl border border-gray-100 mb-6 relative group">
                    <img src="{{ route('ad.display', ['path' => $ad->preview_image]) }}" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent flex items-center px-12 md:px-24">
                        <div class="max-w-xl text-white">
                            <h2 class="text-4xl md:text-5xl font-black leading-tight mb-4 uppercase">Construction Mega Sale</h2>
                            <a href="#" class="inline-block bg-white text-gray-900 px-8 py-3 rounded-xl font-black uppercase text-xs hover:bg-leaf-green hover:text-white transition">Shop Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        {{-- EXPERTS SECTION --}}
        <section class="max-w-[1440px] mx-auto px-6 py-10 border-t border-gray-100">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-black text-gray-900 uppercase">Featured on SoilNWater</h2>
                <div class="h-1 w-20 bg-[#4CAF50] mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                @foreach($experts as $expert)
                    <a href="{{ route('public.store', $expert->store_slug) }}" class="group flex flex-col items-center text-center">
                        <div class="h-24 w-24 rounded-full p-1 border-2 border-transparent group-hover:border-[#4CAF50] transition-all bg-white shadow-sm mb-3">
                            <div class="h-full w-full rounded-full overflow-hidden bg-gray-50 border border-gray-100">
                                @if($expert->store_logo)
                                    <img src="{{ route('ad.display', ['path' => $expert->store_logo]) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-[#2D5A27] font-black text-xl">{{ substr($expert->store_name, 0, 1) }}</div>
                                @endif
                            </div>
                        </div>
                        <h4 class="font-bold text-xs text-gray-900 group-hover:text-[#4CAF50] truncate w-full">{{ $expert->store_name }}</h4>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- UPCOMING PROJECTS: 4 Cards Per Row, 2 Rows --}}
        @isset($upcomingProjects)
            <section class="max-w-[1440px] mx-auto px-6 py-6 border-t border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-black uppercase flex items-center gap-3"><i class="fas fa-city text-blue-600"></i> Upcoming Projects</h2>
                    <a href="#" class="text-xs font-bold text-blue-600 uppercase underline">View All</a>
                </div>
                {{-- Change 'thumbnail' to 'image' and 'starting_price' to 'price' --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @foreach($upcomingProjects as $project)
                        <div class="bg-white rounded-[1.5rem] p-3 border border-gray-100 shadow-sm flex gap-3 items-center hover:shadow-md transition">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-50">
                    @php 
                        $images = $project->images;
                        
                        // Convert to array if it's still a JSON string, otherwise use as is
                        $imagesArray = is_string($images) ? json_decode($images, true) : $images;
                        
                        // Get the first image path
                        $firstImagePath = (is_array($imagesArray) && count($imagesArray) > 0) ? $imagesArray[0] : null;
                    @endphp
                    
                    <img src="{{ $firstImagePath ? route('ad.display', ['path' => $firstImagePath]) : asset('images/placeholder.png') }}" 
                        class="w-full h-full object-cover">
                </div>
            <div class="overflow-hidden">
                <h3 class="text-xs font-black text-gray-900 truncate">{{ $project->name }}</h3>
                <p class="text-[9px] text-gray-500 truncate">{{ $project->location }}</p>
                {{-- SQL shows column is 'price', not 'starting_price' --}}
                <p class="text-[10px] font-bold text-leaf-green mt-0.5">₹{{ number_format($project->price) }}</p>
            </div>
        </div>
    @endforeach
</div>
            </section>
        @endisset

    </div>
</div>