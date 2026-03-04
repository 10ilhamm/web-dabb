<footer>
    <div class="container footer-grid">
        <div>
            <div class="footer-title">{{ __('home.footer.title') }}</div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1647370889287!2d107.6724258!3d-6.963769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c3b997b00f17%3A0xa05bd0bfa977d91c!2sArsip%20Nasional%20RI%2C%20Depo%20Arsip%20Berkelanjutan%2C%20Bandung!5e0!3m2!1sid!2sid!4v1704369600000"
                width="100%" height="280" style="border:0;border-radius:8px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
            <div class="footer-title">{{ __('home.footer.info') }}</div>
            <p>{{ __('home.footer.address') }}</p>
            <p class="blue-text">{{ __('home.footer.phone') }}</p>
            <p class="blue-text">{{ __('home.footer.email') }}</p>
            <p class="blue-text">{{ __('home.footer.hours') }}</p>
        </div>
        <div>
            <div class="footer-title">{{ __('home.footer.menu') }}</div>
            <a href="{{ route('home') }}">{{ __('home.nav.home') }}</a>
            <a href="#">{{ __('home.nav.profile') }}</a>
            <a href="#">{{ __('home.nav.exhibition') }}</a>
            <a href="#">{{ __('home.nav.publication') }}</a>
            <a href="#">{{ __('home.nav.contact') }}</a>
        </div>
        <div>
            <div class="footer-title">{{ __('home.footer.managed') }}</div>
            <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI" style="width: 80px; margin-bottom: 10px;">
            <p>{{ __('home.site_name') }}</p>
        </div>
    </div>
    <div class="copyright">{{ __('home.footer.copyright') }}</div>
</footer>
