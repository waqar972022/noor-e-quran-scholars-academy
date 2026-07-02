<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'video_title',
        'youtube_url',
        'video_order',
    ];

    protected function casts(): array
    {
        return [
            'course_id'   => 'integer',
            'video_order' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonProgress(): HasMany
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    public static function groupedByCategory()
    {
        $videos = static::with(['course.category'])
            ->whereHas('course', fn ($q) => $q->where('status', 'published'))
            ->orderBy('video_order')
            ->get();

        $firstIdByCourse = $videos->groupBy('course_id')->map(fn ($g) => $g->first()->id);

        $videos->each(function ($video) use ($firstIdByCourse) {
            $video->is_free_preview = $video->course->is_free || $firstIdByCourse[$video->course_id] === $video->id;
        });

        return $videos->groupBy(fn ($v) => $v->course->category?->name ?? 'General');
    }
}
