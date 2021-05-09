<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use \Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

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
        // Create new Admin
        if (!$request->cookie('auth:token')) {
            return response()->json([
                "status" => 401,
                "message" => "Vous n'etes pas connecter"
            ], 401);
        }
        
        $cookie_value = base64_decode($request->cookie('auth:token'));

        
        try {
            $is_admin = JWT::decode($cookie_value, env('JWT_SECRET'), array('HS256'))->admin;

            // print_r(gettype($is_admin));
            // return;
            if ($is_admin !== TRUE) {
                return response()->json([
                    "status" => 401,
                    "message" => "Vous n'etes pas un admin"
                ], 401);
            }
            
            if (Admin::where('username', $request->all()['username'])->exists()) {
                return response()->json([
                    "status" => 401,
                    "message" => "User is Already an admin"
                ], 401);
            }
            return Admin::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => 401,
                "message" => "Bad token",
                "more" => $th->getMessage()
            ], 401);
        }

        // print_r($is_admin);
        // return;

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
        // print_r($id);
        // print_r();


        // header('Content-Type', 'application/json');
        // return print_r(Admin::find($id));
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
}
