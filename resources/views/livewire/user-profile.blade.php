<div class="max-w-4xl mx-auto px-4 py-10">
    
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Account Settings</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
            &larr; Back to Dashboard
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateProfile" class="space-y-6">
        
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Personal Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input wire:model="email" type="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password (Optional)</label>
                    <input wire:model="new_password" type="password" placeholder="Leave blank to keep current password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                </div>

            </div>
        </div>

        @if($is_business_account)
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Business Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store / Business Name</label>
                    <input wire:model="store_name" type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Slug (URL)</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            soilnwater.in/v/
                        </span>
                        <input wire:model="store_slug" type="text" class="flex-1 border-gray-300 rounded-r-lg focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    </div>
                </div>

                @if(Auth::user()->profile_type == 'consultant')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profession / Category</label>
                        <input wire:model="service_category" type="text" placeholder="e.g. Architect, Plumber" class="w-full border-gray-300 rounded-lg shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Consultation Fee (₹)</label>
                        <input wire:model="service_charge" type="number" class="w-full border-gray-300 rounded-lg shadow-sm p-2 border">
                    </div>
                @endif

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Logo / Profile Photo</label>
                    
                    <div class="flex items-center gap-4">
                        @if ($store_logo) 
                            <img src="{{ $store_logo->temporaryUrl() }}" class="h-16 w-16 rounded-full object-cover border">
                        @elseif($existing_logo)
                            <img src="{{ asset('storage/'.$existing_logo) }}" class="h-16 w-16 rounded-full object-cover border">
                        @else
                            <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">📷</div>
                        @endif
                        
                        <input wire:model="store_logo" type="file" class="text-sm text-gray-500">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 1MB.</p>
                </div>
            </div>
        </div>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                Save Changes
            </button>
        </div>
    </form>
</div>