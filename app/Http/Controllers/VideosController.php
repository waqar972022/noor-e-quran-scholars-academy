<?php

namespace App\Http\Controllers;

use App\Models\CourseVideo;
use Illuminate\View\View;

class VideosController extends Controller
{
    public function __invoke(): View
    {
        $videosByCategory = CourseVideo::groupedByCategory();

        return view('videos.index', compact('videosByCategory'));
    }
}
