<div class="max-w-7xl mx-auto py-12 px-4">
    
    {{-- 1. LOGIC: Check for any Pending Business --}}
    @php
        $pendingBusiness = Auth::user()->businesses()->where('is_verified', false)->first();
    @endphp

    {{-- 2. ALERT: Show Pending Warning --}}
    @if($pendingBusiness)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-10 rounded-r-lg shadow-sm animate-fade-in-down">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-yellow-600 text-2xl mt-1"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-yellow-800">Application Pending Approval</h3>
                    <p class="text-yellow-700 mt-1">
                        Your registration for <strong>{{ $pendingBusiness->name }}</strong> is currently under review by our Admin Team. 
                    </p>
                    <p class="text-sm text-yellow-600 mt-2">
                        <i class="fas fa-info-circle"></i> You will be able to manage your inventory and add more branches once this is approved.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- 3. HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">
                Account Status: <span class="uppercase font-bold text-blue-600">{{ Auth::user()->profile_type }}</span>
            </p>
        </div>
        
        <div class="flex gap-4">
            <a href="#" class="bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                <i class="fas fa-home text-blue-500"></i> Post Property
            </a>

            @if(Auth::user()->profile_type === 'customer')
                <a href="{{ route('join.partner') }}" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-blue-700 shadow-lg transition animate-pulse flex items-center gap-2">
                    <i class="fas fa-handshake"></i> Join as Partner
                </a>
            @else
                @if(!$pendingBusiness)
                    <a href="{{ route('onboarding') }}" class="bg-black text-white font-bold py-2.5 px-6 rounded-xl hover:bg-gray-800 shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i> Add New Branch
                    </a>
                @else
                    <button disabled class="bg-gray-300 text-gray-500 font-bold py-2.5 px-6 rounded-xl cursor-not-allowed flex items-center gap-2" title="Wait for approval first">
                        <i class="fas fa-lock"></i> Add New Branch
                    </button>
                @endif
            @endif
        </div>
    </div>

    {{-- 4. BUSINESS LIST (For Partners) --}}
    @if(Auth::user()->profile_type !== 'customer')
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-store text-gray-400"></i> My Businesses / Branches
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(Auth::user()->businesses as $business)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group relative">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-4 right-4">
                        @if($business->is_verified)
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 animate-pulse">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @endif
                    </div>

                    {{-- Card Content --}}
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-14 w-14 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-xl font-bold text-gray-500">
                                @if($business->logo)
                                    <img src="{{ asset('storage/'.$business->logo) }}" class="h-full w-full object-cover rounded-lg">
                                @else
                                    {{ substr($business->name, 0, 1) }}
                                @endif
                            </div>
                            
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 leading-tight">{{ $business->name }}</h3>
                                <p class="text-xs text-gray-500 uppercase">{{ $business->type }}</p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500 mb-6 flex items-start gap-2">
                            <i class="fas fa-map-marker-alt mt-1 text-gray-400"></i>
                            <span class="line-clamp-2">{{ $business->address }}</span>
                        </div>

                        {{-- Actions --}}
                        <div class="pt-4 border-t border-gray-100 flex gap-3">
                            @if($business->is_verified)
                                <a href="{{ route('business.manage', $business->id) }}" class="flex-1 bg-blue-50 text-blue-600 text-center py-2 rounded-lg font-bold text-sm hover:bg-blue-100 transition">
                                    Manage Shop
                                </a>
                                <a href="{{ url('/v/'.$business->slug) }}" target="_blank" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition" title="View Public Page">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @else
                                <button disabled class="flex-1 bg-gray-100 text-gray-400 text-center py-2 rounded-lg font-bold text-sm cursor-not-allowed">
                                    Awaiting Approval
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="h-16 w-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">You haven't added any branches yet.</p>
                    <p class="text-sm text-gray-400 mt-1">Click the "Add New Branch" button above to get started.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>