<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SentMail extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'sent_email';
    protected $fillable = [
        'to','cc', 'bcc', 'subject', 'content'
    ];
}
