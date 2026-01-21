<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Floor Plans</h3>
            <p class="text-sm text-gray-500">Add details for each floor level.</p>
        </div>
        <button type="button" wire:click="addFloor" class="text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-lg font-bold hover:bg-blue-100 transition flex items-center gap-2 border border-blue-200">
            <i class="fas fa-plus"></i> Add Floor
        </button>
    </div>

    <div class="space-y-8">
        @foreach($floors as $index => $floor)
            <div class="p-6 bg-gray-50 rounded-xl border border-gray-300 relative shadow-sm hover:shadow-md transition" wire:key="floor-{{ $index }}">
                
                <button type="button" wire:click="removeFloor({{ $index }})" 
                        class="absolute top-3 right-3 text-gray-400 hover:text-red-600 bg-white hover:bg-red-50 p-2 rounded-lg shadow-sm border border-gray-200 transition z-10"
                        title="Remove this floor">
                    <i class="fas fa-trash-alt"></i>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Floor Name *</label>
                        <input wire:model="floors.{{ $index }}.floor_name" type="text" placeholder="e.g. Ground Floor" 
                               class="w-full border-gray-300 rounded-lg p-2.5 border text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        @error("floors.{$index}.floor_name") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Area (sqft)</label>
                        <input wire:model="floors.{{ $index }}.area_sqft" type="number" placeholder="e.g. 1200" 
                               class="w-full border-gray-300 rounded-lg p-2.5 border text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Rooms</label>
                        <input wire:model="floors.{{ $index }}.rooms" type="number" placeholder="e.g. 3" 
                               class="w-full border-gray-300 rounded-lg p-2.5 border text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Floor Plan Image</label>
                        <div class="flex items-center gap-4 bg-white p-3 rounded-lg border border-gray-300">
                            <input wire:model="floors.{{ $index }}.new_image" type="file" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            
                            {{-- Show success indicator if uploaded --}}
                            @if(isset($floors[$index]['new_image']) && $floors[$index]['new_image'])
                                <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> New Selected
                                </span>
                            @elseif(!empty($floor['image_path']))
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-blue-600 font-bold flex items-center gap-1">
                                        <i class="fas fa-image"></i> Saved
                                    </span>
                                    <a href="{{ asset('storage/'.$floor['image_path']) }}" target="_blank" class="text-xs text-gray-400 underline hover:text-gray-600">View</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Description</label>
                        <textarea wire:model="floors.{{ $index }}.description" rows="2" placeholder="Describe the layout, specific features, or highlights of this floor..." 
                                  class="w-full border-gray-300 rounded-lg p-2.5 border text-sm focus:ring-blue-500 focus:border-blue-500 bg-white"></textarea>
                    </div>

                </div>
            </div>
        @endforeach

        @if(empty($floors))
            <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                <p>No floors added yet. Click "Add Floor" to begin.</p>
            </div>
        @endif
    </div>
</div>