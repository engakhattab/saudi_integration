<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $guarded=[];


    public function cities()
    {
        return $this->hasMany(City::class,'gov_id','id');
    }

}//end fun
