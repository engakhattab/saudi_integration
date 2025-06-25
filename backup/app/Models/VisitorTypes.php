<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorTypes extends Model
{

    protected $guarded = [];
    public function shifts(){
        return $this->belongsToMany(Shifts::class,'shifts','visitor_type_id','shift_id');
    }

    public function top_up()
    {
        return $this->hasOne(TopUpPrice::class,'type_id');
    }//end fun

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }//end fun

}//end class
