<?php

namespace App\Components\Documents\ExamResultsDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamResultsDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_exam_results';

    protected $fillable = [
        'group_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
