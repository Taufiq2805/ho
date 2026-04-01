@extends('layouts.admin')

@section('title', 'Riwayat Pemasukan')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Keuangan
        </span>
        <h1 class="pk-page-title">Riwayat Pemasukan</h1>
        <p class="pk-page-sub">Pantau seluruh riwayat transaksi dan pemasukan hotel.</p>
    </div>
</div>

{{-- GRAND TOTAL BADGE --}}
@php
    $grandTotal = collect($data)->sum('total');
@endphp
<div class="pk-summary-bar">
    <div class="pk-summary-item">
        <span class="pk-summary-label">Total Pemasukan</span>
        <span class="pk-summary-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
    </div>
    <div class="pk-summary-item">
        <span class="pk-summary-label">Jumlah Transaksi</span>
        <span class="pk-summary-value">{{ count($data) }}</span>
    </div>
</div>

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="tableRiwayat">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Username</th>
                        <th class="pk-th">Pesan</th>
                        <th class="pk-th">Total</th>
                        <th class="pk-th">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $i + 1 }}</td>

                        {{-- Username --}}
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar" data-initials="{{ strtoupper(substr($d['username'], 0, 2)) }}">
                                    {{ strtoupper(substr($d['username'], 0, 2)) }}
                                </div>
                                <span class="pk-room-num">{{ $d['username'] }}</span>
                            </div>
                        </td>

                        {{-- Pesan --}}
                        <td class="pk-td">
                            <span class="pk-email">{{ Str::limit($d['pesan'], 60) }}</span>
                        </td>

                        {{-- Total --}}
                        <td class="pk-td">
                            <span class="pk-amount">Rp {{ number_format($d['total'], 0, ',', '.') }}</span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="pk-td">
                            <span class="pk-date">
                                <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                                    <rect x="1.5" y="2.5" width="13" height="12" rx="2" stroke="currentColor" stroke-width="1.3"/>
                                    <path d="M5 1.5v2M11 1.5v2M1.5 6.5h13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($d['tanggal'])->format('d-m-Y H:i') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr class="pk-row">
                        <td colspan="5" class="pk-empty-state">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
                                <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                                <rect x="12" y="13" width="16" height="14" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                                <path d="M15 18h10M15 22h6" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            <span>Belum ada data riwayat pemasukan.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="pk-tfoot-row">
                        <td colspan="3" class="pk-td pk-td--tfoot-label">Total Pemasukan</td>
                        <td colspan="2" class="pk-td pk-td--tfoot-value">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('#tableRiwayat')) {
            new simpleDatatables.DataTable(document.querySelector('#tableRiwayat'), {
                columns: [{ select: 4, sort: 'desc' }],
                labels: {
                    placeholder: "Cari...",
                    perPage: "Menunjukkan {select} entri",
                    noRows: "Tidak ada data ditemukan",
                    info: "Menampilkan {start} sampai {end} dari {rows} entri",
                }
            });
        }
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
}

body { font-family: 'DM Sans', sans-serif; }

/* PAGE HEADER */
.pk-page-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 1rem; margin-bottom: 1.5rem; animation: pkFadeUp .5s ease both;
}
.pk-page-header__left { display: flex; flex-direction: column; gap: .35rem; }
.pk-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .72rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--pk-gold);
}
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

/* SUMMARY BAR */
.pk-summary-bar {
    display: flex; gap: 1rem; margin-bottom: 2rem;
    animation: pkFadeUp .5s .1s ease both;
}
.pk-summary-item {
    display: flex; flex-direction: column; gap: .25rem;
    padding: .9rem 1.4rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2E2A22 100%);
    border: 1px solid var(--pk-border); border-radius: var(--pk-radius);
    box-shadow: 0 2px 12px rgba(0,0,0,.12);
}
.pk-summary-label {
    font-size: .7rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--pk-muted);
}
.pk-summary-value {
    font-family: 'DM Serif Display', serif; font-size: 1.4rem;
    color: var(--pk-gold-l); line-height: 1.1;
}

/* CARD */
.pk-card {
    background: #FDFBF8; border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius); overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.05); animation: pkFadeUp .6s .2s ease both;
}
.pk-card__body { padding: 1.25rem 1.5rem; overflow-x: auto; }

/* TABLE */
.pk-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.pk-th {
    font-family: 'DM Sans', sans-serif; font-size: .7rem; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase; color: var(--pk-muted);
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
.pk-room-num { font-weight: 600; color: var(--pk-dark); letter-spacing: .02em; }
.pk-email { display: inline-flex; align-items: center; gap: .4rem; font-size: .83rem; color: var(--pk-muted); }

/* Amount */
.pk-amount {
    font-weight: 600; color: var(--pk-dark);
    font-size: .875rem;
}

/* Date */
.pk-date {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .83rem; color: var(--pk-muted);
}

/* Tfoot */
.pk-tfoot-row { border-top: 2px solid rgba(184,150,110,.25); background: rgba(184,150,110,.04); }
.pk-td--tfoot-label {
    font-size: .78rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--pk-muted); text-align: right;
}
.pk-td--tfoot-value {
    font-family: 'DM Serif Display', serif; font-size: 1.1rem;
    color: var(--pk-gold-d); font-weight: 400;
}

.pk-no-shift { color: var(--pk-muted); font-size: .88rem; }

.pk-empty-state {
    padding: 3rem 1rem !important; text-align: center; color: var(--pk-muted);
    font-size: .88rem; display: flex; flex-direction: column;
    align-items: center; gap: .75rem;
}

@keyframes pkFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .pk-page-header { flex-direction: column; align-items: flex-start; }
    .pk-page-title  { font-size: 1.6rem; }
    .pk-summary-bar { flex-direction: column; }
}
</style>
@endpush