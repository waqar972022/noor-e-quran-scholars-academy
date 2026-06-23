<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with('category')->where('status', 'published');

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        $courses    = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::withCount(['courses' => fn ($q) => $q->where('status', 'published')])
            ->having('courses_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('courses.index', compact('courses', 'categories'));
    }

    public function show(string $slug): View
    {
        $course = Course::with([
                'category',
                'videos' => fn ($q) => $q->orderBy('video_order'),
                'files',
            ])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $isSubscribed = $course->is_free || (auth()->check() && auth()->user()->hasActiveSubscription());

        $completedVideoIds = [];
        $completedCount    = 0;
        $totalVideos       = $course->videos->count();

        if (auth()->check() && $isSubscribed) {
            $completedVideoIds = auth()->user()
                ->lessonProgress()
                ->whereIn('course_video_id', $course->videos->pluck('id'))
                ->pluck('course_video_id')
                ->toArray();
            $completedCount = count($completedVideoIds);
        }

        return view('courses.show', compact(
            'course', 'isSubscribed',
            'completedVideoIds', 'completedCount', 'totalVideos'
        ));
    }
}
