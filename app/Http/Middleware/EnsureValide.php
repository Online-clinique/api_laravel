<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;

class EnsureValide
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
        $data = $request->only('id_admin', 'id_medic');
        $raw_cookie = $request->cookie('validate');
        $cookie_payload = $this->decodeJWTBase64($raw_cookie);
        // return;

        // return response()->json($cookie_payload);
        if ($cookie_payload) {
            if (($data['id_admin'] !== $cookie_payload['id_admin']) || ($data['id_medic'] !== $cookie_payload['id_medic'])) {
                return response()->json([
                    "status" => 401,
                    "message" => "Not authorized"
                ], 401);
            }
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Not authorized"
            ], 401);
        }
        return $next($request);
    }


    public function decodeJWTBase64($raw)
    {
        if (!$raw) {
            return null;
        }
        try {
            $value_base64 = base64_decode($raw);
            return (array) JWT::decode(json_decode($value_base64)->jwt, env('JWT_SECRET'), array('HS256'));
        } catch (\Throwable $th) {
            return null;
        }
    }
}
