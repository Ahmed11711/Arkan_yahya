<?php

namespace App\Http\Controllers\Api\Kyc;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UploadFileTrait;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kyc\KycRequest;
use App\Repositories\Kyc\KycRepositoryInterface;
use App\Http\Resources\Admin\UserKyc\UserKycResource;

class KycController extends Controller
{
    use ApiResponseTrait, UploadFileTrait;
    public function __construct(protected KycRepositoryInterface $kycRepo) {}

    public function index(Request $request)
    {
        $user = $request->get('user');
        $get = $this->kycRepo->getByUserId($user['id']);
        return $this->successResponse(UserKycResource::collection($get), "return successful");
    }
  public function upload(KycRequest $request)
{
    $data = $request->validated();

    $existingKyc = $this->kycRepo->findBYKey('user_id', $data['user_id']);
    if ($existingKyc) { return $this->errorResponse('KYC record already exists. Please wait for review.', 409); }
   

    DB::beginTransaction();
    try {
        $paths = [];
        foreach (['front_id', 'back_id', 'face'] as $field) {
            if ($request->hasFile($field)) {
                $paths[$field] = $this->uploadFile($request->file($field), 'Kyc');
            } else {
                throw new \Exception("Missing file: $field");
            }
        }

        $data = array_merge($data, $paths);
        $this->kycRepo->create($data);

        $user = User::find($data['user_id']);
        if ($user) {
            $user->verified_kyc = true;
            $user->save();
        }

        DB::commit();
        return $this->successResponse([], 'KYC uploaded successfully. Pending admin review.');

    } catch (\Throwable $th) {
        DB::rollBack();
        Log::error('KYC Upload Error', ['error' => $th->getMessage()]);
        return $this->errorResponse('Failed to upload KYC. Please try again.', 500);
    }

}
}
