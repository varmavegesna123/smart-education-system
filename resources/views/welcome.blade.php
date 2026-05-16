<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Education – AI Powered Learning & Career Guidance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- External Libraries -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .minimal-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
        }
        .minimal-card:hover {
            border-color: rgba(0, 193, 106, 0.3);
            background: rgba(255, 255, 255, 0.04);
        }
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-green {
            background: linear-gradient(135deg, #00C16A 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        /* Custom Swiper pagination */
        .swiper-pagination-bullet { background-color: rgba(255,255,255,0.3) !important; width: 6px; height: 6px; }
        .swiper-pagination-bullet-active { background-color: #00C16A !important; width: 16px; border-radius: 4px; }
        
        .grid-bg {
            background-image: linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
        }
    </style>
</head>
<body class="bg-[#09090b] text-gray-100 overflow-x-hidden antialiased selection:bg-[#00C16A] selection:text-white">

    <!-- 1. Sticky Navbar -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 10)"
         :class="{'glass-nav py-2': scrolled, 'py-4 bg-transparent': !scrolled}" 
         class="fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-10">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-[#00C16A] flex items-center justify-center font-bold text-white text-xs shadow-sm">S</div>
                    <span class="text-base font-semibold tracking-tight">Smart<span class="text-[#00C16A]">Edu</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="#home" class="text-sm text-gray-400 hover:text-white transition duration-200">Home</a>
                    <a href="#about" class="text-sm text-gray-400 hover:text-white transition duration-200">About</a>
                    <a href="#courses" class="text-sm text-gray-400 hover:text-white transition duration-200">Courses</a>
                    <a href="#services" class="text-sm text-gray-400 hover:text-white transition duration-200">Services</a>
                    <a href="#testimonials" class="text-sm text-gray-400 hover:text-white transition duration-200">Testimonials</a>
                    <a href="#contact" class="text-sm text-gray-400 hover:text-white transition duration-200">Contact</a>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('admin'))
                            <a href="{{ route('teacher.dashboard') }}" class="text-sm font-medium bg-[#00C16A] text-white px-4 py-1.5 rounded-md hover:bg-emerald-500 transition shadow-sm">Teacher Portal</a>
                        @endif
                        @if(auth()->user()->hasRole('student'))
                            <a href="{{ route('student.dashboard') }}" class="text-sm font-medium bg-[#00C16A] text-white px-4 py-1.5 rounded-md hover:bg-emerald-500 transition shadow-sm">Student Portal</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-400 hover:text-white transition">Sign Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-white text-black hover:bg-gray-200 px-4 py-1.5 rounded-md transition shadow-sm">Sign Up</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-400 hover:text-white focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" style="display: none;" 
             x-transition
             class="lg:hidden glass-nav absolute w-full left-0 top-full shadow-lg border-t border-white/10">
            <div class="px-4 py-4 space-y-3">
                <a href="#home" class="block text-sm font-medium text-gray-300 hover:text-white">Home</a>
                <a href="#about" class="block text-sm font-medium text-gray-300 hover:text-white">About</a>
                <a href="#courses" class="block text-sm font-medium text-gray-300 hover:text-white">Courses</a>
                <a href="#services" class="block text-sm font-medium text-gray-300 hover:text-white">Services</a>
                @auth
                    @if(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('admin'))
                        <a href="{{ route('teacher.dashboard') }}" class="block text-sm font-medium text-[#00C16A] hover:text-emerald-400">Teacher Portal</a>
                    @endif
                    @if(auth()->user()->hasRole('student'))
                        <a href="{{ route('student.dashboard') }}" class="block text-sm font-medium text-[#00C16A] hover:text-emerald-400">Student Portal</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-400 hover:text-white transition">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Sign In</a>
                    <a href="{{ route('register') }}" class="block text-sm font-medium text-[#00C16A]">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section -->
    <section id="home" class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden flex items-center min-h-[90vh]">
        <!-- Background elements -->
        <div class="absolute inset-0 z-0 flex items-center justify-center">
            <div class="grid-bg absolute inset-0"></div>
            <!-- Soft glow in center -->
            <div class="w-[600px] h-[600px] bg-[#00C16A] rounded-full mix-blend-screen filter blur-[200px] opacity-[0.07]"></div>
            <div class="w-[400px] h-[400px] bg-blue-600 rounded-full mix-blend-screen filter blur-[150px] opacity-[0.05] absolute top-10 right-20"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                
                <!-- Left Content -->
                <div class="w-full lg:w-1/2" data-aos="fade-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full minimal-card text-[#00C16A] text-[11px] font-semibold tracking-wide uppercase mb-6 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#00C16A] animate-pulse"></span>
                        AI-Powered Career Guidance
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-[1.1] mb-6 text-white">
                        Unlocking Potential, <br>
                        Creating <span class="text-gradient-green">Future.</span>
                    </h1>
                    
                    <p class="text-gray-400 text-base lg:text-lg mb-8 max-w-lg leading-relaxed font-light">
                        Discover your perfect career path with our intelligent learning platform. We use AI to identify strengths, offer remedial support, and guide you to top universities globally.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="#contact" class="bg-white text-black hover:bg-gray-100 px-5 py-2.5 rounded-md text-sm font-medium transition shadow-sm">
                            Book Free Counseling
                        </a>
                        <a href="#courses" class="minimal-card text-white hover:text-[#00C16A] px-5 py-2.5 rounded-md text-sm font-medium transition">
                            Explore Courses
                        </a>
                    </div>
                </div>

                <!-- Right Content (Image & Floating UI) -->
                <div class="w-full lg:w-1/2 relative hidden md:block" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative z-10 rounded-2xl overflow-hidden minimal-card p-2 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800" alt="Student" class="w-full h-auto rounded-xl object-cover opacity-90 transition duration-700 hover:opacity-100 grayscale-[20%] hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#09090b] via-transparent to-transparent opacity-60"></div>
                    </div>

                    <!-- Floating Card -->
                    <div class="absolute -left-6 bottom-8 minimal-card px-4 py-3 rounded-lg z-20 shadow-xl flex items-center gap-3" style="animation: float 4s ease-in-out infinite;">
                        <div class="w-8 h-8 rounded-full bg-[#00C16A]/10 flex items-center justify-center text-[#00C16A]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[13px] font-semibold text-white leading-tight">AI Engine Active</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">Personalized Paths</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Features/Statistics Section -->
    <section class="relative z-20 pb-16 px-4" data-aos="fade-up">
        <div class="max-w-5xl mx-auto">
            <div class="minimal-card rounded-2xl p-6 lg:p-8 flex flex-wrap justify-between items-center gap-6 divide-x divide-white/5">
                
                <div class="flex-1 text-center min-w-[120px]">
                    <div class="text-2xl lg:text-3xl font-bold text-white tracking-tight">12.5K+</div>
                    <div class="text-xs text-gray-500 font-medium uppercase tracking-wider mt-1">Students</div>
                </div>
                
                <div class="flex-1 text-center min-w-[120px]">
                    <div class="text-2xl lg:text-3xl font-bold text-white tracking-tight">25+</div>
                    <div class="text-xs text-gray-500 font-medium uppercase tracking-wider mt-1">Courses</div>
                </div>

                <div class="flex-1 text-center min-w-[120px]">
                    <div class="text-2xl lg:text-3xl font-bold text-white tracking-tight">20+</div>
                    <div class="text-xs text-gray-500 font-medium uppercase tracking-wider mt-1">Nations</div>
                </div>

                <div class="flex-1 text-center min-w-[120px]">
                    <div class="text-2xl lg:text-3xl font-bold text-white tracking-tight">100+</div>
                    <div class="text-xs text-gray-500 font-medium uppercase tracking-wider mt-1">Universities</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Services Section -->
    <section id="services" class="py-20 border-t border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-12" data-aos="fade-up">
                <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-white mb-3">How We Help You <span class="text-[#00C16A]">Succeed</span></h2>
                <p class="text-gray-400 text-sm md:text-base font-light leading-relaxed">Our comprehensive ecosystem supports students at every stage, using advanced analytics to personalize learning strategies.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Service 1 -->
                <div class="minimal-card p-6 rounded-xl group transition-all duration-300" data-aos="fade-up" data-aos-delay="50">
                    <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 text-gray-300 flex items-center justify-center mb-4 group-hover:text-[#00C16A] group-hover:bg-[#00C16A]/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="text-base font-medium text-white mb-2">Career Counselling</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed font-light">Get expert advice tailored to your strengths and market trends. Map your optimal career trajectory.</p>
                    <a href="#" class="text-[#00C16A] text-xs font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Read More <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
                </div>

                <!-- Service 2 -->
                <div class="minimal-card p-6 rounded-xl group transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 text-gray-300 flex items-center justify-center mb-4 group-hover:text-[#00C16A] group-hover:bg-[#00C16A]/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-base font-medium text-white mb-2">Course Selection</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed font-light">Our AI analyzes your aptitude to recommend courses that maximize your chances of success.</p>
                    <a href="#" class="text-[#00C16A] text-xs font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Read More <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
                </div>

                <!-- Service 3 -->
                <div class="minimal-card p-6 rounded-xl group transition-all duration-300" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 text-gray-300 flex items-center justify-center mb-4 group-hover:text-[#00C16A] group-hover:bg-[#00C16A]/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-base font-medium text-white mb-2">Eligibility Check</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed font-light">Instantly verify your eligibility for top tier global universities without the guesswork.</p>
                    <a href="#" class="text-[#00C16A] text-xs font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Read More <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
                </div>

                <!-- Service 4 -->
                <div class="minimal-card p-6 rounded-xl group transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 text-gray-300 flex items-center justify-center mb-4 group-hover:text-[#00C16A] group-hover:bg-[#00C16A]/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-base font-medium text-white mb-2">Study Abroad</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed font-light">End-to-end guidance for studying overseas, from applications to visa assistance.</p>
                    <a href="#" class="text-[#00C16A] text-xs font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Read More <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. About Section -->
    <section id="about" class="py-20 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image -->
                <div class="relative" data-aos="fade-right">
                    <div class="minimal-card p-2 rounded-2xl relative z-10">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800" class="rounded-xl w-full h-64 object-cover grayscale-[30%] opacity-90 hover:grayscale-0 hover:opacity-100 transition duration-500">
                    </div>
                    <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-[#00C16A]/10 rounded-full blur-[80px]"></div>
                </div>

                <!-- Content -->
                <div data-aos="fade-left">
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-white mb-4">Empowering Students Through Data & AI</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-light">
                        Smart Education is a next-generation EdTech platform designed to eliminate the "one-size-fits-all" approach to learning. We identify gaps early and provide personalized pathways.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex gap-3">
                            <div class="mt-0.5"><svg class="w-4 h-4 text-[#00C16A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <div>
                                <h4 class="text-sm font-medium text-white">Our Mission</h4>
                                <p class="text-gray-500 text-xs mt-1 font-light">Identify learning gaps early and provide personalized remedial pathways for every student globally.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="mt-0.5"><svg class="w-4 h-4 text-[#00C16A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <div>
                                <h4 class="text-sm font-medium text-white">Our Vision</h4>
                                <p class="text-gray-500 text-xs mt-1 font-light">A world where no student is left behind due to a lack of insights, guidance, or support.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#courses" class="text-sm font-medium text-white border border-white/20 hover:bg-white hover:text-black px-5 py-2 rounded-md transition shadow-sm inline-block">
                        Discover More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Courses Section -->
    <section id="courses" class="py-20 border-t border-white/5 bg-[#09090b]/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-end mb-10 gap-4" data-aos="fade-up">
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-white mb-2">Top Programs</h2>
                    <p class="text-gray-400 text-sm font-light">Curated pathways designed to enhance your skillset.</p>
                </div>
                <a href="{{ route('register') }}" class="text-xs font-medium text-gray-300 hover:text-white transition">View all programs →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Course 1 -->
                <div class="minimal-card rounded-xl overflow-hidden group flex flex-col" data-aos="fade-up" data-aos-delay="50">
                    <div class="h-40 overflow-hidden relative border-b border-white/5">
                        <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 grayscale-[20%] group-hover:grayscale-0">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500 text-[11px] font-medium uppercase tracking-wider">Data Science</span>
                            <span class="text-gray-400 text-xs flex items-center gap-1"><svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> 4.9 (120)</span>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2">Advanced Machine Learning</h3>
                        <p class="text-gray-500 text-xs mb-4 flex-grow font-light">Master AI patterns and build predictive models from scratch.</p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-xs text-gray-400"><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>6 Months</span>
                            <a href="{{ route('register') }}" class="bg-[#00C16A] text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-emerald-500 transition">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="minimal-card rounded-xl overflow-hidden group flex flex-col" data-aos="fade-up" data-aos-delay="100">
                    <div class="h-40 overflow-hidden relative border-b border-white/5">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 grayscale-[20%] group-hover:grayscale-0">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500 text-[11px] font-medium uppercase tracking-wider">Engineering</span>
                            <span class="text-gray-400 text-xs flex items-center gap-1"><svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> 4.8 (85)</span>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2">Full-Stack Web Engineering</h3>
                        <p class="text-gray-500 text-xs mb-4 flex-grow font-light">Learn modern web architectures with React and Laravel.</p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-xs text-gray-400"><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>4 Months</span>
                            <a href="{{ route('register') }}" class="bg-[#00C16A] text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-emerald-500 transition">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="minimal-card rounded-xl overflow-hidden group flex flex-col" data-aos="fade-up" data-aos-delay="150">
                    <div class="h-40 overflow-hidden relative border-b border-white/5">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 grayscale-[20%] group-hover:grayscale-0">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500 text-[11px] font-medium uppercase tracking-wider">Business</span>
                            <span class="text-gray-400 text-xs flex items-center gap-1"><svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> 4.7 (200)</span>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2">Digital Strategy Mastery</h3>
                        <p class="text-gray-500 text-xs mb-4 flex-grow font-light">Lead digital transformation and marketing strategies.</p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-xs text-gray-400"><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>3 Months</span>
                            <a href="{{ route('register') }}" class="bg-[#00C16A] text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-emerald-500 transition">Enroll Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Testimonials Section -->
    <section id="testimonials" class="py-20 border-t border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-white mb-3">Student Success</h2>
                <p class="text-gray-400 text-sm font-light">Real stories from our global alumni network.</p>
            </div>

            <div class="swiper testimonial-swiper pb-12" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="minimal-card p-6 rounded-xl h-full flex flex-col">
                            <p class="text-gray-300 text-sm leading-relaxed mb-6 font-light italic">"The AI remedial suggestions completely changed my trajectory. I was struggling with Calculus, but the tailored assignments helped me ace my finals."</p>
                            <div class="mt-auto flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=32" class="w-10 h-10 rounded-full bg-gray-800">
                                <div>
                                    <h4 class="text-white text-sm font-medium">Sarah Jenkins</h4>
                                    <p class="text-[11px] text-gray-500">Data Science Cohort</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="minimal-card p-6 rounded-xl h-full flex flex-col">
                            <p class="text-gray-300 text-sm leading-relaxed mb-6 font-light italic">"The study abroad guidance was phenomenal. I got accepted into my dream university in Canada with a 50% scholarship, all thanks to the counseling team!"</p>
                            <div class="mt-auto flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=11" class="w-10 h-10 rounded-full bg-gray-800">
                                <div>
                                    <h4 class="text-white text-sm font-medium">David Chen</h4>
                                    <p class="text-[11px] text-gray-500">Study Abroad Prog.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="minimal-card p-6 rounded-xl h-full flex flex-col">
                            <p class="text-gray-300 text-sm leading-relaxed mb-6 font-light italic">"The teacher dashboard gave our instructors incredible insight into student performance. We've seen a 40% increase in class passing rates."</p>
                            <div class="mt-auto flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=5" class="w-10 h-10 rounded-full bg-gray-800">
                                <div>
                                    <h4 class="text-white text-sm font-medium">Elena Rodriguez</h4>
                                    <p class="text-[11px] text-gray-500">Web Dev Instructor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>

    <!-- 8. Footer -->
    <footer id="contact" class="border-t border-white/10 pt-16 pb-8 bg-[#09090b]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-5 h-5 rounded bg-[#00C16A] flex items-center justify-center font-bold text-white text-[10px]">S</div>
                        <span class="text-sm font-semibold tracking-tight">Smart<span class="text-[#00C16A]">Edu</span></span>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed mb-5 font-light">Empowering the next generation of leaders through personalized education and career guidance.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-500 hover:text-white transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="text-gray-500 hover:text-white transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4">Platform</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-xs text-gray-500 hover:text-white transition font-light">About Us</a></li>
                        <li><a href="#courses" class="text-xs text-gray-500 hover:text-white transition font-light">Courses</a></li>
                        <li><a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-white transition font-light">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="text-xs text-gray-500 hover:text-white transition font-light">Sign Up</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-xs text-gray-500 hover:text-white transition font-light">Privacy Policy</a></li>
                        <li><a href="#" class="text-xs text-gray-500 hover:text-white transition font-light">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4">Contact Us</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-xs text-gray-500 font-light leading-relaxed">Lovely Professional University,<br>GT Road, Punjab</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:varmavegesna093@gmail.com" class="text-xs text-gray-500 hover:text-white transition font-light">varmavegesna093@gmail.com</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-xs text-gray-500 font-light">8919209005</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/5 pt-6 text-center md:flex md:justify-between md:text-left">
                <p class="text-gray-600 text-[11px] font-light">© {{ date('Y') }} Smart Education System. All rights reserved.</p>
                <p class="text-gray-600 text-[11px] mt-2 md:mt-0 font-light">Engineered for excellence.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 600, once: true, offset: 50 });
            new Swiper('.testimonial-swiper', {
                slidesPerView: 1, spaceBetween: 20,
                pagination: { el: '.swiper-pagination', clickable: true },
                breakpoints: {
                    640: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                }
            });
        });
    </script>
</body>
</html>
