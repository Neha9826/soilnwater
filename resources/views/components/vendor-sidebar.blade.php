<aside x-data="{ mobileMenuOpen: false }"
       :class="mobileMenuOpen ? 'block' : 'hidden'" 
       class="md:block bg-white shadow-xl border-r border-gray-200 md:w-64 flex-shrink-0 z-50 flex flex-col h-screen fixed inset-y-0 left-0">
    
    <div class="p-6 border-b border-gray-100 flex-shrink-0">
        <h2 class="text-xl font-extrabold text-blue-900 flex items-center gap-2">
            <i class="fas fa-user-circle"></i> Dashboard
        </h2>
        <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-bold">
            {{ ucfirst(Auth::user()->profile_type) }} Panel
        </p>
    </div>

    <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
        
        <a href="{{ route('dashboard') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-chart-pie w-5"></i> Overview
        </a>

        <a href="{{ route('website.builder') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('website.builder') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-globe w-5"></i> Public Page
        </a>

        <a href="{{ route('vendor.branches') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('vendor.branches') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-building w-5"></i> My Branches
        </a>

        <a href="{{ route('vendor.products') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('vendor.products') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            @if(Auth::user()->profile_type === 'vendor') 
                <i class="fas fa-box-open w-5"></i> Manage Products
            @else 
                <i class="fas fa-bed w-5"></i> Manage Listings 
            @endif
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-100 pt-4">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-bold text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt w-5"></i> Logout
            </button>
        </form>
    </nav>
</aside>