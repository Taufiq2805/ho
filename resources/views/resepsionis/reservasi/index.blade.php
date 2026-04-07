@extends('layouts.resepsionis')

@section('title', 'Daftar Reservasi')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap');

  :root {
    --blue-accent:   #3b82f6;
    --green-accent:  #22c55e;
    --orange-accent: #f97316;
    --red-accent:    #ef4444;
    --cyan-accent:   #06b6d4;
    --card-radius:   18px;
    --transition:    all .35s cubic-bezier(.4,0,.2,1);
  }

  /* ── Page Heading ───────────────────────────── */
  .page-heading h3 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #1e3a5f 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: .25rem;
  }
  .page-heading .text-subtitle {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem;
    letter-spacing: .02em;
  }
  .page-heading::after {
    content: '';
    display: block;
    margin-top: 12px;
    width: 60px;
    height: 4px;
    border-radius: 99px;
    background: linear-gradient(90deg, #3b82f6, #22c55e);
  }

  /* ── Fade-slide animation ───────────────────── */
  .anim-fade { animation: fadeSlideUp .55s ease both; }
  .anim-d1   { animation-delay: .10s; }
  .anim-d2   { animation-delay: .22s; }
  .anim-d3   { animation-delay: .34s; }

  @keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── Tambah Reservasi button ────────────────── */
  .btn-reservasi-add {
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .88rem;
    letter-spacing: .04em;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    border-radius: 12px;
    padding: 10px 22px;
    color: #fff;
    box-shadow: 0 4px 14px rgba(59,130,246,.35);
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .btn-reservasi-add:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 8px 24px rgba(59,130,246,.45);
    color: #fff;
  }

  /* ── Alert success ──────────────────────────── */
  .alert-success-styled {
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem;
    background: linear-gradient(135deg, #dcfce7, #f0fdf4);
    border: 1px solid #22c55e;
    border-left: 5px solid #22c55e;
    border-radius: 12px;
    color: #166534;
    padding: 12px 18px;
  }

  /* ── Table card ─────────────────────────────── */
  .reservasi-card {
    border-radius: var(--card-radius) !important;
    border: 0 !important;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.07) !important;
    transition: var(--transition);
  }
  .reservasi-card:hover {
    box-shadow: 0 12px 36px rgba(0,0,0,.11) !important;
  }

  /* Card header bar */
  .reservasi-card-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    border-radius: calc(var(--card-radius) - 2px) calc(var(--card-radius) - 2px) 0 0 !important;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .reservasi-card-header h6 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: .01em;
  }
  .reservasi-card-header .header-icon {
    background: rgba(255,255,255,.15);
    border-radius: 10px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .reservasi-card-header .header-icon span {
    font-size: 1.2rem;
    color: #fff;
  }

  /* ── Table styling ──────────────────────────── */
  .reservasi-table thead th {
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: #64748b;
    border-bottom: 2px solid #e2e8f0;
    padding: 14px 16px;
    white-space: nowrap;
    background: #f8fafc;
  }
  .reservasi-table tbody tr {
    transition: background .2s ease;
    border-bottom: 1px solid #f1f5f9;
  }
  .reservasi-table tbody tr:hover {
    background: #f0f7ff;
  }
  .reservasi-table tbody td {
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem;
    color: #334155;
    padding: 13px 16px;
    vertical-align: middle;
  }

  /* Kamar chip */
  .chip-kamar {
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 3px 10px;
    font-size: .8rem;
    font-weight: 600;
    color: #1d4ed8;
    display: inline-block;
  }

  /* Total styling */
  .total-cell {
    font-weight: 600;
    color: #0f172a;
  }

  /* Badge makanan */
  .badge-makanan {
    background: linear-gradient(135deg, #cffafe, #ecfeff);
    border: 1px solid #a5f3fc;
    color: #0e7490;
    border-radius: 8px;
    font-size: .73rem;
    font-weight: 600;
    padding: 3px 9px;
    margin: 2px;
    display: inline-block;
  }

  /* ── Action buttons ─────────────────────────── */
  .btn-action {
    font-family: 'DM Sans', sans-serif;
    font-size: .76rem;
    font-weight: 600;
    border-radius: 8px;
    padding: 5px 10px;
    border: none;
    transition: var(--transition);
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .btn-action:hover { transform: translateY(-2px); }

  .btn-selesai {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    box-shadow: 0 3px 10px rgba(34,197,94,.3);
  }
  .btn-selesai:hover { box-shadow: 0 6px 18px rgba(34,197,94,.4); color: #fff; }

  .btn-pdf {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: #fff;
    box-shadow: 0 3px 10px rgba(6,182,212,.3);
  }
  .btn-pdf:hover { box-shadow: 0 6px 18px rgba(6,182,212,.4); color: #fff; }

  .btn-hapus {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    box-shadow: 0 3px 10px rgba(239,68,68,.3);
  }
  .btn-hapus:hover { box-shadow: 0 6px 18px rgba(239,68,68,.4); color: #fff; }

  /* ── MODAL STYLING ──────────────────────────── */
  .modal-content {
    border-radius: 20px !important;
    border: 0 !important;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.18);
  }

  .modal-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    border-bottom: 0 !important;
    padding: 20px 24px;
  }
  .modal-header .modal-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #fff;
  }
  .modal-header .btn-close {
    filter: invert(1) brightness(2);
    opacity: .8;
  }
  .modal-header .btn-close:hover { opacity: 1; }

  /* Modal section headings */
  .modal-section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .modal-section-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 18px;
    border-radius: 99px;
    background: linear-gradient(180deg, #3b82f6, #22c55e);
  }
  .modal-divider {
    border: 0;
    height: 1px;
    background: linear-gradient(90deg, #3b82f6 0%, transparent 100%);
    opacity: .25;
    margin-bottom: 18px;
  }

  /* Modal labels */
  .modal-body label {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 6px;
    display: block;
  }

  /* Form controls */
  .modal .form-control,
  .modal .form-select,
  .modal input[type="date"],
  .modal input[type="text"],
  .modal input[type="number"] {
    border: 1.5px solid #e2e8f0 !important;
    background-color: #f8fafc !important;
    padding: 9px 13px !important;
    border-radius: 10px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: .875rem !important;
    font-style: normal !important;
    color: #0f172a !important;
    transition: var(--transition) !important;
  }
  .modal .form-control:focus,
  .modal .form-select:focus,
  .modal input[type="date"]:focus,
  .modal input[type="text"]:focus {
    border-color: #3b82f6 !important;
    background-color: #fff !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.15) !important;
  }

  /* Total display box */
  .total-display-box {
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border: 1.5px solid #bfdbfe;
    border-radius: 12px;
    padding: 12px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 4px 0 18px;
  }
  .total-display-box .total-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #64748b;
  }
  .total-display-box .total-value {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #1d4ed8;
  }

  /* Preview foto kamar */
  #previewFotoKamar {
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,.12);
    transition: var(--transition);
  }

  /* List makanan */
  #listMakanan {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  #listMakanan li {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 8px 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem;
    color: #166534;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: fadeSlideUp .3s ease both;
  }

  /* Remove makanan button */
  .remove-makanan {
    background: rgba(239,68,68,.1) !important;
    color: #dc2626 !important;
    border: 1px solid rgba(239,68,68,.25) !important;
    border-radius: 7px !important;
    font-size: .72rem !important;
    padding: 3px 9px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-weight: 600 !important;
    transition: var(--transition) !important;
  }
  .remove-makanan:hover {
    background: rgba(239,68,68,.2) !important;
    transform: scale(1.05);
  }

  /* Preview makanan box */
  #previewMakanan {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
  }
  #previewMakanan img {
    border-radius: 10px;
    box-shadow: 0 4px 14px rgba(0,0,0,.1);
  }
  #deskripsiMakanan {
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem;
    color: #64748b;
  }
  #hargaMakanan {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: #0891b2;
  }

  /* Modal footer */
  .modal-footer {
    border-top: 1px solid #f1f5f9 !important;
    padding: 16px 24px;
    gap: 10px;
  }
  .btn-modal-cancel {
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .875rem;
    border-radius: 10px;
    padding: 9px 20px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    transition: var(--transition);
  }
  .btn-modal-cancel:hover {
    background: #f1f5f9;
    color: #334155;
  }
  .btn-modal-save {
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .875rem;
    border-radius: 10px;
    padding: 9px 24px;
    border: none;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 4px 14px rgba(59,130,246,.35);
    transition: var(--transition);
  }
  .btn-modal-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(59,130,246,.45);
    color: #fff;
  }

  /* Sidebar safety */
  .navbar-vertical .nav-link,
  .navbar-vertical .nav-link span {
    font-style: normal !important;
  }

  /* Empty state */
  .empty-state {
    padding: 48px 24px;
    text-align: center;
    color: #94a3b8;
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem;
  }
  .empty-state span {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 12px;
  }
