<?php

namespace App\Components\Documents\ExamProtocolDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamProtocolDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_exam_protocol';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
