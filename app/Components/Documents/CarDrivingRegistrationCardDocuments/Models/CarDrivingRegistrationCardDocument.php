<?php

namespace App\Components\Documents\CarDrivingRegistrationCardDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarDrivingRegistrationCardDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_car_driving_registration_card';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
