@extends('layouts.admin')

@section('title', 'Data Shift')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen SDM
        </span>
        <h1 class="pk-page-title">Daftar Shift</h1>
        <p class="pk-page-sub">Kelola jadwal shift kerja seluruh staf hotel.</p>
    </div>
    <button class="pk-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahShift">
        <span class="pk-btn-add__icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah Shift
    </button>
</div>

{{-- ALERT --}}
@if(session('success'))
<div class="pk-alert pk-alert--success">
    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="10" cy="10" r="7.5" stroke="currentColor" stroke-width="1.5"/>
        <path d="M6.5 10.5l2.5 2.5 4.5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="tableShift">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Nama Shift</th>
                        <th class="pk-th">Jam Mulai</th>
                        <th class="pk-th">Jam Selesai</th>
                        <th class="pk-th">Durasi</th>
                        <th class="pk-th pk-th--action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $index => $shift)
                        <tr class="pk-row">
                            <td class="pk-td pk-td--no">{{ $index + 1 }}</td>
                            <td class="pk-td">
                                <div class="pk-room-cell">
                                    <span class="pk-room-icon">
                                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M10 6.5v3.8l2.5 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    <span class="pk-room-num">{{ $shift->nama_shift }}</span>
                                </div>
                            </td>
                            <td class="pk-td">
                                <span class="pk-time-badge pk-time-badge--start">
                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
                                        <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                        <path d="M8 5.5V8l1.8 1.3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    </svg>
                                    {{ $shift->jam_mulai }}
                                </span>
                            </td>
                            <td class="pk-td">
                                <span class="pk-time-badge pk-time-badge--end">
                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
                                        <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                        <path d="M8 5.5V8l1.8 1.3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    </svg>
                                    {{ $shift->jam_selesai }}
                                </span>
                            </td>
                            <td class="pk-td">
                                @php
                                    try {
                                        $mulai    = \Carbon\Carbon::createFromFormat('H:i:s', $shift->jam_mulai);
                                        $selesai  = \Carbon\Carbon::createFromFormat('H:i:s', $shift->jam_selesai);
                                        $diff     = $mulai->diffInMinutes($selesai);
                                        if ($diff < 0) $diff += 1440;
                                        $jam      = intdiv($diff, 60);
                                        $menit    = $diff % 60;
                                        $durasi   = $jam . 'j' . ($menit ? ' ' . $menit . 'm' : '');
                                    } catch(\Exception $e) {
                                        $durasi = '—';
                                    }
                                @endphp
                                <span class="pk-tipe-badge">{{ $durasi }}</span>
                            </td>
                            <td class="pk-td">
                                <div class="pk-action-group">
                                    <button class="pk-action-btn pk-action-btn--edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditShift{{ $shift->id }}"
                                            title="Edit Shift">
                                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.5 2.5a1.414 1.414 0 012 2L5 13H3v-2L11.5 2.5z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.shift.destroy', $shift->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="pk-action-btn pk-action-btn--del"
                                                onclick="return confirm('Yakin ingin menghapus shift ini?')"
                                                title="Hapus Shift">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 4.5h10M6 4.5V3h4v1.5M6.5 7v4M9.5 7v4M4 4.5l.7 8h6.6l.7-8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="modalEditShift{{ $shift->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
                                <div class="modal-content pk-modal">
                                    <form action="{{ route('admin.shift.update', $shift->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="pk-modal__header">
                                            <div class="pk-modal__icon pk-modal__icon--edit">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16 3.5a2.121 2.121 0 013 3L7 19H4v-3L16 3.5z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="pk-modal__title">Edit Shift</h5>
                                                <p class="pk-modal__sub">Ubah detail jadwal shift ini</p>
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
                                                        <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                                        <path d="M8 5.5V8l1.8 1.3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                    </svg>
                                                    Nama Shift
                                                </label>
                                                <input type="text" name="nama_shift" class="pk-input"
                                                       value="{{ $shift->nama_shift }}"
                                                       placeholder="Contoh: Shift Pagi…" required>
                                            </div>
                                            <div class="pk-time-row">
                                                <div class="pk-field">
                                                    <label class="pk-label">
                                                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3 8.5L8 4l5 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <rect x="5.5" y="8" width="5" height="5" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                                                        </svg>
                                                        Jam Mulai
                                                    </label>
                                                    <input type="time" name="jam_mulai" class="pk-input pk-input--time"
                                                           value="{{ $shift->jam_mulai }}" required>
                                                </div>
                                                <div class="pk-time-sep">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5 12h14M14 7l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="pk-field">
                                                    <label class="pk-label">
                                                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3 7.5L8 12l5-4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <rect x="5.5" y="3" width="5" height="5" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                                                        </svg>
                                                        Jam Selesai
                                                    </label>
                                                    <input type="time" name="jam_selesai" class="pk-input pk-input--time"
                                                           value="{{ $shift->jam_selesai }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pk-modal__footer">
                                            <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                                                    <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Update Shift
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahShift" tabindex="-1" aria-labelledby="modalTambahShiftLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
        <div class="modal-content pk-modal">
            <form action="{{ route('admin.shift.store') }}" method="POST">
                @csrf
                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Tambah Shift Baru</h5>
                        <p class="pk-modal__sub">Isi detail jadwal shift di bawah ini</p>
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
                                <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M8 5.5V8l1.8 1.3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Nama Shift
                        </label>
                        <input type="text" name="nama_shift" class="pk-input"
                               placeholder="Contoh: Shift Pagi, Shift Malam…" required>
                    </div>
                    <div class="pk-time-row">
                        <div class="pk-field">
                            <label class="pk-label">
                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 8.5L8 4l5 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="5.5" y="8" width="5" height="5" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                                </svg>
                                Jam Mulai
                            </label>
                            <input type="time" name="jam_mulai" class="pk-input pk-input--time" required>
                        </div>
                        <div class="pk-time-sep">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12h14M14 7l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="pk-field">
                            <label class="pk-label">
                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 7.5L8 12l5-4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="5.5" y="3" width="5" height="5" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                                </svg>
                                Jam Selesai
                            </label>
                            <input type="time" name="jam_selesai" class="pk-input pk-input--time" required>
                        </div>
                    </div>
                </div>

                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan Shift
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
        new simpleDatatables.DataTable(document.querySelector('#tableShift'));
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
   ALERT
   ============================================================ */
