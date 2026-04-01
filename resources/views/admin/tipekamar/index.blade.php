@extends('layouts.admin')

@section('content')

{{-- ===== PAGE HEADING ===== --}}
<div class="tk-page-heading mb-4">
    <div class="tk-heading-inner">
        <div>
            <span class="tk-label-badge">
                <span class="tk-badge-dot"></span> Manajemen Kamar
            </span>
            <h3 class="tk-title">Daftar Tipe Kamar</h3>
            <p class="tk-subtitle">Kelola seluruh tipe kamar, harga, dan fasilitas hotel.</p>
        </div>
        <button class="tk-btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTipe">
            <span class="tk-btn-icon">＋</span>
            <span>Tambah Tipe Kamar</span>
        </button>
    </div>
</div>

{{-- ===== MAIN CARD ===== --}}
<section class="section">
    <div class="tk-card">
        <div class="tk-card-inner">
            <table class="table table-hover align-middle mb-0" id="tableTipeKamar">
                <thead>
                    <tr class="tk-thead-row">
                        <th class="tk-th">No</th>
                        <th class="tk-th">Nama Tipe</th>
                        <th class="tk-th">Harga / Malam</th>
                        <th class="tk-th">Deskripsi</th>
                        <th class="tk-th">Foto</th>
                        <th class="tk-th text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipeKamar as $index => $tipe)
                        <tr class="tk-tbody-row">
                            <td class="tk-td">
                                <span class="tk-row-num">{{ $index + 1 }}</span>
                            </td>
                            <td class="tk-td">
                                <span class="tk-nama">{{ $tipe->nama }}</span>
                            </td>
                            <td class="tk-td">
                                <span class="tk-price-badge">
                                    Rp {{ number_format($tipe->harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="tk-td">
                                <span class="tk-desc-text">{{ Str::limit($tipe->deskripsi, 32) }}</span>
                            </td>
                            <td class="tk-td">
                                @if($tipe->foto)
                                    <div class="tk-foto-wrap">
                                        <img src="{{ asset('uploads/tipekamar/' . $tipe->foto) }}"
                                             width="80" height="52"
                                             style="object-fit:cover;"
                                             class="tk-foto">
                                    </div>
                                @else
                                    <span class="tk-no-foto">—</span>
                                @endif
                            </td>
                            <td class="tk-td text-end">
                                <div class="tk-action-group">
                                    <button class="tk-btn-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditTipe{{ $tipe->id }}">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.tipekamar.destroy', $tipe->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="tk-btn-hapus"
                                                onclick="return confirm('Yakin ingin menghapus tipe kamar ini?')">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- ===== MODAL EDIT ===== --}}
                        <div class="modal fade" id="modalEditTipe{{ $tipe->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered tk-modal-dialog">
                                <div class="modal-content tk-modal-content">
                                    <form action="{{ route('admin.tipekamar.update', $tipe->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="tk-modal-header">
                                            <div class="tk-modal-title-wrap">
                                                <div class="tk-modal-icon tk-icon-edit">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </div>
                                                <h5 class="tk-modal-title">Edit Tipe Kamar</h5>
                                            </div>
                                            <button type="button" class="tk-modal-close" data-bs-dismiss="modal" aria-label="Tutup">✕</button>
                                        </div>
                                        <div class="modal-body tk-modal-body">
                                            <div class="tk-field">
                                                <label class="tk-label">Nama Tipe Kamar</label>
                                                <input type="text" name="nama" class="tk-input" value="{{ $tipe->nama }}" required placeholder="cth. Deluxe, Suite...">
                                            </div>
                                            <div class="tk-field">
                                                <label class="tk-label">Harga per Malam</label>
                                                <div class="tk-input-prefix-wrap">
                                                    <span class="tk-input-prefix">Rp</span>
                                                    <input type="number" name="harga" class="tk-input tk-input-prefixed" value="{{ $tipe->harga }}" required placeholder="0">
                                                </div>
                                            </div>
                                            <div class="tk-field">
                                                <label class="tk-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="tk-input tk-textarea" rows="3" placeholder="Deskripsi singkat fasilitas kamar...">{{ $tipe->deskripsi }}</textarea>
                                            </div>
                                            <div class="tk-field">
                                                <label class="tk-label">Foto Baru <span class="tk-label-hint">(opsional — biarkan kosong jika tidak ingin ganti)</span></label>
                                                <div class="tk-file-zone">
                                                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    <span>Klik atau seret foto ke sini</span>
                                                    <input type="file" name="foto" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tk-modal-footer">
                                            <button type="button" class="tk-btn-cancel" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="tk-btn-submit">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                                Update
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
<div class="modal fade" id="modalTambahTipe" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered tk-modal-dialog">
        <div class="modal-content tk-modal-content">
            <form action="{{ route('admin.tipekamar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tk-modal-header">
                    <div class="tk-modal-title-wrap">
                        <div class="tk-modal-icon tk-icon-add">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                        <h5 class="tk-modal-title">Tambah Tipe Kamar</h5>
                    </div>
                    <button type="button" class="tk-modal-close" data-bs-dismiss="modal" aria-label="Tutup">✕</button>
                </div>
                <div class="modal-body tk-modal-body">
                    <div class="tk-field">
                        <label class="tk-label">Nama Tipe Kamar</label>
                        <input type="text" name="nama" class="tk-input" required placeholder="cth. Deluxe, Suite, Standard...">
                    </div>
                    <div class="tk-field">
                        <label class="tk-label">Harga per Malam</label>
                        <div class="tk-input-prefix-wrap">
                            <span class="tk-input-prefix">Rp</span>
                            <input type="number" name="harga" class="tk-input tk-input-prefixed" required placeholder="0">
                        </div>
                    </div>
                    <div class="tk-field">
                        <label class="tk-label">Deskripsi</label>
                        <textarea name="deskripsi" class="tk-input tk-textarea" rows="3" placeholder="Deskripsi singkat fasilitas kamar..."></textarea>
                    </div>
                    <div class="tk-field">
                        <label class="tk-label">Foto Kamar</label>
                        <div class="tk-file-zone">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span>Klik atau seret foto ke sini</span>
                            <input type="file" name="foto" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="tk-modal-footer">
                    <button type="button" class="tk-btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="tk-btn-submit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
/* ===== VARIABLES ===== */
:root {
    --tk-gold:       #c9a84c;
    --tk-gold-light: #f0d98a;
    --tk-gold-pale:  #fdf6e3;
    --tk-dark:       #1a1a2e;
    --tk-slate:      #2d3561;
    --tk-text:       #374151;
    --tk-muted:      #8b95a3;
    --tk-border:     #e8ecf0;
    --tk-surface:    #ffffff;
    --tk-bg:         #f5f7fa;
    --tk-radius:     14px;
    --tk-shadow:     0 4px 24px rgba(26,26,46,.07);
    --tk-shadow-md:  0 8px 40px rgba(26,26,46,.12);
}

/* ===== PAGE HEADING ===== */
.tk-page-heading {
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.tk-heading-inner {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.tk-label-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--tk-gold);
    background: var(--tk-gold-pale);
    border: 1px solid #ecdca0;
    padding: 4px 11px;
    border-radius: 999px;
    margin-bottom: 10px;
}
.tk-badge-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--tk-gold);
    animation: tk-pulse 1.8s ease-in-out infinite;
}
@keyframes tk-pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.5; transform:scale(1.4); }
}
.tk-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.9rem;
    color: var(--tk-dark);
    margin: 0 0 4px;
    line-height: 1.15;
}
.tk-subtitle {
    font-size: 13.5px;
    color: var(--tk-muted);
    margin: 0;
}

