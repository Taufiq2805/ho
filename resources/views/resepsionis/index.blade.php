@extends('layouts.resepsionis')

@section('title', 'Dashboard Resepsionis')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600&display=swap');

  :root {
    --blue: #2563eb;
    --blue-light: #dbeafe;
    --green: #16a34a;
    --green-light: #dcfce7;
    --orange: #f97316;
    --orange-light: #ffedd5;
    --purple: #6366f1;
    --purple-light: #ede9fe;
    --bg: #f1f5f9;
    --white: #ffffff;
    --text-main: #0f172a;
    --text-sub: #64748b;
    --border: #e2e8f0;
    --shadow: 0 4px 24px rgba(0,0,0,0.07);
    --shadow-hover: 0 12px 32px rgba(0,0,0,0.13);
    --radius: 18px;
    --radius-sm: 10px;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  .dash-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    padding: 28px;
    min-height: 100vh;
    color: var(--text-main);
  }

  /* ── HEADING ─────────────────────────── */
  .dash-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 28px;
    animation: fadeUp .5s ease both;
  }

  .dash-heading h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -.3px;
    color: var(--text-main);
    line-height: 1;
  }

  .dash-heading .sub {
    font-size: 13px;
    color: var(--text-sub);
    margin-top: 5px;
  }

  .dash-heading .live-date {
    font-size: 13px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 7px 16px;
    color: var(--text-sub);
    display: flex;
    align-items: center;
    gap: 7px;
    box-shadow: var(--shadow);
  }

  .live-dot {
    width: 8px; height: 8px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse 1.8s infinite;
  }

  /* ── STAT CARDS ───────────────────────── */
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 22px;
  }

  .stat-card {
    background: var(--white);
    padding: 22px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: transform .25s ease, box-shadow .25s ease;
    animation: fadeUp .5s ease both;
    position: relative;
    overflow: hidden;
  }

  .stat-card:nth-child(1) { animation-delay: .05s; }
  .stat-card:nth-child(2) { animation-delay: .10s; }
  .stat-card:nth-child(3) { animation-delay: .15s; }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
  }

  .stat-card::after {
    content: '';
    position: absolute;
    right: -18px; top: -18px;
    width: 90px; height: 90px;
    border-radius: 50%;
    opacity: .06;
  }

  .stat-card.blue-card::after  { background: var(--blue); }
  .stat-card.green-card::after { background: var(--green); }
  .stat-card.orange-card::after{ background: var(--orange); }

  .stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }

  .blue-card  .stat-icon { background: var(--blue-light); }
  .green-card .stat-icon { background: var(--green-light); }
  .orange-card .stat-icon { background: var(--orange-light); }

  .stat-label {
    font-size: 12.5px;
    color: var(--text-sub);
    font-weight: 500;
    margin-bottom: 4px;
  }

  .stat-value {
    font-size: 32px;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -1px;
  }

  .blue-card  .stat-value { color: var(--blue); }
  .green-card .stat-value { color: var(--green); }
  .orange-card .stat-value { color: var(--orange); }

  .stat-badge {
    font-size: 10.5px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    margin-top: 6px;
    display: inline-block;
  }

  .blue-card  .stat-badge { background: var(--blue-light);   color: var(--blue); }
  .green-card .stat-badge { background: var(--green-light);  color: var(--green); }
  .orange-card .stat-badge{ background: var(--orange-light); color: var(--orange); }

  /* ── BOTTOM GRID ──────────────────────── */
  .bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  /* ── PANEL ────────────────────────────── */
  .panel {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    animation: fadeUp .5s ease both;
  }

  .panel:nth-child(1) { animation-delay: .2s; }
  .panel:nth-child(2) { animation-delay: .25s; }

  .panel-header {
    padding: 16px 22px;
    border-bottom: 1px solid var(--border);
    font-weight: 700;
    font-size: 14.5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fafbfc;
  }

  .panel-header .count-badge {
    font-size: 11px;
    background: var(--blue-light);
    color: var(--blue);
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
  }

  .panel-body {
    padding: 16px 22px;
  }

  /* ── CHECK-IN LIST ────────────────────── */
  .checkin-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: var(--radius-sm);
    margin-bottom: 6px;
    transition: background .2s;
    cursor: default;
  }

  .checkin-item:hover { background: #f8fafc; }

  .checkin-item:last-child { margin-bottom: 0; }

  .checkin-avatar {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #a855f7);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
    letter-spacing: .5px;
  }

  .checkin-name {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-main);
  }

  .checkin-room {
    font-size: 11.5px;
    color: var(--text-sub);
    margin-top: 2px;
  }

  .checkin-badge {
    margin-left: auto;
    font-size: 10.5px;
    font-weight: 600;
    background: var(--green-light);
    color: var(--green);
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .empty-state {
    text-align: center;
    padding: 28px 0;
    color: var(--text-sub);
    font-size: 13px;
  }

  .empty-state .icon { font-size: 28px; margin-bottom: 8px; }

  /* ── ROOM GRID ────────────────────────── */
  .room-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 14px;
  }

  .legend-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px;
    color: var(--text-sub);
    font-weight: 500;
  }

  .legend-dot {
    width: 9px; height: 9px;
    border-radius: 3px;
  }

  .room-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
  }

  .room-box {
    padding: 10px 6px;
    border-radius: 10px;
    text-align: center;
    font-size: 11.5px;
    font-weight: 700;
    border: 1.5px solid transparent;
    cursor: default;
    transition: transform .2s, box-shadow .2s;
    position: relative;
  }

  .room-box:hover {
    transform: scale(1.07);
    box-shadow: 0 4px 12px rgba(0,0,0,0.10);
    z-index: 1;
  }

  .available {
    background: var(--green-light);
    color: var(--green);
    border-color: #bbf7d0;
  }

  .occupied {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fecaca;
  }

  .cleaning {
    background: #fef3c7;
    color: #d97706;
    border-color: #fde68a;
  }

  .reserved {
    background: var(--blue-light);
    color: var(--blue);
    border-color: #bfdbfe;
  }

  /* ── ANIMATIONS ───────────────────────── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .5; transform: scale(1.3); }
  }

  /* ── RESPONSIVE ───────────────────────── */
  @media (max-width: 900px) {
    .cards-grid { grid-template-columns: 1fr 1fr; }
    .bottom-grid { grid-template-columns: 1fr; }
  }

  @media (max-width: 600px) {
    .cards-grid { grid-template-columns: 1fr; }
    .room-grid  { grid-template-columns: repeat(4, 1fr); }
  }
