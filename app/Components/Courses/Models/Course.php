<?php

namespace App\Components\Courses\Models;

use App\Components\Modules\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'category',
        'price',
        'driving_hours',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class)
            ->where('course_module.deleted_at', '=', null)
            ->select([
                'modules.id',
                'modules.instructor_id',
                'modules.name',
                'modules.description',
                'modules.hours'
            ]);
    }

    protected $dates = ['deleted_at'];
}
