<?php

namespace App\Http\Controllers\Api\UserPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPlan\UserPlanWebStoreRequest;
use App\Models\Affiliate;
use App\Models\Rank;
use App\Models\UserRank;
use App\Models\UserBalance;
use App\Models\UserPlan;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AffiliateAfterSubscribe extends Controller
{
    public function activeParent(UserPlanWebStoreRequest $request)
    {
        $user = $request->get('user');
        $walletId = $request->input('wallet_id');
        $planPrice = UserPlan::where([
            'wallet_id' => $walletId,
            'user_id' => $user['id'],
          ])
            ->orderBy('id', 'desc') // أو orderBy('created_at', 'desc')
            ->value('amount');
        DB::transaction(function () use ($user, $planPrice) {
            $parentIds = Affiliate::where('user_id', $user['id'])->pluck('parent_id');
            Log::info('Parent IDs fetched', ['parent_ids' => $parentIds]);

            if ($parentIds->isEmpty()) {
                Log::warning('No parents found for user', ['user_id' => $user['id']]);
                return;
            }

            // ✅ تفعيل الآباء
            Affiliate::whereIn('parent_id', $parentIds)->update(['active' => true]);

            // ✅ تحميل الرتب
            $ranks = Rank::orderByDesc('count_direct')
                ->orderByDesc('count_undirect')
                ->get();

             foreach ($parentIds as $parentId) {
                $countDirect = Affiliate::where('parent_id', $parentId)
                    ->where('active', true)
                    ->where('generation', 1)
                    ->count();

                $countIndirect = Affiliate::where('parent_id', $parentId)
                    ->where('active', true)
                    ->where('generation', '>', 1)
                    ->count();

                 $rank = $ranks->first(function ($r) use ($countDirect, $countIndirect) {
                    return $r->count_direct <= $countDirect && $r->count_undirect <= $countIndirect;
                });

                if (!$rank) {
                    continue;
                }

                // ✅ تحديث بيانات الرتبة
                $parentRank = UserRank::firstOrCreate(['user_id' => $parentId]);
                $parentRank->update([
                    'rank' => $rank->id,
                    'count_direct_active' => $countDirect,
                    'count_indirect_active' => $countIndirect,
                    'count_direct' => Affiliate::where('parent_id', $parentId)
                        ->where('generation', 1)
                        ->count(),
                    'count_indirect' => Affiliate::where('parent_id', $parentId)
                        ->where('generation', '>', 1)
                        ->count(),
                ]);

                // ✅ توزيع الأرباح
                $this->distributeProfit($parentId, $rank, $user['id'], $planPrice);
            }
        });

        Log::info('=== End: AffiliateAfterSubscribe::activeParent ===');
    }

    /**
     * توزيع الأرباح على الآباء بناءً على الرتبة وعدد الأجيال.
     */
    private function distributeProfit($parentId, $rank, $subscribedUserId, $planPrice)
    {
        $profits = [
            1 => $rank->profit_g1,
            2 => $rank->profit_g2,
            3 => $rank->profit_g3,
            4 => $rank->profit_g4,
            5 => $rank->profit_g5,
        ];

        foreach ($profits as $generation => $profit) {
            if ($profit > 0) {
                $amount = ($planPrice * $profit) / 100;

                Log::info('Distributing profit', [
                    'parent_id' => $parentId,
                    'generation' => $generation,
                    'profit_percent' => $profit,
                    'amount' => $amount,
                    'from_user_id' => $subscribedUserId,
                ]);

                // ✅ نحصل على علاقة الأفلييت بين الأب والابن
                $affiliate = Affiliate::where('parent_id', $parentId)
                    ->where('user_id', $subscribedUserId)
                    ->first();

                if ($affiliate) {
                    // 🔹 نضيف المبلغ في عمود amount
                    $affiliate->increment('moony', $amount);


                    Log::info('Affiliate updated with profit', [
                        'parent_id' => $parentId,
                        'user_id' => $subscribedUserId,
                        'added_amount' => $amount,
                        'new_amount' => $affiliate->amount,
                    ]);
                }

                // ✅ تحديث رصيد المستخدم في جدول UserBalance
                $balance = UserBalance::firstOrCreate(['user_id' => $parentId]);
                $balance->increment('balance', $amount);

                Log::info('UserBalance updated', [
                    'parent_id' => $parentId,
                    'new_balance' => $balance->balance,
                ]);
            }
        }
    }
}
