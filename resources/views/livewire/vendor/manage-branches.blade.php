<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8 md:pl-64">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">My Branches</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($myBusinesses as $biz)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <h3 class="font-bold text-xl mb-2">{{ $biz->name }}</h3>
                        <p class="text-gray-500 mb-4"><i class="fas fa-map-marker-alt text-red-500"></i> {{ $biz->city }}</p>
                        <button class="w-full bg-blue-50 text-blue-600 font-bold py-2 rounded-lg hover:bg-blue-100">Manage Branch</button>
                    </div>
                @endforeach
                
                <a href="{{ route('join') }}" class="border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-gray-400 hover:border-blue-400 hover:text-blue-500 transition p-6 cursor-pointer">
                    <i class="fas fa-plus-circle text-4xl mb-2"></i>
                    <span class="font-bold">Add New Branch</span>
                </a>
            </div>
        </div>
    </main>
</div>