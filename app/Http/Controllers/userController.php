<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['user', 'gentoken']]);
    }

    public function user() {
        return response()->json([
            "message" => bcrypt("mohamed")
        ]);
    }

    public function gentoken() {
        $response = auth()->attempt(['name' => 'Mohamed', 'password' => "mohamed"]);
        if ($response) {
            # code...
            return response()->json([
                "status" => 200,
                "token" => $response
            ]);
        }
        return response()->json([
            "status" => "422"
        ], 422);
        
        // var_dump($response);
    }
}
