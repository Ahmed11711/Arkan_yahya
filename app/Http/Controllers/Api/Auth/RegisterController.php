<?php

namespace App\Http\Controllers\Api\Auth;

use Google_Client;
use App\Models\User;
use App\Models\userTron;
use Illuminate\Support\Str;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Client\Request;
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
        return $this->successResponse($service, 'User registered successfully.');
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

    public function me(Request $request)
    {
        $token = $request->get('user'); 
        $user=User::find($token['id']);

        return $this->successResponse(new LoginResource($user), 'User retrieved successfully.');
    }   
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

 

    public function googleLogin(LoginByGoogleRequest $request)
{
    $data = $request->validated();
    $idTokens = $data['id_token'];
     $idToken = $idTokens['credential'];
    
    $client = new Google_Client([
        'client_id' => '205900460791-h21g4s9m289i97ce8g9ctvuhj2skcf79.apps.googleusercontent.com'
    ]);

    $payload = $client->verifyIdToken($idToken);

    if (!$payload) {
        return $this->errorResponse('Invalid Google token', 401);
    }

    $googleId = $payload['sub'];
    $email    = $payload['email'];
    $name     = $payload['name'] ?? $payload['given_name'];
    $avatar   = $payload['picture'] ?? null;

     $user = User::firstOrCreate(
        ['google_id' => $googleId],
        [
            'name' => $name,
            'email' => $email,
            // 'avatar' => $avatar,
            'password' => bcrypt(Str::random(16)), 
        ]
    );

     if (isset($user->active) && !$user->active) {
        return $this->errorResponse('Your account is deactivated. Contact support.', 403);
    }

     $token = JWTAuth::fromUser($user);

    return $this->successResponse([
        'user' => new LoginResource($user),
        'token' => $token,
    ], 'Login Successfully');
}


}
