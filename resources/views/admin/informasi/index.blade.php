@extends('layouts.admin')

@section('title', 'Informasi Fasilitas Hotel')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Hotel
        </span>
        <h1 class="pk-page-title">Informasi Fasilitas</h1>
        <p class="pk-page-sub">Kelola seluruh informasi dan fasilitas yang tersedia di hotel.</p>
    </div>
    <button class="pk-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahInformasi">
        <span class="pk-btn-add__icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah Informasi
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
        <svg viewBox="0 0 20 20" fill="none" width="13" height="13">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
        </svg>
    </button>
</div>
@endif

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="tableInformasi">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Nama</th>
                        <th class="pk-th">Deskripsi</th>
                        <th class="pk-th">Foto</th>
                        <th class="pk-th">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($informasi as $index => $item)
                    <tr class="pk-row">
                        <td class="pk-td pk-td--no">{{ $index + 1 }}</td>

                        {{-- Nama --}}
                        <td class="pk-td">
                            <div class="pk-user-cell">
                                <div class="pk-avatar" data-initials="{{ strtoupper(substr($item->nama, 0, 2)) }}">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                <span class="pk-room-num">{{ $item->nama }}</span>
                            </div>
                        </td>

                        {{-- Deskripsi --}}
                        <td class="pk-td">
                            <span class="pk-email">{{ Str::limit($item->deskripsi, 60) }}</span>
                        </td>

                        {{-- Foto --}}
                        <td class="pk-td">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                     width="80" height="50"
                                     style="object-fit:cover; border-radius:8px; border:1.5px solid rgba(184,150,110,.18);">
                            @else
                                <span class="pk-no-shift">—</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="pk-td">
                            <div style="display:flex; gap:.45rem;">
                                <button class="pk-tipe-badge"
                                        style="cursor:pointer; border:none;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditInformasi{{ $item->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.informasi.destroy', $item->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="pk-tipe-badge"
                                            style="cursor:pointer; border:none; background:rgba(239,68,68,.1); color:#b91c1c; border:1px solid rgba(239,68,68,.2);">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="modalEditInformasi{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
                            <div class="modal-content pk-modal">
                                <form action="{{ route('admin.informasi.update', $item->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="pk-modal__header">
                                        <div class="pk-modal__icon pk-modal__icon--add">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 3l5 5-11 11H5v-5L16 3z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="pk-modal__title">Edit Informasi</h5>
                                            <p class="pk-modal__sub">Perbarui data fasilitas hotel</p>
                                        </div>
                                        <button type="button" class="pk-modal__close" data-bs-dismiss="modal">
                                            <svg viewBox="0 0 20 20" fill="none">
                                                <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pk-modal__body">
                                        <div class="pk-field">
                                            <label class="pk-label">
                                                <svg viewBox="0 0 16 16" fill="none">
                                                    <circle cx="8" cy="6" r="3" stroke="currentColor" stroke-width="1.3"/>
                                                    <path d="M2 14c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                </svg>
                                                Nama
                                            </label>
                                            <input type="text" name="nama" class="pk-input"
                                                   value="{{ $item->nama }}" required>
                                        </div>

                                        <div class="pk-field">
                                            <label class="pk-label">
                                                <svg viewBox="0 0 16 16" fill="none">
                                                    <path d="M3 4h10M3 7h10M3 10h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                </svg>
                                                Deskripsi
                                            </label>
                                            <textarea name="deskripsi" class="pk-input"
                                                      rows="3"
                                                      style="resize:vertical; min-height:80px;">{{ $item->deskripsi }}</textarea>
                                        </div>

                                        <div class="pk-field">
                                            <label class="pk-label">
                                                <svg viewBox="0 0 16 16" fill="none">
                                                    <rect x="1.5" y="3" width="13" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                                    <circle cx="6" cy="8" r="1.8" stroke="currentColor" stroke-width="1.2"/>
                                                    <path d="M1.5 11l3.5-3 2.5 2.5 2.5-3 4 3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Foto Baru <span style="font-weight:400;color:var(--pk-muted);margin-left:.2rem;">(opsional)</span>
                                            </label>
                                            <input type="file" name="foto" class="pk-input" style="padding:.45rem .9rem;">
                                            @if($item->foto)
                                                <span class="pk-no-shift" style="font-size:.77rem;">
                                                    Foto saat ini: {{ basename($item->foto) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="pk-modal__footer">
                                        <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                                            <svg viewBox="0 0 20 20" fill="none" width="16" height="16">
                                                <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr class="pk-row">
                        <td colspan="5" class="pk-empty-state">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
                                <circle cx="20" cy="20" r="18" stroke="#D4B896" stroke-width="1.5" stroke-dasharray="4 3"/>
                                <rect x="12" y="13" width="16" height="14" rx="2" stroke="#D4B896" stroke-width="1.4"/>
                                <path d="M15 18h10M15 22h6" stroke="#D4B896" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            <span>Belum ada data informasi.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahInformasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
        <div class="modal-content pk-modal">
            <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Tambah Informasi Baru</h5>
                        <p class="pk-modal__sub">Isi data fasilitas hotel di bawah ini</p>
                    </div>
                    <button type="button" class="pk-modal__close" data-bs-dismiss="modal">
                        <svg viewBox="0 0 20 20" fill="none">
                            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="pk-modal__body">
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <circle cx="8" cy="6" r="3" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M2 14c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Nama
                        </label>
                        <input type="text" name="nama" class="pk-input"
                               placeholder="Contoh: Kolam Renang, Spa, Restoran" required>
                    </div>

                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <path d="M3 4h10M3 7h10M3 10h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" class="pk-input"
                                  rows="3"
                                  style="resize:vertical; min-height:80px;"
                                  placeholder="Jelaskan fasilitas secara singkat…"></textarea>
                    </div>

                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none">
                                <rect x="1.5" y="3" width="13" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                <circle cx="6" cy="8" r="1.8" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M1.5 11l3.5-3 2.5 2.5 2.5-3 4 3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Foto
                        </label>
                        <input type="file" name="foto" class="pk-input" style="padding:.45rem .9rem;">
                    </div>
                </div>

                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                        <svg viewBox="0 0 20 20" fill="none" width="16" height="16">
                            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan Informasi
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
        if (document.querySelector('#tableInformasi')) {
            new simpleDatatables.DataTable(document.querySelector('#tableInformasi'));
        }
    });
