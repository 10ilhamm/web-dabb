<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Registrasi') }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        .register-card {
            /* Based on login-card but slightly adapted for longer forms */
            background: #fff;
            border-radius: 32px;
            width: 100%;
            max-width: 1200px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            min-height: 700px;
        }

        /* Dropdown wrapper */
        .role-selector-wrapper {
            position: relative;
            margin-bottom: 40px;
        }

        .role-selector {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid #CED4DA;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            appearance: none;
            background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236C757D' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E") no-repeat right 20px center;
            background-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .role-selector:focus {
            border-color: #0579CB;
            outline: none;
            box-shadow: 0 0 0 3px rgba(5, 121, 203, 0.15);
        }

        /* Form Sections */
        .dynamic-form-section {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .dynamic-form-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Grid Layout for Forms */
        .form-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 20px 15px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .form-grid label {
                margin-top: 10px;
            }
        }

        .form-grid label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin: 0;
        }

        .form-grid label.required::after {
            content: "*";
            color: #DC3545;
            margin-left: 3px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
            height: 44px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        /* File Input Styling */
        .file-upload-wrapper {
            display: flex;
            align-items: center;
            border: 1px solid #CED4DA;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .file-upload-btn {
            background: #343A40;
            color: #fff;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .file-upload-text {
            padding: 0 15px;
            font-size: 13px;
            color: #6C757D;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        input[type="file"] {
            display: none;
        }

        hr {
            margin: 30px 0;
            border: 0;
            border-top: 1px solid #DEE2E6;
        }

        /* Password wrapper */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6C757D;
        }

        .btn-submit-form {
            background: #0579CB;
            color: #fff;
            padding: 12px 32px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            float: right;
            margin-top: 20px;
        }

        .btn-submit-form:hover {
            background: #0466AC;
        }
    </style>
</head>

