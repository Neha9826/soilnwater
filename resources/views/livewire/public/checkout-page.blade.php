<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-3xl font-black uppercase mb-10">Checkout</h1>

        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Left Side: Shipping Information --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black uppercase mb-6 flex items-center gap-3">
                        <i class="fas fa-truck text-leaf-green"></i> Shipping Address
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                            <input wire:model="name" type="text" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition">
                            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Phone Number</label>
                            <input wire:model="phone" type="text" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition">
                            @error('phone') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Pincode</label>
                            <input wire:model="pincode" type="text" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition">
                            @error('pincode') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Detailed Address</label>
                            <textarea wire:model="address" rows="3" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition"></textarea>
                            @error('address') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">City</label>
                            <input wire:model="city" type="text" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition">
                            @error('city') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">State</label>
                            <select wire:model="state" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3 focus:border-leaf-green outline-none transition">
                                <option value="">Select State</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Uttarakhand">Uttarakhand</option>
                                {{-- Add more states as needed --}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Order Summary & Action --}}
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-lg border border-gray-100 sticky top-24">
                    <h2 class="text-xl font-black uppercase mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">{{ $item->quantity }}x {{ $item->product->name }}</span>
                            <span class="font-bold">₹{{ number_format(($item->product->discounted_price ?: $item->product->price) * $item->quantity) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dashed pt-4 space-y-2">
                        <div class="flex justify-between font-bold">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-leaf-green">
                            <span>Shipping</span>
                            <span>FREE</span>
                        </div>
                        <div class="flex justify-between text-2xl font-black text-soil-green pt-2">
                            <span>Total</span>
                            <span>₹{{ number_format($total) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-leaf-green text-white font-black py-5 rounded-2xl mt-8 hover:bg-soil-green transition transform active:scale-95 shadow-xl flex items-center justify-center gap-3">
                        <i class="fas fa-check-circle"></i> PLACE ORDER
                    </button>
                    
                    <p class="text-[10px] text-center text-gray-400 mt-4 uppercase font-bold tracking-widest">
                        Secure SSL Encrypted Checkout
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>