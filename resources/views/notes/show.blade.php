@extends('layouts.app')

@section('title', $note->title ?? 'View Note')

@section('content')
<div class="container py-3">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm rounded-circle shadow-sm">
            ⬅
        </a>
        <h6 class="mb-0 text-muted">Detail Catatan</h6>
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary btn-sm shadow-sm">
            ✏️ Edit
        </a>
    </div>

    <!-- Card Note -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <h4 class="fw-bold mb-3 text-dark">
                {{ $note->title ?? 'Untitled' }}
            </h4>

            <div class="note-content">
                {!! $note->content !!}
            </div>

        </div>
    </div>

</div>

<!-- Footer -->
<footer class="text-center py-2 bg-white border-top shadow-sm fixed-bottom small">
    dibuat dengan ❤️ oleh <strong>Muhammad Luqni Baehaqi</strong>
</footer>

@endsection

@push('styles')
<style>
.note-content {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
}

/* Styling seperti buku catatan */
.note-content p {
    margin-bottom: 8px;
}

.note-content h1,
.note-content h2,
.note-content h3 {
    font-weight: bold;
    margin-top: 16px;
}

.card {
    background: linear-gradient(180deg, #ffffff, #f9fafb);
}

/* Mobile Optimization */
@media (max-width: 576px) {
    .note-content {
        font-size: 15px;
    }
}
</style>
@endpush
