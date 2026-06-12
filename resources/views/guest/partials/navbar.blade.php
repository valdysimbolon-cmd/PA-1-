{{-- ══════════════════════════════════════════
    NAVBAR RESPONSIF — UNTUK PUBLIC GUEST & MAHASISWA
══════════════════════════════════════════ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap');

:root {
  --forest:     #1A4D2E;
  --forest-mid: #2E7D52;
  --accent:     #4CAF7C;
  --teal:       #1D9E75;
  --cream:      #F0F7F2;
  --cream-deep: #DFF0E7;
  --white:      #FFFFFF;
  --ink:        #0D2A1A;
  --muted:      #6B8F7A;
}

.bp-nav {
  position: sticky; top: 0; z-index: 1000;
  background: rgba(255,255,255,.97);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid var(--cream-deep);
  font-family: 'DM Sans', sans-serif;
  transition: box-shadow .3s;
}
.bp-nav.scrolled { box-shadow: 0 2px 20px rgba(26,77,46,.09); }
.bp-nav .bp-container {
  max-width: 1200px; margin: 0 auto; padding: 0 1rem;
  display: flex; align-items: center; height: 66px; gap: 0;
}

/* Brand */
.bp-brand { display: flex; align-items: center; gap: .7rem; text-decoration: none; margin-right: auto; flex-shrink: 0; }
.bp-brand img { height: 36px; width: auto; display: block; }
.bp-brand-sep { width: 1px; height: 28px; background: var(--cream-deep); flex-shrink: 0; }
.bp-brand-text { line-height: 1.2; }
.bp-brand-main { display: block; font-size: .78rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--forest); }
.bp-brand-sub { display: block; font-size: .6rem; font-weight: 500; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }

/* Nav List Desktop */
.bp-nav-list {
  display: flex; align-items: center; list-style: none; margin: 0; padding: 0; gap: .4rem;
}
.bp-nav-link {
  display: flex; align-items: center; gap: .28rem;
  padding: .5rem .8rem; font-size: .81rem; font-weight: 500; color: var(--ink);
  text-decoration: none; white-space: nowrap; border-bottom: 2px solid transparent;
  transition: color .2s, border-color .2s; cursor: pointer; user-select: none;
}
.bp-nav-link:hover, .bp-nav-link.bp-active { color: var(--forest); border-bottom-color: var(--accent); }

/* Chevron */
.bp-chev { display: inline-block; width: 7px; height: 7px; border-right: 1.5px solid currentColor; border-bottom: 1.5px solid currentColor; transform: rotate(45deg) translateY(-1px); transition: transform .22s; flex-shrink: 0; margin-left: 1px; }
.bp-dropdown.bp-open > .bp-nav-link .bp-chev { transform: rotate(-135deg) translateY(-1px); }

/* Dropdown Desktop */
.bp-dropdown { position: relative; }
.bp-drop {
  position: absolute; top: calc(100% + 4px); left: 50%; transform: translateX(-50%) translateY(-8px);
  min-width: 196px; background: var(--white); border: 1px solid var(--cream-deep);
  box-shadow: 0 12px 32px rgba(26,77,46,.11); padding: .4rem 0; list-style: none; margin: 0;
  opacity: 0; visibility: hidden; transition: opacity .22s ease, transform .22s ease, visibility .22s; pointer-events: none;
}
.bp-dropdown.bp-open .bp-drop { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); pointer-events: auto; }
.bp-drop::before { content: ''; position: absolute; top: -5px; left: 50%; transform: translateX(-50%) rotate(45deg); width: 8px; height: 8px; background: var(--white); border-left: 1px solid var(--cream-deep); border-top: 1px solid var(--cream-deep); }
.bp-drop-item { display: flex; align-items: center; gap: .5rem; padding: .55rem 1.1rem; font-size: .8rem; font-weight: 500; color: var(--ink); text-decoration: none; white-space: nowrap; transition: background .18s, color .18s; }
.bp-drop-item::before { content: ''; display: block; width: 5px; height: 5px; border-radius: 50%; background: var(--cream-deep); flex-shrink: 0; transition: background .18s; }
.bp-drop-item:hover { background: var(--cream); color: var(--forest); }
.bp-drop-item:hover::before { background: var(--accent); }

