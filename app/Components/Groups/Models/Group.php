<?php

namespace App\Components\Groups\Models;

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
        'instructor_id',
        'course_id',
    ];

    protected $dates = ['deleted_at'];
}
