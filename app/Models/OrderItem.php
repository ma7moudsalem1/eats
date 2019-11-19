<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
