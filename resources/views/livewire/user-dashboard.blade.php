<div class="min-h-screen bg-gray-100" x-data="{ mobileMenuOpen: false }">

    <div class="flex flex-col md:flex-row min-h-screen">

        <aside :class="mobileMenuOpen ? 'block' : 'hidden'" 
               class="md:block bg-white shadow-xl border-r border-gray-200 md:w-64 flex-shrink-0 z-30 transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-extrabold text-blue-900 flex items-center gap-2">
                    <i class="fas fa-user-circle"></i> Dashboard
                </h2>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-bold">
                    {{ ucfirst($user->profile_type) }} Account
                </p>
            </div>
            <nav class="p-4 space-y-2">
                <button wire:click="setTab('stats'); mobileMenuOpen = false" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium {{ $activeTab === 'stats' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}"><i class="fas fa-chart-pie w-5"></i> Overview</button>
                <button wire:click="setTab('page'); mobileMenuOpen = false" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium {{ $activeTab === 'page' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}"><i class="fas fa-globe w-5"></i> Public Page</button>
                <button wire:click="setTab('business'); mobileMenuOpen = false" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium {{ $activeTab === 'business' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}"><i class="fas fa-building w-5"></i> My Branches</button>
                <button wire:click="setTab('items'); mobileMenuOpen = false" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-medium {{ $activeTab === 'items' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                   @if($user->profile_type === 'vendor') <i class="fas fa-box-open w-5"></i> Manage Products
                   @else <i class="fas fa-bed w-5"></i> Manage Listings @endif
                </button>
                <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-100 pt-4">@csrf <button type="submit" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition font-bold text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5"></i> Logout</button></form>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            <div class="md:hidden mb-6">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">Success</p><p>{{ session('message') }}</p>
                </div>
            @endif

            @if($activeTab === 'stats')
                <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Dashboard Overview</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="text-gray-500 text-xs font-bold uppercase">Total Branches</div>
                        <div class="text-4xl font-extrabold text-blue-600 mt-2">{{ $myBusinesses->count() }}</div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'page')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">My Public Website</h2>
                <p class="text-gray-500 mt-1">
                    Manage your main profile page. This page displays all your business branches and products in one place.
                </p>
            </div>
        </div>

        @if(Auth::user()->store_slug)
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-6">
                
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden border border-gray-200">
                        @if(Auth::user()->store_logo)
                            <img src="{{ asset('storage/'.Auth::user()->store_logo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-store text-gray-300 text-2xl"></i>
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ Auth::user()->store_name }}</h3>
                        <a href="{{ url('/v/'.Auth::user()->store_slug) }}" target="_blank" class="text-blue-600 text-sm hover:underline flex items-center gap-1">
                            {{ url('/v/'.Auth::user()->store_slug) }} <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('website.builder') }}" class="flex-1 md:flex-none text-center bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-paint-brush text-purple-500 mr-2"></i> Edit Design
                    </a>

                    <a href="{{ route('public.profile', ['slug' => Auth::user()->store_slug]) }}" target="_blank" class="flex-1 md:flex-none text-center bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                        View Live Page
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-600 text-2xl">
                    <i class="fas fa-magic"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Create Your Website</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Build a stunning landing page to showcase your business and products to the world.</p>
                
                <a href="{{ route('website.builder') }}" class="bg-black text-white px-8 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">
                    Start Building Now
                </a>
            </div>
        @endif

    </div>
