<?php

namespace App\Components\Instructors\Models;

use App\Components\Cars\Models\Car;
use App\Components\Categories\Models\Category;
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
        'car_id',
        'category_id',
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

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id')->first();
    }

    protected $dates = ['deleted_at'];
}
