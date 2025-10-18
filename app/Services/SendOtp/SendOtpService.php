<?php

namespace App\Services\SendOtp;


class SendOtpService
{
    public string $sendGridApiKey;

    public function __construct()
    {
        $this->sendGridApiKey = '44';
    }
    public function sendSms(string $phone, int $otp)
    {
        return $otp;
    }
    public function sendEmail(string $email, int $otp)
    {
      return $otp;
    }

   

 
}