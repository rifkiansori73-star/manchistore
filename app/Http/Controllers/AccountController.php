<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    // Menampilkan Katalog Akun dengan Fitur Pencarian & Pagination
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query dasar dengan pengecekan kolom status
        $query = Account::query();

        if (Schema::hasColumn('accounts', 'status')) {
            $query->whereIn('status', ['ready', 'available', 'Ready', 'Available']);
        }

        // Filter pencarian berdasarkan keyword (Nama, Kode, Rank, Skin, Hero, dll) tanpa 'title'
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('rank', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%")
                  ->orWhere('skin_count', 'like', "%{$keyword}%")
                  ->orWhere('hero_count', 'like', "%{$keyword}%");
            });
        }

        // Ambil data dengan pagination (12 item per halaman)
        $accounts = $query->latest()->paginate(12);
        
        // Ambil nomor WA admin dari Setting, fallback ke default jika kosong
        $adminWa = Setting::where('key', 'wa_admin_akun')->value('value') ?? '6285718447963';
        $emptyStockMessage = rawurlencode("Hallo ManChi, saya mau tanya apakah ada stok akun game yang ready saat ini?");
        $waAdminUrl = "https://wa.me/{$adminWa}?text={$emptyStockMessage}";

        return view('accounts.index', compact('accounts', 'waAdminUrl', 'keyword'));
    }

    // Menampilkan Detail Spesifikasi Akun
    public function show($identifier)
    {
        $account = Account::where('slug', $identifier)
                    ->orWhere('id', $identifier)
                    ->firstOrFail();

        $adminWaAkun = Setting::where('key', 'wa_admin_akun')->value('value') ?? '6285718447963'; 
        
        $accTitle = $account->name ?? 'Akun Game';
        $buyMessage = rawurlencode("Hallo Admin, saya mau beli akun ini:\n- Kode: " . ($account->code ?? $account->id) . "\n- Nama: {$accTitle}\n- Harga: Rp " . number_format($account->price ?? 0, 0, ',', '.'));
        $buyUrl = "https://wa.me/{$adminWaAkun}?text={$buyMessage}";

        return view('accounts.show', compact('account', 'buyUrl', 'adminWaAkun'));
    }

    // Menampilkan daftar akun di panel admin
    public function adminIndex()
    {
        $accounts = Account::latest()->paginate(10);
        return view('admin.accounts.index', compact('accounts'));
    }

    // Menampilkan form tambah akun
    public function create()
    {
        return view('admin.accounts.create');
    }

    // Menyimpan data akun baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'old_price' => 'nullable',
            'code' => 'nullable|string|max:50',
            'status' => 'required|string',
            'rank' => 'nullable|string',
            'skin_count' => 'nullable|integer',
            'hero_count' => 'nullable|integer',
            'emblem' => 'nullable|string',
            'login_via' => 'nullable|string',
            'minus' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Bersihkan format harga
        $rawPrice = str_replace(['.', ','], '', $request->price);
        $validated['price'] = is_numeric($rawPrice) ? (float) $rawPrice : 0;

        if (!empty($request->old_price)) {
            $rawOldPrice = str_replace(['.', ','], '', $request->old_price);
            $validated['old_price'] = is_numeric($rawOldPrice) ? (float) $rawOldPrice : null;
        } else {
            $validated['old_price'] = null;
        }

        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Handle Upload Gambar Utama
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('accounts', 'public');
        }

        // Handle Upload Multi-Screenshot Galeri
        $galleryImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $galleryImages[] = $file->store('accounts/gallery', 'public');
            }
            $validated['images'] = $galleryImages; 
        }

        $account = Account::create($validated);

        // Generate slug stabil
        $account->update([
            'slug' => Str::slug($request->name) . '-' . $account->id
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun game berhasil ditambahkan!');
    }

    // Menampilkan form edit akun
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('admin.accounts.edit', compact('account'));
    }

    // Memperbarui data akun
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'old_price' => 'nullable',
            'code' => 'nullable|string|max:50',
            'status' => 'required|string',
            'rank' => 'nullable|string',
            'skin_count' => 'nullable|integer',
            'hero_count' => 'nullable|integer',
            'emblem' => 'nullable|string',
            'login_via' => 'nullable|string',
            'minus' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Bersihkan format harga
        $rawPrice = str_replace(['.', ','], '', $request->price);
        $validated['price'] = is_numeric($rawPrice) ? (float) $rawPrice : 0;

        if (!empty($request->old_price)) {
            $rawOldPrice = str_replace(['.', ','], '', $request->old_price);
            $validated['old_price'] = is_numeric($rawOldPrice) ? (float) $rawOldPrice : null;
        } else {
            $validated['old_price'] = null;
        }

        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Update Gambar Utama
        if ($request->hasFile('image')) {
            if ($account->image && Storage::disk('public')->exists($account->image)) {
                Storage::disk('public')->delete($account->image);
            }
            $validated['image'] = $request->file('image')->store('accounts', 'public');
        }

        // Update Galeri Screenshot
        if ($request->hasFile('images')) {
            $galleryImages = $account->images ?? [];
            if (!is_array($galleryImages)) {
                $galleryImages = [];
            }
            foreach ($request->file('images') as $file) {
                $galleryImages[] = $file->store('accounts/gallery', 'public');
            }
            $validated['images'] = $galleryImages;
        }

        if (empty($account->slug) || $request->name !== $account->name) {
            $validated['slug'] = Str::slug($request->name) . '-' . $account->id;
        }

        $account->update($validated);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun game berhasil diperbarui!');
    }

    // Menghapus data akun
    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        if ($account->image && Storage::disk('public')->exists($account->image)) {
            Storage::disk('public')->delete($account->image);
        }

        if (!empty($account->images) && is_array($account->images)) {
            foreach ($account->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun game berhasil dihapus!');
    }
}