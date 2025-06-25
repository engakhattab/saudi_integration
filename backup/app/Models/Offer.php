<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    public function items(){
        return $this->hasMany(OfferItem::class,'offer_id');
    }
}
