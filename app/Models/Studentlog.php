<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Studentlog extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'batch_code',
        'admissiondate',
        'dateofbirth',
        'address',
        'centercode',
        'college',
        'role_id',
        'status',
        'create_by',
        'update_by',
        'session_id',
    ];



}
