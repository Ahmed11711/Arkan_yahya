<?php

namespace App\Http\Controllers\Api\UserPlan;

use Illuminate\Http\Request;
use App\Models\UserBalance;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Http\Resources\Admin\UserPlan\UserPlanResource;
use App\Repositories\UserPlan\UserPlanRepositoryInterface;
use App\Http\Requests\Admin\UserPlan\UserPlanWebStoreRequest;

class UserPlanController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected UserPlanRepositoryInterface $userPlanRepository,
        protected WalletRepositoryInterface $walletRepository,
    ) {}

    public function index(Request $request)
    {
        $user = $request->get('user');
         $plans = $this->userPlanRepository->getByUserIdWithRelations($user['id'],'wallet');
        return $this->successResponse(UserPlanResource::collection($plans), "All List Success");
    }

    public function store(UserPlanWebStoreRequest $request)
    {
        $data = $request->validated();
        $user = $request->get('user');

        $wallet = $this->walletRepository->find($data['wallet_id']);
        if (!$wallet || $wallet->status !== 'active') {
            return $this->errorResponse('This plan is not available', 400);
        }

        $userBalance = UserBalance::where('user_id', $user['id'])->lockForUpdate()->first();
        if (!$userBalance) {
            return $this->errorResponse('User balance not found', 404);
        }

        if ($userBalance->balance < $wallet->amount) {
            return $this->errorResponse('Insufficient wallet balance', 400);
        }

        try {
            $userPlan = DB::transaction(function () use ($user, $wallet, $userBalance) {

                $userBalance->decrement('balance', $wallet->amount);

                $plan = $this->userPlanRepository->create([
                    'user_id'        => $user['id'],
                    'wallet_id'      => $wallet->id,
                    'price'          => $wallet->amount,
                    'status'         => 'active',
                    'transaction_id' => uniqid('txn_'),
                    'start_date'     => now(),
                    'end_date'       => now()->addMonths($wallet->duration_months ?? 1),
                    // 'count_unite'  => $data['count_unite'] ?? null,
                ]);

                return $plan;
            });

            return $this->successResponse($userPlan, 'Plan subscribed successfully');
        } catch (\Throwable $e) {
            Log::error('Plan subscription failed', [
                'user_id' => $user['id'],
                'error'   => $e->getMessage(),
            ]);

            return $this->errorResponse('Something went wrong', 500);
        }
    }
}
