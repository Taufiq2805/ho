@extends('layouts.housekeeping')

@section('title', 'Data Pengeluaran')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
  :root {
    --bg:        #0d1b2a;
    --surface:   #132236;
    --card:      #1a2e47;
    --card-hover:#1f3654;
    --accent1:   #38bdf8;
    --accent2:   #34d399;
    --accent3:   #fb923c;
    --accent4:   #f87171;
    --accent5:   #a78bfa;
    --text:      #e2eaf4;
    --muted:     #7b93b0;
    --border:    rgba(255,255,255,0.07);
    --input-bg:  #0f1e30;
  }

  .hk-body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text);
  }

  /* ── Page Heading ── */
  .page-heading { margin-bottom: 28px; animation: hkFadeUp 0.45s ease both; }
  .page-heading .eyebrow {
    font-size: 11px; font-weight: 600; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--accent1);
    display: flex; align-items: center; gap: 8px; margin-bottom: 6px;
  }
  .page-heading .eyebrow::before {
    content: ''; display: block; width: 20px; height: 2px;
    background: var(--accent1); border-radius: 2px;
  }
  .page-heading h3 {
    font-size: 26px; font-weight: 800; letter-spacing: -0.4px; color: #fff; margin: 0;
  }
  .page-heading p { font-size: 14px; color: var(--muted); margin-top: 4px; margin-bottom: 0; }

  /* ── Alert ── */
  .hk-alert {
    background: rgba(52,211,153,0.12);
    border: 1px solid rgba(52,211,153,0.25);
    color: var(--accent2);
    border-radius: 12px;
    padding: 12px 18px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    animation: hkFadeUp 0.4s ease both;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .hk-alert::before {
    content: '';
    display: block;
    width: 8px; height: 8px;
    background: var(--accent2);
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* ── Add Button ── */
  .btn-hk-add {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--accent1); color: #0d1b2a;
    border: none; border-radius: 10px;
    padding: 9px 18px; font-size: 13px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: opacity .2s, transform .2s;
    margin-bottom: 20px;
    animation: hkFadeUp 0.5s ease both;
    animation-delay: 0.1s;
  }
  .btn-hk-add:hover { opacity: .85; transform: translateY(-1px); }
  .btn-hk-add svg { width: 15px; height: 15px; stroke-width: 2.5; }

  /* ── Table Card ── */
  .hk-table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    animation: hkFadeUp 0.5s ease both;
    animation-delay: 0.15s;
  }

  .hk-table-card table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .hk-table-card thead tr {
    border-bottom: 1px solid var(--border);
  }

  .hk-table-card thead th {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 14px 18px;
    white-space: nowrap;
  }

  .hk-table-card tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .18s;
  }
  .hk-table-card tbody tr:last-child { border-bottom: none; }
  .hk-table-card tbody tr:hover { background: rgba(255,255,255,0.03); }

  .hk-table-card tbody td {
    padding: 14px 18px;
    font-size: 13px;
    color: var(--text);
    vertical-align: middle;
  }

  /* ── No column ── */
  .td-no {
    font-size: 11px; font-weight: 700;
    color: var(--muted);
    width: 40px;
  }

  /* ── User avatar ── */
  .hk-user {
    display: flex; align-items: center; gap: 9px;
  }
  .hk-avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(56,189,248,0.15);
    color: var(--accent1);
    font-size: 11px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
  }
  .hk-user-name { font-size: 13px; font-weight: 600; color: var(--text); }

  /* ── Room badge ── */
  .hk-room-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(167,139,250,0.13);
    color: var(--accent5);
    font-size: 11px; font-weight: 700;
    padding: 4px 10px; border-radius: 8px;
    letter-spacing: 0.03em;
  }
  .hk-room-badge svg { width: 11px; height: 11px; stroke-width: 2.5; }

  /* ── Item list ── */
  .hk-item-list { display: flex; flex-direction: column; gap: 2px; }
  .hk-item-line { font-size: 13px; color: var(--text); line-height: 1.5; }
  .hk-item-qty {
    display: inline-block; margin-top: 4px;
    font-size: 10.5px; font-weight: 700;
    color: var(--muted);
    background: rgba(255,255,255,0.05);
    padding: 2px 8px; border-radius: 6px;
    letter-spacing: 0.04em;
  }

  /* ── Date ── */
  .hk-date {
    font-size: 12px; font-weight: 600;
    color: var(--muted);
    white-space: nowrap;
  }

  /* ── Amount ── */
  .hk-amount {
    font-size: 14px; font-weight: 800;
    color: var(--accent2);
    letter-spacing: -0.3px;
    white-space: nowrap;
  }
  .hk-amount .cur {
    font-size: 10px; font-weight: 600;
    color: var(--muted);
    vertical-align: top; margin-top: 3px; margin-right: 2px;
  }

  /* ── Action buttons ── */
  .hk-actions { display: flex; align-items: center; gap: 6px; }
  .hk-btn-action {
    width: 32px; height: 32px;
    border-radius: 9px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: opacity .18s, transform .18s;
    flex-shrink: 0;
  }
  .hk-btn-action:hover { opacity: .8; transform: translateY(-1px); }
  .hk-btn-action svg { width: 14px; height: 14px; stroke-width: 2.2; }
  .hk-btn-action.edit   { background: rgba(52,211,153,0.15);  color: var(--accent2); }
  .hk-btn-action.delete { background: rgba(248,113,113,0.15); color: var(--accent4); }

  /* ── Empty state ── */
  .hk-empty {
    text-align: center; padding: 52px 20px;
    color: var(--muted); font-size: 13px;
  }
  .hk-empty svg {
    width: 40px; height: 40px; stroke-width: 1.4;
    color: rgba(123,147,176,0.3);
    display: block; margin: 0 auto 14px;
  }

  /* ── Modal ── */
  .modal-content {
    background: var(--card) !important;
    border: 1px solid var(--border) !important;
    border-radius: 20px !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text);
  }
  .modal-header {
    border-bottom: 1px solid var(--border) !important;
    padding: 20px 24px !important;
  }
  .modal-title {
    font-size: 16px !important;
    font-weight: 800 !important;
    color: #fff !important;
    letter-spacing: -0.2px;
  }
  .btn-close {
    filter: invert(1) !important;
    opacity: 0.5 !important;
  }
  .btn-close:hover { opacity: 0.9 !important; }

  .modal-body { padding: 22px 24px !important; }
  .modal-footer {
    border-top: 1px solid var(--border) !important;
    padding: 16px 24px !important;
    gap: 8px;
  }

  /* ── Form labels ── */
  .hk-form-label {
    font-size: 11px; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 7px; display: block;
  }

  /* ── Inputs ── */
  .hk-form-control,
  .hk-form-select {
    width: 100%;
    background: var(--input-bg) !important;
    border: 1px solid var(--border) !important;
    border-radius: 10px !important;
    color: var(--text) !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px !important;
    padding: 10px 13px !important;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none;
    appearance: none;
  }
  .hk-form-control:focus,
  .hk-form-select:focus {
    border-color: var(--accent1) !important;
    box-shadow: 0 0 0 3px rgba(56,189,248,0.12) !important;
  }
  .hk-form-control[readonly] {
    color: var(--accent2) !important;
    font-weight: 700 !important;
    background: rgba(52,211,153,0.06) !important;
    border-color: rgba(52,211,153,0.2) !important;
    cursor: not-allowed;
  }
  .hk-form-control::placeholder { color: rgba(123,147,176,0.5) !important; }

  /* select arrow */
  .hk-form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237b93b0' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    padding-right: 34px !important;
  }
  .hk-form-select option { background: #1a2e47; color: var(--text); }

  /* ── Modal buttons ── */
  .btn-hk-save {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--accent2); color: #0d1b2a;
    border: none; border-radius: 10px;
    padding: 9px 20px; font-size: 13px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: opacity .2s;
  }
  .btn-hk-save:hover { opacity: .85; }
  .btn-hk-save.blue { background: var(--accent1); }
  .btn-hk-save svg { width: 14px; height: 14px; stroke-width: 2.5; }

  .btn-hk-cancel {
    display: inline-flex; align-items: center;
    background: rgba(255,255,255,0.05); color: var(--muted);
    border: 1px solid var(--border); border-radius: 10px;
    padding: 9px 16px; font-size: 13px; font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: background .2s;
  }
  .btn-hk-cancel:hover { background: rgba(255,255,255,0.09); }

  /* ── Divider in modal form ── */
  .hk-modal-grid { display: grid; gap: 16px; }
  .hk-modal-grid.cols-2 { grid-template-columns: 1fr 1fr; }
  .hk-modal-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }

  /* ── Section label inside modal ── */
  .hk-section-sep {
    font-size: 10px; font-weight: 700; letter-spacing: 0.12em;
    text-transform: uppercase; color: var(--muted);
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 4px;
    grid-column: 1 / -1;
  }

  @keyframes hkFadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }

  @media(max-width: 640px) {
    .hk-modal-grid.cols-2,
    .hk-modal-grid.cols-3 { grid-template-columns: 1fr; }
  }
