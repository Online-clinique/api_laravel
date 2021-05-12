<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        "date_debut",
        "date_fin",
        "slug",
        'description',
        "medic_id"
    ];
}
