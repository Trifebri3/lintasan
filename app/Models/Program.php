<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'title_en',
        'short_description',
        'short_description_en',
        'description',
        'description_en',
        'icon',
        'color_class',
        'text_color',
        'image_url',
        'link',
        'code',
        'sort_order'
    ];

    public function getTitleAttribute($value)
    {
        if (session('locale') === 'en' && !empty($this->attributes['title_en'] ?? null)) {
            return $this->attributes['title_en'];
        }
        return $value;
    }

    public function getShortDescriptionAttribute($value)
    {
        if (session('locale') === 'en' && !empty($this->attributes['short_description_en'] ?? null)) {
            return trim(strip_tags($this->attributes['short_description_en']));
        }
        if (!empty($value)) {
            return trim(strip_tags($value));
        }
        // Fallback to description if short_description is not set
        $fallback = $this->description;
        return \Illuminate\Support\Str::limit(trim(strip_tags($fallback)), 130);
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

    public function getShortDescriptionIdAttribute()
    {
        return $this->attributes['short_description'] ?? '';
    }

    public function getDescriptionIdAttribute()
    {
        return $this->attributes['description'] ?? '';
    }

    public function getImageUrlAttribute($value)
    {
        // 1. If valid path provided, check if it actually exists in public storage or public dir
        if (!empty($value)) {
            $cleaned = ltrim($value, '/');
            // If it starts with storage/
            if (str_starts_with($cleaned, 'storage/')) {
                $storageSub = substr($cleaned, 8); // remove 'storage/'
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storageSub)) {
                    return $value;
                }
            } elseif (file_exists(public_path($cleaned))) {
                return $value;
            }
        }

        // 2. High-quality thematic fallbacks if the local image file is missing or not yet uploaded
        $title = strtolower($this->attributes['title'] ?? '');
        if (str_contains($title, 'spab') || str_contains($title, 'bencana') || str_contains($title, 'sekolah')) {
            return 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($title, 'hutan') || str_contains($title, 'han') || str_contains($title, 'pohon') || str_contains($title, 'lingkungan')) {
            return 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($title, 'senyum') || str_contains($title, 'san') || str_contains($title, 'anak')) {
            return 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($title, 'smk') || str_contains($title, 'vokasi') || str_contains($title, 'jago')) {
            return 'https://images.unsplash.com/photo-1581092921461-eab62e97a780?auto=format&fit=crop&w=800&q=80';
        }

        return 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=800&q=80';
    }

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
