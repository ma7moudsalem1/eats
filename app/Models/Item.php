<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function sizes()
    {
        return $this->hasMany('App\Models\ItemSize');
    }
}
