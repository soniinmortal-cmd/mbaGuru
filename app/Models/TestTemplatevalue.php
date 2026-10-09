<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTemplatevalue extends Model
{
    use HasFactory;
    protected $fillable = [
        'temp_id',
        'total_marks',
        'exam_duration',
        'total_question',
        'total_question_type',
        'total_section',
        'section_duration',
        'calculator_type',
        'exame_instruction',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
}
