<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    use ApiResponseTrait;
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('Token expired');
         } catch (TokenInvalidException $e) {
            return $this->errorResponse('Token invalid');
        } catch (JWTException $e) {
            return $this->errorResponse('Token not provided');

         }

         $request->attributes->set('user', $user);

        return $next($request);
    }
}
