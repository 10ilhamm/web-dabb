<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CMS — Manajemen Fitur (features/index)
    |--------------------------------------------------------------------------
    */

    'features' => [
        'title' => 'Manajemen Fitur',
        'card_title' => 'Manajemen Fitur CMS',
        'card_desc' => 'Kelola semua fitur yang ditampilkan di website',
        'add_button' => 'Tambah Fitur',

        // Table headers
        'col_name' => 'Nama Fitur',
        'col_type' => 'Tipe Menu',
        'col_sub_count' => 'Jumlah Sub Fitur',
        'col_order' => 'Urutan',
        'col_action' => 'Aksi',

        // Badges
        'type_dropdown' => 'Dropdown',
        'type_link' => 'Link',

        // Buttons
        'detail' => 'Detail',

        // Empty state
        'empty' => 'Belum ada fitur. Klik "+ Tambah Fitur" untuk menambahkan.',

        // Edit modal
        'edit_title' => 'Edit Fitur',

        // Add modal
        'add_title' => 'Tambah Fitur Baru',

        // Delete modal
        'delete' => [
            'title' => 'Hapus Fitur',
            'confirm' => 'Apakah Anda yakin ingin menghapus fitur :name? Tindakan ini tidak dapat dibatalkan.',
            'yes' => 'Ya, Hapus',
        ],

        // Form labels (shared between add/edit)
        'form' => [
            'name' => 'Nama Fitur',
            'type' => 'Tipe Menu',
            'path' => 'Path / URL',
            'path_placeholder' => 'Contoh: /beranda',
            'order' => 'Urutan',
            'name_placeholder' => 'Contoh: Beranda',
        ],

        // Detail page (features/show)
        'detail_title' => 'Detail Fitur: :name',
        'type_label' => 'Tipe',

        // Sub-menu section (dropdown type)
        'sub' => [
            'list_title' => 'Daftar Sub Menu — :name',
            'list_desc' => 'Kelola sub menu yang ada di dalam menu :name',
            'add_button' => 'Tambah Sub Menu',
            'col_name' => 'Nama Sub Menu',
            'col_path' => 'Path / URL',
            'col_order' => 'Urutan',
            'col_action' => 'Aksi',
            'empty' => 'Belum ada sub menu. Klik "+ Tambah Sub Menu" untuk menambahkan.',

            // Add sub modal
            'add_title' => 'Tambah Sub Menu',

            // Edit sub modal
            'edit_title' => 'Edit Sub Menu',

            // Delete sub modal
            'delete' => [
                'title' => 'Hapus Sub Menu',
                'confirm' => 'Apakah Anda yakin ingin menghapus sub menu :name?',
                'yes' => 'Ya, Hapus',
            ],

            // Sub form labels
            'form' => [
                'name' => 'Nama Sub Menu',
                'path' => 'Path / URL',
                'path_placeholder' => 'Contoh: /profil/sejarah',
                'name_placeholder' => 'Contoh: Sejarah',
                'order' => 'Urutan',
            ],
        ],

        // Content editor (link type)
        'content' => [
            'title' => 'Editor Konten Halaman — :name',
            'desc' => 'Edit konten yang ditampilkan pada halaman :name',
            'label' => 'Konten Halaman',
            'placeholder' => 'Masukkan konten HTML atau teks untuk halaman ini...',
            'help' => 'Anda dapat menggunakan HTML untuk memformat konten.',
        ],

        // Flash messages
        'flash' => [
            'sub_added' => 'Sub menu berhasil ditambahkan.',
            'feature_added' => 'Fitur berhasil ditambahkan.',
            'feature_updated' => 'Fitur berhasil diperbarui.',
            'content_saved' => 'Konten halaman berhasil disimpan.',
            'feature_deleted' => 'Fitur berhasil dihapus.',
            'sub_updated' => 'Sub fitur berhasil diperbarui.',
            'sub_deleted' => 'Sub fitur berhasil dihapus.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CMS — Halaman Fitur (feature pages)
    |--------------------------------------------------------------------------
    */

    'feature_pages' => [
        'title' => 'Manajemen Halaman — :name',
        'desc' => 'Kelola halaman-halaman yang ditampilkan pada fitur :name',
        'add_button' => 'Tambah Halaman',
        'back_to_feature' => 'Kembali ke Fitur',

        'col_title' => 'Judul Halaman',
        'col_sections' => 'Jumlah Seksi',
        'col_order' => 'Urutan',
        'col_action' => 'Aksi',

        'empty' => 'Belum ada halaman. Klik "+ Tambah Halaman" untuk menambahkan.',

        'add_title' => 'Tambah Halaman Baru',
        'edit_title' => 'Edit Halaman',

        'delete' => [
            'title' => 'Hapus Halaman',
            'confirm' => 'Apakah Anda yakin ingin menghapus halaman :name?',
            'yes' => 'Ya, Hapus',
        ],

        'form' => [
            'title' => 'Judul Halaman',
            'title_placeholder' => 'Contoh: Pameran Kontemporer',
            'description' => 'Deskripsi Halaman',
            'description_placeholder' => 'Deskripsi singkat halaman ini...',
            'order' => 'Urutan',
        ],

        // Sections
        'sections_title' => 'Seksi Halaman — :name',
        'sections_desc' => 'Kelola seksi-seksi konten pada halaman :name',
        'add_section' => 'Tambah Seksi',
        'add_section_title' => 'Tambah Seksi Baru',
        'edit_section_title' => 'Edit Seksi',

        'section_form' => [
            'title' => 'Judul Seksi',
            'title_placeholder' => 'Contoh: Fasilitas Mini Diorama',
            'description' => 'Deskripsi',
            'description_placeholder' => 'Deskripsi seksi ini...',
            'images' => 'Gambar',
            'images_help' => 'Upload gambar JPG/PNG/WebP, maks 2MB per file',
            'existing_images' => 'Gambar Saat Ini',
            'order' => 'Urutan',
        ],

        'delete_section' => [
            'title' => 'Hapus Seksi',
            'confirm' => 'Apakah Anda yakin ingin menghapus seksi :name?',
            'yes' => 'Ya, Hapus',
        ],

        'flash' => [
            'page_added' => 'Halaman berhasil ditambahkan.',
            'page_updated' => 'Halaman berhasil diperbarui.',
            'page_deleted' => 'Halaman berhasil dihapus.',
            'section_added' => 'Seksi berhasil ditambahkan.',
            'section_updated' => 'Seksi berhasil diperbarui.',
            'section_deleted' => 'Seksi berhasil dihapus.',
        ],

        // Public page
        'welcome' => 'Selamat datang di portal :name,',
        'search_placeholder' => 'Pencarian',
        'list_title' => 'Daftar :name',
    ],

    /*
    |--------------------------------------------------------------------------
    | CMS — Editor Beranda (home/edit)
    |--------------------------------------------------------------------------
    */

    'home' => [
        'title' => 'Editor Konten Halaman Beranda',
        'desc' => 'Kelola semua konten yang ditampilkan di halaman Beranda website',
        'view_page' => 'Lihat Halaman',

        'hero' => [
            'title' => 'Seksi Hero (Banner Utama)',
            'desc' => 'Teks utama dan tombol CTA di bagian atas halaman',
            'hero_title' => 'Judul Hero',
            'hero_cta' => 'Teks Tombol CTA',
        ],

        'feature_strip' => [
            'title' => 'Feature Strip (Banner Bawah Hero)',
            'desc' => 'Dua kotak informasi di bawah hero',
            'left' => 'Teks Kiri',
            'middle' => 'Tombol Tengah',
            'right_button' => 'Tombol Kanan',
            'right_text' => 'Teks Kanan',
        ],

        'info' => [
            'title' => 'Seksi Informasi DABB',
            'desc' => 'Judul dan dua paragraf informasi tentang DABB',
            'section' => 'Judul Seksi',
            'paragraph1' => 'Paragraf 1',
            'paragraph2' => 'Paragraf 2',
        ],

        'activities' => [
            'title' => 'Seksi Kegiatan Kearsipan',
            'desc' => '6 item kegiatan yang ditampilkan dalam kartu berwarna',
            'section' => 'Judul Seksi',
        ],

        'section_titles' => [
            'title' => 'Judul Seksi Lainnya',
            'desc' => 'Judul untuk seksi Galeri, Statistik, YouTube, Instagram, dll.',
            'related' => 'Link Terkait',
            'gallery' => 'Pameran Arsip (Galeri)',
            'stats' => 'Statistik Pengunjung',
            'youtube' => 'YouTube',
            'instagram' => 'Instagram Feed',
        ],

        'stats' => [
            'title' => 'Label Statistik',
            'desc' => 'Label teks untuk counter statistik pengunjung',
            'total' => 'Label Total Pengunjung',
            'today' => 'Label Pengunjung Hari Ini',
        ],

        'youtube' => [
            'title' => 'Video YouTube',
            'desc' => 'ID video YouTube yang ditampilkan di carousel (format: ID saja, contoh: F2NhNTiNxoY)',
            'video_label' => 'Video :number',
            'placeholder' => 'ID YouTube',
            'help' => 'Salin ID dari URL YouTube: youtube.com/watch?v=<strong>ID_DI_SINI</strong>',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Common (shared across CMS pages)
    |--------------------------------------------------------------------------
    */

    'common' => [
        'cancel' => 'Batal',
        'save_changes' => 'Simpan Perubahan',
        'save_content' => 'Simpan Konten',
        'back' => 'Kembali',
        'required' => '*',
    ],

];
