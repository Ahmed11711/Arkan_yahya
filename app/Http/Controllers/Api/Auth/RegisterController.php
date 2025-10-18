<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Str;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Services\Auth\RegisterService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Login\LoginResource;
use Illuminate\Support\Facades\RateLimiter;

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

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
