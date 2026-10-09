<?php

namespace App\Http\Controllers\Admin;
use Response;
use App\Imports\ImportAdmin;
use App\Imports\ImportWordExcel;
use App\Imports\ExceQuestionImport;
use App\Imports\PercentileImport;
use App\Imports\ImportAssignCourse;
use App\Exports\ExportAdmin;
use App\Exports\ExportUser;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Admin;
use App\Models\QuizDuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Set;
use App\Models\Test;
use App\Models\ImportExcelWord;
use App\Models\Percentile;
use App\Models\PublishStatus;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Storage;
use App\Models\ExcelQuestion;
use DB;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Studentlog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;


class AdminController extends Controller
{
    //


    //  public function logincount(Studentlog $user)
    // {
    //     $onlineUsers = $user->visits()->count();
        
    //     return view('student.dashboard', compact('onlineUsers'));
    // }

    public function index()
    {
        // $user_id = 11; 
        // $newPassword = 'mbaguru@123'; 
        // $hashedPassword = Hash::make($newPassword);
        // DB::table('admins')
        //     ->where('id', $user_id)
        //     ->update(['password' => $hashedPassword]);
        //     die("updated");

        if (Auth::guard('admin')->check()) {

           return redirect('/admin/dashboard');
        }
        return view('admin/login');
    }

