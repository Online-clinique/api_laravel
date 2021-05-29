<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Appointement;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "email" => 'email|required',
            "password" => 'string|required|min:6',
            "password_confirm" => 'string|required',
            "CIN" => 'string|required',
            "phone" => 'string|required',
        ]);

        if (User::where('email', $request->all()['email'])->exists()) {
            return response()->json([
                "status" => 400,
                "message" => "User already exists"
            ], 400);
        }

        if (
            $request->only(['password', 'password_confirm'])['password']
            !== $request->only(['password', 'password_confirm'])['password_confirm']
        ) {
            return response()->json([
                "status" => 401,
                "message" => "Passwords do not match"
            ], 401);
        }

        return response()->json(
            [
                'status' => 200,
                'user' => User::create(
                    array_merge(
                        $request->all(),
                        [
                            'full_name' => $request->all()['first_name'] . " " . $request->all()['last_name']
                        ]
                    )
                )
            ]
        );
    }

    public function Login(Request $request)
    {
        $request->validate([
            "username" => 'string|required',
            "password" => 'string|required'
        ]);

        $data = $request->only('username', 'password');

        if (!User::where('email', $data['username'])->exists()) {
            # code...
            return response()->json([
                "status" => 401,
                "message" => "Wrong email/password"
            ], 401);
        }

        $target_password = $data['password'];
        $resource_admin = User::where('email', $data['username'])->get()->first();

        $same = Hash::check($target_password, $resource_admin['password']);


        if (boolval($same) === true) {
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
                "message" => "Wrong email/password"
            ],  401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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


    public function appointement(Request $request)
    {
        // start_date: ,
        // date_time,
        // reason,
        // doctor_id: ,

        $request->validate([
            'start_date' => 'string|required',
            'end_date' => 'string|required',
            'doctor_id' => 'string|required|uuid',
            'reason' => 'string|required'
        ]);

        $data = $request->only('start_date', 'reason', 'doctor_id', 'end_date');


        if (!$request['currentuser']) {
            return response()->json(
                [
                    'status' => 401,
                    'message' => "Not logged in"
                ]
            );
        }




        Appointement::create(
            [
                'medic_id' => $data['doctor_id'],
                'user_id' => $request['currentuser']->id,
                'start' => $data['start_date'],
                'end' => $data['end_date'],
                'status' => $data['reason'],
                'title' => $request['currentuser']->full_name
            ]
        );

        return response()->json([
            'status' => 201,
            'message' => 'Created'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(
            [
                'status' => 200,
                'payload' => $request['currentuser']
            ]
        );
    }
}
