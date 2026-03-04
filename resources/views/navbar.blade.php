<nav class="top-nav">
    <div class="container">
        <div class="brand">
            <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI">
            <div>
                <strong>{{ __('home.site_name') }}</strong>
            </div>
        </div>

        <div class="nav-right">
            <div class="menu">
                <a href="{{ route('home') }}" class="active">{{ __('home.nav.home') }}</a>
                <a href="#">{{ __('home.nav.profile') }}</a>
                <a href="#">{{ __('home.nav.exhibition') }}</a>
                <a href="#">{{ __('home.nav.publication') }}</a>
                <a href="#">{{ __('home.nav.service') }}</a>
                <a href="#">{{ __('home.nav.contact') }}</a>
            </div>

            <div class="auth-utils">
                <a href="{{ route('login') }}" class="login-link">{{ __('home.nav.login') }}</a>
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
