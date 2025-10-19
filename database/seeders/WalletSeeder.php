<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wallets')->insert([
            [
                'name' => 'المحفظة الذهبية', // اسم المحفظة
                'desc' => 'محفظة استثمارية بعائد شهري ثابت بنسبة 10%.', // وصف المحفظة
                'amount' => 5000.00, // الحد الأدنى لرأس المال
                'profit_rate' => 10.00, // نسبة الأرباح الشهرية
                'profit_cycle' => 30, // يتم صرف الأرباح كل 30 يوم
                'duration_months' => 6, // مدة الاستثمار 6 شهور
                'capital_return' => true, // استرجاع رأس المال في نهاية المدة
                'affiliate_commission_rate' => 5.00, // نسبة العمولة للمسوق
                'status' => 'active', // الحالة
                'early_withdraw_penalty' => 2.50, // غرامة السحب المبكر
                'img' => 'wallets/golden.jpg', // صورة رمزية للمحفظة
                'service_id' => 1, // ربط المحفظة بخدمة معينة
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'المحفظة البلاتينية',
                'desc' => 'محفظة طويلة الأجل بعائد أعلى بنسبة 15%.',
                'amount' => 10000.00,
                'profit_rate' => 15.00,
                'profit_cycle' => 30,
                'duration_months' => 12,
                'capital_return' => true,
                'affiliate_commission_rate' => 7.00,
                'status' => 'active',
                'early_withdraw_penalty' => 3.00,
                'img' => 'wallets/platinum.jpg',
                'service_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'المحفظة السريعة',
                'desc' => 'محفظة قصيرة المدى بأرباح شهرية منخفضة مع مرونة عالية.',
                'amount' => 2000.00,
                'profit_rate' => 5.00,
                'profit_cycle' => 15, // صرف الأرباح كل 15 يوم
                'duration_months' => 3,
                'capital_return' => true,
                'affiliate_commission_rate' => 3.50,
                'status' => 'active',
                'early_withdraw_penalty' => 1.00,
                'img' => 'wallets/quick.jpg',
                'service_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
