<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];
    protected $appends = ['photo'];

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function sizes()
    {
        return $this->hasMany('App\Models\ItemSize');
    }

    public function getPhotoAttribute()
    {
        $image = $this->image;
        return $image == null ? url('public/no_photo.png') : $image;
    }
}