</script>
@endpush

@push('styles')
<style>
{{-- COPY PASTE PERSIS dari halaman User -- tidak ada yang ditambah atau dikurangi --}}
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

.pk-btn-add {
    display: inline-flex; align-items: center; gap: .6rem;
    padding: .65rem 1.3rem;
    background: linear-gradient(135deg, #1C1A17 0%, #2E2A22 100%);
    color: var(--pk-gold-l); border: 1px solid var(--pk-border);
    border-radius: var(--pk-radius); font-family: 'DM Sans', sans-serif;
    font-size: .85rem; font-weight: 600; cursor: pointer; white-space: nowrap;
    transition: all .25s ease; box-shadow: 0 2px 12px rgba(0,0,0,.18);
}
.pk-btn-add:hover {
    background: linear-gradient(135deg, #252219 0%, #3A3428 100%);
    color: var(--pk-gold); box-shadow: 0 6px 22px rgba(184,150,110,.2);
    transform: translateY(-2px);
}
.pk-btn-add__icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; background: rgba(184,150,110,.15); border-radius: 6px;
}
.pk-btn-add__icon svg { width: 14px; height: 14px; }

.pk-alert {
    display: flex; align-items: center; gap: .65rem;
    padding: .8rem 1.1rem; border-radius: var(--pk-radius-sm);
    font-size: .85rem; font-weight: 500; margin-bottom: 1.25rem;
    animation: pkFadeUp .4s ease both; position: relative;
}
.pk-alert--success { background: #f0fdf4; color: #065f46; border: 1px solid #bbf7d0; }
.pk-alert__close {
    margin-left: auto; display: flex; align-items: center; justify-content: center;
    background: transparent; border: none; cursor: pointer;
    color: #065f46; opacity: .5; padding: 2px; border-radius: 4px; transition: opacity .2s;
}
.pk-alert__close:hover { opacity: 1; }

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

.pk-email {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .83rem; color: var(--pk-muted);
}

.pk-tipe-badge {
    display: inline-block; padding: .25rem .75rem;
    background: rgba(184,150,110,.1); color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.2); border-radius: 99px;
    font-size: .78rem; font-weight: 600;
}

.pk-no-shift { color: var(--pk-muted); font-size: .88rem; }

.pk-empty-state {
    padding: 3rem 1rem !important; text-align: center; color: var(--pk-muted);
    font-size: .88rem; display: flex; flex-direction: column;
    align-items: center; gap: .75rem;
}

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

.pk-field { display: flex; flex-direction: column; gap: .45rem; }
.pk-label {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .8rem; font-weight: 600; letter-spacing: .04em; color: var(--pk-dark);
}
.pk-label svg { width: 14px; height: 14px; color: var(--pk-gold); }
.pk-input, .pk-select {
    font-family: 'DM Sans', sans-serif; font-size: .875rem; color: var(--pk-dark);
    background: #fff; border: 1.5px solid rgba(184,150,110,.22);
    border-radius: var(--pk-radius-sm); padding: .6rem .9rem;
    outline: none; transition: border-color .2s ease, box-shadow .2s ease; width: 100%;
}
.pk-input:focus, .pk-select:focus {
    border-color: var(--pk-gold); box-shadow: 0 0 0 3px rgba(184,150,110,.15);
}
.pk-input::placeholder { color: #c0b8b0; }

.pk-modal-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .6rem 1.25rem; border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s ease;
}
.pk-modal-btn--cancel { background: transparent; color: var(--pk-muted); border: 1px solid rgba(0,0,0,.1); }
.pk-modal-btn--cancel:hover { background: #eee; color: var(--pk-dark); }
.pk-modal-btn--save {
    background: linear-gradient(135deg, var(--pk-gold-d), var(--pk-gold));
    color: #fff; box-shadow: 0 2px 10px rgba(184,150,110,.35);
}
.pk-modal-btn--save:hover { filter: brightness(1.08); transform: translateY(-1px); }

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