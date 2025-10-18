<?php
namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\View;
use GuzzleHttp\Exception\ClientException;

trait SendEmail
{

    public function generateOTP()
    {
      return  $otp = rand(1000, 9999);
        return 1234;
    }



    public function sendEmail($to,$message)
    {


        try {
            $client = new Client();

            $htmlContent = View::make('otpmail', ['otpData' => $message])->render();

            $response = $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => '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',
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'TSmart.com',
                        'email' => 'hanyamir767@gmail.com'
                    ],
                    'to' => [
                        [
                            'email' => $to,
                            'name' => 'Recipient'
                        ]
                    ],
                    'subject' => "TSmart",
                    "htmlContent" => $htmlContent,
                ],
            ]);

            return $response->getBody();
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = $e->getResponse()->getBody()->getContents();
            return "Client Error $statusCode: $errorMessage";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function sendEmailToAdmin($formData, $images,$user)
    {
        // dd($formData);
        $to = 'tahounsmart60@gmail.com';

        try {
            $client = new Client();

            $htmlContent = View::make('sendForm', [
                'formData' => $formData,
                'images' => $images,
                'user' => $user
            ])->render();

            $response = $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => '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',
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'tsmartapp.com',
                        'email' => 'hanyamir767@gmail.com'
                    ],
                    'to' => [
                        [
                            'email' => $to,
                            'name' => 'Security Admin'
                        ]
                    ],
                    'subject' => "New Form Submission",
                    "htmlContent" => $htmlContent,
                ],
            ]);

            return $response->getBody();
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }
    }


    public function autoReplay($to,$message)
    {


        try {
            $client = new Client();

            $htmlContent = View::make('autoReplay',
            [
                'message' => $message,
                'email'=>$to,

            ])->render();

            $response = $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => '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',
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'TSmart.com',
                        'email' => 'hanyamir767@gmail.com'
                    ],
                    'to' => [
                        [
                            'email' => $to,
                            'name' => 'Recipient'
                        ]
                    ],
                    'subject' => "TSmart",
                    "htmlContent" => $htmlContent,
                ],
            ]);

            return $response->getBody();
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = $e->getResponse()->getBody()->getContents();
            return "Client Error $statusCode: $errorMessage";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }


}
