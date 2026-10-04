<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RankRate; // Disesuaikan menggunakan RankRate

class JokiController extends Controller
{
    public function orderForm(Request $request)
    {
        $type = $request->query('type', 'biasa'); // Default 'biasa'

        // Ambil data tarif joki dari database berdasarkan model RankRate
        $ratesFromDb = RankRate::pluck('price', 'rank_name')->toArray();

        // Fallback default tarif jika database belum terisi
        $defaultRates = [
            'Warrior'         => 1000,
            'Elite'           => 1500,
            'Master'          => 2000,
            'Grandmaster'     => 3000,
            'Epic'            => 4000,
            'Legend'          => 5000,
            'Mythic'          => 8000,
            'Mythic Honor'    => 10000,
            'Mythic Glory'    => 13000,
            'Mythic Immortal' => 18000,
        ];

        // Gabungkan tarif DB dan fallback (prioritas data dari database)
        $rankRates = array_merge($defaultRates, $ratesFromDb);

        return view('joki.order', compact('type', 'rankRates'));
    }
}