/* Tombol */
.bp-btn-mybio {
  display: inline-block; padding: .48rem 1.2rem;
  background: transparent; color: var(--forest-mid) !important; font-size: .76rem; font-weight: 700;
  letter-spacing: .06em; text-transform: uppercase; text-decoration: none;
  border: 1.5px solid var(--forest-mid);
  clip-path: polygon(0 0, calc(100% - 9px) 0, 100% 9px, 100% 100%, 0 100%);
  transition: all .22s; flex-shrink: 0;
}
.bp-btn-mybio:hover { background: var(--forest-mid); color: var(--white) !important; box-shadow: 0 5px 15px rgba(46,125,82,.2); }

.bp-btn-login {
  display: inline-block; padding: .48rem 1.35rem;
  background: var(--forest); color: var(--white) !important; font-size: .76rem; font-weight: 700;
  letter-spacing: .09em; text-transform: uppercase; text-decoration: none;
  clip-path: polygon(0 0, calc(100% - 9px) 0, 100% 9px, 100% 100%, 0 100%);
  transition: background .22s, box-shadow .22s; flex-shrink: 0;
}
.bp-btn-login:hover { background: var(--forest-mid); box-shadow: 0 5px 18px rgba(26,77,46,.28); }

/* Hamburger (Mobile) */
.bp-hamburger { display: none; flex-direction: column; gap: 5px; background: none; border: none; padding: .4rem; cursor: pointer; margin-left: auto; z-index: 1001; }
.bp-hamburger span { display: block; width: 22px; height: 1.5px; background: var(--forest); transition: all .28s; }
.bp-hamburger.bp-open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
.bp-hamburger.bp-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.bp-hamburger.bp-open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

