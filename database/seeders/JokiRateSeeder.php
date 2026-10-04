<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JokiRate;

class JokiRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Tarif Joki Biasa (Lepas Akun)
        $ratesBiasa = [
            'Master'          => 2000,
            'Grandmaster'     => 3000,
            'Epic'            => 4000,
            'Legend'          => 5000,
            'Mythic'          => 8000,
            'Mythic Honor'    => 10000,
            'Mythic Glory'    => 13000,
            'Mythic Immortal' => 18000,
        ];

        // 2. Data Tarif Joki Gendong / Mabar (Party Mode)
        $ratesGendong = [
            'Master'          => 3000,
            'Grandmaster'     => 4500,
            'Epic'            => 6000,
            'Legend'          => 8000,
            'Mythic'          => 12000,
            'Mythic Honor'    => 15000,
            'Mythic Glory'    => 18000,
            'Mythic Immortal' => 25000,
        ];

        // Masukkan data Joki Biasa ke Database
        foreach ($ratesBiasa as $rank => $price) {
            JokiRate::create([
                'rank_name'      => $rank,
                'type'           => 'biasa',
                'price_per_star' => $price,
            ]);
        }

        // Masukkan data Joki Gendong ke Database
        foreach ($ratesGendong as $rank => $price) {
            JokiRate::create([
                'rank_name'      => $rank,
                'type'           => 'gendong',
                'price_per_star' => $price,
            ]);
        }
    }
}