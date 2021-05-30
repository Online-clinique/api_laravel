<?php

namespace App\Http\Middleware;

use Closure;

class EnsureAdmin
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
        if (isset($request['currentuser']->admin) && $request['currentuser']->admin) {
            # code...
            return $next($request);
        }

        return response()->json(
            [
                "status" => 401,
                "message" => "Not Authorized"
            ],
            401
        );
    }
}
