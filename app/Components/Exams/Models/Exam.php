<?php

namespace App\Components\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = 'exams';

    protected $fillable = [
        'name',
        'mark',
        'student_id',
        'date',
    ];

    protected $dates = ['deleted_at'];
}
