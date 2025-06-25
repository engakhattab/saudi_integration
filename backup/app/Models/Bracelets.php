<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bracelets extends Model
{
    protected $guarded = [];
    public function scopeBraceletFree($query)
    {
        return $query->where([
            ['status', true],
        ]);
    }//end fun

    public static function checkIsFree($title){
        $find = TicketRevModel::where('bracelet_number',$title)->count();
    }

    public static function checkIfCharIsFree($title){
       return Bracelets::BraceletFree()->where('title','LIKE','%'.$title.'%')->count();
    }

}//end class
