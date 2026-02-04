@foreach($ads as $ad)
    @php
        // Map database units to Tailwind/CSS grid classes
        $widthSpan = $ad->template->tier->grid_width > 1 ? 'md:col-span-' . $ad->template->tier->grid_width : 'col-span-1';
        $heightSpan = $ad->template->tier->grid_height > 1 ? 'md:row-span-' . $ad->template->tier->grid_height : 'row-span-1';
        
        // Convert EAV values to a usable array for the template
        $data = $ad->values->mapWithKeys(function ($item) {
            return [$item->field->field_name => $item->value];
        })->toArray();
    @endphp

    <div class="{{ $widthSpan }} {{ $heightSpan }} overflow-hidden rounded-xl shadow-sm border border-gray-200 bg-white group relative">
        {{-- Load the specific Master Template View --}}
        @include($ad->template->blade_path, [
            'data' => $data, 
            'ad' => $ad,
            'is_preview' => false 
        ])

        {{-- Hover Overlay for Actions (Edit/Delete) --}}
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
             <a href="{{ route('customer.post.edit', $ad->id) }}" class="bg-white p-2 rounded-full text-blue-600 shadow">
                <i class="fas fa-edit"></i>
             </a>
             <span class="bg-white px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ $ad->status }}
             </span>
        </div>
    </div>
@endforeach