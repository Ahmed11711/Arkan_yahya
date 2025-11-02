<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtAdminMiddleware
{
    use ApiResponseTrait;
   public function handle(Request $request, Closure $next)
{
    try {
            $payload = JWTAuth::parseToken()->getPayload();
            $request->attributes->set('user', [
                'id' => $payload->get('sub'),
                'name' => $payload->get('name'),
                'email' => $payload->get('email'),
                'linkDeposit' => $payload->get('linkDeposit')
            ]);
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('Token expired');
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('Token invalid');
        } catch (JWTException $e) {
            return $this->errorResponse('Token not provided');
        }

        return $next($request);
}

}
