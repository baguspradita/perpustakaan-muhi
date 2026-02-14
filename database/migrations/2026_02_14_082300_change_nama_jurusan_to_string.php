<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah kolom nama_jurusan dari enum menjadi string
     * agar bisa menerima nama jurusan bebas (tidak terbatasi pada enum values)
     */
    public function up(): void
    {
        Schema::table('jurusan', function (Blueprint $table) {
            // Ubah kolom enum menjadi string dengan max 50 karakter
            $table->string('nama_jurusan', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     * Kembalikan kolom ke enum jika migration di-rollback
     */
    public function down(): void
    {
        Schema::table('jurusan', function (Blueprint $table) {
            // Kembalikan ke enum dengan nilai asli
            $table->enum('nama_jurusan', ['RPL', 'TI', 'SI', 'AK', 'PM'])->change();
        });
    }
};
