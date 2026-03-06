<nav class="top-nav">
    <div class="container" style="margin-right: 25%">
        <div class="brand">
            <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI">
            <div>
            <strong>{{ __('home.site_name') }}</strong>
            </div>
        </div>

        <div class="nav-right">
            <div class="menu">
                @foreach ($navFeatures as $feature)
                    @php
                        $label = app()->getLocale() === 'en' && $feature->name_en ? $feature->name_en : $feature->name;
                        $isHome = $feature->path === '/' || strtolower($feature->name) === 'beranda';
                    @endphp

                    @if ($feature->type === 'dropdown' && $feature->subfeatures->count())
                        <div class="nav-dropdown">
                            <a href="#" class="nav-dropdown-toggle">
                                {{ $label }}
                                <svg class="nav-chevron" viewBox="0 0 20 20" fill="currentColor" width="12" height="12">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <div class="nav-dropdown-menu">
                                @foreach ($feature->subfeatures as $sub)
                                    @php
                                        $subLabel = app()->getLocale() === 'en' && $sub->name_en ? $sub->name_en : $sub->name;
                                    @endphp
                                    <a href="{{ $sub->path ?? '#' }}">{{ $subLabel }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $isHome ? route('home') : ($feature->path ?? '#') }}"
                           class="{{ $isHome && request()->routeIs('home') ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="auth-utils">
                @auth
                    <a href="{{ route('dashboard') }}" class="login-link">{{ __('home.nav.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="login-link">{{ __('home.nav.login') }}</a>
                @endauth
                <div class="lang-switch">
                    <a href="{{ route('locale.switch', 'id') }}"
                        class="{{ app()->getLocale() === 'id' ? 'current' : '' }}">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}"
                        class="{{ app()->getLocale() === 'en' ? 'current' : '' }}">EN</a>
                </div>
            </div>
        </div>
    </div>
</nav>
