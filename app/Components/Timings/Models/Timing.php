<?php

namespace App\Components\Timings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timing extends Model
{
    use SoftDeletes;

    protected $table = 'timings';

    protected $fillable = [
        'start',
        'end',
        'time_interval',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
