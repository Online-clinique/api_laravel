<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    //
    use \App\Http\Traits\UsesUuid;


    protected $fillable = [
        "slug",
        "value",
        "medic_id"
    ];
    
}
