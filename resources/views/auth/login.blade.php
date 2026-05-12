<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LaundryRIAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .login-card .logo {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem; color: #fff;
        }
        .form-control:focus { border-color: #3949ab; box-shadow: 0 0 0 .2rem rgba(57,73,171,.2); }
        .btn-login {
            background: linear-gradient(135deg, #1a237e, #3949ab);
            border: none; color: #fff; padding: .75rem;
            border-radius: 10px; font-weight: 600;
            transition: opacity .2s;
        }
        .btn-login:hover { opacity: .9; color: #fff; }
        .input-group-text { background: #f8f9fa; border-right: none; }
        .form-control { border-left: none; }
        .form-control:focus { border-left: none; }
        .cek-status-link {
            display: block; text-align: center; margin-top: 1rem;
            color: #3949ab; text-decoration: none; font-size: .9rem;
        }
        .cek-status-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="logo"><i class="bi bi-basket2-fill"></i></div>
    <h4 class="text-center fw-bold mb-1">Laundry RIAN</h4>
    <p class="text-center text-muted mb-4" style="font-size:.85rem">Sistem Manajemen Laundry Multi-Cabang</p>

    @if($errors->any())
        <div class="alert alert-danger py-2 px-3" style="font-size:.88rem">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                       placeholder="Masukkan username" value="{{ old('username') }}" autofocus required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label text-muted" for="remember" style="font-size:.88rem">Ingat saya</label>
        </div>
        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
    </form>

    <a href="{{ route('cek-status') }}" class="cek-status-link">
        <i class="bi bi-search me-1"></i>Cek Status Laundry (tanpa login)
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>