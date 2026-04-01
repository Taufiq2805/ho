@extends('layouts.admin')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Properti
        </span>
        <h1 class="pk-page-title">Daftar Kamar</h1>
        <p class="pk-page-sub">Kelola seluruh unit kamar hotel beserta statusnya.</p>
    </div>
    <button class="pk-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <span class="pk-btn-add__icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah Kamar
    </button>
</div>

{{-- FILTER BAR --}}
<div class="pk-filter-bar">
    <form action="{{ route('admin.kamar.index') }}" method="GET" class="pk-filter-form">
        <div class="pk-filter-group">
            <svg class="pk-filter-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 5h14M6 10h8M9 15h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            <select name="tipe_id" id="tipe_id" class="pk-filter-select">
                <option value="">Semua Tipe Kamar</option>
                @foreach ($tipeKamar as $tipe)
                    <option value="{{ $tipe->id }}" {{ request('tipe_id') == $tipe->id ? 'selected' : '' }}>
                        {{ $tipe->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="pk-filter-btn pk-filter-btn--primary">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15">
                <circle cx="9" cy="9" r="5.5" stroke="currentColor" stroke-width="1.7"/>
                <path d="M13.5 13.5L17 17" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
            Filter
        </button>
        <a href="{{ route('admin.kamar.index') }}" class="pk-filter-btn pk-filter-btn--ghost">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
            Reset
        </a>
    </form>

    {{-- Status Legend --}}
    <div class="pk-legend">
        <span class="pk-legend-item pk-legend--tersedia">Tersedia</span>
        <span class="pk-legend-item pk-legend--terisi">Terisi</span>
        <span class="pk-legend-item pk-legend--bersih">Dibersihkan</span>
        <span class="pk-legend-item pk-legend--maint">Maintenance</span>
    </div>
</div>

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="table1">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Nomor Kamar</th>
                        <th class="pk-th">Tipe</th>
                        <th class="pk-th">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kamar as $index => $item)
                        <tr class="pk-row">
                            <td class="pk-td pk-td--no">{{ $index + 1 }}</td>
                            <td class="pk-td">
                                <div class="pk-room-cell">
                                    <span class="pk-room-icon">
                                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="3" y="7" width="14" height="10" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M7 7V5.5a3 3 0 016 0V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                    <span class="pk-room-num">{{ $item->nomor_kamar }}</span>
                                </div>
                            </td>
                            <td class="pk-td">
                                <span class="pk-tipe-badge">{{ $item->tipe->nama }}</span>
                            </td>
                            <td class="pk-td">
                                @php
                                    $statusMap = match($item->status) {
                                        'tersedia'    => ['cls' => 'pk-status--tersedia',  'dot' => '#22c55e', 'label' => 'Tersedia'],
                                        'terisi'      => ['cls' => 'pk-status--terisi',    'dot' => '#3b82f6', 'label' => 'Terisi'],
                                        'dibersihkan' => ['cls' => 'pk-status--bersih',    'dot' => '#f59e0b', 'label' => 'Dibersihkan'],
                                        'maintenance' => ['cls' => 'pk-status--maint',     'dot' => '#ef4444', 'label' => 'Maintenance'],
                                        default       => ['cls' => 'pk-status--default',   'dot' => '#94a3b8', 'label' => ucfirst($item->status)],
                                    };
                                @endphp
                                <span class="pk-status {{ $statusMap['cls'] }}">
                                    <span class="pk-status__dot" style="background:{{ $statusMap['dot'] }}"></span>
                                    {{ $statusMap['label'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
        <div class="modal-content pk-modal">
            <form action="{{ route('admin.kamar.store') }}" method="POST">
                @csrf
                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Tambah Kamar Baru</h5>
                        <p class="pk-modal__sub">Isi detail unit kamar di bawah ini</p>
                    </div>
                    <button type="button" class="pk-modal__close" data-bs-dismiss="modal" aria-label="Tutup">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="pk-modal__body">
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="5" width="12" height="9" rx="1.2" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M5.5 5V4a2.5 2.5 0 015 0v1" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Nomor Kamar
                        </label>
                        <input type="text" name="nomor_kamar" class="pk-input" placeholder="Contoh: 101, A-202…" required>
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 13V6.5L8 3l6 3.5V13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="5.5" y="9" width="5" height="4" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                            </svg>
                            Tipe Kamar
                        </label>
                        <select name="tipe_id" class="pk-select" required>
                            <option value="">— Pilih Tipe —</option>
                            @foreach ($tipeKamar as $tipe)
                                <option value="{{ $tipe->id }}">{{ $tipe->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M8 5.5v2.5l2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Status Awal
                        </label>
                        <div class="pk-status-picker">
                            <label class="pk-radio-opt pk-radio-opt--tersedia">
                                <input type="radio" name="status" value="tersedia" checked>
                                <span>Tersedia</span>
                            </label>
                            <label class="pk-radio-opt pk-radio-opt--terisi">
                                <input type="radio" name="status" value="terisi">
                                <span>Terisi</span>
                            </label>
                            <label class="pk-radio-opt pk-radio-opt--bersih">
                                <input type="radio" name="status" value="dibersihkan">
                                <span>Dibersihkan</span>
                            </label>
                            <label class="pk-radio-opt pk-radio-opt--maint">
                                <input type="radio" name="status" value="maintenance">
                                <span>Maintenance</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new simpleDatatables.DataTable(document.querySelector('#table1'));
    });
</script>
@endpush

@push('styles')
<style>
/* ============================================================
   FONT
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

/* ============================================================
   TOKENS
   ============================================================ */
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

/* ============================================================
   BASE
   ============================================================ */
body { font-family: 'DM Sans', sans-serif; }

/* ============================================================
   PAGE HEADER
   ============================================================ */
.pk-page-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    animation: pkFadeUp .5s ease both;
}
.pk-page-header__left { display: flex; flex-direction: column; gap: .35rem; }

.pk-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--pk-gold);
}
.pk-eyebrow__dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--pk-gold);
    animation: pkPulse 2s ease infinite;
}
@keyframes pkPulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.7); }
}