/* ===== PRIMARY BUTTON ===== */
.tk-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: linear-gradient(135deg, var(--tk-dark) 0%, var(--tk-slate) 100%);
    color: #fff;
    border: none;
    border-radius: var(--tk-radius);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s ease;
    box-shadow: 0 4px 16px rgba(26,26,46,.25);
    white-space: nowrap;
}
.tk-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26,26,46,.35);
}
.tk-btn-icon {
    width: 22px; height: 22px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(255,255,255,.15);
    border-radius: 6px;
    font-size: 15px;
    line-height: 1;
}

/* ===== MAIN CARD ===== */
.tk-card {
    background: var(--tk-surface);
    border-radius: var(--tk-radius);
    box-shadow: var(--tk-shadow);
    border: 1px solid var(--tk-border);
    overflow: hidden;
    animation: tk-fadeUp .45s ease both;
}
@keyframes tk-fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.tk-card-inner {
    overflow-x: auto;
}

/* ===== TABLE ===== */
.tk-thead-row { background: #f8f9fb; }
.tk-th {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--tk-muted);
    padding: 14px 18px !important;
    border-bottom: 2px solid var(--tk-border) !important;
    white-space: nowrap;
}
.tk-tbody-row {
    transition: background .18s ease;
}
.tk-tbody-row:hover { background: #fafbfc; }
.tk-td {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--tk-text);
    padding: 14px 18px !important;
    border-bottom: 1px solid var(--tk-border) !important;
    vertical-align: middle !important;
}
.tk-row-num {
    display: inline-flex;
    align-items: center; justify-content: center;
    width: 26px; height: 26px;
    background: var(--tk-bg);
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    color: var(--tk-muted);
}
.tk-nama {
    font-weight: 600;
    color: var(--tk-dark);
}
.tk-price-badge {
    display: inline-block;
    padding: 4px 10px;
    background: var(--tk-gold-pale);
    color: #8a6200;
    border: 1px solid #ecdca0;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    white-space: nowrap;
}
.tk-desc-text {
    color: var(--tk-muted);
    font-size: 13px;
}
.tk-foto-wrap {
    border-radius: 10px;
    overflow: hidden;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}
