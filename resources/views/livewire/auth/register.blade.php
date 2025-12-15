<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-6">Join SoilNWater</h2>

        <form wire:submit.prevent="register" class="space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">I want to...</label>
                <select wire:model.live="role" class="w-full border-gray-300 rounded-lg p-3 border">
                    <option value="customer">Just Buy / Browse</option>
                    <option value="vendor">Sell Products (Vendor)</option>
                    <option value="dealer">Sell/Rent Properties (Real Estate)</option>
                    <option value="service">Offer Services (Plumber/Architect)</option>
                    <option value="hotel">List Hotel / Homestay</option>
                </select>
            </div>

            <input wire:model="name" type="text" placeholder="Full Name" class="w-full border-gray-300 rounded-lg p-3 border">
            <input wire:model="email" type="email" placeholder="Email Address" class="w-full border-gray-300 rounded-lg p-3 border">
            <input wire:model="password" type="password" placeholder="Password" class="w-full border-gray-300 rounded-lg p-3 border">

            @if($role !== 'customer')
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 space-y-3 animate-fade-in">
                    <h3 class="text-sm font-bold text-blue-800 uppercase">
                        {{ ucfirst($role) }} Details
                    </h3>
                    
                    <input wire:model="store_name" type="text" 
                           placeholder="{{ $role == 'service' ? 'Service Name (e.g. Rahul Plumbing)' : 'Business Name' }}" 
                           class="w-full border-gray-300 rounded-lg p-3 border">

                    @if($role == 'service')
                         <select wire:model="service_category" class="w-full border-gray-300 rounded-lg p-3 border">
                            <option value="">Select Category...</option>
                            <option value="plumber">Plumber</option>
                            <option value="architect">Architect</option>
                            <option value="electrician">Electrician</option>
                        </select>
                    @endif
                </div>
            @endif

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                Register Now
            </button>
        </form>
    </div>
</div>