<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionbuilder extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'question_type',
        'paper_type',
        'question',
        'answer',
        'percentage',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
