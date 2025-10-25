<?php

namespace App\Http\Controllers\Api\UserPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPlan\UserPlanWebStoreRequest;
use App\Models\Affiliate;
use App\Models\Rank;
use App\Models\UserRank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AffiliateAfterSubscribe extends Controller
{
    public function activeParent(UserPlanWebStoreRequest $request)
    {
        Log::info('=== Start: AffiliateAfterSubscribe::activeParent ===');

        $user = $request->get('user');
        if (!$user) {
            Log::warning('No user found in request');
            return;
        }

        Log::info('User received', ['user' => $user]);

        DB::transaction(function () use ($user) {
            Log::info('Transaction started');

            // 1️⃣ جلب جميع الآباء
            $parentIds = Affiliate::where('user_id', $user['id'])->pluck('parent_id');
            Log::info('Parent IDs fetched', ['parent_ids' => $parentIds]);

            if ($parentIds->isEmpty()) {
                Log::warning('No parents found for user', ['user_id' => $user['id']]);
                return;
            }

            // 2️⃣ تفعيل الآباء
            $updated = Affiliate::whereIn('parent_id', $parentIds)->update(['active' => true]);
            Log::info('Parents activated', ['count' => $updated]);

            // 3️⃣ تحميل الرتب
            $ranks = Rank::orderByDesc('count_direct')
                ->orderByDesc('count_undirect')
                ->get();
            Log::info('Ranks loaded', ['total_ranks' => $ranks->count()]);

            // 4️⃣ حلقة المرور على كل أب
            foreach ($parentIds as $parentId) {
                Log::info('Processing parent', ['parent_id' => $parentId]);

                $countDirect = Affiliate::where('parent_id', $parentId)
                    ->where('active', true)
                    ->where('generation', 1)
                    ->count();
                $countIndirect = Affiliate::where('parent_id', $parentId)
                    ->where('active', true)
                    ->where('generation', '>', 1)
                    ->count();

                Log::info('Counts calculated', [
                    'parent_id' => $parentId,
                    'count_direct_active' => $countDirect,
                    'count_indirect_active' => $countIndirect,
                ]);

                $rank = $ranks->first(function ($r) use ($countDirect, $countIndirect) {
                    return $r->count_direct <= $countDirect && $r->count_undirect <= $countIndirect;
                });

                if (!$rank) {
                    Log::info('No matching rank found', ['parent_id' => $parentId]);
                    continue;
                }

                Log::info('Rank matched', [
                    'parent_id' => $parentId,
                    'rank_id' => $rank->id,
                    'rank_name' => $rank->name ?? null,
                ]);

                $parent = UserRank::firstOrCreate(['user_id' => $parentId]);
                $parent->update([
                    'rank' => $rank->id,
                    'count_direct_active' => $countDirect,
                    'count_undirect_active' => $countIndirect,
                    'count_direct_total' => Affiliate::where('parent_id', $parentId)
                        ->where('generation', 1)
                        ->count(),
                    'count_undirect_total' => Affiliate::where('parent_id', $parentId)
                        ->where('generation', '>', 1)
                        ->count(),
                ]);

                Log::info('UserRank updated', ['parent_id' => $parentId]);
            }

            Log::info('Transaction completed successfully');
        });

        Log::info('=== End: AffiliateAfterSubscribe::activeParent ===');
    }
}
