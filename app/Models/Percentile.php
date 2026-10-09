<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentile extends Model
{
    use HasFactory;
    protected $fillable = [
        'score',
        'percentile',
        'section_type',
        'test_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
}
