<div class="flex h-full w-full bg-gray-100">
    
    <main class="flex-1 p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-black mb-6">Create New Offer</h1>
            
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Offer Title *</label>
                            <input wire:model="title" type="text" placeholder="e.g. Diwali Dhamaka Sale" class="w-full border-2 rounded-lg p-2.5">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Discount Tag *</label>
                            <input wire:model="discount_tag" type="text" placeholder="e.g. 50% OFF" class="w-full border-2 rounded-lg p-2.5">
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Coupon Code (Optional)</label>
                            <input wire:model="coupon_code" type="text" class="w-full border-2 rounded-lg p-2.5">
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Valid Until</label>
                            <input wire:model="valid_until" type="date" class="w-full border-2 rounded-lg p-2.5">
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Target Category</label>
                            <select wire:model="product_category_id" class="w-full border-2 rounded-lg p-2.5">
                                <option value="">Global (All Categories)</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Banner Image *</label>
                            <input wire:model="image" type="file" class="w-full border-2 border-dashed p-4 rounded-lg">
                            @if($image) <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-32 rounded"> @endif
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Short Description</label>
                            <textarea wire:model="description" class="w-full border-2 rounded-lg p-2.5" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-green-700 transition shadow-lg">
                        Submit Offer for Approval
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>