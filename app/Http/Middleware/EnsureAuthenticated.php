<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->cookie('auth:token')) {
            $cookie_value = base64_decode($request->cookie('auth:token'));
            
            try {
                $payload = JWT::decode(json_decode($cookie_value)->jwt, env('JWT_SECRET'), array('HS256'));
    
                // print_r(gettype($is_admin));
                // return;
                // print_r($payload);
                $request->merge(['currentuser' => $payload]);

            } catch (\Throwable $th) {
                //throw $th;
                return response()->json([
                    "status" => 401,
                    "message" => "Bad Token",
                    "more" => $th->getMessage()
                ], 401);
            }
        } else {
            // $request->merge(['currentuser' => NULL]);
            return response()->json([
                "status" => 401,
                "message" => "Resource Requires Authentication"
            ], 401);
        }
        
        return $next($request);
    }
}
