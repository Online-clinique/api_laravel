<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    use \App\Http\Traits\UsesUuid;


    protected $fillable = [
        "genre",
        "value",
        "medic_id"
    ];
}
