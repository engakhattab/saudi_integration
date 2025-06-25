<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];

    public function governorateYA(){
        return $this->belongsTo(Governorate::class,'gov_id');
    }

    public function cityYA(){
        return $this->belongsTo(City::class,'city_id');
    }
}
