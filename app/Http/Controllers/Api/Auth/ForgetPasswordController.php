<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RestPasswordRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Auth\SendRestPasswordRequest;

class ForgetPasswordController extends Controller
{
    use ApiResponseTrait;
     public function __construct(public UserRepositoryInterface $userRepository) {}

    public function sendResetLink(SendRestPasswordRequest $request)
    {
        $data=$request->validated();
        $user=$this->userRepository->findByKey($data['method'],$data['value']);
       if(!$user)
       {
        return $this->errorResponse("The User Not Found");
       }
        
        $token = Str::random(64);
        $email=$user->email;
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $frontendUrl = config('app.frontend_url', 'https://frontend.example.com');
        $link = "{$frontendUrl}/reset-password?token={$token}&email={$email}";
        return $this->successResponse($link,"Password reset link sent successfully");
    }
     public function reset(RestPasswordRequest $request)
    {
        $data=$request->validated();
        $email=$data['email'];
        $token=$data['token'];
        $password=$data['password'];

        $reset = DB::table('password_resets')->where('email', $email)->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid email or token'], 400);
        }

        if (!Hash::check($token, $reset->token)) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        if (now()->diffInMinutes($reset->created_at) > 15) {
            DB::table('password_resets')->where('email', $email)->delete();
            return response()->json(['message' => 'Token expired'], 400);
        }
        $user = User::where('email', $email)->first();
        $user->update(['password' => Hash::make($password)]);
        DB::table('password_resets')->where('email', $email)->delete();
        return response()->json(['message' => 'Password reset successfully']);
    }
}
