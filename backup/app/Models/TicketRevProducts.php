<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketRevProducts extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }//end fun
    /**
     * @return mixed
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }//end fun

    /**
     * @return mixed
     */
    public function reservation()
    {
        return $this->belongsTo(Reservations::class,'rev_id');
    }//end fun


}//end class
