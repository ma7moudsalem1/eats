<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
