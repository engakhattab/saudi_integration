<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

class Reservations extends Model
{

    protected $guarded=[];

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shifts::class,'shift_id');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(TicketRevModel::class,'rev_id');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function append_models()
    {
        return $this->hasMany(TicketRevModel::class,'rev_id')
            ->where('status', 'append');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function in_models()
    {
        return $this->hasMany(TicketRevModel::class,'rev_id')
            ->where('status', 'in');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(TicketRevProducts::class,'rev_id');
    }//end fun

    public function reason(){
        return $this->belongsTo(DiscountReason::class,'discount_id');
    }


    public function payments(){
        return $this->hasMany(Payment::class,'rev_id');
    }

    public function governorateYA(){
        return $this->belongsTo(Governorate::class,'gov_id');
    }

    public function cityYA(){
        return $this->belongsTo(City::class,'city_id');
    }

}//end class
