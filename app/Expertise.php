<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        "medic_id"
    ];
}
