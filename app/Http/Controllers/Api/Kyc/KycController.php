<?php

namespace App\Http\Controllers\Api\Kyc;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kyc\KycRequest;
use App\Http\Resources\Admin\UserKyc\UserKycResource;
use App\Models\User;
use App\Repositories\Kyc\KycRepositoryInterface;
use App\Traits\UploadFileTrait;

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
        if ($existingKyc) {
            return $this->errorResponse('KYC record already exists. Please wait for review.', 409);
        }
        $frontPath = $this->uploadFile($request->file('front_id'), 'Kyc');
        $backPath  = $this->uploadFile($request->file('back_id'), 'Kyc');
        $facePath  = $this->uploadFile($request->file('face'), 'Kyc');

        $data = [
            'user_id' => $data['user_id'],
            'front_id' => $frontPath,
            'back_id' => $backPath,
            'face' => $facePath
        ];
        $this->kycRepo->create($data);
        $user = User::find($data['user_id']);
        if ($user) {
            $user->verified_kyc = true;
            $user->save();
        }


        return $this->successResponse([], 'KYC uploaded successfully. Pending admin review.');
    }
}
