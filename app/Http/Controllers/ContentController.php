<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFile;
use App\Models\CourseVideo;
use App\Models\UserLessonProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContentController extends Controller
{
    public function video(Request $request, string $slug, CourseVideo $video): View|RedirectResponse
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_if($video->course_id !== $course->id, 404);

        if (! $course->is_free && ! $request->user()->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('warning', 'An active subscription is required to access course content.');
        }

        $embedUrl  = $this->youtubeEmbedUrl($video->youtube_url);
        abort_if(! $embedUrl, 404);

        $allVideos = $course->videos()->orderBy('video_order')->get();

        $completedIds = $request->user()
            ->lessonProgress()
            ->whereIn('course_video_id', $allVideos->pluck('id'))
            ->pluck('course_video_id')
            ->toArray();

        $isCompleted   = in_array($video->id, $completedIds);
        $completedCount = count($completedIds);
        $totalVideos   = $allVideos->count();

        return view('courses.video', compact(
            'course', 'video', 'embedUrl', 'allVideos',
            'completedIds', 'isCompleted', 'completedCount', 'totalVideos'
        ));
    }

    public function pdf(Request $request, string $slug, CourseFile $file): View|RedirectResponse
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_if($file->course_id !== $course->id, 404);

        if (! $course->is_free && ! $request->user()->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('warning', 'An active subscription is required to access course content.');
        }

        return view('courses.pdf', compact('course', 'file'));
    }

    public function pdfStream(Request $request, string $slug, CourseFile $file): StreamedResponse
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_if($file->course_id !== $course->id, 404);

        if (! $course->is_free && ! $request->user()->hasActiveSubscription()) {
            abort(403);
        }

        abort_unless(Storage::exists($file->file_path), 404);

        return Storage::response($file->file_path, null, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline',
            'Cache-Control'       => 'private, no-store',
        ]);
    }

    public function markComplete(Request $request, string $slug, CourseVideo $video): RedirectResponse
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_if($video->course_id !== $course->id, 404);

        $user = $request->user();

        if (! $course->is_free && ! $user->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('warning', 'An active subscription is required.');
        }

        // Toggle: if already marked, remove it
        $deleted = UserLessonProgress::where('user_id', $user->id)
            ->where('course_video_id', $video->id)
            ->delete();

        if ($deleted) {
            return back()->with('success', 'Lesson marked as incomplete.');
        }

        UserLessonProgress::create([
            'user_id'         => $user->id,
            'course_video_id' => $video->id,
            'completed_at'    => now(),
        ]);

        return back()->with('success', 'Lesson marked as complete.');
    }

    private function youtubeEmbedUrl(string $url): ?string
    {
        $patterns = [
            '/[?&]v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/\/embed\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $m)) {
                return 'https://www.youtube-nocookie.com/embed/' . $m[1];
            }
        }

        return null;
    }
}
