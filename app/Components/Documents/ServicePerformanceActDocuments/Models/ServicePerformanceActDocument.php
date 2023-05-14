<?php

namespace App\Components\Documents\ServicePerformanceActDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePerformanceActDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_service_performance_act';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
