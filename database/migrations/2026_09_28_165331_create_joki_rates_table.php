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
        Schema::create('joki_rates', function (Blueprint $table) {
            $table->id();
            $table->string('rank_name'); // Nama Rank (contoh: Master, Epic, Legend, Mythic)
            $table->enum('type', ['biasa', 'gendong']); // Membedakan tipe Joki Biasa & Joki Gendong
            $table->integer('price_per_star'); // Harga per bintang / point (contoh: 4000)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joki_rates');
    }
};