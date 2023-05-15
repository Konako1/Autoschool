<?php

namespace App\Components\Documents\WaybillDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaybillDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_waybill';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
