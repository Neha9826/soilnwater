<div class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-[1400px] mx-auto px-4 py-3 flex items-center gap-6">
            
            <a href="/" class="text-2xl font-bold text-blue-700 flex-shrink-0">
                Soil<span class="text-green-600">N</span>Water
            </a>

            <div class="flex-grow relative">
                <div class="flex">
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search for 'Cement', 'Drill Machine', '3BHK'..." 
                        class="w-full border border-gray-300 rounded-l-md px-4 py-2.5 focus:outline-none focus:border-blue-500 text-sm"
                    >
                    <button class="bg-orange-500 text-white px-8 rounded-r-md font-bold hover:bg-orange-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-6 text-gray-600 text-sm font-medium flex-shrink-0">
                @auth
                    <div class="relative group">
                        <button class="flex flex-col items-center hover:text-blue-600 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold mb-1">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>Account</span>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                            <div class="px-4 py-2 border-b text-xs text-gray-500">
                                Signed in as<br>
                                <span class="font-bold text-gray-900 truncate block">{{ Auth::user()->name }}</span>
                            </div>
                            
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Dashboard</a>
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-cog mr-2"></i> Profile Settings
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center hover:text-blue-600">
                        <i class="fas fa-user text-lg"></i>
                        <span>Login</span>
                    </a>
                @endauth

                <a href="#" class="flex flex-col items-center hover:text-blue-600">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </div>
        </div>

        <div class="border-t border-gray-200">
            <div class="max-w-[1400px] mx-auto px-4 py-2 flex gap-8 text-sm text-gray-700 font-medium overflow-x-auto whitespace-nowrap">
                <a href="#" class="hover:text-blue-600">Safety</a>
                <a href="#" class="hover:text-blue-600">Power Tools</a>
                <a href="#" class="hover:text-blue-600">Pumps & Motors</a>
                <a href="#" class="hover:text-blue-600">Real Estate</a>
                <a href="#" class="hover:text-blue-600">Office Supplies</a>
                <a href="#" class="hover:text-blue-600 text-orange-600">View All Categories</a>
            </div>
        </div>
    </div>