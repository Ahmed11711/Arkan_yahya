<?php

namespace App\Http\Controllers\Api\Withdraw;

use App\Models\Withdraw;
use App\Models\UserBalance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Withdraw\WithdrawStoreRequest;
use App\Repositories\Withdraw\WithdrawRepositoryInterface;

class WithdrawController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected WithdrawRepositoryInterface $withdrawRepository)
    {}

   public function store(WithdrawStoreRequest $request)
    {
        $user = $request->get('user');
        $amount = $request->input('amount');  
        $address = $request->input('address');  

        try {
            $withdraw = DB::transaction(function() use ($user, $amount, $address) {
                $myBalance = UserBalance::where('user_id', $user['id'])
                                        ->lockForUpdate()
                                        ->first();

                if (!$myBalance) {
                    throw new \Exception("User balance not found");
                }

                if ($myBalance->balance < $amount) {
                    throw new \Exception("Insufficient balance");
                }

                $myBalance->balance -= $amount;
                $myBalance->save();

                return $this->withdrawRepository->create([
                    'user_id' => $user['id'],
                    'transaction_id' => Str::uuid(),
                    'address' => $address,
                    'symbol' => 'USDT',
                    'amount' => $amount,
                    'status' => 'pending',
                ]);
            });

            return $this->successResponse($withdraw, "Withdraw request created successfully");

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

      public function withdraw(Request $request)
    {
         $user = $request->get('user'); 
         $withdraw=$this->withdrawRepository->getByUserId($user['id']);
         return $this->successResponse($withdraw, "All List Success");
         
    }

}
