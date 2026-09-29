<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('telepon', 20);
            $table->text('alamat')->nullable();
            $table->boolean('is_member')->default(false);
            $table->timestamps();
            $table->index('email');
        });
    }
    public function down(): void { Schema::dropIfExists('pelanggan'); }
};