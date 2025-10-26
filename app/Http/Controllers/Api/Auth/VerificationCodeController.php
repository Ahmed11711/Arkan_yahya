<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\VerifyRequest;
use App\Services\Auth\VerificationService;
use App\Http\Requests\Auth\VerificationRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Auth\SendRestPasswordRequest;

class VerificationCodeController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected VerificationService $verificationService,
    public UserRepositoryInterface $userRepository
    ) {}

    public function sendOtp(VerificationRequest $request)
    {
        
        $data = $request->validated();
        $user=$this->userRepository->find($data['user_id']);
        if($data['method']=='email')
        {
            $recipient=$user['email'];
        }if($data['method']=='sms')
        {
            $recipient=$user['phone'];
        }if($data['method']=='app')
        {
            $recipient=1;
        }

        $sendOtp = $this->verificationService->sendOtp($data['method'],'register',$recipient, $data['user_id']);
        return $this->successResponse($sendOtp, 'OTP sent successfully.');
    }


    public function verifyOtp(VerifyRequest $request)
    {
        $data = $request->validated();
        $userId = $data['user_id'];
        $method = $data['method'];
        $code   = $data['code'];

        $verified = $this->verificationService->verifyCode($method, $userId, $code);

        if (!$verified) {
            return $this->errorResponse('Invalid or expired code.', 422);
        }

        return $this->successResponse(message: "Verification successful.");
    }

    public function SendOtpForRestPassword(SendRestPasswordRequest $request)
    {
         $status = Password::sendResetLink(
            $request->only('email')
        );
       $data = $request->validated();

       $user=$this->userRepository->findByKey($data['method'],$data['value']);
       if(!$user)
       {
        return $this->errorResponse("The User Not Found");
       }
       $sendOtp = $this->verificationService->sendOtp($data['method'],'restPassword', $user['id']);
       return $this->successResponse($sendOtp, 'OTP sent successfully.');
 

    }

    public function restPassword()
    {

    }
}
