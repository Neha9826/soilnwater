<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">

    @if(!$selectedRole)
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Partner with SoilNWater</h1>
            <p class="text-xl text-gray-500 mb-12">Choose your business category to begin the application.</p>
            
            {{-- Copy your existing Grid of Cards here --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 <div wire:click="selectRole('vendor')" class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 cursor-pointer hover:border-blue-600 hover:shadow-2xl transition group transform hover:-translate-y-1">
                    <div class="h-20 w-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-store text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Vendor</h3>
                    <p class="text-sm text-gray-500 mt-2">Sell materials, tools, and hardware.</p>
                </div>
                {{-- (Other cards...) --}}
                 <div wire:click="selectRole('consultant')" class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 cursor-pointer hover:border-purple-600 hover:shadow-2xl transition group transform hover:-translate-y-1">
                    <div class="h-20 w-20 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Consultant</h3>
                    <p class="text-sm text-gray-500 mt-2">Architects, Interior Designers, Legal.</p>
                </div>
                <div wire:click="selectRole('hotel')" class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 cursor-pointer hover:border-orange-500 hover:shadow-2xl transition group transform hover:-translate-y-1">
                    <div class="h-20 w-20 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-600 group-hover:text-white transition">
                        <i class="fas fa-hotel text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Hotel & Resort</h3>
                    <p class="text-sm text-gray-500 mt-2">List rooms, homestays, and resorts.</p>
                </div>
                <div wire:click="selectRole('builder')" class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 cursor-pointer hover:border-gray-800 hover:shadow-2xl transition group transform hover:-translate-y-1">
                    <div class="h-20 w-20 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-gray-800 group-hover:text-white transition">
                        <i class="fas fa-city text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Builder</h3>
                    <p class="text-sm text-gray-500 mt-2">Developers and Construction Projects.</p>
                </div>
                 <div wire:click="selectRole('service')" class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 cursor-pointer hover:border-green-600 hover:shadow-2xl transition group transform hover:-translate-y-1">
                    <div class="h-20 w-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="fas fa-tools text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Service Provider</h3>
                    <p class="text-sm text-gray-500 mt-2">Plumbing, Electrician, Repairs.</p>
                </div>
            </div>
        </div>

    @else
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8 items-stretch relative">
            
            <div class="w-full lg:w-1/3 relative">
                
                <div class="sticky top-24 space-y-6">
                    <button wire:click="backToGrid" class="w-full bg-white text-gray-700 font-bold py-3 px-4 rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition flex items-center justify-center gap-2 mb-4 shadow-sm">
                        <i class="fas fa-arrow-left"></i> Change Category
                    </button>

                    <div class="bg-blue-900 rounded-2xl shadow-xl p-8 text-white border border-blue-800">
                        <h2 class="text-2xl font-bold mb-6 text-white border-b border-blue-700 pb-4">
                            Why Join as a {{ ucfirst($selectedRole) }}?
                        </h2>
                        
                        <ul class="space-y-6">
                            <li class="flex items-start gap-4">
                                <div class="bg-blue-700 p-3 rounded-lg shrink-0 shadow-md">
                                    <i class="fas fa-qrcode text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-white">Digital Identity</h4>
                                    <p class="text-sm text-blue-100 mt-1">Get a unique QR code and profile page.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="bg-blue-700 p-3 rounded-lg shrink-0 shadow-md">
                                    <i class="fas fa-infinity text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-white">Unlimited Listings</h4>
                                    <p class="text-sm text-blue-100 mt-1">Upload as many products as you want.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="bg-blue-700 p-3 rounded-lg shrink-0 shadow-md">
                                    <i class="fab fa-whatsapp text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-white">Direct Chat</h4>
                                    <p class="text-sm text-blue-100 mt-1">Customers contact you directly on WhatsApp.</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-8 pt-6 border-t border-blue-800">
                            <p class="text-xs text-blue-200 leading-relaxed font-bold bg-blue-800 p-3 rounded-lg">
                                <i class="fas fa-shield-alt mr-1"></i> 
                                Your data is secure. Approval typically takes 24 hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <h2 class="text-3xl font-extrabold text-gray-900">
                            {{ ucfirst($selectedRole) }} Registration
                        </h2>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-blue-200">
                            New Application
                        </span>
                    </div>

                    <form wire:submit.prevent="submitForm" class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Company Name <span class="text-red-500">*</span></label>
                                <input wire:model="company_name" type="text" placeholder="Enter your business name"
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900 font-medium">
                                @error('company_name') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Contact Person <span class="text-red-500">*</span></label>
                                <input wire:model="contact_person" type="text" placeholder="Owner Name"
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Company Logo <span class="text-red-500">*</span></label>
                                <input wire:model="logo" type="file" 
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border-2 border-gray-300 rounded-xl cursor-pointer">
                                @error('logo') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border-2 border-gray-200 mt-4">
                            <h4 class="font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Contact Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Contact Number <span class="text-red-500">*</span></label>
                                    <input wire:model="phone" type="number" 
                                           class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900 bg-white">
                                    @error('phone') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">WhatsApp Number</label>
                                    <input wire:model="whatsapp_number" type="number" 
                                           class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900 bg-white">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Email Address <span class="text-red-500">*</span></label>
                                    <input wire:model="email" type="email" 
                                           class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900 bg-white">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Address <span class="text-red-500">*</span></label>
                                <input wire:model="address" type="text" placeholder="Shop No, Street, Landmark"
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">City <span class="text-red-500">*</span></label>
                                <input wire:model="city" type="text" 
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">State <span class="text-red-500">*</span></label>
                                <input wire:model="state" type="text" 
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Pincode <span class="text-red-500">*</span></label>
                                <input wire:model="pincode" type="number" 
                                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Country</label>
                                <input wire:model="country" type="text" readonly
                                       class="w-full border-2 border-gray-200 bg-gray-100 text-gray-500 rounded-xl p-3 cursor-not-allowed font-bold">
                            </div>
                        </div>

                        <div class="border-t-2 border-dashed border-gray-200 pt-6 mt-6">
                            <h4 class="font-bold text-gray-800 mb-4">Legal Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">PAN Number <span class="text-red-500">*</span></label>
                                    <input wire:model="pan_number" type="text" class="w-full border-2 border-gray-300 rounded-xl p-3 uppercase placeholder-gray-400 text-gray-900 font-bold">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">
                                        GST Number {{ in_array($selectedRole, ['vendor', 'builder', 'hotel']) ? '*' : '(Optional)' }}
                                    </label>
                                    <input wire:model="gst_number" type="text" class="w-full border-2 border-gray-300 rounded-xl p-3 uppercase placeholder-gray-400 text-gray-900 font-bold">
                                    @error('gst_number') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">
                                    {{ ucfirst($selectedRole) }} Category <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select wire:model="category_type" class="w-full border-2 border-gray-300 rounded-xl p-3 appearance-none bg-white focus:border-blue-600 focus:ring-0 transition text-gray-900 font-bold">
                                        <option value="">Select specific category...</option>
                                        @if($selectedRole == 'vendor')
                                            <option>Hardware Store</option><option>Tools & Machinery</option><option>Home Decor</option><option>Construction Material</option>
                                        @elseif($selectedRole == 'consultant')
                                            <option>Architect</option><option>Interior Designer</option><option>Vastu Consultant</option><option>Legal Advisor</option>
                                        @elseif($selectedRole == 'hotel')
                                            <option>Hotel</option><option>Resort</option><option>Homestay</option>
                                        @elseif($selectedRole == 'service')
                                            <option>Plumber</option><option>Electrician</option><option>Carpenter</option><option>Painter</option>
                                        @endif
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Brief Description <span class="text-red-500">*</span></label>
                                <textarea wire:model="description" rows="4" placeholder="Tell us about your services..." 
                                          class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-blue-600 focus:ring-0 transition text-gray-900"></textarea>
                                @error('description') <span class="text-red-600 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-2xl border-2 border-blue-100 mt-6">
                            <h4 class="font-bold text-blue-900 mb-4">Media Gallery</h4>
                            
                            <label class="block text-sm font-bold text-gray-900 mb-2">Upload Images (Min 3) <span class="text-red-500">*</span></label>
                            <input wire:model="images" type="file" multiple 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-blue-700 hover:file:bg-blue-100 mb-4 cursor-pointer">
                            @error('images') <span class="text-red-600 text-xs font-bold block mb-4">{{ $message }}</span> @enderror

                            <label class="block text-sm font-bold text-gray-900 mb-2 mt-4">Upload Video (Optional)</label>
                            <input wire:model="video" type="file" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                        </div>

                        <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-xl text-lg flex items-center justify-center gap-2 transform hover:-translate-y-1 mt-6">
                            <span>Submit Application</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endif
</div>