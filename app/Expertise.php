<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Medic;

class Expertise extends Model
{
    //
    use \App\Http\Traits\UsesUuid;

    protected $guarded = [
        "id"
    ];

    public function medic()
    {
        $this->belongsTo(Medic::class, 'medic_id');
    }
}
