<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'course_id',
        'status',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
}
