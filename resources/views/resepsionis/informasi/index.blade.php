@extends('layouts.resepsionis')

@section('title', 'Informasi Hotel')

@section('content')

{{-- ===================== STYLE ===================== --}}
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@400;500;600&display=swap');

  :root {
    --blue-accent:   #3b82f6;
    --green-accent:  #22c55e;
    --orange-accent: #f97316;
    --navy:          #1e3a5f;
    --card-radius:   18px;
    --transition:    all .35s cubic-bezier(.4,0,.2,1);
  }

  /* ── Page Heading ── */
  .page-heading h3 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--navy) 0%, var(--blue-accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: .25rem;
  }
  .page-heading .text-subtitle {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem;
    letter-spacing: .02em;
    color: #64748b;
  }
  .page-heading::after {
    content: '';
    display: block;
    margin-top: 12px;
    width: 60px;
    height: 4px;
    border-radius: 99px;
    background: linear-gradient(90deg, var(--blue-accent), var(--green-accent));
  }

  /* ── Empty State ── */
  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 64px 24px;
    gap: 16px;
    font-family: 'DM Sans', sans-serif;
    color: #94a3b8;
  }
  .empty-state .empty-icon {
    width: 72px; height: 72px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
  }
  .empty-state .empty-icon span {
    font-size: 2rem;
    color: #cbd5e1;
  }
  .empty-state p { font-size: .95rem; margin: 0; }

  /* ── Info Grid ── */
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  /* ── Info Card ── */
  .info-card {
    border-radius: var(--card-radius);
    overflow: hidden;
    background: #fff;
    border: 1px solid #e8eef6;
    box-shadow: 0 4px 16px rgba(30,58,95,.06);
    transition: var(--transition);
    position: relative;
    animation: fadeSlideUp .55s ease both;
    display: flex;
    flex-direction: column;
  }
  .info-card:hover {
    transform: translateY(-6px) scale(1.012);
    box-shadow: 0 20px 40px rgba(30,58,95,.13) !important;
    border-color: #c7d9f5;
  }

  /* Stagger delays for up to 9 items */
  .info-card:nth-child(1)  { animation-delay: .08s; }
  .info-card:nth-child(2)  { animation-delay: .16s; }
  .info-card:nth-child(3)  { animation-delay: .24s; }
  .info-card:nth-child(4)  { animation-delay: .32s; }
  .info-card:nth-child(5)  { animation-delay: .40s; }
  .info-card:nth-child(6)  { animation-delay: .48s; }
  .info-card:nth-child(7)  { animation-delay: .56s; }
  .info-card:nth-child(8)  { animation-delay: .64s; }
  .info-card:nth-child(9)  { animation-delay: .72s; }

  @keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0);    }
  }

  /* ── Card Image Wrapper ── */
  .info-card__img-wrap {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
    flex-shrink: 0;
  }
  .info-card__img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .55s cubic-bezier(.4,0,.2,1);
    display: block;
  }
  .info-card:hover .info-card__img-wrap img {
    transform: scale(1.06);
  }

  /* Gradient overlay on image */
  .info-card__img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,23,42,.45) 0%, transparent 60%);
    pointer-events: none;
    opacity: 0;
    transition: var(--transition);
  }
  .info-card:hover .info-card__img-wrap::after { opacity: 1; }

  /* No-image placeholder */
  .info-card__no-img {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 8px;
    color: #94a3b8;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
  }
  .info-card__no-img span.material-symbols-rounded {
    font-size: 2.4rem;
    color: #bfdbfe;
  }

  /* Accent bar top */
  .info-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--blue-accent), var(--green-accent));
    opacity: 0;
    transition: var(--transition);
    z-index: 2;
  }
  .info-card:hover::before { opacity: 1; }

  /* ── Card Body ── */
  .info-card__body {
    padding: 20px 22px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  /* Label chip */
  .info-card__chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #eff6ff;
    color: var(--blue-accent);
    border-radius: 99px;
    padding: 3px 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    width: fit-content;
  }
  .info-card__chip span {
    font-size: .9rem;
  }

  /* Card title */
  .info-card__title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
    margin: 0;
  }

  /* Divider */
  .info-card__divider {
    height: 1px;
    background: linear-gradient(90deg, #e2e8f0, transparent);
    border: none;
    margin: 2px 0;
  }

  /* Description */
  .info-card__desc {
    font-family: 'DM Sans', sans-serif;
    font-size: .875rem;
    color: #64748b;
    line-height: 1.65;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* ── Section Wrapper (white card) ── */
  .info-section-card {
    background: #fff;
    border-radius: var(--card-radius);
    border: 1px solid #e8eef6;
    box-shadow: 0 4px 16px rgba(30,58,95,.05);
    padding: 28px 28px 32px;
  }

  /* ── Section header row ── */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
  }
  .section-header__left {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .section-header__icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .section-header__icon span {
    font-size: 1.4rem;
    color: var(--blue-accent);
  }
  .section-header__title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }
  .section-header__sub {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    color: #94a3b8;
    margin: 0;
  }

  /* ── Count badge ── */
  .count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
    border: 1px solid #bfdbfe;
    border-radius: 99px;
    padding: 5px 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    color: #1e40af;
  }
  .count-badge span { font-size: .95rem; color: var(--blue-accent); }
</style>
{{-- ============================================================ --}}


{{-- Page Heading --}}
<div class="page-heading mb-4">
    <h3>Informasi Hotel</h3>
    <p class="text-subtitle">Detail dan fasilitas yang tersedia di hotel kami.</p>
</div>


{{-- Main Section Card --}}
<div class="info-section-card">

  {{-- Section header --}}
  <div class="section-header">
    <div class="section-header__left">
      <div class="section-header__icon">
        <span class="material-symbols-rounded">apartment</span>
      </div>
      <div>
        <p class="section-header__title">Fasilitas & Layanan</p>
        <p class="section-header__sub">Semua informasi terkait hotel ditampilkan di bawah ini.</p>
      </div>
    </div>
    <div class="count-badge">
      <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
      {{ count($informasi) }} Item
    </div>
  </div>

  {{-- Info Grid --}}
  @if($informasi->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">
        <span class="material-symbols-rounded">image_not_supported</span>
      </div>
      <p>Belum ada data informasi yang tersedia.</p>
    </div>
  @else
    <div class="info-grid">
      @foreach($informasi as $item)
        <div class="info-card">

          {{-- Image --}}
          <div class="info-card__img-wrap">
            @if($item->foto)
              <img src="{{ asset('storage/' . $item->foto) }}"
                   alt="{{ $item->nama }}">
            @else
              <div class="info-card__no-img">
                <span class="material-symbols-rounded">image_not_supported</span>
                <span>Tidak ada foto</span>
              </div>
            @endif
          </div>

          {{-- Body --}}
          <div class="info-card__body">

            <span class="info-card__chip">
              <span class="material-symbols-rounded">hotel</span>
              Fasilitas
            </span>

            <h2 class="info-card__title">{{ $item->nama }}</h2>

            <hr class="info-card__divider">

            <p class="info-card__desc">
              {{ $item->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
            </p>

          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>

@endsection