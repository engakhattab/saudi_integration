<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    protected $guarded=[];
    protected $table='shifts';


    public function visitors(){
        return $this->belongsToMany(VisitorTypes::class,'shift_details','shift_id','visitor_type_id');
    }
}//end class
