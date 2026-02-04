<div class="relative w-full aspect-square bg-white shadow-2xl rounded-xl overflow-hidden font-sans">
    <div class="absolute top-0 right-0 w-[150%] h-48 bg-[#b18567] opacity-20 rounded-b-[100%] -translate-y-12 rotate-[-5deg]"></div>

    <div class="relative z-10 p-8 flex flex-col h-full">
        <p class="text-[#b18567] font-bold tracking-widest text-xs uppercase">{{ $get('default_data.company_name') }}</p>
        <h2 class="italic text-2xl text-gray-700 mt-1 font-serif">Special Today</h2>
        <h1 class="text-5xl font-black uppercase leading-none text-gray-800">{{ $get('default_data.main_headline') }}</h1>

        <div class="absolute top-32 left-1/2 w-32 h-32 bg-[#7b4f31] rounded-full border-4 border-dashed border-white flex flex-col items-center justify-center text-white shadow-xl">
            <span class="text-3xl font-black leading-none">50%</span>
            <span class="text-sm font-bold">OFF</span>
        </div>

        <div class="flex mt-8 gap-4">
            <div class="w-1/2">
                <h3 class="font-bold uppercase text-sm border-b-2 border-[#b18567] inline-block mb-3 text-gray-800 tracking-widest">Our Services</h3>
                <ul class="space-y-1">
                    @foreach($get('default_data.services') ?? [] as $service)
                        <li class="text-xs text-gray-600 font-bold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#b18567]"></span>
                            {{ $service['item'] ?? '' }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="w-1/2 flex flex-col items-end gap-2 -mt-10">
                @for($i=1; $i<=3; $i++)
                    <div class="w-24 h-24 rounded-full border-4 border-[#b18567] overflow-hidden shadow-lg bg-gray-50">
                        @if($get('default_data.image_'.$i))
                            <img src="{{ Storage::url($get('default_data.image_'.$i)) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>