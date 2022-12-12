<?php

namespace App\Components\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table = 'groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'studying_start_date',
        'studying_end_date',
        'examen_date',
        'instructor_id',
        'schedule_id',
    ];
}
