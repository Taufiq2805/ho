@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Hotel
        </span>
        <h1 class="pk-page-title">Laporan Keuangan</h1>
        <p class="pk-page-sub">Pantau pemasukan dan pengeluaran operasional hotel secara terperinci.</p>
    </div>
</div>

{{-- FILTER CARDS --}}
<section class="section">
    <div class="pk-filter-grid">

        {{-- Filter Pemasukan --}}
        <div class="pk-card pk-card--filter">
            <div class="pk-card__filter-header">
                <div class="pk-modal__icon pk-modal__icon--income">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 20V4M5 11l7-7 7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <p class="pk-card__filter-title">Laporan Pemasukan</p>
                    <p class="pk-card__filter-sub">Filter berdasarkan bulan pembayaran</p>
                </div>
            </div>
            <div class="pk-card__body">
                <form method="GET" action="{{ route('admin.laporan.index') }}">
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <rect x="1.5" y="2.5" width="13" height="12" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M5 1.5v2M11 1.5v2M1.5 6h13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                            Pilih Bulan Pembayaran
                        </label>
                        <select name="bulan" id="bulan" class="pk-input pk-select">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach ($bulanOptions as $item)
                                @php $date = \Carbon\Carbon::createFromFormat('Y-m', $item->bulan); @endphp
                                <option value="{{ $item->bulan }}" {{ request('bulan') == $item->bulan ? 'selected' : '' }}>
                                    {{ $date->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--submit pk-modal-btn--income" style="margin-top:.85rem; width:100%; justify-content:center;">
                        <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
                            <circle cx="7" cy="7" r="5" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M11 11l3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        Tampilkan Pemasukan
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter Pengeluaran --}}
        <div class="pk-card pk-card--filter">
            <div class="pk-card__filter-header">
                <div class="pk-modal__icon pk-modal__icon--expense">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 4v16M5 13l7 7 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <p class="pk-card__filter-title">Laporan Pengeluaran</p>
                    <p class="pk-card__filter-sub">Filter berdasarkan rentang tanggal</p>
                </div>
            </div>
            <div class="pk-card__body">
                <form method="GET" action="{{ route('admin.laporan.index') }}">
                    <div class="pk-field" style="margin-bottom:.65rem;">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <rect x="1.5" y="2.5" width="13" height="12" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M5 1.5v2M11 1.5v2M1.5 6h13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                            Dari Tanggal
                        </label>
                        <input type="date" name="dari" class="pk-input" value="{{ request('dari') }}">
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <rect x="1.5" y="2.5" width="13" height="12" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M5 1.5v2M11 1.5v2M1.5 6h13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                            Sampai Tanggal
                        </label>
                        <input type="date" name="sampai" class="pk-input" value="{{ request('sampai') }}">
                    </div>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--submit pk-modal-btn--expense" style="margin-top:.85rem; width:100%; justify-content:center;">
                        <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
                            <circle cx="7" cy="7" r="5" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M11 11l3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        Tampilkan Pengeluaran
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- TABEL PEMASUKAN --}}
@if(request('bulan'))
<section class="section" style="margin-top:1.75rem;">
    <div class="pk-section-heading">
        <span class="pk-eyebrow pk-eyebrow--income">
            <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                <path d="M7 11V3M3 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Pemasukan
        </span>
        <h2 class="pk-section-title">
            Laporan Pemasukan —
            <span style="color:var(--pk-gold);">{{ \Carbon\Carbon::createFromFormat('Y-m', request('bulan'))->translatedFormat('F Y') }}</span>
        </h2>

        @if(count($pemasukan))
        <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}" target="_blank" class="pk-modal-btn pk-modal-btn--pdf" style="margin-left:auto;">
            <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                <rect x="2" y="1" width="10" height="14" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                <path d="M5 5h6M5 8h4M5 11h3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            Cetak PDF
        </a>
        @endif
    </div>

    @if(count($pemasukan))
    <div class="pk-card" style="animation-delay:.05s;">
        <div class="pk-card__body">
            <table class="pk-table" id="tablePemasukan">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Tanggal</th>
                        <th class="pk-th">Nama Tamu</th>
                        <th class="pk-th">Kamar</th>
                        <th class="pk-th">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemasukan as $i => $item)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $i + 1 }}</td>
                        <td class="pk-td">
                            <span class="pk-time-badge pk-time-badge--start">
                                <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                                    <rect x="1.5" y="2.5" width="11" height="10" rx="1.3" stroke="currentColor" stroke-width="1.2"/>
                                    <path d="M4.5 1.5v2M9.5 1.5v2M1.5 5.5h11" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                {{ $item->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar pk-avatar--income">{{ strtoupper(substr($item->reservasi->nama_tamu ?? 'NN', 0, 2)) }}</div>
                                <span class="pk-room-num">{{ $item->reservasi->nama_tamu ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="pk-td">
                            <span class="pk-tipe-badge">{{ $item->reservasi->kamar->nomor_kamar ?? '-' }}</span>
                        </td>
                        <td class="pk-td">
                            <span class="pk-amount pk-amount--income">
                                Rp {{ number_format($item->reservasi->total ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="pk-card" style="animation-delay:.05s;">
        <div class="pk-card__body">
            <div class="pk-empty-state">
                <svg viewBox="0 0 40 40" fill="none" width="36" height="36">
                    <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                    <rect x="12" y="11" width="16" height="18" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                    <path d="M15 17h10M15 21h7M15 25h5" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                </svg>
                <span>Tidak ada data pemasukan pada bulan yang dipilih.</span>
            </div>
        </div>
    </div>
    @endif
</section>
@endif

{{-- TABEL PENGELUARAN --}}
@if(request('dari') && request('sampai'))
<section class="section" style="margin-top:1.75rem;">
    <div class="pk-section-heading">
        <span class="pk-eyebrow pk-eyebrow--expense">
            <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                <path d="M7 3v8M3 7l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Pengeluaran
        </span>
        <h2 class="pk-section-title">
            Laporan Pengeluaran —
            <span style="color:var(--pk-rose);">
                {{ \Carbon\Carbon::parse(request('dari'))->format('d M Y') }}
                &rarr;
                {{ \Carbon\Carbon::parse(request('sampai'))->format('d M Y') }}
            </span>
        </h2>

        @if(count($pengeluaran))
        <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}" target="_blank" class="pk-modal-btn pk-modal-btn--pdf" style="margin-left:auto;">
            <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                <rect x="2" y="1" width="10" height="14" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                <path d="M5 5h6M5 8h4M5 11h3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            Cetak PDF
        </a>
        @endif
    </div>

    @if(count($pengeluaran))
    <div class="pk-card" style="animation-delay:.05s;">
        <div class="pk-card__body">
            <table class="pk-table" id="tablePengeluaran">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Tanggal</th>
                        <th class="pk-th">User</th>
                        <th class="pk-th">Keterangan</th>
                        <th class="pk-th">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengeluaran as $i => $item)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $i + 1 }}</td>
                        <td class="pk-td">
                            <span class="pk-time-badge pk-time-badge--end">
                                <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                                    <rect x="1.5" y="2.5" width="11" height="10" rx="1.3" stroke="currentColor" stroke-width="1.2"/>
                                    <path d="M4.5 1.5v2M9.5 1.5v2M1.5 5.5h11" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar pk-avatar--expense">{{ strtoupper(substr($item->user->name ?? 'AD', 0, 2)) }}</div>
                                <span class="pk-room-num">{{ $item->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="pk-td">
                            <span style="color:var(--pk-dark); font-size:.855rem;">{{ $item->nama_barang }}</span>
                        </td>
                        <td class="pk-td">
                            <span class="pk-amount pk-amount--expense">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="pk-card" style="animation-delay:.05s;">
        <div class="pk-card__body">
            <div class="pk-empty-state">
                <svg viewBox="0 0 40 40" fill="none" width="36" height="36">
                    <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                    <rect x="12" y="11" width="16" height="18" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                    <path d="M15 17h10M15 21h7M15 25h5" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                </svg>
                <span>Tidak ada data pengeluaran pada rentang tanggal yang dipilih.</span>
            </div>
        </div>
    </div>
    @endif
</section>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        ['#tablePemasukan', '#tablePengeluaran'].forEach(sel => {
            const el = document.querySelector(sel);
            if (el) new simpleDatatables.DataTable(el);
        });
    });
</script>
@endpush

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

:root {
    --pk-gold:      #B8966E;
    --pk-gold-l:    #D4B896;
    --pk-gold-d:    #8A6A44;
    --pk-dark:      #12110F;
    --pk-dark-2:    #1C1A17;
    --pk-dark-3:    #252219;
    --pk-border:    rgba(184,150,110,.18);
    --pk-text:      #E8E0D4;
    --pk-muted:     #8A8070;
    --pk-white:     #FDFBF8;
    --pk-radius:    14px;
    --pk-radius-sm: 8px;

    /* extended for laporan */
    --pk-green:     #16a34a;
    --pk-green-l:   #bbf7d0;
    --pk-green-bg:  #f0fdf4;
    --pk-rose:      #be123c;
    --pk-rose-l:    #fecdd3;
    --pk-rose-bg:   #fff1f2;
}

body { font-family: 'DM Sans', sans-serif; }

/* ── Page Header ── */
.pk-page-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 1rem; margin-bottom: 2rem; animation: pkFadeUp .5s ease both;
}
.pk-page-header__left { display: flex; flex-direction: column; gap: .35rem; }
.pk-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .72rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--pk-gold);
}
.pk-eyebrow--income { color: var(--pk-green); }
.pk-eyebrow--expense { color: var(--pk-rose); }
.pk-eyebrow__dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--pk-gold); animation: pkPulse 2s ease infinite;
}
@keyframes pkPulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.7); }
}
.pk-page-title {
    font-family: 'DM Serif Display', serif; font-size: 2rem;
    color: var(--pk-dark); margin: 0; line-height: 1.1;
}
.pk-page-sub { font-size: .85rem; color: var(--pk-muted); margin: 0; }

