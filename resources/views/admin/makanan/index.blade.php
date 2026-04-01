@extends('layouts.admin')

@section('content')

{{-- PAGE HEADING --}}
<div class="pk-page-header">
    <div class="pk-page-header__left">
        <span class="pk-eyebrow">
            <span class="pk-eyebrow__dot"></span>
            Manajemen Restoran
        </span>
        <h1 class="pk-page-title">Daftar Menu Makanan</h1>
        <p class="pk-page-sub">Kelola seluruh menu makanan beserta harga dan fotonya.</p>
    </div>
    <button class="pk-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahMakanan">
        <span class="pk-btn-add__icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah Makanan
    </button>
</div>

{{-- SESSION ALERT --}}
@if(session('success'))
    <div class="pk-alert pk-alert--success">
        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- TABLE CARD --}}
<section class="section">
    <div class="pk-card">
        <div class="pk-card__body">
            <table class="pk-table" id="tableMakanan">
                <thead>
                    <tr>
                        <th class="pk-th pk-th--no">No</th>
                        <th class="pk-th">Nama Menu</th>
                        <th class="pk-th">Harga</th>
                        <th class="pk-th">Deskripsi</th>
                        <th class="pk-th">Foto</th>
                        <th class="pk-th pk-th--action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($makanan as $index => $item)
                        <tr class="pk-row">
                            <td class="pk-td pk-td--no">{{ $index + 1 }}</td>

                            {{-- Nama --}}
                            <td class="pk-td">
                                <div class="pk-room-cell">
                                    <span class="pk-room-icon">
                                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 3v5a4 4 0 008 0V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M8 8v9M12 3v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M14 6a2 2 0 000-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                    <span class="pk-room-num">{{ $item->nama }}</span>
                                </div>
                            </td>

                            {{-- Harga --}}
                            <td class="pk-td">
                                <span class="pk-tipe-badge">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="pk-td pk-td--muted">{{ Str::limit($item->deskripsi, 40) }}</td>

                            {{-- Foto --}}
                            <td class="pk-td">
                                @if($item->foto)
                                    <div class="pk-foto-wrap">
                                        <img src="{{ asset('uploads/makanan/' . $item->foto) }}" alt="{{ $item->nama }}" class="pk-foto">
                                    </div>
                                @else
                                    <span class="pk-no-foto">
                                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                                            <rect x="2" y="4" width="16" height="12" rx="2" stroke="currentColor" stroke-width="1.4"/>
                                            <circle cx="7.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.4"/>
                                            <path d="M2 14l4-4 3 3 3-4 4 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Tidak ada
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="pk-td">
                                <div class="pk-action-group">
                                    <button class="pk-action-btn pk-action-btn--edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditMakanan{{ $item->id }}">
                                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
                                            <path d="M11.5 2.5a1.414 1.414 0 012 2L5 13H3v-2L11.5 2.5z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.makanan.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="pk-action-btn pk-action-btn--delete"
                                                onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
                                                <path d="M3 4.5h10M6 4.5V3h4v1.5M5.5 4.5l.5 8h4l.5-8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- ===== MODAL EDIT ===== --}}
                        <div class="modal fade" id="modalEditMakanan{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
                                <div class="modal-content pk-modal">
                                    <form action="{{ route('admin.makanan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="pk-modal__header">
                                            <div class="pk-modal__icon pk-modal__icon--edit">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16 3l5 5L8 21H3v-5L16 3z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="pk-modal__title">Edit Menu Makanan</h5>
                                                <p class="pk-modal__sub">Perbarui detail item: <strong style="color:var(--pk-gold-l)">{{ $item->nama }}</strong></p>
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
                                                        <path d="M4 3v5a4 4 0 008 0V3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                        <path d="M8 8v5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                    </svg>
                                                    Nama Menu
                                                </label>
                                                <input type="text" name="nama" class="pk-input" value="{{ $item->nama }}" required>
                                            </div>
                                            <div class="pk-field">
                                                <label class="pk-label">
                                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                                        <path d="M8 5v3l2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                    </svg>
                                                    Harga (Rp)
                                                </label>
                                                <input type="number" name="harga" class="pk-input" value="{{ $item->harga }}" required>
                                            </div>
                                            <div class="pk-field">
                                                <label class="pk-label">
                                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2 4h12M2 8h8M2 12h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                                    </svg>
                                                    Deskripsi
                                                </label>
                                                <textarea name="deskripsi" class="pk-input pk-textarea" rows="3">{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="pk-field">
                                                <label class="pk-label">
                                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="1" y="3" width="14" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                                        <circle cx="5.5" cy="6.5" r="1.2" stroke="currentColor" stroke-width="1.3"/>
                                                        <path d="M1 11l3.5-3.5L8 11l3-3.5 4 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Foto Baru <span class="pk-label-opt">(opsional)</span>
                                                </label>
                                                <input type="file" name="foto" class="pk-input pk-file-input" accept="image/*">
                                                @if($item->foto)
                                                    <div class="pk-current-foto">
                                                        <img src="{{ asset('uploads/makanan/' . $item->foto) }}" alt="Foto saat ini" class="pk-current-foto__img">
                                                        <span class="pk-current-foto__label">Foto saat ini</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="pk-modal__footer">
                                            <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                                                    <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Update Menu
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

{{-- ===== MODAL TAMBAH ===== --}}
<div class="modal fade" id="modalTambahMakanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pk-modal-dialog">
        <div class="modal-content pk-modal">
            <form action="{{ route('admin.makanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="pk-modal__header">
                    <div class="pk-modal__icon pk-modal__icon--add">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="pk-modal__title">Tambah Menu Baru</h5>
                        <p class="pk-modal__sub">Isi detail item makanan di bawah ini</p>
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
                                <path d="M4 3v5a4 4 0 008 0V3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <path d="M8 8v5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Nama Menu
                        </label>
                        <input type="text" name="nama" class="pk-input" placeholder="Contoh: Nasi Goreng Spesial…" required>
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M8 5v3l2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Harga (Rp)
                        </label>
                        <input type="number" name="harga" class="pk-input" placeholder="Contoh: 35000" required>
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 4h12M2 8h8M2 12h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" class="pk-input pk-textarea" rows="3" placeholder="Deskripsi singkat menu…"></textarea>
                    </div>
                    <div class="pk-field">
                        <label class="pk-label">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1" y="3" width="14" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                <circle cx="5.5" cy="6.5" r="1.2" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M1 11l3.5-3.5L8 11l3-3.5 4 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Foto Menu
                        </label>
                        <input type="file" name="foto" class="pk-input pk-file-input" accept="image/*">
                    </div>
                </div>
                <div class="pk-modal__footer">
                    <button type="button" class="pk-modal-btn pk-modal-btn--cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="pk-modal-btn pk-modal-btn--save">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                            <path d="M4 10.5l4.5 4.5 7.5-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new simpleDatatables.DataTable(document.getElementById('tableMakanan'));
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
    gap: .6rem;
    padding: .75rem 1.1rem;
    border-radius: var(--pk-radius-sm);
    font-size: .85rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: pkFadeUp .4s ease both;
}
.pk-alert--success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
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
.pk-td--muted {
    font-size: .82rem;
    color: var(--pk-muted);
    max-width: 220px;
}

