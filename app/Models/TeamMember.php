<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'category',
        'role_id',
        'role_en',
        'photo_path',
        'bio_id',
        'bio_en',
        'social_linkedin',
        'social_email',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get locale-aware role / position title.
     */
    public function getRoleAttribute()
    {
        if (session('locale') === 'en' && !empty($this->role_en)) {
            return $this->role_en;
        }
        return $this->role_id;
    }

    /**
     * Get locale-aware biography.
     */
    public function getBioAttribute()
    {
        if (session('locale') === 'en' && !empty($this->bio_en)) {
            return $this->bio_en;
        }
        return $this->bio_id;
    }

    /**
     * Category metadata helper for badge colors and labels.
     */
    public static function getCategories(): array
    {
        return [
            'pendiri' => [
                'id' => 'Pendiri Yayasan',
                'en' => 'Founders',
                'badge' => 'bg-amber-50 text-amber-800 border-amber-200',
                'icon' => 'fa-certificate',
            ],
            'pembina' => [
                'id' => 'Dewan Pembina',
                'en' => 'Advisory Board',
                'badge' => 'bg-blue-50 text-blue-800 border-blue-200',
                'icon' => 'fa-shield-halved',
            ],
            'pengawas' => [
                'id' => 'Dewan Pengawas',
                'en' => 'Supervisory Board',
                'badge' => 'bg-purple-50 text-purple-800 border-purple-200',
                'icon' => 'fa-scale-balanced',
            ],
            'pengurus' => [
                'id' => 'Pengurus Harian',
                'en' => 'Executive Board',
                'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'icon' => 'fa-user-tie',
            ],
            'tim' => [
                'id' => 'Tim Pelaksana & Manajemen',
                'en' => 'Operations & Management Team',
                'badge' => 'bg-teal-50 text-teal-800 border-teal-200',
                'icon' => 'fa-users',
            ],
        ];
    }

    /**
     * Get current category label based on locale.
     */
    public function getCategoryLabelAttribute(): string
    {
        $cats = self::getCategories();
        $cat = $cats[$this->category] ?? null;
        if (!$cat) {
            return ucfirst($this->category);
        }
        return session('locale') === 'en' ? $cat['en'] : $cat['id'];
    }

    /**
     * Get category badge CSS class.
     */
    public function getCategoryBadgeAttribute(): string
    {
        $cats = self::getCategories();
        return $cats[$this->category]['badge'] ?? 'bg-gray-100 text-gray-700 border-gray-200';
    }
}

