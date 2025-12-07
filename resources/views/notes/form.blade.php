@extends('layouts.app')

@php
    if (!isset($action)) {
        $action = isset($note) ? route('notes.update', $note) : route('notes.store');
    }
    if (!isset($method)) {
        $method = isset($note) ? 'PUT' : 'POST';
    }
@endphp

@section('content')
<div class="container-fluid p-0">

  <!-- CARD BUKU CATATAN -->
  <div class="card shadow-sm notebook rounded-0 border-0">
    <div class="card-header text-center fw-bold">
      {{ isset($note) ? 'Edit Catatan' : 'Tulis Catatan Baru' }}
    </div>

    <div class="card-body" style="padding-right: 0rem !important;
  padding-left: 0rem !important;">

      <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if (strtoupper($method) === 'PUT' || strtoupper($method) === 'PATCH')
          @method($method)
        @endif

        <!-- JUDUL -->
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" 
                 name="title" 
                 class="form-control"
                 placeholder="Judul catatan..."
                 value="{{ old('title', $note->title ?? '') }}">
        </div>
        <!-- TOOLBAR -->
        <div id="toolbar" class="mb-2 p-2 rounded small-toolbar toolbar-dark shadow-sm">
          <select class="ql-font">
            <option selected></option>
            <option value="patrick">Patrick Hand</option>
            <option value="reenie">Reenie Beanie</option>
          </select>

          <button class="ql-bold"></button>
          <button class="ql-italic"></button>
          <button class="ql-underline"></button>
          <select class="ql-color"></select>

          <button id="btn-ocr" type="button" class="btn btn-sm btn-outline-light ms-1">
            📷
          </button>

          <input type="file" 
                id="ocr-image" 
                accept="image/*" 
                capture="environment" 
                hidden>

          <button id="btn-quran" type="button" class="btn btn-sm btn-outline-success ms-1">
            <i class="fa-solid fa-book-quran me-1"></i>
          </button>
        </div>


        <!-- EDITOR -->
        <div class="notebook-paper">
          <div id="editor">
            {!! old('content', $note->content ?? '') !!}
          </div>
        </div>

        <input type="hidden" name="content" id="content-input">

        <!-- BUTTON -->
        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-primary">
            💾 Simpan Catatan
          </button>

          <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary mt-2">
            ⬅ Kembali
          </a>
        </div>

      </form>
    </div>
  </div>

</div>
<hr>
<footer class="text-center py-2 bg-white border-top shadow-sm fixed-bottom small">
        dibuat dengan ❤️ oleh <strong>Muhammad Luqni Baehaqi</strong>
</footer>
<!-- ✅ MODAL INSERT AYAT -->
<div class="modal fade" id="quranModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Insert Ayat Al-Qur'an</h6>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="mb-2">
          <label class="form-label">Surah (1–114)</label>
          <input type="number" id="surah" class="form-control" min="1" max="114" value="1">
        </div>

        <div class="mb-2">
          <label class="form-label">Ayat</label>
          <input type="number" id="ayat" class="form-control" min="1" value="1">
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-success btn-sm" id="fetch-ayat">
          Ambil Ayat
        </button>
      </div>
    </div>
  </div>
</div>

@endsection


@push('scripts')
<script>
  var Font = Quill.import('formats/font');
  Font.whitelist = ['patrick','reenie','serif','sans-serif','monospace'];
  Quill.register(Font, true);

  var quill = new Quill('#editor', {
    modules: { toolbar: '#toolbar' },
    theme: 'snow'
  });

  var style = document.createElement('style');
  style.innerHTML =
    ".ql-font-patrick { font-family: 'Patrick Hand', cursive; }\\n" +
    ".ql-font-reenie { font-family: 'Reenie Beanie', cursive; }\\n";
  document.head.appendChild(style);

  document.querySelector('form').addEventListener('submit', function(){
    document.getElementById('content-input').value = quill.root.innerHTML;
  });

  document.getElementById('btn-ocr').addEventListener('click', function(){
    document.getElementById('ocr-image').click();
  });

  document.getElementById('ocr-image').addEventListener('change', function(e){
    var file = e.target.files[0];
    if(!file) return;

    var form = new FormData();
    form.append('image', file);
    form.append('_token', Laravel.csrfToken);

    fetch('{{ route('notes.ocr') }}', {
      method: 'POST',
      body: form
    })
    .then(r => r.json())
    .then(data => {
      if(data.text){
        var range = quill.getSelection(true);
        quill.insertText(range.index, data.text + "\\n");
      }else{
        alert(data.error ?? 'OCR gagal');
      }
    });
  });

  // ✅ Tombol buka modal
  document.getElementById('btn-quran').addEventListener('click', function(){
    var modal = new bootstrap.Modal(document.getElementById('quranModal'));
    modal.show();
  });

  // ✅ Ambil ayat dari API Al-Qur'an
  document.getElementById('fetch-ayat').addEventListener('click', function(){
    let surah = document.getElementById('surah').value;
    let ayat = document.getElementById('ayat').value;

    this.innerText = '⏳';

    fetch(`https://api.alquran.cloud/v1/ayah/${surah}:${ayat}/editions/quran-uthmani,id.indonesian`)
      .then(r => r.json())
      .then(res => {
        this.innerText = 'Ambil Ayat';

        let arab = res.data[0].text;
        let indo = res.data[1].text;

        let text = `\n${arab}\n${indo}\n(QS. ${surah}:${ayat})\n\n`;

        var range = quill.getSelection(true);
        quill.insertText(range.index, text);

        bootstrap.Modal.getInstance(document.getElementById('quranModal')).hide();
      })
      .catch(() => {
        this.innerText = 'Ambil Ayat';
        alert('Gagal mengambil ayat');
      });
  });

</script>
@endpush


@push('styles')
<style>
/* ✅ TEMA BUKU CATATAN – FULL WIDTH */
.notebook {
  border-radius: 0;
  min-height: 100vh;
}

.notebook-paper {
  background: repeating-linear-gradient(
    white,
    white 28px,
    #cce 29px
  );
  border-left: 4px solid #ff6b6b;
  padding: 10px 12px;
  border-radius: 0;
  min-height: 70vh;
}

/* ✅ Editor benar-benar full kiri kanan */
#editor {
  min-height: 65vh;
  font-size: 16px;
  padding: 0 !important;
  margin: 0 !important;
}

/* ✅ Toolbar tetap rapih */
.small-toolbar button,
.small-toolbar select {
  margin-bottom: 4px;
}

/* ✅ Mobile lebih nyaman */
@media (max-width: 576px) {
  #editor {
    min-height: 60vh;
    font-size: 15px;
  }

  .notebook-paper {
    padding: 8px;
  }
}

/* ✅ TOOLBAR GELAP */
.toolbar-dark {
  background: linear-gradient(135deg, #2c2c2c, #1f1f1f);
  border: 1px solid #444;
}

.toolbar-dark .ql-picker,
.toolbar-dark button {
  color: #fff;
  filter: brightness(1.1);
}

.toolbar-dark button:hover {
  background: rgba(255, 255, 255, 0.1);
}

.toolbar-dark .btn-outline-light {
  border-color: #ddd;
  color: #fff;
}

.toolbar-dark .btn-outline-success {
  border-color: #28a745;
  color: #28a745;
}

/* Icon Qur'an lebih hidup */
#btn-quran {
  font-weight: bold;
}
</style>
@endpush

