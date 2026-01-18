@extends('layouts.dashboard')

@section('title', $note->title ?? 'Untitled Note')

@section('content')
<div class="pb-24 pt-4">

    <!-- Floating Top Bar -->
    <div class="fixed top-24 inset-x-4 z-30 pointer-events-none">
        <div class="max-w-[95%] mx-auto flex justify-between items-center pointer-events-auto">
            <!-- Back Button -->
            <a href="{{ route('notes.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/80 dark:bg-slate-900/80 backdrop-blur text-slate-600 dark:text-slate-300 shadow-sm hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-white/50">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <!-- Edit Button -->
            <a href="{{ route('notes.edit', $note) }}" class="group flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 hover:bg-emerald-600 hover:scale-105 active:scale-95 transition-all">
                <span class="text-xs font-bold uppercase tracking-wide">Edit</span>
                <i class="fa-solid fa-pen-nib"></i>
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="max-w-4xl mx-auto mt-12 px-4">
        <article class="bg-emerald-50/50 dark:bg-slate-900/50 backdrop-blur-md border border-emerald-100 dark:border-slate-800 rounded-[2rem] p-6 md:p-10 shadow-sm relative overflow-hidden min-h-[70vh] flex flex-col">
            
            <!-- Bismillah Header -->
            <div class="w-full flex justify-center mb-8 opacity-40">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/Basmala.svg" class="h-6 dark:invert" alt="Bismillah">
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-bold text-emerald-950 dark:text-white mb-6 text-center leading-tight tracking-tight">
                {{ $note->title ?? 'Untitled Note' }}
            </h1>

            <div class="w-24 h-1 bg-emerald-200 dark:bg-emerald-900/30 mx-auto mb-8 rounded-full"></div>

            <!-- Content -->
            <div class="prose prose-lg prose-slate dark:prose-invert max-w-none font-[Outfit] leading-loose text-slate-900 dark:text-slate-100 note-content">
                {!! $note->content !!}
            </div>

            <!-- Footer Meta -->
            <div class="mt-auto pt-12 border-t border-emerald-100/50 dark:border-slate-800 flex items-center justify-center text-xs font-bold text-emerald-900/40 dark:text-slate-400 gap-4 uppercase tracking-widest">
                <span>{{ $note->created_at->format('d M Y') }}</span>
                <span>•</span>
                <span>{{ $note->created_at->format('H:i') }}</span>
            </div>
        </article>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Clean overrides for typography */
    .note-content h1, .note-content h2, .note-content h3 { font-family: 'Outfit', sans-serif; margin-top: 2em; margin-bottom: 0.5em; font-weight: 700; color: #1e293b; }
    .dark .note-content h1, .dark .note-content h2, .dark .note-content h3 { color: #f8fafc; }
    
    .note-content blockquote { 
        border-left: 4px solid #10b981; 
        background: rgba(16, 185, 129, 0.05); 
        padding: 1rem 1.5rem; 
        border-radius: 0.5rem;
        font-style: italic;
        color: #475569;
        margin: 1.5rem 0;
    }
    .dark .note-content blockquote { color: #94a3b8; }
    
    .note-content ul { list-style-type: disc; padding-left: 1.5rem; }
    .note-content ol { list-style-type: decimal; padding-left: 1.5rem; }
    
    .note-content img { border-radius: 1rem; margin: 1.5rem 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
</style>
@endpush
