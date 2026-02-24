<div> <style>
        html { scroll-behavior: smooth; }
        .hover-shake:hover { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        @keyframes shake { 10%, 90% { transform: translate3d(-1px, 0, 0) rotate(-1deg); } 20%, 80% { transform: translate3d(2px, 0, 0) rotate(2deg); } 30%, 50%, 70% { transform: translate3d(-4px, 0, 0) rotate(-4deg); } 40%, 60% { transform: translate3d(4px, 0, 0) rotate(4deg); } }
    </style>

    <div class="bg-white font-sans text-gray-800 antialiased">

        <div class="relative w-full mb-24">
            
            <div class="relative h-[50vh] md:h-[60vh] w-full bg-gray-900 overflow-hidden" 
                 x-data="{ 
                    activeSlide: 0, 
                    slides: {{ json_encode(!empty($vendor->header_images) ? array_map(fn($i) => asset('storage/'.$i), $vendor->header_images) : []) }},
                    start() { if(this.slides.length > 1) setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length }, 5000); }
                 }"
                 x-init="start()">
                
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                         :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }"
                         :style="`background-image: url('${slide}');`">
                         <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    </div>
                </template>

                @if(empty($vendor->header_images))
                    <div class="absolute inset-0 w-full h-full bg-gray-800 flex items-center justify-center">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    </div>
                @endif

                <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 z-10 flex flex-col md:flex-row items-end justify-between gap-6">
                    <div class="md:pl-52 w-full md:w-2/3 text-white mb-4 md:mb-0">
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight drop-shadow-md">
                            {{ $vendor->header_title ?? $vendor->name }}
                        </h1>
                        <p class="text-lg text-gray-300 mt-2 max-w-xl font-light">
                            {{ $vendor->header_subtitle ?? 'Quality Products & Professional Services' }}
                        </p>
                        
                        <div class="flex items-center gap-3 mt-4">
                            <div class="text-xl font-bold tracking-wide text-white border-l-4 border-blue-500 pl-3">
                                {{ $vendor->name }}
                            </div>
                            <i class="fas fa-check-circle text-blue-400 text-xl drop-shadow-md" title="Verified"></i>
                        </div>
                    </div>

                    <div class="flex gap-3 mb-6 md:mb-2 relative" x-data="{ showQr: false }">
                        
                        <button class="bg-white text-gray-900 px-6 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 transition flex items-center gap-2"
                                onclick="navigator.clipboard.writeText('{{ route('public.store', $vendor->slug) }}'); alert('Profile Link Copied!');">
                            <i class="fas fa-share-alt"></i> Share
                        </button>

                        <button @click="showQr = !showQr" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-bold shadow-lg transition flex items-center gap-2">
                            <i class="fas fa-qrcode text-xl"></i> Scan QR
                        </button>

                        <div x-show="showQr" 
                             @click.away="showQr = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute bottom-16 right-0 bg-white p-4 rounded-xl shadow-2xl border border-gray-100 w-48 flex flex-col items-center z-50">
                            
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('public.store', $vendor->slug)) }}" 
                                 alt="Profile QR" 
                                 class="w-full h-auto rounded-lg mb-2 border border-gray-100">
                            
                            <p class="text-xs text-gray-500 text-center font-bold">Scan to visit profile</p>
                            <div class="w-3 h-3 bg-white absolute -bottom-1.5 right-8 rotate-45 border-b border-r border-gray-100"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="absolute bottom-[-4rem] left-6 md:left-12 z-20">
                <div class="h-32 w-32 md:h-40 md:w-40 bg-white rounded-2xl shadow-2xl p-2 border-4 border-white hover-shake transition-transform duration-300">
                    @if($vendor->logo)
                        <img src="{{ $vendor->logo ? route('ad.display', ['path' => $vendor->logo]) : '' }}" class="w-full h-full object-cover rounded-xl bg-gray-50">
                    @else
                         <div class="w-full h-full bg-gray-800 rounded-xl flex items-center justify-center text-4xl font-bold text-white uppercase">
                            {{ substr($vendor->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </div> 

        <div class="sticky top-[70px] z-30 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm pl-6 md:pl-64 pr-6 transition-all duration-300">
            <div class="max-w-7xl mx-auto py-4 flex justify-between items-center overflow-x-auto">
                <div class="flex gap-6 md:gap-10 text-sm font-bold text-gray-600 whitespace-nowrap mx-auto md:mx-0">
                    <a href="#" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">Home</a>
                    <a href="#about" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">About Us</a>
                    <a href="#listings" class="hover:text-blue-600 transition border-b-2 border-transparent hover:border-blue-600 pb-1">Listings</a>
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
                                    <img src="{{ (isset($section['image_path']) && $section['image_path']) ? route('ad.display', ['path' => $section['image_path']]) : '' }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
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

        <div id="listings" class="bg-gray-50 py-20 mt-12 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">Our Offerings</h2>
                
                @if($products->isEmpty())
                    <div class="text-center text-gray-500 py-10">
                        <p>No listings added yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($products as $item)
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="h-56 bg-gray-100 rounded-xl overflow-hidden mb-4 relative">
             @php
                 // Decode the JSON array from the database
                 $pImages = is_string($item->images) ? json_decode($item->images, true) : $item->images;
                 $firstImagePath = (is_array($pImages) && !empty($pImages)) ? $pImages[0] : null;
             @endphp

             @if($firstImagePath)
                 {{-- Pass the full path to the bridge --}}
                 <img src="{{ route('ad.display', ['path' => $firstImagePath]) }}" 
                      class="w-full h-full object-cover">
             @else
                 <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-box text-3xl"></i>
                 </div>
             @endif
        </div>
        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $item->name ?? $item->title }}</h3>
        <p class="text-blue-600 font-bold text-xl">₹{{ number_format($item->price) }}</p>
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
                    @if($vendor->address) <p class="mb-2 flex items-center gap-3"><i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vendor->address }}</p> @endif
                    @if($vendor->phone) <p class="mb-2 flex items-center gap-3"><i class="fas fa-phone text-green-400"></i> +91 {{ $vendor->phone }}</p> @endif
                    @if($vendor->email) <p class="mb-2 flex items-center gap-3"><i class="fas fa-envelope text-yellow-400"></i> {{ $vendor->email }}</p> @endif
                </div>
            </div>
        </div>

    </div>

</div> 