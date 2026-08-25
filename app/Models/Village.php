<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'location',
        'description',
        'narrative',
        'image_path',
        'map_iframe',
        'latitude',
        'longitude',
    ];
}
