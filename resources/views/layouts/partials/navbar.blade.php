{{-- ══════════════════════════════════════════
    NAVBAR FINAL — Teknik Bioproses IT Del
    - Sinkron denga Struktur Admin
    - Desain Premium & Elegan
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
  max-width: 1200px; margin: 0 auto; padding: 0 2rem;
  display: flex; align-items: center; height: 66px; gap: 0;
}

.bp-brand { display: flex; align-items: center; gap: .7rem; text-decoration: none; margin-right: auto; flex-shrink: 0; }
.bp-brand img { height: 36px; width: auto; display: block; }
.bp-brand-sep { width: 1px; height: 28px; background: var(--cream-deep); flex-shrink: 0; }
.bp-brand-text { line-height: 1.2; }
.bp-brand-main { display: block; font-size: .78rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--forest); }
.bp-brand-sub { display: block; font-size: .6rem; font-weight: 500; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }

.bp-nav-list { display: flex; align-items: center; list-style: none; margin: 0; padding: 0; gap: 0; }
.bp-nav-link {
  display: flex; align-items: center; gap: .28rem;
  padding: .5rem .8rem; font-size: .81rem; font-weight: 500; color: var(--ink);
  text-decoration: none; white-space: nowrap; border-bottom: 2px solid transparent;
  transition: color .2s, border-color .2s; cursor: pointer; user-select: none;
}
.bp-nav-link:hover, .bp-nav-link.bp-active { color: var(--forest); border-bottom-color: var(--accent); }

.bp-chev { display: inline-block; width: 7px; height: 7px; border-right: 1.5px solid currentColor; border-bottom: 1.5px solid currentColor; transform: rotate(45deg) translateY(-1px); transition: transform .22s; flex-shrink: 0; margin-left: 1px; }
.bp-dropdown.bp-open > .bp-nav-link .bp-chev { transform: rotate(-135deg) translateY(-1px); }

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
.bp-drop-divider { height: 1px; background: var(--cream-deep); margin: .3rem .8rem; }

.bp-btn-login {
  display: inline-block; margin-left: .6rem; padding: .48rem 1.35rem;
  background: var(--forest); color: var(--white) !important; font-size: .76rem; font-weight: 700;
  letter-spacing: .09em; text-transform: uppercase; text-decoration: none;
  clip-path: polygon(0 0, calc(100% - 9px) 0, 100% 9px, 100% 100%, 0 100%);
  transition: background .22s, box-shadow .22s; flex-shrink: 0;
}
.bp-btn-login:hover { background: var(--forest-mid); box-shadow: 0 5px 18px rgba(26,77,46,.28); }

.bp-hamburger { display: none; flex-direction: column; gap: 5px; background: none; border: none; padding: .4rem; cursor: pointer; margin-left: auto; }
.bp-hamburger span { display: block; width: 22px; height: 1.5px; background: var(--forest); transition: all .28s; }
.bp-hamburger.bp-open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
.bp-hamburger.bp-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.bp-hamburger.bp-open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

@media (max-width: 991px) {
  .bp-hamburger { display: flex; }
  .bp-nav-list { display: none; flex-direction: column; align-items: stretch; position: absolute; top: 66px; left: 0; right: 0; background: var(--white); border-top: 1px solid var(--cream-deep); padding: .5rem 1rem 1rem; box-shadow: 0 12px 32px rgba(26,77,46,.1); }
  .bp-nav-list.bp-open { display: flex; }
  .bp-drop { position: static; transform: none !important; opacity: 1 !important; visibility: visible !important; box-shadow: none; border: none; background: var(--cream); display: none; }
  .bp-dropdown.bp-open .bp-drop { display: block; }
  .bp-btn-login { margin: .6rem .6rem 0; text-align: center; clip-path: none; display: block; }
}
</style>

<nav class="bp-nav" id="bpNav">
  <div class="bp-container">
    
    {{-- Brand --}}
    <a class="bp-brand" href="/">
      <img src="{{ asset('guest_assets/img/logo-del.png') }}" alt="Logo IT Del">
      <div class="bp-brand-sep"></div>
      <div class="bp-brand-text">
        <span class="bp-brand-main">Teknik Bioproses</span>
        <span class="bp-brand-sub">Institut Teknologi Del</span>
      </div>
    </a>

    {{-- Hamburger --}}
    <button class="bp-hamburger" id="bpHam" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>

    {{-- Nav List --}}
    <ul class="bp-nav-list" id="bpList">
      
      <li><a class="bp-nav-link {{ request()->is('/') ? 'bp-active' : '' }}" href="/">Beranda</a></li>

      <li><a class="bp-nav-link {{ request()->is('profile*') ? 'bp-active' : '' }}" href="{{ route('guest.profil_bioproses') }}">Profil</a></li>


      {{-- 2. Kabar Bioproses --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Kabar Bioproses <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.news') }}">Berita & Kegiatan</a></li>
          <li>
    <a class="bp-drop-item" href="{{ route('public.announcements') }}">Pengumuman</a>
            <li><a class="bp-drop-item" href="{{ route('public.mitra.index') }}">Mitra Strategis</a></li>
        <li><a class="bp-drop-item" href="{{ route('public.testimoni.index') }}">Testimoni Alumni</a></li>
</li>
        </ul>
      </li>

      {{-- 3. Akademik --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Akademik <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.kurikulum') }}">Kurikulum</a></li>
          <li><a class="bp-drop-item" href="{{ route('public.dosen_staff') }}">Dosen & Staff</a></li>
          <li>
    <a class="bp-drop-item" href="{{ route('public.beasiswa') }}">Beasiswa</a>
</li>
          <li><a class="bp-drop-item" href="{{ route('public.prestasi') }}">Prestasi</a></li>
        </ul>
      </li>

      {{-- 4. Dokumen (Single Link) --}}
      <li><a class="bp-nav-link {{ request()->is('dokumen*') ? 'bp-active' : '' }}" href="{{ route('public.archives') }}">Dokumen</a></li>

      {{-- 5. Lab & Fasilitas --}}
      <li class="bp-dropdown" data-dd>
        <span class="bp-nav-link">Lab & Fasilitas <i class="bp-chev"></i></span>
        <ul class="bp-drop">
          <li><a class="bp-drop-item" href="{{ route('public.labs') }}">Unit Laboratorium</a></li>
              <a class="bp-drop-item" href="{{ route('public.facilities') }}">
        Ruangan & Sarana
    </a>
        </ul>
      </li>

      <li><a class="bp-btn-login" href="{{ route('login') }}">LOGIN</a></li>
    </ul>
  </div>
</nav>

<script>
(function () {
  const nav  = document.getElementById('bpNav');
  const ham  = document.getElementById('bpHam');
  const list = document.getElementById('bpList');
  const dds  = document.querySelectorAll('[data-dd]');

  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 8), { passive: true });

  ham.addEventListener('click', (e) => {
    e.stopPropagation();
    ham.classList.toggle('bp-open');
    list.classList.toggle('bp-open');
  });

  dds.forEach(dd => {
    const trigger = dd.querySelector('.bp-nav-link');
    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = dd.classList.contains('bp-open');
      dds.forEach(d => d.classList.remove('bp-open'));
      if (!isOpen) dd.classList.add('bp-open');
    });
  });

  document.addEventListener('click', () => {
    dds.forEach(d => d.classList.remove('bp-open'));
    list.classList.remove('bp-open');
    ham.classList.remove('bp-open');
  });
})();
</script>