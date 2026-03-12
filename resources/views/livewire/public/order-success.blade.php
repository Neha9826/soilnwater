<div class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-6">
    <div class="max-w-md w-full bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100 text-center">
        {{-- Success Icon --}}
        <div class="w-24 h-24 bg-green-100 text-leaf-green rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
            <i class="fas fa-check-circle text-5xl" style="color: #2D5A27;"></i>
        </div>
        
        <h1 class="text-3xl font-black uppercase text-gray-900 mb-2">Order Placed!</h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs mb-8">Thank you for shopping with us</p>

        {{-- Order ID Card --}}
        <div class="bg-gray-50 rounded-3xl p-6 mb-8 border border-dashed border-gray-200">
            <p class="text-xs font-black text-gray-400 uppercase mb-1">Your Order ID</p>
            <p class="text-xl font-black" style="color: #2D5A27;">#{{ request()->order_number }}</p>
        </div>

        {{-- Action Buttons with Forced Colors --}}
        <div class="space-y-4">
            <a href="{{ route('customer.orders') }}" 
               style="background-color: #2D5A27 !important; color: white !important; display: block !important;"
               class="w-full font-black py-4 rounded-2xl hover:opacity-90 transition shadow-lg uppercase text-sm text-center">
                View My Orders
            </a>
            
            <a href="{{ route('home') }}" 
               style="border: 2px solid #2D5A27 !important; color: #2D5A27 !important; background-color: white !important; display: block !important;"
               class="w-full font-black py-4 rounded-2xl hover:bg-gray-50 transition uppercase text-sm text-center">
                Continue Shopping
            </a>
        </div>
        
        <p class="text-[10px] text-gray-400 mt-10 font-bold uppercase tracking-widest">
            A confirmation has been sent to your email.
        </p>
    </div>
</div>