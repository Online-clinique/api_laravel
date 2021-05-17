<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Medic;
use \Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return response()->json(Admin::all());

        return response()->json(Admin::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Admin::where('username', $request->all()['username'])->exists()) {
            return response()->json([
                'status' => 401,
                "message" => "User is already an Admin"
            ], 401);
        }
        return Admin::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Admin::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function self(Request $request)
    {
        return response()->json($request['currentuser']);
    }

    public function SignAdmin(Request $request)
    {
        try {
            $data = $request->only('username', 'password');
            $request->validate([
                'username' => 'required|email',
                "password" => 'required'
            ]);

            if (!Admin::where('username', $data['username'])->exists()) {
                # code...
                return response()->json([
                    "status" => 401,
                    "message" => "Bad credentials"
                ], 401);
            }

            $target_password = $data['password'];
            $resource_admin = Admin::where('username', $data['username'])->get()->first();

            $same = Hash::check($target_password, $resource_admin['password']);


            // $same_password = Hash::check($data['password'], );

            // echo gettype($resource_admin);
            // return;


            if (boolval($same) === TRUE) {
                $now_seconds = time();
                $exp_seconds = $now_seconds + (60 * 60);
                $resource_admin->iat = $now_seconds;
                $resource_admin->exp = $exp_seconds;
                return response()->json([
                    'status' => 200,
                    "message" => "you are now signed in"
                ])->cookie(
                    "auth:token",
                    base64_encode(json_encode([
                        'jwt' => JWT::encode($resource_admin, env('JWT_SECRET'))
                    ])),
                    NULL,
                    "/",
                    null,
                    false,
                    true
                );
            } else {
                return response()->json([
                    'status' => 401,
                    "message" => "Are you trying to hack me"
                ],  401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                "message" => "Something happened"
            ],  500);
        }
    }

    public function docs(Request $request)
    {
        $docs = Admin::find($request['currentuser']->id)->docs;

        return response()->json(
            [
                'doctors' => $docs
            ]
        );
    }

    public function signout()
    {
        $cookie = Cookie::forget('auth:token');
        return redirect("http://localhost:5500/dash/admin")->withCookie($cookie);
    }
}
