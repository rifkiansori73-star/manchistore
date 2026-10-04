<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Membuat link direct WhatsApp (wa.me) dengan format pesan rapi & mutlak 62
     */
    private function waLink(string $phone, string $message): string
    {
        $phone = preg_replace('/\D+/', '', trim($phone));

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62') && strlen($phone) >= 10) {
            $phone = '62' . $phone;
        }

        $cleanMessage = preg_replace('/[^\x20-\x7E\r\n]/u', '', $message);

        return "https://wa.me/{$phone}?text=" . rawurlencode($cleanMessage);
    }

    /**
     * Menampilkan Halaman Utama (Public Home Store)
     */
    public function index()
    {
        $adminWaJoki = class_exists(Setting::class) 
            ? (Setting::where('key', 'wa_admin_joki')->value('value') ?? '6285718447963') 
            : '6285718447963';

        $adminWaAkun = class_exists(Setting::class) 
            ? (Setting::where('key', 'wa_admin_akun')->value('value') ?? '6281234567890') 
            : '6281234567890';

        $jokiText = "Halo ManChi, saya mau nanya seputar layanan manchistore.";
        $jokiGendongText = "Halo ManChi, saya mau order Mabar / Party bareng Pro Player. Mohon info ketersediaan slot dan daftar harganya ya.";

        $defaultJualText = implode("\n", [
            "Halo ManChi, saya mau tawarkan / lepas akun game,",
            "Berikut detail akun yang ingin saya tawarkan :",
            "",
            "- Jenis Game : ",
            "- Nick Account / ID Server : ",
            "- Spesifikasi Ringkas : ",
            "- Open Price : ",
        ]);

        $jokiUrl        = $this->waLink($adminWaJoki, $jokiText);
        $jokiGendongUrl = $this->waLink($adminWaJoki, $jokiGendongText);
        $jualUrl        = $this->waLink($adminWaAkun, $defaultJualText);

        $tiktokUrl = class_exists(Setting::class) 
            ? (Setting::where('key', 'tiktok_url')->value('value') ?? "https://vm.tiktok.com/ZS9ATr3rwv36E-YPXex/") 
            : "https://vm.tiktok.com/ZS9ATr3rwv36E-YPXex/";

        $katalogAkun = collect();
        
        if (class_exists(Account::class) && Schema::hasTable('accounts')) {
            $query = Account::query();

            if (Schema::hasColumn('accounts', 'is_featured')) {
                $query->where('is_featured', 1);
            } elseif (Schema::hasColumn('accounts', 'status')) {
                $query->where('status', 'ready');
            }

            $limit = class_exists(Setting::class) ? (int) (Setting::where('key', 'limit_katalog_home')->value('value') ?? 6) : 6;
            $katalogAkun = $query->latest()->take($limit)->get();
        }

        return view('home', compact(
            'jokiUrl', 
            'jokiGendongUrl', 
            'jualUrl', 
            'tiktokUrl', 
            'adminWaJoki',
            'adminWaAkun',
            'katalogAkun'
        ));
    }

    /**
     * Menampilkan Halaman Detail Akun Game Publik Berdasarkan Slug
     */
    public function showAccount($slug)
    {
        // Cari data akun berdasarkan slug, jika tidak ditemukan otomatis 404
        $account = Account::where('slug', $slug)->firstOrFail();

        // Ambil nomor WA Admin Akun (Admin 2) untuk tombol beli/order akun spesifik ini
        $adminWaAkun = class_exists(Setting::class) 
            ? (Setting::where('key', 'wa_admin_akun')->value('value') ?? '6281234567890') 
            : '6281234567890';

        $buyText = implode("\n", [
            "Halo ManChi, saya tertarik untuk membeli akun game ini:",
            "- Nama Akun: " . $account->name,
            "- Kode/ID: " . ($account->code ?? '-'),
            "- Harga: Rp " . number_format($account->price, 0, ',', '.'),
            "",
            "Mohon info ketersediaan dan proses selanjutnya ya."
        ]);

        $buyUrl = $this->waLink($adminWaAkun, $buyText);

        // Pastikan Anda sudah membuat view ini di resources/views/public/account-detail.blade.php
        // Atau sesuaikan path view dengan struktur folder proyek Anda (misal: 'accounts.detail')
        return view('public.account-detail', compact('account', 'buyUrl'));
    }
}