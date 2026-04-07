@extends('layouts.housekeeping')

@section('title', 'Data Maintenance Kamar')

@section('content')
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
    --border-md: rgba(255,255,255,0.11);
  }

  .hk-body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); }

  /* ── Heading ── */
  .page-heading { margin-bottom: 32px; animation: hkFadeUp 0.45s ease both; }
  .page-heading .eyebrow {
    font-size: 11px; font-weight: 600; letter-spacing: .14em;
    text-transform: uppercase; color: var(--accent1);
    display: flex; align-items: center; gap: 8px; margin-bottom: 6px;
  }
  .page-heading .eyebrow::before {
    content: ''; display: block; width: 20px; height: 2px;
    background: var(--accent1); border-radius: 2px;
  }
  .page-heading h3 { font-size: 26px; font-weight: 800; letter-spacing: -.4px; color: #fff; margin: 0; }
  .page-heading p  { font-size: 14px; color: var(--muted); margin-top: 4px; }

  /* ── Table Card ── */
  .hk-table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    animation: hkFadeUp .5s ease both;
    animation-delay: .1s;
  }
  .hk-table-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
  }
  .hk-table-card-header h5 {
    font-size: 15px; font-weight: 700; color: #fff; margin: 0;
    display: flex; align-items: center; gap: 10px;
  }
  .hk-table-card-header h5 .icon-wrap {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(251,146,60,.15); color: var(--accent3);
    display: flex; align-items: center; justify-content: center;
  }
  .hk-table-card-header h5 .icon-wrap svg { width: 17px; height: 17px; stroke-width: 2; }

  /* ── Btn Add ── */
  .btn-hk-add {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 16px; border-radius: 10px; border: none; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    background: var(--accent1); color: #0d1b2a;
    transition: opacity .2s, transform .2s;
  }
  .btn-hk-add:hover { opacity: .88; transform: translateY(-1px); }
  .btn-hk-add svg { width: 15px; height: 15px; stroke-width: 2.5; }

  /* ── Table ── */
  .hk-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .hk-table thead tr th {
    padding: 11px 18px;
    font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,.025); white-space: nowrap;
  }
  .hk-table tbody tr { transition: background .15s; }
  .hk-table tbody tr:hover { background: rgba(255,255,255,.03); }
  .hk-table tbody tr:not(:last-child) { border-bottom: 1px solid var(--border); }
  .hk-table tbody td { padding: 13px 18px; vertical-align: middle; color: var(--text); }

  .hk-no {
    width: 28px; height: 28px; border-radius: 8px;
    background: rgba(255,255,255,.05); color: var(--muted);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
  }
  .hk-room-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(56,189,248,.1); color: var(--accent1);
    border-radius: 8px; padding: 4px 10px;
    font-size: 12.5px; font-weight: 700;
  }
  .hk-date { color: var(--muted); font-size: 13px; }

  /* ── Status Badge ── */
  .hk-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11.5px; font-weight: 700; padding: 4px 10px;
    border-radius: 100px; white-space: nowrap;
  }
  .hk-status::before {
    content: ''; width: 6px; height: 6px; border-radius: 50%;
    background: currentColor; display: block; opacity: .8;
  }
  .hk-status.maintenance { background: rgba(248,113,113,.12); color: var(--accent4); }
  .hk-status.dibersihkan { background: rgba(251,146,60,.12);  color: var(--accent3); }
  .hk-status.tersedia    { background: rgba(52,211,153,.12);  color: var(--accent2); }
  .hk-status.terisi      { background: rgba(167,139,250,.12); color: var(--accent5); }
  .hk-status.default     { background: rgba(123,147,176,.12); color: var(--muted); }

  /* ── Catatan ── */
  .hk-catatan {
    max-width: 220px; font-size: 13px; color: var(--text);
    white-space: pre-line; line-height: 1.5;
    cursor: pointer; border-radius: 6px; padding: 4px 6px;
    transition: background .15s;
  }
  .hk-catatan:hover { background: rgba(255,255,255,.05); }
  .hk-catatan .hint {
    font-size: 10px; color: var(--muted); display: block; margin-top: 2px;
  }

  /* ── Petugas ── */
  .hk-officer {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; color: var(--text);
  }
  .hk-officer-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(167,139,250,.2); color: var(--accent5);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800;
  }

  /* ── Action Buttons ── */
  .hk-actions { display: flex; align-items: center; gap: 5px; }
  .hk-btn {
    width: 32px; height: 32px; border-radius: 9px; border: none; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
    transition: transform .15s, opacity .15s;
  }
  .hk-btn:hover { transform: translateY(-1px); opacity: .85; }
  .hk-btn svg { width: 15px; height: 15px; stroke-width: 2; }
  .hk-btn.edit   { background: rgba(251,146,60,.15);  color: var(--accent3); }
  .hk-btn.done   { background: rgba(52,211,153,.15);  color: var(--accent2); }
  .hk-btn.delete { background: rgba(248,113,113,.12); color: var(--accent4); }

  /* ── Empty State ── */
  .hk-empty { padding: 48px 24px; text-align: center; }
  .hk-empty-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: rgba(123,147,176,.1); color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
  .hk-empty-icon svg { width: 26px; height: 26px; stroke-width: 1.5; }
  .hk-empty p { font-size: 13.5px; color: var(--muted); margin: 0; }

  /* ── Modal ── */
  .hk-modal .modal-content {
    background: var(--surface);
    border: 1px solid var(--border-md);
    border-radius: 20px;
    color: var(--text);
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .hk-modal .modal-header {
    border-bottom: 1px solid var(--border);
    padding: 20px 24px 16px;
  }
  .hk-modal .modal-title { font-size: 16px; font-weight: 800; color: #fff; }
  .hk-modal .btn-close { filter: invert(1) brightness(.6); }
  .hk-modal .modal-body  { padding: 20px 24px; }
  .hk-modal .modal-footer {
    border-top: 1px solid var(--border);
    padding: 14px 24px;
    gap: 8px;
  }

  .hk-form-label {
    font-size: 11.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); margin-bottom: 7px; display: block;
  }
  .hk-form-control {
    width: 100%; background: rgba(255,255,255,.04);
    border: 1px solid var(--border-md); border-radius: 11px;
    color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px; padding: 10px 14px;
    transition: border-color .15s, background .15s;
    outline: none;
  }
  .hk-form-control:focus { border-color: var(--accent1); background: rgba(56,189,248,.04); }
  .hk-form-control option { background: #1a2e47; }
  textarea.hk-form-control { resize: vertical; min-height: 90px; }

  .btn-hk-cancel {
    padding: 9px 18px; border-radius: 10px; border: 1px solid var(--border-md);
    background: transparent; color: var(--muted);
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: background .15s;
  }
  .btn-hk-cancel:hover { background: rgba(255,255,255,.05); }
  .btn-hk-save {
    padding: 9px 20px; border-radius: 10px; border: none;
    background: var(--accent1); color: #0d1b2a;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: opacity .15s, transform .15s;
  }
  .btn-hk-save:hover { opacity: .88; transform: translateY(-1px); }
  .btn-hk-save.green { background: var(--accent2); }

  @keyframes hkFadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }
</style>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<div class="hk-body">

  {{-- Heading --}}
  <div class="page-heading">
    <div class="eyebrow">Housekeeping</div>
    <h3>Data Maintenance Kamar</h3>
    <p>Kelola dan pantau seluruh aktivitas maintenance kamar.</p>
  </div>

  {{-- Table Card --}}
  <div class="hk-table-card">
    <div class="hk-table-card-header">
      <h5>
        <span class="icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a5 5 0 01-6.4 6.4l-4 4a2 2 0 01-2.8-2.8l4-4A5 5 0 0114.7 6.3z"/></svg>
        </span>
        Daftar Maintenance
      </h5>
    </div>

    <div style="overflow-x:auto;">
      <table class="hk-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Petugas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($maintenances as $index => $m)
          <tr>
            <td><span class="hk-no">{{ $index + 1 }}</span></td>
            <td>
              <span class="hk-room-chip">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
                {{ $m->kamar->nomor_kamar ?? '-' }}
              </span>
            </td>
            <td>
              <span class="hk-date">{{ $m->tanggal }}</span>
            </td>
            <td>
              @php
                $statusMap = [
                  'maintenance' => 'maintenance',
                  'dibersihkan' => 'dibersihkan',
                  'tersedia'    => 'tersedia',
                  'terisi'      => 'terisi',
                ];
                $cls = $statusMap[$m->status] ?? 'default';
              @endphp
              <span class="hk-status {{ $cls }}">{{ ucfirst($m->status) }}</span>
            </td>
            <td>
              <div class="hk-catatan editable-catatan" data-id="{{ $m->id }}" title="Double-klik untuk edit">
                {{ $m->catatan ?? '-' }}
                <span class="hint">double-klik untuk edit</span>
              </div>
            </td>
            <td>
              <div class="hk-officer">
                <div class="hk-officer-avatar">
                  {{ strtoupper(substr($m->user->name ?? 'X', 0, 1)) }}
                </div>
                {{ $m->user->name ?? '-' }}
              </div>
            </td>
            <td>
              <div class="hk-actions">
                {{-- Edit --}}
                <button class="hk-btn edit btnEdit"
                  data-id="{{ $m->id }}"
                  data-kamar="{{ $m->kamar_id }}"
                  data-tanggal="{{ $m->tanggal }}"
                  data-status="{{ $m->status }}"
                  data-catatan="{{ $m->catatan }}"
                  title="Edit">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>

                {{-- Selesai --}}
                @if($m->status !== 'tersedia')
                <form action="{{ route('housekeeping.maintenance.updateStatus', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai sebagai selesai dan ubah status kamar ke tersedia?')">
                  @csrf
                  <button type="submit" class="hk-btn done" title="Tandai Selesai">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
                  </button>
                </form>
                @endif

                {{-- Hapus --}}
                <form action="{{ route('housekeeping.maintenance.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="hk-btn delete" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">
              <div class="hk-empty">
                <div class="hk-empty-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="9" y1="12" x2="15" y2="12"/></svg>
                </div>
                <p>Belum ada data maintenance kamar.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- ══════════════ MODAL TAMBAH ══════════════ --}}
