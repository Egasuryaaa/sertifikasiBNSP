<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cabang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100);
            $table->string('kota', 100);
            $table->string('alamat', 255)->nullable();
            $table->timestamps();
            $table->index('kota');
        });
    }
    public function down(): void { Schema::dropIfExists('cabang'); }
};