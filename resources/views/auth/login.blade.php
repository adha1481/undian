<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Aplikasi Undian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
        }

        .login-right {
            padding: 60px 40px;
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
        }

        .admin-info {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
        }

        .admin-info h6 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .admin-info .admin-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-check {
            margin: 20px 0;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        @media (max-width: 768px) {
            .login-left {
                padding: 40px 20px;
            }

            .login-right {
                padding: 40px 20px;
            }

            .login-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="row g-0">
            <!-- Left Panel - Info -->
            <div class="col-lg-5 login-left">
                <div class="h-100 d-flex flex-column justify-content-center">
                    <div class="mb-4">
                        <i class="fas fa-trophy fa-3x mb-3"></i>
                        <h2 class="login-title">Admin Panel</h2>
                        <p class="login-subtitle">Sistem Undian Hadiah</p>
                    </div>

                    <div class="admin-info">
                        <h6><i class="fas fa-users-cog me-2"></i>Login Admin</h6>
                        <div class="admin-item">
                            <span><i class="fas fa-crown me-2"></i>Super Admin</span>
                            <small>Akses Penuh</small>
                        </div>
                        <div class="admin-item">
                            <span><i class="fas fa-dice me-2"></i>Admin Undian</span>
                            <small>Kelola Undian</small>
                        </div>
                        <div class="admin-item">
                            <span><i class="fas fa-user-friends me-2"></i>Admin Peserta</span>
                            <small>Kelola Peserta</small>
                        </div>
                        <div class="admin-item">
                            <span><i class="fas fa-gift me-2"></i>Admin Hadiah</span>
                            <small>Kelola Hadiah</small>
                        </div>
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.3);">
                        <div class="text-center">
                            <small><i class="fas fa-eye me-2"></i>Halaman pemenang bisa diakses tanpa login</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="col-lg-7 login-right">
                <div class="h-100 d-flex flex-column justify-content-center">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Selamat Datang!</h3>
                        <p class="text-muted">Silakan login untuk mengakses panel admin</p>
                    </div>

                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="name@example.com"
                                   value="{{ old('email') }}" required>
                            <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <hr>
                        <p class="text-muted mb-0">
                            <i class="fas fa-eye me-2"></i>
                            <a href="{{ route('lottery.winners') }}" class="text-decoration-none">
                                Lihat Daftar Pemenang (Tanpa Login)
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
