<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroImage extends Model
{
    protected $fillable = [
        'image_path',
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'sort_order',
        'is_active',
        'button_link',
    ];
}
