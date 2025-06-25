<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketRevModel extends Model
{
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservations::class,'rev_id');
    }//end fun

    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }//end fun

    public function type()
    {
        return $this->belongsTo(VisitorTypes::class,'visitor_type_id');
    }//end fun

    public function scopeWhereFree($query,$title)
    {
        return $query->where([
            ['status', 'in'],
            ['bracelet_number',$title]
        ]);
    }//end fun

}//end class
