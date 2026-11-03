<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>adm-yasfat</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- ==========================================
         CUSTOM UI/UX: TEMA ORANGE & PUTIH
    =========================================== -->
    <style>
        :root {
            --primary-orange: #ff7800; /* Warna utama orange cerah */
            --light-orange: #fff6f0;   /* Latar belakang putih kemerahan */
        }
        
        body {
            background-color: var(--light-orange);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Desain Navbar */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 120, 0, 0.1) !important;
            padding: 15px 0;
        }
        .navbar-brand {
            color: var(--primary-orange) !important;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        /* Desain Tombol */
        .btn-primary {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            font-weight: 700;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(255, 120, 0, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #e66c00;
            border-color: #e66c00;
            transform: translateY(-2px); /* Efek tombol melayang saat disentuh */
            box-shadow: 0 6px 15px rgba(255, 120, 0, 0.4);
        }

        /* Desain Card & Tabel */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan */
            backdrop-filter: blur(10px);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 2px solid var(--light-orange);
            border-radius: 15px 15px 0 0 !important;
        }
        .table-light th {
            background-color: #ffe8d6 !important;
            color: #d15c00 !important;
        }

        /* ==========================================
           ANIMASI OMBAK (WAVE) DI BAWAH LAYAR
        =========================================== */
        .wave-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 15vh;
            min-height: 100px;
            max-height: 150px;
            z-index: -1; /* Diletakkan di belakang konten */
        }
        .waves {
            position: relative;
            width: 100%;
            height: 100%;
            margin-bottom: -7px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }
        
        @keyframes move-forever {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
        .btn {
            transition: all 0.3s ease-in-out;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div id="app" style="flex: 1;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    adm-yasfat
                </a>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('login') }}" style="color: #ff7800;">Login Panitia</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item me-3">
                            <span class="nav-link fw-bold text-dark">Halo, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-danger px-3 py-1" style="border-radius: 20px;" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <!-- KODE SVG ANIMASI OMBAK -->
    <div class="wave-container">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <!-- Layer Ombak dari belakang ke depan (Warna gradasi orange) -->
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255, 120, 0, 0.2)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255, 120, 0, 0.4)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255, 120, 0, 0.6)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#ff7800" />
            </g>
        </svg>
    </div>

</body>
</html>