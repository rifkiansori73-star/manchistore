<?php

use Illuminate\Support\Facades\Route;

// Import Controller Public & Utama
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JokiController;
use App\Http\Controllers\CheckoutController;

// Import Controller Autentikasi & Admin
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\JokiRateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;

// Import Model User untuk route pembuatan admin kilat
use App\Models\User;

/*
|--------------------------------------------------------------------------
| ROUTE KILAT PEMBUATAN AKUN ADMIN (Sementara)
|--------------------------------------------------------------------------
*/
Route::get('/buat-admin-kilat', function () {
    User::updateOrCreate(
        ['email' => 'admin@manchistore.com'],
        [
            'name' => 'Admin ManChi',
            'password' => bcrypt('password123'),
            'is_admin' => 1
        ]
    );
    return "Akun admin berhasil dibuat di database online! Silakan hapus rute ini kembali.";
});


/*
|--------------------------------------------------------------------------
| 1. AREA PUBLIC (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/akun', [AccountController::class, 'index'])->name('akun.index');

// DISESUAIKAN: Rute detail akun publik diarahkan ke AccountController agar cocok dengan method show($identifier)
Route::get('/akun/{identifier}', [AccountController::class, 'show'])->name('akun.show');

Route::get('/joki/order', [JokiController::class, 'orderForm'])->name('joki.order');
Route::post('/checkout/order', [CheckoutController::class, 'storeOrder'])->name('checkout.order');


/*
|--------------------------------------------------------------------------
| 2. AREA AUTENTIKASI (Login & Logout)
|--------------------------------------------------------------------------
*/
// Rute login menggunakan middleware 'guest' bawaan Laravel
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');

// DITAMBAHKAN THROTTLE DI SINI (Maksimal 5 kali salah login dalam 1 menit)
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 3. AREA ADMIN PANEL (Wajib Login & Wajib Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [OrderController::class, 'index'])->name('admin.dashboard');
    
    // 1. Manajemen Orderan
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // 2. Kelola Tarif Joki
    Route::get('/joki-rates', [JokiRateController::class, 'index'])->name('admin.joki.index');
    Route::post('/joki-rates', [JokiRateController::class, 'store'])->name('admin.joki.store');
    Route::post('/joki-rates/update', [JokiRateController::class, 'update'])->name('admin.joki.update');
    Route::delete('/joki-rates/{id}', [JokiRateController::class, 'destroy'])->name('admin.joki.destroy');
    Route::post('/joki-rates/seed', [JokiRateController::class, 'seedDefault'])->name('admin.joki.seed');

    // 3. Web Settings - Setting Kontak & WA Admin
    Route::get('/settings', [SettingController::class, 'kontakIndex'])->name('admin.settings.index');
    Route::get('/settings/kontak', [SettingController::class, 'kontakIndex'])->name('admin.settings.kontak');
    Route::post('/settings/kontak', [SettingController::class, 'kontakUpdate'])->name('admin.settings.kontak.update');

    // Pengaturan Limit & Status Katalog Web Depan
    Route::post('/settings/katalog/limit', [SettingController::class, 'updateKatalogSetting'])->name('admin.settings.katalog.limit');
    Route::post('/settings/katalog/{id}/toggle', [SettingController::class, 'toggleFeatured'])->name('admin.settings.katalog.toggle');
    Route::post('/settings/katalog/{id}/status', [SettingController::class, 'updateStatus'])->name('admin.settings.katalog.status');

    // 4. Kelola Stok & Katalog Akun Game
    Route::get('/accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
    Route::get('/accounts/create', [AdminAccountController::class, 'create'])->name('admin.accounts.create');
    Route::post('/accounts', [AdminAccountController::class, 'store'])->name('admin.accounts.store');
    Route::get('/accounts/{id}/edit', [AdminAccountController::class, 'edit'])->name('admin.accounts.edit');
    Route::put('/accounts/{id}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
    Route::delete('/accounts/{id}', [AdminAccountController::class, 'destroy'])->name('admin.accounts.destroy');

    Route::post('/accounts/{id}/toggle', [AdminAccountController::class, 'toggleFeatured'])->name('admin.accounts.toggle');

});