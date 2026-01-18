<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Notes App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            height: 100vh;
        }
        .login-card {
            max-width: 420px;
            border-radius: 16px;
        }
        .google-btn {
            border-radius: 50px;
            font-weight: 500;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="card login-card shadow-lg p-4">
    <div class="text-center mb-3">
        <h3 class="fw-bold">📓 Notes App</h3>
        <p class="text-muted small">
            Catat ide, ringkasan, ayat Al-Qur'an & hadis<br>
            dengan OCR tulisan tangan
        </p>
    </div>

    <a href="{{ route('google.login') }}" class="btn btn-danger google-btn w-100 py-2">
        <i class="fa-brands fa-google me-2"></i>
        Login dengan Google
    </a>

    <div class="text-center mt-4 text-muted small">
        Dengan login, catatan tersimpan aman di akun Anda
    </div>
</div>

</body>
</html>
