<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotifyRelationship extends Model
{
    use HasFactory;

    public $table = 'push_notify_relationship';
    protected $fillable = [
        'apartment_id',
        'push_notify_id',
    ];
    public $timestamps = false;

}
