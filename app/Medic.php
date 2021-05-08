<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class Medic extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * @return array
     */
    public function  getJWTCustomClaims() {
        return [];
    }

    public function getAuthPassword() {
        return '$2y$10$HcshwbKCphwhSJTU6feKMe6ZbOp.bbRhrA0hDIwTGK8X/CpIYfbzC';
    }
}
