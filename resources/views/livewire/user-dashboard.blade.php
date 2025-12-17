<div class="max-w-7xl mx-auto py-12 px-4">
    
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Welcome, {{ Auth::user()->name }}
            </h1>
            <p class="text-gray-500">
                You are logged in as: 
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded uppercase">
                    {{ Auth::user()->profile_type }}
                </span>
            </p>
        </div>
        
        @if(Auth::user()->profile_type !== 'customer')
            <a href="{{ url('/v/'.Auth::user()->store_slug) }}" target="_blank" class="bg-white border border-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-50 shadow-sm">
                <i class="fas fa-external-link-alt mr-2"></i> View My Public Page
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('profile.edit') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fas fa-user-cog text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Account Settings</h3>
                    <p class="text-xs text-gray-500">Edit Login & Profile Info</p>
                </div>
            </div>
        </a>

        @if(Auth::user()->profile_type === 'vendor')
            
            <a href="{{ route('vendor.business') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Manage Shop Page</h3>
                        <p class="text-xs text-gray-500">Header Image, About Us</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('vendor.products') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Manage Products</h3>
                        <p class="text-xs text-gray-500">Add or Edit Items</p>
                    </div>
                </div>
            </a>

        @endif

        @if(Auth::user()->profile_type === 'consultant')

            <a href="{{ route('vendor.business') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Manage Portfolio</h3>
                        <p class="text-xs text-gray-500">Profile, Bio, Headers</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-tools text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">My Services</h3>
                        <p class="text-xs text-gray-500">Add New Services</p>
                    </div>
                </div>
            </a>

        @endif

    </div>
</div>