@extends('layouts.app')
@section('title','All Notes')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 sticky-top">
        <h4 class="fw-bold mb-0">📚 Notes</h4>
        <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
            ✍️ New Note
        </a>
    </div>

    <!-- Card List -->
    <div class="row g-3">

        @forelse($notes as $note)
        <div class="col-12">
            <div class="card shadow-sm border-0 note-card">
                <div class="card-body d-flex justify-content-between align-items-start">

                    <div class="w-100 pe-2">
                        <h6 class="fw-bold mb-1 text-truncate">
                            {{ $note->title ?? 'Untitled' }}
                        </h6>

                        <small class="text-muted">
                            {{ Str::limit(strip_tags($note->content), 60) }}
                        </small>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-primary btn-sm mb-1">
                            View
                        </a>

                        <form method="POST" action="{{ route('notes.destroy', $note) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Delete this note?')">
                                Del
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                📭 Belum ada catatan
            </div>
        </div>
        @endforelse

    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $notes->links() }}
    </div>
</div>
<footer class="text-center py-2 bg-white border-top shadow-sm fixed-bottom small">
        dibuat dengan ❤️ oleh <strong>Muhammad Luqni Baehaqi</strong>
</footer>
<style>
    body {
        background: #f8f9fa;
    }

    .note-card {
        border-left: 6px solid #0d6efd;
        background: linear-gradient(180deg, #fff, #fdfdfd);
    }
</style>
@endsection
