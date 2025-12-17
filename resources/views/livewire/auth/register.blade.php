<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
        
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Join SoilNWater</h2>
            <p class="text-sm text-gray-500 mt-1">Create your account to get started</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">I want to...</label>
                <select wire:model.live="role" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="customer">Just Buy / Browse</option>
                    <option value="vendor">Sell Products (Vendor)</option>
                    <option value="dealer">Sell/Rent Properties (Real Estate)</option>
                    <option value="hotel">List Hotel / Homestay</option>
                    <option value="consultant">Offer Services (Plumber/Architect)</option>
                </select>
                @error('role') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <input wire:model="name" type="text" placeholder="Full Name" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <input wire:model="email" type="email" placeholder="Email Address" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500">
                @error('email') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <input wire:model="password" type="password" placeholder="Password" class="w-full border-gray-300 rounded-lg p-3 border focus:ring-blue-500 focus:border-blue-500">
                @error('password') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            @if($role !== 'customer')
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 space-y-3 animate-fade-in">
                    <h3 class="text-xs font-bold text-blue-800 uppercase tracking-wide">
                        {{ ucfirst($role) }} Details
                    </h3>
                    
                    <div>
                        <input wire:model="store_name" type="text" 
                               placeholder="@if($role == 'consultant') Service Name (e.g. Rahul Plumbing) @elseif($role == 'hotel') Hotel Name @else Business / Shop Name @endif" 
                               class="w-full border-gray-300 rounded-lg p-3 border text-sm">
                        @error('store_name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input wire:model="contact_phone" type="number" 
                               placeholder="Business Phone Number" 
                               class="w-full border-gray-300 rounded-lg p-3 border text-sm">
                        @error('contact_phone') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    @if($role == 'consultant')
                        <div>
                             <select wire:model="service_category" class="w-full border-gray-300 rounded-lg p-3 border text-sm bg-white">
                                <option value="">Select Profession...</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Architect">Architect</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Painter">Painter</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Interior Designer">Interior Designer</option>
                            </select>
                            @error('service_category') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            @endif

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-md">
                Register Now
            </button>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>