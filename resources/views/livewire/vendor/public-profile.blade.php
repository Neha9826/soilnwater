<x-layouts.app>

    <style>
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }

        /* Animations */
        @keyframes slow-zoom { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .animate-slow-zoom { animation: slow-zoom 20s infinite alternate ease-in-out; }
        
        .hover-shake:hover { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        @keyframes shake { 10%, 90% { transform: translate3d(-1px, 0, 0) rotate(-1deg); } 20%, 80% { transform: translate3d(2px, 0, 0) rotate(2deg); } 30%, 50%, 70% { transform: translate3d(-4px, 0, 0) rotate(-4deg); } 40%, 60% { transform: translate3d(4px, 0, 0) rotate(4deg); } }

        /* Typography Fixes */
        .prose ul { list-style-type: disc !important; padding-left: 1.5em !important; margin-bottom: 1em; }
        .prose ol { list-style-type: decimal !important; padding-left: 1.5em !important; margin-bottom: 1em; }
        .prose p { margin-bottom: 0.8em; }
    </style>

    <div class="bg-white font-sans text-gray-800 antialiased">

        <div class="relative w-full mb-24">
            
            <div class="relative h-[50vh] md:h-[60vh] w-full bg-gray-900 overflow-hidden" 
                 x-data="{ 
                    activeSlide: 0, 
                    slides: {{ json_encode(!empty($vendor->header_images) ? array_map(fn($i) => asset('storage/'.$i), $vendor->header_images) : [asset('images/default-hero.jpg')]) }},
                    start() { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length }, 5000); }
                 }"
                 x-init="start()">
                
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                         :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }"
                         :style="`background-image: url('${slide}');`">
                         <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    </div>
                </template>

                <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 z-10 flex flex-col md:flex-row items-end justify-between gap-6">
                    <div class="md:pl-52 w-full md:w-2/3 text-white mb-4 md:mb-0">
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight drop-shadow-md">
                            {{ $vendor->header_title ?? $vendor->store_name }}
                        </h1>
                        <p class="text-lg text-gray-300 mt-2 max-w-xl font-light">
                            {{ $vendor->header_subtitle ?? 'Quality Products & Professional Services' }}
                        </p>
                        
                        <div class="flex items-center gap-3 mt-4">
                            <div class="text-xl font-bold tracking-wide text-white border-l-4 border-blue-500 pl-3">
                                {{ $vendor->store_name }}
                            </div>
                            @if($vendor->profile_type == 'vendor')
                                <i class="fas fa-check-circle text-blue-400 text-xl drop-shadow-md" title="Verified Vendor"></i>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3 mb-6 md:mb-2">
                        <button class="bg-white text-gray-900 px-6 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 transition flex items-center gap-2">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                        @if($vendor->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $vendor->phone) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-bold shadow-lg transition flex items-center gap-2">
                                <i class="fab fa-whatsapp text-xl"></i> Chat
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="absolute bottom-[-4rem] left-6 md:left-12 z-20">
                <div class="h-32 w-32 md:h-40 md:w-40 bg-white rounded-2xl shadow-2xl p-2 border-4 border-white hover-shake transition-transform duration-300">
                    @if($vendor->store_logo)
                        <img src="{{ asset('storage/'.$vendor->store_logo) }}" class="w-full h-full object-cover rounded-xl bg-gray-50">
                    @else
                         <div class="w-full h-full bg-gray-800 rounded-xl flex items-center justify-center text-4xl font-bold text-white uppercase">
                            {{ substr($vendor->store_name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </div> 

        <div class="sticky top-[114px] z-30 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm pl-6 md:pl-64 pr-6 transition-all duration-300">
            <div class="max-w-7xl mx-auto py-4 flex justify-between items-center overflow-x-auto">
                <div class="flex gap-6 md:gap-10 text-sm font-bold text-gray-600 whitespace-nowrap mx-auto md:mx-0">
                    <a href="#" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">Home</a>
                    <a href="#about" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">About Us</a>
                    <a href="#products" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">Products</a>
                    <a href="#contact" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">Contact</a>
                </div>
            </div>
        </div>

        <div id="about" class="py-20 max-w-7xl mx-auto px-6 space-y-24">
            @if(!empty($vendor->page_sections))
                @foreach($vendor->page_sections as $index => $section)
                    <div class="flex flex-col md:flex-row gap-12 items-center {{ $index % 2 == 1 ? 'md:flex-row-reverse' : '' }}">
                        
                        <div class="flex-1 space-y-6 w-full">
                            <div class="flex items-center gap-4 mb-2">
                                <span class="h-1 w-12 bg-blue-600 rounded-full"></span>
                                <span class="text-sm font-bold text-blue-600 uppercase tracking-widest">Section {{ $index + 1 }}</span>
                            </div>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $section['title'] ?? '' }}</h2>
                            
                            <div class="prose prose-lg text-gray-600 leading-relaxed">
                                {!! $section['description'] ?? '' !!}
                            </div>
                        </div>

                        <div class="flex-1 w-full">
                            <div class="aspect-video bg-gray-100 rounded-3xl overflow-hidden shadow-xl border border-gray-100 relative group cursor-pointer">
                                 @if(isset($section['image_path']) && $section['image_path'])
                                    <img src="{{ asset('storage/'.$section['image_path']) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
                                 @else
                                    <div class="absolute inset-0 bg-gradient-to-tr from-gray-100 to-white flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300 text-6xl"></i>
                                    </div>
                                 @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="products" class="bg-gray-50 py-20 mt-12 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">Our Offerings</h2>
                
                @if($products->isEmpty())
                    <div class="text-center text-gray-500 py-10">
                        <p>No listings added yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-gray-100">
                                <div class="h-56 bg-gray-100 rounded-xl overflow-hidden mb-4 relative">
                                     @php
                                         // Handle both JSON string and Array for images
                                         $pImages = $product->images;
                                         if (is_string($pImages)) {
                                             $pImages = json_decode($pImages, true);
                                         }
                                         $firstImage = $pImages[0] ?? null;
                                     @endphp

                                     @if($firstImage)
                                        <img src="{{ asset('storage/'.$firstImage) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                     @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-box text-3xl"></i></div>
                                     @endif
                                     
                                     <button class="absolute bottom-4 right-4 bg-white text-gray-900 p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1">{{ $product->name ?? $product->title }}</h3>
                                <p class="text-blue-600 font-bold text-xl">₹{{ number_format($product->price) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12 flex justify-center">{{ $products->links() }}</div>
                @endif
            </div>
        </div>

        <div id="contact" class="bg-gray-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold mb-6">Contact Us</h3>
                    @if($vendor->address) 
                        <p class="mb-2 flex items-center gap-3"><i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vendor->address }}</p> 
                    @endif
                    @if($vendor->phone) 
                        <p class="mb-2 flex items-center gap-3"><i class="fas fa-phone text-green-400"></i> +91 {{ $vendor->phone }}</p> 
                    @endif
                </div>
                <div class="flex md:justify-end items-center gap-4">
                    @if($vendor->facebook) 
                        <a href="{{ $vendor->facebook }}" target="_blank" class="text-white hover:text-blue-500 text-3xl transition"><i class="fab fa-facebook"></i></a> 
                    @endif
                    @if($vendor->instagram) 
                        <a href="{{ $vendor->instagram }}" target="_blank" class="text-white hover:text-pink-500 text-3xl transition"><i class="fab fa-instagram"></i></a> 
                    @endif
                </div>
            </div>
        </div>

    </div>

</x-layouts.app>