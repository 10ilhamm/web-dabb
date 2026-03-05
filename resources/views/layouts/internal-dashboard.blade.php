<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __('home.dashboard.title') }} - {{ __('home.site_name') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FB;
            /* Light background for the dashboard area */
        }

        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar for sidebar */
        .sidebar {
            background-color: #174E93;
            /* Deep ANRI Blue */
        }

        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            /* Slightly lighter blue for active item */
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body class="text-gray-800 antialiased overflow-hidden">
    <!-- Alpine Root Component for Sidebar State -->
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-[#F4F6F9]">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="sidebar text-white transition-all duration-300 ease-in-out flex flex-col h-full z-20 shrink-0">

            <!-- Logo Section -->
            <div class="h-20 flex items-center justify-center border-b border-white/10 px-4 mt-2">
                <!-- Expanded Logo -->
                <div x-show="sidebarOpen"
                    class="flex flex-col items-center  w-full space-y-2 transition-opacity duration-300"
                    x-transition.opacity>
                    <div class="flex items-center justify-start w-full">
                        <img src="{{ asset('image/logo_anri.png') }}" alt="Logo ANRI"
                            class="h-10 w-auto shrink-0 drop-shadow-md">
                        <div class="ml-3 flex flex-col items-start leading-tight">
                            <div class="font-bold text-[13px] tracking-wide text-white drop-shadow-sm">Depot Arsip</div>
                            <div class="font-bold text-[13px] tracking-wide text-white drop-shadow-sm">Berkelanjutan
                                Bandung</div>
                            <div class="font-normal text-[9px] text-blue-200 mt-1 whitespace-nowrap">Depot Arsip
                                Berkelanjutan</div>
                        </div>
                    </div>
                </div>

                <!-- Collapsed Logo -->
                <div x-show="!sidebarOpen" class="flex justify-center w-full transition-opacity duration-300"
                    x-transition.opacity x-cloak>
                    <img src="{{ asset('image/logo_anri.png') }}" alt="Logo ANRI" class="h-10 w-auto shrink-0">
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 mt-6 px-3 space-y-2 overflow-y-auto no-scrollbar">
                <!-- Beranda -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link active flex items-center px-3 py-3 rounded-lg text-white group">
                    <svg class="w-6 h-6 shrink-0 opacity-90 group-hover:opacity-100" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-4 text-[14px] font-medium transition-opacity duration-300"
                        x-transition.opacity>{{ __('dashboard.sidebar.home') }}</span>
                </a>

                <!-- Laporan -->
                <a href="#"
                    class="sidebar-link flex items-center px-3 py-3 rounded-lg text-[#b8cdef] hover:text-white group">
                    <svg class="w-6 h-6 shrink-0 opacity-80 group-hover:opacity-100" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-4 text-[14px] font-medium transition-opacity duration-300"
                        x-transition.opacity>{{ __('dashboard.sidebar.reports') }}</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- CMS -->
                <a href="#"
                    class="sidebar-link flex items-center px-3 py-3 rounded-lg text-[#b8cdef] hover:text-white group">
                    <svg class="w-6 h-6 shrink-0 opacity-80 group-hover:opacity-100" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-4 text-[14px] font-medium transition-opacity duration-300"
                        x-transition.opacity>{{ __('dashboard.sidebar.cms') }}</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Pengguna -->
                <a href="#"
                    class="sidebar-link flex items-center px-3 py-3 rounded-lg text-[#b8cdef] hover:text-white group">
                    <svg class="w-6 h-6 shrink-0 opacity-80 group-hover:opacity-100" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-4 text-[14px] font-medium transition-opacity duration-300"
                        x-transition.opacity>{{ __('dashboard.sidebar.users') }}</span>
                </a>
            </nav>

            <!-- Bottom Links -->
            <div class="px-3 pb-6 pt-4 space-y-2 mt-auto">
                <a href="{{ route('home') }}"
                    class="sidebar-link flex items-center px-3 py-3 rounded-lg text-[#b8cdef] hover:text-white group"
                    title="Lihat Website">
                    <svg class="w-6 h-6 shrink-0 opacity-80 group-hover:opacity-100" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 font-semibold tracking-wide text-[13.5px] whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                        :class="sidebarOpen ? 'opacity-100 max-w-full' : 'opacity-0 max-w-0'">{{ __('dashboard.sidebar.visit_website') }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="sidebar-link w-full flex items-center px-3 py-3 rounded-lg text-[#b8cdef] hover:text-white group border-none bg-transparent cursor-pointer"
                        title="Keluar">
                        <svg class="w-6 h-6 shrink-0 opacity-80 group-hover:opacity-100" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 font-semibold tracking-wide text-[13.5px] whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                            :class="sidebarOpen ? 'opacity-100 max-w-full' : 'opacity-0 max-w-0'">{{ __('dashboard.sidebar.logout') }}</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-white">

            <!-- Top Header -->
            <header
                class="bg-white border-b border-gray-100 flex items-center justify-between px-6 py-4 shrink-0 shadow-sm relative z-10">
                <!-- Left: Hamburger & Breadcrumb -->
                <div class="flex items-center space-x-6">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-white bg-[#174E93] hover:bg-blue-800 p-1.5 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- Header slot for optional page title/breadcrumb -->
                    <div class="hidden sm:block">
                        @hasSection('header')
                            @yield('header')
                        @else
                            <div class="text-[13px] text-gray-500 font-medium">
                                <span class="text-gray-400">{{ __('dashboard.header.breadcrumb_home') }} /</span>
                                <span class="text-[#0ea5e9">@yield('breadcrumb_active', __('dashboard.header.breadcrumb_home'))</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Language & Profile -->
                <div class="flex items-center space-x-6">
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2 text-[13px] font-semibold tracking-wide">
                        <a href="{{ route('locale.switch', 'id') }}"
                            class="px-2 py-1 rounded transition-colors {{ app()->getLocale() === 'id' ? 'bg-[#174E93] text-white' : 'text-gray-400 hover:text-gray-800 hover:bg-gray-100' }}">
                            ID
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('locale.switch', 'en') }}"
                            class="px-2 py-1 rounded transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#174E93] text-white' : 'text-gray-400 hover:text-gray-800 hover:bg-gray-100' }}">
                            EN
                        </a>
                    </div>

                    <div x-data="{ profileOpen: false }" class="relative flex items-center pl-4 border-l border-gray-200">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false"
                            class="flex items-center focus:outline-none w-full text-left">
                            <img class="h-9 w-9 rounded-full object-cover border border-gray-200"
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=E5E7EB&color=374151&bold=true"
                                alt="Avatar">
                            <div class="ml-3 flex flex-col" style="line-height: 1.2;">
                                <span
                                    class="text-[13px] font-semibold text-gray-800">{{ auth()->user()->name ?? __('dashboard.profile.default_name') }}</span>
                                <span
                                    class="text-[11px] text-gray-500">{{ App\Models\User::roleLabels()[auth()->user()->role ?? 'umum'] ?? __('dashboard.profile.default_role') }}</span>
                            </div>
                            <div
                                class="ml-4 p-1 rounded-full border border-gray-200 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 top-[120%] mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 py-1"
                            style="display: none;">

                            <!-- Kelola Akun -->
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-[#EEF2FF] hover:text-[#4F46E5] transition-colors rounded-t-xl group">
                                <svg class="w-5 h-5 mr-3 text-[#60A5FA] group-hover:text-[#4F46E5]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span
                                    class="font-medium text-[13px]">{{ __('dashboard.profile.manage_account') }}</span>
                            </a>

                            <!-- Ubah Kata Sandi -->
                            <a href="{{ route('profile.password') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-[#F472B6]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                    </path>
                                </svg>
                                <span
                                    class="font-medium text-[13px]">{{ __('dashboard.profile.change_password') }}</span>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Aktivitas Log -->
                            <a href="{{ route('profile.activity') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors rounded-b-xl">
                                <svg class="w-5 h-5 mr-3 text-[#C084FC]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                <span class="font-medium text-[13px]">Aktivitas Log</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F4F6FA] p-6 lg:p-8">
                <main class="max-w-7xl mx-auto w-full">
                    @yield('content')
                </main>

                <!-- Footer within content area -->
                <footer
                    class="max-w-7xl mx-auto w-full mt-10 pt-4 border-t border-gray-200 flex justify-between items-center text-[12px] text-gray-400 font-medium">
                    <div>{{ date('Y') }} &copy; Depot Arsip Berkelanjutan Bandung.</div>
                    <img src="{{ asset('image/logo_anri.png') }}" alt="Logo ANRI"
                        class="h-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                </footer>
            </div>
        </main>
    </div>

    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>

</html>