</style>

<div class="hk-body">

  {{-- Heading --}}
  <div class="page-heading">
    <div class="eyebrow">Housekeeping</div>
    <h3>Manajemen Pengeluaran</h3>
    <p>Kelola seluruh pengeluaran operasional kamar secara terpusat.</p>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div class="hk-alert">{{ session('success') }}</div>
  @endif

  {{-- Add Button --}}
  <button class="btn-hk-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Pengeluaran
  </button>

  {{-- Table Card --}}
  <div class="hk-table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Petugas</th>
          <th>Kamar</th>
          <th>Keterangan</th>
          <th>Tanggal</th>
          <th>Jumlah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pengeluarans as $i => $p)
        <tr>
          {{-- No --}}
          <td class="td-no">{{ $i + 1 }}</td>

          {{-- User --}}
          <td>
            <div class="hk-user">
              <div class="hk-avatar">{{ mb_substr($p->user->name ?? 'U', 0, 2) }}</div>
              <span class="hk-user-name">{{ $p->user->name ?? '-' }}</span>
            </div>
          </td>

          {{-- Kamar --}}
          <td>
            <span class="hk-room-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/></svg>
              {{ $p->kamar->nomor_kamar ?? '-' }}
            </span>
          </td>

          {{-- Keterangan --}}
          <td>
            <div class="hk-item-list">
              @php $items = explode("\n", $p->nama_barang); @endphp
              @foreach($items as $item)
                <div class="hk-item-line">{{ trim($item) }}</div>
              @endforeach
              <span class="hk-item-qty">{{ $p->jumlah_barang }} pcs</span>
            </div>
          </td>

          {{-- Tanggal --}}
          <td>
            <span class="hk-date">
              {{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d M Y') }}
            </span>
          </td>

          {{-- Total --}}
          <td>
            <div class="hk-amount">
              <span class="cur">Rp</span>{{ number_format($p->total_harga, 0, ',', '.') }}
            </div>
          </td>

          {{-- Aksi --}}
          <td>
            <div class="hk-actions">
              {{-- Edit --}}
              <button class="hk-btn-action edit"
                data-bs-toggle="modal"
                data-bs-target="#modalEdit-{{ $p->id }}"
                title="Edit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                  <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
              </button>

              {{-- Delete --}}
              <form action="{{ route('housekeeping.pengeluaran.destroy', $p->id) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="hk-btn-action delete" title="Hapus">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                  </svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7">
            <div class="hk-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
              </svg>
              Belum ada data pengeluaran.
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

{{-- ===== MODAL EDIT (per item) ===== --}}
@foreach($pengeluarans as $p)
<div class="modal fade" id="modalEdit-{{ $p->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('housekeeping.pengeluaran.update', $p->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="kamar_id" value="{{ $p->kamar_id }}">
        <input type="hidden" name="maintenance_id" value="{{ $p->maintenance_id }}">

        <div class="modal-header">
          <h5 class="modal-title">Edit Pengeluaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="hk-modal-grid cols-2">
            <div class="hk-section-sep">Informasi Pengeluaran</div>

            <div>
              <label class="hk-form-label">Tanggal</label>
              <input type="date" name="tanggal_pengeluaran"
                     class="hk-form-control"
                     value="{{ $p->tanggal_pengeluaran }}">
            </div>

            <div>
              <label class="hk-form-label">Nama Barang</label>
              <input type="text" name="nama_barang"
                     class="hk-form-control"
                     value="{{ $p->nama_barang }}"
                     placeholder="Contoh: Bohlam LED">
            </div>
          </div>

          <div class="hk-modal-grid cols-3" style="margin-top:16px;">
            <div>
              <label class="hk-form-label">Jumlah</label>
              <input type="number" name="jumlah_barang"
                     class="hk-form-control jumlah"
                     value="{{ $p->jumlah_barang }}"
                     placeholder="0">
            </div>
            <div>
              <label class="hk-form-label">Harga Satuan</label>
              <input type="number" name="harga_satuan"
                     class="hk-form-control harga"
                     value="{{ $p->harga_satuan }}"
                     placeholder="0">
            </div>
            <div>
              <label class="hk-form-label">Total Harga</label>
              <input type="number" name="total_harga"
                     class="hk-form-control total"
                     value="{{ $p->total_harga }}"
                     readonly>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-hk-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-hk-save">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach


{{-- ===== MODAL TAMBAH ===== --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('housekeeping.pengeluaran.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengeluaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="hk-modal-grid cols-2">
            <div class="hk-section-sep">Detail Pengeluaran</div>

            <div>
              <label class="hk-form-label">Pilih Kamar</label>
              <select name="kamar_id" class="hk-form-select">
                <option value="">-- Pilih Kamar --</option>
                @foreach($kamars as $k)
                  <option value="{{ $k->id }}">{{ $k->nomor_kamar }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="hk-form-label">Tanggal</label>
              <input type="date" name="tanggal_pengeluaran" class="hk-form-control">
            </div>

            <div>
              <label class="hk-form-label">Nama Barang</label>
              <input type="text" name="nama_barang" class="hk-form-control" placeholder="Contoh: Kain pel, Sabun lantai">
            </div>

            <div></div>
          </div>

          <div class="hk-modal-grid cols-3" style="margin-top:16px;">
            <div>
              <label class="hk-form-label">Jumlah</label>
              <input type="number" name="jumlah_barang" class="hk-form-control jumlah" placeholder="0">
            </div>
            <div>
              <label class="hk-form-label">Harga Satuan</label>
              <input type="number" name="harga_satuan" class="hk-form-control harga" placeholder="0">
            </div>
            <div>
              <label class="hk-form-label">Total Harga</label>
              <input type="number" name="total_harga" class="hk-form-control total" readonly placeholder="Auto">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-hk-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-hk-save blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function setupAutoTotal(modalEl) {
    const jumlah = modalEl.querySelector('input[name="jumlah_barang"]');
    const harga  = modalEl.querySelector('input[name="harga_satuan"]');
    const total  = modalEl.querySelector('input[name="total_harga"]');
    if (!jumlah || !harga || !total) return;

    function calc() {
      const j = parseFloat(jumlah.value) || 0;
      const h = parseFloat(harga.value)  || 0;
      total.value = j * h;
    }
    jumlah.addEventListener('input', calc);
    harga.addEventListener('input', calc);
  }

  document.addEventListener('DOMContentLoaded', function () {
    const modalTambah = document.getElementById('modalTambah');
    if (modalTambah) {
      modalTambah.addEventListener('shown.bs.modal', () => setupAutoTotal(modalTambah));
    }
    document.querySelectorAll('[id^="modalEdit-"]').forEach(modal => {
      modal.addEventListener('shown.bs.modal', () => setupAutoTotal(modal));
    });
  });
</script>
@endpush