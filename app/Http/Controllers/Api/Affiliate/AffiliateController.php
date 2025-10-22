<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateRequest;

class AffiliateController extends Controller
{
    public function index(AffiliateRequest $request)
    {
        $userId=$request->user_id;
        $user=User::select('id','coming_affiliate')->where('id',$userId)->first();
        return $this->createAffiliateRelations($userId,$user->coming_affiliate);
    }

    public function getByParent(Request $request)
    {
        $parentId=0;
        if($request->user_id)
        {
         $parentId=$request->user_id;
        }
       $user = $request->get('user'); 
       $parentId=$user['id'];

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
                'active' => true,
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