<body class="login-page-bg font-sans text-gray-900 antialiased flex flex-col min-h-screen">

    @include('navbar')

    <div class="login-breadcrumb">
        <div class="container">
            <span class="text-cyan">Registrasi</span>
        </div>
    </div>

    <div class="login-hero" style="height: 200px;">
        <div class="container">
            <h1>REGISTRASI PENGGUNA</h1>
        </div>
    </div>

    <main class="flex-grow login-main-wrapper" style="padding: 40px 5%;">
        <div class="register-card">

            <!-- Left Side: Form Area -->
            <div class="login-form-side" style="padding: 50px 60px;">
                <h2 style="font-size: 26px; margin-bottom: 10px; color: #495057;">Pendaftaran Akun Pengguna</h2>
                <p class="subtitle" style="margin-bottom: 40px;">Lengkapi form di bawah untuk membuat akun baru</p>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Role Selector -->
                <div class="role-selector-wrapper" id="initial-selector">
                    <select class="role-selector" id="role-select" onchange="showForm()">
                        <option value="" disabled selected>Pilih Jenis Akun</option>
                        <option value="umum">Umum</option>
                        <option value="pelajar">Pelajar / Mahasiswa</option>
                        <option value="instansi">Instansi / Swasta</option>
                    </select>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                    id="registration-form" style="display: none;">
                    @csrf

                    <!-- Hidden input to store role for backend -->
                    <input type="hidden" name="role" id="form-role-input">

                    <div class="form-grid">
                        <!-- Nama -->
                        <label for="name" class="required" id="label-name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="login-input"
                            placeholder="Nama Lengkap" value="{{ old('name') }}" required>

                        <!-- Username -->
                        <label for="username" class="required">Username</label>
                        <input type="text" name="username" id="username" class="login-input" placeholder="username"
                            value="{{ old('username') }}" required>

                        <!-- Email -->
                        <label for="email" class="required">Email</label>
                        <input type="email" name="email" id="email" class="login-input"
                            placeholder="nama@gmail.com" value="{{ old('email') }}" required>

                        <!-- Jenis Kelamin (Hidden for Instansi) -->
                        <div class="jk-group" style="display: contents;">
                            <label class="required">Jenis Kelamin</label>
                            <div class="radio-group" id="jk-container">
                                <label class="radio-item">
                                    <input type="radio" name="jenis_kelamin" value="Laki-Laki"
                                        {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }}> Laki - Laki
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}> Perempuan
                                </label>
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <label for="tempat_lahir" class="required" id="label-tempat-lahir">Tempat Tanggal Lahir</label>
                        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 15px;">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="login-input"
                                placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}" required>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="login-input"
                                value="{{ old('tanggal_lahir') }}" required>
                        </div>

                        <!-- Kartu Identitas Upload -->
                        <label for="kartu_identitas" class="required" id="label-kartu-identitas">Kartu
                            Identitas</label>
                        <div class="file-upload-wrapper">
                            <button type="button" class="file-upload-btn"
                                onclick="document.getElementById('kartu_identitas').click()">Choose File</button>
                            <span class="file-upload-text" id="file-name">No file chosen</span>
                            <input type="file" name="kartu_identitas" id="kartu_identitas"
                                accept=".jpg,.jpeg,.png,.pdf" onchange="updateFileName(this)" required>
                        </div>

                        <!-- Nomor Kartu Identitas -->
                        <label for="nomor_kartu_identitas" class="required">Nomor Kartu Identitas</label>
                        <input type="text" name="nomor_kartu_identitas" id="nomor_kartu_identitas"
                            class="login-input" placeholder="Nomor Kartu Identitas"
                            value="{{ old('nomor_kartu_identitas') }}" required>

                        <!-- Alamat -->
                        <label for="alamat" class="required">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="login-input"
                            placeholder="Alamat" value="{{ old('alamat') }}" required>

                        <!-- Whatsapp -->
                        <label for="nomor_whatsapp" class="required">Nomor Whatsapp</label>
                        <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" class="login-input"
                            placeholder="0831xxxxxxxx" value="{{ old('nomor_whatsapp') }}" required>

                        <!-- Divider inside grid -->
                        <div style="grid-column: 1 / -1;">
                            <hr>
                        </div>

                        <!-- Password -->
                        <label for="password" class="required">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="login-input"
                                placeholder="Password" required>
                        </div>

                        <!-- Confirm Password -->
                        <label for="password_confirmation" class="required">Ulangi Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="login-input" placeholder="Ulangi Password" required>
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <hr>
                        </div>

                        <!-- Jenis Keperluan -->
                        <label for="jenis_keperluan" class="required">Jenis Keperluan</label>
                        <select name="jenis_keperluan" id="jenis_keperluan" class="login-input" required>
                            <option value="">Pilih Keperluan</option>
                            <option value="Hanya Daftar Akun"
                                {{ old('jenis_keperluan') == 'Hanya Daftar Akun' ? 'selected' : '' }}>Hanya Daftar Akun
                            </option>
                            <option value="Penelitian" {{ old('jenis_keperluan') == 'Penelitian' ? 'selected' : '' }}>
                                Penelitian</option>
                            <option value="Kunjungan" {{ old('jenis_keperluan') == 'Kunjungan' ? 'selected' : '' }}>
                                Kunjungan</option>
                        </select>

                        <!-- Judul Keperluan -->
                        <label for="judul_keperluan" class="required">Judul Keperluan</label>
                        <input type="text" name="judul_keperluan" id="judul_keperluan" class="login-input"
                            value="{{ old('judul_keperluan') }}" required>

                    </div>

                    <div style="text-align: right; margin-top: 30px;">
                        <button type="submit" class="btn-submit-form">Daftar Akun</button>
                    </div>

                </form>

            </div>

            <!-- Right Side: Image Banner -->
            <div class="login-banner-side" style="flex: 0.8;">
                <div class="banner-overlay-logo">
                    <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI Logo">
                    <div class="banner-overlay-text">
                        <div class="title">Depot Arsip<br>Berkelanjutan Bandung</div>
                        <div class="subtitle">Depot Arsip Berkelanjutan</div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('footer')

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        }

        function showForm() {
            const selected = document.getElementById('role-select').value;
            const formContainer = document.getElementById('registration-form');
            const hiddenRoleInput = document.getElementById('form-role-input');
            const jkGroupElements = document.querySelectorAll('.jk-group');
            const jkInputs = document.querySelectorAll('input[name="jenis_kelamin"]');

            if (!selected) return;

            formContainer.style.display = 'block';

            if (selected === 'umum') {
                hiddenRoleInput.value = 'umum';
                document.getElementById('label-name').textContent = "Nama Lengkap";
                document.getElementById('name').placeholder = "Nama Lengkap";
                document.getElementById('label-kartu-identitas').textContent = "Kartu Identitas (KTP)";

                // Show JK
                jkGroupElements.forEach(el => el.style.display = 'contents');
                jkInputs.forEach(el => el.required = true);

            } else if (selected === 'pelajar') {
                hiddenRoleInput.value = 'pelajar_mahasiswa';
                document.getElementById('label-name').textContent = "Nama Lengkap";
                document.getElementById('name').placeholder = "Nama Lengkap";
                document.getElementById('label-kartu-identitas').textContent = "Kartu Identitas (KTM/Pelajar)";

                // Show JK
                jkGroupElements.forEach(el => el.style.display = 'contents');
                jkInputs.forEach(el => el.required = true);

            } else if (selected === 'instansi') {
                hiddenRoleInput.value = 'instansi_swasta';
                document.getElementById('label-name').textContent = "Nama Instansi / Perusahaan";
                document.getElementById('name').placeholder = "Nama Instansi / Perusahaan";
                document.getElementById('label-kartu-identitas').textContent = "Kartu Identitas Instansi";

                // Hide JK
                jkGroupElements.forEach(el => el.style.display = 'none');
                jkInputs.forEach(el => el.required = false);
            }
        }

        // Restore form state if there was a validation error
        document.addEventListener('DOMContentLoaded', function() {
            const oldRole = "{{ old('role') }}";
            if (oldRole) {
                const select = document.getElementById('role-select');
                if (oldRole === 'umum') select.value = 'umum';
                if (oldRole === 'pelajar_mahasiswa') select.value = 'pelajar';
                if (oldRole === 'instansi_swasta') select.value = 'instansi';
                showForm();
            }
        });
    </script>
</body>

</html>
