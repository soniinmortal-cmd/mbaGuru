<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentQuize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class StudentRecordController extends Controller
{


//      public function savequizedata(Request $request)
//     {
//        // if(Auth::guard('student')->check()){
//             //dd(auth()->guard('student'));
//         //}
// $email = $email = Auth::guard('student')->id();
// //$email =$request->session()->get('key');
// dd($email);
//      $values = array(
//         'test_id' => $request['test_id'],
//         'user_id' => $request->user_id,
//         'answer_review' => $request->answer_review,
//         'question_id' => implode(',', $request->question_id),
//         'answer' =>  implode(',', $request->answer),
//         'question_type' => implode(',', $request->question_type)
            
//      );
//         StudentQuize::create($values);
//    // $this->createEntry($data);
//     return response()->json([
//         'success' => true,
//         'message' => 'Data successfully submitted',
//     ]);
//   }
}
