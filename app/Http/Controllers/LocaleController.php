<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch language and store in session.
     */
    public function switchLang($locale)
    {
        if (in_array($locale, ['id', 'en'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
