<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('created_at', 'desc')->paginate(10);
        $limitDisplay = Setting::where('key', 'limit_katalog_home')->value('value') ?? 6;

        return view('admin.accounts.index', compact('accounts', 'limitDisplay'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp', // Batasan max dihapus
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp', // Validasi untuk multiple galeri
        ]);

        $data = $request->except(['image', 'images']);
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Simpan Thumbnail Utama
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('accounts', 'public');
        }

        // Simpan Multiple Foto Galeri
        $galleryImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $galleryImages[] = $file->store('accounts', 'public');
            }
        }
        $data['images'] = $galleryImages;

        Account::create($data);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun game berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp', // Batasan max dihapus
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp', // Validasi untuk multiple galeri
        ]);

        $data = $request->except(['image', 'images']);
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Update Thumbnail Utama
        if ($request->hasFile('image')) {
            if ($account->image && Storage::disk('public')->exists($account->image)) {
                Storage::disk('public')->delete($account->image);
            }
            $data['image'] = $request->file('image')->store('accounts', 'public');
        }

        // Gabungkan atau Tambah Foto Galeri Baru secara Multiple tanpa batasan jumlah
        $existingImages = $account->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $existingImages[] = $file->store('accounts', 'public');
            }
        }
        $data['images'] = $existingImages;

        $account->update($data);

        return redirect()->route('admin.accounts.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        if ($account->image && Storage::disk('public')->exists($account->image)) {
            Storage::disk('public')->delete($account->image);
        }

        // Hapus juga file-file galeri jika ada
        if (!empty($account->images) && is_array($account->images)) {
            foreach ($account->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $account->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }

    // Update limit tampil di home
    public function updateLimit(Request $request)
    {
        Setting::updateOrCreate(
            ['key' => 'limit_katalog_home'],
            ['value' => $request->limit]
        );

        return redirect()->back()->with('success', 'Limit katalog berhasil disimpan!');
    }

    // Toggle status tampil di web depan (is_featured)
    public function toggleFeatured($id)
    {
        $account = Account::findOrFail($id);
        $account->is_featured = ($account->is_featured == 1) ? 0 : 1;
        $account->save();

        return redirect()->back()->with('success', 'Status tampil akun web depan berhasil diubah!');
    }

    // Update status stok akun (ready / booked / sold)
    public function updateStatus(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->status = $request->status;
        $account->save();

        return redirect()->back()->with('success', 'Status stok akun berhasil diperbarui!');
    }
}