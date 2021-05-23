<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medic;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \Firebase\JWT\JWT;

use Illuminate\Support\Facades\DB;

use App\Expertise;

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
        return response()->json([
            "status" => 200,
            "data" => Medic::where('id', $id)->with('expertise')->first()
        ]);
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

    public function GenJWTBase64($payload)
    {
        return base64_encode(json_encode([
            'jwt' => JWT::encode($payload, env('JWT_SECRET'))
        ]));
    }


    public function continueSignUp(Request $request)
    {

        // id_admin,
        // 	id_medic,
        // 	email,
        // 	password,
        // 	password_confirm,
        // 	first_name,
        // 	last_name,
        // 	addresse_cabinet,
        // 	tel_pers,
        // 	tel_fixe,
        // 	tarifs,
        // 	cni,


        $request->validate([
            'id_admin' => 'required|uuid',
            'id_medic' => 'required|uuid',
            'email' => 'email|required',
            'password' => 'required',
            'password_confirm' => 'string|required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'addresse_cabinet' => 'string|required',
            'tel_pers' => 'string|required|numeric',
            'tel_fixe' => 'string|required|numeric',
            'tarifs' => 'string|required',
            'cni' => 'string|required',
            'specialite' => 'required'
        ]);

        $data = $request->only(
            'id_admin',
            'id_medic',
            'email',
            'password',
            'password_confirm',
            'first_name',
            'last_name',
            'addresse_cabinet',
            'tel_pers',
            'tel_fixe',
            'tarifs',
            'cni',
            'specialite'
        );

        if ($data['password'] !== $data['password_confirm']) {
            return response()->json([
                "status" => 400,
                "message" => "Passwords do not match"
            ]);
        }
        DB::beginTransaction();

        try {
            $users = DB::table('medic')
                ->where('id', [$data['id_medic']])
                ->update([
                    'full_name' => ucfirst($data['first_name']) . " " . ucfirst($data['last_name']),
                    'password' => bcrypt($data['password']),
                    'adresse_cabinet' => $data['addresse_cabinet'],
                    'phone_portable' => $data['tel_pers'],
                    'phone_cabinet' => $data['tel_fixe'],
                    'cni' => $data['cni'],
                    'account_status' => 'active',
                    'request_hash' => null
                ]);

            foreach ($data['specialite'] as $value) {
                DB::table('expertises')->insert([
                    'slug' => Str::slug($value['value'], "-"),
                    'medic_id' => $data['id_medic'],
                    'id' => Str::uuid()
                ]);
            }
            DB::commit();
            return response()->json([
                "status" => 200,
                "payload " => Medic::find($data['id_medic'])
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                "status" => 500,
                "message " => $th->getMessage()
            ], 500);
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


            if (!$doc->exists()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Invalid link'
                ], 422);
            }

            $doc_object = $doc->get()->first();

            return response()->json([
                "status" => 200,
                "message" => $doc_object
            ])->cookie(
                "validate",
                $this->GenJWTBase64(
                    [
                        'id_admin' => $doc_object['added_by'],
                        'id_medic' => $doc_object['id']
                    ]
                )
            );
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 422,
                "message" => $th->getMessage()
            ], 422);
        }
    }
}
