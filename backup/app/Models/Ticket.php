<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model{


    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id','phone');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function append_models()
    {
        return $this->hasMany(TicketRevModel::class,'ticket_id')
            ->where('status', 'append');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function in_models()
    {
        return $this->hasMany(TicketRevModel::class,'ticket_id')
            ->where('status', 'in');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(TicketRevModel::class,'ticket_id');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(TicketRevProducts::class,'ticket_id');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shifts::class,'shift_id');
    }//end fun

    public function reason(){
        return $this->belongsTo(DiscountReason::class,'discount_id');
    }


    public function payments(){
        return $this->hasMany(Payment::class,'ticket_id');
    }


    public function returns(){
        return $this->hasMany(ReturnAmount::class,'ticket_id');
    }


}//end class
