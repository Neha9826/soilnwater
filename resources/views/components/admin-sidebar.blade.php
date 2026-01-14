<aside x-data="{ mobileMenuOpen: false }" 
       :class="mobileMenuOpen ? 'block' : 'hidden'" 
       class="md:block bg-slate-900 text-white shadow-xl border-r border-gray-800 md:w-64 flex-shrink-0 z-50 transition-all duration-300 flex flex-col h-full fixed inset-y-0 left-0">
    
    <div class="p-6 border-b border-gray-800 flex-shrink-0">
        <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
            <i class="fas fa-shield-alt text-blue-500"></i> Admin Panel
        </h2>
        <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide font-bold">Super Admin</p>
    </div>

    <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
        <a href="{{ route('admin.approvals') }}" 
           class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium {{ request()->routeIs('admin.approvals') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800' }}">
            <i class="fas fa-check-double w-5"></i> Approvals
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-800 pt-4">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-bold text-red-400 hover:bg-red-900/20">
                <i class="fas fa-sign-out-alt w-5"></i> Logout
            </button>
        </form>
    </nav>
</aside>