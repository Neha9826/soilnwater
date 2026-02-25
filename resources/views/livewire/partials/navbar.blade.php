<div class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-[1440px] mx-auto px-6 py-4 flex items-center gap-8">
        
        {{-- Updated Logo --}}
        <a href="/" class="flex-shrink-0">
            <img src="{{ asset('images/logo_soilnwater.png') }}" alt="SoilNWater" class="h-14 w-auto">
        </a>

        {{-- Search Bar: Updated to Blue-Green Theme --}}
        <div class="flex-grow relative max-w-2xl hidden md:block">
            <div class="flex group">
                <input type="text" name="query" placeholder="Search for 'Cement', 'Drill Machine', '3BHK'..." 
                    class="w-full border-2 border-gray-100 bg-gray-50 rounded-l-2xl px-5 py-3 focus:outline-none focus:border-[#4CAF50] focus:bg-white transition-all text-sm">
                <button class="bg-[#4CAF50] text-white px-8 rounded-r-2xl font-bold hover:bg-[#388E3C] transition-colors shadow-md">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-8 text-gray-600 text-sm font-bold flex-shrink-0">
            
            {{-- POST AD: Matches 'Soil' Green --}}
            <a href="{{ route('post.choose-category') }}" class="hidden lg:flex bg-[#2D5A27] text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition transform items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                <span>POST AD</span>
            </a>

            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 hover:text-[#4CAF50] focus:outline-none py-2">
                        <div class="h-10 w-10 rounded-full bg-green-50 border-2 border-[#4CAF50] flex items-center justify-center text-[#2D5A27] font-black">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden sm:inline">My Account</span>
                        <i class="fas fa-chevron-down text-[10px] opacity-50"></i>
                    </button>
                    
                    {{-- Dropdown: Preserving your existing logic --}}
                    <div class="absolute right-0 mt-1 w-64 bg-white rounded-2xl shadow-2xl py-2 hidden group-hover:block border border-gray-100 z-50 overflow-hidden">
                        <div class="px-5 py-4 bg-gray-50 border-b text-xs text-gray-400 uppercase tracking-widest">
                            Authorized User<br>
                            <span class="font-black text-[#2D5A27] truncate block text-sm mt-1 capitalize">{{ Auth::user()->name }}</span>
                        </div>
                        
                        @if(Auth::user()->profile_type != 'customer')
                            <a href="{{ route('dashboard') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-[#4CAF50] transition">
                                <i class="fas fa-tachometer-alt w-6 text-[#2D5A27]"></i> My Dashboard
                            </a>
                        @else
                            <a href="{{ route('customer.listings') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-[#4CAF50] transition">
                                <i class="fas fa-layer-group w-6 text-blue-500"></i> My Posts & Ads
                            </a>
                            <a href="{{ route('join') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-[#4CAF50] transition">
                                <i class="fas fa-handshake w-6 text-green-500"></i> Join as Partner
                            </a>
                        @endif

                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-cog w-6 text-gray-400"></i> Profile Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-5 py-3 text-sm text-red-500 hover:bg-red-50 font-bold">
                                <i class="fas fa-sign-out-alt w-6"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-[#4CAF50] transition">
                    <i class="fas fa-user-circle text-xl"></i>
                    <span>Login</span>
                </a>
            @endauth

            <a href="#" class="relative hover:text-[#2196F3] transition">
                <i class="fas fa-shopping-bag text-xl"></i>
                <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-[10px] h-4 w-4 rounded-full flex items-center justify-center">0</span>
            </a>
        </div>
    </div>

    {{-- Sub-nav: Soil Color --}}
    <div class="bg-[#2D5A27] shadow-inner">
        <div class="max-w-[1440px] mx-auto px-6 py-3 flex gap-10 text-xs text-white/90 font-black uppercase tracking-widest overflow-x-auto whitespace-nowrap scrollbar-hide">
            <a href="#" class="hover:text-green-300 transition">Power Tools</a>
            <a href="#" class="hover:text-green-300 transition">Pumps & Motors</a>
            <a href="#" class="hover:text-green-300 transition">Real Estate</a>
            <a href="#" class="hover:text-green-300 transition">Office Supplies</a>
            <a href="#" class="hover:text-green-300 transition">Construction</a>
            <a href="#" class="text-green-400 ml-auto border-b border-green-400">View All Categories &rarr;</a>
        </div>
    </div>
</div>