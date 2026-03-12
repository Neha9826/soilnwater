{{-- resources/views/livewire/customer/my-orders.blade.php --}}
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        <h1 class="text-3xl font-black uppercase mb-10 flex items-center gap-4">
            <i class="fas fa-box text-leaf-green" style="color: #2D5A27;"></i> My Order History
        </h1>

        <div class="space-y-8">
            @forelse($orders as $order)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Order Header Section --}}
                    <div class="bg-gray-50 px-8 py-4 border-b flex flex-wrap justify-between items-center gap-4">
                        <div class="flex gap-8">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Order Placed</p>
                                <p class="font-bold text-sm text-gray-900">{{ $order->created_at->format('d M, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Amount</p>
                                <p class="font-bold text-sm text-soil-green" style="color: #2D5A27;">₹{{ number_format($order->total_amount) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Order #</p>
                                <a href="{{ route('order.detail', $order->order_number) }}" class="font-bold text-sm text-leaf-green hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </div>
                        </div>
                        
                        {{-- Status Badge --}}
                        <div class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter 
                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $order->status }}
                        </div>
                    </div>

                    {{-- Individual Order Items --}}
                    <div class="p-8 space-y-6">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-6">
                                <img src="{{ route('ad.display', ['path' => $item->product->images[0] ?? '']) }}" 
                                     class="w-16 h-16 object-cover rounded-xl border">
                                <div class="flex-grow">
                                    <h4 class="font-bold text-gray-900 uppercase text-sm leading-tight">{{ $item->product->name }}</h4>
                                    <p class="text-xs text-gray-500 font-medium">Quantity: {{ $item->quantity }} | Price: ₹{{ number_format($item->price) }}</p>
                                </div>
                                <a href="{{ route('public.product.detail', $item->product->slug) }}" 
                                   style="color: #2D5A27; border-color: #2D5A27;"
                                   class="text-[10px] font-black border-2 px-4 py-2 rounded-lg hover:bg-leaf-green hover:text-white transition uppercase tracking-widest">
                                    BUY AGAIN
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-200">
                    <i class="fas fa-shopping-basket text-6xl text-gray-200 mb-4"></i>
                    <h2 class="text-2xl font-black text-gray-400 uppercase">No orders found</h2>
                    <a href="{{ route('public.products.index') }}" class="inline-block mt-4 font-black hover:underline" style="color: #2D5A27;">Start Shopping &rarr;</a>
                </div>
            @endforelse
        </div>
    </div>
</div>