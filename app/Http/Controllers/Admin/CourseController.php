<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseFile;
use App\Models\CourseVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $courses = Course::query()
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->with('category')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'short_description'=> 'required|string|max:500',
            'long_description' => 'nullable|string',
            'thumbnail'        => 'required|file|max:5120|mimes:jpg,jpeg,png,webp',
            'status'           => 'required|in:draft,published',
            'pdf_files'        => 'nullable|array|max:20',
            'pdf_files.*'      => 'file|max:102400|mimes:pdf',
            'pdf_titles'       => 'nullable|array',
            'pdf_titles.*'     => 'nullable|string|max:255',
        ]);

        $thumb = $request->file('thumbnail');
        $this->assertImageMime($thumb->getPathname());

        $thumbName = Str::slug(pathinfo($thumb->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time() . '.' . $thumb->extension();
        $thumbPath = $thumb->storeAs('thumbnails', $thumbName, 'public');

        $slug = $this->uniqueSlug($request->title);

        $course = Course::create([
            'title'             => $request->title,
            'slug'              => $slug,
            'category_id'       => $request->category_id,
            'owner_id'          => auth()->id(),
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'thumbnail'         => $thumbPath,
            'is_premium'        => true,
            'status'            => $request->status,
        ]);

        $this->storePdfs($request, $course);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Course created. Add video lessons below.');
    }

    public function edit(Course $course): View
    {
        $categories = Category::orderBy('name')->get();
        $course->load(['files', 'videos' => fn ($q) => $q->orderBy('video_order')]);
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'short_description'=> 'required|string|max:500',
            'long_description' => 'nullable|string',
            'thumbnail'        => 'nullable|file|max:5120|mimes:jpg,jpeg,png,webp',
            'status'           => 'required|in:draft,published',
            'pdf_files'        => 'nullable|array|max:20',
            'pdf_files.*'      => 'file|max:102400|mimes:pdf',
            'pdf_titles'       => 'nullable|array',
            'pdf_titles.*'     => 'nullable|string|max:255',
        ]);

        $data = [
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'status'            => $request->status,
        ];

        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail');
            $this->assertImageMime($thumb->getPathname());

            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $thumbName = Str::slug(pathinfo($thumb->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $thumb->extension();
            $data['thumbnail'] = $thumb->storeAs('thumbnails', $thumbName, 'public');
        }

        $course->update($data);
        $this->storePdfs($request, $course);

        return back()->with('success', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        foreach ($course->files as $file) {
            Storage::disk('local')->delete($file->file_path);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted.');
    }

    // ── PDF file management ────────────────────────────────

    public function destroyFile(Course $course, CourseFile $file): RedirectResponse
    {
        abort_if($file->course_id !== $course->id, 404);

        Storage::disk('local')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'PDF removed.');
    }

    // ── Video management ───────────────────────────────────

    public function storeVideo(Request $request, Course $course): RedirectResponse
    {
        $request->validate([
            'video_title' => 'required|string|max:255',
            'youtube_url' => 'required|url|max:500',
            'video_order' => 'required|integer|min:0',
        ]);

        $course->videos()->create($request->only('video_title', 'youtube_url', 'video_order'));

        return back()->with('success', 'Video lesson added.');
    }

    public function updateVideo(Request $request, Course $course, CourseVideo $video): RedirectResponse
    {
        abort_if($video->course_id !== $course->id, 404);

        $request->validate([
            'video_title' => 'required|string|max:255',
            'youtube_url' => 'required|url|max:500',
            'video_order' => 'required|integer|min:0',
        ]);

        $video->update($request->only('video_title', 'youtube_url', 'video_order'));

        return back()->with('success', 'Video updated.');
    }

    public function destroyVideo(Course $course, CourseVideo $video): RedirectResponse
    {
        abort_if($video->course_id !== $course->id, 404);

        $video->delete();

        return back()->with('success', 'Video removed.');
    }

    // ── Private helpers ────────────────────────────────────

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function assertImageMime(string $path): void
    {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime    = (new \finfo(FILEINFO_MIME_TYPE))->file($path);
        abort_if(! in_array($mime, $allowed, true), 422, 'Invalid image file.');
    }

    private function storePdfs(Request $request, Course $course): void
    {
        if (! $request->hasFile('pdf_files')) {
            return;
        }

        foreach ($request->file('pdf_files') as $i => $pdf) {
            $realMime = (new \finfo(FILEINFO_MIME_TYPE))->file($pdf->getPathname());
            if ($realMime !== 'application/pdf') {
                continue;
            }

            $pdfName = Str::slug(pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '-' . $i . '.pdf';
            $pdfPath = $pdf->storeAs('course-files/' . $course->id, $pdfName);

            CourseFile::create([
                'course_id'  => $course->id,
                'file_title' => $request->input("pdf_titles.{$i}") ?: $pdf->getClientOriginalName(),
                'file_path'  => $pdfPath,
            ]);
        }
    }
}
