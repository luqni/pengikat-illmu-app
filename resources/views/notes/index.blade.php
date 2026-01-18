@extends('layouts.dashboard')
@section('title', 'Catatan Saya')

@section('content')
    <!-- Top Section (Greeting & Search) -->
    <div class="pb-6">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">Catatan Saya</h1>
        <p class="text-slate-500 text-sm font-medium mb-6">Simpan ilmumu, ikat maknanya.</p>

        <!-- Search Bar (Glass) -->
        <form action="{{ route('notes.index') }}" method="GET" class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-emerald-500/50 group-focus-within:text-emerald-500 transition-colors"></i>
            </div>
            <input type="text" 
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari catatan..." 
                   class="w-full bg-white/70 dark:bg-slate-800/50 backdrop-blur-sm border-0 rounded-2xl py-3 pl-10 pr-4 shadow-sm text-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/50 focus:bg-white transition-all">
        </form>
    </div>

    <!-- Dynamic Content Container -->
    <div id="notes-container">
        <!-- Empty State -->
        @if($notes->isEmpty())
            <div class="flex flex-col items-center justify-center min-h-[50vh] text-center p-6">
                <!-- ... (Empty state content remains same, just ensuring it's inside container) ... -->
                <div class="w-32 h-32 bg-emerald-100/50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-6 animate-pulse-slow">
                    <i class="fa-solid fa-feather-pointed text-4xl text-emerald-500/50"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Belum ada catatan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-xs mx-auto leading-relaxed">
                    @if(request('search'))
                        Tidak ditemukan catatan dengan kata kunci "{{ request('search') }}"
                    @else
                        "Ikatlah ilmu dengan tulisan". <br> Mulai perjalanan ilmumu hari ini.
                    @endif
                </p>
                <a href="{{ route('notes.create') }}" class="px-6 py-3 rounded-full bg-emerald-500 text-white font-semibold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-1 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Buat Catatan Baru
                </a>
            </div>
        @else
            <!-- Notes Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-4 pb-24">
                @foreach($notes as $note)
                    <a href="{{ route('notes.show', $note) }}" class="group relative flex flex-col bg-white/60 dark:bg-slate-900/60 backdrop-blur-md rounded-[2rem] p-6 border border-white/50 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300">
                        
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 line-clamp-1 group-hover:text-emerald-600 transition-colors">
                            {{ $note->title ?? 'Untitled Note' }}
                        </h3>
                        
                        <!-- Snippet -->
                        <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-6 font-medium">
                            {{ Str::limit(strip_tags($note->content), 100) }}
                        </p>
                        
                        <!-- Footer -->
                        <div class="mt-auto flex items-center justify-between border-t border-slate-100/50 dark:border-slate-800 pt-4">
                            <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 bg-slate-100/50 px-2 py-1 rounded-lg">
                                {{ $note->created_at->format('d M Y') }}
                            </span>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                 <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Hapus catatan ini?');" class="relative z-10">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="event.stopImmediatePropagation()" class="w-8 h-8 rounded-full hover:bg-red-50 text-slate-300 hover:text-red-500 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-24 px-4">
                 {{ $notes->links() }}
            </div>
        @endif
    </div>

@push('scripts')
<script>
    let timeout = null;
    const input = document.querySelector('input[name="search"]');
    
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value;
        
        timeout = setTimeout(() => {
            fetch(`{{ route('notes.index') }}?search=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.getElementById('notes-container');
                if (newContainer) {
                    document.getElementById('notes-container').innerHTML = newContainer.innerHTML;
                    
                    // Update URL without reload
                    const url = new URL(window.location);
                    if(query) url.searchParams.set('search', query);
                    else url.searchParams.delete('search');
                    window.history.pushState({}, '', url);
                }
            });
        }, 300); // 300ms debounce
    });
</script>
@endpush
@endsection
