<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Story;
use App\Models\Partner;
use App\Models\Volunteer;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        // 7-day traffic summary for dashboard widget
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        $totalPageviews = VisitorLog::where('visited_at', '>=', $sevenDaysAgo)->count();
        $uniqueVisitors = VisitorLog::where('visited_at', '>=', $sevenDaysAgo)->distinct('session_id')->count('session_id');
        $todayPageviews = VisitorLog::where('visited_at', '>=', Carbon::now()->startOfDay())->count();

        $dailyStats = VisitorLog::where('visited_at', '>=', $sevenDaysAgo)
            ->select(DB::raw('DATE(visited_at) as visit_date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE(visited_at)'))
            ->orderBy('visit_date', 'asc')
            ->pluck('count', 'visit_date')
            ->toArray();

        $trendLabels = [];
        $trendValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i);
            $key = $d->toDateString();
            $trendLabels[] = $d->format('d M');
            $trendValues[] = $dailyStats[$key] ?? 0;
        }

        $topPages = VisitorLog::where('visited_at', '>=', $sevenDaysAgo)
            ->select('path', 'page_title', DB::raw('count(*) as views'))
            ->groupBy('path', 'page_title')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        return view('admin.dashboard', compact(
            'programCount', 
            'storyCount', 
            'partnerCount', 
            'volunteerCount', 
            'latestVolunteers',
            'totalPageviews',
            'uniqueVisitors',
            'todayPageviews',
            'trendLabels',
            'trendValues',
            'topPages'
        ));
    }
}
