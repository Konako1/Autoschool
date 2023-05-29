<?php

namespace App\Components\Lessons\Models;

use App\Components\Modules\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'title',
        'date',
        'module_id',
        'group_id',
    ];

    public function module() {
        return $this->hasOne(Module::class, 'id', 'module_id')->first();
    }

    protected $dates = ['deleted_at'];
}
