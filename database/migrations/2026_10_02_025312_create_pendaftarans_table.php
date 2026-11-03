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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_panitia'); 
        $table->string('nama_calon_siswa');
        $table->string('nama_orang_tua');
        $table->string('nomor_orang_tua');
        $table->string('nama_rekomendasi')->nullable(); 
        $table->string('bukti_pendaftaran'); 
        $table->text('catatan_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
