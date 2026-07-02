<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFile;
use App\Models\CourseVideo;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $plans = SubscriptionPlan::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $videosByCategory = CourseVideo::groupedByCategory();

        $booksByCategory = CourseFile::groupedByCategory();

        $stats = collect([
            'courses' => Course::where('status', 'published')->count(),
            'students' => User::where('role', '!=', 'admin')->count(),
            'videos'  => CourseVideo::count(),
        ])->filter(fn($v) => $v > 0);

        return view('home', compact('videosByCategory', 'booksByCategory', 'plans', 'stats'));
    }
}
