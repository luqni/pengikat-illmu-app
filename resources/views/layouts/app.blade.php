<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pengikat Ilmu</title>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Google Fonts: handwriting-like -->
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Reenie+Beanie&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { font-family: Inter, Arial, sans-serif; padding: 20px; }
.ql-editor { min-height: 300px; }
/* custom fonts mapping for Quill */
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="patrick"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="patrick"]::before { content: 'Patrick Hand'; }
.ql-font-patrick { font-family: 'Patrick Hand', cursive; }
.ql-font-reenie { font-family: 'Reenie Beanie', cursive; }
</style>
</head>
<body>
    <div class="container">
    <h1 class="text-center py-2 bg-white sticky-top">@yield('title', 'Notes')</h1>
    @if(session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    @yield('content')
    </div>


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
    @stack('scripts')
</body>
</html>