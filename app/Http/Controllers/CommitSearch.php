<?php

namespace App\Http\Controllers;

use App\Expertise;
use Illuminate\Http\Request;

use App\Medic;

class CommitSearch extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($spec, $cat, $name)
    {
        //

        // return Medic::with(['expertise'])->join('expertises', 'expertises.medic_id', '=', 'medic.id')->where('expertises.slug', 'like', $cat === 'all' ? '%%' : "%$cat%")->get();

        // if ($cat === 'all' && $spec === 'all' && $name === 'all') {
        //     return Medic::with(['expertise'])->get();
        // } else {
        //     if ($cat === 'all' && $spec === 'all' && $name !== 'all') {
        //         # code...
        //         return Medic::with(['expertise'])->where('full_name', 'like', "%$name%")->get();
        //     } else if ($cat === 'all' && $spec !== 'all' && $name !== 'all') {
        //         $expertise =  Expertise::where('slug', 'like', "%$name%")->get()->with('medic');

        //         return $expertise;
        //     }
        // }



        return Medic::with(['expertise'])->whereHas('expertise', function ($query) use ($cat) {
            $query
                ->where('slug', 'like', $cat === 'all' ? "%%" :  "%$cat%");
        })
            ->where('ville', 'like', $spec === "all" ? "%%" : "%$spec%")
            ->where('full_name', 'like', $name === "all" ? "%%" : "%$name%")->get();
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
}
