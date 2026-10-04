<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RankRate;

class RankRateController extends Controller
{
    // Menampilkan halaman daftar harga di Admin Panel
    public function index()
    {
        $rates = RankRate::all();
        return view('admin.joki.index', compact('rates'));
    }

    // Menyimpan rank baru
    public function store(Request $request)
    {
        $request->validate([
            'rank_name' => 'required|string|unique:rank_rates,rank_name',
            'price' => 'required|integer|min:0',
        ]);

        RankRate::create([
            'rank_name' => $request->rank_name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Rank baru berhasil ditambahkan!');
    }

    // Menyimpan perubahan harga dari Admin Panel (Mass Update)
    public function update(Request $request)
    {
        $prices = $request->input('prices', []);

        foreach ($prices as $id => $price) {
            RankRate::where('id', $id)->update(['price' => $price]);
        }

        return redirect()->back()->with('success', 'Tarif joki berhasil diperbarui!');
    }

    // Menghapus rank
    public function destroy($id)
    {
        RankRate::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Rank berhasil dihapus!');
    }

    // Reset/Seed data default jika diperlukan
    public function seedDefault()
    {
        $defaults = [
            ['rank_name' => 'Warrior', 'price' => 1000],
            ['rank_name' => 'Elite', 'price' => 1500],
            ['rank_name' => 'Master', 'price' => 2000],
            ['rank_name' => 'Grandmaster', 'price' => 3000],
            ['rank_name' => 'Epic', 'price' => 4000],
            ['rank_name' => 'Legend', 'price' => 5000],
            ['rank_name' => 'Mythic', 'price' => 8000],
            ['rank_name' => 'Mythic Honor', 'price' => 10000],
            ['rank_name' => 'Mythic Glory', 'price' => 13000],
            ['rank_name' => 'Mythic Immortal', 'price' => 18000],
        ];

        foreach ($defaults as $d) {
            RankRate::updateOrCreate(['rank_name' => $d['rank_name']], $d);
        }

        return redirect()->back()->with('success', 'Tarif default berhasil dimuat ulang!');
    }
}