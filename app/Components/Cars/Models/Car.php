<?php

namespace App\Components\Cars\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'reg_number',
    ];

    protected $dates = ['deleted_at'];
}
