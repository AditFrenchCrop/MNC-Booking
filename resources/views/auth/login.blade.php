<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MNC Studios Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            border: none;
            border-top: 5px solid #198754; /* Garis hijau di atas card */
            border-radius: 10px;
        }
        .btn-success-custom {
            background: linear-gradient(135deg, #198754 0%, #0d5231 100%);
            border: none;
        }
        .btn-success-custom:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                
                <div class="text-center mb-4">
                    <div class="text-success display-4 mb-2">
                        <i class="fa-solid fa-guitar"></i>
                    </div>
                    <h3 class="fw-bold text-dark">MNC Studios Booking</h3>
                    <p class="text-muted small">Silakan masuk untuk mengelola dan membooking ruangan</p>
                </div>

                <div class="card shadow-sm login-card p-4">
                    
                    @if (session('status'))
                        <div class="alert alert-success mb-3 small" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3 small" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-muted small">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-muted small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                                <label for="remember_me" class="form-check-label text-muted small">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-success small text-decoration-none">Lupa Password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success btn-success-custom w-100 fw-bold text-white py-2 shadow-sm mb-3">
                            LOG IN <i class="fa-solid fa-right-to-bracket ms-1"></i>
                        </button>
                        
                        @if (Route::has('register'))
                            <div class="text-center">
                                <span class="text-muted small">Belum punya akun?</span>
                                <a href="{{ route('register') }}" class="text-success fw-bold small text-decoration-none ms-1">Daftar Sekarang</a>
                            </div>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>