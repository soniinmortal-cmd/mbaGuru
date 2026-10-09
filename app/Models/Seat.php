<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
     protected $fillable = [
        'course_id',
        'test_id',
        'seats',
        'from_date',
        'to_date',
        'from_time',
        'to_time',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
