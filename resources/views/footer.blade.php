@php
    $footerSettings = \App\Models\Setting::all()->pluck('value', 'key');
    $getSetting = function($key, $default) use ($footerSettings) {
        return $footerSettings->has($key) ? $footerSettings->get($key) : $default;
    };

    $title = $getSetting('footer_title', __('home.footer.title') ?? 'DEPOT ARSIP BERKELANJUTAN BANDUNG');
    $mapEmbed = $getSetting('footer_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1647370889287!2d107.6724258!3d-6.963769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c3b997b00f17%3A0xa05bd0bfa977d91c!2sArsip%20Nasional%20RI%2C%20Depo%20Arsip%20Berkelanjutan%2C%20Bandung!5e0!3m2!1sid!2sid!4v1704369600000');
    $address = $getSetting('footer_address', __('home.footer.address') ?? 'Jl. Raya Derwati, Mekarjaya, Kec. Rancasari, Kota Bandung, Jawa Barat 40292');
    $phone = $getSetting('footer_phone', '(+62) 21 7805851');
    $email = $getSetting('footer_email', 'info@anri.go.id');
    $hours = $getSetting('footer_hours', "Senin-Kamis : 7:30 - 16:00\nJumat : 7:30 - 16:30");
    $managedBy = $getSetting('footer_managed_by', "Depot Arsip\nBerkelanjutan Bandung");
    $managedBySub = $getSetting('footer_managed_by_sub', "Depot Arsip\nBerkelanjutan");
    $fb = $getSetting('footer_facebook', '#');
    $tw = $getSetting('footer_twitter', '#');
    $ig = $getSetting('footer_instagram', '#');
    $yt = $getSetting('footer_youtube', '#');

    $menuCol1Str = $getSetting('footer_menu_col1', "Beranda | " . (Route::has('home') ? route('home') : '/') . "\nLayanan Publik | #\nPublikasi | #\nKontak Kami | #");
    $menuCol2Str = $getSetting('footer_menu_col2', "Profil | #\nPameran Arsip | #\nPerpustakaan DABB | #\nDisclaimer | #");

    $parseMenu = function($str) {
        $lines = explode("\n", trim($str));
        $menu = [];
        foreach($lines as $line) {
            if(!trim($line)) continue;
            $parts = array_map('trim', explode("|", $line));
            $label = $parts[0];
            $url = isset($parts[1]) ? $parts[1] : '#';
            
            // Auto-redirect Disclaimer menu to the proper route if set to #
            if (strtolower($label) === 'disclaimer' && $url === '#') {
                $url = '/disclaimer';
            }
            
            $menu[] = [
                'label' => $label,
                'url' => $url
            ];
        }
        return $menu;
    };
    $menuCol1 = $parseMenu($menuCol1Str);
    $menuCol2 = $parseMenu($menuCol2Str);
@endphp
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">
<footer class="custom-footer">
    <div class="footer-container custom-footer-grid">
        <!-- Kolom 1: Map -->
        <div>
            @if($title)<div class="footer-block-title">{{ $title }}</div>@endif
            @if($mapEmbed)
            <div class="footer-map-wrap">
                <iframe
                    src="{{ $mapEmbed }}"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            @endif
        </div>

        <!-- Kolom 2: Informasi -->
        <div>
            <div class="footer-block-title">{{ __('home.footer.info') ?? 'INFORMASI' }}</div>
            <div class="footer-info-text">
                @if($address)<p>{{ $address }}</p>@endif
                @if($phone)<p><span class="footer-highlight">Telp :</span> {{ $phone }}</p>@endif
                @if($email)<p><span class="footer-highlight">Email :</span> {{ $email }}</p>@endif
                @if($hours)
                <p>
                    <span class="footer-highlight">Jam Kerja :</span><br>
                    {!! nl2br(e($hours)) !!}
                </p>
                @endif
            </div>
        </div>

        <!-- Kolom 3: Menu -->
        <div>
            <div class="footer-block-title">{{ __('home.footer.menu') ?? 'MENU' }}</div>
            <div class="footer-menu-grid">
                <div>
                    @foreach($menuCol1 as $item)
                        <a href="{{ $item['url'] }}" class="footer-menu-link">{{ $item['label'] }}</a>
                    @endforeach
                </div>
                <div>
                    @foreach($menuCol2 as $item)
                        <a href="{{ $item['url'] }}" class="footer-menu-link">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kolom 4: Dikelola Oleh -->
        <div class="footer-managed">
            <div class="footer-block-title">{{ __('home.footer.managed') ?? 'DIKELOLA OLEH' }}</div>
            <div class="footer-brand-wrap">
                <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI" class="footer-logo">
                <div class="footer-brand-text">
                    @if($managedBy)<strong>{!! nl2br(e($managedBy)) !!}</strong>@endif
                    @if($managedBySub)<span>{!! nl2br(e($managedBySub)) !!}</span>@endif
                </div>
            </div>

            @if($fb || $tw || $ig || $yt)
            <div class="footer-social-list">
                @if($fb)<a href="{{ $fb }}" class="footer-social-icon" title="Facebook" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                </a>@endif
                @if($tw)<a href="{{ $tw }}" class="footer-social-icon" title="X (Twitter)" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l16 16M4 20L20 4"></path></svg>
                </a>@endif
                @if($ig)<a href="{{ $ig }}" class="footer-social-icon" title="Instagram" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>@endif
                @if($yt)<a href="{{ $yt }}" class="footer-social-icon" title="YouTube" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                </a>@endif
            </div>
            @endif
        </div>
        </div>
    </div>
    <div class="footer-bottom">
        Copyright &copy; {{ date('Y') }} <strong>Arsip Nasional Republik Indonesia</strong>
    </div>
</footer>
