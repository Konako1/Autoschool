<?php

namespace App\Components\Weekdays\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weekday extends Model
{
    use SoftDeletes;

    protected $table = 'weekdays';

    protected $fillable = [
        'order',
        'day_short',
        'day_long',
    ];

    protected $dates = ['deleted_at'];
}
