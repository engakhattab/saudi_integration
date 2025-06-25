<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUpPrice extends Model
{
    protected $guarded = [];
    protected $table = 'top_up_prices';
    public $timestamps =false;

    public function visitor(){
        return $this->belongsTo(VisitorTypes::class,'type_id');
    }
}
