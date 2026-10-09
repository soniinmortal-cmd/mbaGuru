<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuize extends Model
{
    use HasFactory;
     protected $fillable = [
        'test_id',
        'user_id',
        'section_type',
        'student_duration',
        'ans_duration',
        'paper_id',
        'question_type',
        'question_id',
        'level',
        'answer',
        'set_type',
        'create_by',
        'update_by',
    ];
}
