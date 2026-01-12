<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between"><span>Menu</span><i class="fas fa-bars"></i></button>
        </div>

        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-sm">
                <p class="font-bold">Success</p>
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">My Branches</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach($myBusinesses as $biz)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-4">
                            <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold">
                                {{ substr($biz->name, 0, 1) }}
                            </div>
                            <button wire:click="deleteBranch({{ $biz->id }})" 
                                    wire:confirm="Are you sure you want to delete this branch? All associated products will be hidden."
                                    class="text-gray-400 hover:text-red-500 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <h3 class="font-bold text-xl text-gray-900 mb-1 truncate">{{ $biz->name }}</h3>
                        
                        <div class="space-y-1 text-sm text-gray-500 mb-6">
                            <p><i class="fas fa-map-marker-alt text-red-500 w-5"></i> {{ $biz->city }}</p>
                            <p><i class="fas fa-phone text-green-500 w-5"></i> {{ $biz->phone }}</p>
                        </div>

                        <a href="{{ route('vendor.branches.edit', $biz->id) }}" class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-2.5 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition flex items-center justify-center gap-2">
                            <i class="fas fa-cog"></i> Manage Details
                        </a>
                    </div>
                @endforeach
                
                <a href="{{ route('vendor.branches.create') }}" class="border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-gray-400 hover:border-blue-400 hover:text-blue-500 transition p-6 cursor-pointer min-h-[250px] group">
                    <div class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-50 transition">
                        <i class="fas fa-plus text-2xl"></i>
                    </div>
                    <span class="font-bold text-lg">Add New Branch</span>
                </a>
            </div>
        </div>

        @if($isEditing)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all scale-100">
                    
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Edit Branch Details</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Branch Name</label>
                            <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-2 focus:ring-blue-500">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">City / Location</label>
                            <input wire:model="city" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-2 focus:ring-blue-500">
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Contact Phone</label>
                            <input wire:model="phone" type="text" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-2 focus:ring-blue-500">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                        <button wire:click="closeModal" class="px-4 py-2 text-gray-600 font-bold hover:bg-gray-200 rounded-lg transition">Cancel</button>
                        <button wire:click="updateBranch" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md transition">Save Changes</button>
                    </div>

                </div>
            </div>
        @endif

    </main>
</div>