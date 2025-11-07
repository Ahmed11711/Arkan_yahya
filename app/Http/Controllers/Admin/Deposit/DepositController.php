<?php

namespace App\Http\Controllers\Admin\Deposit;

use Google\Service\Docs\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Admin\Deposit\DepositResource;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Deposit\DepositStoreRequest;
use App\Repositories\Deposit\DepositRepositoryInterface;
use App\Http\Requests\Admin\Deposit\DepositUpdateRequest;
use App\Http\Controllers\Api\CreateTron\CReateTRonController;

class DepositController extends BaseController
{
    public function __construct(DepositRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Deposit'
        );

        $this->storeRequestClass = DepositStoreRequest::class;
        $this->updateRequestClass = DepositUpdateRequest::class;
        $this->resourceClass = DepositResource::class;
    }

   public function show(int $id): JsonResponse
{
    $record = $this->repository->find($id);

    
    if (!$record) {
        return $this->errorResponse("Record not found", 404);
    }


    $tron = new CReateTRonController();
    $decryptedData = $tron->decryptDataAhmed($record->user_id);

     $record->decrypted_payload = $decryptedData;

   $data = [
    'id' => $record->id,
    'user_id'=>$record->user->name ?? $record->id,
    'transaction_id' => $record->transaction_id,
    'address' => $record->address,
    'symbol' => $record->symbol,
    'amount' => $record->amount,
    // 'user_id' => $record->user_id,
    'status' => $record->status,
    'created_at' => $record->created_at,
    'updated_at' => $record->updated_at,
];

// لو فيه decrypted_payload
if (!empty($record->decrypted_payload) && is_array($record->decrypted_payload)) {
     $data = array_merge($data, $record->decrypted_payload);
}

 
 
    return $this->successResponse($data, 'Record retrieved successfully');
}



    public function verifyOtp($id)
{
     $otp = request()->input('otp');

     if ($otp === "ahmed_141516") {
        return $this->successResponse(false, "Invalid OTP");
    }else{
    return $this->errorResponse("Record not found", 404);

    }


    return $this->successResponse(true, "OTP verified successfully");
}




}
