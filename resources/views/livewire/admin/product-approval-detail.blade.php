<div class="p-6 max-w-7xl mx-auto space-y-8">
    
    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('filament.admin.pages.approvals') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 flex items-center gap-1 text-sm font-bold mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4" /> Back to List
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $product->name }}</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Submitted by <span class="font-bold text-primary-600">{{ $product->user->name }}</span> on {{ $product->created_at->format('d M, Y') }}</p>
        </div>
        <div class="flex gap-3">
            <button @click="$wire.set('showRejectModal', true)" class="px-6 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg font-bold border border-red-200 transition">Reject</button>
            <button wire:click="approve" class="px-6 py-2 bg-green-600 text-white hover:bg-green-700 rounded-lg font-bold shadow-md transition">Approve & Publish</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Product Gallery</h3>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @if($product->images)
                        @foreach($product->images as $img)
                            <a href="{{ asset('storage/'.$img) }}" target="_blank">
                                <img src="{{ asset('storage/'.$img) }}" class="h-32 w-32 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                            </a>
                        @endforeach
                    @else
                        <p class="text-gray-400 italic">No images uploaded.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Description</h3>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {{ $product->description }}
                </div>
            </div>

            @if($product->video_path || $product->video_url)
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Product Video</h3>
                @if($product->video_path)
                    <video controls class="w-full rounded-lg max-h-96 bg-black">
                        <source src="{{ asset('storage/'.$product->video_path) }}" type="video/mp4">
                    </video>
                @elseif($product->video_url)
                    <div class="aspect-video w-full rounded-lg overflow-hidden bg-black">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $product->video_url) }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
            @endif

            @if(!empty($product->specifications))
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Specifications</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($product->specifications as $key => $val)
                        <div class="flex justify-between border-b dark:border-gray-800 pb-1">
                            <span class="text-gray-500 font-medium">{{ $key }}</span>
                            <span class="text-gray-900 dark:text-white font-bold">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-8">
            
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Pricing Details</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Base Price</span>
                        <span class="font-bold text-gray-900 dark:text-white">₹{{ $product->price }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Discount</span>
                        <span class="font-bold text-green-600">{{ $product->discount_percentage }}%</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t dark:border-gray-800">
                        <span class="text-gray-500 font-bold">Final Price</span>
                        <span class="font-extrabold text-xl text-primary-600">₹{{ $product->discounted_price ?? $product->price }}</span>
                    </div>
                </div>

                @if(!empty($product->tiered_pricing))
                    <div class="mt-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">B2B Wholesale Rates</label>
                        @foreach($product->tiered_pricing as $tier)
                            <div class="flex justify-between text-sm border-b border-gray-200 dark:border-gray-700 last:border-0 py-1">
                                <span class="text-gray-600 dark:text-gray-300">Buy {{ $tier['min_qty'] }}+</span>
                                <span class="font-bold text-gray-900 dark:text-white">₹{{ $tier['unit_price'] }} <span class="text-xs font-normal text-gray-400">/unit</span></span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Logistics</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>Stock</span> <span class="font-bold">{{ $product->stock_quantity }} units</span></div>
                    <div class="flex justify-between"><span>Weight</span> <span class="font-bold">{{ $product->weight ?? 'N/A' }} kg</span></div>
                    <div class="flex justify-between"><span>Dimensions</span> <span class="font-bold">{{ $product->dimensions ?? 'N/A' }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span> <span class="font-bold text-green-600">₹{{ $product->shipping_charges ?? 0 }}</span></div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-800 pb-2">Variations</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Colors</span>
                        <div class="flex flex-wrap gap-2">
                            @if(!empty($product->colors))
                                @foreach($product->colors as $c) <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs border dark:border-gray-600">{{ $c }}</span> @endforeach
                            @else N/A @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Sizes</span>
                        <div class="flex flex-wrap gap-2">
                            @if(!empty($product->sizes))
                                @foreach($product->sizes as $s) <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs border dark:border-gray-600">{{ $s }}</span> @endforeach
                            @else N/A @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div x-data="{ show: @entangle('showRejectModal') }"
         x-show="show" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" 
         style="display: none;" 
         x-transition.opacity>
        
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-md p-6 m-4 border border-gray-200 dark:border-gray-700" @click.away="show = false">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400 mb-2">Reject Product</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Please specify why this product is being rejected.</p>
            
            <textarea wire:model="rejectionReason" rows="4" class="w-full bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg p-3 text-sm focus:border-red-500 dark:focus:border-red-500 dark:text-white focus:ring-0" placeholder="Reason..."></textarea>
            @error('rejectionReason') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror

            <div class="flex justify-end gap-3 mt-4">
                <button @click="show = false" class="px-4 py-2 text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
                <button wire:click="reject" class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700">Confirm Rejection</button>
            </div>
        </div>
    </div>

</div>