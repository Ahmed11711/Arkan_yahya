<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AuthLoginRequest;
use App\Models\UserTwoFactor;
use PragmaRX\Google2FA\Google2FA;

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

        // ✅ السماح فقط للأدمن
        if ($user->type !== 'admin') {
            return $this->errorResponse('Access denied', 403);
        }

        // ✅ تحقق من كود 2FA
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

        // ✅ توليد JWT
        $jwt = JWTAuth::fromUser($user);

        // ✅ تخزين التوكن في كوكي آمن (HTTP-only)
        $cookie = cookie(
            'access_token',
            $jwt,
            JWTAuth::factory()->getTTL() * 60,
            '/',       // المسار
            null,      // الدومين (افتراضي)
            true,      // Secure: فقط عبر HTTPS
            true       // HttpOnly: لا يمكن قراءته من JavaScript
        );

        // ✅ استجابة النجاح
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ])->cookie($cookie);
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

    // ✅ اختبار المستخدم المسجل (للتحقق من الجلسة)
    public function me(Request $request)
    {
        $token = $request->cookie('access_token');

        if (! $token) {
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