/* ── Section Heading ── */
.pk-section-heading {
    display: flex; align-items: center; gap: .75rem;
    flex-wrap: wrap; margin-bottom: 1rem;
}
.pk-section-title {
    font-family: 'DM Serif Display', serif; font-size: 1.25rem;
    color: var(--pk-dark); margin: 0;
}

/* ── Filter Grid ── */
.pk-filter-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
}
@media (max-width: 768px) {
    .pk-filter-grid { grid-template-columns: 1fr; }
}

/* ── Cards ── */
.pk-card {
    background: #FDFBF8; border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius); overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.05); animation: pkFadeUp .6s .1s ease both;
}
.pk-card--filter { animation: pkFadeUp .5s ease both; }
.pk-card--filter:nth-child(2) { animation-delay: .1s; }
.pk-card__body { padding: 1.25rem 1.5rem; overflow-x: auto; }

.pk-card__filter-header {
    display: flex; align-items: center; gap: .9rem;
    padding: 1.1rem 1.5rem .9rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2A2620 100%);
    border-bottom: 1px solid rgba(184,150,110,.15);
}
.pk-card__filter-title {
    font-family: 'DM Serif Display', serif; font-size: 1rem;
    color: var(--pk-white); margin: 0 0 .1rem;
}
.pk-card__filter-sub { font-size: .76rem; color: rgba(232,224,212,.5); margin: 0; }

