<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $guarded = [];

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
