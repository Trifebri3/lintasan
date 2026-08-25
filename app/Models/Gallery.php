<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title_id',
        'title_en',
        'type',
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
}
