<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotify extends Model
{
    use HasFactory;
    public $table = 'push_notification';
    protected $fillable = [
        'receive_id',
        'category',
        "item_id",
        "title",
        "body",
        "type_user",
        "click_action"
    ];
}
