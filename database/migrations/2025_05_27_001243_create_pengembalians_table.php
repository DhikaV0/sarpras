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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->foreignId('returned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('deskripsi_pengembalian')->nullable();
            $table->string('foto_pengembalian')->nullable();
            $table->timestamp('tanggal_pengajuan_kembali')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->enum('status_pengembalian', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
