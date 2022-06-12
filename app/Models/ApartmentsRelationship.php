<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApartmentsRelationship extends Model
{
    use HasFactory,SoftDeletes;
    public $table = "apartments_relationship";
}
