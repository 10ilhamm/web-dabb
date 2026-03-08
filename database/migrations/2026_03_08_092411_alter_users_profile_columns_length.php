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
        Schema::table('user_umums', function (Blueprint $table) {
            $table->string('tempat_lahir', 100)->change();
            $table->string('nomor_kartu_identitas', 25)->change();
            $table->string('nomor_whatsapp', 20)->change();
        });

        Schema::table('user_pelajars', function (Blueprint $table) {
            $table->string('tempat_lahir', 100)->change();
            $table->string('nomor_kartu_identitas', 25)->change();
            $table->string('nomor_whatsapp', 20)->change();
        });

        Schema::table('user_instansis', function (Blueprint $table) {
            $table->string('tempat_lahir', 100)->change();
            $table->string('nomor_kartu_identitas', 25)->change();
            $table->string('nomor_whatsapp', 20)->change();
        });

        Schema::table('user_admins', function (Blueprint $table) {
            $table->string('nip', 18)->change();
            $table->string('tempat_lahir', 100)->change();
            $table->string('nomor_kartu_identitas', 25)->change();
            $table->string('nomor_whatsapp', 20)->change();
            $table->string('agama', 30)->change();
            $table->string('jabatan', 80)->change();
            $table->string('pangkat_golongan', 80)->change();
        });

        Schema::table('user_pegawais', function (Blueprint $table) {
            $table->string('nip', 18)->change();
            $table->string('tempat_lahir', 100)->change();
            $table->string('nomor_kartu_identitas', 25)->change();
            $table->string('nomor_whatsapp', 20)->change();
            $table->string('agama', 30)->change();
            $table->string('jabatan', 80)->change();
            $table->string('pangkat_golongan', 80)->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_umums', function (Blueprint $table) {
            $table->string('tempat_lahir', 255)->change();
            $table->string('nomor_kartu_identitas', 255)->change();
            $table->string('nomor_whatsapp', 255)->change();
        });

        Schema::table('user_pelajars', function (Blueprint $table) {
            $table->string('tempat_lahir', 255)->change();
            $table->string('nomor_kartu_identitas', 255)->change();
            $table->string('nomor_whatsapp', 255)->change();
        });

        Schema::table('user_instansis', function (Blueprint $table) {
            $table->string('tempat_lahir', 255)->change();
            $table->string('nomor_kartu_identitas', 255)->change();
            $table->string('nomor_whatsapp', 255)->change();
        });

        Schema::table('user_admins', function (Blueprint $table) {
            $table->string('nip', 255)->change();
            $table->string('tempat_lahir', 255)->change();
            $table->string('nomor_kartu_identitas', 255)->change();
            $table->string('nomor_whatsapp', 255)->change();
            $table->string('agama', 255)->change();
            $table->string('jabatan', 255)->change();
            $table->string('pangkat_golongan', 255)->change();
        });

        Schema::table('user_pegawais', function (Blueprint $table) {
            $table->string('nip', 255)->change();
            $table->string('tempat_lahir', 255)->change();
            $table->string('nomor_kartu_identitas', 255)->change();
            $table->string('nomor_whatsapp', 255)->change();
            $table->string('agama', 255)->change();
            $table->string('jabatan', 255)->change();
            $table->string('pangkat_golongan', 255)->change();
        });
    }
};
