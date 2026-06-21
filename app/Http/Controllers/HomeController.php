<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredCourses = Course::with('category')
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredCourses'));
    }
}
