<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-3xl font-black uppercase mb-10">Your Shopping Bag</h1>

        {{-- Use a grid with 3 columns on large screens --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            {{-- Left: Item List (Takes up 2 columns) --}}
            <div class="lg:col-span-2 space-y-4">
                @forelse($cartItems as $item)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-6">
                        <img src="{{ route('ad.display', ['path' => $item->product->images[0] ?? '']) }}" class="w-24 h-24 object-cover rounded-2xl">
                        <div class="flex-grow">
                            <h3 class="font-bold text-lg">{{ $item->product->name }}</h3>
                            <p class="text-soil-green font-black">₹{{ number_format($item->product->discounted_price ?: $item->product->price) }}</p>
                        </div>
                        {{-- Quantity controls logic from previous step --}}
                        <div class="flex items-center gap-4 bg-gray-50 rounded-xl p-2">
                            <button wire:click="decrement({{ $item->id }})" class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm">-</button>
                            <span class="font-bold">{{ $item->quantity }}</span>
                            <button wire:click="increment({{ $item->id }})" class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm">+</button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed">
                        <p class="text-gray-400 font-bold uppercase">Your cart is empty.</p>
                    </div>
                @endforelse
            </div>

            {{-- Right: Summary (Takes up 1 column and stays sticky) --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 sticky top-28">
                    <h3 class="text-xl font-black mb-6 uppercase">Order Summary</h3>
                    <div class="flex justify-between mb-4 font-bold">
                        <span class="text-gray-400">Subtotal</span>
                        <span>₹{{ number_format($total) }}</span>
                    </div>
                    <div class="border-t border-dashed pt-4 mt-4">
                        <div class="flex justify-between text-2xl font-black text-soil-green mb-8">
                            <span>Total</span>
                            <span>₹{{ number_format($total) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-[#4CAF50] text-white text-center font-black py-5 rounded-2xl hover:bg-[#2D5A27] transition shadow-xl uppercase">
                        Proceed to Checkout
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>