<?php

namespace App\Components\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupWeekday extends Model
{
    use SoftDeletes;

    protected $table = 'group_weekday';

    protected $fillable = [
        'group_id',
        'weekday_id',
    ];

    protected $dates = ['deleted_at'];
}
