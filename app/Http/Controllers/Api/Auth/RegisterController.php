<?php

namespace App\Http\Controllers\Api\Auth;

use Google_Client;
use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Auth\RegisterService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Login\LoginResource;
use App\Http\Requests\Auth\LoginByGoogleRequest;

 class RegisterController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected RegisterService $modelService) {}

    public function createUser(RegisterRequest $request)
    {
        $data = $request->validated();
        $commingAffiliate = $request->input('coming_affiliate');
        $service = $this->modelService->createUser($data, $commingAffiliate);
        // $response = Http::get('http://localhost:3000/tron/create-wallet');
        // $walletData = $response->json();
        // Log::info("dd", [$walletData]);
        // $password = "ahmed";
        // $this->encryptData($walletData, $service->id, $password);

        // return $this->get($service['id']);
        return $this->successResponse($service, 'User registered successfully.');
    }

    public function get($userId)
    {
        return $this->decryptData($userId,'ahmed');
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = auth()->user();

        if (! $user->active) {
            return $this->errorResponse('Your account is deactivated. Contact support.', 403);
        }

        return $this->successResponse([
            'user' => new LoginResource($user),
            'token' => $token,
        ], 'Login Successfully');
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    private function encryptData(array $walletData, int $userId, string $password)
    {
        $plaintext = json_encode($walletData);

        // توليد الملح والـ nonce والمفتاح
        $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
        $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($plaintext, '', $nonce, $key);
        sodium_memzero($key);

        $encrypted = [
            'ciphertext' => base64_encode($ciphertext),
            'salt' => base64_encode($salt),
            'nonce' => base64_encode($nonce)
        ];

        // تخزين البيانات في جدول user_trons
        DB::table('user_trons')->insert([
            'user_id' => $userId,
            'address' => $walletData['address'] ?? null,
            'encrypted_payload' => json_encode($encrypted),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    private function decryptData(int $userId, string $password): ?array
    {
        $record = DB::table('user_trons')->where('user_id', $userId)->first();

        if (!$record || !$record->encrypted_payload) {
            return null; // لا يوجد بيانات
        }

        $encrypted = json_decode($record->encrypted_payload, true);

        // فك التشفير
        $salt = base64_decode($encrypted['salt']);
        $nonce = base64_decode($encrypted['nonce']);
        $ciphertext = base64_decode($encrypted['ciphertext']);

        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $plaintext = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, '', $nonce, $key);
        sodium_memzero($key);

        if ($plaintext === false) {
            return null; // كلمة السر خطأ أو البيانات تالفة
        }

        return json_decode($plaintext, true);
    }

     public function googleLogin(LoginByGoogleRequest $request)
    {
        $data=$request->validated();

        $idToken = $data['id_token'];
        $client = new Google_Client(['client_id' => '205900460791-h21g4s9m289i97ce8g9ctvuhj2skcf79.apps.googleusercontent.com']);
        $payload = $client->verifyIdToken($idToken);

        if (!$payload) {
            return response()->json(['error' => 'Invalid Google token'], 401);
        }

        return $payload;
        $googleId = $payload['sub'];
        $email    = $payload['email'];
        $name     = $payload['name'] ?? $payload['given_name'];
        $avatar   = $payload['picture'] ?? null;

         $user = User::firstOrCreate(
            ['google_id' => $googleId],
            [
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
                'password' => bcrypt(Str::random(16)), // كلمة مرور افتراضية
            ]
        );

        // ممكن تستخدم Laravel Sanctum أو Passport لإعطاء توكن داخلي
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

}
