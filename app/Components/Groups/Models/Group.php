<?php

namespace App\Components\Groups\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'studying_start_date',
        'studying_end_date',
        'examen_date',
        'instructor_id',
    ];
}
