<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $agamaEnum = "'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'";
        $jabatanEnum = "'Kepala ANRI', 'Sekretaris Utama', 'Deputi Bidang Pembinaan Kearsipan', 'Deputi Bidang Informasi dan Pengembangan Sistem Kearsipan', 'Deputi Bidang Konservasi Arsip', 'Direktur Kearsipan Pusat', 'Direktur Kearsipan Daerah I & II', 'Direktur SDM Kearsipan dan Sertifikasi', 'Arsiparis Ahli Pertama', 'Arsiparis Ahli Muda', 'Arsiparis Ahli Madya', 'Arsiparis Ahli Utama', 'Arsiparis Terampil', 'Arsiparis Mahir', 'Arsiparis Penyelia', 'Konservator Arsip', 'Restorator Arsip', 'Reprogrator Arsip', 'Agendaris', 'Protokol', 'Sekretaris Pimpinan', 'Bendahara Gaji'";
        $pangkatEnum = "'IV/e (Pembina Utama)', 'IV/d (Pembina Utama Madya)', 'IV/c (Pembina Utama Muda)', 'IV/b (Pembina Tingkat I)', 'IV/a (Pembina)', 'III/d (Penata Tingkat I)', 'III/c (Penata)', 'III/b (Penata Muda Tingkat I)', 'III/a (Penata Muda)', 'II/d (Pengatur Tingkat I)', 'II/c (Pengatur)', 'II/b (Pengatur Muda Tingkat I)', 'II/a (Pengatur Muda)', 'I/d (Juru Tingkat I)', 'I/c (Juru)', 'I/b (Juru Muda Tingkat I)', 'I/a (Juru Muda)'";

        \Illuminate\Support\Facades\DB::statement("UPDATE user_admins SET agama = 'Islam' WHERE agama NOT IN ($agamaEnum) OR agama IS NULL");
        \Illuminate\Support\Facades\DB::statement("UPDATE user_admins SET jabatan = 'Kepala ANRI' WHERE jabatan NOT IN ($jabatanEnum) OR jabatan IS NULL");
        \Illuminate\Support\Facades\DB::statement("UPDATE user_admins SET pangkat_golongan = 'IV/e (Pembina Utama)' WHERE pangkat_golongan NOT IN ($pangkatEnum) OR pangkat_golongan IS NULL");

        \Illuminate\Support\Facades\DB::statement("UPDATE user_pegawais SET agama = 'Islam' WHERE agama NOT IN ($agamaEnum) OR agama IS NULL");
        \Illuminate\Support\Facades\DB::statement("UPDATE user_pegawais SET jabatan = 'Kepala ANRI' WHERE jabatan NOT IN ($jabatanEnum) OR jabatan IS NULL");
        \Illuminate\Support\Facades\DB::statement("UPDATE user_pegawais SET pangkat_golongan = 'IV/e (Pembina Utama)' WHERE pangkat_golongan NOT IN ($pangkatEnum) OR pangkat_golongan IS NULL");

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN agama ENUM($agamaEnum)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN jabatan ENUM($jabatanEnum)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN pangkat_golongan ENUM($pangkatEnum)");

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN agama ENUM($agamaEnum)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN jabatan ENUM($jabatanEnum)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN pangkat_golongan ENUM($pangkatEnum)");
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN agama VARCHAR(30)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN jabatan VARCHAR(80)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_admins MODIFY COLUMN pangkat_golongan VARCHAR(80)");

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN agama VARCHAR(30)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN jabatan VARCHAR(80)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE user_pegawais MODIFY COLUMN pangkat_golongan VARCHAR(80)");
    }
};
