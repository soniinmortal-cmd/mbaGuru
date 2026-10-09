<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasFactory;
      protected $fillable = [
        'name',
        'email',
        'mobile',
        'signed_on',
        'last_login',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
        
      
    ];
    
    
}



