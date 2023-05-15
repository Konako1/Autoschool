<?php

namespace App\Components\Instructors\Models;

use App\Components\Cars\Models\Car;
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
        'is_practician'
    ];

    public function car() {
        return $this->hasOne(Car::class, 'id', 'car_id')->first();
    }

    protected $dates = ['deleted_at'];
}
