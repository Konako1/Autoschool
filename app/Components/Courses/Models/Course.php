<?php

namespace App\Components\Courses\Models;

use App\Components\Categories\Models\Category;
use App\Components\Instructors\Models\Instructor;
use App\Components\Modules\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'price',
        'driving_hours',
        'category_id',
        'instructor_id',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class)
            ->where('course_module.deleted_at', '=', null)
            ->select([
                'modules.id',
                'modules.name',
                'modules.description',
                'modules.hours',
                'modules.metadata'
            ]);
    }

    public function instructor() {
        return $this->hasOne(Instructor::class, 'id', 'instructor_id')->first();
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id')->first();
    }

    protected $dates = ['deleted_at'];
}
