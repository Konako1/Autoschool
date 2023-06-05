<?php

namespace App\Components\Documents\GroupDebtDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupDebtDocument extends Model
{
    use SoftDeletes;

    protected $table = 'group_debt_documents';

    protected $fillable = [
        'group_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
