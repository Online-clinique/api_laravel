<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        "medic_id",
        "price",
        "slug",
        "description"
    ];
}
