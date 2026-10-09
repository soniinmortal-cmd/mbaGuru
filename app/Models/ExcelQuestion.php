<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelQuestion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'test_id',
        'serial_no',
        'section_name',
        'tag',
        'positive_mark',
        'negative_mark',
        'level',
        'answer_time',
        'answer_explanation',
        'question',
        'question_type',
        'correct_option',
        'instruction',
        'option1',
        'option2',
        'option3',
        'option4',
        'option5',
        'criteria1',
        'percentage1',
        'criteria2',
        'percentage2',
        'criteria3',
        'percentage3',
        'criteria4',
        'percentage4',
        'criteria5',
        'percentage5',
        'video_link'
      
    ];
}
