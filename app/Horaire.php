<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    //
    use \App\Http\Traits\UsesUuid;


    protected $guarded = [
        "id"
    ];
}
