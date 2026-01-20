<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">What would you like to post today?</h2>
        <p class="mt-4 text-xl text-gray-500">Choose a category to get started.</p>
    </div>

    <div class="max-w-6xl mx-auto grid gap-8 grid-cols-1 md:grid-cols-3">
        
        <a href="{{ route('customer.property.create') }}" class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 p-8 border border-gray-200 group text-center cursor-pointer relative overflow-hidden transform hover:-translate-y-2">
            <div class="absolute top-0 left-0 w-full h-2 bg-blue-500"></div>
            <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-600 transition-colors duration-300">
                <i class="fas fa-home text-3xl text-blue-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Sell / Rent Property</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                Post your Apartment, Villa, Plot, or Share-a-Space. Reach thousands of local buyers and tenants instantly.
            </p>
            <span class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-bold rounded-full group-hover:bg-blue-600 group-hover:text-white transition-all">
                List for Free
            </span>
        </a>

        <a href="#" class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 p-8 border border-gray-200 group text-center cursor-pointer relative overflow-hidden transform hover:-translate-y-2 opacity-75 hover:opacity-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500"></div>
            <div class="bg-purple-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-600 transition-colors duration-300">
                <i class="fas fa-building text-3xl text-purple-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Post New Project</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                Launching a new residential or commercial project? Promote it here to attract serious investors.
            </p>
            <span class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded shadow-sm">PREMIUM</span>
            <span class="inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-bold rounded-full group-hover:bg-purple-600 group-hover:text-white transition-all">
                Start Campaign
            </span>
        </a>

        <a href="#" class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 p-8 border border-gray-200 group text-center cursor-pointer relative overflow-hidden transform hover:-translate-y-2 opacity-75 hover:opacity-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-pink-500"></div>
            <div class="bg-pink-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-pink-600 transition-colors duration-300">
                <i class="fas fa-bullhorn text-3xl text-pink-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Run Advertisement</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                Promote your business with custom banner ads. Design them yourself or upload your creative.
            </p>
            <span class="inline-block px-6 py-2 border-2 border-pink-600 text-pink-600 font-bold rounded-full group-hover:bg-pink-600 group-hover:text-white transition-all">
                Create Ad
            </span>
        </a>

    </div>
    
    <div class="text-center mt-12">
        <a href="/" class="text-gray-400 hover:text-gray-600 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Cancel and go back home
        </a>
    </div>
</div>