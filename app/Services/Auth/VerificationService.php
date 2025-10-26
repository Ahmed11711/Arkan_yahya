<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\UserTwoFactor\UserTwoFactorRepositoryInterface;
use App\Services\SendOtp\SendOtpService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\In;
use PragmaRX\Google2FA\Google2FA;


class VerificationService
{
    protected int $otpLength = 6;
    protected int $otpExpiry = 5;

    public function __construct(
        protected UserTwoFactorRepositoryInterface $userTwoFactor,
        public SendOtpService $sendOtpService,
    ) {}

    public function sendOtp(string $method,$type, $recipient,Int $userId)
    {
        $otp = $this->generateOtp();        
         $this->sendOtpToMethod($recipient,$otp,$method);
        $store = $this->storeInDb($method,$type, $otp, $userId);
        return $store;
    }


    protected function generateOtp(): int
    {
        return rand(100000, 999999); // 6-digit OTP
    }

    protected function sendOtpToMethod(string $recipient, int $otp, string $method = 'email')
    {
          switch ($method) {
            case 'sms':
                $this->sendOtpService->sendSms($recipient, $otp);
                break;

            case 'email':
                 $this->sendOtpService->sendEmail($recipient, $otp);
                break;

            case 'app':
                break;

            default:
                throw new \InvalidArgumentException("Invalid OTP sending method: {$method}");
        }
    }

    public function storeInDb($method, $type,$otp, $userId)
    {

        $qr_code = null;

        if ($method === 'app') {
            $google2fa = new Google2FA();
            $qr_code = $google2fa->generateSecretKey();
        }
        $data = [
            'method' => $method,
            'user_id' => $userId,
            'type' => $type,
            'code' => $otp,
            'qr_code' => $qr_code ?? null,
            'expires_at' => now()->addMinutes(5),

        ];

        $this->userTwoFactor->createOrUpdate($data);
        if($method === 'app')
        {
            return $qr_code;
        }
        return $otp;
    }

   public function verifyCode(string $method, int $userId, string $code): bool
   {
     $otpRecord = $this->userTwoFactor->findByConditions([
        'user_id' => $userId,
        'method'  => $method,
        'type'    => 'register'
    ]);

    if (!$otpRecord) {
        return false; 
    }

     if ($otpRecord->expires_at && now()->greaterThan($otpRecord->expires_at)) {
        return false; 
    }

    if ($method === 'app') {
         $google2fa = new \PragmaRX\Google2FA\Google2FA();
        return $google2fa->verifyKey($otpRecord->qr_code, $code);
    }
        $otpRecord->active=1;
        $otpRecord->save();
        $user = $otpRecord->user;
        $user->email_verified_at = now();
        $user->save();


     return $otpRecord->code === $code;
}

}
