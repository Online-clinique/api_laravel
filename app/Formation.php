<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $guarded = [
        "id"
    ];
}
