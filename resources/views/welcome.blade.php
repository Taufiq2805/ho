<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grand Luxury Hotel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f3d3e;
            --secondary: #f0c36d;
            --accent: #2e8b8a;
            --muted: #e7ecef;
            --ink: #1f2a35;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background: #f8fafc;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1120px, 90%);
            margin: 0 auto;
        }

        /* ── HERO ── */
        .hero {
            background: radial-gradient(circle at top left, #ffffff 0%, #f7f1e1 35%, #e2f2f1 100%);
            padding: 60px 0 90px;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            right: -120px;
            top: -100px;
            width: 360px;
            height: 360px;
            background: rgba(15, 61, 62, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 0 60px;
            position: relative;
            z-index: 1;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
        }

        .logo i {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:not(.btn-primary) {
            color: var(--primary);
            opacity: 0.75;
            transition: opacity 0.2s;
        }

        .nav-links a:not(.btn-primary):hover {
            opacity: 1;
        }

        /* ── BUTTONS ── */
        .btn-primary {
            background: var(--primary);
            color: #fff;
            padding: 12px 22px;
            border-radius: 999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(15, 61, 62, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(15, 61, 62, 0.25);
        }

        .btn-secondary {
            border: 1px solid var(--primary);
            color: var(--primary);
            padding: 12px 20px;
            border-radius: 999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* ── HERO CONTENT ── */
        .hero-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-label {
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 12px;
            color: var(--accent);
            margin-bottom: 16px;
        }

        .hero-title {
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 18px;
            color: var(--primary);
        }

        .hero-text {
            font-size: 16px;
            line-height: 1.7;
            color: #3a4a58;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        /* ── HERO CARD ── */
        .hero-card {
            background: #fff;
            border-radius: 24px;
            padding: 26px;
            box-shadow: 0 20px 45px rgba(15, 61, 62, 0.15);
        }

        .hero-card h4 {
            font-size: 18px;
            margin-bottom: 14px;
            color: var(--primary);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .stat-item {
            background: var(--muted);
            border-radius: 16px;
            padding: 16px;
        }

        .stat-item span {
            display: block;
            font-size: 12px;
            color: #627083;
            margin-bottom: 4px;
        }

        .stat-item strong {
            font-size: 20px;
            color: var(--primary);
        }

        /* ── SECTIONS ── */
        section {
            padding: 70px 0;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--primary);
        }

        .section-subtitle {
            color: #566475;
            margin-bottom: 32px;
            max-width: 640px;
        }

        /* ── GRIDS ── */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #edf1f4;
            box-shadow: 0 10px 28px rgba(15, 61, 62, 0.08);
        }

        .card i {
            font-size: 22px;
            color: var(--accent);
            background: rgba(46, 139, 138, 0.15);
            padding: 12px;
            border-radius: 14px;
            margin-bottom: 16px;
            display: inline-flex;
        }

        .card h4 {
            margin-bottom: 10px;
            font-size: 18px;
            color: var(--primary);
        }

        .card p {
            font-size: 14px;
            color: #607083;
            line-height: 1.6;
        }

        /* ── CTA ── */
        .cta {
            background: var(--primary);
            color: #fff;
            border-radius: 28px;
            padding: 48px;
            display: grid;
            gap: 24px;
            align-items: center;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .cta h3 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .cta p {
            color: rgba(255, 255, 255, 0.75);
        }

        /* ── FOOTER ── */
        footer {
            padding: 30px 0 50px;
            color: #7b8794;
            font-size: 14px;
            text-align: center;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav .btn-primary {
                display: inline-flex;
            }

            .hero {
                padding: 40px 0 60px;
            }

            .hero-card {
                padding: 22px;
            }

            .cta {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

    {{-- ══ HERO / NAV ══ --}}
    <header class="hero">
        <div class="container">
            <nav class="nav">
                <div class="logo">
                    <i class="fa-solid fa-hotel"></i>
                    Grand Luxury Hotel
                </div>
                <div class="nav-links">
                    <a href="#fitur">Fitur</a>
                    <a href="#modul">Modul</a>
                    <a href="#peran">Peran</a>
                    @if (Route::has('login'))
                        @auth
                            <a class="btn-primary" href="{{ url('/dashboard') }}">
                                <i class="fa-solid fa-gauge"></i>
                                Dashboard
                            </a>
                        @else
                            <a class="btn-primary" href="{{ route('login') }}">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                Masuk Sistem
                            </a>
                        @endauth
                    @endif
                </div>
                {{-- Mobile: tampilkan tombol login saja --}}
                @if (Route::has('login'))
                    @guest
                        <a class="btn-primary" href="{{ route('login') }}" style="display:none;" id="mobile-login">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Masuk
                        </a>
                    @endguest
                @endif
            </nav>

            <div class="hero-grid">
                <div>
                    <p class="hero-label">Platform Manajemen Hotel Terintegrasi</p>
                    <h1 class="hero-title">
                        Kendalikan operasional hotel dalam satu dashboard terpadu.
                    </h1>
                    <p class="hero-text">
                        Grand Luxury Hotel memudahkan tim Anda mengelola reservasi, kamar, housekeeping,
                        maintenance, hingga laporan keuangan dengan alur kerja yang rapi dan real-time.
                    </p>
                    <div class="hero-actions">
                        @if (Route::has('login'))
                            @auth
                                <a class="btn-primary" href="{{ url('/dashboard') }}">
                                    Buka Dashboard
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            @else
                                <a class="btn-primary" href="{{ route('login') }}">
                                    Mulai Kelola Hotel
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                @if (Route::has('register'))
                                    <a class="btn-secondary" href="{{ route('register') }}">
                                        Daftar Akun
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <div class="hero-card">
    <h4>Statistik Hari Ini</h4>
    <div class="stat-grid">
        <div class="stat-item">
            <span>Okupansi</span>
            <strong>{{ $okupansi }}%</strong>
        </div>
        <div class="stat-item">
            <span>Check-in</span>
            <strong>{{ $checkInHariIni }}</strong>
        </div>
        <div class="stat-item">
            <span>Check-out</span>
            <strong>{{ $checkOutHariIni }}</strong>
        </div>
        <div class="stat-item">
            <span>Kamar Tersedia</span>
            <strong>{{ $kamarTersedia }}</strong>
        </div>
    </div>
</div>
            </div>
        </div>
    </header>

    {{-- ══ FITUR ══ --}}
    <section id="fitur">
        <div class="container">
            <h2 class="section-title">Fitur Utama</h2>
            <p class="section-subtitle">
                Dirancang untuk operasional hotel modern dengan transparansi tugas, kolaborasi tim,
                dan data yang siap untuk keputusan strategis.
            </p>
            <div class="feature-grid">
                <div class="card">
                    <i class="fa-solid fa-calendar-check"></i>
                    <h4>Reservasi Terpusat</h4>
                    <p>Kelola booking, check-in, dan check-out dengan alur kerja yang rapi dan terdokumentasi.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-door-open"></i>
                    <h4>Manajemen Kamar</h4>
                    <p>Atur tipe kamar, ketersediaan, tarif, serta status kebersihan secara real-time.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-broom"></i>
                    <h4>Housekeeping Terstruktur</h4>
                    <p>Distribusi tugas kebersihan dengan prioritas yang jelas dan checklist digital.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <h4>Maintenance &amp; Inspeksi</h4>
                    <p>Catat perbaikan kamar, aset, dan permintaan service agar semuanya terkontrol.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ MODUL ══ --}}
    <section id="modul" style="background: #f1f5f9;">
        <div class="container">
            <h2 class="section-title">Modul Operasional</h2>
            <p class="section-subtitle">
                Semua kebutuhan operasional hotel Anda tersedia dalam modul terintegrasi
                yang bisa diakses sesuai peran.
            </p>
            <div class="module-grid">
                <div class="card">
                    <i class="fa-solid fa-chart-line"></i>
                    <h4>Dashboard KPI</h4>
                    <p>Ringkasan performa okupansi, pendapatan, dan tren tamu dalam satu tampilan.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-users-gear"></i>
                    <h4>Manajemen Staff</h4>
                    <p>Atur shift, peran, dan akses pengguna agar setiap tugas tertangani dengan baik.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-wallet"></i>
                    <h4>Pemasukan &amp; Pengeluaran</h4>
                    <p>Catat transaksi harian serta monitoring anggaran operasional dengan mudah.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-file-invoice"></i>
                    <h4>Laporan Otomatis</h4>
                    <p>Ekspor laporan PDF/Excel untuk audit, owner, atau kebutuhan regulasi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ PERAN ══ --}}
    <section id="peran">
        <div class="container">
            <h2 class="section-title">Akses Sesuai Peran</h2>
            <p class="section-subtitle">
                Setiap tim mendapat tampilan dan tugas sesuai tanggung jawabnya. Proses lebih cepat, lebih aman.
            </p>
            <div class="role-grid">
                <div class="card">
                    <i class="fa-solid fa-user-shield"></i>
                    <h4>Admin</h4>
                    <p>Mengelola data master, laporan, dan konfigurasi sistem untuk seluruh operasional hotel.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-id-badge"></i>
                    <h4>Resepsionis</h4>
                    <p>Fokus pada tamu: reservasi, check-in/out, serta informasi ketersediaan kamar.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-people-roof"></i>
                    <h4>Housekeeping</h4>
                    <p>Melihat daftar kamar yang perlu dibersihkan dan update status secara instan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section>
        <div class="container">
            <div class="cta">
                <div>
                    <h3>Siap menjalankan operasional hotel lebih cepat?</h3>
                    <p>Masuk ke sistem untuk mengelola setiap proses dengan workflow yang lebih rapi.</p>
                </div>
                <div>
                    @if (Route::has('login'))
                        <a class="btn-primary" href="{{ route('login') }}" style="background:#fff; color:var(--primary);">
                            Akses Dashboard
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FOOTER ══ --}}
    <footer>
        <div class="container">
            © 2026 Grand Luxury Hotel · Sistem Manajemen Hotel Terpadu
        </div>
    </footer>

    <script>
        // Tampilkan tombol login mobile jika layar kecil
        (function () {
            var btn = document.getElementById('mobile-login');
            if (btn && window.innerWidth <= 768) {
                btn.style.display = 'inline-flex';
            }
        })();
    </script>

</body>
</html>