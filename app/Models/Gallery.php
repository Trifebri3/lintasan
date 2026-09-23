<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title_id',
        'title_en',
        'type',
        'layout_size',
        'image_path',
        'video_url',
        'youtube_id',
        'embed_url',
        'sort_order'
    ];

    /**
     * Get title based on the active locale session.
     */
    public function getTitleAttribute()
    {
        return session('locale') == 'en' ? ($this->title_en ?: $this->title_id) : $this->title_id;
    }

    /**
     * Get Bento Grid CSS span classes based on layout_size.
     */
    public function getGridSpanClassAttribute()
    {
        return match ($this->layout_size) {
            'featured' => 'col-span-1 sm:col-span-2 md:col-span-2 row-span-2 min-h-[380px]',
            'wide' => 'col-span-1 sm:col-span-2 md:col-span-2 row-span-1 min-h-[220px]',
            'tall' => 'col-span-1 row-span-2 min-h-[380px]',
            default => 'col-span-1 row-span-1 min-h-[220px]',
        };
    }

    /**
     * Human-readable layout size label for admin.
     */
    public function getLayoutLabelAttribute()
    {
        return match ($this->layout_size) {
            'featured' => 'Besar / Featured (2x2)',
            'wide' => 'Lebar / Wide (2x1)',
            'tall' => 'Tinggi / Tall (1x2)',
            default => 'Normal (1x1)',
        };
    }
}
