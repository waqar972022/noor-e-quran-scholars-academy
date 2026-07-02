<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
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
