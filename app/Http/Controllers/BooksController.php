<?php

namespace App\Http\Controllers;

use App\Models\CourseFile;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function __invoke(): View
    {
        $booksByCategory = CourseFile::groupedByCategory();

        return view('books.index', compact('booksByCategory'));
    }
}
