@extends('layouts.admin')

@section('title', 'Riwayat Pengeluaran')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Keuangan
        </span>
        <h1 class="pk-page-title">Riwayat Pengeluaran</h1>
        <p class="pk-page-sub">Pantau seluruh riwayat pengeluaran dan pembelian barang.</p>
    </div>
</div>

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="tablePengeluaran">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Username</th>
                        <th class="pk-th">Pesan</th>
                        <th class="pk-th">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluarans as $i => $p)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $i + 1 }}</td>

                        {{-- Username --}}
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar">
                                    {{ strtoupper(substr($p->user->name ?? '-', 0, 2)) }}
                                </div>
                                <span class="pk-room-num">{{ $p->user->name ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- Pesan --}}
                        <td class="pk-td">
                            <span class="pk-email">
                                Telah menambahkan pengeluaran {{ $p->nama_barang }}
                                {{ $p->jumlah_barang }} pcs dengan biaya
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="pk-td">
                            <span class="pk-date">
                                <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                                    <rect x="1.5" y="2.5" width="13" height="12" rx="2" stroke="currentColor" stroke-width="1.3"/>
                                    <path d="M5 1.5v2M11 1.5v2M1.5 6.5h13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                </svg>
                                {{ $p->created_at?->format('d-m-Y, H:i:s') ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr class="pk-row">
                        <td colspan="4" class="pk-empty-state">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
                                <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                                <rect x="12" y="13" width="16" height="14" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                                <path d="M15 18h10M15 22h6" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            <span>Belum ada data riwayat pengeluaran.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.querySelector('#tablePengeluaran');
        if (el) {
            new simpleDatatables.DataTable(el, {
                perPage: 10,
                perPageSelect: [5, 10, 25, 50],
                searchable: true,
                sortable: true,
                columns: [{ select: 3, sort: 'desc' }],
                labels: {
                    placeholder: "Cari data...",
                    perPage: "Tampilkan {select} entri",
                    noRows: "Tidak ada data ditemukan",
                    info: "Menampilkan {start}–{end} dari {rows} entri",
                    noResults: "Tidak ada hasil yang cocok",
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

.pk-card {
    background: #FDFBF8; border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius); overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.05); animation: pkFadeUp .6s .1s ease both;
}
.pk-card__body { padding: 1.25rem 1.5rem; overflow-x: auto; }

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
.pk-date {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .83rem; color: var(--pk-muted);
}

.pk-empty-state {
    padding: 3rem 1rem !important; text-align: center; color: var(--pk-muted);
    font-size: .88rem; display: flex; flex-direction: column;
    align-items: center; gap: .75rem;
}

/* ── simpleDatatables overrides ── */
.dataTable-wrapper .dataTable-top,
.dataTable-wrapper .dataTable-bottom {
    display: flex; align-items: center; justify-content: space-between;
    gap: .75rem; padding: .75rem 0; flex-wrap: wrap;
}
.dataTable-wrapper .dataTable-top { border-bottom: 1px solid var(--pk-border); margin-bottom: .5rem; }
.dataTable-wrapper .dataTable-bottom { border-top: 1px solid var(--pk-border); margin-top: .5rem; }

.dataTable-wrapper .dataTable-dropdown label,
.dataTable-wrapper .dataTable-search label {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; color: var(--pk-muted); white-space: nowrap;
}
.dataTable-wrapper .dataTable-selector {
    font-family: 'DM Sans', sans-serif; font-size: .8rem; color: var(--pk-dark);
    background: #fff; border: 1.5px solid rgba(184,150,110,.22);
    border-radius: var(--pk-radius-sm); padding: .3rem .6rem;
    outline: none; cursor: pointer; transition: border-color .2s;
}
.dataTable-wrapper .dataTable-selector:focus { border-color: var(--pk-gold); box-shadow: 0 0 0 3px rgba(184,150,110,.15); }
.dataTable-wrapper .dataTable-input {
    font-family: 'DM Sans', sans-serif; font-size: .83rem; color: var(--pk-dark);
    background: #fff; border: 1.5px solid rgba(184,150,110,.22);
    border-radius: var(--pk-radius-sm); padding: .35rem .8rem;
    outline: none; transition: border-color .2s, box-shadow .2s; width: 200px;
}
.dataTable-wrapper .dataTable-input::placeholder { color: #c0b8b0; }
.dataTable-wrapper .dataTable-input:focus { border-color: var(--pk-gold); box-shadow: 0 0 0 3px rgba(184,150,110,.15); }
.dataTable-wrapper .dataTable-info { font-size: .78rem; color: var(--pk-muted); }
.dataTable-wrapper .dataTable-pagination { display: flex; align-items: center; gap: .3rem; list-style: none; margin: 0; padding: 0; }
.dataTable-wrapper .dataTable-pagination li a {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 .5rem;
    font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 500;
    color: var(--pk-muted); background: transparent;
    border: 1.5px solid rgba(184,150,110,.18); border-radius: var(--pk-radius-sm);
    text-decoration: none; transition: all .2s ease; cursor: pointer;
}
.dataTable-wrapper .dataTable-pagination li a:hover { background: rgba(184,150,110,.1); color: var(--pk-gold-d); border-color: rgba(184,150,110,.35); }
.dataTable-wrapper .dataTable-pagination li.active a {
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff; border-color: transparent; box-shadow: 0 2px 8px rgba(184,150,110,.35);
}
.dataTable-wrapper .dataTable-pagination li.disabled a { opacity: .35; cursor: not-allowed; pointer-events: none; }

@keyframes pkFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .pk-page-header { flex-direction: column; align-items: flex-start; }
    .pk-page-title  { font-size: 1.6rem; }
}
</style>
@endpush