<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationValue extends Model
{
    protected $fillable = [
        'title',
        'title_en',
        'description',
        'description_en',
        'icon',
        'color_class',
        'bg_class',
        'border_class',
        'order',
    ];

    public function getTitleAttribute($value)
    {
        if (session('locale') === 'en' && !empty($this->attributes['title_en'] ?? null)) {
            return $this->attributes['title_en'];
        }
        return $value;
    }

    public function getDescriptionAttribute($value)
    {
        if (session('locale') === 'en' && !empty($this->attributes['description_en'] ?? null)) {
            return $this->attributes['description_en'];
        }
        return $value;
    }

    public function getTitleIdAttribute()
    {
        return $this->attributes['title'] ?? '';
    }

    public function getDescriptionIdAttribute()
    {
        return $this->attributes['description'] ?? '';
    }

    public function getThemeAttribute()
    {
        if (str_contains($this->color_class ?? '', 'blue')) return 'blue';
        if (str_contains($this->color_class ?? '', 'amber') || str_contains($this->color_class ?? '', 'orange')) return 'amber';
        if (str_contains($this->color_class ?? '', 'purple')) return 'purple';
        if (str_contains($this->color_class ?? '', 'teal')) return 'teal';
        if (str_contains($this->color_class ?? '', 'rose')) return 'rose';
        return 'emerald';
    }
}
