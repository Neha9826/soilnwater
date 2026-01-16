<aside x-data="{ mobileMenuOpen: false }" 
       :class="mobileMenuOpen ? 'block' : 'hidden'" 
       class="md:block bg-white shadow-xl border-r border-gray-200 md:w-64 flex-shrink-0 z-30 transition-all duration-300 flex flex-col h-full">
    
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

        <a href="{{ route('user.profile.public') }}" 
            class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
            {{ request()->routeIs('user.profile.public') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-globe w-5"></i> Public Page
        </a>

        <a href="{{ route('vendor.branches') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('vendor.branches') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-building w-5"></i> My Branches
        </a>

        @php $role = auth()->user()->profile_type; @endphp

        {{-- 1. VENDOR (Hardware Store) --}}
        @if($role === 'vendor')
            <a href="{{ route('vendor.products') }}" 
               class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
               {{ request()->routeIs('vendor.products*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-box-open w-5"></i> Manage Products
            </a>
        
        {{-- 2. BUILDER (Real Estate) --}}
        @elseif($role === 'builder' || $role === 'agent')
            <a href="{{ route('vendor.properties') }}" 
               class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
               {{ request()->routeIs('vendor.properties*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-building w-5"></i> Manage Properties
            </a>

        {{-- 3. SERVICE PROVIDER (Electrician) --}}
        @elseif($role === 'service')
            <a href="{{ route('vendor.services') }}" 
               class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
               {{ request()->routeIs('vendor.services*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-tools w-5"></i> My Services
            </a>

        {{-- 4. CONSULTANT (Architect) --}}
        @elseif($role === 'consultant')
            <a href="{{ route('vendor.consultations') }}" 
               class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
               {{ request()->routeIs('vendor.consultations*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-check w-5"></i> Consultations
            </a>

        {{-- 5. HOTEL (Hotel Owner) --}}
        @elseif($role === 'hotel')
            <a href="{{ route('vendor.hotel') }}" 
               class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
               {{ request()->routeIs('vendor.hotel*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-bed w-5"></i> Hotel Management
            </a>
        @endif
        <a href="{{ route('profile.edit') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium 
           {{ request()->routeIs('profile.show') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-cog w-5"></i> Settings
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-100 pt-4">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-bold text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt w-5"></i> Logout
            </button>
        </form>
    </nav>
</aside>