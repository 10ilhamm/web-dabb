<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('home.site_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
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
                    <a href="#" class="active">{{ __('home.nav.home') }}</a>
                    <a href="#">{{ __('home.nav.profile') }}</a>
                    <a href="#">{{ __('home.nav.exhibition') }}</a>
                    <a href="#">{{ __('home.nav.publication') }}</a>
                    <a href="#">{{ __('home.nav.service') }}</a>
                    <a href="#">{{ __('home.nav.contact') }}</a>
                </div>

                <div class="auth-utils">
                    <a href="{{ route('login') }}" class="login-link">{{ __('home.nav.login') }}</a>
                    <div class="lang-switch">
                        <a href="{{ route('locale.switch', 'id') }}" class="{{ app()->getLocale() === 'id' ? 'current' : '' }}">ID</a>
                        <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'current' : '' }}">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('video/library-books.mp4') }}" type="video/mp4">
        </video>
        <div class="container hero-grid">
            <div>
                <h1>{{ __('home.hero_title') }}</h1>
                <a class="cta" href="#info-section">{{ __('home.hero_cta') }}</a>
            </div>
            <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI" class="hero-logo">
        </div>
    </header>

    <div class="feature-strip">
        <div class="left">
            <div class="text">{{ __('home.feature_strip.left') }}</div>
            <a class="btn" href="#">{{ __('home.feature_strip.middle') }}</a>
        </div>
        <div class="right">
            <a class="btn" href="#">{{ __('home.feature_strip.right_button') }}</a>
            <div class="text">{{ __('home.feature_strip.right_text') }}</div>
        </div>
    </div>

    <section id="info-section">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.info_title') }}</h2>
            <div class="separator"></div>
            <div class="info-grid">
                <img class="info-photo" src="{{ asset('image/kantordabb.png') }}" alt="Kantor DABB">
                <p>{{ __('home.sections.info_1') }}</p>
                <img class="info-photo" src="{{ asset('image/pegawai1.png') }}" alt="Pegawai DABB">
                <p>{{ __('home.sections.info_2') }}</p>
            </div>
        </div>
    </section>

    <section class="activities">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.activities') }}</h2>
            <div class="separator"></div>
            @php
                $colors = ['#D06767','#3598DB','#89DB51','#000000','#DB420F','#E660D4'];
            @endphp
            <div class="activity-list">
                @foreach(__('home.activity_items') as $index => $item)
                    <div class="activity-card">
                        <div class="activity-number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="activity-text" style="background: {{ $colors[$index] }}">{{ $item }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="links-related">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.related') }}</h2>
            <div class="separator"></div>
            <div class="logo-link">
                <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI">
            </div>
        </div>
    </section>

    <section class="gallery">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.gallery') }}</h2>
            <div class="separator"></div>
            <div class="items">
                <img src="{{ asset('image/pameran1.png') }}" alt="Pameran 1">
                <img src="{{ asset('image/desain_dokumentasi.png') }}" alt="Pameran 2">
                <img src="{{ asset('image/pameran1.png') }}" alt="Pameran 3">
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.stats') }}</h2>
            <div class="separator"></div>
            <div class="stats-grid">
                <img src="{{ asset('image/statistik_pengunjung.png') }}" alt="Statistik">
                <div class="counter">
                    <div class="number">10</div>
                    <div>{{ __('home.stats.total') }}</div>
                </div>
                <div class="counter">
                    <div class="number">3</div>
                    <div>{{ __('home.stats.today') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="related">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.youtube') }}</h2>
            <div class="separator"></div>
            <div style="position: relative; background: #f3f3f3; border-radius: 26px; padding: 24px;">
                <div class="youtube-slider" style="background: transparent; padding: 0;">
                    <div id="youtube-carousel" style="display: flex; justify-content: center;">
                        <div class="youtube-video" style="width: 100%; max-width: 740px;">
                            <iframe width="100%" height="416" src="https://www.youtube.com/embed/videoseries?list=PLbI3c9z8VpFVyuX9zPFDcjvMlNpDXCMJF" title="ANRI Arsip Nasional Republik Indonesia" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border-radius: 20px;"></iframe>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; justify-content: center; align-items: center; gap: 16px;">
                    <button id="youtube-prev" style="background: var(--blue); color: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center; transition: 0.3s;">❮</button>
                    <div style="display: flex; gap: 8px; justify-content: center;" id="youtube-dots">
                        <span class="youtube-dot active" style="width: 10px; height: 10px; border-radius: 50%; background: var(--blue); cursor: pointer;"></span>
                        <span class="youtube-dot" style="width: 10px; height: 10px; border-radius: 50%; background: #D0D0D0; cursor: pointer;"></span>
                        <span class="youtube-dot" style="width: 10px; height: 10px; border-radius: 50%; background: #D0D0D0; cursor: pointer;"></span>
                    </div>
                    <button id="youtube-next" style="background: var(--blue); color: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center; transition: 0.3s;">❯</button>
                </div>
            </div>
        </div>
    </section>

    <section class="instagram">
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.instagram') }}</h2>
            <div class="separator"></div>
            @php
                $igPosts = [
                    ['img' => 'image/instagram/post1.png', 'url' => 'https://www.instagram.com/p/DULJ3gDkkDZ/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA=='],
                    ['img' => 'image/instagram/post2.png', 'url' => 'https://www.instagram.com/p/DUIkzDcEjtW/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D'],
                    ['img' => 'image/instagram/post3.png', 'url' => 'https://www.instagram.com/p/DUGS9NCkiTd/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D'],
                    ['img' => 'image/instagram/post4.png', 'url' => 'https://www.instagram.com/p/DUDcoEWkpPr/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D'],
                    ['img' => 'image/instagram/post5.png', 'url' => 'https://www.instagram.com/p/DUCla4wku-w/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D'],
                    ['img' => 'image/instagram/post6.png', 'url' => 'https://www.instagram.com/p/DUA1BeEEsun/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D'],
                ];
            @endphp
            <div class="instagram-grid">
                <div class="left">
                    <a class="ig-profile-preview" href="https://www.instagram.com/arsipnasionalri/?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer">
                        <div class="ig-profile-head">
                            <img src="{{ asset('image/logo_anri.png') }}" alt="arsipnasionalri" class="ig-avatar">
                            <div>
                                <div class="ig-username">arsipnasionalri</div>
                                <div class="ig-name">Arsip Nasional RI</div>
                                <div class="ig-stats">4,106 posts · 119K followers · 91 following</div>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.instagram.com/arsipnasionalri/?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="follow-btn" target="_blank" rel="noopener noreferrer">Follow Kami</a>
                </div>
                <div class="right">
                    @foreach($igPosts as $index => $post)
                        <a class="ig-post" href="{{ $post['url'] }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset($post['img']) }}" alt="Instagram konten {{ $index + 1 }}" loading="lazy">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.faq') }}</h2>
            <div class="separator"></div>
            <div class="faq-list">
                @foreach(__('home.faq_items') as $faq)
                    <div class="faq-item">{{ $faq }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div>
                <div class="footer-title">{{ __('home.footer.title') }}</div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1647370889287!2d107.6724258!3d-6.963769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c3b997b00f17%3A0xa05bd0bfa977d91c!2sArsip%20Nasional%20RI%2C%20Depo%20Arsip%20Berkelanjutan%2C%20Bandung!5e0!3m2!1sid!2sid!4v1704369600000" width="100%" height="280" style="border:0;border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                <a href="#">{{ __('home.nav.home') }}</a>
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

    <script src="{{ asset('js/welcome.js') }}" defer></script>
</body>
</html>
