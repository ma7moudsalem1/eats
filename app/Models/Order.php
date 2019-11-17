<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $appends = ['resturant'];

    public function decision()
    {
        return $this->belongsTo('App\Models\Decision');
    }

    public function getResturantAttribute()
    {
        return $this->decision->resturant;
    }
}
