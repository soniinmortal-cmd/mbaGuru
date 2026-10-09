<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use App\Models\Admin\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTables;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data   = Student::get_students();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('signed_on', function ($row) {
                    return !empty($row->signed_on) ? $row->signed_on : '----';
                })->addColumn('last_login', function ($row) {
                    return !empty($row->last_login) ? $row->last_login : '----';
                })->addColumn('status', function ($row) {
                    $str = '<span class="badge badge-success">Active</span>';
                    return $str;
                })->addColumn('action', function ($row) {

                    $btn = '<button data-toggle="tooltip" title="Edit" onclick="editStudent(' . $row->id . ')" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></button> <button data-toggle="tooltip" title="Delete" onclick="deleteStudent(' . $row->id . ')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>';

                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('Admin/add_student');
    }

    public function save(Request $request)
    {
        $id = $request->id;
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students']
        ];
        if(!empty($id)) {
            $rules['email'] = [
                'required',
                Rule::unique('students', 'email')->ignore($id),
            ];
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = [];
            foreach ($rules as $key => $value) {
                $errors[$key] = $validator->messages()->first($key);
            }
            return [
                'status' => 'error',
                'code' => 000,
                'message' => $errors,
                'data' => [],
            ];
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile
            ];
            if (!empty($data)) {
                if(!empty($id)) {
                    // update
                    $student = Student::find($id);
                    $student->name = $request->name;
                    $student->email = $request->email;
                    $student->mobile = $request->mobile;
                    $student->updated_by =  Auth::id();

                    if($student->save()) {
                        return [
                            'status' => 'success',
                            'code' => 111,
                            'message' => 'Student updated successfully.',
                            'data' => [],
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'code' => 000,
                            'message' => 'Something went wrong.',
                            'data' => [],
                        ];
                    }
                } else {
                    // insert
                    $data['created_by'] = Auth::id($data);
                    $res = Student::create($data);
                    if ($res) {
                        return [
                            'status' => 'success',
                            'code' => 111,
                            'message' => 'Student created successfully.',
                            'data' => [],
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'code' => 000,
                            'message' => 'Something went wrong.',
                            'data' => [],
                        ];
                    }
                }
            } else {
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Data missing.',
                    'data' => [],
                ];
            }
        }
    }

    public function student_list(Request $request) {
        if ($request->ajax()) {
            $data   = Student::get_students([ 'deleted_at' => null]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })->addColumn('email', function ($row) {
                    return $row->email;
                })->addColumn('mobile', function ($row) {
                    return $row->mobile;
                })->addColumn('signed_on', function ($row) {
                    return !empty($row->signed_on) ? $row->signed_on : '----' ;
                })->addColumn('last_login', function ($row) {
                    return !empty($row->last_login) ? $row->last_login : '----';
                })->addColumn('action', function ($row) {

                    $btn = '<button data-toggle="tooltip" title="Edit" onclick="editStudent('.$row->id.')" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></button> <button data-toggle="tooltip" title="Delete" onclick="deleteStudent('.$row->id.')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>';

                    return $btn;
                })
                ->escapeColumns([])
                ->make(true);
            // dd($data);
        }
        return view('Admin/student_list');
    }

    public function edit(Request $request) {
        $id = $request->id;
        if(!empty($id)) {
            $data = Student::where(['id' => $id])->first();
            if($data) {
                return [
                    'status' => 'success',
                    'code' => 111,
                    'message' => 'Data found.',
                    'data' => $data,
                ];
            } else {
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Data missing.',
                    'data' => [],
                ];
            }
        } else {
            return [
                'status' => 'error',
                'code' => 000,
                'message' => 'Something went wrong.',
                'data' => [],
            ];
        }
    }

    public function delete(Request $request) {
        $id = $request->id;
        if(!empty($id)) {
            $student = Student::find($id)->delete();
    
            if ($student) {
                return [
                    'status' => 'success',
                    'code' => 111,
                    'message' => 'Student deleted successfully.',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Data missing.',
                    'data' => [],
                ];
            }
        } else {
            return [
                'status' => 'error',
                'code' => 000,
                'message' => 'Something went wrong.',
                'data' => [],
            ];
        }
    }

    public function excel_upload(Request $request) {
        $file = $request->file('excel')->store('studentImportExcel');
        $res = Excel::import(new StudentImport,$file);
        if($res) {
            return [
                'status' => 'success',
                'code' => 111,
                'message' => 'Student Excel successfully.',
                'data' => [],
            ];
        } else {
            return [
                'status' => 'error',
                'code' => 000,
                'message' => 'Something went wrong.',
                'data' => [],
            ];
        }
    }

    public function getStatus($key = 1)
    {
        $data = [
            1 => 'Active',
            0 => 'Inactive'
        ];
        return $data[$key];
    }

   

}
