<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JokiRate;
use Illuminate\Http\Request;

class JokiRateController extends Controller
{
    public function index()
    {
        // Ambil semua data tarif joki dari database
        $rates = JokiRate::orderBy('type')->orderBy('id')->get();

        return view('admin.joki.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'           => 'required|in:biasa,gendong',
            'rank_name'      => 'required|string',
            'price_per_star' => 'required|numeric|min:0',
        ]);

        JokiRate::create([
            'type'           => $request->type,
            'rank_name'      => $request->rank_name,
            'price_per_star' => $request->price_per_star,
        ]);

        return back()->with('success', 'Tarif Joki baru berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'rates' => 'required|array',
        ]);

        foreach ($request->rates as $id => $data) {
            JokiRate::where('id', $id)->update([
                'rank_name'      => $data['rank_name'] ?? '',
                'price_per_star' => $data['price_per_star'] ?? 0,
            ]);
        }

        return back()->with('success', 'Semua perubahan tarif Joki berhasil disimpan!');
    }

    public function destroy($id)
    {
        $rate = JokiRate::findOrFail($id);
        $rate->delete();

        return back()->with('success', 'Tarif Joki berhasil dihapus!');
    }

    // Generate Tarif Default Jika Tabel Masih Kosong
    public function seedDefault()
    {
        $defaultRanks = [
            ['Warrior', 1000],
            ['Elite', 1500],
            ['Master', 2000],
            ['Grandmaster', 3000],
            ['Epic', 4000],
            ['Legend', 5000],
            ['Mythic', 8000],
            ['Mythic Honor', 10000],
            ['Mythic Glory', 13000],
            ['Mythic Immortal', 18000],
        ];

        foreach (['biasa', 'gendong'] as $type) {
            $multiplier = ($type === 'gendong') ? 1.5 : 1.0; // Joki gendong +50%
            foreach ($defaultRanks as $rank) {
                JokiRate::firstOrCreate(
                    ['type' => $type, 'rank_name' => $rank[0]],
                    ['price_per_star' => $rank[1] * $multiplier]
                );
            }
        }

        return back()->with('success', 'Data tarif default berhasil dibuat otomatis!');
    }
}