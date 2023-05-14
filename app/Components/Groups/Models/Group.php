<?php

namespace App\Components\Groups\Models;

use App\Components\Courses\Models\Course;
use App\Components\Students\Models\Student;
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
    ];

    public function course() {
        return $this->hasOne(Course::class, 'id', 'course_id')->first();
    }

    public function students() {
        return $this->hasMany(Student::class, 'group_id', 'id')->get();
    }

    protected $dates = ['deleted_at'];
}
