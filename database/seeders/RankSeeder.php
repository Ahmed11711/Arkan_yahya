<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $ranks = [
            [
                'name' => 'Bronze',
                'desc' => 'الرتبة البرونزية',
                'count_direct' => 2,
                'count_undirect' => 5,
                'profit_g1' => 10,
                'profit_g2' => 5,
                'profit_g3' => 2,
                'profit_g4' => 1,
                'profit_g5' => 0.5,
            ],
            [
                'name' => 'Silver',
                'desc' => 'الرتبة الفضية',
                'count_direct' => 5,
                'count_undirect' => 10,
                'profit_g1' => 15,
                'profit_g2' => 10,
                'profit_g3' => 5,
                'profit_g4' => 2,
                'profit_g5' => 1,
            ],
            [
                'name' => 'Gold',
                'desc' => 'الرتبة الذهبية',
                'count_direct' => 10,
                'count_undirect' => 20,
                'profit_g1' => 20,
                'profit_g2' => 15,
                'profit_g3' => 10,
                'profit_g4' => 5,
                'profit_g5' => 2,
            ],
            [
                'name' => 'Platinum',
                'desc' => 'الرتبة البلاتينية',
                'count_direct' => 20,
                'count_undirect' => 40,
                'profit_g1' => 25,
                'profit_g2' => 20,
                'profit_g3' => 15,
                'profit_g4' => 10,
                'profit_g5' => 5,
            ],
            [
                'name' => 'Diamond',
                'desc' => 'الرتبة الماسية',
                'count_direct' => 50,
                'count_undirect' => 100,
                'profit_g1' => 30,
                'profit_g2' => 25,
                'profit_g3' => 20,
                'profit_g4' => 15,
                'profit_g5' => 10,
            ],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
