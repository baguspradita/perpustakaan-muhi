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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman');
            $table->foreignId('buku_id')->constrained('buku');
            $table->integer('jumlah')->default(1);
            $table->string('id_eksamplar', 10)->nullable()->after('buku_id')->comment('ID Eksamplar buku yang dipinjam (format 5 digit: 00001)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
