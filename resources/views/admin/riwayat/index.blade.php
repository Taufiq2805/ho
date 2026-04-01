@extends('layouts.admin')

@section('title', 'Riwayat Sewa')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Hotel
        </span>
        <h1 class="pk-page-title">Riwayat Sewa</h1>
        <p class="pk-page-sub">Lihat seluruh riwayat sewa dan detail transaksi tamu hotel.</p>
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
                        <th class="pk-th">Nama Tamu</th>
                        <th class="pk-th">Kamar</th>
                        <th class="pk-th">Check-in</th>
                        <th class="pk-th">Check-out</th>
                        <th class="pk-th">Total Harga</th>
                        <th class="pk-th">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $i => $r)
                        @php
                            $res         = $r->reservasi;
                            $hargaMalam  = ($res->kamar->tipe->harga ?? 0) + ($res->paket->harga ?? $res->paket_harga ?? 0);
                            $in          = \Carbon\Carbon::parse($res->tanggal_checkin);
                            $out         = \Carbon\Carbon::parse($res->tanggal_checkout);
                            $lama        = max($in->diffInDays($out), 1);
                            $roomTotal   = $lama * $hargaMalam;
                            $makananTotal = $res->makanans->sum(fn($m) => ($m->pivot->harga ?? $m->harga ?? 0) * ($m->pivot->qty ?? 1));
                            $total       = $r->total ?? ($roomTotal + $makananTotal);
                        @endphp

                        <tr class="pk-row">
                            <td class="pk-td pk-td--no">{{ $i + 1 }}</td>

                            <td class="pk-td">
                                <div class="pk-user-cell">
                                    <div class="pk-avatar">{{ strtoupper(substr($res->nama_tamu, 0, 2)) }}</div>
                                    <span class="pk-room-num">{{ $res->nama_tamu }}</span>
                                </div>
                            </td>

                            <td class="pk-td">
                                <span class="pk-tipe-badge">{{ $res->kamar->nomor_kamar }}</span>
                            </td>

                            <td class="pk-td">
                                <span class="pk-time-badge pk-time-badge--start">
                                    <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                                        <rect x="1.5" y="2.5" width="11" height="10" rx="1.3" stroke="currentColor" stroke-width="1.2"/>
                                        <path d="M4.5 1.5v2M9.5 1.5v2M1.5 5.5h11" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                    </svg>
                                    {{ $in->format('d M Y') }}
                                </span>
                            </td>

                            <td class="pk-td">
                                <span class="pk-time-badge pk-time-badge--end">
                                    <svg viewBox="0 0 14 14" fill="none" width="11" height="11">
                                        <rect x="1.5" y="2.5" width="11" height="10" rx="1.3" stroke="currentColor" stroke-width="1.2"/>
                                        <path d="M4.5 1.5v2M9.5 1.5v2M1.5 5.5h11" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                    </svg>
                                    {{ $out->format('d M Y') }}
                                </span>
                            </td>

                            <td class="pk-td">
                                <span style="font-weight:600; color:var(--pk-gold-d); font-size:.875rem;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="pk-td">
                                <button class="pk-tipe-badge"
                                        style="cursor:pointer; border:none;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail-{{ $r->id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                    @empty
                        <tr class="pk-row">
                            <td colspan="7" class="pk-empty-state">
                                <svg viewBox="0 0 40 40" fill="none" width="36" height="36">
                                    <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                                    <rect x="12" y="11" width="16" height="18" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                                    <path d="M15 17h10M15 21h7M15 25h5" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                                </svg>
                                <span>Belum ada riwayat sewa.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- 
    SEMUA MODAL DI LUAR TABEL
    Modal di dalam <tr> tidak valid — browser akan buang elemen modal dari DOM
    sehingga Bootstrap tidak bisa menemukannya dan tombol close tidak bekerja.
