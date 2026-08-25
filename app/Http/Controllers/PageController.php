<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Village;
use App\Models\Setting;
use App\Models\Story;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display Partner Villages (Desa Mitra Lintasan) page with dynamic database records.
     */
    public function desaBinaan()
    {
        $villages = Village::all();
        return view('public.desabinaan.index', compact('villages'));
    }

    /**
     * Display detailed narrative profile and map of a single partner village.
     */
    public function showVillage($slug)
    {
        $village = Village::where('slug', $slug)->firstOrFail();
        $otherVillages = Village::where('id', '!=', $village->id)->limit(3)->get();
        return view('public.desabinaan.show', compact('village', 'otherVillages'));
    }

    /**
     * Display Partners (Mitra) list.
     */
    public function mitra()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('public.mitra.index', compact('partners'));
    }

    /**
     * Display About Us (Tentang Kami) page.
     */
    public function tentangKami()
    {
        $localeCol = session('locale') == 'en' ? 'value_en' : 'value_id';
        $settings = Setting::pluck($localeCol, 'key')->all();
        return view('public.tentangkami.index', compact('settings'));
    }

    /**
     * Display Gallery (Galeri & Dokumentasi) page with items from the galleries database.
     */
    public function galeri()
    {
        $galleryItems = Gallery::orderBy('sort_order')->get();
        return view('public.galeri.index', compact('galleryItems'));
    }
}
