<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Models\Rank;
use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateRequest;
use App\Http\Resources\Affiliate\AffiliateResource;

class AffiliateController extends Controller
{
    use ApiResponseTrait;
    public function index(AffiliateRequest $request)
    {
        $userId=$request->user_id;
        $user=User::select('id','coming_affiliate')->where('id',$userId)->first();
        return $this->createAffiliateRelations($userId,$user->coming_affiliate);
    }

    public function getByParent(Request $request)
    {
        $parentId = $request->input('user_id')
        ?? optional($request->user())->id
        ?? data_get($request->get('user'), 'id');
         $affiliate=Affiliate::where('parent_id',$parentId)->get();
        return $this->successResponse(AffiliateResource::collection($affiliate));

 
    }


    public function createAffiliateRelations($userId, $comingAffiliate)
    {
        $generation = 1;
        $maxGenerations = 5;
        $currentAffiliate = $comingAffiliate;

        $relations = [];

        while ($generation <= $maxGenerations && $currentAffiliate) {
            $parent = User::select('id', 'coming_affiliate')
                ->where('affiliate_code', $currentAffiliate)
                ->first();

            if (!$parent) {
                break;
            }

            $relations[] = [
                'user_id' => $userId,
                'parent_id' => $parent->id,
                'generation' => $generation,
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $currentAffiliate = $parent->coming_affiliate;
            $generation++;
        }

        if (!empty($relations)) {
            Affiliate::insert($relations);
        }
    }

    public function updateParentRanks($userId)
{
     $parents = Affiliate::where('user_id', $userId)->pluck('parent_id');

    foreach ($parents as $parentId) {
        // احسب عدد المباشرين
        $countDirect = Affiliate::where('parent_id', $parentId)
            ->where('generation', 1)
            ->count();

        // احسب عدد غير المباشرين
        $countIndirect = Affiliate::where('parent_id', $parentId)
            ->where('generation', '>', 1)
            ->count();

        // هات الرتبة المناسبة
        $rank = Rank::where('count_direct', '<=', $countDirect)
            ->where('count_undirect', '<=', $countIndirect)
            ->orderByDesc('count_direct')
            ->first();

        if ($rank) {
            $parent = User::find($parentId);
            if ($parent->rank_id != $rank->id) {
                $parent->rank_id = $rank->id;
                $parent->save();
            }
        }
    }
}

}
