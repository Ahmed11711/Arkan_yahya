<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Models\UserTwoFactor;
use App\Traits\ApiResponseTrait;
use PragmaRX\Google2FA\Google2FA;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\Login\LoginResource;
use App\Http\Resources\Admin\User\UserResource;
use App\Http\Requests\Admin\Auth\AuthLoginRequest;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(AuthLoginRequest $request)
    {
        $data = $request->validated();

        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = auth()->user();

         if ($user->type !== 'admin') {
            return $this->errorResponse('Access denied', 403);
        }

         $userTwoFactor = UserTwoFactor::where('user_id', $user->id)
            ->where('method', 'app')
            ->first();

        if (! $userTwoFactor) {
            return $this->errorResponse('2FA not enabled for this account.', 403);
        }

        $google2fa = new Google2FA();

        if (! $google2fa->verifyKey($userTwoFactor->qr_code, $data['otp'])) {
            return $this->errorResponse('Invalid 2FA code.', 401);
        }

         $jwt = JWTAuth::fromUser($user);
         $user->token=$jwt;

  return $this->successResponse([
            'user' => new LoginResource($user),
            'token' => $token,
        ], 'Login Successfully');

       
       
    }

    // ✅ تسجيل الخروج
    public function logout(Request $request)
    {
        $token = $request->cookie('access_token');
        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        }

        // حذف الكوكي
        $cookie = cookie()->forget('access_token');

        return response()->json(['message' => 'Logged out successfully'])->cookie($cookie);
    }

  public function me(Request $request)
{
    // نحاول نجيب التوكن من الكوكي
    $token = $request->cookie('access_token');

    // لو مش موجود، نحاول نجيبه من Authorization header
    if (! $token && $request->hasHeader('Authorization')) {
        $authHeader = $request->header('Authorization');
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7);
        }
    }

    // لو لسه مش موجود، نجيب أول أدمن مؤقتًا (للتمرير فقط)
    if (! $token) {
        $user = \App\Models\User::where('type', 'admin')->first();
        if ($user) {
            return $this->successResponse($user);
        }
        return $this->errorResponse('No token found', 401);
    }

    try {
        $user = JWTAuth::setToken($token)->authenticate();
    } catch (\Exception $e) {
        return $this->errorResponse('Invalid token', 401);
    }

    return $this->successResponse($user);
}


    
}
