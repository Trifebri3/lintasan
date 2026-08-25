<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of stories.
     */
    public function index()
    {
        $stories = Story::latest()->get();
        return view('public.ceritadampak.index', compact('stories'));
    }

    public function show($slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        
        // Increment visitor count
        $story->increment('views');
        
        // Load other featured stories (manually specified in related_links or fallback to latest)
        $otherStories = collect();
        $relatedLinksText = $story->related_links;
        
        if (!empty($relatedLinksText)) {
            $lines = explode("\n", str_replace("\r", "", $relatedLinksText));
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                $extractedSlug = $line;
                if (filter_var($line, FILTER_VALIDATE_URL)) {
                    $path = parse_url($line, PHP_URL_PATH);
                    $segments = explode('/', trim($path, '/'));
                    $extractedSlug = end($segments);
                }
                
                $relatedStory = Story::where('slug', $extractedSlug)->first();
                if ($relatedStory) {
                    $otherStories->push($relatedStory);
                }
            }
        }
        
        if ($otherStories->isEmpty()) {
            $otherStories = Story::where('id', '!=', $story->id)->latest()->limit(3)->get();
        } else {
            $otherStories = $otherStories->filter(function ($item) use ($story) {
                return $item->id !== $story->id;
            })->take(3);
        }
        
        return view('public.ceritadampak.show', compact('story', 'otherStories'));
    }
}
