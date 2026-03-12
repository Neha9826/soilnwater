<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-black uppercase italic">Order Detail</h1>
            <a href="{{ route('customer.orders') }}" class="text-sm font-bold text-gray-400 hover:text-black transition">
                &larr; BACK TO HISTORY
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 font-bold shadow-sm border-l-4 border-green-500">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Side: Order Items & Policy (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Ordered Items</h3>
                        <div class="space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-6 border-b border-gray-50 pb-6 last:border-0">
                                    <img src="{{ route('ad.display', ['path' => $item->product->images[0] ?? '']) }}" class="w-20 h-20 object-cover rounded-2xl border">
                                    <div class="flex-grow">
                                        <h4 class="font-black text-gray-900 uppercase text-sm">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-gray-400 font-bold">QTY: {{ $item->quantity }} x ₹{{ number_format($item->price) }}</p>
                                    </div>
                                    <p class="font-black text-soil-green">₹{{ number_format($item->price * $item->quantity) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Cancellation & Policy Section --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 italic">Cancellation Policy</h3>
                    <div class="text-[11px] text-gray-500 space-y-2 leading-relaxed font-medium">
                        <p>• Orders can be cancelled only while the status is <span class="text-yellow-600 font-black">PENDING</span>.</p>
                        <p>• Once an order is marked as <span class="font-black">SHIPPED</span> or <span class="font-black">DELIVERED</span>, cancellation is not possible.</p>
                        <p>• Refund for cancelled prepaid orders will be processed within 5-7 working days.</p>
                    </div>

                    @if($order->status === 'pending')
                        <button wire:click="cancelOrder" 
                                wire:confirm="Are you sure you want to cancel this order?"
                                class="mt-6 bg-red-50 text-red-600 text-[10px] font-black py-3 px-8 rounded-xl hover:bg-red-600 hover:text-white transition uppercase tracking-widest">
                            Cancel This Order
                        </button>
                    @endif
                </div>
            </div>

            {{-- Right Side: Summary & Shipping (1/3) --}}
            <div class="space-y-6">
                {{-- Address Card --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 italic">Delivery Address</h3>
                    <div class="space-y-1">
                        <p class="font-black text-sm uppercase">{{ $order->name }}</p>
                        <p class="text-xs text-gray-500 font-bold leading-relaxed">
                            {{ $order->address }}<br>
                            {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}
                        </p>
                        <p class="text-xs font-black text-gray-900 pt-2">Phone: {{ $order->phone }}</p>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="bg-[#2D5A27] rounded-[2.5rem] p-8 text-white shadow-xl">
                    <h3 class="text-xs font-black opacity-60 uppercase tracking-widest mb-6">Price Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm opacity-80">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order->total_amount) }}</span>
                        </div>
                        <div class="flex justify-between text-sm opacity-80">
                            <span>Shipping</span>
                            <span class="font-black">FREE</span>
                        </div>
                        <div class="border-t border-white/20 pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-black uppercase text-xs">Total Amount</span>
                                <span class="text-2xl font-black italic">₹{{ number_format($order->total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 bg-white/10 rounded-2xl p-4 border border-white/10">
                        <p class="text-[9px] font-black uppercase opacity-60 mb-1">Current Status</p>
                        <p class="text-sm font-black uppercase tracking-tighter italic">{{ $order->status }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>