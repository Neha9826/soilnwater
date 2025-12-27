<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-10 rounded-2xl shadow-xl border border-gray-200">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="text-sm text-gray-500 mt-2">Join SoilNWater to start your journey</p>
        </div>

        <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full bg-white text-gray-700 font-bold py-3 px-4 rounded-xl border-2 border-gray-200 hover:border-gray-400 hover:bg-gray-50 transition duration-300">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
            Continue with Google
        </a>

        <div class="relative flex py-6 items-center">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-gray-400 text-xs uppercase font-bold tracking-wider">Or register with email</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form wire:submit.prevent="register" class="space-y-6">
            
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Full Name</label>
                <input wire:model="name" type="text" placeholder="e.g. Rahul Kumar" 
                       class="w-full border-2 border-gray-300 rounded-xl p-3 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-0 transition">
                @error('name') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Email Address</label>
                <input wire:model="email" type="email" placeholder="name@example.com" 
                       class="w-full border-2 border-gray-300 rounded-xl p-3 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-0 transition">
                @error('email') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Phone Number</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-bold border-r-2 border-gray-200 pr-3 my-2 text-sm">+91</span>
                    <input wire:model="phone" type="number" placeholder="98765 43210" 
                           class="w-full pl-20 border-2 border-gray-300 rounded-xl p-3 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-0 transition">
                </div>
                @error('phone') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Password</label>
                <input wire:model="password" type="password" placeholder="••••••••" 
                       class="w-full border-2 border-gray-300 rounded-xl p-3 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-0 transition">
                @error('password') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Confirm Password</label>
                <input wire:model="password_confirmation" type="password" placeholder="••••••••" 
                       class="w-full border-2 border-gray-300 rounded-xl p-3 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-0 transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Create Account
            </button>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Login here</a>
                </p>
            </div>
        </form>
    </div>
</div>