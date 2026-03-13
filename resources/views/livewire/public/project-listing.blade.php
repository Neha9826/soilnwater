<div class="min-h-screen bg-gray-50 pb-20">
    <div class="bg-white border-b border-gray-200 py-10 mb-10 shadow-sm">
        <div class="max-w-[1440px] mx-auto px-6">
            <h1 class="text-4xl font-black text-gray-900 uppercase">Upcoming Projects</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest mt-2">New Launches & Society Developments</p>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($projects as $project)
            <div class="bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden shadow-sm hover:shadow-2xl transition duration-500 group">
                <div class="h-64 relative overflow-hidden">
                    @php 
                        $imgs = is_array($project->images) ? $project->images : json_decode($project->images, true);
                        $firstImg = $imgs[0] ?? null;
                    @endphp
                    <img src="{{ $firstImg ? route('ad.display', ['path' => $firstImg]) : asset('images/placeholder.png') }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <span class="absolute top-6 left-6 bg-leaf-green text-white text-[9px] font-black px-4 py-1.5 rounded-full uppercase">{{ $project->project_status }}</span>
                </div>
                <div class="p-8">
                    <h2 class="text-xl font-black text-gray-900 uppercase mb-2 truncate">{{ $project->title }}</h2>
                    <p class="text-xs font-bold text-gray-400 mb-6 uppercase"><i class="fas fa-map-marker-alt"></i> {{ $project->city }}, {{ $project->state }}</p>
                    <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                        <span class="text-2xl font-black text-gray-900">₹{{ number_format($project->price) }}</span>
                        <a href="{{ route('public.project.detail', $project->id) }}" class="bg-gray-900 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase">Explore Project</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>