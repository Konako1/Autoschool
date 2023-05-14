<?php

namespace App\Components\Documents\DriverExamCardDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverExamCardDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_driver_exam_card';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
