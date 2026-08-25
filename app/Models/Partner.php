<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'logo_icon',
        'logo_path',
        'url',
        'sort_order'
    ];
}
