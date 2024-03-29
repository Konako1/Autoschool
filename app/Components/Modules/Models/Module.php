<?php

namespace App\Components\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'modules';

    protected $fillable = [
        'name',
        'description',
        'metadata',
        'hours'
    ];

    protected $dates = ['deleted_at'];
}
