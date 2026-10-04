<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RankRate;

class RankRateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
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

        foreach ($rates as $rate) {
            RankRate::updateOrCreate(['rank_name' => $rate['rank_name']], $rate);
        }
    }
}