.pk-page-title {
    font-family: 'DM Serif Display', serif;
    font-size: 2rem;
    color: var(--pk-dark);
    margin: 0;
    line-height: 1.1;
}
.pk-page-sub {
    font-size: .85rem;
    color: var(--pk-muted);
    margin: 0;
}

/* ============================================================
   ADD BUTTON
   ============================================================ */
.pk-btn-add {
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    padding: .65rem 1.3rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2E2A22 100%);
    color: var(--pk-gold-l);
    border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius);
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: all .25s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,.18);
}
.pk-btn-add:hover {
    background: linear-gradient(135deg, #252219 0%, #3A3428 100%);
    color: var(--pk-gold);
    box-shadow: 0 6px 22px rgba(184,150,110,.2);
    transform: translateY(-2px);
}
.pk-btn-add__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px; height: 24px;
    background: rgba(184,150,110,.15);
    border-radius: 6px;
}
.pk-btn-add__icon svg { width:14px; height:14px; }

/* ============================================================
   FILTER BAR
   ============================================================ */
.pk-filter-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    background: #FDFBF8;
    border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius);
    padding: .9rem 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 6px rgba(0,0,0,.04);
    animation: pkFadeUp .55s .05s ease both;
}
.pk-filter-form {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.pk-filter-group {
    display: flex;
    align-items: center;
    gap: .5rem;
    background: #F4EFE8;
    border: 1px solid rgba(184,150,110,.2);
    border-radius: var(--pk-radius-sm);
    padding: .45rem .75rem;
}
.pk-filter-icon { width:16px; height:16px; color: var(--pk-gold); flex-shrink:0; }
.pk-filter-select {
    border: none;
    background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: .84rem;
    color: var(--pk-dark);
    outline: none;
    min-width: 200px;
    cursor: pointer;
}

.pk-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .5rem 1rem;
    border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: all .2s ease;
}
.pk-filter-btn--primary {
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff;
    box-shadow: 0 2px 8px rgba(184,150,110,.3);
}
.pk-filter-btn--primary:hover { filter: brightness(1.1); transform: translateY(-1px); }
.pk-filter-btn--ghost {
    background: transparent;
    color: var(--pk-muted);
    border: 1px solid rgba(0,0,0,.1);
}
.pk-filter-btn--ghost:hover { background: #F4EFE8; color: var(--pk-dark); }

/* Legend */
.pk-legend { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
.pk-legend-item {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .75rem;
    font-weight: 500;
    padding: .28rem .65rem;
    border-radius: 99px;
}
.pk-legend-item::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    display: inline-block;
}
.pk-legend--tersedia { background: #d1fae5; color: #065f46; }
.pk-legend--tersedia::before { background: #22c55e; }
.pk-legend--terisi   { background: #dbeafe; color: #1e40af; }
.pk-legend--terisi::before   { background: #3b82f6; }
.pk-legend--bersih   { background: #fef3c7; color: #92400e; }
.pk-legend--bersih::before   { background: #f59e0b; }
.pk-legend--maint    { background: #fee2e2; color: #991b1b; }
.pk-legend--maint::before    { background: #ef4444; }

/* ============================================================
   TABLE CARD
   ============================================================ */
.pk-card {
    background: #FDFBF8;
    border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius);
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.05);
    animation: pkFadeUp .6s .1s ease both;
}
.pk-card__body { padding: 1.25rem 1.5rem; overflow-x: auto; }

.pk-table { width: 100%; border-collapse: collapse; font-size: .875rem; }

.pk-th {
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--pk-muted);
    padding: .65rem 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(184,150,110,.18);
    white-space: nowrap;
}
.pk-th--no { width: 48px; text-align: center; }

.pk-row {
    border-bottom: 1px solid rgba(184,150,110,.08);
    transition: background .18s ease;
}
.pk-row:last-child { border-bottom: none; }
.pk-row:hover { background: rgba(184,150,110,.04); }

.pk-td {
    padding: .85rem 1rem;
    color: var(--pk-dark);
    vertical-align: middle;
}
.pk-td--no {
    text-align: center;
    font-size: .78rem;
    font-weight: 600;
    color: var(--pk-muted);
}

/* Room cell */
.pk-room-cell { display: flex; align-items: center; gap: .6rem; }
.pk-room-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(184,150,110,.1);
    color: var(--pk-gold-d);
    flex-shrink: 0;
}
.pk-room-icon svg { width:16px; height:16px; }
.pk-room-num { font-weight: 600; color: var(--pk-dark); letter-spacing: .02em; }

/* Type badge */
.pk-tipe-badge {
    display: inline-block;
    padding: .25rem .75rem;
    background: rgba(184,150,110,.1);
    color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.2);
    border-radius: 99px;
    font-size: .78rem;
    font-weight: 600;
}

/* Status badge */
.pk-status {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .3rem .8rem;
    border-radius: 99px;
    font-size: .78rem;
    font-weight: 600;
}
.pk-status__dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}
.pk-status--tersedia { background: #d1fae5; color: #065f46; }
.pk-status--terisi   { background: #dbeafe; color: #1e40af; }
.pk-status--bersih   { background: #fef3c7; color: #92400e; }
.pk-status--maint    { background: #fee2e2; color: #991b1b; }
.pk-status--default  { background: #f1f5f9; color: #64748b; }

/* ============================================================
   MODAL
   ============================================================ */
.pk-modal-dialog .modal-content,
.pk-modal { border: none; border-radius: var(--pk-radius); overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,.18); }

.pk-modal__header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.35rem 1.5rem 1rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2A2620 100%);
    border-bottom: 1px solid rgba(184,150,110,.15);
    position: relative;
}
.pk-modal__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px; height: 40px;
    border-radius: 10px;
    flex-shrink: 0;
}
.pk-modal__icon svg { width: 20px; height: 20px; }
.pk-modal__icon--add {
    background: rgba(184,150,110,.2);
    color: var(--pk-gold-l);
    border: 1px solid rgba(184,150,110,.3);
}
.pk-modal__title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.1rem;
    color: var(--pk-white);
    margin: 0 0 .15rem;
}
.pk-modal__sub {
    font-size: .78rem;
    color: rgba(232,224,212,.55);
    margin: 0;
}
.pk-modal__close {
    position: absolute;
    top: 1rem; right: 1rem;
    width: 28px; height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(184,150,110,.2);
    border-radius: 6px;
    background: transparent;
    color: rgba(232,224,212,.5);
    cursor: pointer;
    transition: all .2s ease;
    padding: 0;
}
.pk-modal__close svg { width: 14px; height: 14px; }
.pk-modal__close:hover { background: rgba(184,150,110,.15); color: var(--pk-gold-l); }

.pk-modal__body { padding: 1.5rem; background: #FDFBF8; display: flex; flex-direction: column; gap: 1.1rem; }
.pk-modal__footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .75rem;
    padding: 1rem 1.5rem;
    background: #F7F3EE;
    border-top: 1px solid rgba(184,150,110,.12);
}

/* Fields */
.pk-field { display: flex; flex-direction: column; gap: .45rem; }
.pk-label {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .8rem;
    font-weight: 600;
    letter-spacing: .04em;
    color: var(--pk-dark);
}
.pk-label svg { width: 14px; height: 14px; color: var(--pk-gold); }

.pk-input,
.pk-select {
    font-family: 'DM Sans', sans-serif;
    font-size: .875rem;
    color: var(--pk-dark);
    background: #fff;
    border: 1.5px solid rgba(184,150,110,.22);
    border-radius: var(--pk-radius-sm);
    padding: .6rem .9rem;
    outline: none;
    transition: border-color .2s ease, box-shadow .2s ease;
    width: 100%;
}
.pk-input:focus,
.pk-select:focus {
    border-color: var(--pk-gold);
    box-shadow: 0 0 0 3px rgba(184,150,110,.15);
}
.pk-input::placeholder { color: #c0b8b0; }

/* Status radio picker */
.pk-status-picker {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .5rem;
}
.pk-radio-opt {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .55rem .85rem;
    border-radius: var(--pk-radius-sm);
    cursor: pointer;
    font-size: .82rem;
    font-weight: 500;
    border: 1.5px solid transparent;
    transition: all .18s ease;
}
.pk-radio-opt input[type=radio] { accent-color: var(--pk-gold); }
.pk-radio-opt--tersedia { background: #f0fdf4; color: #065f46; border-color: #bbf7d0; }
.pk-radio-opt--terisi   { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
.pk-radio-opt--bersih   { background: #fffbeb; color: #92400e; border-color: #fde68a; }
.pk-radio-opt--maint    { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
.pk-radio-opt:has(input:checked) { filter: brightness(.93); font-weight: 700; }

/* Modal Buttons */
.pk-modal-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.25rem;
    border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .2s ease;
    text-decoration: none;
}
.pk-modal-btn--cancel {
    background: transparent;
    color: var(--pk-muted);
    border: 1px solid rgba(0,0,0,.1);
}
.pk-modal-btn--cancel:hover { background: #eee; color: var(--pk-dark); }
.pk-modal-btn--save {
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff;
    box-shadow: 0 2px 10px rgba(184,150,110,.35);
}
.pk-modal-btn--save:hover { filter: brightness(1.08); transform: translateY(-1px); }

/* ============================================================
   ANIMATION
   ============================================================ */
@keyframes pkFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 640px) {
    .pk-page-header { flex-direction: column; align-items: flex-start; }
    .pk-filter-bar  { flex-direction: column; align-items: stretch; }
    .pk-legend      { display: none; }
    .pk-status-picker { grid-template-columns: 1fr; }
    .pk-page-title  { font-size: 1.6rem; }
}
</style>
@endpush