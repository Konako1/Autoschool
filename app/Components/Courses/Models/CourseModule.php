<?php

namespace App\Components\Courses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseModule extends Model
{
    use SoftDeletes;

    protected $table = 'course_module';

    protected $fillable = [
        'course_id',
        'module_id'
    ];

    protected $dates = ['deleted_at'];
}
