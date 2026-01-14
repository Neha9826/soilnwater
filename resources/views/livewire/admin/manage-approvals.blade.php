<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ rejectModalOpen: @entangle('showRejectModal') }">
    
    <x-admin-sidebar />

    <main class="flex-1 overflow-y-auto bg-gray-50 p-8 md:pl-72">
        
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Approvals Center</h1>
            <p class="text-gray-500 mb-8">Review and approve pending products and vendor profiles.</p>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">Success</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="flex gap-4 mb-6 border-b border-gray-200">
                <button wire:click="setTab('products')" 
                        class="pb-3 px-4 font-bold text-sm transition border-b-4 {{ $activeTab === 'products' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-box-open mr-2"></i> Pending Products
                </button>
                <button wire:click="setTab('vendors')" 
                        class="pb-3 px-4 font-bold text-sm transition border-b-4 {{ $activeTab === 'vendors' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-store mr-2"></i> Pending Vendors
                </button>
            </div>

            @if($activeTab === 'products')
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    @if($pendingProducts->isEmpty())
                        <div class="p-12 text-center text-gray-500">
                            <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                            <p>All caught up! No pending products.</p>
                        </div>
                    @else
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                                <tr>
                                    <th class="p-4">Image</th>
                                    <th class="p-4">Product Name</th>
                                    <th class="p-4">Vendor</th>
                                    <th class="p-4">Price</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($pendingProducts as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-4">
                                            @php $img = $product->images[0] ?? null; @endphp
                                            <div class="h-12 w-12 bg-gray-100 rounded border overflow-hidden">
                                                @if($img) <img src="{{ asset('storage/'.$img) }}" class="h-full w-full object-cover"> @endif
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-bold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                        </td>
                                        <td class="p-4 text-sm">{{ $product->user->name ?? 'Unknown' }}</td>
                                        <td class="p-4 font-bold">₹{{ $product->price }}</td>
                                        <td class="p-4 text-right flex justify-end gap-2">
                                            <button wire:click="approveProduct({{ $product->id }})" class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-green-200">Approve</button>
                                            <button wire:click="openRejectModal({{ $product->id }}, 'product')" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-200">Reject</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif

            @if($activeTab === 'vendors')
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    @if($pendingVendors->isEmpty())
                        <div class="p-12 text-center text-gray-500">
                            <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                            <p>No pending vendor profiles.</p>
                        </div>
                    @else
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                                <tr>
                                    <th class="p-4">Logo</th>
                                    <th class="p-4">Business Name</th>
                                    <th class="p-4">Owner</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($pendingVendors as $biz)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-4">
                                            <div class="h-12 w-12 bg-gray-100 rounded-full border overflow-hidden">
                                                @if($biz->logo) <img src="{{ asset('storage/'.$biz->logo) }}" class="h-full w-full object-cover"> @endif
                                            </div>
                                        </td>
                                        <td class="p-4 font-bold text-gray-900">{{ $biz->name }}</td>
                                        <td class="p-4 text-sm">{{ $biz->contact_person }}</td>
                                        <td class="p-4 text-right flex justify-end gap-2">
                                            <button wire:click="approveVendor({{ $biz->id }})" class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-green-200">Approve</button>
                                            <button wire:click="openRejectModal({{ $biz->id }}, 'vendor')" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-200">Reject</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif

        </div>
    </main>

    <div x-show="rejectModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 m-4" @click.away="rejectModalOpen = false">
            <h3 class="text-lg font-bold text-red-600 mb-2">Reject Item</h3>
            <textarea wire:model="rejectionReason" rows="4" class="w-full border-2 border-gray-200 rounded-lg p-3 text-sm focus:border-red-500" placeholder="Reason for rejection..."></textarea>
            <div class="flex justify-end gap-3 mt-4">
                <button @click="rejectModalOpen = false" class="px-4 py-2 text-gray-600 font-bold hover:bg-gray-100 rounded-lg">Cancel</button>
                <button wire:click="submitRejection" class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700">Confirm</button>
            </div>
        </div>
    </div>
</div>