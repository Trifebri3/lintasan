<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class TranslationHelper
{
    /**
     * Cache for database settings to minimize queries.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected static $cachedSettings = null;

    /**
     * Get value from settings table, or create a default if it doesn't exist.
     *
     * @param string $key
     * @param string $defaultId
     * @param string $defaultEn
     * @param string $type
     * @return string
     */
    public static function get($key, $defaultId = '', $defaultEn = '', $type = 'text')
    {
        // Fail-safe: if the settings table does not exist yet (e.g. during migrations)
        if (!Schema::hasTable('settings')) {
            return session('locale') === 'en' ? ($defaultEn ?: $defaultId) : $defaultId;
        }

        if (self::$cachedSettings === null) {
            try {
                self::$cachedSettings = Setting::all()->keyBy('key');
            } catch (\Exception $e) {
                return session('locale') === 'en' ? ($defaultEn ?: $defaultId) : $defaultId;
            }
        }

        $setting = self::$cachedSettings->get($key);

        if (!$setting) {
            try {
                // Auto-create setting in database so it becomes editable in the admin panel
                $setting = Setting::create([
                    'key' => $key,
                    'value_id' => $defaultId,
                    'value_en' => $defaultEn ?: $defaultId,
                    'type' => $type,
                ]);
                self::$cachedSettings->put($key, $setting);
            } catch (\Exception $e) {
                // Return default on failure (e.g. duplicate key race conditions)
                return session('locale') === 'en' ? ($defaultEn ?: $defaultId) : $defaultId;
            }
        }

        $locale = session('locale', 'id');
        $val = $locale === 'en' ? $setting->value_en : $setting->value_id;

        return $val !== null ? $val : ($locale === 'en' ? ($defaultEn ?: $defaultId) : $defaultId);
    }
}
