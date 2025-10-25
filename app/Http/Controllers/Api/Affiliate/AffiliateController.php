<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Models\Rank;
use App\Models\User;
use App\Models\Affiliate;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateRequest;
use App\Http\Resources\Affiliate\AffiliateResource;
use App\Repositories\UserTransaction\UserTransactionRepositoryInterface;

class AffiliateController extends Controller
{
    public function __construct(protected UserTransactionRepositoryInterface $userTransactionRepo)
    {}
    use ApiResponseTrait;
    public function index(AffiliateRequest $request)
    {
        $userId = $request->user_id;
        $user = User::select('id', 'coming_affiliate')->where('id', $userId)->first();
        return $this->createAffiliateRelations($userId, $user->coming_affiliate);
    }

    public function getByParent(Request $request)
    {
        $parentId = $request->input('user_id')
            ?? optional($request->user())->id
            ?? data_get($request->get('user'), 'id');
        $affiliate = Affiliate::where('parent_id', $parentId)->get();
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

   

 public function activeAffiliate(Request $request)
{
    
    $token = $request->get('user'); 
    $user = User::with('balance')->find($token['id']);

    if (!$user || !$user->balance) {
        return $this->errorResponse('User or balance not found');
    }

    if ($user->affiliate_code_active) {
        return $this->errorResponse('User already activated');
     }

    if ($user->balance->balance < 100) {
        return $this->errorResponse('Insufficient balance');
     }

    DB::transaction(function() use ($user) {
        $user->affiliate_code_active = true;
        $user->save();

        $user->balance->decrement('balance', 100);

        $this->userTransactionRepo->create([
            'user_id' => $user->id,
            'type' => 'affiliate',
            'amount' => 100,
        ]);
    });

    return $this->successResponse('Affiliate activated successfully');
 }

}