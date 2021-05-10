<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{
    //
    // use Notifiable;

    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        'name', 'email', 'password', 'added_by', 'request_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'medic';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }
}
