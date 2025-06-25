<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftDetails extends Model
{
    protected $guarded = [];

    public function visitors(){
        return $this->belongsTo(VisitorTypes::class,'visitor_type_id');
    }

    public function shifts(){
        return $this->belongsTo(Shifts::class,'shift_id');
    }
}
