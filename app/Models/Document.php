<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'year',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'cover_path',
        'downloads_count',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'downloads_count' => 'integer',
        'file_size' => 'integer',
        'published_at' => 'date',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doc) {
            if (empty($doc->slug)) {
                $doc->slug = Str::slug($doc->title);
                $originalSlug = $doc->slug;
                $counter = 1;
                while (static::where('slug', $doc->slug)->exists()) {
                    $doc->slug = $originalSlug . '-' . $counter++;
                }
            }
            if (empty($doc->published_at)) {
                $doc->published_at = now();
            }
        });
    }

    /**
     * Get human-readable file size.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes === 1) {
            return '1 byte';
        } else {
            return '0 KB';
        }
    }

    /**
     * Get file URL.
     */
    public function getFileUrlAttribute(): string
    {
        if (empty($this->file_path)) {
            return '#';
        }
        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }
        if (str_starts_with($this->file_path, '/storage/')) {
            return $this->file_path;
        }
        return '/storage/' . ltrim($this->file_path, '/');
    }

    /**
     * Get cover image URL or generate dynamic fallback.
     */
    public function getCoverUrlAttribute(): string
    {
        if (!empty($this->cover_path)) {
            if (str_starts_with($this->cover_path, 'http://') || str_starts_with($this->cover_path, 'https://')) {
                return $this->cover_path;
            }
            if (str_starts_with($this->cover_path, '/storage/')) {
                return $this->cover_path;
            }
            return '/storage/' . ltrim($this->cover_path, '/');
        }

        return '';
    }

    /**
     * FontAwesome icon based on file type.
     */
    public function getIconClassAttribute(): string
    {
        $ext = strtolower($this->file_type);
        return match ($ext) {
            'pdf' => 'fa-file-pdf text-red-500',
            'doc', 'docx' => 'fa-file-word text-blue-600',
            'xls', 'xlsx' => 'fa-file-excel text-emerald-600',
            'ppt', 'pptx' => 'fa-file-powerpoint text-amber-500',
            default => 'fa-file-lines text-gray-500',
        };
    }

    /**
     * Badge color styles for category.
     */
    public function getCategoryBadgeClassAttribute(): string
    {
        return match (strtolower($this->category)) {
            'annual report', 'laporan tahunan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'laporan keuangan' => 'bg-blue-50 text-blue-700 border-blue-200',
            'riset & panduan', 'panduan & modul' => 'bg-amber-50 text-amber-800 border-amber-200',
            'dokumen kebijakan' => 'bg-purple-50 text-purple-700 border-purple-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    }

    /**
     * Scope for published documents.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
