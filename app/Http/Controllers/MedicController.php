<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medic;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \Firebase\JWT\JWT;

use Illuminate\Support\Facades\DB;

class MedicController extends Controller
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

    public function requestNewMedic(Request $request)
    {
        $data = $request->all()['username'];

        $exists = Medic::where('username', $data)->exists();


        if ($exists) {
            return response()->json([
                'status' => 400,
                'message' => 'Docteur exist Déja'
            ], 400);
        }

        $request_hash = Str::uuid();

        $hash_tobe_sent = base64_encode(JWT::encode(json_encode([
            'hash' => $request_hash
        ]), env('JWT_SECRET')));


        DB::beginTransaction();

        DB::insert(
            "insert into medic (id, added_by, request_hash, username, account_status) 
            values (?, ?, ?, ?, ?)",
            [
                Str::uuid(), $request["currentuser"]->id, $request_hash, $data, "pending_metadata"
            ]
        );

        if (mail($data, 'Email to de verification', "http://localhost:5500/dash/medic/$hash_tobe_sent")) {
            DB::commit();
            return response()->json([
                'status' => 200
            ]);
        } else {
            DB::rollBack();
        }
    }

    public function validateRequestEmail($base)
    {
        // try {
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => 400,
        //         "message" => 'Bad token',
        //         "more" => $th->getMessage()
        //         ]);
        //     }
        // }
        try {
            $jwt = base64_decode($base);
            $uuid = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));
            $doc = Medic::where('request_hash', json_decode($uuid)->hash);


            $hash = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));

            if (!$doc->exists()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Invalid link'
                ], 422);
            }

            return response()->json([
                "status" => 200,
                "message" => $doc->get()->first()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 422,
                "message" => $th->getMessage()
            ]);
        }
    }
}
