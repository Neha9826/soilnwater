<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-3xl font-black uppercase mb-10">Checkout</h1>

        @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        <p class="font-bold">Please fix the following errors:</p>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    
        {{-- Crucial: wire:submit.prevent must be on the form tag --}}
        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Left Side: Shipping Information --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black uppercase mb-6 flex items-center gap-3">
                        <i class="fas fa-truck text-leaf-green"></i> Shipping Address
                    </h2>

                    {{-- Saved Address Selector --}}
                    @if(count($savedAddresses) > 0)
                    <div class="mb-8">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-3">Select a Saved Address</label>
                        <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                            @foreach($savedAddresses as $addr)
                            <div wire:click="setAddress({{ $addr->id }})" 
                                class="min-w-[250px] cursor-pointer p-4 rounded-2xl border-2 transition {{ $selectedAddressId == $addr->id ? 'border-leaf-green bg-green-50' : 'border-gray-100 bg-white' }}">
                                <p class="text-[10px] font-black uppercase">{{ $addr->name }}</p>
                                <p class="text-[9px] text-gray-500 truncate">{{ $addr->address }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
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
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Order Summary --}}
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-lg border border-gray-100 sticky top-24">
                    <h2 class="text-xl font-black uppercase mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3 text-sm">
                            <img src="{{ route('ad.display', ['path' => $item->product->images[0] ?? '']) }}" class="w-12 h-12 object-cover rounded-lg border border-gray-100">
                            <div class="flex-grow">
                                <span class="text-gray-900 font-bold block leading-tight">{{ $item->product->name }}</span>
                                <span class="text-gray-400 text-xs font-black">{{ $item->quantity }} x ₹{{ number_format($item->product->discounted_price ?: $item->product->price) }}</span>
                            </div>
                            <span class="font-black text-soil-green">₹{{ number_format(($item->product->discounted_price ?: $item->product->price) * $item->quantity) }}</span>
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

                    <button type="submit" 
                            style="background-color: #2D5A27 !important; color: white !important;"
                            class="w-full font-black py-5 rounded-2xl mt-8 hover:opacity-90 transition transform active:scale-95 shadow-xl flex items-center justify-center gap-3">
                        <i class="fas fa-check-circle"></i> 
                        <span wire:loading.remove wire:target="placeOrder">PLACE ORDER</span>
                        <span wire:loading wire:target="placeOrder"><i class="fas fa-spinner fa-spin"></i> PROCESSING...</span>
                    </button>
                    
                    <p class="text-[10px] text-center text-gray-400 mt-4 uppercase font-bold tracking-widest">
                        Secure SSL Encrypted Checkout
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>