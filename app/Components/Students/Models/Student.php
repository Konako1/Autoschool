<?php

namespace App\Components\Students\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'payment_needed',
        'group_id',
        'name',
        'surname',
        'middle_name',
        'birthday',
        'photo_path',
        'phone',
        'address',
    ];
}
