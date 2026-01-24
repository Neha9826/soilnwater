<div class="min-h-screen bg-gray-50 py-8 px-4" 
     x-data="adBuilder()"
     @add-image-layer.window="addImageLayer($event.detail.url)">
    
    {{-- SCRIPT FOR SCREENSHOTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- LEFT PANEL: SETTINGS & TOOLS --}}
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Ad Configuration</h2>
                
                {{-- 1. TITLE & LINK --}}
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ad Title</label>
                        <input wire:model="title" type="text" class="w-full border-gray-300 rounded-lg p-2.5">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Target Link (Optional)</label>
                        <input wire:model="target_link" type="text" placeholder="https://..." class="w-full border-gray-300 rounded-lg p-2.5">
                    </div>
                </div>

                {{-- 2. MODE SELECTION --}}
                <div class="flex gap-4 mb-6">
                    <button @click="mode = 'upload'; $wire.set('mode', 'upload')" 
                            :class="mode === 'upload' ? 'bg-blue-600 text-white ring-2 ring-blue-300' : 'bg-gray-100 text-gray-600'"
                            class="flex-1 py-3 rounded-lg font-bold text-sm transition">
                        <i class="fas fa-upload mr-2"></i> Upload File
                    </button>
                    <button @click="mode = 'builder'; $wire.set('mode', 'builder')" 
                            :class="mode === 'builder' ? 'bg-orange-600 text-white ring-2 ring-orange-300' : 'bg-gray-100 text-gray-600'"
                            class="flex-1 py-3 rounded-lg font-bold text-sm transition">
                        <i class="fas fa-magic mr-2"></i> Ad Builder
                    </button>
                </div>

                {{-- UPLOAD MODE CONTENT --}}
                <div x-show="mode === 'upload'" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50">
                    <input wire:model="uploaded_file" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-2">Upload your ready-made poster (JPG, PNG)</p>
                    @if($uploaded_file)
                        <img src="{{ $uploaded_file->temporaryUrl() }}" class="mt-4 rounded-lg shadow-sm max-h-48 mx-auto">
                    @endif
                </div>

                {{-- BUILDER TOOLBAR --}}
                <div x-show="mode === 'builder'" class="space-y-6">
                    
                    {{-- Size Selector --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">1. Select Size</label>
                        <select x-model="canvasSize" @change="updateCanvasDimensions()" wire:model="canvas_size" class="w-full border-gray-300 rounded-lg p-2.5">
                            <option value="square">Square Post (1080x1080)</option>
                            <option value="story">Story / Reel (1080x1920)</option>
                            <option value="banner">Wide Banner (1200x628)</option>
                        </select>
                    </div>

                    {{-- Background Color --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">2. Background Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="bgColor" wire:model="bg_color" class="h-10 w-14 p-1 rounded border cursor-pointer">
                            <span class="text-sm text-gray-600" x-text="bgColor"></span>
                        </div>
                    </div>

                    {{-- Add Elements --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">3. Add Elements</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button @click="addTextLayer()" type="button" class="bg-white border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 font-bold text-sm">
                                <i class="fas fa-font mr-1 text-blue-500"></i> Add Text
                            </button>
                            <div class="relative">
                                <button type="button" class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 font-bold text-sm relative z-0">
                                    <i class="fas fa-image mr-1 text-green-500"></i> Add Image
                                </button>
                                <input type="file" wire:model.live="temp_layer_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            </div>
                        </div>
                    </div>

                    {{-- Active Layer Settings --}}
                    <div x-show="activeLayerIndex !== null" class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-orange-800 uppercase">Edit Selected</span>
                            <button @click="deleteLayer()" class="text-red-500 text-xs font-bold hover:underline">Delete</button>
                        </div>
                        
                        <template x-if="layers[activeLayerIndex]?.type === 'text'">
                            <div class="space-y-2">
                                <input type="text" x-model="layers[activeLayerIndex].content" class="w-full text-sm border-gray-300 rounded p-1">
                                <div class="flex gap-2">
                                    <input type="color" x-model="layers[activeLayerIndex].color" class="h-8 w-8 p-0 border rounded">
                                    <input type="number" x-model="layers[activeLayerIndex].fontSize" class="w-16 text-sm border-gray-300 rounded p-1" title="Font Size">
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="layers[activeLayerIndex]?.type === 'image'">
                            <div class="text-xs text-gray-500">
                                Drag to move. Use corner handle to resize (Future feature).
                            </div>
                        </template>
                    </div>

                </div>
            </div>

            {{-- SAVE BUTTON --}}
            <button @click="submitAd()" type="button" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 shadow-lg text-lg flex justify-center items-center gap-2">
                <span wire:loading.remove>Publish Ad</span>
                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Processing...</span>
            </button>

        </div>

        {{-- RIGHT PANEL: CANVAS AREA --}}
        <div class="lg:col-span-8 flex justify-center items-start bg-gray-200 rounded-xl p-8 overflow-auto min-h-[600px] border border-gray-300">
            
            {{-- THE CANVAS --}}
            <div x-show="mode === 'builder'"
                 id="ad-canvas" 
                 class="relative shadow-2xl transition-all duration-300 overflow-hidden bg-white"
                 :style="`width: ${width}px; height: ${height}px; background-color: ${bgColor};`"
                 @click.self="activeLayerIndex = null">
                
                {{-- LAYERS LOOP --}}
                <template x-for="(layer, index) in layers" :key="layer.id">
                    
                    {{-- Draggable Container --}}
                    <div class="absolute cursor-move select-none group"
                         :style="`left: ${layer.x}px; top: ${layer.y}px;`"
                         @mousedown="startDrag($event, index)"
                         @touchstart="startDrag($event, index)">
                        
                        {{-- Text Layer --}}
                        <template x-if="layer.type === 'text'">
                            <p :style="`color: ${layer.color}; font-size: ${layer.fontSize}px; font-weight: bold; font-family: sans-serif; white-space: nowrap;`"
                               :class="activeLayerIndex === index ? 'ring-2 ring-blue-500 ring-offset-2 rounded' : 'hover:ring-1 hover:ring-blue-300'"
                               x-text="layer.content"></p>
                        </template>

                        {{-- Image Layer --}}
                        <template x-if="layer.type === 'image'">
                            <img :src="layer.content" 
                                 class="w-32 h-auto object-cover rounded pointer-events-none"
                                 :class="activeLayerIndex === index ? 'ring-2 ring-blue-500 ring-offset-2' : ''">
                        </template>

                    </div>
                </template>

                {{-- Watermark (Optional) --}}
                <div class="absolute bottom-4 right-4 opacity-50 pointer-events-none">
                    <span class="text-xs font-bold text-gray-400">Powered by SoilNWater</span>
                </div>

            </div>

            {{-- Upload Preview Placeholder --}}
            <div x-show="mode === 'upload'" class="text-gray-400 text-center mt-20">
                <i class="fas fa-eye text-4xl mb-2"></i>
                <p>Preview will appear here after upload.</p>
            </div>

        </div>
    </div>
</div>

{{-- ALPINE.JS LOGIC --}}
<script>
function adBuilder() {
    return {
        mode: @entangle('mode'),
        canvasSize: 'square',
        width: 500, // Scaled down for UI
        height: 500,
        bgColor: '#ffffff',
        layers: [],
        activeLayerIndex: null,
        dragging: false,
        dragOffsetX: 0,
        dragOffsetY: 0,

        init() {
            this.updateCanvasDimensions();
        },

        updateCanvasDimensions() {
            if (this.canvasSize === 'square') { this.width = 500; this.height = 500; }
            if (this.canvasSize === 'story') { this.width = 350; this.height = 622; } // 9:16 approx
            if (this.canvasSize === 'banner') { this.width = 600; this.height = 314; }
        },

        addTextLayer() {
            this.layers.push({
                id: Date.now(),
                type: 'text',
                content: 'Double Click Edit',
                x: 50,
                y: 50,
                color: '#000000',
                fontSize: 24
            });
            this.activeLayerIndex = this.layers.length - 1;
        },

        addImageLayer(url) {
            this.layers.push({
                id: Date.now(),
                type: 'image',
                content: url,
                x: 50,
                y: 50
            });
            this.activeLayerIndex = this.layers.length - 1;
        },

        deleteLayer() {
            if (this.activeLayerIndex !== null) {
                this.layers.splice(this.activeLayerIndex, 1);
                this.activeLayerIndex = null;
            }
        },

        // --- DRAG LOGIC ---
        startDrag(event, index) {
            this.activeLayerIndex = index;
            this.dragging = true;
            
            // Calculate offset (click position relative to element)
            const el = event.target.closest('div.absolute'); // Get the wrapper
            const rect = el.getBoundingClientRect();
            const parentRect = document.getElementById('ad-canvas').getBoundingClientRect();

            // Touch or Mouse support
            const clientX = event.touches ? event.touches[0].clientX : event.clientX;
            const clientY = event.touches ? event.touches[0].clientY : event.clientY;

            this.dragOffsetX = clientX - rect.left;
            this.dragOffsetY = clientY - rect.top;

            const onMove = (e) => {
                if (!this.dragging) return;
                e.preventDefault(); // Stop scrolling on touch

                const cx = e.touches ? e.touches[0].clientX : e.clientX;
                const cy = e.touches ? e.touches[0].clientY : e.clientY;

                // New Position relative to canvas
                let newX = cx - parentRect.left - this.dragOffsetX;
                let newY = cy - parentRect.top - this.dragOffsetY;

                // Update Alpine Data
                this.layers[index].x = newX;
                this.layers[index].y = newY;
            };

            const onUp = () => {
                this.dragging = false;
                window.removeEventListener('mousemove', onMove);
                window.removeEventListener('mouseup', onUp);
                window.removeEventListener('touchmove', onMove);
                window.removeEventListener('touchend', onUp);
            };

            window.addEventListener('mousemove', onMove);
            window.addEventListener('mouseup', onUp);
            window.addEventListener('touchmove', onMove, { passive: false });
            window.addEventListener('touchend', onUp);
        },

        // --- SUBMISSION ---
        async submitAd() {
            if (this.mode === 'builder') {
                // Capture Canvas
                const canvas = document.getElementById('ad-canvas');
                
                // Temporarily remove selection rings for screenshot
                this.activeLayerIndex = null; 
                await new Promise(r => setTimeout(r, 50)); // Tiny wait for UI update

                try {
                    const canvasImage = await html2canvas(canvas, {
                        useCORS: true, // Allow external images
                        scale: 2 // High Res
                    });
                    
                    const dataURL = canvasImage.toDataURL("image/png");
                    
                    // Send to Livewire
                    @this.set('generated_image_data', dataURL);
                    @this.set('layers', this.layers); // Save JSON state
                    @this.call('save');
                } catch (error) {
                    alert('Error generating image. Please try again.');
                    console.error(error);
                }
            } else {
                // Standard Upload Mode
                @this.call('save');
            }
        }
    };
}
</script>