<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'username',
        'password',
        'centercode',
        'batchcode',
        'catyear',
        'admissiondate',
        'dateofbirth',
        'address',
        'college',
        'signed_on',
        'last_login',
        'status',
        'created_by',
        'updated_by',
         'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function get_students( $where = [], $column = 'students.id', $order = 'DESC', $limit = 0)
    {
        if ($limit > 0) {
            $data = Student::where($where)->orderBy($column, $order)->limit($limit)->get(['students.*']);
        } else {
            $data = Student::where($where)->orderBy($column, $order)->get(['students.*']);
        }

        return $data;
    }
}
