<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-2">New Projects in Dehradun</h1>
    <p class="text-gray-500 mb-8">Exclusive residential and commercial developments</p>
    
    <div class="space-y-8">
        @foreach($projects as $project)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 flex flex-col md:flex-row h-auto md:h-72 hover:shadow-xl transition">
                
                <div class="md:w-1/3 bg-gray-200 relative">
                     @if($project->images)
                        <img src="{{ $project->images ? route('ad.display', ['filename' => basename($project->images[0])]) : asset('images/placeholder.png') }}" class="w-full h-full object-cover">
                    @endif
                    <span class="absolute top-4 left-4 bg-black bg-opacity-70 text-white text-xs px-3 py-1 rounded uppercase tracking-wider">
                        {{ $project->status }}
                    </span>
                </div>
                
                <div class="p-6 md:w-2/3 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h3>
                            @if($project->rera_id)
                                <span class="bg-green-100 text-green-800 text-[10px] px-2 py-1 rounded border border-green-200">
                                    RERA: {{ $project->rera_id }}
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-500 mt-1">📍 {{ $project->location }}, {{ $project->city }}</p>
                        
                        <div class="flex gap-4 mt-4 text-sm text-gray-600">
                            @if(in_array('club', $project->amenities ?? [])) <span>🏊 Pool</span> @endif
                            @if(in_array('gym', $project->amenities ?? [])) <span>💪 Gym</span> @endif
                            @if(in_array('park', $project->amenities ?? [])) <span>🌳 Park</span> @endif
                        </div>
                        
                        <p class="text-gray-500 mt-4 line-clamp-2 text-sm">{{ $project->description }}</p>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-6">
                        <button class="bg-blue-900 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition">
                            Download Brochure
                        </button>
                        <button class="border border-blue-900 text-blue-900 px-6 py-2 rounded-lg font-bold hover:bg-blue-50 transition">
                            Contact Builder
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>