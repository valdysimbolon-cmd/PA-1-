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

/* Tombol Pencarian */
.bp-search-btn {
    background: none;
    border: none;
    padding: .5rem .8rem;
    font-size: 1.1rem;
    color: var(--ink);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
.bp-search-btn:hover {
    color: var(--forest);
    background: var(--cream);
}
.bp-search-dropdown {
    display: none;
    position: absolute;
    right: -10px;
    top: calc(100% + 10px);
    background: white;
    padding: 8px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(26, 77, 46, 0.15);
    z-index: 1100;
    min-width: 300px;
    border: 1px solid var(--cream-deep);
    transform-origin: top right;
}
.bp-search-dropdown.bp-show {
    display: block;
    animation: bpPopIn 0.3s ease-out;
}
.bp-search-inner {
    display: flex;
    background: var(--cream);
    border-radius: 8px;
    padding: 4px;
    border: 1px solid var(--cream-deep);
}
.bp-search-inner input {
    border: none;
    background: none;
    padding: 8px 12px;
    font-size: 0.85rem;
    width: 100%;
    outline: none;
    color: var(--forest);
}
.bp-search-inner button {
    background: var(--forest);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 0 12px;
    transition: background 0.2s;
}
.bp-search-inner button:hover {
    background: var(--forest-mid);
}
.bp-search-toggle {
    position: relative;
}

@keyframes bpPopIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== TOMBOL MYBIOPROSES & LOGIN (diperbaiki) ===== */
.bp-btn-mybio, .bp-btn-login, .bp-btn-cis-logout {
  display: inline-block;
  padding: 0.55rem 1.5rem;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.25s ease;
  flex-shrink: 0;
  border-radius: 100px;
  border: none;
  cursor: pointer;
  line-height: 1.2;
}
.bp-btn-mybio {
  background: transparent;
  color: var(--forest-mid) !important;
  border: 1.5px solid var(--forest-mid);
}
.bp-btn-mybio:hover {
  background: var(--forest-mid);
  color: var(--white) !important;
  box-shadow: 0 5px 15px rgba(46,125,82,0.2);
  transform: translateY(-2px);
}
.bp-btn-login {
  background: var(--forest);
  color: var(--white) !important;
  box-shadow: 0 4px 12px rgba(26,77,46,0.15);
}
.bp-btn-login:hover {
  background: var(--forest-mid);
  box-shadow: 0 8px 20px rgba(26,77,46,0.25);
  transform: translateY(-2px);
}
.bp-btn-cis-logout {
  background: #1A4D2E !important;
  color: white !important;
  border: none;
}
.bp-btn-cis-logout:hover {
  background: #2E7D52 !important;
}

/* Hamburger (Mobile) */
.bp-hamburger { display: none; flex-direction: column; gap: 5px; background: none; border: none; padding: .4rem; cursor: pointer; margin-left: auto; z-index: 1001; }
.bp-hamburger span { display: block; width: 22px; height: 1.5px; background: var(--forest); transition: all .28s; }
.bp-hamburger.bp-open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
.bp-hamburger.bp-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.bp-hamburger.bp-open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

/* ===== RESPONSIVE (≤ 991px) ===== */
@media (max-width: 991px) {
  .bp-hamburger { display: flex; }
  .bp-nav-list {
    display: none;
    flex-direction: column;
    align-items: stretch;
    position: absolute;
    top: 66px; left: 0; right: 0;
    background: var(--white);
    border-top: 1px solid var(--cream-deep);
    padding: 0.75rem 1rem 1.25rem;
    box-shadow: 0 12px 32px rgba(26,77,46,.12);
    gap: 0;
    max-height: calc(100vh - 66px);
    overflow-y: auto;
  }
  .bp-nav-list.bp-open { display: flex; }
  .bp-nav-link { padding: 0.75rem 0.5rem; font-size: 0.9rem; white-space: normal; justify-content: space-between; width: 100%; }
  .bp-dropdown { position: static; }
  .bp-drop {
    position: static; transform: none !important; opacity: 1 !important; visibility: visible !important;
    box-shadow: none; border: none; background: var(--cream); display: none; padding: 0.5rem 0; margin-top: 0.25rem; width: 100%;
  }
  .bp-dropdown.bp-open .bp-drop { display: block; }
  .bp-drop::before { display: none; }
  .bp-drop-item { padding: 0.6rem 0.5rem 0.6rem 1.8rem; white-space: normal; font-size: 0.85rem; }
  .bp-drop-item::before { width: 4px; height: 4px; margin-right: 0.5rem; }

  .bp-btn-mybio, .bp-btn-login, .bp-btn-cis-logout {
    margin: 0.5rem 0.5rem 0;
    text-align: center;
    display: block;
    width: calc(100% - 1rem);
    border-radius: 50px;
  }
  .bp-search-dropdown {
    position: static;
    box-shadow: none;
    width: 100%;
    padding: 10px 0;
    border: none;
    background: transparent;
  }
  .bp-search-inner { background: white; }
}

@media (max-width: 480px) {
  .bp-brand img { height: 30px; }
  .bp-brand-main { font-size: 0.68rem; }
  .bp-brand-sub { font-size: 0.52rem; }
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
      <li><a class="bp-nav-link {{ request()->is('/') ? 'bp-active' : '' }}" href="/">Beranda</a></li>
      <li><a class="bp-nav-link {{ request()->is('profile*') ? 'bp-active' : '' }}" href="{{ route('guest.profil_bioproses') }}">Profil</a></li>

      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Akademik <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.kurikulum') }}">Kurikulum</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.dosen_staff') }}">Dosen & Staff</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.beasiswa') }}">Beasiswa</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.prestasi') }}">Prestasi</a></li>
        </ul>
      </li>

      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Kabar Bioproses <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.news') }}">Berita & Informasi</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.mitra.index') }}">Mitra Strategis</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.testimoni.index') }}">Testimoni Alumni</a></li>
        </ul>
      </li>

      {{-- ===== LAB & FASILITAS (dengan tambahan menu CIS) ===== --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Lab & Fasilitas <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.labs') }}">Unit Laboratorium</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.facilities') }}">Ruangan & Sarana</a></li>
          @if(session()->has('pinjam_user'))
            <li><hr class="dropdown-divider" style="margin:0.3rem 0; border-color: var(--cream-deep);"></li>
            <li><a class="bp-drop-item" href="{{ route('laboratorium.pinjam') }}" style="color: var(--teal); font-weight: 600;">Peminjaman Barang</a></li>
            <li><a class="bp-drop-item" href="{{ route('pinjam.status') }}" style="color: var(--teal); font-weight: 600;">Cek Status Pinjaman</a></li>
          @endif
        </ul>
      </li>

      <li><a class="bp-nav-link {{ request()->is('dokumen*') ? 'bp-active' : '' }}" href="{{ route('public.archives') }}">Dokumen</a></li>

      {{-- TOMBOL CARI --}}
      <li class="bp-search-toggle">
          <button id="searchToggleBtn" type="button" class="bp-search-btn" title="Cari">
              <i class="bi bi-search"></i>
          </button>
          <div id="searchForm" class="bp-search-dropdown">
              <form action="{{ route('public.search') }}" method="GET" class="bp-search-inner">
                  <input type="text" name="query" placeholder="Cari informasi..." value="{{ request('query') }}" required>
                  <button type="submit"><i class="bi bi-search"></i></button>
              </form>
          </div>
      </li>

      {{-- ===== AUTHENTICATION (dengan tambahan CIS logout) ===== --}}
      @if(session()->has('pinjam_user'))
        <li class="nav-item">
          <form action="{{ route('logout.cis') }}" method="POST" class="d-inline" id="cis-logout-form">
            @csrf
            <button type="submit" class="bp-btn-cis-logout" style="cursor:pointer;">
              LOGOUT ({{ session('pinjam_user')['username'] }})
            </button>
          </form>
        </li>
      @elseif(Auth::check() && session('user_type') === 'mahasiswa')
        {{-- Jika Mahasiswa login Laravel biasa (bukan CIS) --}}
        <li><span class="bp-nav-link" style="color: var(--forest); font-weight: 600; cursor: default;">Halo, {{ Auth::user()->name }}</span></li>
        <li>
          <a class="bp-btn-login" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: #991b1b;">LOGOUT</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </li>
      @else
        {{-- Jika belum login sama sekali --}}
        <li><a href="{{ route('mybioproses.auth') }}" class="bp-btn-mybio">MyBioproses</a></li>
        <li><a href="{{ route('login') }}" class="bp-btn-login">LOGIN</a></li>
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
  const searchBtn = document.getElementById('searchToggleBtn');
  const searchBox = document.getElementById('searchForm');

  // Toggle Search Form
  searchBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    searchBox.classList.toggle('bp-show');
    if(searchBox.classList.contains('bp-show')) searchBox.querySelector('input').focus();
  });

  // Scroll effect
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 8), { passive: true });

  // Toggle hamburger
  ham.addEventListener('click', (e) => {
    e.stopPropagation();
    ham.classList.toggle('bp-open');
    list.classList.toggle('bp-open');
  });

  // Dropdown toggle
  dds.forEach(dd => {
    const trigger = dd.querySelector('.bp-nav-link');
    trigger.addEventListener('click', (e) => {
      e.preventDefault(); e.stopPropagation();
      const isOpen = dd.classList.contains('bp-open');
      dds.forEach(d => d.classList.remove('bp-open'));
      if (!isOpen) dd.classList.add('bp-open');
    });
  });

  // Close all on outside click
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.bp-nav-list') && !e.target.closest('.bp-hamburger')) {
      dds.forEach(d => d.classList.remove('bp-open'));
      list.classList.remove('bp-open');
      ham.classList.remove('bp-open');
    }
    if (!e.target.closest('.bp-search-toggle')) {
      searchBox.classList.remove('bp-show');
    }
  });
})();
</script>