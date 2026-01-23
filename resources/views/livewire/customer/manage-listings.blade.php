<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">My Listings Manager</h1>
            <p class="text-gray-500 mt-1">Manage all your Properties, Projects, and Ads in one place.</p>
        </div>
        
        {{-- Unified "Post New" Button (Dropdown or Link) --}}
        <a href="{{ route('post.choose-category') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg flex items-center gap-2 transform transition hover:-translate-y-1 w-full md:w-auto justify-center">
            <i class="fas fa-plus-circle"></i> Post New Ad
        </a>
    </div>

    {{-- TABS HEADER --}}
    <div class="border-b border-gray-200 mb-8">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            
            {{-- Tab 1: Properties --}}
            <button wire:click="switchTab('properties')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition {{ $activeTab === 'properties' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-home mr-2 {{ $activeTab === 'properties' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Properties
            </button>

            {{-- Tab 2: Projects --}}
            <button wire:click="switchTab('projects')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition {{ $activeTab === 'projects' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-building mr-2 {{ $activeTab === 'projects' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Projects
            </button>

            {{-- Tab 3: Ads / Promotions --}}
            <button wire:click="switchTab('ads')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition {{ $activeTab === 'ads' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-ad mr-2 {{ $activeTab === 'ads' ? 'text-orange-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Ads & Promotions
            </button>
        </nav>
    </div>

    {{-- TABS CONTENT --}}
    <div>
        @if($activeTab === 'properties')
            {{-- We reuse the existing MyPosts component here --}}
            <livewire:customer.my-posts />
        
        @elseif($activeTab === 'projects')
            {{-- We reuse the existing MyProjects component here --}}
            <livewire:customer.my-projects />
        
        @elseif($activeTab === 'ads')
            {{-- Placeholder for future Ads module --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="h-20 w-20 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bullhorn text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">No Active Promotions</h3>
                <p class="text-gray-500 mt-2 mb-6">You haven't posted any classified ads or paid promotions yet.</p>
                <button class="text-blue-600 font-bold hover:underline" disabled>Coming Soon</button>
            </div>
        @endif
    </div>

</div>