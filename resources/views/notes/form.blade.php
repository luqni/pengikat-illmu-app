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
<div id="ql-loading">Loading...</div>
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

          <button id="btn-hadith" type="button" class="btn btn-sm btn-outline-warning ms-1">
              <i class="fa-solid fa-book-open-reader"></i>
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

<!-- MODAL PILIH HADIS -->
<div class="modal fade" id="modalHadith" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">📚 Pilih Hadis — Bukhari & Muslim</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <label class="form-label">Pilih Kitab Hadis</label>
        <select id="hadith-collection" class="form-select mb-3">
            <option value="bukhari">Shahih Bukhari</option>
            <option value="muslim">Shahih Muslim</option>
        </select>

        <label class="form-label">Nomor Hadis</label>
        <input id="hadith-number" class="form-control" type="number"
               placeholder="Masukkan nomor hadis…">

        <small class="text-muted d-block mt-2">
            Contoh: Bukhari 1–7000, Muslim 1–3000 (bergantung dataset)
        </small>

        <div id="hadith-preview" class="mt-3 p-2 border rounded bg-light small d-none">
            <strong>Preview:</strong>
            <div id="hadith-text" class="mt-1"></div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button id="insert-hadith" class="btn btn-warning">Insert ke Catatan</button>
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

  // OPEN MODAL
document.getElementById('btn-hadith').addEventListener('click', function() {
    new bootstrap.Modal(document.getElementById('modalHadith')).show();
});

// LOAD & PREVIEW HADIS
document.getElementById('hadith-number').addEventListener('change', async function() {
    const collection = document.getElementById('hadith-collection').value;
    const number = this.value;

    if (!number) return;

    const url = `https://api.hadith.gading.dev/books/${collection}/${number}`;

    document.getElementById('hadith-preview').classList.add('d-none');

    try {
        const res = await fetch(url);
        const data = await res.json();

        if (data.data) {
            document.getElementById('hadith-text').innerHTML =
                `<strong>${data.data.name} No. ${number}</strong><br>${data.data.contents.arab}<br><em>${data.data.contents.id}</em>`;

            document.getElementById('hadith-preview').classList.remove('d-none');
        }
    } catch (e) {
        alert("Hadis tidak ditemukan!");
    }
});

// INSERT KE QUILL
document.getElementById('insert-hadith').addEventListener('click', function() {
    const preview = document.getElementById('hadith-text').innerHTML;

    if (!preview.trim()) {
        alert("Tidak ada hadis untuk dimasukkan.");
        return;
    }

    const range = quill.getSelection(true);
    
    quill.insertText(range.index, "\n");
    quill.clipboard.dangerouslyPasteHTML(range.index, preview + "<br><br>");
    

    bootstrap.Modal.getInstance(document.getElementById('modalHadith')).hide();
});

document.addEventListener("DOMContentLoaded", function () {
    const loadingBox = document.getElementById("ql-loading");

    function showLoading() {
        loadingBox.style.display = "inline-block";
    }

    function hideLoading() {
        loadingBox.style.display = "none";
    }

    quill.on('text-change', async function(delta, oldDelta, source) {
        if (source !== 'user') return;

        let text = quill.getText().trim();

        // ==========================
        // PATTERN QURAN: (quran:2:255) atau (quran:2:1-5)
        // ==========================
        const regexQuran = /\(quran:(\d{1,3}):(\d{1,3})(?:-(\d{1,3}))?\)/i;
        let qMatch = text.match(regexQuran);

        // ==========================
        // PATTERN HADIS: (muslim:12) atau (bukhari:55)
        // ==========================
        const regexHadith = /\((muslim|bukhari):(\d{1,4})\)/i;
        let hMatch = text.match(regexHadith);

        // ==========================
        // PROSES QURAN
        // ==========================
        if (qMatch) {
            const fullTag = qMatch[0];
            const surah = qMatch[1];
            const start = qMatch[2];
            const end = qMatch[3] || start;

            showLoading();
            try {
                const res = await fetch(
                    `https://api.alquran.cloud/v1/ayah/${surah}:${start}-${end}/editions/quran-uthmani,id.indonesian`
                );

                const data = await res.json();

                if (data.data && data.data.length >= 2) {
                    const arab = data.data[0].text;
                    const indo = data.data[1].text;

                    const output = `
                        <div class="quran-block">
                            <div class="quran-arabic" style="font-size:22px; text-align:right;">${arab}</div>
                            <div class="quran-translation" style="font-size:14px; color:#444;">${indo}</div>
                            <div class="quran-ref" style="font-size:12px; color:#777;">(QS. ${surah}:${start})</div>
                        </div>
                    `;

                    const index = text.indexOf(fullTag);
                    quill.deleteText(index, fullTag.length);
                    quill.clipboard.dangerouslyPasteHTML(index, output + "<br>");
                }

            } catch (e) {
                console.error("Quran API Failed", e);
            }

            hideLoading();
        }

        // ==========================
        // PROSES HADIS
        // ==========================
        if (hMatch) {
            const fullTag = hMatch[0];
            const kitab = hMatch[1];
            const number = hMatch[2];

            showLoading();
            try {
                const res = await fetch(
                    `https://api.hadith.gading.dev/books/${kitab}/${number}`
                );

                const data = await res.json();

                if (data.data?.contents) {
                    const arab = data.data.contents.arab;
                    const indo = data.data.contents.id;

                    const output = `
                        <div class="hadith-block">
                            <div class="hadith-arabic" style="font-size:20px; text-align:right;">${arab}</div>
                            <div class="hadith-translation" style="font-size:14px; color:#444;">${indo}</div>
                            <div class="hadith-source" style="font-size:12px; color:#777;">(HR. ${kitab.toUpperCase()} No. ${number})</div>
                        </div>
                    `;

                    const index = text.indexOf(fullTag);
                    quill.deleteText(index, fullTag.length);
                    quill.clipboard.dangerouslyPasteHTML(index, output + "<br>");
                }

            } catch (e) {
                console.error("Hadith API Failed", e);
            }

            hideLoading();
        }
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

.quran-block {
    padding: 10px 12px;
    background: #f9f9ff;
    border-left: 4px solid #4c6ef5;
    border-radius: 6px;
    margin-bottom: 12px;
}

.quran-arabic {
    font-family: 'Scheherazade New', serif;
    font-size: 22px;
    line-height: 1.8;
    direction: rtl;
    text-align: right;
    color: #222;
}

.quran-translation {
    margin-top: 6px;
    font-size: 14px;
    color: #555;
}
#ql-loading {
    display: none;
    position: absolute;
    top: 5px;
    right: 15px;
    background: #fff;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 99;
}
</style>
@endpush