@endif

            @if($activeTab === 'business')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    
                    @if(!$showBusinessForm)
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">My Branches</h2>
                            <a href="{{ route('join') }}" class="bg-black text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-gray-800 shadow-md">
                                + Add New Branch
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach($myBusinesses as $biz)
                                <div class="flex flex-col md:flex-row md:items-center justify-between p-5 border border-gray-100 rounded-xl hover:shadow-md transition bg-white">
                                    <div class="mb-4 md:mb-0">
                                        <h4 class="font-bold text-lg text-gray-900">{{ $biz->name }}</h4>
                                        <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $biz->city }}</p>
                                        <p class="text-sm text-gray-500"><i class="fas fa-phone text-green-500 mr-1"></i> {{ $biz->phone }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button wire:click="editBusiness({{ $biz->id }})" class="bg-gray-100 text-blue-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-50 transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button wire:click="deleteBusiness({{ $biz->id }})" wire:confirm="Are you sure you want to delete this branch?" class="bg-gray-100 text-red-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-50 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="max-w-xl">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Edit Branch</h2>
                                <button wire:click="resetBusinessForm" class="text-gray-500 font-bold hover:text-gray-700">Cancel</button>
                            </div>
                            <form wire:submit.prevent="updateBusiness" class="space-y-4">
                                <div>
                                    <label class="block font-bold text-sm text-gray-700">Branch Name</label>
                                    <input wire:model="bus_name" type="text" class="w-full border rounded-lg p-2">
                                </div>
                                <div>
                                    <label class="block font-bold text-sm text-gray-700">City</label>
                                    <input wire:model="bus_city" type="text" class="w-full border rounded-lg p-2">
                                </div>
                                <div>
                                    <label class="block font-bold text-sm text-gray-700">Phone</label>
                                    <input wire:model="bus_phone" type="text" class="w-full border rounded-lg p-2">
                                </div>
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">Update Branch</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            @if($activeTab === 'items')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    
                    @if(!$showItemForm)
                        
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $user->profile_type == 'vendor' ? 'Products' : 'Listings' }}
                            </h2>
                            <button wire:click="openItemCreate" class="bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-800 shadow-md transition transform hover:scale-105">
                                + Create New
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @foreach($myItems as $item)
                                <div class="border border-gray-200 rounded-xl p-4 bg-white flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-lg transition">
                                    <div class="flex gap-4 items-center">
                                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $item->name ?? $item->title }}</h4>
                                            <div class="flex gap-3 text-sm text-gray-500">
                                                <span class="text-blue-600 font-bold">₹{{ number_format($item->price) }}</span>
                                                <span>•</span>
                                                <span><i class="fas fa-store text-gray-400"></i> {{ $item->business->name ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 md:mt-0 flex gap-2 w-full md:w-auto">
                                        <button wire:click="editItem({{ $item->id }})" class="flex-1 md:flex-none bg-blue-50 text-blue-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-100 transition">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        <button wire:click="deleteItem({{ $item->id }})" wire:confirm="Delete this item?" class="flex-1 md:flex-none bg-red-50 text-red-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-100 transition">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @if($myItems->isEmpty())
                                <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <p class="text-gray-400 font-bold">No items found.</p>
                                    <button wire:click="openItemCreate" class="text-blue-600 font-bold mt-2 hover:underline">Create your first item</button>
                                </div>
                            @endif
                        </div>

                    @else

                        <div class="max-w-2xl mx-auto">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ $isEditingItem ? 'Edit Item' : 'Create New Item' }}
                                </h2>
                                <button wire:click="resetItemForm" class="text-gray-500 hover:text-gray-800 font-bold flex items-center gap-2">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>

                            <form wire:submit.prevent="saveItem" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Select Branch</label>
                                    <select wire:model="selectedBusinessId" class="w-full border-2 border-gray-200 rounded-xl p-3 font-bold bg-white">
                                        @foreach($myBusinesses as $biz)
                                            <option value="{{ $biz->id }}">{{ $biz->name }} ({{ $biz->city }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Name / Title</label>
                                        <input wire:model="item_name" type="text" class="w-full border-2 border-gray-200 rounded-xl p-3">
                                        @error('item_name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Price (₹)</label>
                                        <input wire:model="item_price" type="number" class="w-full border-2 border-gray-200 rounded-xl p-3">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                        <textarea wire:model="item_description" rows="4" class="w-full border-2 border-gray-200 rounded-xl p-3"></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg">
                                    {{ $isEditingItem ? 'Update Item' : 'Create Item' }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

        </main>
    </div>
</div>