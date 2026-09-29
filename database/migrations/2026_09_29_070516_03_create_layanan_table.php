<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 50);
            $table->decimal('tarif_per_kg', 12, 2);
            $table->decimal('min_kg', 5, 2)->default(1);
            $table->decimal('asuransi_persen', 5, 2)->default(0.2);
            $table->decimal('asuransi_min_nilai', 15, 2)->default(1000000);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('layanan'); }
};