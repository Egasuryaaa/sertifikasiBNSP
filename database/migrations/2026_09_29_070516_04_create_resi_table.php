<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_resi', 30)->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->restrictOnDelete();
            $table->foreignId('cabang_asal_id')->constrained('cabang')->restrictOnDelete();
            $table->foreignId('cabang_tujuan_id')->constrained('cabang')->restrictOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_penerima', 100);
            $table->string('telepon_penerima', 20);
            $table->text('alamat_penerima');
            $table->decimal('berat_aktual', 8, 2);
            $table->decimal('panjang', 8, 2)->nullable();
            $table->decimal('lebar', 8, 2)->nullable();
            $table->decimal('tinggi', 8, 2)->nullable();
            $table->decimal('berat_tagih', 8, 2);
            $table->decimal('nilai_barang', 15, 2)->default(0);
            $table->decimal('biaya_dasar', 12, 2);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('asuransi', 12, 2)->default(0);
            $table->decimal('total_biaya', 12, 2);
            $table->enum('status', ['pending', 'pickup', 'transit', 'delivery', 'terkirim', 'gagal'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index('nomor_resi');
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('resi'); }
};