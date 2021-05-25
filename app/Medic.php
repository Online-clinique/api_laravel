<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tarif;
use App\Experience;
use App\Expertise;
use App\Formation;
use App\Horaire;
use App\Admin;

class Medic extends Model
{
    //
    // use Notifiable;

    use \App\Http\Traits\UsesUuid;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'medic';


    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tarifs()
    {
        return $this->hasMany(Tarif::class, 'medic_id');
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class, 'medic_id');
    }
    public function expertise()
    {
        return $this->hasMany(Expertise::class, 'medic_id');
    }

    public function formations()
    {
        return $this->hasMany(Formation::class, 'medic_id');
    }
    public function horaire()
    {
        return $this->hasMany(Horaire::class, 'medic_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }
}
