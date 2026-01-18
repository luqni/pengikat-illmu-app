@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="pt-8 px-4 pb-24">
    <!-- Header -->
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-1 text-center">Akun Saya</h1>
    <p class="text-slate-500 text-sm font-medium mb-8 text-center">Kelola profil dan sesi anda.</p>

    <!-- Profile Card -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-950 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden flex flex-col items-center text-center max-w-sm mx-auto text-white ring-1 ring-white/10">
        
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-emerald-500/20 to-transparent pointer-events-none"></div>

        <!-- Avatar -->
        <div class="relative w-28 h-28 rounded-full bg-slate-700/50 flex items-center justify-center text-white text-4xl font-bold mb-6 ring-4 ring-white/10 shadow-lg backdrop-blur-sm">
            {{ substr(auth()->user()->name ?? 'User', 0, 1) }}
            <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-slate-800 rounded-full"></div>
        </div>

        <!-- Name & Email -->
        <h2 class="text-2xl font-bold text-white mb-1">
            {{ auth()->user()->name ?? 'Guest User' }}
        </h2>
        <p class="text-slate-400 text-sm mb-8 font-medium">
            {{ auth()->user()->email ?? 'guest@example.com' }}
        </p>

        <!-- Divider -->
        <div class="w-full h-px bg-white/10 mb-8"></div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full py-4 rounded-xl bg-red-500/10 text-red-400 font-bold hover:bg-red-500/20 border border-red-500/20 transition-all flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-right-from-bracket group-hover:-translate-x-1 transition-transform"></i>
                Keluar Aplikasi
            </button>
        </form>
    </div>

    <!-- App Version -->
    <div class="mt-8 text-center opacity-40">
        <p class="text-xs font-medium text-slate-400 tracking-widest uppercase">
            Demi Pena v1.0
        </p>
    </div>
</div>
@endsection
