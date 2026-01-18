@extends('layouts.dashboard')

@php
    if (!isset($action)) {
        $action = isset($note) ? route('notes.update', $note) : route('notes.store');
    }
    if (!isset($method)) {
        $method = isset($note) ? 'PUT' : 'POST';
    }
@endphp

@section('title', isset($note) ? 'Edit Catatan' : 'Catatan Baru')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Fresh Youthful Overrides */
    nav.fixed.bottom-0, header { display: none !important; }
    main { padding-top: 0 !important; }

    /* Custom Scrollbar for tools */
    .hide-scroll::-webkit-scrollbar { display: none; }
    .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

    /* Glass Effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col pb-24 relative overflow-hidden">
    
    <!-- Top Bar (Floating Pill) -->
    <div class="fixed top-24 inset-x-4 z-30">
        <div class="max-w-[95%] mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl shadow-lg shadow-emerald-500/10 rounded-full px-4 py-2 flex items-center justify-between border border-emerald-100 dark:border-emerald-900/30">
            
            <a href="{{ route('notes.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-emerald-100 hover:text-emerald-600 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <div class="flex-1 overflow-x-auto hide-scroll mx-4 flex items-center gap-4 justify-center">
                 <!-- Modern Tools -->
                 <button type="button" class="ql-bold w-9 h-9 flex items-center justify-center rounded-xl hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 transition-all">
                    <i class="fa-solid fa-bold text-sm"></i>
                 </button>
                 <button type="button" class="ql-italic w-9 h-9 flex items-center justify-center rounded-xl hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 transition-all">
                    <i class="fa-solid fa-italic text-sm"></i>
                 </button>
                 <div class="w-px h-5 bg-slate-200 dark:bg-slate-700"></div>
                 <button type="button" class="ql-header w-9 h-9 flex items-center justify-center rounded-xl hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 transition-all font-bold text-xs" value="1">H1</button>
                 <button type="button" class="ql-list w-9 h-9 flex items-center justify-center rounded-xl hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 transition-all" value="bullet">
                    <i class="fa-solid fa-list-ul text-sm"></i>
                 </button>
                 <div class="w-px h-5 bg-slate-200 dark:bg-slate-700"></div>
                 
                 <!-- Special App Tools -->
                 <button id="btn-ocr" type="button" class="group relative px-3 py-1.5 rounded-3xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-500 text-xs font-bold hover:bg-indigo-100 transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-camera"></i> <span class="hidden sm:inline">OCR</span>
                 </button>
                 <button id="btn-quran" type="button" class="group relative px-3 py-1.5 rounded-3xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 text-xs font-bold hover:bg-emerald-100 transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-book-quran"></i> <span class="hidden sm:inline">Quran</span>
                 </button>
            </div>

            <!-- Save Circle -->
            <button onclick="submitForm()" class="w-10 h-10 flex items-center justify-center rounded-full bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/30 transition-transform active:scale-95">
                <i class="fa-solid fa-check"></i>
            </button>
        </div>
    </div>

    <!-- Main Editor Card -->
    <div class="flex-1 mt-32 w-full mx-auto">
        <form id="note-form" method="POST" action="{{ $action }}" enctype="multipart/form-data" class="glass-panel w-full min-h-screen rounded-t-[2.5rem] border-x-0 border-b-0 p-6 md:p-8 shadow-xl relative flex flex-col">
            @csrf
            @if (strtoupper($method) === 'PUT' || strtoupper($method) === 'PATCH') @method($method) @endif

            <!-- Bismillah Header -->
            <div class="w-full flex justify-center mb-8 opacity-60">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/Basmala.svg" class="h-8 dark:invert" alt="Bismillah">
            </div>

            <!-- Title -->
            <input type="text" 
                   name="title" 
                   class="w-full bg-transparent text-4xl md:text-6xl font-bold placeholder-slate-300 dark:placeholder-slate-600 border-none focus:ring-0 p-0 mb-8 text-slate-800 dark:text-slate-100 leading-tight text-center tracking-tight"
                   placeholder="Judul Catatan..."
                   value="{{ old('title', $note->title ?? '') }}">

            <!-- Editor -->
            <div id="editor" class="flex-1 ql-container ql-snow border-none text-xl text-slate-700 dark:text-slate-300 leading-loose font-medium font-sans">
                {!! old('content', $note->content ?? '') !!}
            </div>

            <input type="hidden" name="content" id="content-input">
            <input type="file" id="ocr-image" accept="image/*" capture="environment" hidden>

            <!-- Decorative Footer -->
            <div class="mt-12 flex items-center justify-center gap-2 text-xs text-slate-400 font-medium tracking-widest uppercase opacity-50">
                <span>•</span>
                <span>Demi Pena</span>
                <span>•</span>
            </div>
        </form>
    </div>

</div>

<!-- Modal Shortcuts (Styled) -->
<div class="modal fade" id="shortcutsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3xl border-0 overflow-hidden">
      <div class="bg-emerald-500 p-6 text-white text-center">
        <h5 class="font-bold text-xl mb-1">Shortcut Islami ✨</h5>
        <p class="text-emerald-100 text-sm">Ketik kode ini di editor</p>
      </div>
      <div class="p-6 bg-white dark:bg-slate-900 grid gap-3">
         <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-2xl">
             <span class="font-mono font-bold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-lg text-sm">(quran:1:1)</span>
             <span class="text-sm font-medium text-slate-600">Al-Fatihah Ayat 1</span>
         </div>
      </div>
    </div>
  </div>
</div>
<!-- Suggestion Modal -->
<div id="suggestionModal" class="fixed inset-0 z-[70] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeSuggestionModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl p-6 border border-red-100 dark:border-red-900/30 animate-bounce-in">
        <div class="text-center mb-4">
             <div class="w-12 h-12 rounded-full bg-red-100 text-red-500 mx-auto flex items-center justify-center mb-3">
                 <i class="fa-solid fa-circle-question text-xl"></i>
             </div>
             <h3 class="font-bold text-lg text-slate-800 dark:text-white">Surat Tidak Ditemukan</h3>
             <p class="text-xs text-slate-500 mt-1">Mungkin maksud anda:</p>
        </div>
        <div id="suggestion-list" class="space-y-2">
            <!-- Buttons injected here -->
        </div>
        <button onclick="closeSuggestionModal()" class="w-full mt-4 py-2 text-sm font-bold text-slate-400 hover:text-slate-600">Batal</button>
    </div>
</div>

@endsection

@push('scripts')
<script>
  // Same logic but cleaner config
  var Font = Quill.import('formats/font');
  Font.whitelist = ['outfit', 'sans-serif']; 
  Quill.register(Font, true);

  var quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis sesuatu yang bermanfaat...',
    modules: { toolbar: '.fixed' } // Bind to our custom fixed toolbar
  });

  // Re-attach listeners (Logic remains same as previous steps)
  document.getElementById('content-input').value = quill.root.innerHTML;
  document.getElementById('note-form').onsubmit = () => {
       document.getElementById('content-input').value = quill.root.innerHTML;
  };

  // OCR
  document.getElementById('btn-ocr').onclick=()=>document.getElementById('ocr-image').click();
  document.getElementById('ocr-image').onchange=(e)=>{
      const f=e.target.files[0]; if(!f)return;
      const fd=new FormData(); fd.append('image',f); fd.append('_token',Laravel.csrfToken);
      fetch('{{ route('notes.ocr') }}',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
          if(d.text) quill.insertText(quill.getSelection(true)?.index||0, d.text+"\n");
      });
  };

  async function insQ(s,st,en,tag){
      try{
          const r=await fetch(`https://api.alquran.cloud/v1/ayah/${s}:${st}-${en}/editions/quran-uthmani,id.indonesian`);
          const d=await r.json();
          if(d.data){
             let a='',i='';
             (Array.isArray(d.data[0])?d.data[0]:[d.data[0]]).forEach(x=>a+=x.text+' ۝ ');
             (Array.isArray(d.data[1])?d.data[1]:[d.data[1]]).forEach(x=>i+=x.text+' ');
             const h=`<div class="p-6 my-6 rounded-3xl bg-emerald-50/50 border border-emerald-100 flex flex-col gap-3 relative overflow-hidden"><div class="absolute -right-4 -top-4 text-9xl text-emerald-100 opacity-20"><i class="fa-solid fa-quran"></i></div><p class="text-right font-outfit text-2xl leading-loose text-slate-800" style="direction: rtl; font-family:serif;">${a}</p><p class="text-sm font-medium text-emerald-700 italic">${i}</p><div class="flex items-center gap-2 mt-2"><span class="bg-emerald-200 text-emerald-800 text-[10px] font-bold px-2 py-1 rounded-full">QS ${s}:${st}-${en}</span></div></div><p><br></p>`;
             rep(tag,h);
          }
      }catch(e){}
  }

  async function insH(b,n,tag){
       try{
           const r=await fetch(`https://api.hadith.gading.dev/books/${b}/${n}`);
           const d=await r.json();
           if(d.data?.contents){
               const h=`<div class="p-6 my-6 rounded-3xl bg-amber-50/50 border border-amber-100 flex flex-col gap-3 relative"><p class="text-right text-2xl leading-loose" style="direction: rtl; font-family:serif;">${d.data.contents.arab}</p><p class="text-sm font-medium text-amber-800 italic">${d.data.contents.id}</p><div class="inline-block bg-amber-200 text-amber-900 text-[10px] font-bold px-2 py-1 rounded-full w-fit">HR ${b} ${n}</div></div><p><br></p>`;
               rep(tag,h);
           }
       }catch(e){}
  }

  function rep(t,h){
      const i=quill.getText().indexOf(t);
      if(i!==-1){quill.deleteText(i,t.length,"silent");quill.clipboard.dangerouslyPasteHTML(i,h,"silent");}
  }

  // Bind Buttons
  // document.getElementById('btn-quran').onclick=()=>quill.insertText(quill.getSelection(true)?.index||0, '(quran:1:1)', 'user'); // Old logic
  document.getElementById('btn-quran').onclick = () => openQuranModal();

  // Quran Modal Logic
  const modal = document.getElementById('quranModal');
  const surahSearch = document.getElementById('surah-search');
  const surahList = document.getElementById('surah-list');
  let surahs = [];

  // Fetch Surahs immediately for auto-complete
  (async () => {
      try {
          const r = await fetch('https://api.alquran.cloud/v1/surah');
          const d = await r.json();
          surahs = d.data;
      } catch(e) { console.error("Failed to load surahs", e); }
  })();

  window.openQuranModal = async () => {
      modal.classList.remove('hidden');
      if(surahs.length > 0) renderSurahList(surahs);
      surahSearch.focus();
  };

  window.closeQuranModal = () => modal.classList.add('hidden');

  function renderSurahList(list) {
      surahList.innerHTML = list.map(s => `
          <div onclick="selectSurah(${s.number}, '${s.englishName.replace(/'/g, "")}')" 
               class="px-4 py-2 hover:bg-emerald-50 dark:hover:bg-slate-700 cursor-pointer flex justify-between items-center transition-colors">
              <span class="font-medium text-slate-700 dark:text-slate-200">${s.number}. ${s.englishName}</span>
              <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-100 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">${s.numberOfAyahs} Ayat</span>
          </div>
      `).join('');
  }

  window.selectSurah = (num, name) => {
      document.getElementById('selected-surah-no').value = num;
      surahSearch.value = `${num}. ${name}`;
      surahList.classList.add('hidden');
      document.getElementById('ayah-start').focus();
  };

  if(surahSearch) {
      surahSearch.oninput = (e) => {
          const v = e.target.value.toLowerCase();
          const filtered = surahs.filter(s => 
              s.englishName.toLowerCase().includes(v) || 
              s.number.toString().includes(v)
          );
          renderSurahList(filtered);
          surahList.classList.remove('hidden');
      };
      
      // Close list on clicking outside
      document.addEventListener('click', (e) => {
          if(!surahSearch.contains(e.target) && !surahList.contains(e.target)) {
              surahList.classList.add('hidden');
          }
      });
  }

  // Levenshtein Distance Helper
  function levenshtein(a, b) {
      if(a.length === 0) return b.length; 
      if(b.length === 0) return a.length;
      const matrix = [];
      for(let i=0; i<=b.length; i++){ matrix[i] = [i]; }
      for(let j=0; j<=a.length; j++){ matrix[0][j] = j; }
      for(let i=1; i<=b.length; i++){
          for(let j=1; j<=a.length; j++){
              if(b.charAt(i-1) == a.charAt(j-1)){
                  matrix[i][j] = matrix[i-1][j-1];
              } else {
                  matrix[i][j] = Math.min(matrix[i-1][j-1] + 1, Math.min(matrix[i][j-1] + 1, matrix[i-1][j] + 1));
              }
          }
      }
      return matrix[b.length][a.length];
  }

  window.suggestSurah = (input, originalString, match) => {
      // Find top 3
      const scored = surahs.map(s => {
          const sName = s.englishName.toLowerCase().replace(/[^a-z0-9]/g, '').replace(/^al/, '');
          const dist = levenshtein(input, sName);
          return { s, dist };
      }).sort((a,b) => a.dist - b.dist).slice(0, 3);
      
      // If matches are reasonable (distance < 4 usually good for short words, adjusted for length)
      if(scored[0].dist < input.length + 2) {
           const suggestionList = document.getElementById('suggestion-list');
           suggestionList.innerHTML = scored.map(x => `
               <button onclick="applySuggestion('${x.s.number}', '${match[2]}', '${match[3]||''}', '${originalString.replace(/'/g,"\\'")}')"
                       class="w-full text-left px-4 py-3 rounded-xl bg-slate-50 hover:bg-emerald-50 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors flex justify-between items-center group">
                   <span class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-emerald-700">${x.s.englishName}</span>
                   <span class="text-xs text-slate-400">QS. ${x.s.number}</span>
               </button>
           `).join('');
           document.getElementById('suggestionModal').classList.remove('hidden');
      }
  };
  
  window.closeSuggestionModal = () => document.getElementById('suggestionModal').classList.add('hidden');
  
  window.applySuggestion = async (num, start, end, originalString) => {
      closeSuggestionModal();
      // Replace text logic
      // We need to find the specific range of the original string to replace
      // Ideally, the 'originalString' is the full match string like (quran:typo:1)
      // Wait, INS_Q handles replacement if we pass the TAG (originalString)
      
      let code = `(quran:${num}:${start}`;
      if(end && end > start) code += `-${end}`;
      code += ')';
      
      // Replace the invalid shortcode with the CORRECT implicit one (or just run insertion)
      // Actually best UX: Just run the insertion immediately!
      // But we need to remove the typo shortcode first.
      
      const t = quill.getText();
      const idx = t.indexOf(originalString);
      if(idx !== -1) {
          // Delete typo
          quill.deleteText(idx, originalString.length, "silent");
          // Insert actual Content (not just shortcode)
          await insQ(num, start, end || start, code); // Using code as tag is creating circle? No, insQ uses tag to replace. 
          // Wait, insQ expects 'tag' to be in the document to replace it.
          // Since we deleted it, insQ loop might fail.
          // Let's Insert the CORRECT shortcode, effectively "Typing it for them"
          // And then let the listener pick it up? No, listener checks on change.
          
          // Better: Replace typo with correct shortcode, then trigger `insQ` manually?
          // Simplest: `insQ` takes 'tag' to find and replace.
          // If we paste the Quran block at `idx`, that's fine.
          
          // Let's modify insQ to accept an INDEX or a TAG.
          // But for now, let's just use `quill.insertText` to put the CORRECTED shortcode
          // and then manually call `insQ` logic?
          // Or just:
          quill.insertText(idx, code, 'user');
          // This will trigger the listener again! And since correct, it will resolve.
      }
  };

  window.insertQuranShortcode = () => {
      const num = document.getElementById('selected-surah-no').value;
      const start = document.getElementById('ayah-start').value;
      const end = document.getElementById('ayah-end').value;

      if(!num) { alert('Pilih surat terlebih dahulu!'); return; }
      
      let code = `(quran:${num}:${start}`;
      if(end && end > start) code += `-${end}`;
      code += ')';

      quill.insertText(quill.getSelection(true)?.index || quill.getLength() - 1, code, 'user');
      closeQuranModal();
      
      // Reset
      surahSearch.value = '';
      document.getElementById('selected-surah-no').value = '';
      document.getElementById('ayah-start').value = '1';
      document.getElementById('ayah-end').value = '';
  };

  // Smart Surah Resolver
  function getSurahNumber(i) {
      if (!isNaN(i)) return i;
      
      // Normalize input: remove spaces, dashes, 'al', lowercase
      const clean = i.toLowerCase().replace(/[^a-z0-9]/g, '').replace(/^al/, '');
      
      // Check full list
      const found = surahs.find(s => {
          const sName = s.englishName.toLowerCase().replace(/[^a-z0-9]/g, '').replace(/^al/, '');
          // Double check fuzzy match (e.g. kahfi vs kahf)
          return sName === clean || sName.includes(clean) || clean.includes(sName);
      });

      return found ? found.number : null;
  }

  // Magic Listener with Wait
  let isP = false;
  quill.on("text-change", async(d,o,s) => {
      if(s !== 'user' || isP) return;
      
      const t = quill.getText();
      const qM = t.match(/\(quran:([a-zA-Z0-9-\s]+):(\d+)(?:-(\d+))?\)/i);
      
      if(qM) {
          isP = true;
          const surahNum = getSurahNumber(qM[1].trim());
          if(surahNum) {
              await insQ(surahNum, qM[2], qM[3]||qM[2], qM[0]);
          } else {
              // Typo! Suggest it.
              suggestSurah(qM[1].trim().toLowerCase().replace(/[^a-z0-9]/g, '').replace(/^al/, ''), qM[0], qM);
          }
          isP = false; 
          return;
      }

      const hM = t.match(/\((muslim|bukhari):(\d+)\)/i);
      if(hM){ isP=true; await insH(hM[1], hM[2], hM[0]); isP=false; }
  });

  async function insQ(s,st,en,tag){
      try{
          const r=await fetch(`https://api.alquran.cloud/v1/ayah/${s}:${st}-${en}/editions/quran-uthmani,id.indonesian`);
          const d=await r.json();
          if(d.data){
             let a='',i='';
             (Array.isArray(d.data[0])?d.data[0]:[d.data[0]]).forEach(x=>a+=x.text+' ۝ ');
             (Array.isArray(d.data[1])?d.data[1]:[d.data[1]]).forEach(x=>i+=x.text+' ');
             const h=`<div class="p-6 my-6 rounded-3xl bg-emerald-50/50 border border-emerald-100 flex flex-col gap-3 relative overflow-hidden"><div class="absolute -right-4 -top-4 text-9xl text-emerald-100 opacity-20"><i class="fa-solid fa-quran"></i></div><p class="text-right font-outfit text-2xl leading-loose text-slate-800" style="direction: rtl; font-family:serif;">${a}</p><p class="text-sm font-medium text-emerald-700 italic">${i}</p><div class="flex items-center gap-2 mt-2"><span class="bg-emerald-200 text-emerald-800 text-[10px] font-bold px-2 py-1 rounded-full">QS ${s}:${st}-${en}</span></div></div><p><br></p>`;
             rep(tag,h);
          }
      }catch(e){ console.error(e); }
  }

  async function insH(b,n,tag){
       try{
           const r=await fetch(`https://api.hadith.gading.dev/books/${b}/${n}`);
           const d=await r.json();
           if(d.data?.contents){
               const h=`<div class="p-6 my-6 rounded-3xl bg-amber-50/50 border border-amber-100 flex flex-col gap-3 relative"><p class="text-right text-2xl leading-loose" style="direction: rtl; font-family:serif;">${d.data.contents.arab}</p><p class="text-sm font-medium text-amber-800 italic">${d.data.contents.id}</p><div class="inline-block bg-amber-200 text-amber-900 text-[10px] font-bold px-2 py-1 rounded-full w-fit">HR ${b} ${n}</div></div><p><br></p>`;
               rep(tag,h);
           }
       }catch(e){ console.error(e); }
  }

  function rep(t,h){
      const i=quill.getText().indexOf(t);
      if(i!==-1){quill.deleteText(i,t.length,"silent");quill.clipboard.dangerouslyPasteHTML(i,h,"silent");}
  }

  // Manual Submit Function to ensure Quill data is synced
  window.submitForm = () => {
      document.getElementById('content-input').value = quill.root.innerHTML;
      document.getElementById('note-form').submit();
  };
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .ql-container { font-family: 'Outfit', sans-serif; font-size: 1.15rem; border: none !important; }
    .ql-container.ql-snow { border: none !important; }
    .ql-editor { padding: 0 !important; }
    .ql-editor.ql-blank::before { color: #cbd5e1; font-style: normal; font-weight: 300; }
</style>
@endpush
