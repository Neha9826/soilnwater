<div class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-4 py-3 flex items-center gap-6">
        
        <a href="/" class="text-2xl font-bold text-blue-700 flex-shrink-0">
            Soil<span class="text-green-600">N</span>Water
        </a>

        <div class="flex-grow relative">
            <div class="flex">
                <input 
    type="text" 
    name="query" 
    placeholder="Search for 'Cement', 'Drill Machine', '3BHK'..." 
    class="w-full border border-gray-300 rounded-l-md px-4 py-2.5 focus:outline-none focus:border-blue-500 text-sm"
>
                <button class="bg-orange-500 text-white px-8 rounded-r-md font-bold hover:bg-orange-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-6 text-gray-600 text-sm font-medium flex-shrink-0">
            
            <a href="{{ route('post.choose-category') }}" class="hidden md:flex bg-gradient-to-r from-orange-500 to-red-500 text-white px-5 py-2.5 rounded-full font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                <span>POST AD</span>
            </a>

            @auth
                <div class="relative group">
                    <button class="flex flex-col items-center hover:text-blue-600 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold mb-1">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>Account</span>
                    </button>
                    
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                        <div class="px-4 py-3 border-b text-xs text-gray-500">
                            Signed in as<br>
                            <span class="font-bold text-gray-900 truncate block text-sm mt-0.5">{{ Auth::user()->name }}</span>
                        </div>
                        
                        @if(Auth::user()->profile_type != 'customer')
                            
                            {{-- CASE A: Vendor / Builder / Consultant --}}
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                <i class="fas fa-tachometer-alt w-5 text-center mr-2 text-gray-400"></i> My Dashboard
                            </a>

                        @else
                            
                            {{-- CASE B: Regular Customer --}}
                            {{-- 1. My Posts (New Feature) --}}
                            <a href="{{ route('customer.my-posts') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                <i class="fas fa-layer-group w-5 text-center mr-2 text-blue-500"></i> My Posts & Ads
                            </a>

                            {{-- 2. Join Partner --}}
                            <a href="{{ route('join') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                <i class="fas fa-handshake w-5 text-center mr-2 text-green-500"></i> Join as Partner
                            </a>

                        @endif

                        <div class="border-t border-gray-100 my-1"></div>

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-cog w-5 text-center mr-2 text-gray-400"></i> Profile Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt w-5 text-center mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center hover:text-blue-600">
                    <i class="fas fa-user text-lg mb-1"></i>
                    <span>Login</span>
                </a>
            @endauth

            <a href="#" class="flex flex-col items-center hover:text-blue-600">
                <i class="fas fa-shopping-cart text-lg mb-1"></i>
                <span>Cart</span>
            </a>
        </div>
    </div>

    <div class="border-t border-gray-200">
        <div class="max-w-[1400px] mx-auto px-4 py-2 flex gap-8 text-sm text-gray-700 font-medium overflow-x-auto whitespace-nowrap scrollbar-hide">
            <a href="#" class="hover:text-blue-600 transition">Safety</a>
            <a href="#" class="hover:text-blue-600 transition">Power Tools</a>
            <a href="#" class="hover:text-blue-600 transition">Pumps & Motors</a>
            <a href="#" class="hover:text-blue-600 transition">Real Estate</a>
            <a href="#" class="hover:text-blue-600 transition">Office Supplies</a>
            <a href="#" class="hover:text-blue-600 text-orange-600 font-bold ml-auto">View All Categories &rarr;</a>
        </div>
    </div>
</div>