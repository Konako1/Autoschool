<?php

namespace App\Components\Lessons\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'time_start',
        'time_end',
        'module_id',
        'group_id',
    ];

    protected $dates = ['deleted_at'];
}
