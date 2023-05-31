<?php

namespace App\Components\Cars\Models;

use App\Components\Categories\Models\Category;
use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'reg_number',
        'gearbox_type',
        'category_id'
    ];

    protected $dates = ['deleted_at'];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id')->first();
    }

    protected static function newFactory(): CarFactory
    {
        return new CarFactory();
    }
}
