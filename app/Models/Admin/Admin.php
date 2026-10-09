<?php

namespace App\Models\Admin;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
         
        'name',
        'email',
        'mobile',
        'role_id',
        'status',
        'create_by',
        'update_by',
        'password',
        'remember_token',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    

}