.pk-alert {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .75rem 1.1rem;
    border-radius: var(--pk-radius-sm);
    font-size: .85rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: pkFadeUp .4s ease both;
}
.pk-alert svg { width: 18px; height: 18px; flex-shrink: 0; }
.pk-alert--success {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

/* ============================================================
   TABLE CARD
   ============================================================ */
.pk-card {
    background: #FDFBF8;
    border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius);
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.05);
    animation: pkFadeUp .55s .08s ease both;
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
.pk-th--no     { width: 48px; text-align: center; }
.pk-th--action { text-align: center; }

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

/* Room/shift cell */
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

/* Time badge */
.pk-time-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .28rem .72rem;
    border-radius: 99px;
    font-size: .8rem;
    font-weight: 600;
    font-variant-numeric: tabular-nums;
    letter-spacing: .03em;
}
.pk-time-badge--start {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}
.pk-time-badge--end {
    background: #fdf4ff;
    color: #7e22ce;
    border: 1px solid #e9d5ff;
}

/* Action group */
.pk-action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
}
.pk-action-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .38rem .85rem;
    border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .2s ease;
    white-space: nowrap;
}
.pk-action-btn svg { width: 13px; height: 13px; }
.pk-action-btn--edit {
    background: rgba(184,150,110,.12);
    color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.25);
}
.pk-action-btn--edit:hover {
    background: rgba(184,150,110,.22);
    color: var(--pk-gold-d);
    transform: translateY(-1px);
}
.pk-action-btn--del {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.pk-action-btn--del:hover {
    background: #fee2e2;
    transform: translateY(-1px);
}

/* ============================================================
   MODAL
   ============================================================ */
.pk-modal-dialog .modal-content,
.pk-modal {
    border: none;
    border-radius: var(--pk-radius);
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.18);
}

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
.pk-modal__icon--edit {
    background: rgba(251,191,36,.15);
    color: #fbbf24;
    border: 1px solid rgba(251,191,36,.25);
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
.pk-modal__close:hover {
    background: rgba(184,150,110,.15);
    color: var(--pk-gold-l);
}

.pk-modal__body {
    padding: 1.5rem;
    background: #FDFBF8;
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}
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

/* Time input accent */
.pk-input--time {
    color-scheme: light;
    font-variant-numeric: tabular-nums;
    letter-spacing: .04em;
}
.pk-input--time::-webkit-calendar-picker-indicator {
    opacity: .5;
    cursor: pointer;
    filter: sepia(1) saturate(3) hue-rotate(5deg);
}

/* Time row layout */
.pk-time-row {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: end;
    gap: .5rem;
}
.pk-time-sep {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: .55rem;
    color: var(--pk-muted);
}
.pk-time-sep svg { width: 18px; height: 18px; }

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
    .pk-page-header  { flex-direction: column; align-items: flex-start; }
    .pk-page-title   { font-size: 1.6rem; }
    .pk-time-row     { grid-template-columns: 1fr; }
    .pk-time-sep     { display: none; }
    .pk-action-group { flex-direction: column; align-items: stretch; }
}
</style>
@endpush