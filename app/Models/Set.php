<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;
    protected $fillable = [
        'setname',
        'course_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
    ];
}
