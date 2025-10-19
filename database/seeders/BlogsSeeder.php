<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Carbon\Carbon;

class BlogsSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'name' => 'Introduction to the World of Trading',
                'text' => 'Trading is the process of buying and selling financial assets with the goal of making a profit...',
                'user_id' => 1,
                'img' => 'blogs/trading_intro.jpg',
                'push' => true,
                'service_id' => 1,
                'push_date' => Carbon::now()->addDays(5),
            ],
            [
                'name' => 'What is the Forex Market and How Does It Work?',
                'text' => 'The Forex market is the largest financial market in the world, where currencies are traded daily...',
                'user_id' => 1,
                'img' => 'blogs/forex_market.jpg',
                'push' => true,
                'service_id' => 2,
                'push_date' => Carbon::now()->addDays(3),
            ],
            // باقي العناصر...
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