</style>

<!-- ── Page Heading ───────────────────────────── -->
<div class="page-heading mb-4 anim-fade anim-d1">
  <h3>Daftar Reservasi</h3>
  <p class="text-subtitle text-muted">Kelola dan pantau semua reservasi tamu hotel.</p>
</div>

<!-- ── Alert ─────────────────────────────────── -->
@if(session('success'))
  <div class="alert-success-styled mb-3 anim-fade anim-d1">
    <span class="material-symbols-rounded" style="vertical-align:middle;font-size:1.1rem;">check_circle</span>
    {{ session('success') }}
  </div>
@endif

<!-- ── Tambah Reservasi ───────────────────────── -->
<div class="mb-4 anim-fade anim-d2">
  <button type="button"
          class="btn-reservasi-add"
          data-bs-toggle="modal"
          data-bs-target="#modalReservasi">
    <span class="material-symbols-rounded" style="font-size:1.1rem;">add_circle</span>
    Tambah Reservasi
  </button>
</div>

<!-- ── Tabel Reservasi ───────────────────────── -->
<div class="card reservasi-card anim-fade anim-d3">

  <!-- Header bar -->
  <div class="reservasi-card-header">
    <div class="header-icon">
      <span class="material-symbols-rounded">table_rows</span>
    </div>
    <h6>Tabel Reservasi</h6>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table reservasi-table mb-0">
        <thead>
          <tr>
            <th>Kamar</th>
            <th>Nama Tamu</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Total</th>
            <th>Extra</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($reservasis as $item)
          <tr>
            <td>
              <span class="chip-kamar">
                {{ $item->kamar->nomor_kamar ?? $item->kamar->nama_kamar ?? '-' }}
              </span>
            </td>
            <td>
              <span style="font-weight:500;color:#0f172a;">
                {{ $item->nama_tamu ?? '-' }}
              </span>
            </td>
            <td>{{ $item->check_in ?? $item->tanggal_checkin ?? '-' }}</td>
            <td>{{ $item->check_out ?? $item->tanggal_checkout ?? '-' }}</td>
            <td class="total-cell">
              {{ $item->total ? 'Rp ' . number_format($item->total,0,',','.') : '-' }}
            </td>
            <td>
              @if ($item->makanans && $item->makanans->count() > 0)
                @foreach ($item->makanans as $makanan)
                  <span class="badge-makanan">{{ $makanan->nama }}</span>
                @endforeach
              @else
                <span class="text-muted" style="font-size:.8rem;">—</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1 flex-wrap">

                {{-- Selesai --}}
                <form action="{{ route('resepsionis.reservasi.selesai', $item->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Checkout reservasi ini?')">
                  @csrf
                  <button type="submit" class="btn-action btn-selesai">
                    <span class="material-symbols-rounded" style="font-size:.9rem;">check_circle</span>
                    Selesai
                  </button>
                </form>

                {{-- PDF --}}
                <a href="{{ route('resepsionis.reservasi.export.pdf', $item->id) }}"
                   class="btn-action btn-pdf">
                  <span class="material-symbols-rounded" style="font-size:.9rem;">download</span>
                  PDF
                </a>

                {{-- Hapus --}}
                <form action="{{ route('resepsionis.reservasi.destroy', $item->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus reservasi ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action btn-hapus">
                    <span class="material-symbols-rounded" style="font-size:.9rem;">delete</span>
                    Hapus
                  </button>
                </form>

              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <span class="material-symbols-rounded">event_busy</span>
                Belum ada reservasi hari ini.
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- ===================================================== -->
<!--                    MODAL RESERVASI                    -->
<!-- ===================================================== -->
<div class="modal fade" id="modalReservasi" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <form method="POST" action="{{ route('resepsionis.reservasi.store') }}">
      @csrf

      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h5 class="modal-title">
            <span class="material-symbols-rounded" style="vertical-align:middle;margin-right:8px;font-size:1.3rem;">add_circle</span>
            Tambah Reservasi
          </h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body p-4">

          <!-- Section: Data Reservasi -->
          <p class="modal-section-title">Data Reservasi</p>
          <hr class="modal-divider">

          <div class="row g-3">

            <!-- Tipe Kamar -->
            <div class="col-md-6">
              <label>Tipe Kamar</label>
              <select id="tipe_id" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                @foreach($tipeKamars as $t)
                  <option value="{{ $t->id }}">{{ $t->nama }}</option>
                @endforeach
              </select>
            </div>

            <!-- Nomor Kamar -->
            <div class="col-md-6">
              <label>Nomor Kamar</label>
              <select name="kamar_id" id="kamar_id" class="form-select" required>
                <option value="">-- Pilih Kamar --</option>
                @foreach($kamars as $k)
                  <option value="{{ $k->id }}"
                          data-tipe="{{ $k->tipe_id }}"
                          data-status="{{ $k->status }}" hidden>
                    Kamar {{ $k->nomor_kamar }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Nama Tamu -->
            <div class="col-12">
              <label>Nama Tamu</label>
              <input type="text" name="nama_tamu" class="form-control"
                     placeholder="Masukkan nama tamu..." required>
            </div>

            <!-- Preview Foto Kamar -->
            <div class="col-12 text-center">
              <img id="previewFotoKamar"
                   style="display:none;width:260px;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,.12);">
            </div>

            <!-- Tanggal Check-in -->
            <div class="col-md-6">
              <label>Tanggal Check-in</label>
              <input type="date" name="tanggal_checkin" class="form-control" required>
            </div>

            <!-- Tanggal Check-out -->
            <div class="col-md-6">
              <label>Tanggal Check-out</label>
              <input type="date" name="tanggal_checkout" class="form-control" required>
            </div>

          </div>

          <!-- Total Box -->
          <div class="total-display-box mt-3">
            <span class="total-label">
              <span class="material-symbols-rounded" style="font-size:1rem;vertical-align:middle;margin-right:4px;">receipt</span>
              Total Harga
            </span>
            <span class="total-value" id="totalHarga">Rp 0</span>
          </div>

          <!-- Section: Pesan Makanan -->
          <p class="modal-section-title mt-2">Pesan Makanan <small style="font-size:.75rem;font-weight:400;color:#94a3b8;font-family:'DM Sans',sans-serif;">(Opsional)</small></p>
          <hr class="modal-divider">

          <div class="row g-3">

            <!-- Dropdown Makanan -->
            <div class="col-md-7">
              <label>Pilih Makanan</label>
              <select id="makananSelect" class="form-select">
                <option value="">-- Pilih Makanan --</option>
                @foreach($makanans as $m)
                  <option value="{{ $m->id }}"
                          data-harga="{{ $m->harga }}"
                          data-foto="{{ $m->foto ? asset('storage/uploads/makanan/'.$m->foto) : asset('images/no-image.jpg') }}"
                          data-deskripsi="{{ $m->deskripsi ?? '-' }}">
                    {{ $m->nama }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- List Makanan Dipilih -->
            <div class="col-md-5">
              <label>List Makanan Dipilih</label>
              <ul id="listMakanan"></ul>
            </div>

            <!-- Preview Makanan -->
            <div class="col-12">
              <div id="previewMakanan" style="display:none;">
                <div class="d-flex align-items-center gap-3">
                  <img id="fotoMakanan" style="width:100px;height:100px;object-fit:cover;border-radius:12px;box-shadow:0 4px 14px rgba(0,0,0,.1);">
                  <div>
                    <p id="deskripsiMakanan" class="mb-1" style="font-size:.83rem;color:#64748b;"></p>
                    <strong id="hargaMakanan" style="font-family:'Playfair Display',serif;font-size:1.05rem;color:#0891b2;"></strong>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div><!-- /modal-body -->

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-modal-save">
            <span class="material-symbols-rounded" style="font-size:1rem;vertical-align:middle;margin-right:4px;">save</span>
            Simpan
          </button>
        </div>

      </div>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

  const tipeSelect  = document.getElementById('tipe_id');
  const kamarSelect = document.getElementById('kamar_id');
  const previewFoto = document.getElementById('previewFotoKamar');
  const checkinEl   = document.querySelector('input[name="tanggal_checkin"]');
  const checkoutEl  = document.querySelector('input[name="tanggal_checkout"]');
  const totalEl     = document.getElementById('totalHarga');

  const makananSelectModal = document.getElementById('makananSelect');
  const listMakanan        = document.getElementById('listMakanan');
  const previewMakanan     = document.getElementById('previewMakanan');
  const fotoMakanan        = document.getElementById('fotoMakanan');
  const deskripsiMakanan   = document.getElementById('deskripsiMakanan');
  const hargaMakanan       = document.getElementById('hargaMakanan');

  const hargaTipeMap = {
    @foreach ($tipeKamars as $t)
      "{{ $t->id }}": {{ $t->harga }},
    @endforeach
  };

  const formatRupiah = n => 'Rp ' + (Number(n) || 0).toLocaleString('id-ID');

  function getTotalMakanan() {
    let total = 0;
    listMakanan?.querySelectorAll('li').forEach(li => total += Number(li.dataset.harga || 0));
    return total;
  }

  function updateTotal() {
    const tipeId        = tipeSelect?.value;
    const hargaPerMalam = Number(hargaTipeMap[tipeId] || 0);
    const makananTotal  = getTotalMakanan();
    const checkin       = new Date(checkinEl?.value);
    const checkout      = new Date(checkoutEl?.value);

    if (!isNaN(checkin) && !isNaN(checkout) && hargaPerMalam > 0) {
      const malam       = Math.max(0, Math.ceil((checkout - checkin) / 86400000));
      const grand       = malam * hargaPerMalam + makananTotal;
      if (totalEl) totalEl.textContent = formatRupiah(grand);
    } else {
      if (totalEl) totalEl.textContent = formatRupiah(makananTotal || 0);
    }
  }

  function filterKamarByTipe() {
    if (!kamarSelect) return;
    kamarSelect.value = "";
    Array.from(kamarSelect.options).forEach(o => {
      const tipeMatch = o.dataset.tipe === tipeSelect.value || o.value === "";
      const tersedia  = (o.dataset.status || '').toLowerCase() !== 'terisi';
      o.hidden = !(tipeMatch && tersedia);
    });
  }

  async function fetchFotoTipe(tipeId) {
    if (!previewFoto) return;
    if (!tipeId) { previewFoto.style.display = "none"; return; }
    try {
      const res  = await fetch(`/resepsionis/get-foto-tipe/${tipeId}`);
      const data = await res.json();
      previewFoto.src = data.foto || '{{ asset("images/no-image.jpg") }}';
      previewFoto.style.display = "block";
    } catch { previewFoto.style.display = "none"; }
  }

  function showPreviewMakanan(opt) {
    if (!opt) { if (previewMakanan) previewMakanan.style.display = 'none'; return; }
    const foto  = opt.dataset.foto || '{{ asset("images/no-image.jpg") }}';
    const desc  = opt.dataset.deskripsi || '-';
    const harga = Number(opt.dataset.harga) || 0;
    if (fotoMakanan)      { fotoMakanan.src = foto; fotoMakanan.onerror = () => fotoMakanan.src = '{{ asset("images/no-image.jpg") }}'; }
    if (deskripsiMakanan) deskripsiMakanan.textContent = desc;
    if (hargaMakanan)     hargaMakanan.textContent = formatRupiah(harga);
    if (previewMakanan)   previewMakanan.style.display = 'block';
  }

  function addMakananFromOption(opt) {
    if (!opt || !listMakanan) return;
    const id    = opt.value;
    const nama  = (opt.textContent || opt.innerText || '').trim();
    const harga = Number(opt.dataset.harga) || 0;
    if (Array.from(listMakanan.querySelectorAll('li')).some(li => li.dataset.id === id)) return;

    const li   = document.createElement('li');
    li.dataset.id    = id;
    li.dataset.harga = harga;

    const span = document.createElement('span');
    span.textContent = `${nama} — ${formatRupiah(harga)}`;

    const hidId   = document.createElement('input');
    hidId.type = 'hidden'; hidId.name = 'makanan_id[]'; hidId.value = id;

    const hidHarga = document.createElement('input');
    hidHarga.type = 'hidden'; hidHarga.name = 'harga_makanan[]'; hidHarga.value = harga;

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'btn btn-sm remove-makanan';
    btn.innerHTML = '<span class="material-symbols-rounded" style="font-size:.85rem;vertical-align:middle;">close</span>';

    li.append(span, hidId, hidHarga, btn);
    listMakanan.appendChild(li);
    updateTotal();
  }

  function handleMakananSelectChange(selectEl) {
    const opt = selectEl.options[selectEl.selectedIndex];
    if (!opt || !selectEl.value) { showPreviewMakanan(null); return; }
    showPreviewMakanan(opt);
    addMakananFromOption(opt);
    selectEl.value = '';
  }

  makananSelectModal?.addEventListener('change', function () { handleMakananSelectChange(this); });

  listMakanan?.addEventListener('click', function (e) {
    if (e.target.closest('.remove-makanan')) {
      e.target.closest('li')?.remove();
      updateTotal();
    }
  });

  tipeSelect?.addEventListener('change', () => { filterKamarByTipe(); fetchFotoTipe(tipeSelect.value); });
  checkinEl?.addEventListener('change', updateTotal);
  checkoutEl?.addEventListener('change', updateTotal);

  filterKamarByTipe();
  if (tipeSelect?.value) fetchFotoTipe(tipeSelect.value);
});
</script>

@endsection