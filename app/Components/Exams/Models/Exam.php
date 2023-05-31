<?php

namespace App\Components\Exams\Models;

use App\Components\Modules\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = 'exams';

    protected $fillable = [
        'name',
        'mark',
        'student_id',
        'module_id',
        'date',
    ];

    public function module() {
        return $this->hasOne(Module::class, 'id', 'module_id')->first();
    }

    protected $dates = ['deleted_at'];
}
