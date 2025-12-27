<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Add New {{ ucfirst(Auth::user()->profile_type) }} Business
        </h1>
        <p class="text-gray-500 mb-8">Enter the details for this branch/location.</p>

        <form wire:submit.prevent="registerBusiness" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Business Name</label>
                <input wire:model="name" type="text" class="w-full border-gray-300 rounded-lg p-3">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            @if(Auth::user()->profile_type === 'vendor')
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <label class="block text-sm font-bold text-blue-800 mb-1">GST Number</label>
                    <input wire:model="gst_number" type="text" class="w-full border-blue-200 rounded-lg p-3 uppercase">
                    @error('gst_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            @endif

            <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition">
                Create Business
            </button>
        </form>
    </div>
</div>