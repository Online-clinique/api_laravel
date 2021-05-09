<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    use \App\Http\Traits\UsesUuid;
    
    protected $fillable = [
        "id",
        "username",
        "full_name",
        "admin"
    ];
}
