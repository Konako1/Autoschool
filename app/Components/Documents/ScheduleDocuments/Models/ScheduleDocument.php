<?php

namespace App\Components\Documents\ScheduleDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_schedule';

    protected $fillable = [
        'group_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