<div class="modal fade hk-modal" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('housekeeping.maintenance.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalCreateLabel">Tambah Maintenance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="hk-form-label">Pilih Kamar</label>
            <select name="kamar_id" class="hk-form-control" required>
              <option value="">-- Pilih Kamar --</option>
              @foreach($kamars as $k)
                <option value="{{ $k->id }}">{{ $k->nomor_kamar }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Tanggal</label>
            <input type="date" name="tanggal" class="hk-form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Status</label>
            <select name="status" class="hk-form-control" required>
              <option value="maintenance">Maintenance</option>
              <option value="dibersihkan">Dibersihkan</option>
              <option value="terisi">Terisi</option>
              <option value="tersedia">Tersedia</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Catatan</label>
            <textarea name="catatan" class="hk-form-control" placeholder="Tulis kondisi kamar, misal: AC bocor, kipas rusak, dll"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-hk-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-hk-save">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ══════════════ MODAL EDIT ══════════════ --}}
<div class="modal fade hk-modal" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formEdit" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Maintenance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="hk-form-label">Kamar</label>
            <select name="kamar_id" id="editKamar" class="hk-form-control" required>
              @foreach($kamars as $k)
                <option value="{{ $k->id }}">{{ $k->nomor_kamar }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Tanggal</label>
            <input type="date" id="editTanggal" name="tanggal" class="hk-form-control" required>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Status</label>
            <select name="status" id="editStatus" class="hk-form-control" required>
              @foreach(['tersedia', 'terisi', 'dibersihkan', 'maintenance'] as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="hk-form-label">Catatan</label>
            <textarea name="catatan" id="editCatatan" class="hk-form-control" placeholder="Misal: Kipas rusak, Lampu mati, dll"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-hk-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-hk-save green">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  /* ── Buka Modal Edit ── */
  document.querySelectorAll('.btnEdit').forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.dataset.id;
      document.getElementById('editKamar').value   = this.dataset.kamar;
      document.getElementById('editTanggal').value  = this.dataset.tanggal;
      document.getElementById('editStatus').value   = this.dataset.status;
      document.getElementById('editCatatan').value  = this.dataset.catatan ?? '';
      document.getElementById('formEdit').action    = `/housekeeping/maintenance/${id}`;
      new bootstrap.Modal(document.getElementById('modalEdit')).show();
    });
  });

  /* ── Inline Edit Catatan (double-click) ── */
  document.querySelectorAll('.editable-catatan').forEach(cell => {
    cell.addEventListener('dblclick', function () {
      const id      = this.dataset.id;
      const hint    = this.querySelector('.hint');
      const oldText = this.childNodes[0]?.textContent.trim() === '-'
                      ? '' : (this.childNodes[0]?.textContent.trim() ?? '');

      const ta = document.createElement('textarea');
      ta.value = oldText;
      ta.className = 'hk-form-control';
      ta.rows = 3;
      ta.style.marginTop = '4px';
      this.innerHTML = '';
      this.appendChild(ta);
      ta.focus();

      ta.addEventListener('blur', () => {
        const newText = ta.value.trim();
        this.innerHTML = (newText || '-') + '<span class="hint">double-klik untuk edit</span>';

        fetch('/housekeeping/maintenance/update-catatan', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ id, catatan: newText })
        })
        .then(r => r.json())
        .then(data => { if (data.success) window.location.reload(); else alert(data.message || 'Gagal menyimpan.'); })
        .catch(() => alert('Gagal menyimpan catatan.'));
      });
    });
  });
</script>
@endsection