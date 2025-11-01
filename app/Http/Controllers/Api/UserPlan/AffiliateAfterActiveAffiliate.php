<?php

namespace App\Http\Controllers\Api\UserPlan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserPlan\UserPlanWebStoreRequest;
use App\Models\{Affiliate, Rank, User, UserRank, UserBalance, UserPlan};
use App\Traits\ApiResponseTrait;

class AffiliateAfterActiveAffiliate extends Controller
{
    use ApiResponseTrait;
    public function activeParentForAffiliate(Request $request)
    {
         $user = $request->get('user');
 
        $planPrice = 100;

        DB::transaction(function () use ($user, $planPrice) {
            $parentIds = Affiliate::where('user_id', $user['id'])->pluck('parent_id');
            if ($parentIds->isEmpty()) {
                Log::info('User has no parents', ['user_id' => $user['id']]);
                return;
            }

            Affiliate::whereIn('parent_id', $parentIds)->update(['active' => true]);

            $ranks = Rank::orderByDesc('count_direct')
                ->orderByDesc('count_undirect')
                ->get()
                ->keyBy('id');

            foreach ($parentIds as $parentId) {
                $affiliates = Affiliate::where('parent_id', $parentId)
                    ->where('active', true)
                    ->get(['generation']);

                $countDirect = $affiliates->where('generation', 1)->count();
                $countIndirect = $affiliates->where('generation', '>', 1)->count();

                $generationForParent = Affiliate::where('user_id', $user['id'])
                    ->where('parent_id', $parentId)
                    ->value('generation');

                if (!$generationForParent) {
                    continue;
                }

                $rank = $ranks->first(function ($r) use ($countDirect, $countIndirect) {
                    return $r->count_direct <= $countDirect && $r->count_undirect <= $countIndirect;
                });

                if (!$rank) {
                    continue;
                }

                UserRank::updateOrCreate(
                    ['user_id' => $parentId],
                    [
                        'rank' => $rank->id,
                        'count_direct_active' => $countDirect,
                        'count_indirect_active' => $countIndirect,
                        'count_direct' => $affiliates->where('generation', 1)->count(),
                        'count_indirect' => $affiliates->where('generation', '>', 1)->count(),
                    ]
                );

                $parentUser = User::select('id', 'affiliate_code_active')->find($parentId);
                if (!$parentUser || !$parentUser->affiliate_code_active) {
                    continue;
                }


                $this->distributeProfit($parentId, $rank, $user['id'], $planPrice, $generationForParent);
            }
        });
    }

    /**
     */
    private function distributeProfit($parentId, $rank, $subscribedUserId, $planPrice, $generationLevel)
    {
        $profits = [
            1 => $rank->profit_g1,
            2 => $rank->profit_g2,
            3 => $rank->profit_g3,
            4 => $rank->profit_g4,
            5 => $rank->profit_g5,
        ];

        $profitPercentage = $profits[$generationLevel] ?? 0;

        if ($profitPercentage <= 0) {

            return;
        }

        $amount = ($planPrice * $profitPercentage) / 100;

        Affiliate::where('parent_id', $parentId)
            ->where('user_id', $subscribedUserId)
            ->increment('moony', $amount);

        UserBalance::updateOrCreate(
            ['user_id' => $parentId],
            ['balance' => DB::raw("balance + $amount")]
        );
    }



    /////////////////////After Activate Affiliate//////////////////////

//    public function activeAffiliate(Request $request)
// {
//     $user = $request->get('user'); 

//     $parentIds = Affiliate::where('user_id', $user['id'])->pluck('parent_id')->toArray();
//     $parentIds->active=1;
//     $parentIds->save();

//     if (empty($parentIds)) {
//         return $this->errorResponse('No parent found');
//     }

//     $ranks = Rank::orderByDesc('count_direct')
//                  ->orderByDesc('count_undirect')
//                  ->get();

//     $affiliates = Affiliate::where('user_id', $user['id'])
//                            ->get(['parent_id', 'generation']);

//     foreach ($parentIds as $parentId) {
//         $parentUser = User::select('id', 'affiliate_code_active')->find($parentId);
//         if (!$parentUser || !$parentUser->affiliate_code_active) {
//             continue;
//         }

//         $generationForParent = $affiliates->firstWhere('parent_id', $parentId)?->generation;

//         $this->distributeProfit($parentId, $ranks, $user['id'], 100, $generationForParent);
//     }

//     return $this->successResponse('Affiliate profit distributed successfully');
// }

}
