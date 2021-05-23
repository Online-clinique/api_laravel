<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    //

    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        "medic_id",
        "date_debut",
        "date_fin",
        "title",
        "medic_id"
    ];
}
