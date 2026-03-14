<div class="min-h-screen bg-[#f3f4f6] pb-16 font-sans">
    {{-- Breadcrumb Navigation --}}
    <div class="bg-white border-b py-3 mb-6">
        <div class="max-w-[1100px] mx-auto px-4 flex justify-between items-center">
            <nav class="flex text-[9px] font-black uppercase text-gray-400 tracking-widest">
                <a href="/">Home</a> <span class="mx-2">/</span> 
                <a href="/projects">Projects</a> <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $project->title }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-[1100px] mx-auto px-4">
        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            {{-- LEFT: Media & Overview (65%) --}}
            <div style="flex: 0 0 65%; max-width: 65%;" class="space-y-6">
                {{-- Square Main Gallery --}}
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm aspect-square border">
                    <img src="{{ route('ad.display', ['path' => $project->images[0] ?? '']) }}" class="w-full h-full object-cover">
                </div>

                {{-- Property Facts Grid --}}
                <div class="bg-white rounded-[2.5rem] p-8 border shadow-sm">
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-6 border-b pb-4">Project Overview</h2>
                    <div class="text-[12px] text-gray-600 leading-relaxed mb-8">
                        {!! nl2br(e($project->description)) !!}
                    </div>

                    {{-- Amenities - Moved to Content Column to avoid sidebar overlap --}}
                    <h2 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-6 border-b pb-4">Key Amenities</h2>
                    <div class="grid grid-cols-3 gap-6">
                        @foreach($project->amenities ?? [] as $amenity)
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-50 flex items-center justify-center">
                                    <i class="fas fa-check text-green-500 text-[8px]"></i>
                                </div>
                                <span class="text-[10px] font-bold text-gray-700 uppercase">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT: Sticky Price Card (35%) --}}
            <div style="flex: 0 0 32%; max-width: 32%; position: sticky; top: 20px;">
                <div class="bg-white rounded-[2.5rem] p-6 border shadow-2xl">
                    <div class="mb-6">
                        <span class="bg-blue-600 text-white text-[8px] font-black px-2 py-1 rounded uppercase mb-3 inline-block">Verified Project</span>
                        <h1 class="text-lg font-black text-gray-900 uppercase leading-tight">{{ $project->title }}</h1>
                        <p class="text-[9px] font-bold text-gray-400 uppercase mt-1">
                            <i class="fas fa-map-marker-alt text-green-500"></i> {{ $project->city }}, {{ $project->state }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100">
                        <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Price Start From</p>
                        <span class="text-2xl font-black text-green-600 tracking-tighter">₹{{ number_format($project->price) }}</span>
                    </div>

                    <div class="space-y-3">
                        <button class="w-full bg-gray-900 text-white font-black py-4 rounded-2xl uppercase text-[10px] hover:bg-green-600 transition shadow-lg">Download Brochure</button>
                        <button class="w-full border-2 border-gray-100 text-gray-900 font-black py-4 rounded-2xl uppercase text-[10px] hover:bg-gray-50 transition">Enquire Now</button>
                    </div>

                    @if($project->rera_number)
                        <div class="mt-8 pt-6 border-t border-dashed border-gray-200 text-center">
                            <span class="text-[8px] font-black text-gray-300 uppercase block mb-1">Registration ID</span>
                            <span class="text-[10px] font-bold text-gray-700">RERA: {{ $project->rera_number }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>