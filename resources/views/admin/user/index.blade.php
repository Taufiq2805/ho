@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen SDM
        </span>
        <h1 class="pk-page-title">Manajemen User</h1>
        <p class="pk-page-sub">Kelola seluruh akun staf hotel beserta role dan jadwal shift.</p>
    </div>
    <button class="pk-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <span class="pk-btn-add__icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah User
    </button>
</div>

{{-- ALERT --}}
@if(session('success'))
<div class="pk-alert pk-alert--success" role="alert">
    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
        <circle cx="10" cy="10" r="8" stroke="#22c55e" stroke-width="1.6"/>
        <path d="M6.5 10.5l2.5 2.5 4.5-5" stroke="#22c55e" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    {{ session('success') }}
    <button type="button" class="pk-alert__close" onclick="this.parentElement.remove()">
        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
        </svg>
    </button>
</div>
@endif

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="table1">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Pengguna</th>
                        <th class="pk-th">Email</th>
                        <th class="pk-th">Role</th>
                        <th class="pk-th">Shift</th>
                        <th class="pk-th">Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $index + 1 }}</td>

                        {{-- User Cell --}}
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar" data-initials="{{ strtoupper(substr($user->name, 0, 2)) }}">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="pk-room-num">{{ $user->name }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="pk-td">
                            <span class="pk-email">
                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
                                    <rect x="1.5" y="3.5" width="13" height="9" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                    <path d="M1.5 5.5l6.5 4 6.5-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                {{ $user->email }}
                            </span>
                        </td>

                        {{-- Role --}}
                        <td class="pk-td">
                            @php
                                $roleMap = match($user->role) {
                                    'resepsionis'  => ['cls' => 'pk-role--resepsionis',  'label' => 'Resepsionis'],
                                    'housekeeping' => ['cls' => 'pk-role--housekeeping', 'label' => 'Housekeeping'],
                                    'admin'        => ['cls' => 'pk-role--admin',        'label' => 'Admin'],
                                    default        => ['cls' => 'pk-role--default',      'label' => ucfirst($user->role)],
                                };
                            @endphp
                            <span class="pk-role-badge {{ $roleMap['cls'] }}">{{ $roleMap['label'] }}</span>
                        </td>

                        {{-- Shift --}}
                        <td class="pk-td">
                            @if($user->shift)
                                <span class="pk-tipe-badge">{{ $user->shift->nama_shift }}</span>
                            @else
                                <span class="pk-no-shift">—</span>
                            @endif
                        </td>

                        {{-- Jam Kerja --}}
                        <td class="pk-td">
                            @if($user->shift)
                                <div class="pk-jamkerja">
                                    <span class="pk-time-badge pk-time-badge--start">
                                        <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" width="11" height="11">
                                            <circle cx="7" cy="7" r="5.2" stroke="currentColor" stroke-width="1.3"/>
                                            <path d="M7 4.5V7l1.8 1.4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($user->shift->jam_mulai)->format('H:i') }}
                                    </span>
                                    <span class="pk-time-sep">→</span>
                                    <span class="pk-time-badge pk-time-badge--end">
                                        <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" width="11" height="11">
                                            <circle cx="7" cy="7" r="5.2" stroke="currentColor" stroke-width="1.3"/>
                                            <path d="M7 4.5V7l1.8 1.4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($user->shift->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            @else
                                <span class="pk-no-shift">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="pk-row">
                        <td colspan="6" class="pk-empty-state">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
                                <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                                <circle cx="20" cy="16" r="5" stroke="#D4B896" stroke-width="1.4"/>
                                <path d="M10 31c0-5.523 4.477-10 10-10s10 4.477 10 10" stroke="#D4B896" stroke-width="1.4" stroke-linecap="round"/>
                            </svg>
                            <span>Belum ada data user.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
        <div class="modal-content pk-modal">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M19 3v6M16 6h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Tambah User Baru</h5>
                        <p class="pk-modal__sub">Isi data akun staf di bawah ini</p>
                    </div>
                    <button type="button" class="pk-modal__close" data-bs-dismiss="modal" aria-label="Tutup">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="pk-modal__body">

                    {{-- Nama --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="6" r="3" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M2 14c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" class="pk-input" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    {{-- Email --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1.5" y="3.5" width="13" height="9" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M1.5 5.5l6.5 4 6.5-4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Alamat Email
                        </label>
                        <input type="email" name="email" class="pk-input" placeholder="nama@hotel.com" required>
                    </div>

                    {{-- Password --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="7" width="10" height="7" rx="1.2" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M5.5 7V5.5a2.5 2.5 0 015 0V7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <circle cx="8" cy="10.5" r="1" fill="currentColor"/>
                            </svg>
                            Password
                        </label>
                        <div class="pk-input-pw-wrap">
                            <input type="password" name="password" id="pwInput" class="pk-input pk-input--pw" placeholder="Minimal 8 karakter" required>
                            <button type="button" class="pk-pw-toggle" onclick="
                                var i=document.getElementById('pwInput');
                                i.type=i.type==='password'?'text':'password';
                                this.classList.toggle('pk-pw-toggle--show');
                            ">
                                <svg class="pk-pw-eye" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                                    <path d="M1.5 10S4.5 4 10 4s8.5 6 8.5 6-3 6-8.5 6S1.5 10 1.5 10z" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 13V6.5L8 3l6 3.5V13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="5.5" y="9" width="5" height="4" rx=".8" stroke="currentColor" stroke-width="1.3"/>
                            </svg>
                            Role Jabatan
                        </label>
                        <div class="pk-role-picker">
                            <label class="pk-radio-opt pk-radio-opt--resepsionis">
                                <input type="radio" name="role" value="resepsionis" required>
                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                                    <rect x="2" y="4" width="12" height="9" rx="1.3" stroke="currentColor" stroke-width="1.3"/>
                                    <path d="M5 4V3a3 3 0 016 0v1" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    <path d="M5 8h6M5 10.5h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                <span>Resepsionis</span>
                            </label>
                            <label class="pk-radio-opt pk-radio-opt--housekeeping">
                                <input type="radio" name="role" value="housekeeping">
                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                                    <path d="M3 13l1.5-5h7L13 13H3z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                                    <path d="M6 8V6a2 2 0 014 0v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    <path d="M1.5 8h13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                </svg>
                                <span>Housekeeping</span>
                            </label>
                        </div>
                    </div>

                    {{-- Shift --}}
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M8 5v3l2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Jadwal Shift
                        </label>
                        <select name="shift_id" class="pk-select" required>
                            <option value="">— Pilih Shift —</option>
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->id }}">
                                    {{ $shift->nama_shift }}
                                    ({{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan User
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
        if (document.querySelector('#table1')) {
            new simpleDatatables.DataTable(document.querySelector('#table1'));
        }
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
.pk-page-sub { font-size: .85rem; color: var(--pk-muted); margin: 0; }

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
.pk-btn-add__icon svg { width: 14px; height: 14px; }

/* ============================================================
   ALERT
   ============================================================ */
.pk-alert {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .8rem 1.1rem;
    border-radius: var(--pk-radius-sm);
    font-size: .85rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: pkFadeUp .4s ease both;
    position: relative;
}
.pk-alert--success {
    background: #f0fdf4;
    color: #065f46;
    border: 1px solid #bbf7d0;
}
.pk-alert__close {
    margin-left: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    cursor: pointer;
    color: #065f46;
    opacity: .5;
    padding: 2px;
    border-radius: 4px;
    transition: opacity .2s;
}
.pk-alert__close:hover { opacity: 1; }

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
.pk-td--no { text-align: center; font-size: .78rem; font-weight: 600; color: var(--pk-muted); }

/* ============================================================
   USER CELL — Avatar
   ============================================================ */
.pk-user-cell { display: flex; align-items: center; gap: .7rem; }

.pk-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .04em;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(184,150,110,.3);
    user-select: none;
}

.pk-room-num { font-weight: 600; color: var(--pk-dark); letter-spacing: .02em; }

/* ============================================================
   EMAIL
   ============================================================ */
.pk-email {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .83rem;
    color: var(--pk-muted);
}

/* ============================================================
   ROLE BADGE
   ============================================================ */
.pk-role-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .28rem .75rem;
    border-radius: 99px;
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .02em;
}
.pk-role-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.pk-role--resepsionis  { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.pk-role--resepsionis::before  { background: #3b82f6; }
.pk-role--housekeeping { background: #f0fdf4; color: #065f46; border: 1px solid #bbf7d0; }
.pk-role--housekeeping::before { background: #22c55e; }
.pk-role--admin        { background: #fdf4ff; color: #6b21a8; border: 1px solid #e9d5ff; }
.pk-role--admin::before        { background: #a855f7; }
.pk-role--default      { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
.pk-role--default::before      { background: #94a3b8; }

/* ============================================================
   TIPE BADGE (reuse for shift name)
   ============================================================ */
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

/* ============================================================
   JAM KERJA
   ============================================================ */
.pk-jamkerja { display: flex; align-items: center; gap: .35rem; flex-wrap: wrap; }
.pk-time-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .24rem .6rem;
    border-radius: 6px;
    font-size: .77rem;
    font-weight: 600;
    font-variant-numeric: tabular-nums;
}
.pk-time-badge--start { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.pk-time-badge--end   { background: #faf5ff; color: #6d28d9; border: 1px solid #ddd6fe; }
.pk-time-sep { font-size: .78rem; color: var(--pk-muted); }
.pk-no-shift { color: var(--pk-muted); font-size: .88rem; }

/* ============================================================
   EMPTY STATE
   ============================================================ */
.pk-empty-state {
    padding: 3rem 1rem !important;
    text-align: center;
    color: var(--pk-muted);
    font-size: .88rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
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
.pk-modal__title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.1rem;
    color: var(--pk-white);
    margin: 0 0 .15rem;
}
.pk-modal__sub { font-size: .78rem; color: rgba(232,224,212,.55); margin: 0; }
.pk-modal__close {
    position: absolute;
    top: 1rem; right: 1rem;
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
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

/* Password toggle */
.pk-input-pw-wrap { position: relative; }
.pk-input--pw { padding-right: 2.8rem; }
.pk-pw-toggle {
    position: absolute;
    right: .65rem;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--pk-muted);
    display: flex;
    align-items: center;
    padding: 0;
    transition: color .2s;
}
.pk-pw-toggle:hover { color: var(--pk-gold); }
.pk-pw-toggle--show .pk-pw-eye { opacity: .5; }

/* ============================================================
   ROLE PICKER (radio)
   ============================================================ */
.pk-role-picker {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .5rem;
}
.pk-radio-opt {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .6rem .9rem;
    border-radius: var(--pk-radius-sm);
    cursor: pointer;
    font-size: .82rem;
    font-weight: 500;
    border: 1.5px solid transparent;
    transition: all .18s ease;
}
.pk-radio-opt input[type=radio] { accent-color: var(--pk-gold); flex-shrink: 0; }
.pk-radio-opt--resepsionis  { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
.pk-radio-opt--housekeeping { background: #f0fdf4; color: #065f46; border-color: #bbf7d0; }
.pk-radio-opt:has(input:checked) { filter: brightness(.93); font-weight: 700; }

/* ============================================================
   MODAL BUTTONS
   ============================================================ */
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
    .pk-page-title  { font-size: 1.6rem; }
    .pk-role-picker { grid-template-columns: 1fr; }
    .pk-jamkerja    { flex-direction: column; align-items: flex-start; gap: .25rem; }
    .pk-time-sep    { display: none; }
}
</style>
@endpush