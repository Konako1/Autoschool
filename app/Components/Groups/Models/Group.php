<?php

namespace App\Components\Groups\Models;

use App\Components\Courses\Models\Course;
use App\Components\Lessons\Models\Lesson;
use App\Components\Students\Models\Student;
use App\Components\Timings\Models\Timing;
use App\Components\Weekdays\Models\Weekday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'studying_start_date',
        'studying_end_date',
        'examen_date',
        'course_id',
        'timing_id',
    ];

    public function course() {
        return $this->hasOne(Course::class, 'id', 'course_id')->first();
    }

    public function students() {
        return $this->hasMany(Student::class, 'group_id', 'id')->get();
    }

    public function lessons() {
        return $this->hasMany(Lesson::class, 'group_id', 'id')->get();
    }

    public function weekdays()
    {
        return $this->belongsToMany(Weekday::class)
            ->where('group_weekday.deleted_at', '=', null)
            ->select([
                'weekdays.id',
                'order',
                'day_short',
                'day_long'
            ]);
    }

    public function timing() {
        return $this->hasOne(Timing::class, 'id', 'timing_id')->first();
    }

    protected $dates = ['deleted_at'];
}
