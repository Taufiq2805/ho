@extends('layouts.housekeeping')

@section('title', 'Dashboard Housekeeping')

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
  }

  .hk-body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text);
  }

  .page-heading { margin-bottom: 32px; animation: hkFadeUp 0.5s ease both; }
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
    font-size: 26px; font-weight: 800; letter-spacing: -0.4px; color: #fff;
  }
  .page-heading p { font-size: 14px; color: var(--muted); margin-top: 4px; }

  .section-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.12em;
    text-transform: uppercase; color: var(--muted);
    margin-bottom: 14px; margin-top: 28px;
  }

  .hk-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
  .hk-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }

  .hk-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px; padding: 22px 20px;
    transition: background .2s, transform .2s, box-shadow .2s;
    animation: hkFadeUp .5s ease both;
    position: relative; overflow: hidden;
  }
  .hk-card:hover { background: var(--card-hover); transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.35); }
  .hk-card:nth-child(1){animation-delay:.05s}
  .hk-card:nth-child(2){animation-delay:.12s}
  .hk-card:nth-child(3){animation-delay:.19s}
  .hk-card:nth-child(4){animation-delay:.26s}

  .hk-icon {
    width: 46px; height: 46px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px; font-size: 22px;
  }
  .hk-icon svg { width: 22px; height: 22px; stroke-width: 2; }

  .hk-icon.blue   { background:rgba(56,189,248,.15);  color:var(--accent1); }
  .hk-icon.green  { background:rgba(52,211,153,.15);  color:var(--accent2); }
  .hk-icon.orange { background:rgba(251,146,60,.15);  color:var(--accent3); }
  .hk-icon.red    { background:rgba(248,113,113,.15); color:var(--accent4); }
  .hk-icon.purple { background:rgba(167,139,250,.15); color:var(--accent5); }

  .hk-label { font-size:12px; font-weight:600; color:var(--muted); margin-bottom:6px; }
  .hk-value { font-size:34px; font-weight:800; letter-spacing:-1px; line-height:1; color:#fff; }
  .hk-value.blue   { color:var(--accent1); }
  .hk-value.green  { color:var(--accent2); }
  .hk-value.orange { color:var(--accent3); }
  .hk-value.red    { color:var(--accent4); }
  .hk-value.purple { color:var(--accent5); }
  .hk-value .cur   { font-size:15px; font-weight:600; color:var(--muted); vertical-align:top; margin-top:6px; margin-right:3px; }

  .hk-badge {
    display:inline-flex; align-items:center; gap:4px;
    font-size:11px; font-weight:700; padding:3px 8px;
    border-radius:100px; margin-top:10px;
  }
  .hk-badge.green  { background:rgba(52,211,153,.15);  color:var(--accent2); }
  .hk-badge.red    { background:rgba(248,113,113,.15); color:var(--accent4); }
  .hk-badge.muted  { background:rgba(123,147,176,.15); color:var(--muted); }

  .hk-bar-bg { height:4px; border-radius:99px; background:rgba(255,255,255,.06); overflow:hidden; margin-top:14px; }
  .hk-bar    { height:100%; border-radius:99px; transition:width 1s cubic-bezier(.4,0,.2,1); }
  .hk-bar.blue   { background:var(--accent1); }

  .hk-blob { position:absolute; right:-14px; bottom:-14px; width:70px; height:70px; border-radius:50%; opacity:.08; pointer-events:none; }

  @keyframes hkFadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
  }

  @media(max-width:900px){ .hk-grid-4{grid-template-columns:repeat(2,1fr);} .hk-grid-3{grid-template-columns:1fr;} }
  @media(max-width:520px){ .hk-grid-4{grid-template-columns:1fr;} }
</style>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<div class="hk-body">

  {{-- Heading --}}
  <div class="page-heading">
    <div class="eyebrow">Housekeeping</div>
    <h3>Dashboard Housekeeping</h3>
    <p>Ringkasan kondisi kamar &amp; aktivitas housekeeping.</p>
  </div>

  {{-- Kondisi Kamar --}}
  <div class="section-label">Kondisi Kamar</div>
  <div class="hk-grid-4">

    <div class="hk-card">
      <div class="hk-icon blue">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
      </div>
      <div class="hk-label">Total Kamar</div>
      <div class="hk-value blue">{{ $totalKamar }}</div>
      <div class="hk-bar-bg"><div class="hk-bar blue" style="width:100%"></div></div>
      <div class="hk-blob" style="background:var(--accent1)"></div>
    </div>

    <div class="hk-card">
      <div class="hk-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-5"/></svg>
      </div>
      <div class="hk-label">Kamar Tersedia</div>
      <div class="hk-value green">{{ $kamarTersedia }}</div>
      <div class="hk-badge green">Siap ditempati</div>
      <div class="hk-blob" style="background:var(--accent2)"></div>
    </div>

    <div class="hk-card">
      <div class="hk-icon orange">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a5 5 0 01-6.4 6.4l-4 4a2 2 0 01-2.8-2.8l4-4A5 5 0 0114.7 6.3z"/></svg>
      </div>
      <div class="hk-label">Kamar Maintenance</div>
      <div class="hk-value orange">{{ $kamarMaintenance }}</div>
      <div class="hk-badge muted">Sedang diperbaiki</div>
      <div class="hk-blob" style="background:var(--accent3)"></div>
    </div>

    <div class="hk-card">
      <div class="hk-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
      </div>
      <div class="hk-label">Total Maintenance</div>
      <div class="hk-value red">{{ $totalMaintenance }}</div>
      <div class="hk-badge red">Perlu perhatian</div>
      <div class="hk-blob" style="background:var(--accent4)"></div>
    </div>

  </div>

  {{-- Keuangan --}}
  <div class="section-label">Keuangan</div>
  <div class="hk-grid-3">
    <div class="hk-card">
      <div class="hk-icon purple">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
      </div>
      <div class="hk-label">Pengeluaran Bulan Ini</div>
      <div class="hk-value purple">
        <span class="cur">Rp</span>{{ number_format($pengeluaranBulanIni, 0, ',', '.') }}
      </div>
      <div class="hk-badge muted" style="margin-top:12px;">Bulan ini</div>
      <div class="hk-blob" style="background:var(--accent5)"></div>
    </div>
  </div>

</div>

<script>
  document.querySelectorAll('.hk-bar').forEach(el => {
    const w = el.style.width; el.style.width = '0';
    requestAnimationFrame(() => setTimeout(() => el.style.width = w, 150));
  });
</script>

@endsection