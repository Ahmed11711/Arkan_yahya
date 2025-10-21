<?php

namespace App\Http\Controllers\Api\Deposit;

use App\Models\Deposit;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Admin\Deposit\DepositResource;
use App\Repositories\Deposit\DepositRepositoryInterface;

class DepositController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected DepositRepositoryInterface $depositRepository)
    {}


    public function deposit(Request $request)
    {
         $user = $request->get('user'); 
         $deposits=$this->depositRepository->getByUserId($user['id']);
         return $this->successResponse($deposits, "All List Success");
         
    }
    public function checkDeposit(Request $request)
    {
        $user = $request->get('user');
        $address = $user['linkDeposit'] ?? null;
        if (!$address) {
            return response()->json(['message' => 'User wallet not found.'], 400);
        }
        $response = Http::get("https://api.trongrid.io/v1/accounts/{$address}/transactions/trc20", [
            'limit' => 10,
        ]);

        $transactions = $response->json()['data'] ?? [];
        $newDeposits = [];
        $totalNewAmount = 0;

        $existingTxIds = Deposit::where('user_id', $user['id'])
            ->pluck('transaction_id')
            ->toArray();

        foreach ($transactions as $tx) {
            $transactionId = $tx['transaction_id'] ?? null;
            if (!$transactionId) continue;

            if (in_array($transactionId, $existingTxIds)) continue;

            if (($tx['to'] ?? null) === $address && ($tx['token_info']['symbol'] ?? null) === 'USDT') {
                $amount = ($tx['value'] ?? 0) / 1_000_000; // تحويل من Sun لـ USDT
                $deposit = Deposit::create([
                    'user_id' => $user['id'],
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                    'address' => $address,
                    'symbol' => $tx['token_info']['symbol'] ?? null,
                ]);
                $newDeposits[] = $deposit;
                $totalNewAmount += $amount;
            }
        }


        if ($totalNewAmount > 0) {
            $userBalance = UserBalance::firstOrCreate(
                ['user_id' => $user['id']],
                ['balance' => 0]
            );
            $userBalance->balance += $totalNewAmount;
            $userBalance->save();
        }
        if (count($newDeposits) > 0) {
            return $this->successResponse([
                'total_new_amount' => $totalNewAmount,
            ], 'Success');
        } else {
            return $this->successResponse([
                'total_new_amount' => 0,
            ], 'Error');
        }
    }
}
