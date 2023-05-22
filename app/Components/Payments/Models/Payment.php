<?php

namespace App\Components\Payments\Models;

use App\Components\Students\Models\Student;
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

    public function student() {
        return $this->hasOne(Student::class, 'id', 'student_id')->first();
    }

    protected $dates = ['deleted_at'];
}
