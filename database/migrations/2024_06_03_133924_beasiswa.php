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
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->unsignedBigInteger('period_id');
            $table->foreign('period_id')->references('id')->on('period')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('kategori_beasiswa')->onDelete('cascade');
            $table->string('ipk');
            $table->string('transkrip_akademik');
            $table->string('surat_rekomendasi_dosen');
            $table->string('surat_pernyataan_beasiswa');
            $table->string('bukti_keaktifan');
            $table->string('dokumen_pendukung_lain');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