.tk-foto {
    display: block;
    transition: transform .3s ease;
    border-radius: 10px;
}
.tk-foto:hover { transform: scale(1.06); }
.tk-no-foto {
    color: var(--tk-border);
    font-size: 18px;
}

/* ===== ACTION BUTTONS ===== */
.tk-action-group {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.tk-btn-edit,
.tk-btn-hapus {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    border: none;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}
.tk-btn-edit {
    background: #fff8ec;
    color: #92620a;
    border: 1px solid #f0d08a;
}
.tk-btn-edit:hover {
    background: #f9edd2;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(201,168,76,.25);
}
.tk-btn-hapus {
    background: #fff5f5;
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.tk-btn-hapus:hover {
    background: #fee2e2;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(220,38,38,.18);
}

/* ===== MODAL ===== */
.tk-modal-dialog { max-width: 500px; }
.tk-modal-content {
    border: none;
    border-radius: var(--tk-radius);
    box-shadow: 0 20px 60px rgba(26,26,46,.18);
    overflow: hidden;
}
.tk-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--tk-border);
    background: #fafafa;
}
.tk-modal-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}
.tk-modal-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
}
.tk-icon-edit  { background: #fff8ec; color: #92620a; border: 1px solid #f0d08a; }
.tk-icon-add   { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.tk-modal-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: var(--tk-dark);
    margin: 0;
}
.tk-modal-close {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    background: var(--tk-bg);
    border: 1px solid var(--tk-border);
    border-radius: 8px;
    color: var(--tk-muted);
    font-size: 13px;
    cursor: pointer;
    transition: all .18s ease;
    line-height: 1;
}
.tk-modal-close:hover {
    background: #fee2e2;
    border-color: #fecaca;
    color: #b91c1c;
}
.tk-modal-body {
    padding: 22px 24px !important;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.tk-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid var(--tk-border);
    background: #fafafa;
}

/* ===== FORM FIELDS ===== */
.tk-field { display: flex; flex-direction: column; gap: 6px; }
.tk-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--tk-text);
    letter-spacing: .01em;
}
.tk-label-hint {
    font-weight: 400;
    color: var(--tk-muted);
    font-size: 11.5px;
}
.tk-input {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--tk-dark);
    background: #fff;
    border: 1.5px solid var(--tk-border);
    border-radius: 10px;
    padding: 10px 14px;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    width: 100%;
}
.tk-input:focus {
    border-color: var(--tk-gold);
    box-shadow: 0 0 0 3px rgba(201,168,76,.12);
}
.tk-input::placeholder { color: #bdc5cd; }
.tk-textarea { resize: vertical; min-height: 80px; }

/* Input prefix Rp */
.tk-input-prefix-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--tk-border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}
.tk-input-prefix-wrap:focus-within {
    border-color: var(--tk-gold);
    box-shadow: 0 0 0 3px rgba(201,168,76,.12);
}
.tk-input-prefix {
    padding: 10px 13px;
    background: #f5f7fa;
    color: var(--tk-muted);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    border-right: 1.5px solid var(--tk-border);
    white-space: nowrap;
}
.tk-input-prefixed {
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    flex: 1;
}

/* File zone */
.tk-file-zone {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 20px;
    border: 1.5px dashed #d1d9e0;
    border-radius: 10px;
    background: #fafbfc;
    color: var(--tk-muted);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    cursor: pointer;
    transition: all .2s ease;
    text-align: center;
}
.tk-file-zone:hover {
    border-color: var(--tk-gold);
    background: var(--tk-gold-pale);
    color: #8a6200;
}
.tk-file-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

/* Modal footer buttons */
.tk-btn-cancel {
    padding: 9px 20px;
    border: 1.5px solid var(--tk-border);
    border-radius: 9px;
    background: #fff;
    color: var(--tk-muted);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .18s ease;
}
.tk-btn-cancel:hover {
    background: var(--tk-bg);
    color: var(--tk-text);
}
.tk-btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 22px;
    background: linear-gradient(135deg, var(--tk-dark) 0%, var(--tk-slate) 100%);
    color: #fff;
    border: none;
    border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(26,26,46,.25);
    transition: all .22s ease;
}
.tk-btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(26,26,46,.35);
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new simpleDatatables.DataTable(document.getElementById('tableTipeKamar'));
    });
</script>
@endpush