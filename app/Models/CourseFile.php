<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'file_title',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'course_id' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function groupedByCategory()
    {
        return static::with(['course.category'])
            ->whereHas('course', fn ($q) => $q->where('status', 'published'))
            ->get()
            ->groupBy(fn ($f) => $f->course->category?->name ?? 'General');
    }
}
