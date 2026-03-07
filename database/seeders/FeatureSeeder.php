<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing features
        Feature::truncate();

        // Top-level menu items
        $beranda = Feature::create([
            'name' => 'Beranda',
            'type' => 'link',
            'path' => '/',
            'order' => 1,
        ]);

        $profil = Feature::create([
            'name' => 'Profil',
            'type' => 'dropdown',
            'path' => null,
            'order' => 2,
        ]);

        $pameranArsip = Feature::create([
            'name' => 'Pameran Arsip',
            'type' => 'dropdown',
            'path' => null,
            'order' => 3,
        ]);

        $publikasi = Feature::create([
            'name' => 'Publikasi',
            'type' => 'dropdown',
            'path' => null,
            'order' => 4,
        ]);

        $layananPublik = Feature::create([
            'name' => 'Layanan Publik',
            'type' => 'dropdown',
            'path' => null,
            'order' => 5,
        ]);

        $kontakKami = Feature::create([
            'name' => 'Kontak Kami',
            'type' => 'link',
            'path' => '/kontak',
            'order' => 6,
        ]);

        // Sub-menus for Profil
        Feature::create(['name' => 'Sejarah', 'type' => 'link', 'path' => '/profil/sejarah', 'order' => 1, 'parent_id' => $profil->id]);
        Feature::create(['name' => 'Visi & Misi', 'type' => 'link', 'path' => '/profil/visi-misi', 'order' => 2, 'parent_id' => $profil->id]);
        Feature::create(['name' => 'Struktur Organisasi', 'type' => 'link', 'path' => '/profil/struktur', 'order' => 3, 'parent_id' => $profil->id]);

        // Sub-menus for Pameran Arsip
        Feature::create(['name' => 'Pameran Tetap', 'type' => 'link', 'path' => '/pameran/tetap', 'order' => 1, 'parent_id' => $pameranArsip->id]);
        Feature::create(['name' => 'Pameran Temporer', 'type' => 'link', 'path' => '/pameran/temporer', 'order' => 2, 'parent_id' => $pameranArsip->id]);

        // Sub-menus for Publikasi
        Feature::create(['name' => 'Berita', 'type' => 'link', 'path' => '/publikasi/berita', 'order' => 1, 'parent_id' => $publikasi->id]);
        Feature::create(['name' => 'Artikel', 'type' => 'link', 'path' => '/publikasi/artikel', 'order' => 2, 'parent_id' => $publikasi->id]);
        Feature::create(['name' => 'Galeri', 'type' => 'link', 'path' => '/publikasi/galeri', 'order' => 3, 'parent_id' => $publikasi->id]);
        Feature::create(['name' => 'Video', 'type' => 'link', 'path' => '/publikasi/video', 'order' => 4, 'parent_id' => $publikasi->id]);

        // Sub-menus for Layanan Publik
        Feature::create(['name' => 'Layanan Arsip', 'type' => 'link', 'path' => '/layanan/arsip', 'order' => 1, 'parent_id' => $layananPublik->id]);
        Feature::create(['name' => 'Layanan Penelitian', 'type' => 'link', 'path' => '/layanan/penelitian', 'order' => 2, 'parent_id' => $layananPublik->id]);
        Feature::create(['name' => 'Layanan Konsultasi', 'type' => 'link', 'path' => '/layanan/konsultasi', 'order' => 3, 'parent_id' => $layananPublik->id]);
        Feature::create(['name' => 'Layanan Digitalisasi', 'type' => 'link', 'path' => '/layanan/digitalisasi', 'order' => 4, 'parent_id' => $layananPublik->id]);
        Feature::create(['name' => 'Layanan Restorasi', 'type' => 'link', 'path' => '/layanan/restorasi', 'order' => 5, 'parent_id' => $layananPublik->id]);
    }
}
