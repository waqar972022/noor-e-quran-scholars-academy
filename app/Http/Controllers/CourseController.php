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

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->get('category')) {
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

        return view('courses.show', compact('course'));
    }
}