--}}
@foreach($riwayats as $r)
    @php
        $res          = $r->reservasi;
        $hargaMalam   = ($res->kamar->tipe->harga ?? 0) + ($res->paket->harga ?? $res->paket_harga ?? 0);
        $in           = \Carbon\Carbon::parse($res->tanggal_checkin);
        $out          = \Carbon\Carbon::parse($res->tanggal_checkout);
        $lama         = max($in->diffInDays($out), 1);
        $roomTotal    = $lama * $hargaMalam;
        $makananTotal = $res->makanans->sum(fn($m) => ($m->pivot->harga ?? $m->harga ?? 0) * ($m->pivot->qty ?? 1));
        $total        = $r->total ?? ($roomTotal + $makananTotal);
    @endphp

    <div class="modal fade" id="modalDetail-{{ $r->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
            <div class="modal-content pk-modal">

                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M8 9h8M8 13h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Detail Riwayat Sewa</h5>
                        <p class="pk-modal__sub">{{ $res->nama_tamu }} · Kamar {{ $res->kamar->nomor_kamar }}</p>
                    </div>
                    <button type="button" class="pk-modal__close" data-bs-dismiss="modal">
                        <svg viewBox="0 0 20 20" fill="none">
                            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="pk-modal__body">

                    {{-- Info Tamu --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <circle cx="8" cy="6" r="3" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M2 14c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Informasi Tamu
                        </label>
                        <div class="pk-detail-box">
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Nama Tamu</span>
                                <span class="pk-detail-val">{{ $res->nama_tamu }}</span>
                            </div>
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Nomor Kamar</span>
                                <span class="pk-detail-val">{{ $res->kamar->nomor_kamar }}</span>
                            </div>
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Tipe Kamar</span>
                                <span class="pk-detail-val">{{ $res->kamar->tipe->nama }}</span>
                            </div>
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Harga per Malam</span>
                                <span class="pk-detail-val">Rp {{ number_format($hargaMalam, 0, ',', '.') }}</span>
                            </div>
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Lama Menginap</span>
                                <span class="pk-tipe-badge" style="font-size:.75rem; padding:.15rem .6rem;">{{ $lama }} malam</span>
                            </div>
                        </div>
                    </div>

                    {{-- Makanan --}}
                    @if($res->makanans->count() > 0)
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <path d="M5 2v5a3 3 0 006 0V2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <path d="M8 9v5M5 14h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Pesanan Makanan
                        </label>
                        <div class="pk-detail-box">
                            @foreach($res->makanans as $m)
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">
                                    {{ $m->nama }}
                                    <span style="color:var(--pk-gold-d); font-weight:600;">×{{ $m->pivot->qty ?? 1 }}</span>
                                </span>
                                <span class="pk-detail-val">
                                    Rp {{ number_format(($m->pivot->harga ?? $m->harga) * ($m->pivot->qty ?? 1), 0, ',', '.') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Ringkasan Biaya --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="2" width="12" height="12" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M5 8h6M5 10.5h3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                            Ringkasan Biaya
                        </label>
                        <div class="pk-detail-box">
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Subtotal Kamar</span>
                                <span class="pk-detail-val">Rp {{ number_format($roomTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="pk-detail-row">
                                <span class="pk-detail-key">Subtotal Makanan</span>
                                <span class="pk-detail-val">Rp {{ number_format($makananTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="pk-detail-row pk-detail-row--total">
                                <span style="font-weight:700; color:var(--pk-dark);">Total</span>
                                <span style="font-weight:700; color:var(--pk-gold-d); font-size:.95rem;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    @if($r->catatan)
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <path d="M3 4h10M3 7h10M3 10h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Catatan
                        </label>
                        <div class="pk-input" style="color:var(--pk-muted); font-size:.855rem;">{{ $r->catatan }}</div>
                    </div>
                    @endif

                </div>

                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
@endforeach

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('#table1')) {
            new simpleDatatables.DataTable(document.querySelector('#table1'));
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

.pk-empty-state {
    padding: 3rem 1rem !important; text-align: center; color: var(--pk-muted);
    font-size: .88rem; display: flex; flex-direction: column;
    align-items: center; gap: .75rem;
}

/* Modal */
.pk-modal-dialog .modal-content,
.pk-modal {
    border: none; border-radius: var(--pk-radius); overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.18);
}
.pk-modal__header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.35rem 1.5rem 1rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2A2620 100%);
    border-bottom: 1px solid rgba(184,150,110,.15); position: relative;
}
.pk-modal__icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
}
.pk-modal__icon svg { width: 20px; height: 20px; }
.pk-modal__icon--add {
    background: rgba(184,150,110,.2); color: var(--pk-gold-l);
    border: 1px solid rgba(184,150,110,.3);
}
.pk-modal__title {
    font-family: 'DM Serif Display', serif; font-size: 1.1rem;
    color: var(--pk-white); margin: 0 0 .15rem;
}
.pk-modal__sub { font-size: .78rem; color: rgba(232,224,212,.55); margin: 0; }
.pk-modal__close {
    position: absolute; top: 1rem; right: 1rem;
    width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
    border: 1px solid rgba(184,150,110,.2); border-radius: 6px;
    background: transparent; color: rgba(232,224,212,.5);
    cursor: pointer; transition: all .2s ease; padding: 0;
}
.pk-modal__close svg { width: 14px; height: 14px; }
.pk-modal__close:hover { background: rgba(184,150,110,.15); color: var(--pk-gold-l); }
.pk-modal__body {
    padding: 1.5rem; background: #FDFBF8;
    display: flex; flex-direction: column; gap: 1.1rem;
}
.pk-modal__footer {
    display: flex; align-items: center; justify-content: flex-end;
    gap: .75rem; padding: 1rem 1.5rem;
    background: #F7F3EE; border-top: 1px solid rgba(184,150,110,.12);
}

/* Field & Label */
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
}

/* Detail box (khusus modal riwayat) */
.pk-detail-box {
    display: flex; flex-direction: column;
    background: #fff; border: 1.5px solid rgba(184,150,110,.18);
    border-radius: var(--pk-radius-sm); overflow: hidden;
}
.pk-detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: .55rem .9rem; font-size: .855rem;
    border-bottom: 1px solid rgba(184,150,110,.08);
}
.pk-detail-row:last-child { border-bottom: none; }
.pk-detail-row--total {
    padding-top: .65rem; padding-bottom: .65rem;
    border-top: 1.5px solid rgba(184,150,110,.15);
    background: rgba(184,150,110,.04);
}
.pk-detail-key { color: var(--pk-muted); }
.pk-detail-val { font-weight: 600; color: var(--pk-dark); }

/* Button */
.pk-modal-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .6rem 1.25rem; border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s ease;
}
.pk-modal-btn--cancel { background: transparent; color: var(--pk-muted); border: 1px solid rgba(0,0,0,.1); }
.pk-modal-btn--cancel:hover { background: #eee; color: var(--pk-dark); }

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