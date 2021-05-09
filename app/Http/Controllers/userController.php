<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Medic;

class userController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['user', 'gentoken', 'decodeJwt']]);
    }

    public function user() {
        return response()->json([
            "message" => bcrypt("mohamed")
        ]);
    }

    public function decodeJwt(Request $request) {
        $token = $request->all()['token'];

        $cookie = base64_decode($request->cookie('auth:token'));

        // print_r($token);

        $decoded = JWT::decode($token, env('JWT_SECRET'), array('HS256'));
        
        return response()->json([
            "payload" => $decoded
            ]);
        }
        
    public function gentoken(Request $req) {
            
        $token = env('ADMIN_JWT');
        $payload = (array) JWT::decode($token, env('JWT_SECRET'), array('HS256'));
        $email_exits = Medic::where('email', $req->all()['username']);

        print_r($email_exits->count());

        if ($payload['admin']) {

            $destination_url = $req->all()['username'];



            return response()->json($destination_url);
            
        }

        // $jwt = JWT::encode($payload,  env('JWT_SECRET'));

        // $response = auth()->attempt(['name' => 'Mohamed', 'password' => "mohamed"]);
        
        // var_dump($response);
    }
}