/* Room-cell style reuse for food name */
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

/* Price badge (reusing tipe-badge style) */
.pk-tipe-badge {
    display: inline-block;
    padding: .25rem .75rem;
    background: rgba(184,150,110,.1);
    color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.2);
    border-radius: 99px;
    font-size: .78rem;
    font-weight: 600;
    white-space: nowrap;
}

/* Foto */
.pk-foto-wrap {
    width: 72px; height: 50px;
    border-radius: var(--pk-radius-sm);
    overflow: hidden;
    border: 1px solid var(--pk-border);
    background: #F4EFE8;
}
.pk-foto {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
}
.pk-foto-wrap:hover .pk-foto { transform: scale(1.08); }

.pk-no-foto {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .75rem;
    color: var(--pk-muted);
    background: #F4EFE8;
    border: 1px dashed var(--pk-border);
    border-radius: var(--pk-radius-sm);
    padding: .3rem .6rem;
}

/* Action Buttons */
.pk-action-group {
    display: flex;
    align-items: center;
    gap: .45rem;
    justify-content: center;
}
.pk-action-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .35rem .75rem;
    border-radius: var(--pk-radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all .2s ease;
    white-space: nowrap;
}
.pk-action-btn--edit {
    background: rgba(184,150,110,.1);
    color: var(--pk-gold-d);
    border-color: rgba(184,150,110,.25);
}
.pk-action-btn--edit:hover {
    background: rgba(184,150,110,.2);
    color: var(--pk-dark-2);
    transform: translateY(-1px);
}
.pk-action-btn--delete {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
}
.pk-action-btn--delete:hover {
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
.pk-label-opt {
    font-weight: 400;
    color: var(--pk-muted);
    font-size: .75rem;
    margin-left: .15rem;
}

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
.pk-input:focus { border-color: var(--pk-gold); box-shadow: 0 0 0 3px rgba(184,150,110,.15); }
.pk-input::placeholder { color: #c0b8b0; }
.pk-textarea { resize: vertical; min-height: 80px; }

/* File input */
.pk-file-input {
    padding: .45rem .75rem;
    cursor: pointer;
}
.pk-file-input::file-selector-button {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    background: rgba(184,150,110,.12);
    color: var(--pk-gold-d);
    border: 1px solid rgba(184,150,110,.25);
    border-radius: 6px;
    padding: .3rem .7rem;
    margin-right: .6rem;
    cursor: pointer;
    transition: background .2s ease;
}
.pk-file-input::file-selector-button:hover { background: rgba(184,150,110,.22); }

/* Current foto preview */
.pk-current-foto {
    display: flex;
    align-items: center;
    gap: .6rem;
    margin-top: .4rem;
}
.pk-current-foto__img {
    width: 56px; height: 40px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--pk-border);
}
.pk-current-foto__label {
    font-size: .75rem;
    color: var(--pk-muted);
}

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
    .pk-page-header   { flex-direction: column; align-items: flex-start; }
    .pk-page-title    { font-size: 1.6rem; }
    .pk-action-group  { flex-direction: column; }
    .pk-td--muted     { display: none; }
}
</style>
@endpush