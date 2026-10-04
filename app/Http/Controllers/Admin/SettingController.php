<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Account; // Model Account untuk kelola stok katalog

class SettingController extends Controller
{
    // Alias / Default index route mengarah ke Kontak
    public function index()
    {
        return $this->kontakIndex();
    }

    // 1. Tampilan Setting Kontak WA Admin
    public function kontakIndex()
    {
        $waAdminJoki  = $this->getSetting('wa_admin_joki', '6285718447963');
        $waAdminAkun  = $this->getSetting('wa_admin_akun', '6281234567890');
        $tiktokUrl    = $this->getSetting('tiktok_url', 'https://tiktok.com');
        $instagramUrl = $this->getSetting('instagram_url', 'https://instagram.com');

        return view('admin.settings.kontak', compact('waAdminJoki', 'waAdminAkun', 'tiktokUrl', 'instagramUrl'));
    }

    // Update Kontak WA Admin & Sosmed
    public function kontakUpdate(Request $request)
    {
        $request->validate([
            'wa_admin_joki' => 'required|numeric',
            'wa_admin_akun' => 'required|numeric',
            'tiktok_url'    => 'nullable|string',
            'instagram_url' => 'nullable|string',
        ]);

        $this->setSetting('wa_admin_joki', $request->wa_admin_joki);
        $this->setSetting('wa_admin_akun', $request->wa_admin_akun);
        $this->setSetting('tiktok_url', $request->tiktok_url);
        $this->setSetting('instagram_url', $request->instagram_url);

        return redirect()->back()->with('success', 'Pengaturan Kontak & Social Media berhasil disimpan!');
    }

    // 2. Tampilan Setting Stok & Display Katalog Akun untuk Web Depan
    public function katalogIndex()
    {
        $accounts     = Account::orderBy('created_at', 'desc')->get();
        $limitDisplay = $this->getSetting('limit_katalog_home', 6);

        return view('admin.settings.katalog', compact('accounts', 'limitDisplay'));
    }

    // Toggle Tampilkan Akun di Web Depan (Featured)
    public function toggleFeatured($id)
    {
        $account = Account::findOrFail($id);
        $account->is_featured = !$account->is_featured;
        $account->save();

        return redirect()->back()->with('success', 'Status tampilan akun berhasil diperbarui!');
    }

    // Update Status Stok Akun (Ready / Sold Out)
    public function updateStatus(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->status = $request->status; // 'ready' / 'sold'
        $account->save();

        return redirect()->back()->with('success', 'Status stok akun berhasil diperbarui!');
    }

    // Update Pengaturan Tampilan Jumlah Katalog Home
    public function updateKatalogSetting(Request $request)
    {
        $this->setSetting('limit_katalog_home', $request->limit_katalog_home);
        return redirect()->back()->with('success', 'Setting jumlah katalog web depan berhasil disimpan!');
    }

    /**
     * Helper Ambil Setting
     */
    private function getSetting($key, $default = null)
    {
        $item = Setting::where('key', $key)->first();
        return $item ? $item->value : $default;
    }

    /**
     * Helper Simpan Setting
     */
    private function setSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value ?? '']
        );
    }
}