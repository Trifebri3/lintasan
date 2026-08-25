<?php

if (!function_exists('db_trans')) {
    function db_trans($key, $defaultId = '', $defaultEn = '', $type = 'text') {
        return \App\Helpers\TranslationHelper::get($key, $defaultId, $defaultEn, $type);
    }
}
