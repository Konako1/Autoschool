<?php

namespace App\Components\Documents\RegistrationOrderDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationOrderDocument extends Model
{
    use SoftDeletes;

    protected $table = 'registration_order_documents';

    protected $fillable = [
        'group_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
