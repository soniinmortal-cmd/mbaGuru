<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizDuration extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'duration',
        'all_duration',
        'verbal_time',
        'interp_time',
        'quantitative_time',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
}
