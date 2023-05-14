<?php

namespace App\Components\Documents\ServiceDeliveryActDocuments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDeliveryActDocument extends Model
{
    use SoftDeletes;

    protected $table = 'documents_service_delivery_act';

    protected $fillable = [
        'student_id',
        'name',
        'path',
        'type',
    ];

    protected $dates = ['deleted_at'];
}
