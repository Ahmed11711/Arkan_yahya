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
        $code = $data['otp_code'] ?? null;

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = auth()->user();

        // تحقق أن المستخدم Admin فعلاً
        if ($user->type !== 'admin') {
            return $this->errorResponse('Access denied.', 403);
        }

        // تحقق من كود 2FA
        $userTwoFactor = UserTwoFactor::where('user_id', $user->id)
            ->where('method', 'app')
            ->first();

        if (! $userTwoFactor) {
            return $this->errorResponse('2FA not set up for this user', 400);
        }

        $google2fa = new Google2FA();
        $isValid = $google2fa->verifyKey($userTwoFactor->qr_code, $code);

        if (! $isValid) {
            return $this->errorResponse('Invalid 2FA code', 403);
        }

        // إنشاء الكوكي
        $cookie = cookie(
            'jwt_token',    // اسم الكوكي
            $token,         // القيمة
            60 * 24,        // المدة بالدقائق (يوم كامل)
            '/',            // المسار
            null,           // الدومين (اتركه null لو نفس الدومين)
            true,           // Secure: فقط HTTPS
            true,           // HttpOnly: لا يمكن الوصول له من JS
            false,          // Raw
            'Strict'        // SameSite
        );

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->only(['id', 'name', 'email'])
        ])->cookie($cookie);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            // تجاهل أي خطأ
        }

        return response()
            ->json(['message' => 'Logged out'])
            ->cookie('jwt_token', '', -1); // حذف الكوكي
    }

    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return $this->successResponse(['user' => $user]);
        } catch (\Exception $e) {
            return $this->errorResponse('Unauthenticated', 401);
        }
    }
}
