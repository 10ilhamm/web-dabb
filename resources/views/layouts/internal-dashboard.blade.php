<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('home.dashboard.title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/internal-dashboard.css') }}">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">
                <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI">
                <div>
                    <strong>{{ __('home.site_name') }}</strong>
                    <div style="font-size:12px;opacity:.8">{{ __('home.tagline') }}</div>
                </div>
            </div>

            <nav class="side-menu">
                <a href="#" class="active">{{ __('home.nav.home') }}</a>
                <a href="#">Laporan</a>
                <a href="#">CMS</a>
                <a href="#">Pengguna</a>
            </nav>

            <div class="side-bottom">
                <nav class="side-menu">
                    <a href="{{ route('home') }}">{{ __('home.dashboard.view_site') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width:100%;text-align:left;display:block;color:#fff;background:transparent;border:0;padding:12px 10px;border-radius:8px;cursor:pointer;font:inherit;">
                            {{ __('home.dashboard.logout') }}
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <main>
            <div class="topbar">
                <div>{{ app()->getLocale() === 'id' ? 'ID' : 'EN' }}</div>
                <div style="font-weight: 600;">{{ auth()->user()->name ?? 'Nama Saya' }}</div>
            </div>

            <div class="content">
                <h1 style="margin-top:0">{{ __('home.dashboard.title') }} - {{ $roleLabel ?? '' }}</h1>

                <section class="card profile">
                    <div class="avatar"></div>
                    <div>
                        <div style="font-size: 26px; font-weight: 700;">{{ auth()->user()->name ?? 'Nama Saya' }}</div>
                        <div style="color:#7f8798;">{{ auth()->user()->email ?? 'nama.saya@email.com' }} | {{ $roleLabel ?? '' }}</div>
                    </div>
                </section>

                <section class="card">
                    <h2>{{ __('home.dashboard.profile') }}</h2>
                    <div class="data-grid">
                        <div class="field"><label>Email</label><div>{{ auth()->user()->email ?? '-' }}</div></div>
                        <div class="field"><label>Role</label><div>{{ $roleLabel ?? '-' }}</div></div>
                        <div class="field"><label>Bahasa</label><div>{{ app()->getLocale() === 'id' ? 'Indonesia' : 'English' }}</div></div>
                        <div class="field"><label>Alamat</label><div>Jl. Raya Derwati, Bandung</div></div>
                        <div class="field"><label>Nomor Telepon</label><div>(+62) 81234567890</div></div>
                        <div class="field"><label>Status</label><div>Aktif</div></div>
                    </div>
                    <button class="btn">{{ __('home.dashboard.edit') }}</button>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
