<div class="max-w-7xl mx-auto py-12 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Posted Projects</h2>
        <a href="{{ route('customer.project.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-purple-700">
            <i class="fas fa-plus"></i> Post New Project
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-purple-100">
                <div class="h-48 bg-gray-200">
                    @if(!empty($project->images))
                        <img src="{{ asset('storage/'.$project->images[0]) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-lg text-gray-900 truncate">{{ $project->title }}</h3>
                        <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">{{ $project->project_status }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">{{ $project->city }}</p>
                    <p class="text-purple-700 font-bold mt-2">Starts ₹{{ number_format($project->price) }}</p>
                    
                    <div class="mt-4 flex gap-2 border-t pt-3">
                        <a href="{{ route('customer.project.edit', $project->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded text-sm font-bold">Edit</a>
                        <button wire:click="delete({{ $project->id }})" onclick="confirm('Delete this project?') || event.stopImmediatePropagation()" class="flex-1 text-center bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded text-sm font-bold">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>