<div class="flex h-full w-full bg-gray-100" x-data="{ mobileMenuOpen: false }">
    
    <x-vendor-sidebar />

    <main class="flex-1 w-full overflow-y-auto bg-gray-50 p-4 md:p-8">
        
        <div class="md:hidden mb-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm text-gray-700 font-bold w-full flex justify-between">
                <span>Menu</span><i class="fas fa-bars"></i>
            </button>
        </div>

        @if (session()->has('message'))
            <div class="max-w-5xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-sm animate-pulse">
                <p class="font-bold">Success</p>
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <div class="max-w-5xl mx-auto pb-20">
            
            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 border-b border-gray-200 pb-6 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Website Builder</h1>
                    <p class="text-gray-500 mt-1">Design your public profile block by block.</p>
                </div>
                
                <div class="flex gap-3">
                    @if(!empty($current_slug))
                        <a href="{{ route('public.profile', ['slug' => $current_slug]) }}" target="_blank" class="flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2 px-4 rounded-lg transition shadow-sm">
                            <i class="fas fa-eye text-blue-500"></i> Preview
                        </a>
                    @else
                        <button disabled class="flex items-center gap-2 bg-gray-100 text-gray-400 font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                            <i class="fas fa-eye-slash"></i> Preview
                        </button>
                    @endif

                    <a href="{{ route('dashboard') }}" class="text-red-500 font-bold py-2 px-4 rounded-lg hover:bg-red-50 transition border border-transparent hover:border-red-200">
                        Cancel & Exit
                    </a>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">

                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="fas fa-paint-brush text-purple-500 bg-purple-50 p-2 rounded-lg"></i> Branding & Header
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="col-span-1 text-center">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Company Logo</label>
                            <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full overflow-hidden border-4 border-white shadow-lg group">
                                @if ($store_logo) 
                                    <img src="{{ $store_logo->temporaryUrl() }}" class="object-cover w-full h-full">
                                @elseif($existing_logo)
                                    <img src="{{ asset('storage/'.$existing_logo) }}" class="object-cover w-full h-full">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-gray-300"><i class="fas fa-camera text-4xl"></i></div>
                                @endif
                                <label for="logo-upload" class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition">
                                    <span class="text-xs font-bold uppercase tracking-wider">Change Logo</span>
                                </label>
                                <input wire:model="store_logo" type="file" id="logo-upload" class="hidden">
                            </div>
                            @error('store_logo') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Page Title</label>
                                <input wire:model="header_title" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Subtitle</label>
                                <input wire:model="header_subtitle" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Banner Images</label>
                                <input wire:model="header_images" type="file" multiple class="block w-full text-sm text-gray-500"/>
                                @error('header_images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                
                                <div class="flex gap-3 mt-4 flex-wrap">
                                    @foreach($existing_headers as $index => $img)
                                        <div class="relative h-20 w-32 group rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                            <img src="{{ asset('storage/'.$img) }}" class="h-full w-full object-cover">
                                            <button type="button" wire:click="removeHeaderImage({{ $index }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition"><i class="fas fa-times"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-2">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-layer-group text-blue-500 bg-blue-50 p-2 rounded-lg"></i> Content Sections
                        </h2>
                        <button type="button" wire:click="addSection" class="bg-black text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-gray-800 transition shadow-md">
                            + Add Section
                        </button>
                    </div>

                    <div class="space-y-8">
                        @foreach($sections as $index => $section)
                            <div wire:key="section-{{ $index }}" class="bg-gray-50 p-6 rounded-2xl border border-gray-200 relative group">
                                <button type="button" wire:click="removeSection({{ $index }})" class="absolute top-4 right-4 text-gray-400 hover:text-red-600 bg-white p-2 rounded-full shadow-sm z-10"><i class="fas fa-trash-alt"></i></button>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="col-span-1">
                                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Image</label>
                                        <div class="relative h-48 bg-white border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center overflow-hidden cursor-pointer">
                                            @if(isset($sections[$index]['new_image']) && $sections[$index]['new_image'])
                                                <img src="{{ $sections[$index]['new_image']->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                            @elseif(isset($section['image_path']) && $section['image_path'])
                                                <img src="{{ asset('storage/'.$section['image_path']) }}" class="absolute inset-0 w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                                                <span class="text-xs text-gray-400 font-bold">Upload</span>
                                            @endif
                                            <input type="file" wire:model="sections.{{ $index }}.new_image" class="absolute inset-0 opacity-0 cursor-pointer">
                                        </div>
                                    </div>

                                    <div class="col-span-2 space-y-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Title</label>
                                            <input wire:model.defer="sections.{{ $index }}.title" type="text" class="w-full mt-1 bg-white border-gray-300 rounded-xl p-3 border">
                                        </div>
                                        
                                        <div wire:ignore 
                                             x-data="{
                                                 content: @entangle('sections.'.$index.'.description'),
                                                 initQuill() {
                                                     let quill = new Quill(this.$refs.editor, {
                                                         theme: 'snow',
                                                         modules: { toolbar: [['bold', 'italic', 'underline'], [{'list':'ordered'}, {'list':'bullet'}]] }
                                                     });
                                                     if (this.content) { quill.root.innerHTML = this.content; }
                                                     quill.on('text-change', () => { this.content = quill.root.innerHTML; });
                                                 }
                                             }"
                                             x-init="initQuill()"
                                        >
                                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Description</label>
                                            <div x-ref="editor" class="bg-white h-40 border border-gray-300 rounded-xl"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="fas fa-address-card text-green-500 bg-green-50 p-2 rounded-lg"></i> Contact Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Store Name *</label>
                            <input wire:model="store_name" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                            @error('store_name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Full Address</label>
                            <input wire:model="address" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Facebook Link</label>
                            <input wire:model="facebook" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Instagram Link</label>
                            <input wire:model="instagram" type="text" class="w-full border-gray-300 rounded-xl p-3 border">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 pb-12">
                    <button type="submit" 
                            class="flex items-center gap-2 bg-black text-white font-bold py-4 px-10 rounded-xl hover:bg-gray-800 shadow-lg transition transform hover:-translate-y-1 text-lg disabled:opacity-50 disabled:cursor-wait">
                        <span wire:loading.remove wire:target="save">Save & Publish Website</span>
                        <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>