<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Story;
use App\Models\Statistic;
use App\Models\Partner;
use App\Models\HeroImage;
use App\Models\Village;
use App\Models\Setting;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        // Auto-initialize background photo settings if missing
        Setting::firstOrCreate(
            ['key' => 'bg_photo_impact'],
            [
                'value_id' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'value_en' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'type' => 'image'
            ]
        );
        Setting::firstOrCreate(
            ['key' => 'bg_photo_cta'],
            [
                'value_id' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1000&q=80',
                'value_en' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1000&q=80',
                'type' => 'image'
            ]
        );

        $localeCol = session('locale') == 'en' ? 'value_en' : 'value_id';
        $settings = Setting::pluck($localeCol, 'key')->all();

        $quickStats = Statistic::where('group', 'quick_stats')
            ->orderBy('sort_order')
            ->get();

        $programs = Program::all();

        $impactStats = Statistic::where('group', 'connected_impact')
            ->orderBy('sort_order')
            ->get();

        $stories = Story::all();
        $latestStories = Story::latest()->take(5)->get();

        $partners = Partner::orderBy('sort_order')->get();

        $heroImages = HeroImage::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $villages = Village::all();
        
        $galleryItems = Gallery::orderBy('sort_order')->take(6)->get();

        return view('public.index', compact('quickStats', 'programs', 'impactStats', 'stories', 'latestStories', 'partners', 'heroImages', 'villages', 'settings', 'galleryItems'));
    }
}
