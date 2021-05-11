<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Medic;

class Admin extends Model
{
    //
    use \App\Http\Traits\UsesUuid;
    
    protected $fillable = [
        "id",
        "username",
        "full_name",
        "admin",
        "password"
    ];

    protected $hidden = array('password');

    public function setPasswordAttribute($raw) {
        $this->attributes['password'] = Hash::make($raw);
    }

    public function docs() {
        return $this->hasMany(Medic::class, 'added_by');
    }
}
