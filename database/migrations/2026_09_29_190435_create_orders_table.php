<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // Contoh: MANCHI-12345
            $table->string('customer_name')->default('Guest'); // Nama atau 'Guest' seperti di gambar
            $table->string('service_type'); // joki, joki_gendong, jual_akun, beli_akun
            $table->text('order_details'); // Detail spesifikasi / format order
            $table->decimal('price', 15, 2)->default(0); // Harga
            $table->decimal('profit', 15, 2)->default(0); // Profit (opsional)
            $table->enum('status', ['Pending', 'Paid', 'Processing', 'Success', 'Canceled'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};