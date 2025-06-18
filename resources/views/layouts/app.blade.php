<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panen Hadiah Simpedes - BRI')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bri-blue: #003d7a;
            --bri-light-blue: #0056b3;
            --bri-orange: #ff8c00;
            --bri-gold: #ffd700;
            --sky-blue: #87ceeb;
            --cloud-white: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--sky-blue) 0%, #4a90e2 50%, var(--bri-blue) 100%);
            min-height: 100vh;
            position: relative;
        }

        /* Background elements seperti parasut */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.3)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.2)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.4)"/></svg>');
            background-size: 200px 200px;
            animation: float 20s linear infinite;
            pointer-events: none;
            z-index: -1;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-20px); }
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(0, 61, 122, 0.2);
            border-bottom: 3px solid var(--bri-orange);
        }

        .navbar-brand {
            font-weight: 800 !important;
            font-size: 1.4rem;
            color: var(--bri-blue) !important;
        }

        .bri-logo {
            height: 40px;
            margin-right: 12px;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 61, 122, 0.15);
            margin: 20px 0;
            padding: 35px;
            border: 2px solid rgba(255, 140, 0, 0.2);
        }

        .event-header {
            background: linear-gradient(135deg, var(--bri-blue) 0%, var(--bri-light-blue) 100%);
            color: white;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .event-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 140, 0, 0.1) 10px,
                rgba(255, 140, 0, 0.1) 20px
            );
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .event-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .event-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .event-info {
            background: rgba(255, 140, 0, 0.9);
            border-radius: 15px;
            padding: 15px;
            margin-top: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--bri-blue) 0%, var(--bri-light-blue) 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 61, 122, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 61, 122, 0.4);
            background: linear-gradient(135deg, var(--bri-light-blue) 0%, var(--bri-blue) 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--bri-orange) 0%, var(--bri-gold) 100%);
            border: none;
            color: white;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 61, 122, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid var(--bri-orange);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 61, 122, 0.2);
        }

        .lottery-display {
            background: linear-gradient(135deg, var(--bri-blue) 0%, var(--bri-light-blue) 100%);
            color: white;
            border-radius: 25px;
            padding: 40px;
            text-align: center;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            position: relative;
            overflow: hidden;
        }

        .lottery-display::before {
            content: '🎁';
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            opacity: 0.3;
        }

        .participant-name {
            animation: fadeInOut 0.25s ease-in-out;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: scale(0.8) rotate(-2deg); }
            50% { opacity: 1; transform: scale(1.1) rotate(1deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        .winner-announcement {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            animation: celebration 1s ease-in-out infinite alternate;
        }

        @keyframes celebration {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.03) rotate(1deg); }
        }

        .control-panel {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            margin-top: 25px;
            border: 2px solid rgba(0, 61, 122, 0.1);
        }

        .spinning {
            animation: spin 0.25s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(90deg) scale(1.05); }
            50% { transform: rotate(180deg) scale(1); }
            75% { transform: rotate(270deg) scale(1.05); }
            100% { transform: rotate(360deg) scale(1); }
        }

        .nav-link {
            font-weight: 500;
            color: var(--bri-blue) !important;
            border-radius: 15px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: linear-gradient(135deg, var(--bri-orange) 0%, var(--bri-gold) 100%);
            color: white !important;
            transform: translateY(-2px);
        }

        .badge {
            font-size: 0.8rem;
            padding: 8px 12px;
            border-radius: 15px;
        }

        .text-bri-blue {
            color: var(--bri-blue) !important;
        }

        .bg-bri-blue {
            background-color: var(--bri-blue) !important;
        }

        .footer-bri {
            background: linear-gradient(135deg, var(--bri-blue) 0%, var(--bri-light-blue) 100%);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
                        <a class="navbar-brand fw-bold" href="{{ route('lottery.index') }}">
                <img src="{{ asset('images/bri-logo.svg') }}"
                     alt="BRI Logo" class="bri-logo">
                Panen Hadiah Simpedes
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lottery.*') ? 'active fw-bold' : '' }}"
                           href="{{ route('lottery.index') }}">
                            <i class="fas fa-dice me-1"></i>Undian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participants.*') ? 'active fw-bold' : '' }}"
                           href="{{ route('participants.index') }}">
                            <i class="fas fa-users me-1"></i>Peserta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prizes.*') ? 'active fw-bold' : '' }}"
                           href="{{ route('prizes.index') }}">
                            <i class="fas fa-trophy me-1"></i>Hadiah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lottery.winners') ? 'active fw-bold' : '' }}"
                           href="{{ route('lottery.winners') }}">
                            <i class="fas fa-crown me-1"></i>Pemenang
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleAudienceMode()" title="Mode Audiens - Sembunyikan Panel Kontrol">
                        <i class="fas fa-tv me-1"></i>
                        <span class="d-none d-md-inline">Mode Audiens</span>
                    </button>
                    <div class="navbar-text small text-bri-blue">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        BRI BO Tasikmalaya
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Event Header -->
        <div class="event-header">
            <div class="position-relative">
                <h1 class="event-title">
                    🎯 PANEN HADIAH 🎁
                </h1>
                <h2 class="event-subtitle">Tabungan Simpedes</h2>
                <p class="mb-2">Pengundian Hadiah Periode Semester 1</p>

                <div class="event-info">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <strong><i class="fas fa-calendar-alt me-2"></i>Periode Simpedes</strong><br>
                            <span class="badge bg-success">September 2024 - Februari 2025</span>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-map-marker-alt me-2"></i>Lokasi Acara</strong><br>
                            <span>Asia Plaza Tasikmalaya, 17 Agustus 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        <div class="main-container">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-bri text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-start">
                    <img src="{{ asset('images/bumn-logo.svg') }}" alt="BUMN Logo" class="mb-2" style="height: 30px;">
                    <br>
                    <small>
                        <i class="fas fa-phone me-2"></i>Contact BRI: 14017<br>
                        <i class="fas fa-globe me-2"></i>www.bri.co.id
                    </small>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <img src="{{ asset('images/bri-logo.svg') }}" alt="BRI Logo" style="height: 35px;" class="me-3">
                        <div>
                            <p class="mb-0 fw-bold fs-5">
                                Panen Hadiah Simpedes 2024
                            </p>
                            <small>BRI BO Tasikmalaya</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <small>
                        <strong>Acara: 17 Agustus 2024</strong><br>
                        Periode: Sep 2024 - Feb 2025<br>
                        <i class="fas fa-heart text-warning"></i> BUMN untuk Indonesia
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery with fallback -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script>
        // jQuery fallback
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"><\/script>');
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    <script>
        // Smooth scrolling untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Function untuk toggle audience mode (dapat dipanggil dari halaman manapun)
        window.toggleAudienceMode = function() {
            const url = new URL(window.location);
            const currentMode = url.searchParams.get('audience');

            if (currentMode === 'true') {
                url.searchParams.delete('audience');
            } else {
                url.searchParams.set('audience', 'true');
            }

            window.location.href = url.toString();
        };
    </script>
</body>
</html>
