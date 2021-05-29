<?php

namespace App\Http\Middleware;

use \Firebase\JWT\JWT;

use Closure;

class CurrentUser
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
                $request->merge(['currentuser' => null]);
            }
        } else {
            $request->merge(['currentuser' => null]);
        }
        return $next($request);
    }
}
