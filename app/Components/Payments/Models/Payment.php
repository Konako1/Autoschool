<?php

namespace App\Components\Payments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'value',
        'date',
        'student_id',
    ];

    protected $dates = ['deleted_at'];
}
