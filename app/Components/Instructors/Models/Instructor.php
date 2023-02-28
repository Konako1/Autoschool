<?php

namespace App\Components\Instructors\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $table = 'instructors';

    protected $fillable = [
        'job',
        'education',
        'certificate',
        'driver_certificate',
        'driver_certificate_category',
        'car_id',
        'name',
        'surname',
        'patronymic',
        'photo_path',
        'phone',
    ];

    protected $dates = ['deleted_at'];
}