    public function login(Request $request)
    {
        
        $rules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ];

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
            if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                return [
                    'status' => 'success',
                    'code' => 111,
                    'message' => 'Logged in successfully.',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Invalid credential.',
                    'data' => [],
                ];
            }
        }
    }

    public function dashboard()
    {
       // $onlineUsers = $user->visits()->count();
       //      return view('admin/dashboard', compact('onlineUsers'));
        return view('admin/dashboard');
    }

    public function register()
    {
        return view('admin/register');
    }

    public function register_code(Request $request)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
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
                'name' => 'Admin',rand(1,9999),
                'email' => $request->email,
                'password' => $request->password
            ];
            
            if (!empty($data)) {
                $res = Admin::create($data);
                if ($res) {
                    return [
                        'status' => 'success',
                        'code' => 111,
                        'message' => 'User created successfully.',
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
                return [
                    'status' => 'error',
                    'code' => 000,
                    'message' => 'Data missing.',
                    'data' => [],
                ];
            }
        }
    }
    
    
    public function save(Request $request)
    {
        
          $request->validate([
           'batch_code' => ['required', 'string', 'regex:/^\S*$/u'], // no spaces allowed
            ], [
                'batch_code.regex' => 'Batch code cannot contain spaces.',
            ]);

        $emailname =  DB::table('studentlogs')->where('email',$request->email)->first();
        if(isset($emailname) && $emailname->email == $request->email){
            $message =  'student already exists';

        }else{
            $input =array(
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "password" => Hash::make($request->password),
                "show_password" => $request->password,
                "batch_code" => $request->batch_code, 
                "admissiondate" => $request->admissiondate,
                "dateofbirth" => $request->dateofbirth,
                "address" => $request->address, 
                "catyear" => $request->catyear,
                "centercode" => $request->centercode,
                "college" => $request->college
            );
            $record = DB::table('studentlogs')->insert($input);
           $message =  'student created Successfully!!!';

        }
        return redirect()->route('admin.studentcreation')->with('message', $message);
      //  return back();
    }
    
    // public function studentcreation(Request $request)
    // {
    //      $search = $request->input('search');
    //      $post = DB::table('studentlogs')
    //       ->where('email', 'LIKE', "%{$search}%")
    //       // ->orWhere('body', 'LIKE', "%{$search}%")
    //       ->get();
    //     if(!empty($search)){
    //         $record =  $post;
    //     }else{
    //          $record = DB::table('studentlogs')
    //      ->select('id','name','email','mobile','password','show_password','batch_code','admissiondate','dateofbirth','address')
    //      ->orderBy('id', 'desc')
    //      ->get();   
    //     }
    //     return view('admin/studentcreation',compact('record'));
    // }
     public function studentcreation(Request $request)
    {
         $search = $request->input('search');
         $post = DB::table('studentlogs')
           ->where('email', 'LIKE', "%{$search}%")
          // ->orWhere('body', 'LIKE', "%{$search}%")
          ->get();
        if(!empty($search)){
            $record =  $post;
        }else{
             $record = DB::table('studentlogs')
         ->select('id','name','email','mobile','password','show_password','batch_code','catyear','admissiondate','dateofbirth','address','centercode','college')
         ->orderBy('id', 'desc')
         ->get();   
        }
        return view('admin/studentcreation',compact('record'));
    }
    public function delete(Request $request,$id)
    {    
          $record = DB::table('studentlogs')->delete($id);
            return back()->with('success','Item deleted successfully!');
          
    }
     public function deleteCourse($id)
    {    
          $record = DB::table('testuploading')->delete($id);
          DB::table('tests')->where('course_id', $id)->delete();
           return redirect()->back()->with('message', 'Course deleted successfully!');  
          
    }
  public function  deletequestion(Request $request,$id)
    {       
          
          $record = DB::table('excel_questions')->delete($id);
            return back()->with('success','Question deleted successfully!');
          
    }

    public function testuploading(Request $request)
    {
        $input = array(
        "title" => $request->title,
        "price" => $request->price
        );
       // alert(name);
        $record = DB::table('testuploading')->insert($input);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    
    

    public function forget_password() {
        return view('Admin/forget_password');
    }

    public function forget_password_code(Request $request)
    {
        //dd($request->all());
    }

    public function reset_password()
    {
        return view('Admin/reset_password');
    }

    public function reset_password_code(Request $request)
    {
       // dd($request->all());
    }
    public function import(Request $request) 
    {
    return view('admin.excel');
    }
    public function importWordExcel($id) 
    {
       $testid = $id;
    return view('admin.importwordexcel')->with(array('testid'=>$testid));;
    }
    
    // public function import2() 
    // {
    //     ini_set('max_execution_time', 00);
    //     ini_set('memory_limit', '512M');
    //     try{
    //        Excel::import(new ImportAdmin,request()->file('file')); 

    //        return redirect()->back()->with('message', 'User Imported Successfully.');  
    //     }catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //        // dd($e->getMessage());   
    //           
    //           //old

    //            //$failures =     $e->getMessage();
    //          // return redirect()->back()->with('message', 'Email already exists !!');  
    //     }
    //      //  Excel::import(new ImportAdmin,request()->file('file'));
    //      // return back();
    // }


    public function import2() 
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
       

        $import = new ImportAdmin; 
          //dd($import);
        $importedData = Excel::import($import, request()->file('file'));
    
        $errors = $import->getErrors();
        
       
        if ($errors->isNotEmpty()) {
           // if(!empty($errors[0])){
                $value = $errors[0];
           // }
        //return redirect()->back()->with('message', $value); 
        return redirect()->back()->with('message', 'User Imported Successfully.'); 
        }else{
        return redirect()->back()->with('message', 'User Imported Successfully.'); 
        }
    }

    
    public function export(Request $request){
       return Excel::download(new ExportAdmin, 'users.xlsx');
      
    }
   
    
    public function newTest($id) 
    {
        return view('admin.newtest');
    }
    public function setCreation(Request $request) 
    {
        $course_id =request()->id;
        $values = array('course_id' => $request->course_id, 'setname' => $request->setname);
        DB::table('sets')->insert($values);
        return back();
    }
    public function setdelete($id) 
    {
        $testname =  DB::table('tests')
                    ->where('set_id',$id)
                    ->get();
        foreach($testname as $testd){
            DB::table('publish_statuses')->where('test_id', $testd->id)->delete();
            DB::table('proctored')->where('test_id', $testd->id)->delete();
        }

        $set=Set::find($id);
        $set->delete();

        Test::where('set_id', $id)->delete();

       
                 

        return back();
    }
    public function testcreation(Request $request)
    {
        //dd($request->all());
        $setid = $request->set_id;
        $testname =  DB::table('tests')->where('set_id',$setid)->orderBy('id', 'desc')->first();
        if($testname == null){
            $inc ="1";
        }else{
            $inc = $testname->testincid+1; 
        }
        $request->validate([
            'set_id' => 'required',
            'test' => 'required',
            'testtempid' => 'required'
        ]);
        $values = array(
            'set_id' => $request->set_id, 
            'test' => $request->test,
            'testtempid' => $request->testtempid,
            'testincid' => $inc,
            'course_id' => $request->course_id
        );
      // $tests = DB::table('tests')->insert($values);
        $testsid =   Test::create($values);
        $insertedId = $testsid->id;
        $setId = $testsid->set_id;

        $values1 = array(
            'test_id' => $insertedId,
            'course_id' => $request->course_id, 
            'status' => 4
        );
        DB::table('publish_statuses')->insert($values1);
         $values2 = array(
            'test_id' => $insertedId,
            'course_id' => $request->course_id, 
            'status' => 0
        );
        DB::table('proctored')->insert($values2);
        return json_encode(array(
            "statusCode"=>200,
            "id"=>$insertedId,
            "setid"=>$setId,
        ));
    }
     public function saveTestUploading(Request $request) 
    {
       // $course_id =request()->id;
        $values = array('title' => $request->title, 'price' => $request->price);
        DB::table('testuploading')->insert($values);
       // return back();
        return json_encode(array(
            "statusCode"=>200,
            "status"=>1
        ));
    }
    public function setEdit(Request $request) 
    {
        $request->validate([
            'setname' => 'required'
        ]);
        DB::table('sets')
        ->where('id',$request->id)
        ->update(array(
            'setname'=>$request->setname,
        ));
        return json_encode(array(
            "statusCode"=>200
        ));
    }
    public function testDelete($id) 
    {
        $test=Test::find($id);
        $test->delete();
        DB::table('publish_statuses')->where('test_id', $id)->delete();
        DB::table('proctored')->where('test_id', $id)->delete();
        return back();
    }
    public function testBuilder($id) 
    {
        $tests = DB::table('tests')->where('id',$id)->first();
          $total_verbal = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%VERBAL%")
                        ->count();
         $total_data = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%DATA%")
                        ->count();
         $total_qt = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%QUANTITATIVE%")
                        ->count();
                       // dd($total_verbal);
        $total_language  = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%Language %")
                        ->count();
        $total_qs  = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%Quantitative Skills%")
                        ->count();
        $total_logical  = DB::table('excel_questions')
                            ->where('test_id',$id)
                             ->where('section_name', 'like', "%Logical %")
                            ->count();
        return view('admin.testbuilder')->with(array('tests'=>$tests,'total_verbal'=>$total_verbal,'total_data'=>$total_data,'total_qt'=>$total_qt,'total_language'=>$total_language,'total_qs'=>$total_qs,'total_logical'=>$total_logical));
    }
   public function savePercentile(Request $request) 
    {
        $rdata = session()->get('val');
        try {
            $import = new PercentileImport;
            $importedData = Excel::import($import, request()->file('file'));
            return redirect()->back()->with('message', 'Save Successfully !!');  
   
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
          $failures =     $e->getMessage();
          return redirect()->back()->with('message', 'The score already exists !!');
        }    
   }

    // public function saveExcelWord(Request $request) 
    // {
    //     $id = $request->test_id;
    //     Excel::import(new ExceQuestionImport,request()->file('file'));      
    //     //return back();
    //     return redirect()->route('admin.testbuilder', $id)->with('message', 'Question Save Successfully!!!');
    // }
    
     public function saveExcelWord(Request $request) 
    {
        $id = $request->test_id;
        Excel::import(new ExceQuestionImport,request()->file('file'));      
        //return back();
        //return redirect()->route('admin.testbuilder', $id)->with('message', 'Question Save Successfully!!!');
        return redirect()->back()->with('message', 'Question Save Successfully!!!');

   }
   

    public function publishStatus($id) 
    {
        return view('admin.publishstatus')->with(array('id'=>$id));

    }
    public function savePublish(Request $request) 
    {
        //$test_id =request()->id;
        $values = array('test_id' => $request->test_id,'course_id' => $request->course_id, 'status' => $request->status,'start_date' => $request->start_date,'end_date' => $request->end_date);
        DB::table('publish_statuses')->insert($values);
        //return back();
        return back()->with('success', 'upload successfully!');
    }
    public function testinstantimport()
    {
        $filepath = public_path('\assets\admin\QuestionsImportTemplate-v4.xlsx');
        //$file = Storage::disk('local')->url('app/files/SampleStudentExcel'); 
        // $csvData = file_get_contents($file);
        // $rows = array_map("str_getcsv", explode("\n",$csvData));
        // $header = array_shift($rows);
        // dd($header);

        $file = fopen($filepath, "r");
            if ($file) {
                $contents = fread($file, filesize($filepath));
                fclose($file);
                //dd($contents);
            }
        return view('admin.testinstantimport')->with(array('file'=>$file));
    }

    public function questionbuilder()
    {
        return view('admin.questionbuilder');
    }

    public function savequestion(Request $request) 
    {
        $this->validate($request, [
            'question' => 'required',
        ]);
        if($request->percentage){
            $percentage = $request->percentage;
        }else{
            $percentage = array(0);
        }
        if($request->criteria){
             $criteria = $request->criteria;
         }else{
            $criteria = array(0);
         }
         if($request->answer){
          $answer = $request->answer;
         }else
         {
            $answer = array(0);
         }

        $values = array(
            'test_id' => $request->test_id, 
            'question_type' => $request->question_type,
            'section_name' => $request->section_name,
            'answer_time' => $request->answer_time,
            'positive_mark' => $request->positive_mark,
            'negative_mark' => $request->negative_mark,
            'tag' => $request->tag,
            'instruction' => $request->instruction,
            'answer_time' => $request->answer_time,
            'question' => $request->question,
            'answer_explanation' => $request->answer_explanation,
            'level' => $request->level,
            'correct_option' => $request->correct_option,
            'percentage' => implode(',', $percentage),
            'answer' =>  implode(',', $answer),
            'criteria' =>  implode(',', $criteria),
            'status' => $request->status,
            'video_link' => $request->video_link,
            'option1'=> $request->option1,
            'option2'=> $request->option2,
            'option3'=> $request->option3,
            'option4'=> $request->option4,
            'option5'=> $request->option5,
        );
        DB::table('excel_questions')->insert($values);
         return redirect()->back()->with('message', 'Save Successfully!!');
    
    }
     public function saveCutoff(Request $request) 
    {
       // dd($request->all());
        $values = array(
            'test_id' => $request->test_id, 
            'student_email' => $request->student_email,
            'verbal_cutoff' => $request->verbal_cutoff,
            'data_cutoff' => $request->data_cutoff,
            'quantitative_cutoff' => $request->quantitative_cutoff,
            'overall_cutoff' => $request->overall_cutoff,

            'language_cutoff' => $request->language_cutoff,
            'qs_cutoff' => $request->qs_cutoff,
            'logical_cutoff' => $request->logical_cutoff,
            'overall_cutoff_nmat'=>$request->overall_cutoff_nmat,
      );
        DB::table('cutoff')->insert($values);
        return redirect()->back()->with('message', 'Save Successfully!!');
    }
     public function updateQuestion(Request $request) 
    {
        if($request->percentage){
            $percentage = $request->percentage;
        }else{
            $percentage = array(null);
        }
        if($request->criteria){
             $criteria = $request->criteria;
         }else{
            $criteria = array(null);
         }
         if($request->answer){
          $answer = $request->answer;
         }else
         {
            $answer = array(null);
         }
        if(!empty($request->option1)|| (!empty($request->percentage1))){
         $status = null;   
        }else{
          $status=  $request->status;  
        }
        $values = array(
            'test_id' => $request->test_id, 
            'question_type' => $request->question_type,
            'section_name' => $request->section_name,
            'answer_time' => $request->answer_time,
            'positive_mark' => $request->positive_mark,
            'negative_mark' => $request->negative_mark,
            'tag' => $request->tag,
            'instruction' => $request->instruction,
            'answer_time' => $request->answer_time,
            'question' => $request->question,
             'option1' => $request->option1,
              'option2' => $request->option2,
           'option3' => $request->option3,
            'option4' => $request->option4,
             'option5' => $request->option5,
            'answer_explanation' => $request->answer_explanation,
            'level' => $request->level,
            'correct_option' => $request->correct_option,
            'percentage' => implode(',', $percentage),
            'answer' =>  implode(',', $answer),
            'criteria' =>  implode(',', $criteria),
            'status' => $status,
             'video_link' => $request->video_link
        );
       DB::table('excel_questions')->where('id',$request->id)->update($values);
      //  DB::table('excel_questions')->insert($values);
        return redirect()->back()->with('message', 'Question Edit Successfully!!');
       // return back()->with('message', 'question Save Successfully!!!');
    }
    public function editquestion($urlid,$id,$sr) 
    {
          $question = DB::table('excel_questions')
                        ->where('id',$id)
                        ->first();
               if(empty($question->id))
               {
                $id = $id-1;
                $sr = $sr-1;
                $last = 1;
                $question = DB::table('excel_questions')
                ->where('id',$id)
                ->first();
               }else{
                $id = $id;
                $sr = $sr;
                $last = 0;
               }
        return view('admin.editquestion')->with(array('question'=>$question,'id'=>$id,'sr'=>$sr,'last'=>$last,'urlid'=>$urlid));
    }
    public function editstudent($id) 
    {
         $students = DB::table('studentlogs')
                    ->where('id',$id)
                    ->first();
        return view('admin.editstudent')->with(array('students'=>$students));
    }
    // public function editstudentdata(Request $request) 
    // {
    //     DB::table('studentlogs')
    //     ->where('id',$request->id)
    //     ->update(array(
    //       'name'=>$request->name,
    //       'email'=>$request->email,
    //       'password'=>Hash::make($request->show_password),
    //       'show_password'=>$request->show_password,
    //       'mobile'=>$request->mobile,
    //       'dateofbirth'=>$request->dateofbirth,
    //       'admissiondate'=>$request->admissiondate,
    //       'address'=>$request->address
    //         ));
    // //  Students::where('id',$request->id)->update(['nem'=>$request->name,'email'=>$request->email,'mobile'=>$request->mobile,'dateofbirth'=>$request->dateofbirth,'address'=>$request->address]);
    //       return redirect()->back()->with('message', 'Edit Successfully!');
    // }
    
    public function editstudentdata(Request $request) 
    {
        DB::table('studentlogs')
        ->where('id',$request->id)
        ->update(array(
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>Hash::make($request->show_password),
           'show_password'=>$request->show_password,
           'mobile'=>$request->mobile,
           'dateofbirth'=>$request->dateofbirth,
           'admissiondate'=>$request->admissiondate,
           'address'=>$request->address,
           'batch_code'=>$request->batch_code,
            'catyear'=>$request->catyear,
            'centercode'=>$request->centercode
        ));
    //  Students::where('id',$request->id)->update(['nem'=>$request->name,'email'=>$request->email,'mobile'=>$request->mobile,'dateofbirth'=>$request->dateofbirth,'address'=>$request->address]);
           return redirect()->back()->with('message', 'Edit Successfully!');
    }
    
    public function preview($ques_type, $id) 
    { 
       //dd($ques_type);
       // $q_type = str_replace('%20',"",$ques_type);
        $questions = DB::table('questionbuilders')
                    ->where('test_id',$id)
                    //->where('question_type','like', '%'.$ques_type.'%')
                    //->where('question_type', '=', $ques_type)
                    ->get();
                  // dd($question);        
        return view('admin.preview')->with(array('questions'=>$questions,'ques_type'=>$ques_type));
    }
    public function seriesbuilder($id) 
    {
        $series = DB::table('tests')
            ->join('sets', 'sets.id', '=', 'tests.set_id')
            ->join('testuploading', 'testuploading.id', '=', 'sets.course_id')
            ->select('tests.*','sets.setname','testuploading.title')
            ->where('tests.id',$id)
            ->first();
        return view('admin.seriesbuilder')->with(array('series'=>$series));
    }
    
    
     public function percentileCutoff($id) 
    {
        // $series = DB::table('tests')
        //     ->join('sets', 'sets.id', '=', 'tests.set_id')
        //     ->join('testuploading', 'testuploading.id', '=', 'sets.course_id')
        //     ->select('tests.*','sets.setname','testuploading.title')
        //     ->where('tests.id',$id)
        //     ->first();
        return view('admin.percentile-cutoff');
    }
    
    
    public function createCenter() 
    {
        return view('admin.create-center');
    }
    public function Center() 
    {
         $centers = DB::table('centers')->get();
          // dd($pool);
        return view('admin.center')->with(array('centers'=>$centers));
    }

     public function savecenter(Request $request) 
    {
        $values = array(
                'centername' => $request->centername,
                'status' => 'Active'
        );
        DB::table('centers')->insert($values);
        return redirect()->route('admin.center')->with('message', 'Save Successfully!!!');
    }
    public function editCenter($id) 
    {
         $center = DB::table('centers')->where('id',$id)->first();
        return view('admin.edit-center')->with(array('center'=>$center));
    }
    public function updateCenter(Request $request) 
    {
        $id = $request->id;
      //  dd($id);

        DB::table('centers')->where('id',$id)->update(array(
            'centername'=>$request->centername,
        ));
        return redirect()->route('admin.edit-center',$id)->with('message', 'Update Successfully!!!');
    }
     public function deleteCenter($id) 
    {
           $record = DB::table('centers')->delete($id);
         return redirect()->route('admin.center')->with('message', 'Delete Successfully!!!');
    }
    public function editTest($id) 
    {
         $tests = DB::table('tests')->where('id',$id)->first();
       return view('admin.edit-test')->with(array('tests'=>$tests));
    }

      public function editTestRecord(Request $request) 
    {
        Test::where('id',$request->id)->update(['test'=>$request->test,'testincid'=>$request->testincid]);
         $testid =  DB::table('tests')->where('id',$request->id)->first();
            return redirect()->route('admin.newtest',$testid->course_id)->with('success', 'Test Edit Successfully!');
    }

    public function editCourse($id) 
    {
         $tests = DB::table('testuploading')->where('id',$id)->first();
         //dd($tests);
       return view('admin.edit-course')->with(array('tests'=>$tests));
    }

    public function editCourseRecord(Request $request) 
    {
        //Test::where('id',$request->id)->update(['title'=>$request->title]);
        DB::table('testuploading')
            ->where('id',$request->id)
            ->update(array(
            'title'=>$request->title,
        ));
        $courses =  DB::table('testuploading')->where('id',$request->id)->first();
        // return view('admin.test-uploading')
        // return redirect()->route('admin.test-uploading')->with('success', 'Test Edit Successfully!');
       // return view('admin.edit-course')->with(array('tests'=>$tests));
       return view('admin.test-uploading')->with(array('courses'=>$courses));
    }


    public function instruction($id) 
    {
         //$tests = DB::table('tests')->where('id',$id)->first();
       return view('admin.instruction')->with(array('id'=>$id));
    }

    public function saveInstruction(Request $request)
    {
         $values = array('instruction' => $request->instruction,'test_id'=>$request->test_id);
        DB::table('instruction')->insert($values);
        return back()->with('success', 'save successfully!');
    }

    public function saveSeriesBuilder(Request $request) 
    {
        $id =$request->test_id;
        if($request->attachments){
            $lession_thumb = time() . '.' . $request->attachments->extension();
            $request->attachments->move(public_path('admin/image'), $lession_thumb);
        }
        if($request->lession_thumb){
            $attachments = time() . '.' . $request->lession_thumb->extension();
            $request->lession_thumb->move(public_path('admin/image'), $attachments); 
        }
        $values = array(
            'test_id' => $request->test_id,
            'title' => $request->title, 
            'test_tag' => $request->test_tag,
            'test_type' =>  $request->test_type,
            's_description' =>  $request->s_description,
            'l_description' =>  $request->l_description,
            'lession_thumb' =>  $lession_thumb,
            'lession_url' =>  $request->lession_url,
            'attachments' =>  $attachments,
            'form_url' =>  $request->form_url,
            'add_link' =>  $request->add_link,
        );
            DB::table('series_builders')->insert($values);
            $test = $request->title;
            DB::table('tests')->where('id',$id)->update(array(
                'test'=>$test,
            ));
        return back()->with('success', 'upload successfully!');
    }

    public function edittime(Request $request) 
    {
        //dd($request->all());
        // $request->validate([
        //     'setname' => 'required'
        // ]);
        DB::table('test_templatevalues')
        ->where('temp_id',2)
        ->update(array(
            'exam_duration'=>$request->exam_duration,
        ));
        return json_encode(array(
            "statusCode"=>200
        ));
    }
    

    public function settings($id) 
    {
         return view('admin.settings')->with(array('id'=>$id));
        return redirect()->back()->with('message', 'Question Save Successfully!!');
       // return back()->with('message', 'question Save Successfully!!!');
    }



    public function duration($id) 
    {
         return view('admin.duration')->with(array('id'=>$id));
    }
    public function quizduration(Request $request) 
    {
        $id = $request->test_id;
        $quiz = new QuizDuration;
        $quiz->test_id = $request->test_id;
        $quiz->duration = $request->duration;
        $quiz->all_duration = $request->all_duration;
        $quiz->verbal_time = $request->verbal_time;
        $quiz->interp_time = $request->interp_time;
        $quiz->quantitative_time = $request->quantitative_time;
        
        $quiz->language_time = $request->language_time;
        $quiz->qs_time = $request->qs_time;
        $quiz->logical_time = $request->logical_time;
        $quiz->save();
        return redirect()->route('admin.duration', $id)->with('message', 'Duration Save Successfully!!!');
    }

    public function upload(Request $request) 
    {
         //dd($request);
        if($request->hasfile('upload'))
        {
            $originName = $request->file('upload')->getClientOriginalName();

            $filename = pathinfo($originName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtensiton();
            $filename = $filename.'-'. time().'.'.$extension;
            $request->file('upload')->move(public_path('media'),$filename);
            $url = assets('media/'.$filename);
            return response()->json(['filename'=>$filename,'uploaded'=>1,'url'=>$url]);
        }
    }

    public function saveWord(Request $request)  
    {
        $id = $request->test_id;
        if($request->importvalue ==1){

         $file = $request->file('filename');

         $namewithextension1= $file->getClientOriginalName();
         $namewithextension  =  time()  .$namewithextension1;

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
        $phpWord->save(storage_path('app/files/'.$namewithextension));
        /// dd($namewithextension);
        }
       $values = array(
        'test_id' => $request->test_id, 
        'importvalue' => $request->importvalue,
        'filename' => $namewithextension
        );
       $data =  ImportExcelWord::create($values);
       $lastId = $data->id;
      // dd($lastInsertId);
        $impo = DB::table('import_excel_words')->where('id',$lastId)->first();
        $filen =  $impo->filename;
        $this->getWord($filen);
         return redirect()->route('admin.importwordexcel', $id)->with('message', 'Question Save Successfully!!!');
    }

   

// public function getWord($filen)
// {
       
//     //$filename = storage_path('app\files\1691753042QuestionImportTemplate-v4.docx');
//       //   $filename =  public_path('images/1691753042QuestionImportTemplate-v4.docx');
//         $filename1 = storage_path('app\files');
//         $filename = $filename1.'/'.$filen;
//       $zip = new \ZipArchive();
     
     
//       if ($zip->open($filename)) {
//           $content = $zip->getFromName("word/document.xml");
//           $zip->close();
//           $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
//           $content = str_replace('</w:r></w:p>', "\n", $content);
          
//           $content = strip_tags($content);
//           // echo'<pre>';
//           //   print_r($content);
//           //   die;         
//           $result = explode("\n", $content);

//           foreach($result as $key => $results)
//           {
//             $mydata[$key] =  $results;
//           }

//             $newtest_id =  array();
//             $newinc = array();
//             $newqus = array();
//             $section = array();
//             $positive = array();
//             $negative = array();
//             $level = array();
//             $type = array();
//             $correctoption = array();
//             $answerexplanation = array();
//             $option1 = array();
//             $option2 = array();
//             $option3 = array();
//             $option4 = array();
//             $criteria1 = array();
//             $criteria2 = array();
//             $criteria3 = array();
//             $criteria4 = array();
//             $criteria5 = array();
//             $percentage1 = array();
//             $percentage2 = array();
//             $percentage3 = array();
//             $percentage4 = array();
//             $percentage5 = array();
//             foreach($mydata as $d_key=> $d_val){
//                 if (str_contains($d_val, 'test_id')) {
//                     $test_id = str_replace("[", '', $d_val);
//                     $test_id1 = str_replace("test_id", '', $test_id);
//                     $test_id2 = str_replace("]", '', $test_id1);
//                     $newtest_id[] = $test_id2;

//                 }
//                 if (str_contains($d_val, 'instruction')) {
//                     $inc = str_replace("[", '', $d_val);
//                     $inc1 = str_replace("instruction", '', $inc);
//                     $inc2 = str_replace("]", '', $inc1);
//                     $newinc[] = $inc2;
                   
//                 }
//                 if (str_contains($d_val, 'Question')) {
//                     $qus = str_replace("[", '', $d_val);
//                     $qus1 = str_replace("Question", '', $qus);
//                     $qus2 = str_replace("]", '', $qus1);
//                     $newqus[] = $qus2;
//                 }
//                 if (str_contains($d_val, 'SectionName')) {
//                     $sect = str_replace("[", '', $d_val);
//                     $sect1 = str_replace("SectionName", '', $sect);
//                     $sect2 = str_replace("]", '', $sect1);
//                     $section[] = $sect2;
//                 }
//                 if (str_contains($d_val, 'Positive')) {
//                     $posi = str_replace("[", '', $d_val);
//                     $posi1 = str_replace("Positive", '', $posi);
//                     $posi2 = str_replace("]", '', $posi1);
//                     $positive[] = $posi2;
//                 }
//                 if (str_contains($d_val, 'Negative')) {
//                     $negat = str_replace("[", '', $d_val);
//                     $negat1 = str_replace("Negative", '', $negat);
//                     $negat2 = str_replace("]", '', $negat1);
//                     $negative[] = $negat2;
//                 }
//                 if (str_contains($d_val, 'Level')) {
//                     $leve = str_replace("[", '', $d_val);
//                     $leve1 = str_replace("Level", '', $leve);
//                     $leve2 = str_replace("]", '', $leve1);
//                     $level[] = $leve2;
//                 }
//                 if (str_contains($d_val, 'AnswerTime')) {
//                     $at = str_replace("[", '', $d_val);
//                     $at1 = str_replace("AnswerTime", '', $at);
//                     $at2 = str_replace("]", '', $at1);
//                     $answertime[] = $at2;
//                 }
//                 if (str_contains($d_val, 'Type')) {
//                     $ty = str_replace("[", '', $d_val);
//                     $ty1 = str_replace("Type", '', $ty);
//                     $ty2 = str_replace("]", '', $ty1);
//                     $type[] = $ty2;
//                 }
//                  if (str_contains($d_val, 'CorrectOption')) {
//                     $co = str_replace("[", '', $d_val);
//                     $co1 = str_replace("CorrectOption", '', $co);
//                     $co2 = str_replace("]", '',$co1);
//                     $correctoption[] = $co2;
//                 }

//                 if (str_contains($d_val, 'AnswerExplanation')) {
//                     $ae = str_replace("[", '', $d_val);
//                     $ae1 = str_replace("AnswerExplanation", '', $ae);
//                     $ae2 = str_replace("]", '',$ae1);
//                     $answerexplanation[] = $ae2;
//                 }
//                 if (str_contains($d_val, 'Option1')) {
//                     $op1 = str_replace("[", '', $d_val);
//                     $op11 = str_replace("Option1", '', $op1);
//                     $op12 = str_replace("]", '',$op11);
//                     $option1[] = $op12;
//                 }
//                 if (str_contains($d_val, 'Option2')) {
//                     $op2 = str_replace("[", '', $d_val);
//                     $op21 = str_replace("Option2", '', $op2);
//                     $op22 = str_replace("]", '',$op21);
//                     $option2[] = $op22;
//                 }
//                  if (str_contains($d_val, 'Option3')) {
//                     $op3 = str_replace("[", '', $d_val);
//                     $op31 = str_replace("Option3", '', $op3);
//                     $op32 = str_replace("]", '',$op31);
//                     $option3[] = $op32;
//                 }
//                 if (str_contains($d_val, 'Option4')) {
//                     $op4 = str_replace("[", '', $d_val);
//                     $op41 = str_replace("Option4", '', $op4);
//                     $op42 = str_replace("]", '',$op41);
//                     $option4[] = $op42;
//                 }
//                 if (str_contains($d_val, 'CRITERIA1')) {
//                     $crit1 = str_replace("[", '', $d_val);
//                     $crit11 = str_replace("CRITERIA1", '', $crit1);
//                     $crit12 = str_replace("]", '',$crit11);
//                     $criteria1[] = $crit12;
//                 }
//                 if (str_contains($d_val, 'CRITERIA2')) {
//                     $crit2 = str_replace("[", '', $d_val);
//                     $crit21 = str_replace("CRITERIA2", '', $crit2);
//                     $crit22 = str_replace("]", '',$crit11);
//                     $criteria2[] = $crit22;
//                 }
//                 if (str_contains($d_val, 'CRITERIA3')) {
//                     $crit3 = str_replace("[", '', $d_val);
//                     $crit31 = str_replace("CRITERIA3", '', $crit3);
//                     $crit32 = str_replace("]", '',$crit31);
//                     $criteria3[] = $crit32;
//                 }
//                 if (str_contains($d_val, 'CRITERIA4')) {
//                     $crit4 = str_replace("[", '', $d_val);
//                     $crit41 = str_replace("CRITERIA4", '', $crit4);
//                     $crit42 = str_replace("]", '',$crit41);
//                     $criteria4[] = $crit42;
//                 }
//                 if (str_contains($d_val, 'CRITERIA5')) {
//                     $crit5 = str_replace("[", '', $d_val);
//                     $crit51 = str_replace("CRITERIA5", '', $crit5);
//                     $crit52 = str_replace("]", '',$crit51);
//                     $criteria5[] = $crit52;
//                 }
//                 if (str_contains($d_val, 'PERCENTAGE1')) {
//                     $per1 = str_replace("[", '', $d_val);
//                     $per11 = str_replace("PERCENTAGE1", '', $per1);
//                     $per12 = str_replace("]", '',$per11);
//                     $percentage1[] = $per12;
//                 }
//                 if (str_contains($d_val, 'PERCENTAGE2')) {
//                     $per2 = str_replace("[", '', $d_val);
//                     $per21 = str_replace("PERCENTAGE2", '', $per2);
//                     $per22 = str_replace("]", '',$per21);
//                     $percentage2[] = $per22;
//                 }
//                 if (str_contains($d_val, 'PERCENTAGE3')) {
//                     $per3 = str_replace("[", '', $d_val);
//                     $per31 = str_replace("PERCENTAGE3", '', $per3);
//                     $per32 = str_replace("]", '',$per31);
//                     $percentage3[] = $per32;
//                 }
//                 if (str_contains($d_val, 'PERCENTAGE4')) {
//                     $per4 = str_replace("[", '', $d_val);
//                     $per41 = str_replace("PERCENTAGE4", '', $per4);
//                     $per42 = str_replace("]", '',$per41);
//                     $percentage4[] = $per32;
//                 }
//                 if (str_contains($d_val, 'PERCENTAGE5')) {
//                     $per5 = str_replace("[", '', $d_val);
//                     $per51 = str_replace("PERCENTAGE5", '', $per5);
//                     $per52 = str_replace("]", '',$per51);
//                     $percentage5[] = $per52;
//                 }

//             }
          

//         foreach($newtest_id as $item => $value){
//             $data[$value]=array(

//                         'test_id'=>$newtest_id[$item],
//                         'question'=> $newqus[$item],
//                         'instruction'=>$newinc[$item],
//                         'section_name'=>$section[$item],
//                         'positive_mark'=>$positive[$item],
//                         'negative_mark'=>$negative[$item],
//                         'level'=>$level[$item],
//                         'answer_time'=>$answertime[$item],
//                         'question_type'=>$type[$item],
//                         'correct_option'=>$correctoption[$item],
//                         'answer_explanation'=>$answerexplanation[$item],
//                         'option1'=>$option1[$item],
//                         'option2'=>$option2[$item],
//                         'option3'=>$option3[$item],
//                         'option4'=>$option4[$item],

//                         'criteria1'=>$criteria1[$item],
//                         'criteria2'=>$criteria2[$item],
//                         'criteria3'=>$criteria3[$item],
//                         'criteria4'=>$criteria4[$item],
//                         'criteria5'=>$criteria5[$item],

//                         'percentage1'=>$percentage1[$item],
//                         'percentage2'=>$percentage2[$item],
//                         'percentage3'=>$percentage3[$item],
//                         'percentage4'=>$percentage4[$item],
//                         'percentage5'=>$percentage5[$item],
//                 ); 
//                 ExcelQuestion::insert($data);
//             }   
//         }
//       return 1;
//     }

    public function maximumAttempt($id) 
    {
        $testid = $id;
        $attempt = DB::table('maximum_attempt_count')->where('test_id',$testid)->first();
        return view('admin.maximum-attempt')->with(array('testid'=>$testid,'attempt'=>$attempt));
    }

  public function savemMaximumAttempt(Request $request) 
    {
        $id =$request->test_id;

           $ma = DB::table('maximum_attempt_count')
                    ->where('test_id',$id)
                   ->orderBy('id', 'desc')
                    ->first();
                   // $lastId = $data->id;
                if($ma){
                        DB::table('maximum_attempt_count')->where('id',$ma->id)->update(array(
                                'maximum_attempt'=>$request->maximum_attempt,
                            ));
                     return redirect()->route('admin.maximum-attempt', $id)->with('message', 'Update Successfully!!!');

                }else{
                     $values = array(
                            'test_id' => $request->test_id,
                            'maximum_attempt' => $request->maximum_attempt, 
                          
                        );
                         $data = DB::table('maximum_attempt_count')->insert($values);
                    return redirect()->route('admin.maximum-attempt', $id)->with('message', 'Save Successfully!!!');
                }
            return redirect()->route('admin.maximum-attempt', $id)->with('message', 'Something went wrong!!!');
    }


    public function saveProctored(Request $request)
    {
        $proc = DB::table('proctored')
                    ->where('test_id',$request->test_id)
                    ->where('course_id',$request->course_id)
                    ->first();
        if($proc)
        {
            if($proc->status == 1){
                $statuss = 0;
                $procyy = $proc->pro_code;
            }else{
                 $statuss = 1;
                 $procyy = rand(10,1000000);
            }
        }
                 
        if($proc){
          $insert =  DB::table('proctored')
            ->where('test_id',$proc->test_id)
             ->where('course_id',$proc->course_id)
             ->where('pro_code',$proc->pro_code)
            ->update(array(
                'status'=>$statuss,
                'pro_code'=>$procyy,
            ));
        }else{
             $values = array(
                'test_id' => $request->test_id,
                'course_id' => $request->course_id, 
                'status' => 1,
                'pro_code' => $request->pro_code
            );
           $insert = DB::table('proctored')->insert($values);   
        }
       if($insert){
         return json_encode(array(
            "statusCode"=>200,
             "id"=>$request->test_id
        ));

       }else{
         return json_encode(array(
            "statusCode"=>201
        ));
       }
    }

    public function slotBooking(Request $request)
    {
        $courses = DB::table('testuploading')->get();
        
        $centers = DB::table('centers')->get();
        return view('admin.slot-booking')->with(array('courses'=>$courses,'centers'=>$centers));
    }

    public function fetchTest(Request $request)
    {
        $data['test'] = Test::where("course_id", $request->course_id)
                                    ->get(["test", "id"]);
                                      
        return response()->json($data);
    }
    public function fetchSeat(Request $request)
    {
        $data = DB::table('seats')
                    ->where('test_id',$request->test_id)
                    ->where('course_id',$request->course_id)
                    ->first();
                                      
        return response()->json($data);
    }
    public function saveSeat(Request $request)
    {
        $seat = DB::table('seats')
                    ->where('test_id',$request->test_id)
                    ->where('course_id',$request->course_id)
                    ->where('center_id',$request->center_id)
                    ->where('from_date',$request->from_date)
                    ->orderBy('id','desc')
                    ->first();
        if($seat){
            $insert = DB::table('seats')
                  ->where('test_id',$seat->test_id)
                  ->where('course_id',$seat->course_id)
                   ->where('id',$seat->id)
                  ->update(array(
                'from_date' => $request->from_date,
                //'to_date' => $request->to_date,
                'from_time' => implode(',', $request->from_time),
                'to_time' => implode(',', $request->to_time),
                'seats' => $request->seats,
                'center_id' => $request->center_id
            ));
        }else{
            $data1 = array();
            $date1 = $request->from_date;
            $date2 = $request->to_date;
            $startDate = Carbon::createFromFormat('Y-m-d', $date1);
            $endDate = Carbon::createFromFormat('Y-m-d', $date2);
            $daterange = CarbonPeriod::create($startDate, $endDate);
            $daterange->toArray();
            foreach ($daterange as $date)
             {
              
                $data1[] =  $date->format('Y-m-d'); 
            }
            foreach($data1 as $item => $value){
               
                $data =array(
                    'test_id' => $request->test_id,
                    'course_id' => $request->course_id, 
                    'from_date' => $value,
                    'from_time' => implode(",",$request->from_time),
                    'to_time' => implode(",",$request->to_time),
                    'seats' => $request->seats,
                    'center_id' => $request->center_id
                );
               $insert = DB::table('seats')->insert($data);
            }
        }
if($insert){
    return redirect()->route('admin.show-seat')->with('message', 'Add Successfully!!!');
 }else{
    return redirect()->route('admin.show-seat')->with('message', 'Something went wrong!!!');
 }
        
          
    }
    public function showSeat(Request $request)
    {
        $seats = DB::table('seats')
                ->leftjoin('testuploading', 'seats.course_id', '=', 'testuploading.id')
                ->leftjoin('tests', 'seats.test_id', '=', 'tests.id')
                 ->leftjoin('centers', 'seats.center_id', '=', 'centers.id')
                ->select('seats.*', 'testuploading.title', 'tests.test', 'centers.centername')
                //->orderBy('seats.from_date','asc')
                ->get();
               // dd($seats);
        return view('admin.show-seat')->with(array('seats'=>$seats)); 
    }

    public function editSeat($id)
    {
        $seats = DB::table('seats')
                ->where('id',$id)
                ->first();
        $courses = DB::table('testuploading')->get();
         $tests = DB::table('tests')->get();
        $centers = DB::table('centers')->get();
             
       return view('admin.edit-seat')->with(array('seats'=>$seats,'courses'=>$courses,'centers'=>$centers,'tests'=>$tests)); 
    }
    public function deleteSeat($id)
    {
        $record = DB::table('seats')->delete($id);
         return redirect()->route('admin.show-seat')->with('message', 'Delete Successfully!!!');
    }

     public function bookingReport(Request $request)
     {

        $reports = DB::table('student_booking')
                    ->leftjoin('tests', 'student_booking.test_id', '=', 'tests.id')
                    ->join('testuploading', 'testuploading.id', '=', 'student_booking.course_id')
                    ->join('studentlogs', 'studentlogs.id', '=', 'student_booking.user_id')
                    ->join('centers', 'centers.id', '=', 'student_booking.center_id')
                    ->select('student_booking.*','testuploading.title','studentlogs.email','centers.centername','tests.test')
                    ->orderBy('student_booking.id','desc')
                    ->get();

        return view('admin.booking-report')->with(array('reports'=>$reports)); 
    }

    public function showCourse(Request $request)
    {
        $courses = DB::table('testuploading')->get();
         
        return view('admin.show-course')->with(array('courses'=>$courses));
    }

    public function showTest(Request $request)
    {
        $id = request()->id;
        $tests = DB::table('tests')->where('course_id',$id)->get();
         
        return view('admin.showtest')->with(array('tests'=>$tests));
    }
    public function studentReport(Request $request)
    {
        
       // $reports =  $this->fetchReport($id,$section_name);
        return view('admin.student-report');
    }

    
    public function fetchReport(Request $request)
    {
        $id = $request->id;
        $section_name = $request->section_name; 
        $var_1='';
        $muser_id = array();
        $newreports = DB::table('student_quizes')
                      ->where('test_id',$id)
                      ->get();
                      
        foreach($newreports as $newreport){
            $muser_id[] = $newreport->user_id;
        }
        
        $users = DB::table('studentlogs')
                    ->whereIn('id',$muser_id)
                    ->orderBy('id','desc')
                    ->get();
                $i=1;
        foreach($users as $user)
        {
            if($section_name == 'overall'){
                $extest1 = DB::table('excel_questions')
                          ->where('test_id', $id)
                          ->where('section_name', 'like', "%verbal%")
                          ->get();
                          
                $extest2 = DB::table('excel_questions')
                          ->where('test_id', $id)
                          ->where('section_name', 'like', "%data%")
                          ->get();
                          
                $extest3 = DB::table('excel_questions')
                          ->where('test_id', $id)
                          ->where('section_name', 'like', "%quantitative%")
                          ->get();
            }else{
                $extest = DB::table('excel_questions')
                         ->where('test_id', $id)
                         ->where('section_name', 'like', "%$section_name%")
                         ->get();
            }
        if($section_name == 'overall'){
             $ex_correct1 = array();
             $ex_correct2 = array();
             $ex_correct3 = array();
             
            $stu_id = array();
            $stu_ans = array();
            
            $positive1 = array();
            $negative1 = array();
            
            $positive2 = array();
            $negative2 = array();
            
            $positive3 = array();
            $negative3 = array();
            
            $timedata = array();
            $timedata = array();
            foreach($extest1 as $extests)
            {
                 $ex_correct1[] = $extests->correct_option;
                 $positive1[] = $extests->positive_mark;
                 $negative1[] = $extests->negative_mark;
            } 
             foreach($extest2 as $extests)
            {
                 $ex_correct2[] = $extests->correct_option;
                 $positive2[] = $extests->positive_mark;
                 $negative2[] = $extests->negative_mark;
            }
            
             foreach($extest3 as $extests)
            {
                 $ex_correct3[] = $extests->correct_option;
                 $positive3[] = $extests->positive_mark;
                 $negative3[] = $extests->negative_mark;
            }
            
            $ex_correct = array_merge($ex_correct1, $ex_correct2, $ex_correct3);
            $positive = array_merge($positive1, $positive2, $positive3);
            $negative = array_merge($negative1, $negative2, $negative3);
             }else{
            $ex_correct = array();
            $stu_id = array();
            $stu_ans = array();
            
            $positive = array();
            $negative = array();
            
            $timedata = array();
            $timedata = array();
                foreach($extest as $extests)
                {
                 $ex_correct[] = $extests->correct_option;
                 $positive[] = $extests->positive_mark;
                 $negative[] = $extests->negative_mark;
                } 
             }
            if($section_name =='overall'){
                // $reports = DB::table('student_quizes')
                //             ->where('test_id',$id)
                //           //->where('section_type', 'like', "%$section_name%")
                //             ->where('user_id',$user->id)
                //             ->get();
                
                
              $subQuery = DB::table('student_quizes')
    ->select('section_type', DB::raw('MAX(id) as max_id'))
    ->where('test_id', $id)
    ->where('user_id', $user->id)
    //->where('paper_id', $paperid)
    ->groupBy('section_type');


$reports = DB::table('student_quizes')
    ->joinSub($subQuery, 'latest', function ($join) {
        $join->on('student_quizes.id', '=', 'latest.max_id');
    })
    ->where('student_quizes.test_id', $id)
    ->where('student_quizes.user_id', $user->id)
  //  ->where('student_quizes.paper_id', $paperid)
    ->orderByRaw("CASE 
        WHEN student_quizes.section_type = 'verbal' THEN 1
        WHEN student_quizes.section_type = 'data' THEN 2
        WHEN student_quizes.section_type = 'quantitative' THEN 3
        ELSE 4
    END")
    ->orderBy('student_quizes.id')
    ->get();
    
                $qid = array();
                $sid = array();
                $tid = array();
                $timedatasnwe = array();
                foreach($reports as $report)
                {
                    $stu_id =   explode(",",$report->question_id);
                    
                    $stu_ans =  explode(",",$report->answer);
                    //$timedata = [$report->ans_duration];
                    $timedata = explode(",",$report->ans_duration);
                    foreach($stu_id as $stu_idss)
                    {
                      $qid[] =  $stu_idss;   
                    }
                    foreach($stu_ans as $stu_ans){
                      $sid[] =  $stu_ans; 
                    }
                    foreach($timedata as $timedatas){
                      $timedatasnwe[] =  $timedatas;
                    }
                }

            }else{
                $reports = DB::table('student_quizes')
                        ->where('test_id',$id)
                        ->where('section_type', 'like', "%$section_name%")
                        ->where('user_id',$user->id)
                        ->get();
                        
                foreach($reports as $report)
                {
                    $stu_id =  explode(",",$report->question_id);
                    $stu_ans =  explode(",",$report->answer);
                  //$timedata = [$report->ans_duration]; 
                    $timedata =  explode(",",$report->ans_duration);
                }
            }
            if($section_name == 'overall'){
                 $all_ans = array_filter($sid);
                 $ex_correct = array_map('strtolower', $ex_correct);
                 $all_ans = array_map('strtolower', $all_ans);
                 $acorrect = array_intersect_assoc($ex_correct, $all_ans);
                 $miss = count($qid)-count($all_ans);  
                 $incorrect =  count($all_ans) - count($acorrect);
                 $pos = array_intersect_key($positive,$acorrect);
                  //start
                 $ansarray = array_filter($sid, function($value) {
                              return $value !== '';
                             });
                            $array1 =($ex_correct);
                            $array2 = ($sid);
                            $result = array();

                            foreach ($array2 as $key=>$value) {
                                if ($key !== null && array_key_exists($key, $array1)) {
                                    $result[] = $array1[$key];
                                }
                            }

                            $mismatch_values = array();
                            foreach ($result as $key => $value) {
                                if (isset($ansarray[$key]) && $ansarray[$key] !== $value) {
                                    $mismatch_values[$key] = $ansarray[$key];
                                }
                            }
                $neg = array_intersect_key($negative,$mismatch_values);
                //end
                // $neg = array_intersect_key($negative,$acorrect);
                 $sumpos = array_sum($pos);
                 $sumneg = array_sum($neg);
                 $score = $sumpos-$sumneg;
                 $total = array_intersect_key($positive,$qid);
                 $to = count($total);
                if($to ==0){
                    $to = 1;
                }else{
                    $to = $to;
                }
                //$per = ($score)/($to)*100;
                if(count($all_ans) == 0){
                    $per = 0;
                }else{
                     $per = (count($acorrect)/count($all_ans))*100;
                }
                //$timevalue =   array_sum($timedata);
                if (!is_array($timedatasnwe)) {
                // Try to decode it if it’s a JSON string
                if (is_string($timedatasnwe) && $decoded = json_decode($timedatasnwe, true)) {
                    $timedatasnwe = $decoded;
                } else {
                    // If it's a comma-separated string like "10,20,30"
                    if (is_string($timedatasnwe) && str_contains($timedatasnwe, ',')) {
                        $timedatasnwe = explode(',', $timedatasnwe);
                    } else {
                        // Force it to be an empty array if invalid
                        $timedatasnwe = [];
                    }
                }
            }

// Make sure all elements are numeric
$timedatasnwe = array_map('floatval', $timedatasnwe);

$timevalue = array_sum($timedatasnwe);

                 $timevalue =  array_sum($timedatasnwe); 
                 $totime = ($timevalue / 1000);
            }else{
                $all_ans = array_filter($stu_ans);
                $ex_correct = array_map('strtolower', $ex_correct);
                $all_ans = array_map('strtolower', $all_ans);
                $acorrect = array_intersect_assoc($ex_correct,$all_ans);  
                $miss = count($stu_id)-count($all_ans); 
                $incorrect =  count($all_ans) - count($acorrect);
                $pos = array_intersect_key($positive,$acorrect);
                //start
                 $ansarray = array_filter($stu_ans, function($value) {
                              return $value !== '';
                            });
                            $array1 =($ex_correct);
                            $array2 = ($stu_ans);
                            $result = array();
                            foreach ($array2 as $key=>$value) {
                                if ($key !== null && array_key_exists($key, $array1)) {
                                    $result[] = $array1[$key];
                                }
                            }
                            $mismatch_values = array();
                            foreach ($result as $key => $value) {
                                if (isset($ansarray[$key]) && $ansarray[$key] !== $value) {
                                    $mismatch_values[$key] = $ansarray[$key];
                                }
                            }
                           
                $neg = array_intersect_key($negative,$mismatch_values);
                //$neg = array_intersect_key($negative,$acorrect);
                $sumpos = array_sum($pos);
                $sumneg = array_sum($neg);
                $score = $sumpos-$sumneg;
                $total = array_intersect_key($positive,$stu_id);
                $to = count($total);
                if($to ==0){
                    $to = 1;
                }else{
                    $to = $to;
                }
                 if(count($all_ans) == 0){
                    $per = 0;
                }else{
                     $per = (count($acorrect)/count($all_ans))*100;
                }
              // $per = ($score)/($to)*100;
                $timevalue =   array_sum($timedata);  
                //$totime = date("H:i:s", $timevalue / 1000);
                $totime = ($timevalue / 1000);  
            }
             $var_1 .= '<tr><td>'.$i++.'</td><td>'.
            '<a href ="https://test.mbaguru.in/admin/show-question/'.$id.'/'.$user->id.'">'.$user->email.'</a></td><td>';
            if($request->section_name == 'overall')
            {
                $var_1 .= count($qid);
            }else{
                $var_1 .= count($stu_id);
            }
            $var_1 .= '</td>'.
            '<td>'.count($all_ans).'</td><td>'.$miss.'</td><td>'.count($acorrect).'</td>'.
            '<td>'.$incorrect.'</td><td>'.$score.'</td><td>'.round($per,2).'</td>'.
            '<td>'.$totime.'</td></tr>';
        } 
        $var_1 = array('var_1' => $var_1);
        echo json_encode($var_1);  
    }
    
    // public function fetchReport11(Request $request)
    // {
    //     $id = $request->id;
    //     $section_name = $request->section_name; 
    //     $var_1 = '';
    //     $muser_id = [];
        
    //     // Fetch user IDs from student_quizes table
    //     $newreports = DB::table('student_quizes')
    //                 ->where('test_id', $id)
    //                 ->pluck('user_id');
                    
    //     $muser_id = $newreports->toArray();
        
    //     // Fetch user details
    //     $users = DB::table('studentlogs')
    //                 ->whereIn('id', $muser_id)
    //                 ->orderBy('id', 'desc')
    //                 ->get();
    
    //     $i = 1;
    //     foreach ($users as $user) {
    //         if($section_name =='overall'){
    //                 $reports = DB::table('student_quizes AS sq1')
    //                     ->where('sq1.test_id', $id)
    //                     ->where('sq1.user_id', $user->id)
    //                     ->whereRaw("sq1.id = (SELECT MAX(sq2.id) FROM student_quizes AS sq2 WHERE sq2.test_id = sq1.test_id AND sq2.user_id = sq1.user_id AND sq2.section_type = sq1.section_type)")
    //                     ->orderBy('sq1.section_type', 'desc')
    //                     ->get();
                   
    //         }else{
                
    //              $reports = DB::table('student_quizes AS sq1')
    //                     ->where('sq1.test_id', $id)
    //                     ->where('sq1.user_id', $user->id)
    //                     ->whereRaw("sq1.id = (SELECT MAX(sq2.id) FROM student_quizes AS sq2 WHERE sq2.test_id = sq1.test_id AND sq2.user_id = sq1.user_id AND sq2.section_type = sq1.section_type)")
    //                     ->where('sq1.section_type', 'like', "%$section_name%")
    //                     ->orderBy('sq1.section_type', 'desc')
    //                     ->get();
    //         }
    //                     // echo'<pre>';
    //                     // print_r($reports);
    //         $stu_id = [];
    //         $stu_ans = [];
    //         $timedata = [];
    
    //         foreach ($reports as $report) 
    //         {
    //             $stu_id = array_merge($stu_id, explode(",", $report->question_id));
    //             $stu_ans = array_merge($stu_ans, explode(",", $report->answer));
    //             $timedata = array_merge($timedata, explode(",", $report->ans_duration));
    //         }
    
    //         // Fetch questions for section_name
    //         if ($section_name == 'overall') {
    //             $sections = ['verbal','data','quantitative'];
    //             $extests = [];
    //             foreach ($sections as $section) {
    //                 $extests[$section] = DB::table('excel_questions')
    //                                     ->where('test_id', $id)
    //                                     ->where('section_name', 'like', "%$section%")
    //                                     ->get();
    //             }
    //         } else {
    //             $extests = DB::table('excel_questions')
    //                         ->where('test_id', $id)
    //                         ->where('section_name', 'like', "%$section_name%")
    //                         ->get();
    //         }
    
    //         // Calculate scores
    //         $ex_correct = [];
    //         $positive = [];
    //         $negative = [];
    
    //         if ($section_name == 'overall') {
    //             foreach ($sections as $section) {
    //                 foreach ($extests[$section] as $extest) {
    //                   $ex_correct[] = strtolower($extest->correct_option);
    //                     //$ex_correct = array_map('strtolower', $ex_correct);
    //                     $positive[] = $extest->positive_mark;
    //                     $negative[] = $extest->negative_mark;
    //                 }
    //             }
    //         } else {
    //             foreach ($extests as $extest) {
    //                 $ex_correct[] = strtolower($extest->correct_option);
    //                 $positive[] = $extest->positive_mark;
    //                 $negative[] = $extest->negative_mark;
    //             }
    //         }
    
    //         $all_ans = array_filter(array_map('strtolower', $stu_ans));
    //         $acorrect = array_intersect_assoc($ex_correct, $all_ans);
    //         $miss = count($stu_id) - count($all_ans);
    //         $incorrect = count($all_ans) - count($acorrect);
    //         $pos = array_intersect_key($positive, $acorrect);
    //         $neg = array_intersect_key($negative, array_diff_assoc($all_ans, $acorrect));
    
    //         $sumpos = array_sum($pos);
    //         $sumneg = array_sum($neg);
    //         $score = $sumpos - $sumneg;
    //         $total = array_intersect_key($positive, $stu_id);
    //         $to = count($total) ?: 1;
    //         $per = count($all_ans) ? (count($acorrect) / count($all_ans)) * 100 : 0;
    //         $timevalue = array_sum($timedata) / 1000;
           
    //         // Create Table Row
    //         $var_1 .= '<tr><td>' . $i++ . '</td><td>' .
    //             '<a href="https://test.mbaguru.in/admin/show-question/' . $id . '/' . $user->id . '">' . $user->email . '</a></td><td>' .
    //             count($stu_id) . '</td>' .
    //             '<td>' . count($all_ans) . '</td><td>' . $miss . '</td><td>' . count($acorrect) . '</td>' .
    //             '<td>' . $incorrect . '</td><td>' . $score . '</td><td>' . round($per, 2) . '</td>' .
    //             '<td>' . $timevalue . '</td></tr>';
    //     }
    //     echo json_encode(['var_1' => $var_1]);
    // }

    public function showQuestion(Request $request)
    {
        return view('admin.show-question');
    }

    public function fetchQuestion(Request $request)
    {
        $var_1='';
        $id = $request->id;
        $userid = $request->userid;
        $section_name = $request->section_name;
        $stuques = DB::table('student_quizes')
                    ->where('test_id', $id)
                    ->where('user_id',$userid)
                    ->where('section_type', 'like', "%$section_name%")
                    ->first();
                    
        $qids = explode(',',$stuques->question_id);
        $ans = explode(',',$stuques->answer);
        //$ang =  array_filter($anss);

        $exques = DB::table('excel_questions')
                ->where('test_id', $id)
                ->where('section_name', 'like', "%$section_name%")
               //->where('section_name', 'like', "VERBAL ABILITY AND READING COMPREHENSION")
                ->get();
        $i =1;
        foreach($exques as $key=>$que)
        {
            $var_1 .=  '<tr>';
            $var_1 .=  '<td>'.$i++.'</td>';
            if(isset($ans[$key]) && $ans[$key] === $que->correct_option) {
                $var_1 .= '<td>Correct</td>';
            }elseif(empty($ans[$key])){
                $var_1 .= '<td>Not-Attempted</td>';
            }else{
                $var_1 .= '<td>Worng</td>';
            }
             $var_1 .=  '</tr>';
        }
        $var_1 = array('var_1' => $var_1);
        echo json_encode($var_1); 
    }
    public function deleteStudent($id)
    {
        $record = DB::table('studentlogs')->delete($id);
        return back()->with('message','Item deleted successfully!');
    }
    
    public function reportExcel(Request $request)
    {
        return view('admin.report-excel'); 
        //return view('admin.report-excel')->with(array('reports'=>$reports)); 
    }


    public function assignTest(Request $request) 
    {
        $search = $request->input('search');
        $post = DB::table('studentlogs')
                    ->where('email', 'LIKE', "%{$search}%")
                    ->orWhere('name','LIKE', "%{$search}%")
                    ->get();

        if(!empty($search)){
                $students =  $post;
        }else{
                $students = DB::table('studentlogs')->orderBy('id','desc')->get();
        }
       return view('admin.assign-test')->with(array('students'=>$students));
    }

    public function assignUser(Request $request)
    {
        $user_id = request()->id;
        $user = DB::table('studentlogs')->where('id',$user_id)->first();
        $assign_tests = DB::table('assign_test')
                        //->join('testuploading', 'testuploading.title', '=', 'assign_test.course_id')
                         ->select('course_id','status')
                         ->groupBy('course_id','status')
                         ->where('email',$user->email)
                         ->get();
        return view('admin.assign-user')->with(array('assign_tests'=>$assign_tests));
    }
    public function assignProduct(Request $request)
    {
        //$user_id = request()->id;
        $courses = DB::table('testuploading')->get();
        return view('admin.assign-product')->with(array('courses'=>$courses));
    }

    public function saveProduct(Request $request)
    {
        $users = $request->user_id;
        $user = DB::table('studentlogs')->where('id',$users)->first();
        $course_id = $request->course_id;
        $assign_users = DB::table('assign_test')
                        ->where('email',$user->email)
                        ->where('course_id',$course_id)
                        //->where('status',1)
                        ->first();
       if(isset($assign_users))
       {
            $insert =  DB::table('assign_test')
                ->where('email',$user->email)
                ->where('course_id',$course_id)
                ->update(array(
                    'status'=>1,
                )); 
        }else{
            $value = array(
                'email' => $user->email,
                'course_id' =>$course_id,
                'status' => 1
                
            );
            DB::table('assign_test')->insert($value);
        } 
        // return json_encode(array(
        //     "statusCode"=>200
        // ));
        return redirect()->route('admin.assign-product', $users)->with('message', 'Assign Successfully!!');
    }

    public function updateAssignUser(Request $request)
    {
        $users = $request->user_id;
        $user = DB::table('studentlogs')->where('id',$users)->first();
        $course_id = $request->course_id;
        $status = $request->status;
        $insert =  DB::table('assign_test')
                    ->where('email',$user->email)
                    ->where('course_id',$course_id)
                    ->update(array(
                        'status'=>$status,
                    )); 
       if($insert)
       {
            return json_encode(array(
                "statusCode"=>200
            ));

       }else{
            return json_encode(array(
                "statusCode"=>201
            ));
       }
        
    }

    public function exportUser(Request $request)
    {
        return Excel::download(new ExportUser, 'usersdata.xlsx');
    }

     public function assignTestImport(Request $request) 
     {
        $import = new ImportAssignCourse; 
        $importedData = Excel::import($import, request()->file('file'));
        $errors = $import->getErrors();
        if ($errors->isNotEmpty()) {
           // if(!empty($errors[0])){
                $value = $errors[0];
           // }
            return redirect()->back()->with('message', $value); 
        }else{
            return redirect()->back()->with('message', 'Assign Successfully !!'); 
        }
           
    }
    
    public function studentExcelReport(Request $request)
    {
        return view('admin.student-excel-report');
    }
    

    // public function downloadExcel(Request $request)
    // {
    //     $html = $request->input('html');
    //     //dd($html);
    //     return Excel::download(new class($html) implements FromCollection {
    //         private $html;

    //         public function __construct($html)
    //         {
    //             $this->html = $html;
    //         }

    //         public function collection()
    //         {
    //             // Parse the HTML table data into an array
    //             $table = new \DOMDocument();
    //             $table->loadHTML($this->html);
    //             $xpath = new \DOMXPath($table);
    //             $rows = $xpath->query('//table//tr');

    //             $data = [];
    //             foreach ($rows as $row) {
    //                 $rowData = [];
    //                 foreach ($row->childNodes as $cell) {
    //                     $rowData[] = $cell->nodeValue;
    //                 }
    //                 $data[] = $rowData;
    //             }

    //             // Convert the array into a collection
    //             return collect($data);
    //         }
    //     }, 'table_data.xlsx');
    // }

//with attempt data
    // public function downloadExcel(Request $request)
    // {
    //     try {
    //         $html = $request->input('html');
    
    //         // Check if HTML content is empty
    //         if (empty($html)) {
    //             throw new \Exception("HTML content is empty");
    //         }
    
    //         // Parse the HTML table data into an array
    //         $table = new \DOMDocument();
    
    //         // Suppress errors during HTML loading to prevent them from being displayed
    //         libxml_use_internal_errors(true);
    //         $table->loadHTML($html);
    //         libxml_use_internal_errors(false);
    
    //         // Initialize XPath
    //         $xpath = new \DOMXPath($table);
    
    //         // Query table rows
    //         $rows = $xpath->query('//table//tr');
    
    //         $data = [];
    //         foreach ($rows as $row) {
    //             $rowData = [];
    //             foreach ($row->childNodes as $cell) {
    //                 $rowData[] = $cell->nodeValue;
    //             }
    //             $data[] = $rowData;
    //         }
    
    //         // Convert the array into a collection
    //         return Excel::download(new class($data) implements FromCollection {
    //             private $data;
    
    //             public function __construct($data)
    //             {
    //                 $this->data = $data;
    //             }
    
    //             public function collection()
    //             {
    //                 return collect($this->data);
    //             }
    //         }, 'table_data.xlsx');
    //     } catch (\Exception $e) {
    //         // Handle exceptions
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    public function downloadExcel(Request $request)
{
    try {
        $html = $request->input('html');

        // Check if HTML content is empty
        if (empty($html)) {
            throw new \Exception("HTML content is empty");
        }

        // Parse the HTML table data into an array
        $table = new \DOMDocument();
        // Suppress errors during HTML loading to prevent them from being displayed
        libxml_use_internal_errors(true);
        $table->loadHTML($html);
        libxml_use_internal_errors(false);

        // Initialize XPath
        $xpath = new \DOMXPath($table);

        // Query table rows
        $rows = $xpath->query('//table//tr');

        $data = [];
        foreach ($rows as $row) {
            $rowData = [];
            foreach ($row->childNodes as $cell) {
                $rowData[] = $cell->nodeValue;
            }
            $data[] = $rowData;
        }

        // Debugging output
        // dd($data);

        // Convert the array into a collection
        return Excel::download(new class($data) implements FromCollection {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return collect($this->data);
            }
        }, 'table_data.xlsx');
    } catch (\Exception $e) {
        // Handle exceptions
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function clearCache()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
    
        return response()->json(['message' => 'Cache cleared successfully']);
    }
    
    public function testPdf(Request $request)
    {
         $id = request()->id;
         $pdfs = DB::table('test_pdfs')->where('test_id',$id)->get();
         return view('admin.test-pdf')->with(array('pdfs'=>$pdfs));
        
    }
    
    public function cerateTestPdf(Request $request)
    {
        $id = request()->id;
         $pdfs = DB::table('test_pdfs')->where('test_id',$id)->first();
          return view('admin.create-test-pdf')->with(array('pdfs'=>$pdfs));
    }
    
   public function savePdf(Request $request)
    {
         $request->validate([
            'file' => 'required|file|mimes:pdf',
          ]);
           if ($request->hasFile('file')) {
                $image = $request->file('file');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('assets/excel-formate');
                $image->move($destinationPath, $image_name);
               }else{
                   $image_name = NULL;
               }
        //  $pdfs = DB::table('test_pdfs')->where('test_id',$request->test_id)->first();
        //  if($pdfs){
        //       DB::table('test_pdfs')
        //     ->where('test_id',$request->test_id)
        //     ->update(array(
        //         'file'=>$image_name,
        //     ));
             
        //  }else{
               $values = array(
                    'test_id'=>$request->test_id,
                    'file' => $image_name, 
                    'pdf_name'=>$request->pdf_name,
                );
               
            DB::table('test_pdfs')->insert($values);  
             
         //}
            return back()->with('message', 'File uploaded successfully');
    }
    
    public function deleteTestPdf($id)
    {
          $record = DB::table('test_pdfs')->delete($id);
            return back()->with('message','pdf deleted successfully!');
    }
    
    public function editTestPdf($id)
    {
         $pdfs = DB::table('test_pdfs')->where('id',$id)->get();
         return view('admin.edit-test-pdf')->with(array('pdfs'=>$pdfs));
    }
    
    public function updateTestPdf(Request $request)
    {
         $request->validate([
            'file' => 'required|file|mimes:pdf',
          ]);
          
           if ($request->hasFile('file')) {
                $image = $request->file('file');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = base_path('assets/excel-formate');
                $image->move($destinationPath, $image_name);
               }else{
                   $image_name = NULL;
               }
              DB::table('test_pdfs')
            ->where('id',$request->id)
            ->update(array(
                'file'=>$image_name,
            ));
          return back()->with('message','pdf update successfully!');
    }
    
    public function studentQuizDetail(Request $request)
    {
        //  $halfquizes = DB::table('half_student_quiz_backup')
        //                  ->orderBy('id','desc')
        //                  ->get();
        
        // $halfquizes = DB::table('half_student_quiz_backup')
        //             ->join('tests', 'half_student_quiz_backup.test_id', '=', 'tests.id') 
        //             ->join('studentlogs', 'half_student_quiz_backup.user_id', '=', 'studentlogs.id') 
        //             ->select(
        //             'half_student_quiz_backup.id',
        //             'half_student_quiz_backup.section_name',
        //             'half_student_quiz_backup.sr_no',
        //             'half_student_quiz_backup.answer',
        //             \DB::raw('MAX(tests.test) as test'),
        //               \DB::raw('MAX(studentlogs.email) as email')
        //         )
        //             ->groupBy( 'half_student_quiz_backup.id',
        //             'half_student_quiz_backup.section_name',
        //             'half_student_quiz_backup.sr_no',
        //             'half_student_quiz_backup.answer')
        //             ->get();
                    
            $subQuery = DB::table('half_student_quiz_backup')
                        ->join('tests', 'half_student_quiz_backup.test_id', '=', 'tests.id')
                        ->join('studentlogs', 'half_student_quiz_backup.user_id', '=', 'studentlogs.id')
                        ->select(
                            'half_student_quiz_backup.id',
                            'half_student_quiz_backup.section_name',
                            'half_student_quiz_backup.sr_no',
                            'half_student_quiz_backup.answer',
                            'tests.test',             
                            'studentlogs.email',
                            DB::raw('ROW_NUMBER() OVER (PARTITION BY half_student_quiz_backup.section_name, half_student_quiz_backup.sr_no ORDER BY half_student_quiz_backup.id DESC) as rn')
                        );

            $halfquizes = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
                            ->mergeBindings($subQuery) 
                            ->where('sub.rn', '=', 1)  
                            ->select(
                                'sub.id',
                                'sub.section_name',
                                'sub.sr_no',
                                'sub.answer',
                                DB::raw('MAX(sub.test) as test'),       
                                DB::raw('MAX(sub.email) as email')
                            )
                            ->groupBy('sub.id', 'sub.section_name', 'sub.sr_no', 'sub.answer')  
                            ->get();
            return view('admin.student-quiz-detail')->with(array('halfquizes'=>$halfquizes));
    }
    
    public function newTestbuilder (Request $request)
    {
         $test_id = request()->id;
         $sections = DB::table('test_sections')->where('test_id',$test_id)->get();
         return view('admin.new-testbuilder')->with(array('sections'=>$sections));
    }
    
    public function addSection (Request $request)
    {
        $test_id= $request->test_id;
        $testtemp_id=$request->testtemp_id;
        $input =array(
            "section_name" => $request->section_name,
            "test_id" => $request->test_id,
            "testtemp_id" => $request->testtemp_id,
               
        );
        $record = DB::table('test_sections')->insert($input);
        return back()->with('message', 'Section Added Successfully!!');
    }
    
    public function editSection(Request $request){
        
        $request->validate([
            'section_name' => 'required'
        ]);
        DB::table('test_sections')
        ->where('id',$request->id)
        ->update(array(
            'section_name'=>$request->section_name,
        ));
        return back()->with('message', 'Section update Successfully!!');
    }
    
    public function deleteSection($id)
    {
        $record = DB::table('test_sections')->delete($id);
        return back()->with('message','Section deleted successfully!');
    }
    
    public function newQuestionbuilder(Request $request)
    {
         return view('admin.new_questionbuilder');
    }

}


