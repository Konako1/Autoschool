<?php

namespace App\Components\Students\Models;

use App\Components\Exams\Models\Exam;
use App\Components\Instructors\Models\Instructor;
use App\Components\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'group_id',
        'instructor_id',
        'name',
        'surname',
        'patronymic',
        'birthday',
        'photo_path',
        'phone',
        'address',
        'gearbox_type',
    ];

    public function payments() {
        return $this->hasMany(Payment::class, 'student_id', 'id');
    }

    public function instructor() {
        return $this->hasMany(Instructor::class, 'id', 'instructor_id')->first();
    }

    public function exams() {
        return $this->hasMany(Exam::class, 'student_id', 'id')->get();
    }

    protected $dates = ['deleted_at'];
}
