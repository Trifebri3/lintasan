<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Story;
use App\Models\Partner;
use App\Models\Volunteer;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard overview.
     */
    public function index()
    {
        $programCount = Program::count();
        $storyCount = Story::count();
        $partnerCount = Partner::count();
        $volunteerCount = Volunteer::count();

        $latestVolunteers = Volunteer::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'programCount', 
            'storyCount', 
            'partnerCount', 
            'volunteerCount', 
            'latestVolunteers'
        ));
    }
}
