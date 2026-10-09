<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportExcelWord extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'importvalue',
        'filename',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
}
