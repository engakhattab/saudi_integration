<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnAmount extends Model{


    protected $table = 'returns';
    protected $fillable = [

        'rev_id',
        'ticket_id',
        'cashier_id',
        'amount',
        'day',
        'payment_method',

    ];


    public function cashier(){

        return $this->belongsTo(User::class, 'cashier_id','id');
    }

    public function reservation(){

        return $this->belongsTo(Reservations::class, 'rev_id','id');
    }

    public function ticket(){

        return $this->belongsTo(Ticket::class, 'ticket_id','id');
    }
}
