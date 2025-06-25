<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function governorate(){

        return $this->belongsTo(Governorate::class,'gov_id','id');
    }
}
