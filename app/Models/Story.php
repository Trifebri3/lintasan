<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'title_id',
        'title_en',
        'category_id',
        'category_en',
        'category_bg',
        'category_color',
        'description_id',
        'description_en',
        'content_id',
        'content_en',
        'gallery',
        'views',
        'impact_number',
        'impact_label_id',
        'impact_label_en',
        'image_url',
        'link',
        'program_id',
        'slug',
        'related_links'
    ];

    protected static function booted()
    {
        static::creating(function ($story) {
            if (empty($story->slug)) {
                $slug = \Illuminate\Support\Str::slug($story->title_id ?: 'story');
                $originalSlug = $slug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }
                $story->slug = $slug;
            }
        });

        static::updating(function ($story) {
            if ($story->isDirty('title_id') && !$story->isDirty('slug')) {
                $slug = \Illuminate\Support\Str::slug($story->title_id ?: 'story');
                $originalSlug = $slug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $story->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }
                $story->slug = $slug;
            }
        });
    }

    protected $casts = [
        'gallery' => 'array',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getTitleAttribute()
    {
        return session('locale') == 'en' ? ($this->title_en ?: $this->title_id) : $this->title_id;
    }

    public function getCategoryAttribute()
    {
        return session('locale') == 'en' ? ($this->category_en ?: $this->category_id) : $this->category_id;
    }

    public function getDescriptionAttribute()
    {
        return session('locale') == 'en' ? ($this->description_en ?: $this->description_id) : $this->description_id;
    }

    public function getContentAttribute()
    {
        return session('locale') == 'en' ? ($this->content_en ?: $this->content_id) : $this->content_id;
    }

    public function getImpactLabelAttribute()
    {
        return session('locale') == 'en' ? ($this->impact_label_en ?: $this->impact_label_id) : $this->impact_label_id;
    }
}
