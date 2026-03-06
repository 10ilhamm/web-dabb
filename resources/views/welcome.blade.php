@extends('layouts.guest')

@section('title', __('home.site_name'))

@section('body-class')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endpush

@section('content')
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
                $colors = ['#D06767', '#3598DB', '#89DB51', '#000000', '#DB420F', '#E660D4'];
            @endphp
            <div class="activity-list">
                @foreach (__('home.activity_items') as $index => $item)
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
            <div class="youtube-wrap">
                <div class="youtube-carousel-container">
                    <div id="youtube-carousel" class="youtube-carousel">
                        <div class="youtube-item">
                            <div class="youtube-thumb">
                                <iframe src="https://www.youtube.com/embed/F2NhNTiNxoY" title="Video 1" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <button class="youtube-play"><span></span></button>
                            </div>
                        </div>
                        <div class="youtube-item">
                            <div class="youtube-thumb">
                                <iframe src="https://www.youtube.com/embed/kasMsnf9Cys" title="Video 2" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <button class="youtube-play"><span></span></button>
                            </div>
                        </div>
                        <div class="youtube-item">
                            <div class="youtube-thumb">
                                <iframe src="https://www.youtube.com/embed/LgdR55MPAnU" title="Video 3"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <button class="youtube-play"><span></span></button>
                            </div>
                        </div>
                        <div class="youtube-item">
                            <div class="youtube-thumb">
                                <iframe src="https://www.youtube.com/embed/NC9_ugD6vxo" title="Video 4"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <button class="youtube-play"><span></span></button>
                            </div>
                        </div>
                        <div class="youtube-item">
                            <div class="youtube-thumb">
                                <iframe src="https://www.youtube.com/embed/F2NhNTiNxoY" title="Video 5"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <button class="youtube-play"><span></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="youtube-nav">
                    <button id="youtube-prev" aria-label="Sebelumnya">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                            <path d="M18 22L12 16L18 10" stroke="#545456" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <span>
                        <span class="youtube-dot"></span>
                        <span class="youtube-dot"></span>
                        <span class="youtube-dot"></span>
                        <span class="youtube-dot"></span>
                        <span class="youtube-dot"></span>
                    </span>
                    <button id="youtube-next" aria-label="Berikutnya">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                            <path d="M14 10L20 16L14 22" stroke="#545456" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="section-title">{{ __('home.sections.instagram') }}</h2>
            <div class="separator"></div>
            @php
                $igPosts = [
                    [
                        'code' => 'DULJ3gDkkDZ',
                        'url' =>
                            'https://www.instagram.com/p/DULJ3gDkkDZ/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==',
                    ],
                    [
                        'code' => 'DUIkzDcEjtW',
                        'url' =>
                            'https://www.instagram.com/p/DUIkzDcEjtW/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D',
                    ],
                    [
                        'code' => 'DUGS9NCkiTd',
                        'url' =>
                            'https://www.instagram.com/p/DUGS9NCkiTd/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D',
                    ],
                    [
                        'code' => 'DUDcoEWkpPr',
                        'url' =>
                            'https://www.instagram.com/p/DUDcoEWkpPr/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D',
                    ],
                    [
                        'code' => 'DUCla4wku-w',
                        'url' =>
                            'https://www.instagram.com/p/DUCla4wku-w/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D',
                    ],
                    [
                        'code' => 'DUA1BeEEsun',
                        'url' =>
                            'https://www.instagram.com/p/DUA1BeEEsun/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D',
                    ],
                ];
            @endphp
            <div class="instagram-grid">
                <div class="left">
                    <a class="ig-profile-preview"
                        href="https://www.instagram.com/arsipnasionalri/?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        target="_blank" rel="noopener noreferrer">
                        <div class="ig-profile-head">
                            <img src="{{ asset('image/logo_anri.png') }}" alt="arsipnasionalri" class="ig-avatar">
                            <div>
                                <div class="ig-username">arsipnasionalri</div>
                                <div class="ig-name">Arsip Nasional RI</div>
                                <div class="ig-stats">4,106 posts · 119K followers · 91 following</div>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.instagram.com/arsipnasionalri/?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        class="follow-btn" target="_blank" rel="noopener noreferrer">Follow Kami</a>
                </div>
                <div class="right">
                    @foreach ($igPosts as $index => $post)
                        <div class="ig-post" aria-label="Instagram konten {{ $index + 1 }}">
                            <iframe src="https://www.instagram.com/p/{{ $post['code'] }}/embed/"
                                title="Instagram konten {{ $index + 1 }}" loading="lazy"
                                allowtransparency="true">
                            </iframe>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/welcome.js') }}" defer></script>
@endpush
