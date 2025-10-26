<?php

namespace App\Services\SendOtp;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


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
 
      $url = 'https://api.sendgrid.com/v3/mail/send';

    $data = [
        "personalizations" => [
            [
                "to" => [
                    ["email" => $email]
                ],
                "subject" => "Your OTP Code"
            ]
        ],
        "from" => [
            "email" => "info@zayamrock.com",
            "name" => "zayamrock"
        ],
      "content" => [
    [
        "type" => "text/html",
        "value" => '
        <div style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 40px; text-align: center;">
            <div style="background: #ffffff; max-width: 500px; margin: auto; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 30px;">
                <h2 style="color: #1e293b; margin-bottom: 20px;">🔐 Email Verification</h2>
                <p style="color: #475569; font-size: 16px; line-height: 1.6;">
                    Hello,<br>
                    Use the verification code below to complete your sign-in process.
                </p>
                <div style="background-color: #f1f5f9; display: inline-block; padding: 12px 24px; border-radius: 8px; margin: 20px 0;">
                    <span style="font-size: 28px; letter-spacing: 3px; color: #0f172a; font-weight: bold;">' . htmlspecialchars($otp) . '</span>
                </div>
                <p style="color: #64748b; font-size: 14px;">
                    This code will expire in <strong>10 minutes</strong>. If you didn’t request this, please ignore this email.
                </p>
                <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
                <p style="color: #94a3b8; font-size: 12px;">
                    &copy; ' . date('Y') . ' Your Company Name. All rights reserved.
                </p>
            </div>
        </div>'
    ]
],

    ];

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . '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',
        'Content-Type' => 'application/json'
    ])->post($url, $data);

    Log::info('SendGrid Response: '.$response->body());
    if ($response->failed()) {
        // Log or handle error
        Log::error('SendGrid Error: '.$response->body());
        return false;
    }

    return true;
    }

   

 
}