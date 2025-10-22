<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateRequest;
use App\Http\Resources\Affiliate\AffiliateResource;
use App\Traits\ApiResponseTrait;

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
}
