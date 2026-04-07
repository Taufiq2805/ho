<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Grand Luxury Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold:       #c9a84c;
            --gold-light: #e8c97a;
            --gold-pale:  rgba(201,168,76,0.12);
            --dark:       #0e0e18;
            --dark2:      #16162a;
            --white:      #fdfaf4;
            --muted:      rgba(253,250,244,0.55);
            --border:     rgba(201,168,76,0.22);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 16px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 15% 15%, rgba(201,168,76,0.1) 0%, transparent 55%),
                radial-gradient(ellipse 60% 50% at 85% 85%, rgba(201,168,76,0.07) 0%, transparent 55%),
                linear-gradient(160deg, #0e0e18 0%, #16162a 50%, #1a1a30 100%);
            z-index: 0;
        }

        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(80px); opacity: 0.15;
            pointer-events: none; z-index: 0;
            animation: floatOrb 12s ease-in-out infinite alternate;
        }
        .orb-1 { width: 300px; height: 300px; background: var(--gold); top: -80px; left: -80px; }
        .orb-2 { width: 220px; height: 220px; background: #7c6dab; bottom: -60px; right: -60px; animation-delay: -5s; }

        @keyframes floatOrb {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(20px,15px) scale(1.08); }
        }

        /* ── Card ── */
        .card {
            position: relative; z-index: 1;
            width: 100%; max-width: 440px;
            background: linear-gradient(180deg, #1a1a32 0%, #12121f 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,168,76,0.08);
            animation: cardIn 0.65s cubic-bezier(.16,1,.3,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Hero ── */
        .hero {
            padding: 40px 32px 32px;
            text-align: center;
            position: relative;
            border-bottom: 1px solid var(--border);
        }
        .hero::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 200px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .crown-ring {
            width: 72px; height: 72px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 0 8px rgba(201,168,76,0.1), 0 0 0 16px rgba(201,168,76,0.04), 0 10px 30px rgba(201,168,76,0.3);
            animation: pulse 3s ease-in-out infinite;
        }
        .crown-ring i { font-size: 28px; color: var(--dark); }

        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 8px rgba(201,168,76,0.1), 0 0 0 16px rgba(201,168,76,0.04), 0 10px 30px rgba(201,168,76,0.3); }
            50%      { box-shadow: 0 0 0 10px rgba(201,168,76,0.15), 0 0 0 20px rgba(201,168,76,0.06), 0 10px 36px rgba(201,168,76,0.4); }
        }

        .hotel-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px; font-weight: 900;
            letter-spacing: 0.1em; color: var(--gold); margin-bottom: 4px;
        }
        .hotel-sub {
            font-size: 9px; font-weight: 500;
            letter-spacing: 0.28em; color: var(--muted); text-transform: uppercase;
        }

        .divider {
            display: flex; align-items: center; gap: 10px; margin-top: 20px;
        }
        .divider span { flex: 1; height: 1px; background: var(--border); }
        .divider i { color: var(--gold); font-size: 8px; opacity: 0.5; }

        /* ── Form ── */
        .form-wrap { padding: 32px 28px 28px; }

        .form-heading { margin-bottom: 24px; animation: fadeUp 0.6s 0.2s both; }
        .form-heading h2 {
            font-family: 'Playfair Display', serif;
            font-size: 22px; font-weight: 700; color: var(--white); margin-bottom: 5px;
        }
        .form-heading p { font-size: 13px; color: var(--muted); }
        .accent { width: 32px; height: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-light)); border-radius: 2px; margin-top: 10px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .field { margin-bottom: 16px; animation: fadeUp 0.6s 0.28s both; }
        .field:nth-child(2) { animation-delay: 0.34s; }

        .field label {
            display: block; font-size: 11px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: rgba(201,168,76,0.7); margin-bottom: 8px;
        }

        .input-wrap { position: relative; }
        .input-wrap i.ico {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            font-size: 14px; color: rgba(255,255,255,0.25);
            pointer-events: none; z-index: 2; transition: color 0.25s;
        }
        .input-wrap input {
            width: 100%; padding: 13px 44px 13px 42px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; color: var(--white);
            font-family: 'DM Sans', sans-serif; font-size: 14px;
            transition: all 0.25s; -webkit-appearance: none;
        }
        .input-wrap input::placeholder { color: rgba(255,255,255,0.2); }
        .input-wrap input:focus {
            outline: none;
            background: rgba(201,168,76,0.07);
            border-color: rgba(201,168,76,0.5);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
        }
        .input-wrap:focus-within i.ico { color: var(--gold); }

        .toggle-pass {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.25); font-size: 14px; padding: 4px; z-index: 2;
            transition: color 0.25s;
        }
        .toggle-pass:hover { color: var(--gold); }

        .row-opts {
            display: flex; justify-content: space-between; align-items: center;
            margin: 18px 0 22px; animation: fadeUp 0.6s 0.38s both;
        }
        .check-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--muted); cursor: pointer; user-select: none;
        }
        .check-label input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--gold); }
        .forgot { font-size: 13px; font-weight: 500; color: var(--gold); text-decoration: none; transition: opacity 0.2s; }
        .forgot:hover { opacity: 0.7; }

        .btn {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark); border: none; border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 6px 24px rgba(201,168,76,0.35);
            transition: all 0.25s; animation: fadeUp 0.6s 0.42s both;
            position: relative; overflow: hidden;
        }
        .btn::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.18), transparent);
            opacity: 0; transition: opacity 0.25s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(201,168,76,0.45); }
        .btn:hover::after { opacity: 1; }
        .btn:active { transform: translateY(0); }

        /* Feature strip */
        .features {
            display: flex; border-top: 1px solid var(--border);
            animation: fadeUp 0.6s 0.5s both;
        }
        .feat-item {
            flex: 1; padding: 16px 10px; text-align: center;
            border-right: 1px solid var(--border); transition: background 0.2s;
        }
        .feat-item:last-child { border-right: none; }
        .feat-item:hover { background: var(--gold-pale); }
        .feat-item i { font-size: 15px; color: var(--gold); display: block; margin-bottom: 5px; }
        .feat-item span { font-size: 10px; color: var(--muted); line-height: 1.4; display: block; }

        .foot {
            text-align: center; padding: 14px;
            font-size: 11px; color: rgba(253,250,244,0.2);
            letter-spacing: 0.04em; border-top: 1px solid var(--border);
        }

        @media (min-width: 520px) {
            .card { max-width: 460px; }
            .form-wrap { padding: 36px 36px 32px; }
            .hero { padding: 44px 36px 34px; }
            .hotel-name { font-size: 26px; }
            .form-heading h2 { font-size: 24px; }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="card">

    <div class="hero">
        <div class="crown-ring"><i class="fas fa-crown"></i></div>
        <div class="hotel-name">GRAND LUXURY</div>
        <div class="hotel-sub">Hotel Management System</div>
        <div class="divider"><span></span><i class="fas fa-diamond"></i><span></span></div>
    </div>

    <div class="form-wrap">
        <div class="form-heading">
            <h2>Selamat Datang</h2>
            <p>Login untuk mengakses sistem manajemen hotel</p>
            <div class="accent"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div class="field">
                <label>Alamat Email</label>
                <div class="input-wrap">
                    <input type="email" name="email" placeholder="nama@email.com" required autocomplete="username">
                    <i class="fas fa-envelope ico"></i>
                </div>
            </div>

            <div class="field">
                <label>Password</label>
                <div class="input-wrap">
                    <input type="password" name="password" id="passField" placeholder="Masukkan password" required autocomplete="current-password">
                    <i class="fas fa-lock ico"></i>
                    <button type="button" class="toggle-pass" id="togglePass">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="row-opts">
                <label class="check-label">
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
                <a href="#" class="forgot">Lupa Password?</a>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Login Sekarang
            </button>
        </form>
    </div>

    <div class="features">
        <div class="feat-item">
            <i class="fas fa-bed"></i>
            <span>Manajemen Kamar</span>
        </div>
        <div class="feat-item">
            <i class="fas fa-calendar-check"></i>
            <span>Reservasi Instan</span>
        </div>
        <div class="feat-item">
            <i class="fas fa-chart-line"></i>
            <span>Analisis Keuangan</span>
        </div>
    </div>

    <div class="foot">© 2026 Grand Luxury Hotel &nbsp;·&nbsp; All Rights Reserved</div>

</div>

<script>
    const btn  = document.getElementById('togglePass');
    const pass = document.getElementById('passField');
    const eye  = document.getElementById('eyeIcon');
    btn.addEventListener('click', () => {
        const show = pass.type === 'password';
        pass.type = show ? 'text' : 'password';
        eye.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
</script>
</body>
</html>