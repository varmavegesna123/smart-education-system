<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard - Smart Education</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #061224; color: #F8FAFC; }
        .glass-panel { background: rgba(11, 23, 48, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .glass-card:hover { border-color: rgba(255, 255, 255, 0.15); }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover, .nav-link.active { background: rgba(0, 208, 132, 0.1); color: #00D084; border-left: 3px solid #00D084; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="antialiased min-h-screen selection:bg-[#00D084] selection:text-white overflow-hidden" 
      x-data="{ 
          sidebarOpen: false, 
          aiModalOpen: false, 
          toast: { show: false, message: '' }, 
          showToast(msg) { 
              this.toast.message = msg; 
              this.toast.show = true; 
              setTimeout(() => this.toast.show = false, 3000); 
          },
          aiChat: {
              input: '',
              isTyping: false,
              messages: [
                  { role: 'ai', text: 'Hello! I am your AI Teaching Assistant. How can I help you manage your classroom today?' }
              ],
              sendMessage(text = null) {
                  const msg = text || this.input;
                  if (!msg.trim()) return;
                  this.messages.push({ role: 'user', text: msg });
                  this.input = '';
                  this.isTyping = true;
                  setTimeout(() => {
                      this.isTyping = false;
                      this.messages.push({ role: 'ai', text: 'Analyzing class data... This is a simulated response for demonstration purposes.' });
                  }, 1500);
              }
          }
      }">
    
    <div class="flex h-screen overflow-hidden bg-[#061224]">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 glass-panel flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 lg:flex-shrink-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-6 border-b border-white/5">
                <div class="flex items-center gap-3 w-full">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#00D084] to-[#00a86b] flex items-center justify-center font-bold text-white shadow-lg shadow-[#00D084]/20">S</div>
                    <span class="text-xl font-bold tracking-tight text-white">Smart<span class="text-[#00D084]">Edu</span></span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="space-y-1 px-3">
                    <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Overview</p>
                    <a href="{{ route('teacher.dashboard') }}" class="nav-link active flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300 group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="#" @click.prevent="showToast('Loading Class Roster...')" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300 group border-l-3 border-transparent">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Class Roster
                    </a>
                    
                    <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Classroom Management</p>
                    <a href="#" @click.prevent="showToast('Opening Assignments Module...')" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300 group border-l-3 border-transparent">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Assignments
                    </a>
                    <a href="#" @click.prevent="showToast('Loading Attendance Logs...')" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300 group border-l-3 border-transparent">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Attendance
                    </a>
                    <a href="#" @click.prevent="showToast('AI Risk Reports Generated')" class="nav-link flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300 group border-l-3 border-transparent">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            AI Risk Reports
                        </div>
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout Area -->
            <div class="p-4 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 w-full rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 transition border-l-3 border-transparent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- Floating Background Glows -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-[#00D084]/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

            <!-- Top Navbar -->
            <header class="glass-panel h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="text-slate-400 hover:text-white lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="hidden sm:flex items-center relative">
                        <svg class="w-4 h-4 text-slate-500 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search students, insights..." class="bg-slate-900/50 border border-white/5 rounded-full pl-9 pr-4 py-1.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-[#00D084] focus:ring-1 focus:ring-[#00D084] w-64 transition shadow-inner">
                        <div class="absolute right-3 flex gap-1">
                            <kbd class="hidden lg:inline-block text-[10px] text-slate-500 font-mono bg-white/5 px-1.5 rounded border border-white/10">⌘</kbd>
                            <kbd class="hidden lg:inline-block text-[10px] text-slate-500 font-mono bg-white/5 px-1.5 rounded border border-white/10">K</kbd>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- AI Assistant CTA -->
                    <button @click="aiModalOpen = true" class="hidden md:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500/20 to-indigo-500/20 border border-purple-500/30 rounded-full text-xs font-medium text-purple-300 hover:text-white hover:border-purple-400 hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Ask AI Assistant
                    </button>

                    <!-- Notifications -->
                    <button @click="showToast('No new notifications')" class="text-slate-400 hover:text-white relative transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-[#061224]"></span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-4 border-l border-white/10 cursor-pointer" @click="showToast('Profile settings coming soon')">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-slate-200 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-purple-400 mt-1 font-semibold tracking-wider uppercase">Teacher</p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white/10">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 z-10 scroll-smooth">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
                
                <footer class="mt-12 py-6 border-t border-white/5 text-center text-xs text-slate-500 font-light w-full">
                    &copy; {{ date('Y') }} Smart Education System. Engineered for excellence.
                </footer>
            </main>

        </div>
    </div>

    <!-- AI Mentor Modal -->
    <div x-show="aiModalOpen" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div x-show="aiModalOpen" x-transition.opacity class="fixed inset-0 bg-[#061224]/80 backdrop-blur-md transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="aiModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     @click.away="aiModalOpen = false"
                     class="relative transform overflow-hidden rounded-2xl glass-card text-left shadow-[0_0_40px_rgba(168,85,247,0.15)] transition-all sm:my-8 sm:w-full sm:max-w-lg border border-purple-500/30 bg-[#0B1730]/95 flex flex-col max-h-[85vh]">
                    
                    <div class="absolute top-0 right-0 pt-4 pr-4 z-20">
                        <button type="button" @click="aiModalOpen = false" class="rounded-md bg-white/5 text-slate-400 hover:text-white hover:bg-white/10 transition">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 pb-4 sm:p-6 sm:pb-4 border-b border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-purple-500/20 border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                                <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-6 text-slate-100 tracking-tight" id="modal-title">AI Teaching Assistant</h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#00D084] animate-pulse"></span>
                                    <span class="text-xs text-slate-400 font-medium tracking-wide">Online & Ready</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-900/50" id="chat-container">
                        <template x-for="(msg, index) in aiChat.messages" :key="index">
                            <div :class="msg.role === 'ai' ? 'flex justify-start' : 'flex justify-end'">
                                <div :class="msg.role === 'ai' ? 'bg-slate-800/80 text-slate-300 rounded-tr-xl' : 'bg-purple-600/20 border border-purple-500/30 text-purple-100 rounded-tl-xl'" 
                                     class="rounded-b-xl py-2 px-3.5 max-w-[85%] text-sm font-light leading-relaxed shadow-sm">
                                    <span x-text="msg.text"></span>
                                </div>
                            </div>
                        </template>

                        <!-- Typing Indicator -->
                        <div x-show="aiChat.isTyping" class="flex justify-start">
                            <div class="bg-slate-800/80 rounded-xl rounded-tl-none py-3 px-4 shadow-sm flex gap-1 items-center h-9">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.15s;"></span>
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.3s;"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Prompts (Teacher specific) -->
                    <div class="px-6 py-3 border-t border-white/5 bg-slate-900/80 overflow-x-auto whitespace-nowrap scrollbar-hide">
                        <div class="flex gap-2">
                            <button @click="aiChat.sendMessage('Show me weak students this week')" class="text-[10px] px-3 py-1.5 bg-white/5 hover:bg-white/10 text-slate-300 rounded-full border border-white/5 transition tracking-wide">Show weak students</button>
                            <button @click="aiChat.sendMessage('Generate class performance report')" class="text-[10px] px-3 py-1.5 bg-white/5 hover:bg-white/10 text-slate-300 rounded-full border border-white/5 transition tracking-wide">Generate class report</button>
                            <button @click="aiChat.sendMessage('Recommend remedial topics')" class="text-[10px] px-3 py-1.5 bg-white/5 hover:bg-white/10 text-slate-300 rounded-full border border-white/5 transition tracking-wide">Recommend topics</button>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="bg-[#0B1730] px-4 py-4 sm:px-6 border-t border-white/5 rounded-b-2xl">
                        <form @submit.prevent="aiChat.sendMessage()" class="relative flex items-center">
                            <input x-model="aiChat.input" type="text" placeholder="Message AI Assistant..." class="w-full bg-[#061224] border border-white/10 rounded-xl pl-4 pr-12 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition shadow-inner font-light">
                            <button type="submit" :disabled="!aiChat.input.trim() || aiChat.isTyping" class="absolute right-2 p-1.5 rounded-lg text-purple-400 hover:text-white hover:bg-purple-500/20 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed bottom-5 right-5 z-50 flex items-center gap-3 px-4 py-3 bg-[#0B1730] border border-white/10 rounded-xl shadow-2xl">
        <div class="w-6 h-6 rounded-full bg-[#00D084]/20 flex items-center justify-center text-[#00D084]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <p class="text-sm font-medium text-white" x-text="toast.message"></p>
    </div>

</body>
</html>
