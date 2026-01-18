<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ config('app.name', 'Demi Pena') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { padding-bottom: env(safe-area-inset-bottom); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full antialiased font-[Outfit] text-slate-800 dark:text-slate-100 relative selection:bg-emerald-200 selection:text-emerald-900 overflow-x-hidden bg-slate-50 dark:bg-slate-950">

    <!-- Top Header -->
    <header class="fixed top-0 left-0 right-0 z-40 glass border-b border-white/20 dark:border-slate-800/50 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
             <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                <i class="fa-solid fa-pen-nib text-sm"></i>
            </div>
            <span class="font-bold text-lg tracking-tight text-slate-800 dark:text-black">Demi Pena</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen pt-24 pb-32 px-4">
        @if(session('success'))
            <div id="flash-message" class="fixed top-4 left-4 right-4 z-[60] bg-white/90 backdrop-blur-md text-emerald-600 px-4 py-3 rounded-2xl shadow-lg border border-emerald-100 flex items-center justify-center gap-2 animate-bounce-in">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Floating Glass Bottom Nav -->
    <nav class="fixed bottom-6 left-6 right-6 z-50 glass rounded-full shadow-xl shadow-emerald-500/10 p-2 flex justify-between items-center max-w-lg mx-auto transition-transform duration-300">
        
        <!-- Home -->
        <a href="{{ route('notes.index') }}" class="flex-1 flex flex-col items-center justify-center p-2 rounded-full transition-all {{ request()->routeIs('notes.index') ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 hover:text-slate-600' }}">
            <i class="fa-solid fa-house text-xl mb-0.5"></i>
            <span class="text-[10px] font-bold">Home</span>
        </a>

        <!-- Add Button (Center Floating) -->
        <a href="{{ route('notes.create') }}" class="flex items-center justify-center w-14 h-14 -mt-8 bg-gradient-to-br from-emerald-400 to-teal-500 text-white rounded-full shadow-lg shadow-emerald-500/40 border-4 border-white/50 backdrop-blur transition-transform hover:scale-110 active:scale-95">
            <i class="fa-solid fa-plus text-2xl"></i>
        </a>

        <!-- User Management -->
        <a href="{{ route('profile.index') }}" class="flex-1 flex flex-col items-center justify-center p-2 rounded-full transition-all {{ request()->routeIs('profile.index') ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 hover:text-slate-600' }}">
             <i class="fa-solid fa-user text-xl mb-0.5"></i>
             <span class="text-[10px] font-bold">Akun</span>
        </a>
    </nav>

    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
        
        // Auto-dismiss Flash Messages
        document.addEventListener('DOMContentLoaded', () => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                setTimeout(() => {
                    flash.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-20px)';
                    setTimeout(() => flash.remove(), 500);
                }, 3000);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
