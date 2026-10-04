<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * (Opsional, Laravel otomatis mendeteksi tabel 'orders')
     */
    protected $table = 'orders';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'order_id',
        'customer_name',
        'service_type',
        'order_details',
        'price',
        'profit',
        'status',
        'cancel_proof',  // File path foto bukti pembatalan
        'cancel_reason', // Teks deskripsi alasan pembatalan
    ];

    /**
     * Nilai default untuk atribut tertentu (opsional).
     */
    protected $attributes = [
        'customer_name' => 'Guest',
        'price' => 0,
        'profit' => 0,
        'status' => 'Pending',
    ];
}