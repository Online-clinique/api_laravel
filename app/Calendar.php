<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $guarded = [
        "id"
    ];
}
