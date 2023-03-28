<?php

namespace App\Components\Courses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'category',
        'price',
    ];

    protected $dates = ['deleted_at'];
}
