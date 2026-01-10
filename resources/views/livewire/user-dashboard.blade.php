<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <x-vendor-sidebar />

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8 md:pl-64">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Dashboard Overview</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="text-gray-500 text-xs font-bold uppercase">Total Branches</div>
                <div class="text-4xl font-extrabold text-blue-600 mt-2">{{ $myBusinesses->count() }}</div>
            </div>
             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="text-gray-500 text-xs font-bold uppercase">Total Products</div>
                <div class="text-4xl font-extrabold text-green-600 mt-2">0</div>
            </div>
        </div>

    </main>
</div>