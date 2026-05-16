<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Smart Education</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #071126; color: #fff; }
        .glass-nav { background: rgba(11, 23, 48, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px); }
    </style>
</head>
<body class="antialiased selection:bg-[#00C16A] selection:text-white min-h-screen flex flex-col">
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-[#00C16A] flex items-center justify-center font-bold text-white text-sm">S</div>
                    <span class="text-lg font-bold tracking-tight text-white">Smart<span class="text-[#00C16A]">Edu</span></span>
                    <span class="ml-4 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 uppercase tracking-wider">Admin Portal</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">Admin</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-gray-400 hover:text-white transition">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @if (isset($header))
        <header class="bg-[#050b14] border-b border-white/5 shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="flex-grow max-w-7xl mx-auto w-full py-8 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <footer class="py-6 border-t border-white/5 text-center text-xs text-gray-500 font-light mt-auto">
        &copy; {{ date('Y') }} Smart Education System. Engineered for excellence.
    </footer>
</body>
</html>
