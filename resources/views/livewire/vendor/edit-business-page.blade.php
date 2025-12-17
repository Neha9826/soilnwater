<div class="max-w-4xl mx-auto py-10 px-4">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Landing Page</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">&larr; Back to Dashboard</a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border border-green-400">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="bg-white shadow-lg rounded-xl p-8 space-y-6">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Header Images (Slideshow)</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50">
                <input wire:model="header_images" type="file" multiple class="hidden" id="upload-headers">
                <label for="upload-headers" class="cursor-pointer text-blue-600 font-bold hover:text-blue-800">
                    <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i><br>
                    Click to Upload Images
                </label>
                <p class="text-xs text-gray-400 mt-1">Upload multiple images for your page banner.</p>
            </div>

            <div class="grid grid-cols-4 gap-4 mt-4">
                @foreach($existing_headers as $index => $img)
                    <div class="relative group">
                        <img src="{{ asset('storage/'.$img) }}" class="h-24 w-full object-cover rounded-lg shadow">
                        <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 text-xs opacity-0 group-hover:opacity-100 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforeach
                @foreach($header_images as $img)
                    <div class="relative">
                        <img src="{{ $img->temporaryUrl() }}" class="h-24 w-full object-cover rounded-lg shadow opacity-70">
                        <span class="absolute bottom-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">New</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Business Name</label>
                <input wire:model="store_name" type="text" class="w-full border-gray-300 rounded-lg p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Business Address</label>
                <input wire:model="address" type="text" placeholder="Shop No, Street, City" class="w-full border-gray-300 rounded-lg p-3 border">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">About Your Organization</label>
            <textarea wire:model="about_text" rows="5" class="w-full border-gray-300 rounded-lg p-3 border" placeholder="Tell customers about your services, history, and values..."></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Facebook URL</label>
                <input wire:model="facebook" type="text" placeholder="https://facebook.com/..." class="w-full border-gray-300 rounded-lg p-3 border">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Instagram URL</label>
                <input wire:model="instagram" type="text" placeholder="https://instagram.com/..." class="w-full border-gray-300 rounded-lg p-3 border">
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-blue-700 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-800 shadow-md transition">
                Save Page Details
            </button>
        </div>
    </form>
</div>