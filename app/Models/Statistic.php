<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'label',
        'icon',
        'color_class',
        'sort_order'
    ];
}