</style>


<div class="dash-wrap">

  <!-- ── HEADING ── -->
  <div class="dash-heading">
    <div>
      <h3>Dashboard Resepsionis</h3>
      <p class="sub">Selamat datang kembali — pantau aktivitas hotel hari ini</p>
    </div>
    <div class="live-date">
      <span class="live-dot"></span>
      <span id="liveDateText">Memuat...</span>
    </div>
  </div>

  <!-- ── STAT CARDS ── -->
  <div class="cards-grid">

    <div class="stat-card blue-card">
      <div class="stat-icon">📅</div>
      <div>
        <div class="stat-label">Reservasi Hari Ini</div>
        <div class="stat-value">{{ $reservasiHariIni }}</div>
        <span class="stat-badge">Booking aktif</span>
      </div>
    </div>

    <div class="stat-card green-card">
      <div class="stat-icon">🛏️</div>
      <div>
        <div class="stat-label">Kamar Tersedia</div>
        <div class="stat-value">{{ $kamarTersedia }}</div>
        <span class="stat-badge">Siap ditempati</span>
      </div>
    </div>

    <div class="stat-card orange-card">
      <div class="stat-icon">🏨</div>
      <div>
        <div class="stat-label">Kamar Terisi</div>
        <div class="stat-value">{{ $kamarTerisi }}</div>
        <span class="stat-badge">Sedang dihuni</span>
      </div>
    </div>

  </div>

  <!-- ── BOTTOM ── -->
  <div class="bottom-grid">

    <!-- Check-In -->
    <div class="panel">
      <div class="panel-header">
        <span>Check-In Hari Ini</span>
        <span class="count-badge">{{ count($checkins) }} tamu</span>
      </div>
      <div class="panel-body">

        @forelse($checkins as $c)
          <div class="checkin-item">
            <div class="checkin-avatar">
              {{ strtoupper(substr($c->nama_tamu, 0, 2)) }}
            </div>
            <div>
              <div class="checkin-name">{{ $c->nama_tamu }}</div>
              <div class="checkin-room">🛏 Kamar {{ $c->kamar->nomor_kamar ?? '-' }}</div>
            </div>
            <span class="checkin-badge">✓ Check-In</span>
          </div>
        @empty
          <div class="empty-state">
            <div class="icon">🌙</div>
            <p>Belum ada tamu check-in hari ini</p>
          </div>
        @endforelse

      </div>
    </div>

    <!-- Status Kamar -->
    <div class="panel">
      <div class="panel-header">
        <span>Status Kamar</span>
      </div>
      <div class="panel-body">

        <!-- Legend -->
        <div class="room-legend">
          <div class="legend-item">
            <div class="legend-dot" style="background:#16a34a;"></div> Tersedia
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#dc2626;"></div> Terisi
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#d97706;"></div> Maintenance
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#2563eb;"></div> Reservasi
          </div>
        </div>

        <div class="room-grid">
          @foreach($kamars as $k)
            <div class="room-box
              @if($k->status == 'tersedia')   available
              @elseif($k->status == 'terisi') occupied
              @elseif($k->status == 'maintenance') cleaning
              @else reserved
              @endif
            ">
              {{ $k->nomor_kamar }}
            </div>
          @endforeach
        </div>

      </div>
    </div>

  </div>

</div>

<script>
  // Live date & time
  function updateDate() {
    const now = new Date();
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    document.getElementById('liveDateText').textContent =
      now.toLocaleDateString('id-ID', opts);
  }
  updateDate();
  setInterval(updateDate, 60000);
</script>

@endsection