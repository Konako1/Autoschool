<?php

namespace App\Components\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'payment_needed',
        'group_id',
        'name',
        'surname',
        'patronymic',
        'birthday',
        'photo_path',
        'phone',
        'address',
    ];

    protected $dates = ['deleted_at'];
}
