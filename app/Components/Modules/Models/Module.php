<?php

namespace App\Components\Modules\Models;

use App\Components\Instructors\Models\Instructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'modules';

    protected $fillable = [
        'instructor_id',
        'name',
        'description',
        'hours'
    ];

    public function instructor() {
        return $this->hasOne(Instructor::class, 'id', 'instructor_id')->first();
    }

    protected $dates = ['deleted_at'];
}
