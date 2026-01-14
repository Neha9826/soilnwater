<x-filament-panels::page>
    <div class="space-y-6">
        @if($pendingProducts->isEmpty())
            <div class="flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="h-12 w-12 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center mb-4">
                    <x-heroicon-o-check class="w-6 h-6" />
                </div>
                <p class="text-gray-500 dark:text-gray-400">All caught up! No pending products.</p>
            </div>
        @else
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-white/5 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Product</th>
                            <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Vendor</th>
                            <th class="p-4 font-medium text-gray-500 dark:text-gray-400">Price</th>
                            <th class="p-4 font-medium text-right text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($pendingProducts as $product)
                            <tr wire:key="prod-{{ $product->id }}" class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @php $img = $product->images[0] ?? null; @endphp
                                        <div class="h-10 w-10 bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border dark:border-gray-700">
                                            @if($img) <img src="{{ asset('storage/'.$img) }}" class="h-full w-full object-cover"> @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-gray-600 dark:text-gray-300">{{ $product->user->name ?? 'N/A' }}</td>
                                <td class="p-4 font-bold text-gray-900 dark:text-white">₹{{ $product->price }}</td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.product.approval', $product->id) }}" 
                                           class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-lg text-xs font-bold transition border border-blue-200 dark:border-blue-800">
                                            Review Details
                                        </a>
                                        
                                        <button wire:click="approveProduct({{ $product->id }})" class="px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white rounded-lg text-xs font-bold transition">
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $pendingProducts->links() }}</div>
        @endif
    </div>
</x-filament-panels::page>