/* ── Modal Icon repurposed for filter ── */
.pk-modal__icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
}
.pk-modal__icon svg { width: 20px; height: 20px; }
.pk-modal__icon--income {
    background: rgba(22,163,74,.2); color: #4ade80;
    border: 1px solid rgba(22,163,74,.3);
}
.pk-modal__icon--expense {
    background: rgba(190,18,60,.2); color: #fb7185;
    border: 1px solid rgba(190,18,60,.3);
}

/* ── Table ── */
.pk-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.pk-th {
    font-size: .7rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--pk-muted);
    padding: .65rem 1rem; text-align: left;
    border-bottom: 1px solid rgba(184,150,110,.18); white-space: nowrap;
}
.pk-th--no { width: 48px; text-align: center; }
.pk-row { border-bottom: 1px solid rgba(184,150,110,.08); transition: background .18s ease; }
.pk-row:last-child { border-bottom: none; }
.pk-row:hover { background: rgba(184,150,110,.04); }
.pk-td { padding: .85rem 1rem; color: var(--pk-dark); vertical-align: middle; }
.pk-td--no { text-align: center; font-size: .78rem; font-weight: 600; color: var(--pk-muted); }

.pk-user-cell { display: flex; align-items: center; gap: .7rem; }
.pk-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff; font-size: .72rem; font-weight: 700; letter-spacing: .04em;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(184,150,110,.3); user-select: none;
}
.pk-avatar--income {
    background: linear-gradient(135deg, #15803d, #22c55e);
    box-shadow: 0 2px 8px rgba(22,163,74,.3);
}
.pk-avatar--expense {
    background: linear-gradient(135deg, #9f1239, #e11d48);
    box-shadow: 0 2px 8px rgba(190,18,60,.3);
}
.pk-room-num { font-weight: 600; color: var(--pk-dark); letter-spacing: .02em; }

.pk-tipe-badge {
    display: inline-block; padding: .25rem .75rem;
    background: rgba(184,150,110,.1); color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.2); border-radius: 99px;
    font-size: .78rem; font-weight: 600;
}

.pk-time-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .24rem .6rem; border-radius: 6px;
    font-size: .77rem; font-weight: 600; font-variant-numeric: tabular-nums;
}
.pk-time-badge--start { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.pk-time-badge--end   { background: #faf5ff; color: #6d28d9; border: 1px solid #ddd6fe; }

.pk-amount {
    font-weight: 700; font-size: .875rem; font-variant-numeric: tabular-nums;
}
.pk-amount--income { color: var(--pk-green); }
.pk-amount--expense { color: var(--pk-rose); }

.pk-empty-state {
    padding: 3rem 1rem !important; text-align: center; color: var(--pk-muted);
    font-size: .88rem; display: flex; flex-direction: column;
    align-items: center; gap: .75rem;
}

/* ── Field & Label ── */
.pk-field { display: flex; flex-direction: column; gap: .45rem; }
.pk-label {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .8rem; font-weight: 600; letter-spacing: .04em; color: var(--pk-dark);
}
.pk-label svg { width: 14px; height: 14px; color: var(--pk-gold); }
.pk-input {
    font-family: 'DM Sans', sans-serif; font-size: .875rem; color: var(--pk-dark);
    background: #fff; border: 1.5px solid rgba(184,150,110,.22);
    border-radius: var(--pk-radius-sm); padding: .6rem .9rem; width: 100%;
    box-sizing: border-box; outline: none; transition: border-color .2s;
}
.pk-input:focus { border-color: var(--pk-gold); }
.pk-select { appearance: none; cursor: pointer; }

/* ── Buttons ── */
.pk-modal-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .6rem 1.25rem; border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s ease;
    text-decoration: none;
}
.pk-modal-btn--submit { color: #fff; }
.pk-modal-btn--income {
    background: linear-gradient(135deg, #15803d, #22c55e);
    box-shadow: 0 2px 12px rgba(22,163,74,.25);
}
.pk-modal-btn--income:hover { box-shadow: 0 4px 18px rgba(22,163,74,.35); transform: translateY(-1px); }
.pk-modal-btn--expense {
    background: linear-gradient(135deg, #9f1239, #e11d48);
    box-shadow: 0 2px 12px rgba(190,18,60,.25);
}
.pk-modal-btn--expense:hover { box-shadow: 0 4px 18px rgba(190,18,60,.35); transform: translateY(-1px); }
.pk-modal-btn--pdf {
    background: rgba(190,18,60,.08); color: var(--pk-rose);
    border: 1px solid rgba(190,18,60,.2);
    padding: .4rem 1rem; font-size: .8rem;
}
.pk-modal-btn--pdf:hover { background: rgba(190,18,60,.15); }

@keyframes pkFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .pk-page-header { flex-direction: column; align-items: flex-start; }
    .pk-page-title  { font-size: 1.6rem; }
    .pk-section-heading { flex-direction: column; align-items: flex-start; }
    .pk-section-heading .pk-modal-btn--pdf { margin-left: 0 !important; }
}
</style>
@endpush