<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans antialiased">
    {{-- Slim Navigation --}}
    <div class="bg-white border-b border-gray-200 py-3 shadow-sm mb-6">
        <div class="max-w-[1100px] mx-auto px-4 flex justify-between items-center">
            <nav class="flex text-[10px] font-black uppercase tracking-tight text-gray-400">
                <a href="/" class="hover:text-green-600">Home</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="/deals" class="hover:text-green-600">Offers</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900">{{ $offer->offer_title }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-[1100px] mx-auto px-4">
        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            {{-- LEFT: Media & Offer Details (65%) --}}
            <div style="flex: 0 0 65%; max-width: 65%;" class="space-y-6">
                {{-- Main Offer Image --}}
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-200 aspect-video">
                    <img src="{{ route('ad.display', ['path' => $offer->image]) }}" class="w-full h-full object-cover">
                </div>

                {{-- Offer Description Content --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm">
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4 border-b pb-3">About This Offer</h2>
                    <div class="text-gray-600 text-[13px] leading-relaxed mb-8">
                        {!! nl2br(e($offer->offer_description)) !!}
                    </div>

                    {{-- Terms/Highlights --}}
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4 border-b pb-3">Terms & Conditions</h2>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-500 text-[10px]"></i>
                            <span class="text-[10px] font-bold text-gray-700 uppercase">Valid until: {{ \Carbon\Carbon::parse($offer->expiry_date)->format('D, d M Y') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-500 text-[10px]"></i>
                            <span class="text-[10px] font-bold text-gray-700 uppercase">Non-transferable and valid for one-time use.</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- RIGHT: Sticky Coupon Card (35%) --}}
            <div style="flex: 0 0 32%; max-width: 32%; position: sticky; top: 20px;">
                <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-2xl">
                    <div class="mb-6">
                        <span class="bg-red-600 text-white text-[8px] font-black px-2 py-0.5 rounded uppercase inline-block mb-3">Limited Time Deal</span>
                        <h1 class="text-lg font-black text-gray-900 uppercase leading-tight mb-2">{{ $offer->offer_title }}</h1>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 mb-6 border-2 border-dashed border-gray-200 text-center">
                        <p class="text-[8px] font-black text-gray-400 uppercase mb-2">Use Coupon Code</p>
                        <span class="text-2xl font-black text-gray-900 tracking-widest select-all bg-white px-4 py-1 rounded-lg border shadow-sm inline-block">
                            {{ $offer->coupon_code }}
                        </span>
                    </div>

                    <div class="p-4 bg-green-50 rounded-2xl mb-6 border border-green-100 text-center">
                        <p class="text-[8px] font-black text-green-600 uppercase">Discount Value</p>
                        <span class="text-xl font-black text-green-700">
                            {{ $offer->discount_amount }}{{ $offer->discount_type == 'percentage' ? '%' : ' FLAT' }} OFF
                        </span>
                    </div>

                    <button onclick="navigator.clipboard.writeText('{{ $offer->coupon_code }}'); alert('Code Copied!')" 
                            class="w-full bg-gray-900 text-white font-black py-4 rounded-xl uppercase text-[10px] hover:bg-green-600 transition shadow-md mb-3">
                        Copy Coupon Code
                    </button>
                    
                    <p class="text-[7px] font-black text-center text-gray-400 uppercase">Click the code to copy to clipboard</p>
                </div>
            </div>

        </div>
    </div>
</div>