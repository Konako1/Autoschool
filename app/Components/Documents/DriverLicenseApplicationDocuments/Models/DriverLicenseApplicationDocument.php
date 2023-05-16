<?php

namespace App\Components\Documents\DriverLicenseApplicationDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverLicenseApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_driver_license_application';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
