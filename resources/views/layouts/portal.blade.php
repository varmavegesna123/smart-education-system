<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartEdu') }} - @yield('title', 'Portal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #09090b; /* zinc-950 equivalent */
            color: #ededed; 
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Premium Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #3f3f46; }

        /* Premium Components */
        .glass-panel {
            background: rgba(24, 24, 27, 0.6); /* zinc-900 */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .premium-card {
            background: #121214;
            border: 1px solid rgba(255, 255, 255, 0.04);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.02);
            transition: all 0.2s ease-in-out;
        }
        .premium-card:hover {
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.04);
        }

        .text-gradient-emerald {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Nav Link Active State */
        .nav-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #fafafa;
        }
        .nav-link.active {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 20%;
            height: 60%;
            width: 3px;
            background: #10b981;
            border-radius: 0 4px 4px 0;
        }

        /* Shimmer Loading */
        .shimmer {
            background: #18181b;
            background-image: linear-gradient(to right, #18181b 0%, #27272a 20%, #18181b 40%, #18181b 100%);
            background-repeat: no-repeat;
            background-size: 800px 100%; 
            animation-duration: 1.5s;
            animation-fill-mode: forwards; 
            animation-iteration-count: infinite;
            animation-name: placeholderShimmer;
            animation-timing-function: linear;
        }

        @keyframes placeholderShimmer {
            0% { background-position: -468px 0; }
            100% { background-position: 468px 0; }
        }
    </style>
</head>
<body class="selection:bg-emerald-500/30 selection:text-emerald-200 flex h-screen overflow-hidden text-sm">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#09090b] border-r border-white/5 hidden md:flex flex-col flex-shrink-0 relative z-20">
        <div class="h-14 flex items-center px-5 border-b border-white/5">
            <div class="flex items-center gap-2.5 cursor-pointer group" onclick="window.location.href='/'">
                <div class="w-6 h-6 rounded bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center font-bold text-white text-[11px] shadow-sm shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">S</div>
                <span class="text-sm font-semibold tracking-tight text-white">Smart<span class="text-emerald-500">Edu</span></span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">
            <div class="px-3 mb-2">
                <p class="text-[10px] font-medium tracking-wider text-zinc-500 uppercase">Menu</p>
            </div>
            @yield('sidebar_links')
        </nav>

        <div class="p-3 border-t border-white/5">
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer group">
                <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-medium text-zinc-300 group-hover:text-white border border-white/5">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-200 truncate group-hover:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-zinc-500 truncate capitalize">{{ auth()->user()->roles->first()->name ?? 'User' }}</p>
                </div>
                <svg class="w-4 h-4 text-zinc-600 group-hover:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-zinc-500 hover:text-zinc-300 hover:bg-white/5 rounded-md transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 bg-[#09090b] relative">
        <!-- Top Header -->
        <header class="h-14 glass-panel border-b border-white/5 flex items-center justify-between px-4 sm:px-6 z-30 sticky top-0">
            <div class="flex items-center gap-4 flex-1">
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-zinc-400 hover:text-white" x-data @click="$dispatch('open-mobile-menu')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-sm font-semibold text-zinc-100 tracking-tight hidden sm:block">@yield('header_title', 'Dashboard')</h1>
                
                <!-- Global Search -->
                <div class="ml-0 sm:ml-6 flex-1 max-w-md relative group hidden sm:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-zinc-500 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search students, subjects, or tasks..." class="block w-full pl-9 pr-3 py-1.5 border border-white/5 rounded-md leading-5 bg-zinc-900/50 text-zinc-300 placeholder-zinc-600 focus:outline-none focus:bg-zinc-900 focus:ring-1 focus:ring-emerald-500/50 focus:border-emerald-500/50 sm:text-xs transition-all duration-200">
                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                        <span class="text-[10px] text-zinc-600 font-medium px-1.5 py-0.5 border border-white/5 rounded bg-zinc-800/50">⌘K</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- AI Assistant Button -->
                <button class="hidden sm:flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium text-emerald-400 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Ask AI
                </button>

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative p-1.5 text-zinc-400 hover:text-white transition-colors rounded-md hover:bg-white/5 border border-transparent hover:border-white/5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-80 bg-zinc-900 rounded-lg shadow-2xl border border-white/10 overflow-hidden z-50 origin-top-right" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                        <div class="px-4 py-2.5 border-b border-white/5 flex justify-between items-center bg-zinc-900/80">
                            <h3 class="text-xs font-semibold text-zinc-200 tracking-tight">Notifications</h3>
                            <button class="text-[10px] text-emerald-500 hover:text-emerald-400 font-medium">Mark all read</button>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <!-- Dummy Notification 1 -->
                            <div class="px-4 py-3 hover:bg-zinc-800/50 cursor-pointer border-b border-white/5 transition-colors group">
                                <div class="flex items-start gap-3">
                                    <div class="w-7 h-7 rounded bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5 border border-emerald-500/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-zinc-300 font-medium group-hover:text-white transition-colors">Assignment Graded</p>
                                        <p class="text-[11px] text-zinc-500 mt-0.5 leading-relaxed">You scored 95/100 on Calculus Project.</p>
                                        <p class="text-[10px] text-zinc-600 mt-1">2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Dummy Notification 2 -->
                            <div class="px-4 py-3 hover:bg-zinc-800/50 cursor-pointer border-b border-white/5 transition-colors group">
                                <div class="flex items-start gap-3">
                                    <div class="w-7 h-7 rounded bg-blue-500/10 text-blue-500 flex items-center justify-center flex-shrink-0 mt-0.5 border border-blue-500/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-zinc-300 font-medium group-hover:text-white transition-colors">New AI Insight</p>
                                        <p class="text-[11px] text-zinc-500 mt-0.5 leading-relaxed">We noticed a pattern in your Physics attendance.</p>
                                        <p class="text-[10px] text-zinc-600 mt-1">Yesterday</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-2.5 text-center text-[11px] text-zinc-500 hover:text-zinc-300 cursor-pointer transition-colors bg-zinc-900/50">
                                View all notifications
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">
            <div class="relative z-10 max-w-6xl mx-auto space-y-6">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Mobile Drawer (Alpine) -->
    <div x-data="{ open: false }" @open-mobile-menu.window="open = true" class="relative z-50 md:hidden">
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false" style="display: none;"></div>
        
        <div x-show="open" 
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-64 bg-zinc-950 border-r border-white/5 flex flex-col" style="display: none;">
            
            <div class="h-14 flex items-center justify-between px-5 border-b border-white/5">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-emerald-500 flex items-center justify-center font-bold text-white text-xs">S</div>
                    <span class="text-sm font-semibold tracking-tight text-white">SmartEdu</span>
                </div>
                <button @click="open = false" class="text-zinc-500 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @yield('sidebar_links')
            </nav>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
