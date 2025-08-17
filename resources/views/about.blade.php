<x-app-layout>
    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 h-[500px] flex items-center justify-center overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500/20 rounded-full blur-3xl animate-pulse delay-2000"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium text-white mb-8 animate-fade-in-up">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                About HybridLand
            </div>
            
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black mb-8 leading-tight drop-shadow-2xl animate-fade-in-up">
                About <span class="bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">{{ __('about.hybridland') }}</span>
            </h1>
            <p class="text-xl md:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed animate-fade-in-up delay-100 font-light">
                Revolutionizing the car marketplace with innovation, trust, and excellence. 
                Discover our story and mission to transform how people buy and sell vehicles.
            </p>
        </div>
    </div>

    {{-- Our Story Section --}}
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Our Story
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                        Building the Future of <span class="text-indigo-600">{{ __('about.car_commerce') }}</span>
                    </h2>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Founded in 2024, HybridLand emerged from a simple vision: to create the most trusted and efficient platform for car enthusiasts and buyers. We recognized that the traditional car buying and selling process was fragmented, time-consuming, and often frustrating.
                    </p>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Today, we're proud to serve thousands of users who trust HybridLand for their automotive needs. Our platform combines cutting-edge technology with human-centered design to deliver an unparalleled car shopping experience.
                    </p>
                    <div class="flex items-center space-x-6 pt-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">{{ $totalCarsCount ?? '1000' }}+</div>
                            <div class="text-gray-600">{{ __('about.cars_listed') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">500+</div>
                            <div class="text-gray-600">{{ __('about.happy_users') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">50+</div>
                            <div class="text-gray-600">{{ __('about.cities_served') }}</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-3xl p-8 shadow-2xl">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2">Fast & Efficient</h3>
                                <p class="text-gray-600 text-sm">{{ __('about.quick_listing') }}</p>
                            </div>
                            <div class="bg-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                                    <h3 class="font-bold text-gray-900 mb-2">{{ __('about.verified_listings') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('about.verified_listings_desc') }}</p>
                            </div>
                            <div class="bg-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v3h8z" />
                                    </svg>
                                </div>
                                                    <h3 class="font-bold text-gray-900 mb-2">{{ __('about.secure_platform') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('about.secure_platform_desc') }}</p>
                            </div>
                            <div class="bg-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                                    <h3 class="font-bold text-gray-900 mb-2">{{ __('about.user_friendly') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('about.user_friendly_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mission & Vision Section --}}
    <div class="py-24 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Our Mission & Vision</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Driving innovation in the automotive marketplace through technology and trust.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Mission --}}
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.our_mission') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        To revolutionize the car buying and selling experience by providing a transparent, efficient, and trustworthy platform that connects car enthusiasts with their perfect vehicles.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Simplify the car buying process
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Ensure transparency and trust
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Provide exceptional customer support
                        </li>
                    </ul>
                </div>

                {{-- Vision --}}
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.our_vision') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        To become the leading global platform for automotive commerce, setting industry standards for innovation, customer satisfaction, and market transparency.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Global market leadership
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Industry innovation standards
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Sustainable growth model
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Values Section --}}
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __('about.our_core_values') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">The principles that guide everything we do at HybridLand.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Trust --}}
                <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl border border-blue-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.trust') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We build lasting relationships through transparency, honesty, and reliability in every interaction.
                    </p>
                </div>

                {{-- Innovation --}}
                <div class="text-center p-8 bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl border border-purple-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.innovation') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We continuously push boundaries to create better solutions for our users and the industry.
                    </p>
                </div>

                {{-- Excellence --}}
                <div class="text-center p-8 bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl border border-green-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.excellence') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We strive for excellence in every aspect of our service, from technology to customer support.
                    </p>
                </div>

                {{-- Community --}}
                <div class="text-center p-8 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-3xl border border-yellow-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.community') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We foster a vibrant community of car enthusiasts, dealers, and buyers who share our passion.
                    </p>
                </div>

                {{-- Sustainability --}}
                <div class="text-center p-8 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-3xl border border-teal-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.sustainability') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We promote sustainable practices and support eco-friendly automotive solutions.
                    </p>
                </div>

                {{-- Customer First --}}
                <div class="text-center p-8 bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl border border-red-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('about.customer_first') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Every decision we make is guided by what's best for our customers and their experience.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Team Section --}}
    <div class="py-24 bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6">{{ __('about.meet_our_team') }}</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">The passionate individuals behind HybridLand's success.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Team Member 1 --}}
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">{{ __('about.jd') }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">{{ __('about.john_doe') }}</h3>
                    <p class="text-indigo-300 mb-4">Founder & CEO</p>
                    <p class="text-gray-400 leading-relaxed">
                        Automotive enthusiast with 15+ years of experience in digital platforms and marketplaces.
                    </p>
                </div>

                {{-- Team Member 2 --}}
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">JS</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Jane Smith</h3>
                    <p class="text-green-300 mb-4">CTO</p>
                    <p class="text-gray-400 leading-relaxed">
                        Technology leader passionate about creating seamless user experiences and scalable solutions.
                    </p>
                </div>

                {{-- Team Member 3 --}}
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">MJ</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Mike Johnson</h3>
                    <p class="text-yellow-300 mb-4">Head of Operations</p>
                    <p class="text-gray-400 leading-relaxed">
                        Operations expert dedicated to ensuring smooth processes and exceptional customer service.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Call to Action Section --}}
    <div class="py-24 bg-gradient-to-r from-indigo-600 to-purple-700">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Join the HybridLand Community</h2>
            <p class="text-xl text-white/90 mb-10 leading-relaxed">
                Be part of the future of car commerce. Start your journey with HybridLand today!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('cars.index') }}" class="group inline-flex items-center px-10 py-4 text-lg font-bold rounded-full text-indigo-600 bg-white hover:bg-gray-100 shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center">
                        Browse Cars
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>
                </a>
                <a href="{{ route('cars.create') }}" class="group inline-flex items-center px-10 py-4 text-lg font-bold rounded-full text-white border-2 border-white hover:bg-white hover:text-indigo-600 transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center">
                        List Your Car
                        <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>


</x-app-layout> 