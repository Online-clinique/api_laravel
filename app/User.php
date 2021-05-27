<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Appointement;

class User extends Model
{
    use Notifiable;
    use \App\Http\Traits\UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appointement()
    {
        return $this->hasMany(Appointement::class, 'user_id');
    }

    /**
     * @return mixed
     */

    protected $hidden = array('password');

    public function setPasswordAttribute($raw)
    {
        $this->attributes['password'] = Hash::make($raw);
    }
}
