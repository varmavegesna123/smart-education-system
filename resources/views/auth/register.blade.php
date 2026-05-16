<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - Smart Education</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #071126; color: #fff; }
        .glass-card {
            background: rgba(11, 23, 48, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.2s;
        }
        .input-field:focus {
            border-color: #00C16A;
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(0, 193, 106, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #00C16A 0%, #059669 100%);
            transition: all 0.3s;
        }
        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(0, 193, 106, 0.4);
            transform: translateY(-1px);
        }
        /* Autofill override */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #0b1730 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#00C16A] selection:text-white min-h-screen flex overflow-x-hidden">

    <!-- Left Branding Section (Hidden on Mobile) -->
    <div class="hidden lg:flex w-1/2 relative overflow-hidden bg-[#050B14] flex-col justify-center p-16">
        <!-- Background Effects -->
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 20% 30%, rgba(0, 193, 106, 0.15) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);"></div>
        <div class="absolute inset-0 opacity-30" style="background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 40px 40px; mask-image: radial-gradient(circle at center, black 40%, transparent 80%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%);"></div>

        <div class="relative z-10 max-w-lg xl:max-w-xl">
            <a href="/" class="flex items-center gap-2 mb-10 cursor-pointer inline-flex">
                <div class="w-8 h-8 rounded-lg bg-[#00C16A] flex items-center justify-center font-bold text-white text-sm shadow-lg shadow-[#00C16A]/20">S</div>
                <span class="text-xl font-bold tracking-tight text-white">Smart<span class="text-[#00C16A]">Edu</span></span>
            </a>
            
            <h1 class="text-3xl xl:text-4xl font-bold mb-4 leading-snug text-white tracking-tight">Join the future of personalized education</h1>
            <p class="text-gray-400 text-sm xl:text-base mb-10 font-light leading-relaxed max-w-md">Create your free account today and discover pathways tailored to your unique strengths and goals.</p>

            <div class="space-y-5">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#00C16A]/10 text-[#00C16A] flex items-center justify-center border border-[#00C16A]/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-sm font-semibold">AI Performance Analytics</h4>
                        <p class="text-gray-500 text-xs">Real-time insights on your progress</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-500/10 text-blue-400 flex items-center justify-center border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-sm font-semibold">Tailored Curriculums</h4>
                        <p class="text-gray-500 text-xs">Learn at your own perfect pace</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-500/10 text-purple-400 flex items-center justify-center border border-purple-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-sm font-semibold">Global University Access</h4>
                        <p class="text-gray-500 text-xs">Direct pipelines to top institutions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Auth Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">
        <div class="w-full max-w-[420px] relative z-10 my-auto">
            <div class="text-center mb-8 pt-8 lg:pt-0">
                <a href="/" class="lg:hidden inline-flex items-center gap-2 mb-6">
                    <div class="w-7 h-7 rounded bg-[#00C16A] flex items-center justify-center font-bold text-white text-xs">S</div>
                    <span class="text-lg font-bold tracking-tight text-white">Smart<span class="text-[#00C16A]">Edu</span></span>
                </a>
                <h2 class="text-2xl sm:text-3xl font-semibold mb-2 text-white tracking-tight">Create an account</h2>
                <p class="text-sm text-gray-400 font-light">Enter your details below to get started</p>
            </div>

            <div class="glass-card rounded-2xl p-6 sm:p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-300 mb-1.5 ml-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                                class="input-field block w-full pl-10 pr-3 py-2.5 rounded-xl text-sm placeholder-gray-500 focus:ring-0" 
                                placeholder="Enter your name">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-300 mb-1.5 ml-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                                class="input-field block w-full pl-10 pr-3 py-2.5 rounded-xl text-sm placeholder-gray-500 focus:ring-0" 
                                placeholder="name@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <!-- Password Field -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-xs font-medium text-gray-300 mb-1.5 ml-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" 
                                class="input-field block w-full pl-10 pr-10 py-2.5 rounded-xl text-sm placeholder-gray-500 focus:ring-0" 
                                placeholder="Create a strong password">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-500 hover:text-gray-300 focus:outline-none">
                                <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" style="display: none;" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-xs font-medium text-gray-300 mb-1.5 ml-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" 
                                class="input-field block w-full pl-10 pr-10 py-2.5 rounded-xl text-sm placeholder-gray-500 focus:ring-0" 
                                placeholder="Confirm your password">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-500 hover:text-gray-300 focus:outline-none">
                                <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" style="display: none;" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full py-2.5 rounded-xl text-white font-medium text-sm shadow-lg flex justify-center items-center gap-2 mt-2">
                        Create Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500 font-light">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-white font-medium hover:text-[#00C16A] transition ml-1 border-b border-transparent hover:border-[#00C16A]">Sign In</a>
                    </p>
                </div>
            </div>
            
            <div class="mt-8 text-center text-[10px] text-gray-600 font-light pb-8">
                By signing up, you agree to our <a href="#" class="hover:text-gray-400 transition underline">Terms</a> and <a href="#" class="hover:text-gray-400 transition underline">Privacy Policy</a>
            </div>
        </div>
    </div>
</body>
</html>
