<?php

namespace App\Http\Middleware;

use Closure;

class ensuredoctor
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
        // return response()->json($request['currentuser']);
        if (isset($request['currentuser']->added_by)) {
            return $next($request);
            # code...
        }

        return response()->json([
            'status' => 401,
            'message' => 'not authorized'
        ]);
    }
}