/* ═══════════════════════════════════════════
   RESPONSIVE (≤ 991px) 
═══════════════════════════════════════════ */
@media (max-width: 991px) {
  .bp-hamburger { display: flex; }
  
  .bp-nav-list {
    display: none;
    flex-direction: column;
    align-items: stretch;
    position: absolute;
    top: 66px;
    left: 0;
    right: 0;
    background: var(--white);
    border-top: 1px solid var(--cream-deep);
    padding: 0.75rem 1rem 1.25rem;
    box-shadow: 0 12px 32px rgba(26,77,46,.12);
    gap: 0;
    max-height: calc(100vh - 66px);
    overflow-y: auto;
  }
  
  .bp-nav-list.bp-open { display: flex; }
  
  /* Menu item mobile */
  .bp-nav-link {
    padding: 0.75rem 0.5rem;
    font-size: 0.9rem;
    white-space: normal;
    justify-content: space-between;
    width: 100%;
  }
  
  /* Dropdown mobile */
  .bp-dropdown { position: static; }
  .bp-drop {
    position: static;
    transform: none !important;
    opacity: 1 !important;
    visibility: visible !important;
    box-shadow: none;
    border: none;
    background: var(--cream);
    display: none;
    padding: 0.5rem 0;
    margin-top: 0.25rem;
    width: 100%;
  }
  .bp-dropdown.bp-open .bp-drop { display: block; }
  .bp-drop::before { display: none; }
  
  .bp-drop-item {
    padding: 0.6rem 0.5rem 0.6rem 1.8rem;
    white-space: normal;
    font-size: 0.85rem;
  }
  .bp-drop-item::before { width: 4px; height: 4px; margin-right: 0.5rem; }
  
  /* Tombol MyBioproses & Login di mobile */
  .bp-btn-mybio, .bp-btn-login {
    margin: 0.5rem 0.5rem 0;
    text-align: center;
    clip-path: none;
    display: block;
    width: calc(100% - 1rem);
  }
  .bp-btn-login.logout-btn { background: #991b1b; margin-top: 0.75rem; }
  
  /* Nama mahasiswa di mobile */
  .bp-nav-link[style*="cursor: default"] { padding-left: 0.5rem; }
}

/* Ukuran HP kecil (≤ 480px) */
@media (max-width: 480px) {
  .bp-brand img { height: 30px; }
  .bp-brand-main { font-size: 0.68rem; }
  .bp-brand-sub { font-size: 0.52rem; }
  .bp-container { padding: 0 0.75rem; }
}
</style>

<nav class="bp-nav" id="bpNav">
  <div class="bp-container">
    <a class="bp-brand" href="/">
      <img src="{{ asset('guest_assets/img/logo-del.png') }}" alt="Logo IT Del">
      <div class="bp-brand-sep"></div>
      <div class="bp-brand-text">
        <span class="bp-brand-main">Teknik Bioproses</span>
        <span class="bp-brand-sub">Institut Teknologi Del</span>
      </div>
    </a>

    <button class="bp-hamburger" id="bpHam" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>

    <ul class="bp-nav-list" id="bpList">
      {{-- 1. Beranda --}}
      <li><a class="bp-nav-link {{ request()->is('/') ? 'bp-active' : '' }}" href="/">Beranda</a></li>

      {{-- 2. Profil --}}
      <li><a class="bp-nav-link {{ request()->is('profile*') ? 'bp-active' : '' }}" href="{{ route('guest.profil_bioproses') }}">Profil</a></li>

      {{-- 3. Akademik --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Akademik <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.kurikulum') }}">Kurikulum</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.dosen_staff') }}">Dosen & Staff</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.beasiswa') }}">Beasiswa</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.prestasi') }}">Prestasi</a></li>
        </ul>
      </li>

      {{-- 4. Kabar Bioproses --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Kabar Bioproses <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.news') }}">Berita & Kegiatan</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.mitra.index') }}">Mitra Strategis</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.testimoni.index') }}">Testimoni Alumni</a></li>
        </ul>
      </li>

      {{-- 5. Lab & Fasilitas --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Lab & Fasilitas <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.labs') }}">Unit Laboratorium</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.facilities') }}">Ruangan & Sarana</a></li>
          @if(Auth::check() && session('user_type') === 'mahasiswa')
            <li><a class="bp-drop-item" href="{{ route('public.peminjaman') }}" style="color: var(--teal); font-weight: 600;">Peminjaman Alat</a></li>
          @endif
        </ul>
      </li>

      {{-- 6. Dokumen --}}
      <li><a class="bp-nav-link {{ request()->is('dokumen*') ? 'bp-active' : '' }}" href="{{ route('public.archives') }}">Dokumen</a></li>

      {{-- AUTHENTICATION SECTION --}}
      @if(Auth::check() && session('user_type') === 'mahasiswa')
        <li><span class="bp-nav-link" style="color: var(--forest); font-weight: 600; cursor: default;">Halo, {{ Auth::user()->name }}</span></li>
        <li>
          <a class="bp-btn-login logout-btn" href="{{ route('logout') }}" 
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
             style="background: #991b1b;">
             LOGOUT
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </li>
      @else
        <li><a class="bp-btn-mybio" href="{{ route('mybioproses.auth') }}">MyBioproses</a></li>
        <li><a class="bp-btn-login" href="{{ route('login') }}">LOGIN</a></li>
      @endif
    </ul>
  </div>
</nav>

<script>
(function () {
  const nav  = document.getElementById('bpNav');
  const ham  = document.getElementById('bpHam');
  const list = document.getElementById('bpList');
  const dds  = document.querySelectorAll('[data-dd]');

  // Scroll shadow effect
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 8), { passive: true });

  // Toggle hamburger menu
  ham.addEventListener('click', (e) => {
    e.stopPropagation();
    ham.classList.toggle('bp-open');
    list.classList.toggle('bp-open');
  });

  // Dropdown toggle (mobile friendly)
  dds.forEach(dd => {
    const trigger = dd.querySelector('.bp-nav-link');
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const isOpen = dd.classList.contains('bp-open');
      // Close all other dropdowns
      dds.forEach(d => d.classList.remove('bp-open'));
      if (!isOpen) dd.classList.add('bp-open');
    });
  });

  // Close all when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.bp-nav-list') && !e.target.closest('.bp-hamburger')) {
      dds.forEach(d => d.classList.remove('bp-open'));
      list.classList.remove('bp-open');
      ham.classList.remove('bp-open');
    }
  });
})();
</script>