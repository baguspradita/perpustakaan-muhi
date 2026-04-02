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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            
            $table->string('nama_depan_penulis', 100)->nullable();
            $table->string('nama_belakang_penulis', 100)->nullable();
            $table->char('huruf_judul_awal', 1)->nullable();
            $table->string('nomor_salinan', 10)->nullable();

            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->foreignId('kategori_id')->constrained('kategori_buku');
            $table->unsignedBigInteger('lokasi_id')->nullable();
            $table->unsignedBigInteger('subjek_id')->nullable();
            $table->foreign('subjek_id')->references('id')->on('subjek_buku')->onDelete('set null');
            $table->integer('jumlah');
             $table->softDeletes()->after('updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
