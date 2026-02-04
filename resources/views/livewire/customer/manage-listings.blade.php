<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">My Listings Manager</h1>
            <p class="text-gray-500 mt-1">Manage all your Properties, Projects, and Ads in one place.</p>
        </div>
        
        {{-- Unified "Post New" Button --}}
        <a href="{{ route('post.choose-category') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg flex items-center gap-2 transform transition hover:-translate-y-1 w-full md:w-auto justify-center">
            <i class="fas fa-plus-circle"></i> Post New Ad
        </a>
    </div>

    {{-- TABS HEADER --}}
    <div class="border-b border-gray-200 mb-8 overflow-x-auto">
        <nav class="-mb-px flex gap-10" aria-label="Tabs">
            <button wire:click="switchTab('properties')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition whitespace-nowrap {{ $activeTab === 'properties' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-home mr-2 {{ $activeTab === 'properties' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Properties
            </button>

            <button wire:click="switchTab('projects')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition whitespace-nowrap {{ $activeTab === 'projects' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-building mr-2 {{ $activeTab === 'projects' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Projects
            </button>

            <button wire:click="switchTab('ads')" 
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition whitespace-nowrap {{ $activeTab === 'ads' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-ad mr-2 {{ $activeTab === 'ads' ? 'text-orange-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Ads & Promotions
            </button>
        </nav>
    </div>

    {{-- TABS CONTENT --}}
    <div>
        @if($activeTab === 'properties')
            <livewire:customer.my-posts />
        @elseif($activeTab === 'projects')
            <livewire:customer.my-projects />
        @elseif($activeTab === 'ads')
            {{-- This is where the grid logic happens --}}
            <livewire:customer.my-ads />
        @endif
    </div>
</div>