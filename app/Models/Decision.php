<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $guarded = [];

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
}
