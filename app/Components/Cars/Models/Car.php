<?php

namespace App\Components\Cars\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'reg_number',
    ];

    protected $dates = ['deleted_at'];

    protected static function newFactory(): CarFactory
    {
        return new CarFactory();
    }
}
