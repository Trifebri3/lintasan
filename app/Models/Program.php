<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_class',
        'text_color',
        'image_url',
        'link',
        'code'
    ];

    protected static function booted()
    {
        static::creating(function ($program) {
            if (empty($program->code)) {
                do {
                    $code = \Illuminate\Support\Str::random(32);
                } while (static::where('code', $code)->exists());
                $program->code = $code;
            }
        });
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
