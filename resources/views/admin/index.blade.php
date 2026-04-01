@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- PAGE HEADING --}}
<div class="dash-heading mb-5">
    <div class="dash-heading-inner">
        <span class="dash-badge">Hotel Management</span>
        <h2 class="dash-title">Dashboard Admin</h2>
        <p class="dash-subtitle">Ringkasan operasional hotel secara real-time.</p>
    </div>
    <div class="dash-date">
        <i class="fas fa-calendar-alt me-2"></i>
        <span id="live-date"></span>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-4 mb-5">

    {{-- Tipe Kamar --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card--indigo">
            <div class="stat-card__glow"></div>
            <div class="stat-card__icon-wrap">
                <div class="stat-card__icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="stat-card__body">
                <span class="stat-card__label">Tipe Kamar</span>
                <div class="stat-card__value">{{ $totalTipeKamar }}</div>
                <div class="stat-card__bar"><div class="stat-card__fill" style="width:72%"></div></div>
            </div>
            <a href="{{ route('admin.tipekamar.index') }}" class="stat-card__link">
                Lihat Detail <i class="fas fa-chevron-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Total Kamar --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card--emerald">
            <div class="stat-card__glow"></div>
            <div class="stat-card__icon-wrap">
                <div class="stat-card__icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <div class="stat-card__body">
                <span class="stat-card__label">Total Kamar</span>
                <div class="stat-card__value">{{ $totalKamar }}</div>
                <div class="stat-card__bar"><div class="stat-card__fill" style="width:88%"></div></div>
            </div>
            <a href="{{ route('admin.kamar.index') }}" class="stat-card__link">
                Lihat Detail <i class="fas fa-chevron-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Kamar Terisi --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card--amber">
            <div class="stat-card__glow"></div>
            <div class="stat-card__icon-wrap">
                <div class="stat-card__icon">
                    <i class="fas fa-door-closed"></i>
                </div>
            </div>
            <div class="stat-card__body">
                <span class="stat-card__label">Kamar Terisi</span>
                <div class="stat-card__value">{{ $totalKamarTerisi }}</div>
                <div class="stat-card__bar"><div class="stat-card__fill" style="width:55%"></div></div>
            </div>
            <a href="#" class="stat-card__link">
                Lihat Detail <i class="fas fa-chevron-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Sisa Uang --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card--sky">
            <div class="stat-card__glow"></div>
            <div class="stat-card__icon-wrap">
                <div class="stat-card__icon">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="stat-card__body">
                <span class="stat-card__label">Total Pemasukan</span>
                <div class="stat-card__value stat-card__value--sm">
                    Rp {{ number_format($sisaUang, 0, ',', '.') }}
                </div>
                <div class="stat-card__bar"><div class="stat-card__fill" style="width:65%"></div></div>
            </div>
            <span class="stat-card__link stat-card__link--muted">
                Saldo aktif
            </span>
        </div>
    </div>

</div>

{{-- SECTION TITLE --}}
<div class="section-divider mb-4">
    <span class="section-divider__label">
        <i class="fas fa-th-large me-2"></i>Menu Cepat
    </span>
    <div class="section-divider__line"></div>
</div>

{{-- QUICK MENU --}}
<div class="row g-4">

    <div class="col-md-4">
        <a href="{{ route('admin.tipekamar.index') }}" class="text-decoration-none">
            <div class="quick-card">
                <div class="quick-card__orb quick-card__orb--indigo"></div>
                <div class="quick-card__icon quick-card__icon--indigo">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="quick-card__content">
                    <h6 class="quick-card__title">Tipe Kamar</h6>
                    <p class="quick-card__desc">Kelola kategori & tipe kamar hotel</p>
                </div>
                <div class="quick-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.kamar.index') }}" class="text-decoration-none">
            <div class="quick-card">
                <div class="quick-card__orb quick-card__orb--emerald"></div>
                <div class="quick-card__icon quick-card__icon--emerald">
                    <i class="fas fa-door-closed"></i>
                </div>
                <div class="quick-card__content">
                    <h6 class="quick-card__title">Kamar</h6>
                    <p class="quick-card__desc">Kelola unit kamar & ketersediaan</p>
                </div>
                <div class="quick-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="text-decoration-none">
            <div class="quick-card quick-card--disabled">
                <div class="quick-card__orb quick-card__orb--amber"></div>
                <div class="quick-card__icon quick-card__icon--amber">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="quick-card__content">
                    <h6 class="quick-card__title">Transaksi</h6>
                    <p class="quick-card__desc">Riwayat pembayaran & pemesanan</p>
                </div>
                <div class="quick-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* ─── Google Font ─────────────────────────────────────────── */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    /* ─── CSS Vars ────────────────────────────────────────────── */
    :root {
        --c-indigo:   #6366f1;
        --c-emerald:  #10b981;
        --c-amber:    #f59e0b;
        --c-sky:      #0ea5e9;
        --c-bg:       #f8faff;
        --c-surface:  #ffffff;
        --c-border:   #e8edf5;
        --c-text:     #0f172a;
        --c-muted:    #64748b;
        --radius:     16px;
    }

    /* ─── Base ────────────────────────────────────────────────── */
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--c-bg); }

    /* ─── Heading ─────────────────────────────────────────────── */
    .dash-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dash-badge {
        display: inline-block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--c-indigo);
        background: rgba(99,102,241,.1);
        border: 1px solid rgba(99,102,241,.25);
        padding: .2rem .75rem;
        border-radius: 100px;
        margin-bottom: .5rem;
    }
    .dash-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--c-text);
        margin: 0 0 .25rem;
        letter-spacing: -.02em;
    }
    .dash-subtitle {
        font-size: .875rem;
        color: var(--c-muted);
        margin: 0;
    }
    .dash-date {
        font-family: 'DM Mono', monospace;
        font-size: .8rem;
        color: var(--c-muted);
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 10px;
        padding: .5rem 1rem;
        white-space: nowrap;
    }

    /* ─── Stat Card ───────────────────────────────────────────── */
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius);
        padding: 1.5rem 1.5rem 1rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        color: #fff;
        min-height: 170px;
        transition: transform .3s ease, box-shadow .3s ease;
        animation: cardIn .5s ease both;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px var(--c-shadow, rgba(0,0,0,.25));
    }

    /* colours */
    .stat-card--indigo  { background: linear-gradient(135deg, #6366f1, #4f46e5); --c-shadow: rgba(99,102,241,.4); }
    .stat-card--emerald { background: linear-gradient(135deg, #10b981, #059669); --c-shadow: rgba(16,185,129,.4); }
    .stat-card--amber   { background: linear-gradient(135deg, #f59e0b, #d97706); --c-shadow: rgba(245,158,11,.4); }
    .stat-card--sky     { background: linear-gradient(135deg, #0ea5e9, #0284c7); --c-shadow: rgba(14,165,233,.4); }

    /* glow blob */
    .stat-card__glow {
        position: absolute;
        top: -40px; right: -40px;
        width: 130px; height: 130px;
        background: rgba(255,255,255,.12);
        border-radius: 50%;
        pointer-events: none;
    }

    /* icon */
    .stat-card__icon-wrap { display: flex; }
    .stat-card__icon {
        width: 44px; height: 44px;
        background: rgba(255,255,255,.2);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        backdrop-filter: blur(6px);
    }

    /* body */
    .stat-card__body { flex: 1; }
    .stat-card__label {
        display: block;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        opacity: .8;
        margin-bottom: .25rem;
    }
    .stat-card__value {
        font-size: 2.4rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -.03em;
    }
    .stat-card__value--sm { font-size: 1.35rem; }

    /* progress bar */
    .stat-card__bar {
        margin-top: .75rem;
        height: 4px;
        background: rgba(255,255,255,.25);
        border-radius: 100px;
        overflow: hidden;
    }
    .stat-card__fill {
        height: 100%;
        background: rgba(255,255,255,.75);
        border-radius: 100px;
        transition: width 1.2s cubic-bezier(.25,.8,.25,1);
    }

    /* link */
    .stat-card__link {
        font-size: .78rem;
        font-weight: 600;
        color: rgba(255,255,255,.9);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .25rem;
        transition: opacity .2s;
    }
    .stat-card__link:hover { opacity: .75; color: #fff; }
    .stat-card__link--muted { opacity: .65; pointer-events: none; }

    /* ─── Section Divider ─────────────────────────────────────── */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .section-divider__label {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--c-muted);
        white-space: nowrap;
    }
    .section-divider__line {
        flex: 1;
        height: 1px;
        background: var(--c-border);
    }

    /* ─── Quick Card ──────────────────────────────────────────── */
    .quick-card {
        position: relative;
        overflow: hidden;
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 1.4rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        cursor: pointer;
    }
    .quick-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(0,0,0,.07);
        border-color: transparent;
    }
    .quick-card:hover .quick-card__arrow {
        opacity: 1;
        transform: translateX(0);
    }
    .quick-card--disabled { opacity: .55; cursor: default; }
    .quick-card--disabled:hover { transform: none; box-shadow: none; border-color: var(--c-border); }

    /* orb */
    .quick-card__orb {
        position: absolute;
        top: -30px; right: -30px;
        width: 100px; height: 100px;
        border-radius: 50%;
        opacity: .07;
        pointer-events: none;
    }
    .quick-card__orb--indigo  { background: var(--c-indigo); }
    .quick-card__orb--emerald { background: var(--c-emerald); }
    .quick-card__orb--amber   { background: var(--c-amber); }

    /* icon */
    .quick-card__icon {
        flex-shrink: 0;
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
    .quick-card__icon--indigo  { background: rgba(99,102,241,.1);  color: var(--c-indigo); }
    .quick-card__icon--emerald { background: rgba(16,185,129,.1); color: var(--c-emerald); }
    .quick-card__icon--amber   { background: rgba(245,158,11,.1); color: var(--c-amber); }

    /* content */
    .quick-card__content { flex: 1; }
    .quick-card__title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--c-text);
        margin: 0 0 .15rem;
    }
    .quick-card__desc {
        font-size: .78rem;
        color: var(--c-muted);
        margin: 0;
    }

    /* arrow */
    .quick-card__arrow {
        color: var(--c-muted);
        opacity: 0;
        transform: translateX(-6px);
        transition: opacity .25s ease, transform .25s ease;
        font-size: .9rem;
    }

    /* ─── Keyframes ───────────────────────────────────────────── */
    @keyframes cardIn {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .col-xl-3:nth-child(1) .stat-card { animation-delay: .05s; }
    .col-xl-3:nth-child(2) .stat-card { animation-delay: .12s; }
    .col-xl-3:nth-child(3) .stat-card { animation-delay: .19s; }
    .col-xl-3:nth-child(4) .stat-card { animation-delay: .26s; }
</style>

<script>
    // Live date display
    (function () {
        const el = document.getElementById('live-date');
        if (!el) return;
        const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        el.textContent = new Date().toLocaleDateString('id-ID', opts);
    })();
</script>
@endpush