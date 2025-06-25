<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];


    public function categoryYA(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
