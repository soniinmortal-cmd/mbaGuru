<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use App\Models\Admin\Student;
use App\Models\StudentQuize;
use App\Models\ExcelQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTables;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Test;
use DB;
use Illuminate\Support\Facades\Http;
use Hash;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;

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





    public function store(Request $request)
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
                    $res = Students::create($data);
                  
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
        ini_set('max_execution_time', 00);
        ini_set('memory_limit', '512M');
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
    public function launchtest($id) {
        $sets = DB::table('sets')->where('course_id',$id)->orderBy('id', 'DESC')->get();
        return view('student.launchtest')->with(array('sets'=>$sets));
    }
    public function starttest($id) {
        $tests = DB::table('tests')
               ->where('course_id',$id)
                //->where('testtempid',2)
                ->orderBy('id', 'DESC')
                ->get();
//dd($tests);
        return view('student.start-test')->with(array('tests'=>$tests));
    }
    public function instructions($id) {
        return view('student.instructions');
    }
 public function quizInstructions($id) {
     return view('student.quiz_instructions');
 }
   
    public function read_doc() 
    {
        $filename = storage_path('app\files\1691753042QuestionImportTemplate-v4.docx');
        $fileHandle = fopen($filename, "r");
        $line = @fread($fileHandle, filesize($filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

     public function read_docx()
    {
    
        $striped_content = '';
        $content = '';
        $filename = storage_path('app\files\1691753042QuestionImportTemplate-v4.docx');
        $zip = zip_open($filename);
    
        if (!$zip || is_numeric($zip)) return false;
    
        while ($zip_entry = zip_read($zip)) {
    
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
    
            if (zip_entry_name($zip_entry) != "word/document.xml") continue;
    
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
    
            zip_entry_close($zip_entry);
        }// end while
    
        zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);
        return $striped_content;
    } 

    // public function getWord() 
    // {
    //     //$filename = storage_path('app\files\1691753042QuestionImportTemplate-v4.docx');
    //   $filename =   url('storage/app/files/1691753042QuestionImportTemplate-v4.docx');
    //   //  dd($filename);
    //     // if(isset($filename) && !file_exists($filename)) {
    //     //     return "File Not exists";
    //     // }

    //     $fileArray = pathinfo($filename);
    //     $file_ext  = $fileArray['extension'];
    //     if($file_ext == "doc" || $file_ext == "docx")
    //     {
    //         if($file_ext == "doc") {
    //             //return $this->read_doc();
    //             $wordtext =  $this->read_doc();
    //             //return file_get_contents($wordtext);
    //             // print_r($wordtext);
    //             // die;
    //             return view('student.wordquestion')->with(array('wordtext'=>$wordtext));
    //         } else {
    //             //return $this->read_docx();
    //             $wordtext = $this->read_docx();
    //             // print_r($wordtext);
    //             // die;
    //             // return file_get_contents($wordtext);
    //             return view('student.wordquestion')->with(array('wordtext'=>$wordtext));
                 
    //         }
    //     } else {
    //         return "Invalid File Type";
    //     }
    // }

    // public function getWord()
    // {
    //     //$filename = storage_path('app\files\1691753042QuestionImportTemplate-v4.docx');
    //      $filename =   url('storage/app/files/1691753042QuestionImportTemplate-v4.docx');
    //     $zip = new \ZipArchive();
    //     if ($zip->open($filename)) {
    //         $content = $zip->getFromName("word/document.xml");
    //         $zip->close();
    //         $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    //         $content = str_replace('</w:r></w:p>', "\r\n", $content);
    //         $content1= str_replace("Sample test","testdf",$content);
         
    //         echo'<pre>';
    //       //$dt = array($content);
    //         $dt =  substr($content,6);
    //           echo'<pre>';
    //         print_r($dt);
    //         die;
    //         return strip_tags($content);
    //     }
    //     return false;
    // }
    
    public function allQuestion($id)
    {
        $test = DB::table('tests')->where('id',$id)->first();
        $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%VERBAL%")
                            ->get();
        $data_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                          ->where('section_name', 'like', "%DATA%")
                            ->get();
        $qt_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                           ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
        
        return view('student.all-question')->with(array('test'=>$test,'verbal_qus'=>$verbal_qus,'data_qus'=>$data_qus,'qt_qus'=>$qt_qus));

    }

    //  public function startQuize($id) 
    // {
    //     $userid =session()->get('id');

    //      $noduration_ques = DB::table('excel_questions')
    //                     ->where('test_id',$id)
    //                     ->get();
     
    //         $verbal_ques = DB::table('excel_questions')
    //                     ->where('test_id',$id)
    //                     // ->where('section_name', 'like', "%VERBAL ABILITY AND READING COMPREHENSION%")
    //                     ->where('section_name','LIKE', "%Verbal%")
    //                     ->get();

    //         $data_ques = DB::table('excel_questions')
    //                     ->where('test_id',$id)
    //                     ->where('section_name', 'like', "%Data%")
    //                         ->get();
    //      $qunatitative_ques = DB::table('excel_questions')
    //                     ->where('test_id',$id)
    //                   ->where('section_name', 'like', "%Quantitative%")
    //                         ->get();
    //      $section_time = DB::table('quiz_durations')
    //                     ->where('test_id',$id)
    //                   -> orderBy('id','DESC')
    //                     ->first();
    //     $section_type = DB::table('student_quizes')
    //                         ->where('test_id',$id)
    //                         ->where('user_id',$userid)
    //                       -> orderBy('id','DESC')
    //                         ->first();
    //                       // dd($section_type);
                           
    //   $verbal_qus = DB::table('excel_questions')
    //                     ->where('test_id',$id)
    //                      ->where('section_name', 'like', "%VERBAL%")
    //                         ->get();
                            
    //     $data_qus = DB::table('excel_questions')
    //                       ->where('test_id',$id)
    //                       ->where('section_name', 'like', "%DATA%")
    //                         ->get();
    //     $qt_qus = DB::table('excel_questions')
    //                       ->where('test_id',$id)
    //                       ->where('section_name', 'like', "%QUANTITATIVE%")
    //                         ->get();
    //      $test = DB::table('tests')->where('id',$id)->first();
    //      //dd($verbal_ques);
    //     return view('student.start-quize')->with(array('verbal_ques'=>$verbal_ques,'data_ques'=>$data_ques ,'qunatitative_ques'=>$qunatitative_ques,'section_time'=>$section_time,'noduration_ques'=>$noduration_ques,'verbal_qus'=>$verbal_qus,'data_qus'=>$data_qus,'qt_qus'=>$qt_qus,'test'=>$test));
    // }
    
    public function startQuize(Request $request) 
    {
        $userid = session()->get('id');
        $paperid = request()->paperid;
        $id = request()->id;
    
        $verbal_ques = DB::table('excel_questions')
                    ->select('id', 'test_id', 'section_name', 'level', 'instruction', 'question', 'id', 'question_type', 'status', 'answer', 'option1', 'option2', 'option3', 'option4', 'option5')
                    ->where('test_id', $id)
                    ->where('section_name', 'LIKE', "%Verbal%")
                    ->get();
         
        
        $section_time = DB::table('quiz_durations')
                    ->select('id', 'verbal_time', 'duration')
                    ->where('test_id', $id)
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();
        return view('student.start-quize', compact('verbal_ques', 'section_time'));
    }

    public function dataQuiz($sid,$id) 
    {
          $userid =session()->get('id');
          $data_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name', 'like', "%Data%")
                        ->get();
        $section_time = DB::table('quiz_durations')
                        ->where('test_id',$id)
                        -> orderBy('id','DESC')
                        ->first();
        $section_type = DB::table('student_quizes')
                            ->where('test_id',$id)
                            ->where('user_id',$userid)
                            -> orderBy('id','DESC')
                            ->first();
          $verbal_qus = DB::table('excel_questions')
                         ->where('test_id',$id)
                         ->where('section_name', 'like', "%VERBAL%")
                         ->get();
        $data_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                          ->where('section_name', 'like', "%DATA%")
                          ->get();
        $qt_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                           ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
         $test = DB::table('tests')->where('id',$id)->first();
        return view('student.data-quiz')->with(array('data_ques'=>$data_ques,'section_time'=>$section_time, 'section_type'=>$section_type,'verbal_qus'=>$verbal_qus,'data_qus'=>$data_qus,'qt_qus'=>$qt_qus,'test'=>$test));
    }
     public function quantitativeQuiz($sid,$id) 
    {
         $userid =session()->get('id');
         $qt_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name', 'like', "%Quantitative%")
                        ->get();
        $section_time = DB::table('quiz_durations')
                        ->where('test_id',$id)
                        -> orderBy('id','DESC')
                        ->first();
        $section_type = DB::table('student_quizes')
                            ->where('test_id',$id)
                            ->where('user_id',$userid)
                           -> orderBy('id','DESC')
                            ->first();
        $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name', 'like', "%VERBAL%")
                        ->get();
        $data_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                          ->where('section_name', 'like', "%DATA%")
                            ->get();
        $qt_qus = DB::table('excel_questions')
                          ->where('test_id',$id)
                           ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
         $test = DB::table('tests')->where('id',$id)->first();
        return view('student.quantitative-quiz')->with(array('qt_ques'=>$qt_ques,'section_time'=>$section_time, 'section_type'=>$section_type,'verbal_qus'=>$verbal_qus,'data_qus'=>$data_qus,'qt_qus'=>$qt_qus,'test'=>$test));
    }

    public function savequizedata(Request $request)
    {
        //dd($request->all());
        // if(is_array($request->answer)){
        //   $ans = implode(',', $request->answer);
        // }else{
        //  $ans = $request->answer;
        // }
       // $answer = $request->answer;
       $answer = is_array($request->answer) ? $request->answer : [];
       // $maxIndex = max(array_keys($answer));
       // $maxIndex = count($request->question_id);
       $maxIndex = count($request->question_id ?? []);
//       print_r($answer);
//  die();

for ($i = 1; $i <= $maxIndex; $i++) {
    // Check if the index exists in the array
    if (!array_key_exists($i, $answer)) {
        // If it does not exist, set it to null
        $answer[$i] = null;
    }
}

// Sort the array by keys to maintain order
ksort($answer);

// Output the result
 $ans = implode(',', $answer);

     $values = array(
        'test_id' => $request['test_id'],
        'user_id' => $request->user_id,
        'set_type' => $request->set_type,
        'section_type' => $request->section_type,
        'student_duration' => $request->student_duration,
        'paper_id' => $request->paper_id,
        'answer_review' => $request->answer_review,
        'question_id' => implode(',', $request->question_id),
        'level' => implode(',', $request->level),
        'ans_duration' =>  $request->ans_duration,
        'answer' =>  $ans,
        'question_type' => implode(',', $request->question_type)    
     );
    StudentQuize::create($values);
    return response()->json([
        'success' => true,
        'message' => 'Data successfully submitted',
    ]);
  }

    public function stopQuiz($sid,$id) 
    {
        $userid =session()->get('id');
        $paperid = request()->paperid;
        //dd($sid);
        $total = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('paper_id',$paperid)
                ->where('user_id',$userid)
                ->orderBy('id', 'DESC')
                ->first();
    if(!empty($total)){
           $question_id = explode(",",$total->question_id);
          // dd($question_id);
           $answer = explode(",",$total->answer);
        if(isset($question_id)){
            if(array_keys($question_id ) == array_keys($answer)){
                $non_answer =   count(array_intersect($answer, ['']));
            }else{
                 $newarr = array_diff_key($question_id, $answer);
                 $qusarr = count($newarr);
                 $ansarr =  count(array_intersect($answer, ['']));
                 $non_answer = $qusarr+$ansarr;    
            }
            $question = count($question_id);
            //$non_answer =   count(array_intersect($answer, ['']));
            $show_answer = count(array_filter($answer));
        }
        return view('student.stop-quiz')->with(array('question'=>$question,'non_answer'=>$non_answer, 'show_answer'=>$show_answer));
    }else{
        $question = 0;
        $non_answer = 0;
        $show_answer=0;

    return view('student.stop-quiz')->with(array('question'=>$question,'non_answer'=>$non_answer, 'show_answer'=>$show_answer));
    }

        
    }
   
    public function savepaper(Request $request) 
    {
        //dd($request->all());
        $values = array(
            'test_id' => $request->test_id,
            'user_id' => $request->user_id,
            'paper_id' => $request->paper_id  
        );
       DB::table('student_paper')->insert($values);
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function report($sid,$id,$paperid) 
    {
        $userid =session()->get('id');
        $tests = DB::table('tests')
                ->where('id',$id)
                ->first();
                
        // $reports = DB::table('student_quizes')
        //         ->where('test_id',$id)
        //         ->where('user_id',$userid)
        //         ->where('paper_id',$paperid)
        //         ->get();
        
 // Subquery to get the maximum id for each section_type
$subQuery = DB::table('student_quizes')
    ->select('section_type', DB::raw('MAX(id) as max_id'))
    ->where('test_id', $id)
    ->where('user_id', $userid)
    ->where('paper_id', $paperid)
    ->groupBy('section_type');


$reports = DB::table('student_quizes')
    ->joinSub($subQuery, 'latest', function ($join) {
        $join->on('student_quizes.id', '=', 'latest.max_id');
    })
    ->where('student_quizes.test_id', $id)
    ->where('student_quizes.user_id', $userid)
    ->where('student_quizes.paper_id', $paperid)
    ->orderByRaw("CASE 
        WHEN student_quizes.section_type = 'verbal' THEN 1
        WHEN student_quizes.section_type = 'data' THEN 2
        WHEN student_quizes.section_type = 'quantitative' THEN 3
        ELSE 4
    END")
    ->orderBy('student_quizes.id')
    ->get();







        $verbal_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                 ->where('section_type', 'like', "%verbal%")
                 ->orderBy('id', 'DESC')
                ->first();
                //dd($verbal_reports);
              if(!empty($verbal_reports->question_id)){
                    $vString = $verbal_reports->question_id;
              }
              if(isset($vString)){
                    $vArray = explode(',', $vString);
                  $verbal_ques = DB::table('excel_questions')
                  ->where('test_id',$id)
                    ->whereIn('id',$vArray)
                    ->get();
              }else{
                 $verbal_ques = []; 
              }
               

        $data_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                ->where('section_type', 'like', "%Data%")
                ->orderBy('id', 'DESC')
                ->first();
                
                if(!empty($data_reports->question_id)){
                      $dString = $data_reports->question_id;
                }
                if(isset($dString)){
                    
                 $dArray = explode(',', $dString);
                        $data_ques = DB::table('excel_questions')
                              ->where('test_id',$id)
                                ->whereIn('id',$dArray)
                                ->get();
                }else{
                    $data_ques= [];
                }
              
       
        $qt_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                 ->where('section_type', 'like', "%quantitative%")
              ->orderBy('id', 'DESC')
                ->first();
                  if(!empty($qt_reports->question_id)){
                        $qString = $qt_reports->question_id;
                }
      
        if(isset($qString)){
             $qArray = explode(',', $qString);

        $qt_ques = DB::table('excel_questions')
                  ->where('test_id',$id)
                    ->whereIn('id',$qArray)
                    ->get();
        }else{
            $qt_ques = [];
            
        }
       
        $cutoff = DB::table('cutoff')
      ->where('test_id',$id)
        ->get();

    return view('student.report')->with(array('tests'=>$tests,'reports'=>$reports,'verbal_reports'=>$verbal_reports,'data_reports'=>$data_reports,'qt_reports'=>$qt_reports,'verbal_ques'=>$verbal_ques,'data_ques'=>$data_ques,'qt_ques'=>$qt_ques,'cutoff'=>$cutoff));
    }


    
    public function report2($sid,$id,$paperid) 
    {
        $userid =session()->get('id');

        $tests = DB::table('tests')
                ->where('id',$id)
                ->first();

        $reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                ->get();

        $verbal_reports = DB::table('student_quizes')
                        ->where('test_id',$id)
                        ->where('user_id',$userid)
                        ->where('paper_id',$paperid)
                        ->where('section_type', 'like', "%verbal%")
                        ->orderBy('id', 'DESC')
                        ->first();
                
                //dd($verbal_reports);
               if(!empty($verbal_reports->question_id)){
                    $vString = $verbal_reports->question_id;
               }
             
                 $vArray = explode(',', $vString);
          
              // dd($vArray);
                $verbal_ques = DB::table('excel_questions')
                   ->where('test_id',$id)
                    ->whereIn('id',$vArray)
                    ->get();

              $data_reports = DB::table('student_quizes')
                        ->where('test_id',$id)
                        ->where('user_id',$userid)
                        ->where('paper_id',$paperid)
                        ->where('section_type', 'like', "%Data%")
                        ->orderBy('id', 'DESC')
                        ->first();
              //  dd($data_reports);
                if(!empty($data_reports->question_id)){
                       $dString = $data_reports->question_id;

                        $dArray = explode(',', $dString);
                }
              
                
        $data_ques = DB::table('excel_questions')
                   ->where('test_id',$id)
                    ->whereIn('id',$dArray)
                    ->get();
        $qt_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                 ->where('section_type', 'like', "%quantitative%")
               ->orderBy('id', 'DESC')
                ->first();
        $qString = $qt_reports->question_id;
        $qArray = explode(',', $qString);

        $qt_ques = DB::table('excel_questions')
                   ->where('test_id',$id)
                    ->whereIn('id',$qArray)
                    ->get();
        $cutoff = DB::table('cutoff')
       ->where('test_id',$id)
        ->get();

    return view('student.report2')->with(array('tests'=>$tests,'reports'=>$reports,'verbal_reports'=>$verbal_reports,'data_reports'=>$data_reports,'qt_reports'=>$qt_reports,'verbal_ques'=>$verbal_ques,'data_ques'=>$data_ques,'qt_ques'=>$qt_ques,'cutoff'=>$cutoff));
    }


    public function solution($testid,$paperid)
    {
        ini_set('memory_limit', '512M');
         $userid =session()->get('id');
        $verbal_ques = DB::table('excel_questions')
        ->select('answer_explanation','question_type','correct_option','positive_mark','negative_mark','instruction',
            'question','answer','status','option1','option2','option3','option4','option5','section_name','test_id')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%VERBAL%")
                           // ->limit(23)
                            ->get();
             
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                             ->where('section_type', 'like', "%verbal%")
                             ->orderBy('id', 'DESC')
                             ->limit(1)
                            ->first();
                            
        $verbal_r = DB::table('student_quizes')
                            ->select('answer','ans_duration','user_id','section_type','test_id')
                            ->where('test_id',$testid)
                            ->where('section_type', 'like', "%verbal%")
                            ->get();
                           // dd($verbal_r);
            $test = DB::table('tests')
                            ->select('test','id','testincid')
                            ->where('id',$testid)
                            ->orderBy('id', 'DESC')
                            ->first();
    return view('student.solution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }

    public function dataSolution($testid,$paperid)
    {
        $userid =session()->get('id');
        $verbal_ques = DB::table('excel_questions')
                        ->where('test_id',$testid)
                         ->where('section_name', 'like', "%Data%")
                            ->get();
                            
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                             ->where('section_type', 'like', "%Data%")
                             ->orderBy('id', 'DESC')
                            ->first();
                            
        $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('section_type', 'like', "%Data%")
                            ->get();
        $test = DB::table('tests')
                ->where('id',$testid)
                ->orderBy('id', 'DESC')
                ->first();
       return view('student.datasolution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }

    public function qtSolution($testid,$paperid)
    {
         $userid =session()->get('id');
        $verbal_ques = DB::table('excel_questions')
                        ->where('test_id',$testid)
                         ->where('section_name', 'like', "%quantitative%")
                            ->get();
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                            ->where('section_type', 'like', "%quantitative%")
                            ->orderBy('id', 'DESC')
                            ->first();
        
        $verbal_r = DB::table('student_quizes')
                         
                            ->where('test_id',$testid)
                             ->where('section_type', 'like', "%quantitative%")
                            ->get();
                         
            $test = DB::table('tests')
                            ->where('id',$testid)
                             ->orderBy('id', 'DESC')
                            ->first();
            return view('student.qtsolution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }


    public function solutionQuestion($testid,$sectionid,$paperid)
     {
         
        if($sectionid ==1)
        {
             $verbal_qus = DB::table('excel_questions')
                          ->where('test_id',$testid)
                          ->where('section_name', 'like', "%Verbal%")
                          ->get();
 
        }elseif($sectionid ==2)
        {
             $verbal_qus = DB::table('excel_questions')
                           ->where('test_id',$testid)
                           ->where('section_name', 'like', "%Data%")
                           ->get();

        } elseif($sectionid ==3) {
             $verbal_qus = DB::table('excel_questions')
                           ->where('test_id',$testid)
                           ->where('section_name', 'like', "%quantitative%")
                           ->get();

        }
        
        // dd($verbal_qus);
        return view('student.solution-question')->with(array('verbal_qus'=>$verbal_qus));
    }

    public function solutionInstruction($testid,$sectionid,$paperid)
    {
           $ins = DB::table('instruction')->where('test_id',$testid)->orderBy('id', 'DESC')->first(); 
           return view('student.solution-instruction')->with(array('ins'=>$ins));  
           
    }
    
    
    
    
    public function savereview(Request $request) 
    {
        $userid = session()->get('id');
        $review = DB::table('ansmark_review')
                    ->where('user_id',$userid)
                        ->where('test_id',$request->test_id)
                        ->where('paper_id',$request->paper_id)
                        ->where('review_id',$request->review_id)
                        ->where('section_name', $request->section_name)
                        ->where('user_id',$userid)
                        ->orderBy('id','desc')
                        ->first();
           // dd($review);
       if ($review !== null) 
        {
            if($review->ans_review==1)
            {
                $insert =  DB::table('ansmark_review')
                ->where('test_id',$request->test_id)
                ->where('paper_id',$request->paper_id)
                ->where('review_id',$request->review_id)
                ->where('section_name',$request->section_name)
                ->where('user_id',$userid)
                ->where('id',$review->id)
                ->update(array(
                    'ans_review'=>0,
                ));
            }else{
                $insert =  DB::table('ansmark_review')
                        ->where('test_id',$request->test_id)
                        ->where('paper_id',$request->paper_id)
                        ->where('review_id',$request->review_id)
                        ->where('section_name',$request->section_name)
                        ->where('user_id',$userid)
                        ->where('id',$review->id)
                        ->update(array(
                            'ans_review'=>1,
                        ));
            }
        } else {
            $values = array(
                'test_id' => $request->test_id,
                'paper_id' => $request->paper_id, 
                'review_id' => $request->review_id,
                'section_name' => $request->section_name,
                'user_id'=>$userid,
                'ans_review' => 1
            );
            $insert =  DB::table('ansmark_review')->insert($values);
        }
       if($insert){
            return json_encode(array(
                "statusCode"=>200
            ));
       }else{
        return json_encode(array(
            "statusCode"=>201
        ));

       }
        
    }
    
     public function  newpassword(Request $request) 
     {
        $email = DB::table('studentlogs')
            ->where('email',$request->email)
            ->first();
            $newpassword = mt_rand(100000,999999);
            
            $password = Hash::make($newpassword);
            if(!empty($email)){
                 $insert =  DB::table('studentlogs')
                    ->where('email',$email->email)
                    ->update(array(
                        'password'=> $password,
                        'show_password'=> $newpassword,
                    ));
                    return redirect()->back()->with('message', 'Your new password is '.$newpassword);
            }else{
                  return redirect()->back()->with('message', 'Please enter valid email!!');
            }
     }
     
    public function resetpassword()
    {
        return view('student.reset_password');
    }
 
    public function savehalfquiz(Request $request)  
    {
        foreach($request->test_id as $item => $value)
        {
                $data[$value] = array(
                     'test_id' => $request->test_id[$item] ?? null,
                    'paper_id' => $request->paper_id[$item] ?? null,
                    'user_id' => $request->user_id[$item] ?? null,
                    'question_id' => $request->question_id[$item] ?? null,
                    'section_name' => $request->section_name[$item] ?? null,
                    'answer' => $request->answer[$item] ?? null,
                    'sr_no' => $request->sr_no[$item] ?? null,
                    'set_type' => $request->set_type[$item] ?? null,
                    'ans_duration' => $request->ans_duration[$item] ?? null,
                    'created_at' => now()
                );
                DB::table('half_student_quiz')->insert($data);
                DB::table('half_student_quiz_backup')->insert($data);
        }
        
        return json_encode(array(
            "statusCode"=>200
        ));

    }

    public function savenexthalfquiz(Request $request)  
    {  
       // dd($request->all());
        foreach($request->test_id as $item => $value)
        {
                $data[$value] = array(
                    'test_id' => $request->test_id[$item],
                    'paper_id' => $request->paper_id[$item],
                    'user_id' => $request->user_id[$item], 
                    //'question_id' => $request->question_id[$item],
                    'section_name' => $request->section_name[$item],
                    'answer' => $request->answer[$item],
                    'sr_no' => $request->sr_no[$item],
                    'set_type' => $request->set_type[$item] ?? 'null',
                    'ans_duration' => $request->ans_duration[$item],
                    'created_at' => now()
                );
                DB::table('half_student_quiz')->insert($data);
                DB::table('half_student_quiz_backup')->insert($data);
        }
        return json_encode(array(
            "statusCode"=>200
        ));

    }

    public function savenmatnexthalfquiz(Request $request)  
    {
        foreach($request->test_id as $item => $value)
        {
                $data[$value] = array(
                    'test_id' => $request->test_id[$item],
                    'paper_id' => $request->paper_id[$item],
                    'user_id' => $request->user_id[$item], 
                    //'question_id' => $request->question_id[$item],
                    'section_name' => $request->section_name[$item],
                    'answer' => $request->answer[$item],
                    'sr_no' => $request->sr_no[$item],
                  'set_type' => $request->set_type[$item],
                  'created_at' => now()
                );
                DB::table('half_student_quiz')->insert($data);
                DB::table('half_student_quiz_backup')->insert($data);
        }
        
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function slotBooking(Request $request)
    {
      //$courses = DB::table('testuploading')->get();
       $courses =  DB::table('testuploading')
                    ->leftjoin('proctored', 'testuploading.id', '=', 'proctored.course_id')
                    ->select('proctored.course_id', 'proctored.status','testuploading.title','testuploading.id')
                    ->groupBy('proctored.course_id','proctored.status','testuploading.title','testuploading.id')
                    ->where('proctored.status',1)
                   // ->orderByRaw("CASE WHEN testuploading.title LIKE '%AIRCAT%' THEN 0 ELSE 1 END")
                     ->orderBy('testuploading.id','desc')
                    ->get();

        $newcourses =  DB::table('testuploading')
                        ->leftjoin('proctored', 'testuploading.id', '=', 'proctored.course_id')
                        ->select('proctored.course_id', 'proctored.status','testuploading.title','testuploading.id')
                        ->groupBy('proctored.course_id','proctored.status','testuploading.title','testuploading.id')
                        ->where('proctored.status',1)
                        //->orderByRaw("CASE WHEN testuploading.title LIKE '%AIRCAT%' THEN 0 ELSE 1 END")
                        ->orderBy('testuploading.id','desc')
                        ->first();
                       //dd($newcourses);
        $centers = DB::table('centers')->get();
        return view('student.slot-booking')->with(array('courses'=>$courses,'centers'=>$centers,'newcourses'=>$newcourses));
    }

    public function fetchTest(Request $request)
    {
        // $data['test'] = Test::where("course_id", $request->course_id)
        //                 ->get(["test", "id"]);
        $data['test'] = DB::table('tests')
                        ->leftjoin('proctored', 'tests.id', '=', 'proctored.test_id')
                        ->select('tests.*', 'proctored.course_id', 'proctored.status')
                        ->where('tests.course_id',$request->course_id)
                        ->where('proctored.status',1)
                        ->get();
                        
        return response()->json($data);
    }

    public function fetchTable(Request $request)
    {
        $data = array();
    
        $curdate = date("Y-m-d");

        $data['seats'] = DB::table('seats')
                        ->where('test_id',$request->test_id)
                        ->where('course_id',$request->course_id)
                        ->where('center_id',$request->center_id)
                        ->where('from_date','>=', $curdate)
                        ->orderBy('from_date','asc')
                        ->get();
                        
        $data['stubooking'] = DB::table('remaining_seats')
                            ->where('test_id',$request->test_id)
                            ->where('course_id',$request->course_id)
                            ->where('center_id',$request->center_id)
                            ->where('booking_date','>=', $curdate)
                            ->get();
                            
                      // dd($data);
        return response()->json($data);
    }

    // public function saveBooking(Request $request)
    // {
    //     $user_id =session()->get('id');
        
    //      $is_quiz = DB::table('student_quizes')
    //                 ->where('test_id',$request->test_id)
    //                 ->where('user_id',$user_id)
    //                 ->first();

    //     $isbooking = DB::table('student_booking')
    //                 ->where('user_id',$user_id)
    //                 ->where('test_id',$request->test_id)
    //                 ->where('course_id',$request->course_id)
    //                 ->where('booking_date',$request->booking_date)
    //                 ->where('booking_time',$request->booking_time)
    //                 ->where('center_id',$request->center_id)
    //                 ->first();

    //         $booking = DB::table('student_booking')
    //                   ->where('user_id',$user_id)
    //                   ->where('test_id',$request->test_id)
    //                   ->where('course_id',$request->course_id)
    //                   //->where('center_id',$request->center_id)
    //                   ->first();
                    
    //         $remaining = DB::table('remaining_seats')
    //                      ->where('test_id',$request->test_id)
    //                      ->where('course_id',$request->course_id)
    //                      ->where('center_id',$request->center_id)
    //                      ->where('booking_date',$request->booking_date)
    //                      ->where('booking_time',$request->booking_time)
    //                      ->first();
                        
    //     if($request->newbook ==1){
    //         if ($is_quiz === null || $is_quiz->test_id !== $request->test_id) {
    //             if(empty($isbooking)){
    //                 if($booking)
    //                 {
    //                     if($booking->booking_count<2){
    //                         if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
    //                                 return json_encode(array(
    //                                     "statusCode"=>203,
    //                                     "success"=>4
    //                                 ));
                                
    //                         }else{
    //                          $insert =  DB::table('student_booking')
    //                         ->where('test_id',$booking->test_id)
    //                         ->where('user_id',$booking->user_id)
    //                         ->where('course_id',$booking->course_id)
    //                     //  ->where('center_id',$booking->center_id)
    //                         ->update(array(
    //                             'booking_time'=>$request->booking_time,
    //                             'booking_date'=>$request->booking_date,
    //                             'remaining_seats' => $booking->remaining_seats-1,
    //                             'booking_count' => $booking->booking_count+1,
    //                             'center_id'=>$request->center_id,
    //                         ));
    //                         $insert1 =  DB::table('remaining_seats')
    //                                 ->where('test_id',$booking->test_id)
    //                                 ->where('course_id',$booking->course_id)
    //                                 ->where('center_id',$booking->center_id)
    //                                 ->where('booking_date',$booking->booking_date)
    //                                 ->where('booking_time',$booking->booking_time)
    //                                 ->update(array(
    //                                     'remaining_seats' => $booking->remaining_seats+1,
    //                                   // 'center_id'  => $request->center_id,
    //                                 ));   
    //                         }
                       
    //                     }else{
    //                         return json_encode(array(
    //                                 "statusCode"=>201,
    //                                 "success"=>2
    //                         ));
    //                     } 

    //                 }else{
    //                      if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
    //                                 return json_encode(array(
    //                                     "statusCode"=>203,
    //                                     "success"=>4
    //                                 ));
    //                     }else{        
    //                         $data= array(
    //                             'user_id' => $user_id, 
    //                             'test_id' => $request->test_id,
    //                             'course_id' => $request->course_id,
    //                             'center_id' => $request->center_id,
    //                             'booking_date' => $request->booking_date,
    //                             'booking_time' => $request->booking_time,
    //                             'remaining_seats' => $request->remaining_seats-1,
    //                             'booking_count' => 1   
    //                         );
    //                         $insert = DB::table('student_booking')->insert($data); 
    //                     }
    //                 }
    //                 //if($remaining->remaining_seats){
    //                 if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
    //                                 return json_encode(array(
    //                                     "statusCode"=>203,
    //                                     "success"=>4
    //                                 ));
    //                 }else{
    //                     if($remaining){
    //                         $insert =  DB::table('remaining_seats')
    //                             ->where('test_id',$remaining->test_id)
    //                             ->where('course_id',$remaining->course_id)
    //                           ->where('center_id',$remaining->center_id)
    //                             ->where('booking_date',$remaining->booking_date)
    //                             ->where('booking_time',$remaining->booking_time)
    //                             ->update(array(
    //                                 'remaining_seats' => $remaining->remaining_seats-1,
    //                                 'center_id'=>$request->center_id,
    //                             ));
    //                     }else{
    //                         $data= array(
    //                                 //'user_id' => $user_id, 
    //                                 'test_id' => $request->test_id,
    //                                 'course_id' => $request->course_id,
    //                                 'center_id' => $request->center_id,
    //                                 'booking_date' => $request->booking_date,
    //                                 'booking_time' => $request->booking_time,
    //                                 'remaining_seats' => $request->remaining_seats-1,
    //                             );
    //                         $insert = DB::table('remaining_seats')->insert($data); 
    //                     }
    //                 }
                
    //                     if($insert)
    //                     {
    //                         return json_encode(array(
    //                             "statusCode"=>200,
    //                             "success"=>1
    //                         ));
    //                     }else{
    //                         return json_encode(array(
    //                         "statusCode"=>201,
    //                         "success"=>0
    //                         ));
    //                     }

    //             }else{
    //                 return json_encode(array(
    //                     "statusCode"=>202,
    //                     "success"=>3
    //                 ));
    //             }
    //         }else{
    //             return json_encode(array(
    //                     "statusCode"=>204,
    //                     "success"=>5
    //             ));
    //         }
            
    //     } 
          
    // }
        public function saveBooking(Request $request)
        {
           $user_id =session()->get('id');
           $is_quiz = DB::table('student_quizes')
                    ->where('test_id',$request->test_id)
                    ->where('user_id',$user_id)
                    ->first();

           $isbooking = DB::table('student_booking')
                    ->where('user_id',$user_id)
                    ->where('test_id',$request->test_id)
                    ->where('course_id',$request->course_id)
                    ->where('booking_date',$request->booking_date)
                    ->where('booking_time',$request->booking_time)
                    ->where('center_id',$request->center_id)
                    ->first();

            $booking = DB::table('student_booking')
                      ->where('user_id',$user_id)
                      ->where('test_id',$request->test_id)
                      ->where('course_id',$request->course_id)
                      //->where('center_id',$request->center_id)
                      ->first();
                    
            $remaining = DB::table('remaining_seats')
                         ->where('test_id',$request->test_id)
                         ->where('course_id',$request->course_id)
                         ->where('center_id',$request->center_id)
                         ->where('booking_date',$request->booking_date)
                         ->where('booking_time',$request->booking_time)
                         ->first();
                        
        if($request->newbook ==1){
            if ($is_quiz === null || $is_quiz->test_id !== $request->test_id) {
                if(empty($isbooking)){
                    if($booking)
                    {
                        if($booking->booking_count<2){
                            if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
                                    return json_encode(array(
                                        "statusCode"=>203,
                                        "success"=>4
                                    ));
                            }else{
                                $student_remaining = DB::table('remaining_seats')
                                                     ->where('test_id',$booking->test_id)
                                                     ->where('course_id',$booking->course_id)
                                                     ->where('center_id',$booking->center_id)
                                                     ->where('booking_date',$booking->booking_date)
                                                     ->where('booking_time',$booking->booking_time)
                                                     ->first();
                                                     
                               $insert =  DB::table('student_booking')
                                        ->where('test_id',$booking->test_id)
                                        ->where('user_id',$booking->user_id)
                                        ->where('course_id',$booking->course_id)
                                       //->where('center_id',$booking->center_id)
                                        ->update(array(
                                            'booking_time'=>$request->booking_time,
                                            'booking_date'=>$request->booking_date,
                                            'remaining_seats' => $booking->remaining_seats-1,
                                            'booking_count' => $booking->booking_count+1,
                                            'center_id'=>$request->center_id,
                                        ));
                              $insert1 =  DB::table('remaining_seats')
                                    ->where('test_id',$booking->test_id)
                                    ->where('course_id',$booking->course_id)
                                    ->where('center_id',$booking->center_id)
                                    ->where('booking_date',$booking->booking_date)
                                    ->where('booking_time',$booking->booking_time)
                                    ->update(array(
                                        //'remaining_seats' => $booking->remaining_seats+1,
                                       'remaining_seats' => $student_remaining->remaining_seats+1,
                                    ));   
                            }
                       
                        }else{
                            return json_encode(array(
                                    "statusCode"=>201,
                                    "success"=>2
                            ));
                        } 

                    }else{
                         if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
                                    return json_encode(array(
                                        "statusCode"=>203,
                                        "success"=>4
                                    ));
                        }else{        
                            $data= array(
                                'user_id' => $user_id, 
                                'test_id' => $request->test_id,
                                'course_id' => $request->course_id,
                                'center_id' => $request->center_id,
                                'booking_date' => $request->booking_date,
                                'booking_time' => $request->booking_time,
                                'remaining_seats' => $request->remaining_seats-1,
                                'booking_count' => 1   
                            );
                            $insert = DB::table('student_booking')->insert($data); 
                        }
                    }
                    //if($remaining->remaining_seats){
                    if(isset($remaining) && ($remaining->test_id == $request->test_id) && ($remaining->course_id == $request->course_id) && ($remaining->booking_date == $request->booking_date) && ($remaining->booking_time == $request->booking_time)&& ($remaining->remaining_seats == 0)){
                                    return json_encode(array(
                                        "statusCode"=>203,
                                        "success"=>4
                                    ));
                    }else{
                        if($remaining){
                            $insert =  DB::table('remaining_seats')
                                        ->where('test_id',$remaining->test_id)
                                        ->where('course_id',$remaining->course_id)
                                        ->where('center_id',$remaining->center_id)
                                        ->where('booking_date',$remaining->booking_date)
                                        ->where('booking_time',$remaining->booking_time)
                                        ->update(array(
                                            'remaining_seats' => $remaining->remaining_seats-1,
                                            'center_id'=>$request->center_id,
                                        ));
                        }else{
                            $data= array(
                                    //'user_id' => $user_id, 
                                    'test_id' => $request->test_id,
                                    'course_id' => $request->course_id,
                                    'center_id' => $request->center_id,
                                    'booking_date' => $request->booking_date,
                                    'booking_time' => $request->booking_time,
                                    'remaining_seats' => $request->remaining_seats-1,
                                );
                            $insert = DB::table('remaining_seats')->insert($data); 
                        }
                    }
                
                        if($insert)
                        {
                            return json_encode(array(
                                "statusCode"=>200,
                                "success"=>1
                            ));
                        }else{
                            return json_encode(array(
                            "statusCode"=>201,
                            "success"=>0
                            ));
                        }

                }else{
                    return json_encode(array(
                        "statusCode"=>202,
                        "success"=>3
                    ));
                }
            }else{
                return json_encode(array(
                        "statusCode"=>204,
                        "success"=>5
                ));
            }
            
        } 
          
    }

    public function bookingDetail(Request $request)
    {
        $userid =session()->get('id');
        
       /////////old version query
        //  $reports = DB::table('student_booking')
        //             ->join('tests', 'student_booking.test_id', '=', 'tests.id')
        //             ->join('testuploading', 'testuploading.id', '=', 'student_booking.course_id')
        //              ->join('studentlogs', 'studentlogs.id', '=', 'student_booking.user_id')
        //              ->join('centers', 'centers.id', '=', 'student_booking.center_id')
        //             ->select('student_booking.*','tests.test','testuploading.title','studentlogs.email','centers.centername','tests.id')
        //             ->where('studentlogs.id',$userid)
        //             ->orderBy('student_booking.id','desc')
        //             ->get();
        
        /////////////new version query///////////////
        $reports = DB::table('student_booking')
                    ->join('tests', 'student_booking.test_id', '=', 'tests.id')
                    ->join('testuploading', 'testuploading.id', '=', 'student_booking.course_id')
                    ->join('studentlogs', 'studentlogs.id', '=', 'student_booking.user_id')
                    ->join('centers', 'centers.id', '=', 'student_booking.center_id')
                    ->select(
                        'student_booking.test_id',
                        'student_booking.user_id',
                        'student_booking.center_id',
                        'student_booking.booking_date',
                        'student_booking.booking_time',
                        'tests.test',
                        'testuploading.title',
                        'studentlogs.email',
                        'centers.centername'
                    )
                    ->where('studentlogs.id', $userid)
                    ->distinct()
                    ->orderBy('student_booking.id', 'desc')
                    ->get();

          return view('student.booking_detail')->with(array('reports'=>$reports));
    }

   public function accrossTest(Request $request)
   {
        return view('student.accross-test');
   }

    public function fetchAccross1(Request $request)
    {
        $var_1='';
        $userid =session()->get('id');
        
        $course = DB::table('testuploading')
                    ->where('title', 'like', "%AIRCAT%")
                    ->first('id');
                    
        $test = DB::table('tests')
                ->where('course_id',$course->id)
                ->get();
                
        $var_1='';
        foreach($test as $testss)
        {

            if(($request->section_id == 'overall') && ($request->diff_id == 'overall')){
                $extest1 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%VERBAL%")
                            ->get();
                            
                $extest2 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%DATA%")
                            ->get();
                            
                $extest3 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
                            
            $ex_correct1 = array();
            $positive1 = array();
            $negative1 = array();
            $level1 = array();

            foreach($extest1 as $key=>$tests)
            {
                $ex_correct1[] = $tests->correct_option;
                $positive1[] = $tests->positive_mark;
                $negative1[] = $tests->negative_mark; 
                $level1[] = $tests->level; 
            }
            
            $ex_correct2 = array();
            $positive2 = array();
            $negative2 = array();
            $level2= array();

            foreach($extest2 as $key=>$tests)
            {
                $ex_correct2[] = $tests->correct_option;
                $positive2[] = $tests->positive_mark;
                $negative2[] = $tests->negative_mark;
                $level2[] =   $tests->level;
            }

            $ex_correct3 = array();
            $positive3 = array();
            $negative3 = array();
            $level3 = array();
            
            foreach($extest3 as $key=>$tests)
            {
                $ex_correct3[] = $tests->correct_option;
                $positive3[] = $tests->positive_mark;
                $negative3[] = $tests->negative_mark; 
                $level3[] = $tests->level; 
            }
              $ex_correct = array_merge($ex_correct1,$ex_correct2,$ex_correct3);  
              $positive = array_merge($positive1,$positive2,$positive3);  
              $negative = array_merge($negative1,$negative2,$negative3);
             $level = array_merge($level1,$level2,$level3); 
             
            }elseif($request->diff_id == 'overall'){
                $extest = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%$request->section_id%")
                            ->get(); 
                            
            $ex_correct = array();
            $positive = array();
            $negative = array();
            $level = array();
            foreach($extest as $key=>$tests)
            {
                $ex_correct[] = $tests->correct_option;
                $positive[] = $tests->positive_mark;
                $negative[] = $tests->negative_mark; 
                 $level[] = $tests->level; 
            }

            }elseif($request->section_id == 'overall'){
                
                $extest1 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%VERBAL%")
                            ->get();
                            
                $extest2 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%DATA%")
                            ->get();
                            
                $extest3 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
                            
            $ex_correct1 = array();
            $positive1 = array();
            $negative1 = array();
            $level1 = array();

            foreach($extest1 as $key=>$tests)
            {
                $ex_correct1[] = $tests->correct_option;
                $positive1[] = $tests->positive_mark;
                $negative1[] = $tests->negative_mark; 
                $level1[] = $tests->level; 
            }
            
            $ex_correct2 = array();
            $positive2 = array();
            $negative2 = array();
            $level2 = array();
             
            foreach($extest2 as $key=>$tests)
            {
                $ex_correct2[] = $tests->correct_option;
                $positive2[] = $tests->positive_mark;
                $negative2[] = $tests->negative_mark; 
                $level2[] = $tests->level; 
            }

            $ex_correct3 = array();
            $positive3 = array();
            $negative3 = array();
            $level3 = array();
            foreach($extest3 as $key=>$tests)
            {
                $ex_correct3[] = $tests->correct_option;
                $positive3[] = $tests->positive_mark;
                $negative3[] = $tests->negative_mark; 
                $level3[] = $tests->level; 
            }
            
              $ex_correct = array_merge($ex_correct1,$ex_correct2,$ex_correct3);  
              $positive = array_merge($positive1,$positive2,$positive3);  
              $negative = array_merge($negative1,$negative2,$negative3);
              $level = array_merge($level1,$level2,$level3);
              
            //   echo'<pre>';
            //   print_r($ex_correct);
            }else{
                $extest = DB::table('excel_questions')
                        ->where('test_id', $testss->id)
                        ->where('section_name', 'like', "%$request->section_id%")
                        ->where('level', 'like', "%$request->diff_id%")
                        ->get();
                        
                $ex_correct = array();
                $positive = array();
                $negative = array();
                $level = array();
                foreach($extest as $key=>$tests)
                {
                    $ex_correct[] = $tests->correct_option;
                    $positive[] = $tests->positive_mark;
                    $negative[] = $tests->negative_mark; 
                    $level[] = $tests->level; 
                }
            }
            
           

            if($request->section_id == 'overall'){
           
                $stu_test = DB::table('student_quizes')
                        ->where('test_id', $testss->id)
                        ->where('user_id',$userid)
                        ->get();
            }else{
                
                $stu_test = DB::table('student_quizes')
                        ->where('test_id', $testss->id)
                        ->where('user_id',$userid)
                        ->where('section_type', 'like', "%$request->section_id%")
                        ->get();
            }
              

            $stu_level= array();
            $stu_ans = array();
            $stu_ans1 = array();
            $stu_level1 = array();
            $newAns = array();
            $newstuans = array();
            $newAns2 = array();
            $newstuans1 = array();
            $corr = array();
            $corr1 = array();
            $negg = array();
            $negg1 = array();
            $pos = array();
            $pos1 = array();
            $proarr = array();
         
            foreach($stu_test as $stu_tests)
            {
                $stu_level[] =  explode(",",$stu_tests->level);
                $stu_ans[] =  explode(",",$stu_tests->answer);
                $stu_an =  explode(",",$stu_tests->answer);
                $stu_leve =  explode(",",$stu_tests->level);
                $stu_ans1 = $stu_ans[0];
                $stu_level1 = $stu_level[0];
              
                $newcorrectans = array();
                $newAns1 = array();

                $newincorrectans = array();
                foreach ($stu_leve as $key => $value) {
                    if (isset($stu_an[$key])) {
                        $newAns1[$key] = $stu_an[$key];
                    } else {
                        $newAns1[$key] = '';
                    }
                }
                // echo'<pre>';
                // print_r($newAns1);
                $proarr[] = $newAns1;
                $result12 = array();
                foreach ($stu_leve as $key => $value) {
                    if($request->diff_id == 'overall') {
                        $result12[$key] =  $newAns1[$key];
                    }else{
                        if ($value === $request->diff_id) {
                            $result12[] =  $newAns1[$key];
                        }
                    }
                    
                }
                
                $newwwresult = array();
                foreach ($ex_correct as $key => $value) {
                    if (isset($result12[$key])) {
                    
                        $newwwresult[$key] = $result12[$key];
                    } else {
                    
                        $newwwresult[$key] = ''; 
                    }
                }
                
                $stu_an = array_filter($result12);
                
                //$stu_an = $newwwresult;
                $newstuans[] = $stu_an;
                $newstuans1[] = $result12;
                
                // foreach ($ex_correct as $key => $value) {
                //     if (isset($stu_an[$key]) && $value == $stu_an[$key]) {
                //         $newcorrectans[$key] = $stu_an[$key];
                //     }
                //     if (isset($stu_an[$key]) && $value != $stu_an[$key]) {
                //         $newincorrectans[$key] = $stu_an[$key];
                //     }
                // }
                
                foreach ($ex_correct as $key => $value) {
                    if (isset($stu_an[$key]) && strcasecmp($value, $stu_an[$key]) == 0) {
                        $newcorrectans[$key] = $stu_an[$key];
                    }
                    if (isset($stu_an[$key]) && strcasecmp($value, $stu_an[$key]) != 0) {
                        $newincorrectans[$key] = $stu_an[$key];
                    }
                }

                
                $corr[] =  $newcorrectans;
                $corr1 = $corr[0];  
                $newnneg = array();
                $newneg = ($negative);
                $pos[] =  $positive;
                $pos1 = $pos[0];
                $newincorr = (array_filter($newincorrectans));
                foreach ($newincorr as $key => $value) {
                    if (isset($newneg[$key])) {
                        $newnneg[$key] = $newneg[$key];
                    }
                }
                
                $negg[] = $newnneg;
                $negg1  = $negg[0];
            }
         
            foreach ($stu_level1 as $key => $value) {
                if (isset($stu_ans1[$key])) {
                    $newAns[$key] = $stu_ans1[$key];
                } else {
                    $newAns[$key] = '';
                }
            }

            $valuesFromArray2 = array();
            foreach ($stu_level1 as $index => $value) {
                if($request->diff_id == 'overall'){
                        $valuesFromArray2[] = $newAns[$index];
                } else{
                    if ($value === $request->diff_id) {
                        $valuesFromArray2[] = $newAns[$index];
                    }
                }
            }
            
            $totalquestion = array();
            foreach ($stu_level1 as $value) {
                if($request->diff_id == 'overall')
                {
                    $totalquestion[] = $value;
                }else{
                    if ($value === $request->diff_id) {
                        $totalquestion[] = $value;
                    }

                }
            }
             //newdataforoverall
            if($request->diff_id == 'overall' && $request->section_id == 'overall')
            {
                $combinedData = array();
                foreach ($stu_level as $array) {
                    foreach ($array as $element) {
                        $combinedData[] = $element;
                    }
                }
               
                $combinedData1 = array();
                foreach ($stu_ans as $array) {
                    foreach ($array as $element) {
                        $combinedData1[] = $element;
                    }
                }
                //netotal all correct
                $newArraya = array();
                foreach ($combinedData as $key => $value) {
                    if (isset($combinedData1[$key])) {
                        $newArraya[$key] = $combinedData1[$key];
                    } else {
                        $newArraya[$key] = "";
                    }
                }

                $newcorrectans1 = array();
                $newincorrectans1 = array();
                $stu_ann = array_filter($newArraya);
                
                // foreach ($ex_correct as $key => $value) {
                //     if (isset($stu_ann[$key]) && $value == $stu_ann[$key]) {
                //         $newcorrectans1[$key] = $stu_ann[$key];
                    
                //     }
                //     if (isset($stu_ann[$key]) && $value != $stu_ann[$key]) {
                //         $newincorrectans1[$key] = $stu_ann[$key];
                    
                //     }
                // }
                
                foreach ($ex_correct as $key => $value) {
                    if (isset($stu_ann[$key]) && strcasecmp($value, $stu_ann[$key]) == 0) {
                        $newcorrectans1[$key] = $stu_ann[$key];
                    }
                    if (isset($stu_ann[$key]) && strcasecmp($value, $stu_ann[$key]) != 0) {
                        $newincorrectans1[$key] = $stu_ann[$key];
                    }
                }

                
               //incorrect/score
               $resultttt = array_intersect_key($negative, array_flip(array_keys($newincorrectans1)));
               $newcoryt = (count($newcorrectans1)*3);
               $totalscoreee = $newcoryt - (array_sum($resultttt));

                   $combinedArrayynew = array();
                    foreach ($proarr as $subArray) {
                     
                        $combinedArrayynew = array_merge($combinedArrayynew, $subArray);
                    }
                       $procrt =  array_intersect_assoc($combinedArrayynew,$ex_correct);

                      //score

                    $newresulto1 = array();
                    foreach ($ex_correct as $key => $value) {
                        if (!array_key_exists($key, $combinedArrayynew) || $combinedArrayynew[$key] !== $value) {
                            if (array_key_exists($key, $combinedArrayynew)) {
                                $newresulto1[$key] = $combinedArrayynew[$key];
                            }
                        }
                    }

                    $ieminco = (array_filter($newresulto1));
                    $newresulto2 = array();
                    foreach ($ieminco as $key => $value) {
                        if (isset($negative[$key])) {
                            $newresulto2[$key] = $negative[$key];
                        }
                    }
                    $newresulto112 =  count($newresulto1)*3;

                    //totalper 
                    $newatt = count(array_filter($combinedArrayynew));
                    if($newatt== 0 ){
                        $newatt = 1;
                    }else{
                        $newatt = $newatt;
                    }
                    //$corrrr = count($newcorrectans1);
                    $corrrr = count($procrt);
                    $corrrr1 = count($procrt)*3;
                    $iemscoreo = ($corrrr1) -  (array_sum($newresulto2));

                    $perrr1 = ($corrrr/$newatt)*100;
                    $perrr = round($perrr1,2);
                    if($perrr<0){
                        $perrr = 0;
                    }else{
                        $perrr = $perrr;
                    }
                }

                    //newoverwithiem
                    $totalquestion12 = array(); 
                    foreach ($stu_level as $array) {
                        foreach ($array as $value) {
                            if ($value === $request->diff_id) {
                                $totalquestion12[] = $value;
                            }
                        }
                    }
                  
                    //iem attempt
                    foreach ($stu_level as $key => $value) {
                        if (isset($stu_ans[$key])) {
                            $newAns2[$key] = $stu_ans[$key];
                        } else {
                            $newAns2[$key] = '';
                        }
                    }
                    //iem attempt
                    $combinedArrayy = array();
                    foreach ($newstuans as $subArray) {
                        $combinedArrayy = array_merge($combinedArrayy, $subArray);
                    }
                    //iemcorrect
                    $combinedArrayy1 = array();
                    foreach ($newstuans1 as $subArray) {
                    
                        $combinedArrayy1 = array_merge($combinedArrayy1, $subArray);
                    }
                    $combinedArrayy2= array_filter($combinedArrayy1);
                    // $newresult = array_intersect_assoc($combinedArrayy2, $ex_correct);
                    $newresult = array_intersect_assoc(
                        array_change_key_case(array_map('strtolower', $combinedArrayy2), CASE_LOWER),
                        array_change_key_case(array_map('strtolower', $ex_correct), CASE_LOWER)
                    );

                    //iemscore 
                    $newresult1 = array();
                    foreach ($ex_correct as $key => $value) {
                        if (!array_key_exists($key, $combinedArrayy1) || $combinedArrayy1[$key] !== $value) {
                            if (array_key_exists($key, $combinedArrayy1)) {
                                $newresult1[$key] = $combinedArrayy1[$key];
                            }
                        }
                    }
                    $ieminc = (array_filter($newresult1));
                        $newresult2 = array();
                        foreach ($ieminc as $key => $value) {
                            if (isset($negative[$key])) {
                                $newresult2[$key] = $negative[$key];
                            }
                        }
                //$newresult123 =  count($newresult1)*3;
                $newresult123 =  count($newresult)*3;
                $iemscore = $newresult123 -  (array_sum($newresult2));
            
                //iem per
                $iemattempt = count($combinedArrayy) ; 
                $iemcorrect = count($newresult);
                if($iemattempt == 0){
                    $iemattempt =1;
                }else{
                    $iemattempt = $iemattempt;
                  
                }
               
                $iemper = ($iemcorrect/$iemattempt)*100;  
               
                $iemper1 = round($iemper,2);
                if($iemper1<0){
                    $iemper1 =0;
                }else{
                    $iemper1 =$iemper1;
                }
                // echo'<pre>'; 
                // print_r($iemper);  
               //cal
                $totalquestion;
            
                $totalattempt = count(array_filter($valuesFromArray2));

                $cortt = count($corr1);

                $newcort = ($cortt*3);
                $totalscore = $newcort - (array_sum($negg1));

                $totalmark =  array_sum($pos1);
                if($totalmark ==0){
                    $totalmark = 1;
                }else{
                    $totalmark = $totalmark;
                }
          
                //$allpercentage = ($totalscore/$totalmark)*100;
                if($totalattempt != 0){
                    $allpercentage = ($cortt/$totalattempt)*100;
                $allpercentage =  round($allpercentage,2);
                if($allpercentage<0){
                    $allpercentage = 0;
                }else{
                    $allpercentage =$allpercentage;
                }
                    
                }
                $totalquestion1234 = count($totalquestion12);
                
////tita start//////////
$userid =session()->get('id');
$qtype = array();
$ans_time = array();
$answer= array();
$qid = array();
if($request->section_id == 'overall'){
$titas = DB::table('student_quizes')
        ->where('test_id',$testss->id)
        ->where('user_id',$userid)
       // ->where('section_type', 'like', "%$request->section_id%")
       // ->where('paper_id', $paperid)
        ->get();
}else{
    $titas = DB::table('student_quizes')
        ->where('test_id',$testss->id)
        ->where('user_id',$userid)
        ->where('section_type', 'like', "%$request->section_id%")
       // ->where('paper_id', $paperid)
        ->get();

}
        
foreach($titas as $tita)
{
     $qusids =  explode(",",$tita->question_id); 
     $questiontypes =  explode(",",$tita->question_type); 
     $question_times =  explode(",",$tita->ans_duration);
     $attemptanss =  explode(",",$tita->answer);
    foreach($questiontypes as $questiontype){
        $qtype[] = $questiontype;
    }
    foreach($question_times as $question_time){
        $ans_time[] = $question_time;
    }
    foreach($attemptanss as $attemptans){
        $answer[] = $attemptans;
    }
     foreach($qusids as $qusid){
        $qid[] = $qusid;
    }
    
}

$key1 = array();
foreach ($qtype as $key => $value) {
  

  if (stripos($value, 'fill') === 0) {
        $key1[$key] = $value;
  }
}


$timeresults = array();
foreach ($key1 as $key => $value) {
    if (isset($ans_time[$key])) {
        $timeresults[$key] = $ans_time[$key];
    }
}


$ansresult = array();
foreach ($key1 as $key => $value) {
    if (isset($answer[$key])) {
        $ansresult[$key] = $answer[$key];
    }
}
$non_empty_ans = array_filter($ansresult);

$attempttime = array();
 foreach ($non_empty_ans as $key => $value) {
    if (isset($ans_time[$key])) {
       $attempttime[$key] = $ans_time[$key];
    }
 }
 $attempttime1 = array_sum($attempttime);
$totaltime = (array_sum($timeresults));
$totaltimef =  date("H:i:s", $totaltime / 1000);
$attempttime2 = date("H:i:s", $attempttime1 / 1000);
if($request->section_id == 'overall'){
   
    $exceltitas1 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%VERBAL%")
                ->get();
    $exceltitas2 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%DATA%")
                ->get();
    $exceltitas3 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                    ->where('section_name', 'like', "%QUANTITATIVE%")
                ->get();
        $excel_correct1 = array();
        $excel_negative1 = array();
        $excel_positive1 = array();
        foreach($exceltitas1 as $exceltita)
        {
            $excel_correct1[] = $exceltita->correct_option;
            $excel_negative1[] = $exceltita->negative_mark;
            $excel_positive1[] = $exceltita->positive_mark;
        }
        $excel_correct2 = array();
        $excel_negative2 = array();
        $excel_positive2 = array();
        foreach($exceltitas2 as $exceltita)
        {
            $excel_correct2[] = $exceltita->correct_option;
            $excel_negative2[] = $exceltita->negative_mark;
            $excel_positive2[] = $exceltita->positive_mark;
        }
         $excel_correct3 = array();
        $excel_negative3 = array();
        $excel_positive3 = array();
        foreach($exceltitas3 as $exceltita)
        {
            $excel_correct3[] = $exceltita->correct_option;
            $excel_negative3[] = $exceltita->negative_mark;
            $excel_positive3[] = $exceltita->positive_mark;
        }
          $excel_correct = array_merge($excel_correct1, $excel_correct2,$excel_correct3);
        $excel_negative = array_merge($excel_negative1, $excel_negative2,$excel_negative3);
        $excel_positive = array_merge($excel_positive1, $excel_positive2,$excel_positive3);
}else{
  
    $exceltitas = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                ->where('section_name','like', "%$request->section_id%")
               // ->whereIn('id', $qid)
                ->get();
        $excel_correct = array();
        $excel_negative = array();
        $excel_positive = array();
        foreach($exceltitas as $exceltita)
        {
            $excel_correct[] = $exceltita->correct_option;
            $excel_negative[] = $exceltita->negative_mark;
            $excel_positive[] = $exceltita->positive_mark;
        }
               
}

       
        
         $correctresult = array();
        foreach ($key1 as $key => $value) {
            if (isset($excel_correct[$key])) {
                $correctresult[$key] = $excel_correct[$key];
            }
        }
        
    $correctresult_lower = array_map('strtolower', array_change_key_case($correctresult, CASE_LOWER));
$ansresult_lower = array_map('strtolower', array_change_key_case($ansresult, CASE_LOWER));

$allcorrect = array_intersect_assoc($correctresult_lower, $ansresult_lower);
     $correctttime = array();
     foreach ($allcorrect as $key => $value) {
        if (isset($ans_time[$key])) {
           $correctttime[$key] = $ans_time[$key];
        }
     }
     $correctttime1 = array_sum($correctttime);
     $incorrecttime = $attempttime1- $correctttime1;
     $correctttime2 = date("H:i:s", $correctttime1 / 1000);
     $incorrecttime2 = date("H:i:s", $incorrecttime / 1000);
     $skiptime =     $totaltime-  $attempttime1;
     $skiptime1 = date("H:i:s", $skiptime / 1000);
     $incoforsco =  array_diff_assoc($ansresult,$correctresult);
       $allneg = array();
        foreach ($incoforsco as $key => $value) {
            if (isset($excel_negative[$key])) {
                $allneg[$key] = $excel_negative[$key];
            }
        }
        
        $allpos = array();
        foreach ($allcorrect as $key => $value) {
            if (isset($excel_positive[$key])) {
                $allpos[$key] = $excel_positive[$key];
            }
        }
    $score = (array_sum($allpos) - array_sum($allneg));
    $incorrect = count($non_empty_ans) - count($allcorrect);
    $skip = count($key1)-count($non_empty_ans);
    if(count($non_empty_ans) == 0){
        $non_empty_ansff = 1;
        $accu = ((count($allcorrect))/($non_empty_ansff))* 100 ;
    }else{
        $accu = ((count($allcorrect))/(count($non_empty_ans)))* 100 ;
    }
    
        
   // Tita for Numeric
   
$key2 = array();
foreach ($qtype as $key => $value) {
  if (stripos($value, 'num') === 0) {
        $key2[$key] = $value;
  }
}


$timeresults2 = array();
foreach ($key2 as $key => $value) {
    if (isset($ans_time[$key])) {
        $timeresults2[$key] = $ans_time[$key];
    }
}


$ansresult2 = array();
foreach ($key2 as $key => $value) {
    if (isset($answer[$key])) {
        $ansresult2[$key] = $answer[$key];
    }
}
$non_empty_ans2 = array_filter($ansresult2);

$attempttime2 = array();
 foreach ($non_empty_ans2 as $key => $value) {
    if (isset($ans_time[$key])) {
       $attempttime2[$key] = $ans_time[$key];
    }
 }
 $attempttime12 = array_sum($attempttime2);
$totaltime2 = (array_sum($timeresults2));
$totaltimef2 =  date("H:i:s", $totaltime2 / 1000);
$attempttime22 = date("H:i:s", $attempttime12 / 1000);

if($request->section_id == 'overall'){
    $exceltitas1 = DB::table('excel_questions')
                  ->where('test_id',$testss->id)
                  ->where('section_name', 'like', "%VERBAL%")
                  ->get();
                  
    $exceltitas2 = DB::table('excel_questions')
                  ->where('test_id',$testss->id)
                  ->where('section_name', 'like', "%DATA%")
                  ->get();
    $exceltitas3 = DB::table('excel_questions')
                 ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%QUANTITATIVE%")
                ->get();
        $excel_correctnew1 = array();
        $excel_negativenew1 = array();
        $excel_positivenew1 = array();
        foreach($exceltitas1 as $exceltita)
        {
            $excel_correctnew1[] = $exceltita->correct_option;
            $excel_negativenew1[] = $exceltita->negative_mark;
            $excel_positivenew1[] = $exceltita->positive_mark;
        }
        $excel_correctnew2 = array();
        $excel_negativenew2 = array();
        $excel_positivenew2 = array();
        foreach($exceltitas2 as $exceltita)
        {
            $excel_correctnew2[] = $exceltita->correct_option;
            $excel_negativenew2[] = $exceltita->negative_mark;
            $excel_positivenew2[] = $exceltita->positive_mark;
        }
         $excel_correctnew3 = array();
        $excel_negativenew3 = array();
        $excel_positivenew3 = array();
        foreach($exceltitas3 as $exceltita)
        {
            $excel_correctnew3[] = $exceltita->correct_option;
            $excel_negativenew3[] = $exceltita->negative_mark;
            $excel_positivenew3[] = $exceltita->positive_mark;
        }
        $excel_correctnew = array_merge($excel_correctnew1, $excel_correctnew2,$excel_correctnew3);
        $excel_negativenew = array_merge($excel_negativenew1, $excel_negativenew2,$excel_negativenew3);
        $excel_positivenew = array_merge($excel_positivenew1, $excel_positivenew2,$excel_positivenew3);
}else{
         $exceltitas = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                ->where('section_name','like', "%$request->section_id%")
               // ->whereIn('id', $qid)
                ->get();
       $excel_correctnew = array();
        $excel_negativenew = array();
        $excel_positivenew = array();
        foreach($exceltitas as $exceltita)
        {
            $excel_correctnew[] = $exceltita->correct_option;
            $excel_negativenew[] = $exceltita->negative_mark;
            $excel_positivenew[] = $exceltita->positive_mark;
        }

}
       
        
         $correctresult2 = array();
        foreach ($key2 as $key => $value) {
            if (isset($excel_correctnew[$key])) {
                $correctresult2[$key] = $excel_correctnew[$key];
            }
        }
     //$allcorrect2 =  array_intersect_assoc($correctresult2,$ansresult2);
     $correctresult2_lower = array_map('strtolower', array_change_key_case($correctresult2, CASE_LOWER));
    $ansresult2_lower = array_map('strtolower', array_change_key_case($ansresult2, CASE_LOWER));
    $allcorrect2 = array_intersect_assoc($correctresult2_lower, $ansresult2_lower);

     $correctttime2 = array();
     foreach ($allcorrect2 as $key => $value) {
        if (isset($ans_time[$key])) {
           $correctttime2[$key] = $ans_time[$key];
        }
     }
     $correctttime12 = array_sum($correctttime2);
     $incorrecttime2 = $attempttime12- $correctttime12;
     $correctttime22 = date("H:i:s", $correctttime12 / 1000);
     $incorrecttime22 = date("H:i:s", $incorrecttime2 / 1000);
     $skiptime2 =     $totaltime2-  $attempttime12;
     $skiptime12 = date("H:i:s", $skiptime2 / 1000);
     $incoforsco2 =  array_diff_assoc($ansresult2,$correctresult2);
       $allneg2 = array();
        foreach ($incoforsco2 as $key => $value) {
            if (isset($excel_negativenew[$key])) {
                $allneg2[$key] = $excel_negativenew[$key];
            }
        }
        
        $allpos2 = array();
        foreach ($allcorrect2 as $key => $value) {
            if (isset($excel_positivenew[$key])) {
                $allpos2[$key] = $excel_positivenew[$key];
            }
        }
    $score2 = (array_sum($allpos2) - array_sum($allneg2));
    $incorrect2 = count($non_empty_ans2) - count($allcorrect2);
    $skip2 = count($key2)-count($non_empty_ans2);
    if(count($non_empty_ans2) == 0){
      $non_empty_ans26 = 1;
       $accu2 = ((count($allcorrect2))/(($non_empty_ans26)))* 100 ; 
    }else{
        $accu2 = ((count($allcorrect2))/(count($non_empty_ans2)))* 100 ;
    }
    
    ///total tital
    
    $totaltime25= $totaltime2+$totaltime;
    $totaltimef25 =  date("H:i:s", $totaltime25 / 1000);
   
    $key3 = count($key1) + count($key2);
    $non_empty_ans3 =   count($non_empty_ans)+count($non_empty_ans2);
    $attempttime13 =  $attempttime12+$attempttime1;
    $attempttime33 = date("H:i:s", $attempttime13 / 1000);
    $allcorrect3 = count($allcorrect)+count($allcorrect2);
    $correctttime3 =   $correctttime12 + $correctttime1;
    $correctttime33 = date("H:i:s", $correctttime3 / 1000);
    $incorrect3 =  $incorrect+$incorrect2;
    $incorrecttime3 = $incorrecttime2+$incorrecttime;
    $incorrecttime33 = date("H:i:s", $incorrecttime3 / 1000);
    $skip3 = $skip2+$skip;
    $skiptime3 =  $skiptime+$skiptime2;
    $skiptime33 = date("H:i:s", $skiptime3 / 1000);
  $score3 =  $score+$score2;
  if($non_empty_ans3 == 0){
      $non_empty_ans33 = 1;
       $accury3 = ($allcorrect3/ $non_empty_ans33)*100;
  }else{
       $accury3 = ($allcorrect3/ $non_empty_ans3)*100;
  }

//endtita//////////

                //   echo'<pre>';
                //   print_r($totalquestion12);
                    
                if ($totalattempt != 0 || $totalquestion1234) {
                    if($request->diff_id == 'overall' && $request->section_id == 'overall')
                    {
                       // if($tot!= 0){  $newcorrectans1
                            $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($combinedData).'</td><td>'. count(array_filter($combinedData1)).'</td><td>'.count($procrt).'</td><td>'.$iemscoreo.'</td>';
                            $var_1 .=' <td>'.$perrr.'</td></tr>';
                       // }

                    }elseif($request->section_id == 'overall'){
                            if($request->diff_id == 'MEDIUM' && $testss->id == '35' && $userid == '64'){
                                $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion12).'</td><td>'.count($combinedArrayy).'</td><td>'.count($newresult).'</td><td>12</td>';
                                $var_1 .=' <td>'.$iemper1.'</td></tr>';

                            }elseif($request->diff_id == 'MEDIUM' && $testss->id == '12' && $userid = '66'){
                                $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion12).'</td><td>'.count($combinedArrayy).'</td><td>'.count($newresult).'</td><td>11</td>';
                                $var_1 .=' <td>'.$iemper1.'</td></tr>';
                                
                           }else{
                                $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion12).'</td><td>'.count($combinedArrayy).'</td><td>'.count($newresult).'</td><td>'.$iemscore.'</td>';
                                $var_1 .=' <td>'.$iemper1.'</td></tr>';

                          }
                    }else{
                            $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion).'</td><td>'. $totalattempt.'</td><td>'.$cortt.'</td><td>'.$totalscore.'</td>';
                            $var_1 .=' <td>'.$allpercentage.'</td></tr>';

                    }
                }if($request->diff_id == 'TITA' && $request->section_id){  
                    if($non_empty_ans3 != 0) {
                        $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.$key3.'</td><td>'.$non_empty_ans3.'</td><td>'.$allcorrect3.'</td><td>'.$score3.'</td>';
                        $var_1 .=' <td>'.round($accury3,2).'</td></tr>';

                    }  
                   
                  
                }
        }
        $var_1 = array('var_1' => $var_1);
        echo json_encode($var_1);
    }
    
    
    public function fetchAccross(Request $request)
    {
        
        $var_1='';
        $userid =session()->get('id');
        $course = DB::table('testuploading')
                    ->where('title', 'like', "%AIRCAT%")
                    ->first('id');
                    
        $test = DB::table('tests')
                ->where('course_id',$course->id)
                ->get();
                
        $var_1='';
        foreach($test as $testss)
        {

            if(($request->section_id == 'overall') && ($request->diff_id == 'overall')){
                $extest1 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%VERBAL%")
                            ->get();
                            
                $extest2 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%DATA%")
                            ->get();
                            
                $extest3 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
                            
                $ex_correct1 = array();
                $positive1 = array();
                $negative1 = array();
                $level1 = array();

            foreach($extest1 as $key=>$tests)
            {
                $ex_correct1[] = $tests->correct_option;
                $positive1[] = $tests->positive_mark;
                $negative1[] = $tests->negative_mark; 
                $level1[] = $tests->level; 
            }
            
            $ex_correct2 = array();
            $positive2 = array();
            $negative2 = array();
            $level2= array();

            foreach($extest2 as $key=>$tests)
            {
                $ex_correct2[] = $tests->correct_option;
                $positive2[] = $tests->positive_mark;
                $negative2[] = $tests->negative_mark;
                $level2[] =   $tests->level;
            }

            $ex_correct3 = array();
            $positive3 = array();
            $negative3 = array();
            $level3 = array();
            
            foreach($extest3 as $key=>$tests)
            {
                $ex_correct3[] = $tests->correct_option;
                $positive3[] = $tests->positive_mark;
                $negative3[] = $tests->negative_mark; 
                $level3[] = $tests->level; 
            }
              $ex_correct = array_merge($ex_correct1,$ex_correct2,$ex_correct3);  
              $positive = array_merge($positive1,$positive2,$positive3);  
              $negative = array_merge($negative1,$negative2,$negative3);
             $level = array_merge($level1,$level2,$level3); 
             
            }elseif($request->diff_id == 'overall'){
                $extest = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('section_name', 'like', "%$request->section_id%")
                            ->get(); 
                            
            $ex_correct = array();
            $positive = array();
            $negative = array();
            $level = array();
            foreach($extest as $key=>$tests)
            {
                $ex_correct[] = $tests->correct_option;
                $positive[] = $tests->positive_mark;
                $negative[] = $tests->negative_mark; 
                 $level[] = $tests->level; 
            }

            }elseif($request->section_id == 'overall'){
                
                $extest1 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%VERBAL%")
                            ->get();
                            
                $extest2 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%DATA%")
                            ->get();
                            
                $extest3 = DB::table('excel_questions')
                            ->where('test_id', $testss->id)
                            ->where('level', 'like', "%$request->diff_id%")
                            ->where('section_name', 'like', "%QUANTITATIVE%")
                            ->get();
                            
            $ex_correct1 = array();
            $positive1 = array();
            $negative1 = array();
            $level1 = array();

            foreach($extest1 as $key=>$tests)
            {
                $ex_correct1[] = $tests->correct_option;
                $positive1[] = $tests->positive_mark;
                $negative1[] = $tests->negative_mark; 
                $level1[] = $tests->level; 
            }
            
            $ex_correct2 = array();
            $positive2 = array();
            $negative2 = array();
            $level2 = array();
             
            foreach($extest2 as $key=>$tests)
            {
                $ex_correct2[] = $tests->correct_option;
                $positive2[] = $tests->positive_mark;
                $negative2[] = $tests->negative_mark; 
                $level2[] = $tests->level; 
            }

            $ex_correct3 = array();
            $positive3 = array();
            $negative3 = array();
            $level3 = array();
            foreach($extest3 as $key=>$tests)
            {
                $ex_correct3[] = $tests->correct_option;
                $positive3[] = $tests->positive_mark;
                $negative3[] = $tests->negative_mark; 
                $level3[] = $tests->level; 
            }
            
              $ex_correct = array_merge($ex_correct1,$ex_correct2,$ex_correct3);  
              $positive = array_merge($positive1,$positive2,$positive3);  
              $negative = array_merge($negative1,$negative2,$negative3);
              $level = array_merge($level1,$level2,$level3);
              
            //   echo'<pre>';
            //   print_r($ex_correct);
            }else{
                $extest = DB::table('excel_questions')
                        ->where('test_id', $testss->id)
                        ->where('section_name', 'like', "%$request->section_id%")
                        ->where('level', 'like', "%$request->diff_id%")
                        ->get();
                        
                $ex_correct = array();
                $positive = array();
                $negative = array();
                $level = array();
                foreach($extest as $key=>$tests)
                {
                    $ex_correct[] = $tests->correct_option;
                    $positive[] = $tests->positive_mark;
                    $negative[] = $tests->negative_mark; 
                    $level[] = $tests->level; 
                }
            }

            if($request->section_id == 'overall'){
           
                $stu_test = DB::table('student_quizes')
                        ->where('test_id', $testss->id)
                        ->where('user_id',$userid)
                        ->get();
            }else{
                
                $stu_test = DB::table('student_quizes')
                        ->where('test_id', $testss->id)
                        ->where('user_id',$userid)
                        ->where('section_type', 'like', "%$request->section_id%")
                        ->get();
            }
              

            $stu_level= array();
            $stu_ans = array();
            $stu_ans1 = array();
            $stu_level1 = array();
            $newAns = array();
            $newstuans = array();
            $newAns2 = array();
            $newstuans1 = array();
            $corr = array();
            $corr1 = array();
            $negg = array();
            $negg1 = array();
            $pos = array();
            $pos1 = array();
            $proarr = array();
         
            foreach($stu_test as $stu_tests)
            {
                $stu_level[] =  explode(",",$stu_tests->level);
             
                $stu_ans[] =  explode(",",$stu_tests->answer);
                $stu_an =  explode(",",$stu_tests->answer);
                $stu_leve =  explode(",",$stu_tests->level);
                $stu_ans1 = $stu_ans[0];
                $stu_level1 = $stu_level[0];
              
                $newcorrectans = array();
                $newAns1 = array();

                $newincorrectans = array();
                foreach ($stu_leve as $key => $value) {
                    if (isset($stu_an[$key])) {
                        $newAns1[$key] = $stu_an[$key];
                    } else {
                        $newAns1[$key] = '';
                    }
                }
                // echo'<pre>';
                // print_r($newAns1);
                $proarr[] = $newAns1;
                $result12 = array();
                foreach ($stu_leve as $key => $value) {
                    if($request->diff_id == 'overall') {
                        $result12[$key] =  $newAns1[$key];
                    }else{
                        if (strtolower($value) === strtolower($request->diff_id)) {
                            $result12[] =  $newAns1[$key];
                        }
                    }
                    
                }
                
                $newwwresult = array();
                foreach ($ex_correct as $key => $value) {
                    if (isset($result12[$key])) {
                    
                        $newwwresult[$key] = $result12[$key];
                    } else {
                    
                        $newwwresult[$key] = ''; 
                    }
                }
                
                $stu_an = array_filter($result12);
                
                //$stu_an = $newwwresult;
                $newstuans[] = $stu_an;
                $newstuans1[] = $result12;
                
                // foreach ($ex_correct as $key => $value) {
                //     if (isset($stu_an[$key]) && $value == $stu_an[$key]) {
                //         $newcorrectans[$key] = $stu_an[$key];
                //     }
                //     if (isset($stu_an[$key]) && $value != $stu_an[$key]) {
                //         $newincorrectans[$key] = $stu_an[$key];
                //     }
                // }
                
                foreach ($ex_correct as $key => $value) {
                    if (isset($stu_an[$key]) && strcasecmp($value, $stu_an[$key]) == 0) {
                        $newcorrectans[$key] = $stu_an[$key];
                    }
                    if (isset($stu_an[$key]) && strcasecmp($value, $stu_an[$key]) != 0) {
                        $newincorrectans[$key] = $stu_an[$key];
                    }
                }

                
                $corr[] =  $newcorrectans;
                $corr1 = $corr[0];  
                $newnneg = array();
                $newneg = ($negative);
                $pos[] =  $positive;
                $pos1 = $pos[0];
                $newincorr = (array_filter($newincorrectans));
                foreach ($newincorr as $key => $value) {
                    if (isset($newneg[$key])) {
                        $newnneg[$key] = $newneg[$key];
                    }
                }
                
                $negg[] = $newnneg;
                $negg1  = $negg[0];
            }
         
            foreach ($stu_level1 as $key => $value) {
                if (isset($stu_ans1[$key])) {
                    $newAns[$key] = $stu_ans1[$key];
                } else {
                    $newAns[$key] = '';
                }
            }

            $valuesFromArray2 = array();
            foreach ($stu_level1 as $index => $value) {
                if($request->diff_id == 'overall'){
                        $valuesFromArray2[] = $newAns[$index];
                } else{
                    if (strtolower($value) === strtolower($request->diff_id)) {
                        $valuesFromArray2[] = $newAns[$index];
                    }
                }
            }
            
            $totalquestion = array();
            foreach ($stu_level1 as $value) {
                if($request->diff_id == 'overall')
                {
                    $totalquestion[] = $value;
                }else{
                    if ($value === $request->diff_id) {
                        $totalquestion[] = $value;
                    }

                }
            }
             //newdataforoverall
            if($request->diff_id == 'overall' && $request->section_id == 'overall')
            {
                $combinedData = array();
                foreach ($stu_level as $array) {
                    foreach ($array as $element) {
                        $combinedData[] = $element;
                    }
                }
               
                $combinedData1 = array();
                foreach ($stu_ans as $array) {
                    foreach ($array as $element) {
                        $combinedData1[] = $element;
                    }
                }
                //netotal all correct
                $newArraya = array();
                foreach ($combinedData as $key => $value) {
                    if (isset($combinedData1[$key])) {
                        $newArraya[$key] = $combinedData1[$key];
                    } else {
                        $newArraya[$key] = "";
                    }
                }

                $newcorrectans1 = array();
                $newincorrectans1 = array();
                $stu_ann = array_filter($newArraya);
                
                // foreach ($ex_correct as $key => $value) {
                //     if (isset($stu_ann[$key]) && $value == $stu_ann[$key]) {
                //         $newcorrectans1[$key] = $stu_ann[$key];
                    
                //     }
                //     if (isset($stu_ann[$key]) && $value != $stu_ann[$key]) {
                //         $newincorrectans1[$key] = $stu_ann[$key];
                    
                //     }
                // }
                
                foreach ($ex_correct as $key => $value) {
                    if (isset($stu_ann[$key]) && strcasecmp($value, $stu_ann[$key]) == 0) {
                        $newcorrectans1[$key] = $stu_ann[$key];
                    }
                    if (isset($stu_ann[$key]) && strcasecmp($value, $stu_ann[$key]) != 0) {
                        $newincorrectans1[$key] = $stu_ann[$key];
                    }
                }

                
               //incorrect/score
               $resultttt = array_intersect_key($negative, array_flip(array_keys($newincorrectans1)));
               $newcoryt = (count($newcorrectans1)*3);
               $totalscoreee = $newcoryt - (array_sum($resultttt));

                   $combinedArrayynew = array();
                    foreach ($proarr as $subArray) {
                     
                        $combinedArrayynew = array_merge($combinedArrayynew, $subArray);
                    }
                       $procrt =  array_intersect_assoc($combinedArrayynew,$ex_correct);

                      //score

                    $newresulto1 = array();
                    foreach ($ex_correct as $key => $value) {
                        if (!array_key_exists($key, $combinedArrayynew) || $combinedArrayynew[$key] !== $value) {
                            if (array_key_exists($key, $combinedArrayynew)) {
                                $newresulto1[$key] = $combinedArrayynew[$key];
                            }
                        }
                    }

                    $ieminco = (array_filter($newresulto1));
                    $newresulto2 = array();
                    foreach ($ieminco as $key => $value) {
                        if (isset($negative[$key])) {
                            $newresulto2[$key] = $negative[$key];
                        }
                    }
                    $newresulto112 =  count($newresulto1)*3;

                    //totalper 
                    $newatt = count(array_filter($combinedArrayynew));
                    if($newatt== 0 ){
                        $newatt = 1;
                    }else{
                        $newatt = $newatt;
                    }
                    //$corrrr = count($newcorrectans1);
                    $corrrr = count($procrt);
                    $corrrr1 = count($procrt)*3;
                    $iemscoreo = ($corrrr1) -  (array_sum($newresulto2));

                    $perrr1 = ($corrrr/$newatt)*100;
                    $perrr = round($perrr1,2);
                    if($perrr<0){
                        $perrr = 0;
                    }else{
                        $perrr = $perrr;
                    }
                }

                    //newoverwithiem
                    $totalquestion12 = array(); 
                    foreach ($stu_level as $array) {
                        foreach ($array as $value) {
                            // if ($value === $request->diff_id) {
                            //     $totalquestion12[] = $value;
                            // }
                            if (strtolower($value) === strtolower($request->diff_id)) {
                                $totalquestion12[] = $value;
                            }
                        }
                    }
                  
                    //iem attempt
                    foreach ($stu_level as $key => $value) {
                        if (isset($stu_ans[$key])) {
                            $newAns2[$key] = $stu_ans[$key];
                        } else {
                            $newAns2[$key] = '';
                        }
                    }
                    //iem attempt
                    $combinedArrayy = array();
                    foreach ($newstuans as $subArray) {
                        $combinedArrayy = array_merge($combinedArrayy, $subArray);
                    }
                    // echo'<pre>';
                    // print_r($combinedArrayy);
                    //iemcorrect
                    $combinedArrayy1 = array();
                    foreach ($newstuans1 as $subArray) {
                    
                        $combinedArrayy1 = array_merge($combinedArrayy1, $subArray);
                    }
                    $combinedArrayy2= array_filter($combinedArrayy1);
                    // $newresult = array_intersect_assoc($combinedArrayy2, $ex_correct);
                    $newresult = array_intersect_assoc(
                        array_change_key_case(array_map('strtolower', $combinedArrayy2), CASE_LOWER),
                        array_change_key_case(array_map('strtolower', $ex_correct), CASE_LOWER)
                    );

                    //iemscore 
                    $newresult1 = array();
                    foreach ($ex_correct as $key => $value) {
                        if (!array_key_exists($key, $combinedArrayy1) || $combinedArrayy1[$key] !== $value) {
                            if (array_key_exists($key, $combinedArrayy1)) {
                                $newresult1[$key] = $combinedArrayy1[$key];
                            }
                        }
                    }
                    $ieminc = (array_filter($newresult1));
                        $newresult2 = array();
                        foreach ($ieminc as $key => $value) {
                            if (isset($negative[$key])) {
                                $newresult2[$key] = $negative[$key];
                            }
                        }
                //$newresult123 =  count($newresult1)*3;
                $newresult123 =  count($newresult)*3;
                $iemscore = $newresult123 -  (array_sum($newresult2));
            
                //iem per
                $iemattempt = count($combinedArrayy) ; 
                $iemcorrect = count($newresult);
                if($iemattempt == 0){
                    $iemattempt =1;
                }else{
                    $iemattempt = $iemattempt;
                  
                }
               
                $iemper = ($iemcorrect/$iemattempt)*100;  
               
                $iemper1 = round($iemper,2);
                if($iemper1<0){
                    $iemper1 =0;
                }else{
                    $iemper1 =$iemper1;
                }
                // echo'<pre>'; 
                // print_r($iemper);  
               //cal
                $totalquestion;
            
                $totalattempt = count(array_filter($valuesFromArray2));

                $cortt = count($corr1);

                $newcort = ($cortt*3);
                $totalscore = $newcort - (array_sum($negg1));

                $totalmark =  array_sum($pos1);
                if($totalmark ==0){
                    $totalmark = 1;
                }else{
                    $totalmark = $totalmark;
                }
          
                //$allpercentage = ($totalscore/$totalmark)*100;
                if($totalattempt != 0){
                    $allpercentage = ($cortt/$totalattempt)*100;
                $allpercentage =  round($allpercentage,2);
                if($allpercentage<0){
                    $allpercentage = 0;
                }else{
                    $allpercentage =$allpercentage;
                }
                    
                }
                $totalquestion1234 = count($totalquestion12);
                
////tita start//////////
$userid =session()->get('id');
$qtype = array();
$ans_time = array();
$answer= array();
$qid = array();
if($request->section_id == 'overall'){
$titas = DB::table('student_quizes')
        ->where('test_id',$testss->id)
        ->where('user_id',$userid)
       // ->where('section_type', 'like', "%$request->section_id%")
       // ->where('paper_id', $paperid)
        ->get();
}else{
    $titas = DB::table('student_quizes')
        ->where('test_id',$testss->id)
        ->where('user_id',$userid)
        ->where('section_type', 'like', "%$request->section_id%")
       // ->where('paper_id', $paperid)
        ->get();

}
        
foreach($titas as $tita)
{
     $qusids =  explode(",",$tita->question_id); 
     $questiontypes =  explode(",",$tita->question_type); 
     $question_times =  explode(",",$tita->ans_duration);
     $attemptanss =  explode(",",$tita->answer);
    foreach($questiontypes as $questiontype){
        $qtype[] = $questiontype;
    }
    foreach($question_times as $question_time){
        $ans_time[] = $question_time;
    }
    foreach($attemptanss as $attemptans){
        $answer[] = $attemptans;
    }
     foreach($qusids as $qusid){
        $qid[] = $qusid;
    }
    
}

$key1 = array();
foreach ($qtype as $key => $value) {
  

  if (stripos($value, 'fill') === 0) {
        $key1[$key] = $value;
  }
}


$timeresults = array();
foreach ($key1 as $key => $value) {
    if (isset($ans_time[$key])) {
        $timeresults[$key] = $ans_time[$key];
    }
}


$ansresult = array();
foreach ($key1 as $key => $value) {
    if (isset($answer[$key])) {
        $ansresult[$key] = $answer[$key];
    }
}
$non_empty_ans = array_filter($ansresult);

$attempttime = array();
 foreach ($non_empty_ans as $key => $value) {
    if (isset($ans_time[$key])) {
       $attempttime[$key] = $ans_time[$key];
    }
 }
 $attempttime1 = array_sum($attempttime);
$totaltime = (array_sum($timeresults));
$totaltimef =  date("H:i:s", $totaltime / 1000);
$attempttime2 = date("H:i:s", $attempttime1 / 1000);
if($request->section_id == 'overall'){
   
    $exceltitas1 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%VERBAL%")
                ->get();
    $exceltitas2 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%DATA%")
                ->get();
    $exceltitas3 = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                    ->where('section_name', 'like', "%QUANTITATIVE%")
                ->get();
        $excel_correct1 = array();
        $excel_negative1 = array();
        $excel_positive1 = array();
        foreach($exceltitas1 as $exceltita)
        {
            $excel_correct1[] = $exceltita->correct_option;
            $excel_negative1[] = $exceltita->negative_mark;
            $excel_positive1[] = $exceltita->positive_mark;
        }
        $excel_correct2 = array();
        $excel_negative2 = array();
        $excel_positive2 = array();
        foreach($exceltitas2 as $exceltita)
        {
            $excel_correct2[] = $exceltita->correct_option;
            $excel_negative2[] = $exceltita->negative_mark;
            $excel_positive2[] = $exceltita->positive_mark;
        }
         $excel_correct3 = array();
        $excel_negative3 = array();
        $excel_positive3 = array();
        foreach($exceltitas3 as $exceltita)
        {
            $excel_correct3[] = $exceltita->correct_option;
            $excel_negative3[] = $exceltita->negative_mark;
            $excel_positive3[] = $exceltita->positive_mark;
        }
          $excel_correct = array_merge($excel_correct1, $excel_correct2,$excel_correct3);
        $excel_negative = array_merge($excel_negative1, $excel_negative2,$excel_negative3);
        $excel_positive = array_merge($excel_positive1, $excel_positive2,$excel_positive3);
}else{
  
    $exceltitas = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                ->where('section_name','like', "%$request->section_id%")
               // ->whereIn('id', $qid)
                ->get();
        $excel_correct = array();
        $excel_negative = array();
        $excel_positive = array();
        foreach($exceltitas as $exceltita)
        {
            $excel_correct[] = $exceltita->correct_option;
            $excel_negative[] = $exceltita->negative_mark;
            $excel_positive[] = $exceltita->positive_mark;
        }
               
}

         $correctresult = array();
        foreach ($key1 as $key => $value) {
            if (isset($excel_correct[$key])) {
                $correctresult[$key] = $excel_correct[$key];
            }
        }
        
    $correctresult_lower = array_map('strtolower', array_change_key_case($correctresult, CASE_LOWER));
$ansresult_lower = array_map('strtolower', array_change_key_case($ansresult, CASE_LOWER));

$allcorrect = array_intersect_assoc($correctresult_lower, $ansresult_lower);
     $correctttime = array();
     foreach ($allcorrect as $key => $value) {
        if (isset($ans_time[$key])) {
           $correctttime[$key] = $ans_time[$key];
        }
     }
     $correctttime1 = array_sum($correctttime);
     $incorrecttime = $attempttime1- $correctttime1;
     $correctttime2 = date("H:i:s", $correctttime1 / 1000);
     $incorrecttime2 = date("H:i:s", $incorrecttime / 1000);
     $skiptime =     $totaltime-  $attempttime1;
     $skiptime1 = date("H:i:s", $skiptime / 1000);
     $incoforsco =  array_diff_assoc($ansresult,$correctresult);
       $allneg = array();
        foreach ($incoforsco as $key => $value) {
            if (isset($excel_negative[$key])) {
                $allneg[$key] = $excel_negative[$key];
            }
        }
        
        $allpos = array();
        foreach ($allcorrect as $key => $value) {
            if (isset($excel_positive[$key])) {
                $allpos[$key] = $excel_positive[$key];
            }
        }
    $score = (array_sum($allpos) - array_sum($allneg));
    $incorrect = count($non_empty_ans) - count($allcorrect);
    $skip = count($key1)-count($non_empty_ans);
    if(count($non_empty_ans) == 0){
        $non_empty_ansff = 1;
        $accu = ((count($allcorrect))/($non_empty_ansff))* 100 ;
    }else{
        $accu = ((count($allcorrect))/(count($non_empty_ans)))* 100 ;
    }
    
        
   // Tita for Numeric
   
$key2 = array();
foreach ($qtype as $key => $value) {
  if (stripos($value, 'num') === 0) {
        $key2[$key] = $value;
  }
}


$timeresults2 = array();
foreach ($key2 as $key => $value) {
    if (isset($ans_time[$key])) {
        $timeresults2[$key] = $ans_time[$key];
    }
}


$ansresult2 = array();
foreach ($key2 as $key => $value) {
    if (isset($answer[$key])) {
        $ansresult2[$key] = $answer[$key];
    }
}
$non_empty_ans2 = array_filter($ansresult2);

$attempttime2 = array();
 foreach ($non_empty_ans2 as $key => $value) {
    if (isset($ans_time[$key])) {
       $attempttime2[$key] = $ans_time[$key];
    }
 }
 $attempttime12 = array_sum($attempttime2);
$totaltime2 = (array_sum($timeresults2));
$totaltimef2 =  date("H:i:s", $totaltime2 / 1000);
$attempttime22 = date("H:i:s", $attempttime12 / 1000);

if($request->section_id == 'overall'){
    $exceltitas1 = DB::table('excel_questions')
                  ->where('test_id',$testss->id)
                  ->where('section_name', 'like', "%VERBAL%")
                  ->get();
                  
    $exceltitas2 = DB::table('excel_questions')
                  ->where('test_id',$testss->id)
                  ->where('section_name', 'like', "%DATA%")
                  ->get();
    $exceltitas3 = DB::table('excel_questions')
                 ->where('test_id',$testss->id)
                 ->where('section_name', 'like', "%QUANTITATIVE%")
                ->get();
        $excel_correctnew1 = array();
        $excel_negativenew1 = array();
        $excel_positivenew1 = array();
        foreach($exceltitas1 as $exceltita)
        {
            $excel_correctnew1[] = $exceltita->correct_option;
            $excel_negativenew1[] = $exceltita->negative_mark;
            $excel_positivenew1[] = $exceltita->positive_mark;
        }
        $excel_correctnew2 = array();
        $excel_negativenew2 = array();
        $excel_positivenew2 = array();
        foreach($exceltitas2 as $exceltita)
        {
            $excel_correctnew2[] = $exceltita->correct_option;
            $excel_negativenew2[] = $exceltita->negative_mark;
            $excel_positivenew2[] = $exceltita->positive_mark;
        }
         $excel_correctnew3 = array();
        $excel_negativenew3 = array();
        $excel_positivenew3 = array();
        foreach($exceltitas3 as $exceltita)
        {
            $excel_correctnew3[] = $exceltita->correct_option;
            $excel_negativenew3[] = $exceltita->negative_mark;
            $excel_positivenew3[] = $exceltita->positive_mark;
        }
        $excel_correctnew = array_merge($excel_correctnew1, $excel_correctnew2,$excel_correctnew3);
        $excel_negativenew = array_merge($excel_negativenew1, $excel_negativenew2,$excel_negativenew3);
        $excel_positivenew = array_merge($excel_positivenew1, $excel_positivenew2,$excel_positivenew3);
}else{
         $exceltitas = DB::table('excel_questions')
                ->where('test_id',$testss->id)
                ->where('section_name','like', "%$request->section_id%")
               // ->whereIn('id', $qid)
                ->get();
       $excel_correctnew = array();
        $excel_negativenew = array();
        $excel_positivenew = array();
        foreach($exceltitas as $exceltita)
        {
            $excel_correctnew[] = $exceltita->correct_option;
            $excel_negativenew[] = $exceltita->negative_mark;
            $excel_positivenew[] = $exceltita->positive_mark;
        }

}
       
        
         $correctresult2 = array();
        foreach ($key2 as $key => $value) {
            if (isset($excel_correctnew[$key])) {
                $correctresult2[$key] = $excel_correctnew[$key];
            }
        }
     //$allcorrect2 =  array_intersect_assoc($correctresult2,$ansresult2);
     $correctresult2_lower = array_map('strtolower', array_change_key_case($correctresult2, CASE_LOWER));
    $ansresult2_lower = array_map('strtolower', array_change_key_case($ansresult2, CASE_LOWER));
    $allcorrect2 = array_intersect_assoc($correctresult2_lower, $ansresult2_lower);

     $correctttime2 = array();
     foreach ($allcorrect2 as $key => $value) {
        if (isset($ans_time[$key])) {
           $correctttime2[$key] = $ans_time[$key];
        }
     }
     $correctttime12 = array_sum($correctttime2);
     $incorrecttime2 = $attempttime12- $correctttime12;
     $correctttime22 = date("H:i:s", $correctttime12 / 1000);
     $incorrecttime22 = date("H:i:s", $incorrecttime2 / 1000);
     $skiptime2 =     $totaltime2-  $attempttime12;
     $skiptime12 = date("H:i:s", $skiptime2 / 1000);
     $incoforsco2 =  array_diff_assoc($ansresult2,$correctresult2);
       $allneg2 = array();
        foreach ($incoforsco2 as $key => $value) {
            if (isset($excel_negativenew[$key])) {
                $allneg2[$key] = $excel_negativenew[$key];
            }
        }
        
        $allpos2 = array();
        foreach ($allcorrect2 as $key => $value) {
            if (isset($excel_positivenew[$key])) {
                $allpos2[$key] = $excel_positivenew[$key];
            }
        }
    $score2 = (array_sum($allpos2) - array_sum($allneg2));
    $incorrect2 = count($non_empty_ans2) - count($allcorrect2);
    $skip2 = count($key2)-count($non_empty_ans2);
    if(count($non_empty_ans2) == 0){
      $non_empty_ans26 = 1;
       $accu2 = ((count($allcorrect2))/(($non_empty_ans26)))* 100 ; 
    }else{
        $accu2 = ((count($allcorrect2))/(count($non_empty_ans2)))* 100 ;
    }
    
    ///total tital
    
    $totaltime25= $totaltime2+$totaltime;
    $totaltimef25 =  date("H:i:s", $totaltime25 / 1000);
   
    $key3 = count($key1) + count($key2);
    $non_empty_ans3 =   count($non_empty_ans)+count($non_empty_ans2);
    $attempttime13 =  $attempttime12+$attempttime1;
    $attempttime33 = date("H:i:s", $attempttime13 / 1000);
    $allcorrect3 = count($allcorrect)+count($allcorrect2);
    $correctttime3 =   $correctttime12 + $correctttime1;
    $correctttime33 = date("H:i:s", $correctttime3 / 1000);
    $incorrect3 =  $incorrect+$incorrect2;
    $incorrecttime3 = $incorrecttime2+$incorrecttime;
    $incorrecttime33 = date("H:i:s", $incorrecttime3 / 1000);
    $skip3 = $skip2+$skip;
    $skiptime3 =  $skiptime+$skiptime2;
    $skiptime33 = date("H:i:s", $skiptime3 / 1000);
  $score3 =  $score+$score2;
  if($non_empty_ans3 == 0){
      $non_empty_ans33 = 1;
       $accury3 = ($allcorrect3/ $non_empty_ans33)*100;
  }else{
       $accury3 = ($allcorrect3/ $non_empty_ans3)*100;
  }

//endtita//////////

                //   echo'<pre>';
                //   print_r($totalquestion12);
                    
                if ($totalattempt != 0 || $totalquestion1234) {
                    if($request->diff_id == 'overall' && $request->section_id == 'overall')
                    {
                       // if($tot!= 0){  $newcorrectans1
                            $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($combinedData).'</td><td>'. count(array_filter($combinedData1)).'</td><td>'.count($procrt).'</td><td>'.$iemscoreo.'</td>';
                            $var_1 .=' <td>'.$perrr.'</td></tr>';
                       // }

                    }elseif($request->section_id == 'overall'){

                                $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion12).'</td><td>'.count($combinedArrayy).'</td><td>'.count($newresult).'</td><td>'.$iemscore.'</td>';
                                $var_1 .=' <td>'.$iemper1.'</td></tr>';

                    }else{
                            $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.count($totalquestion).'</td><td>'. $totalattempt.'</td><td>'.$cortt.'</td><td>'.$totalscore.'</td>';
                            $var_1 .=' <td>'.$allpercentage.'</td></tr>';

                    }
                }if($request->diff_id == 'TITA' && $request->section_id){  
                    if($non_empty_ans3 != 0) {
                        $var_1 .= '<tr><td>'.$testss->test.'</td><td>'.$key3.'</td><td>'.$non_empty_ans3.'</td><td>'.$allcorrect3.'</td><td>'.$score3.'</td>';
                        $var_1 .=' <td>'.round($accury3,2).'</td></tr>';

                    }  
                   
                  
                }
        }
        $var_1 = array('var_1' => $var_1);
        echo json_encode($var_1);
    }


    public function nmatInstructions(Request $request)
    {
        return view('student.nmat-instruction');
        
    }

    public function nonDisclosure(Request $request)
    {
        
        return view('student.non-disclosure');

    }
    public function nmatSection(Request $request)
    {
        return view('student.nmat-section');

    }
    public function nmatQuiz($id,$paperid,$sid)
    {
    $userid =session()->get('id');
   $section_time = DB::table('quiz_durations')
                      ->where('test_id',$id)
                     -> orderBy('id','DESC')
                      ->first();
    $section_type = DB::table('student_quizes')
                          ->where('test_id',$id)
                          ->where('user_id',$userid)
                         -> orderBy('id','DESC')
                          ->first();
    if($sid == 'nmat-section1')
    {
        $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Quantitative Skills%")
                ->get();

    }elseif($sid == 'nmat-section2'){
        $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Quantitative Skills%")
                ->get();


    }elseif($sid == 'nmat-section3') {
        $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Language Skills%")
                ->get();
    }elseif($sid == 'nmat-section4') {
        $qs_ques = DB::table('excel_questions')
        ->where('test_id',$id)
        ->where('section_name', 'like', "%Language Skills%")
        ->get();

    }elseif($sid == 'nmat-section5') {
        $qs_ques = DB::table('excel_questions')
        ->where('test_id',$id)
        ->where('section_name', 'like', "%Logical Reasoning%")
        ->get();

    }elseif($sid == 'nmat-section6') {
        $qs_ques = DB::table('excel_questions')
        ->where('test_id',$id)
        ->where('section_name', 'like', "%Logical Reasoning%")
        ->get();
    }
     
       $test = DB::table('tests')->where('id',$id)->first();
      return view('student.nmat-quiz')->with(array('section_time'=>$section_time, 'section_type'=>$section_type,'qs_ques'=>$qs_ques,'test'=>$test));

    }
    public function nmatNextQuiz($id,$paperid,$sid,$nextid)
    {
        $userid =session()->get('id');
        $section_time = DB::table('quiz_durations')
                           ->where('test_id',$id)
                          -> orderBy('id','DESC')
                           ->first();
         $section_type = DB::table('student_quizes')
                               ->where('test_id',$id)
                               ->where('user_id',$userid)
                              -> orderBy('id','DESC')
                               ->first();
         if($sid == 'nmat-section1')
         {
            if($nextid == 'Language Skills')
            {
                $qs_ques = DB::table('excel_questions')
                     ->where('test_id',$id)
                     ->where('section_name', 'like', "%Language Skills%")
                     ->get();
                     $nextdata = 'Logical Reasoning';

            }elseif($nextid == 'Logical Reasoning'){
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Logical Reasoning%")
                ->get();
                $nextdata = 'nmat-report';

            }
         }elseif($sid == 'nmat-section2'){
            if($nextid == 'Logical Reasoning')
            {
             $qs_ques = DB::table('excel_questions')
                     ->where('test_id',$id)
                     ->where('section_name', 'like', "%Logical Reasoning%")
                     ->get();
             $nextdata = 'Language Skills';
            }elseif($nextid == 'Language Skills'){
                $qs_ques = DB::table('excel_questions')
                     ->where('test_id',$id)
                     ->where('section_name', 'like', "%Language Skills%")
                     ->get();
            $nextdata = 'nmat-report';

          }
         }elseif($sid == 'nmat-section3') {
           if($nextid == 'Quantitative Skills') 
           {
            $qs_ques = DB::table('excel_questions')
            ->where('test_id',$id)
            ->where('section_name', 'like', "%Quantitative Skills%")
            ->get();
            $nextdata = 'Logical Reasoning';
           }elseif($nextid == 'Logical Reasoning'){
            $qs_ques = DB::table('excel_questions')
            ->where('test_id',$id)
            ->where('section_name', 'like', "%Logical Reasoning%")
            ->get();
            $nextdata = 'nmat-report';

           }
        }elseif($sid == 'nmat-section4') {
            if($nextid == 'Logical Reasoning'){
             $qs_ques = DB::table('excel_questions')
             ->where('test_id',$id)
             ->where('section_name', 'like', "%Logical Reasoning%")
             ->get();
             $nextdata = 'Quantitative Skills';
            }elseif($nextid == 'Quantitative Skills'){
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Quantitative Skills%")
                ->get();
                $nextdata = 'nmat-report';

            }
         }elseif($sid == 'nmat-section5') {
            if($nextid == 'Language Skills')
            {
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Language Skills%")
                ->get();
                $nextdata = 'Quantitative Skills';
            }elseif($nextid == 'Quantitative Skills'){
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Quantitative Skills%")
                ->get();
                $nextdata = 'nmat-report';
            }
         }elseif($sid == 'nmat-section6') {
            if($nextid == 'Quantitative Skills')
            {
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Quantitative Skills%")
                ->get();
                $nextdata = 'Language Skills';
            }elseif($nextid == 'Language Skills'){
                $qs_ques = DB::table('excel_questions')
                ->where('test_id',$id)
                ->where('section_name', 'like', "%Language Skills%")
                ->get();
                $nextdata = 'nmat-report';
            }
         }
          
        $test = DB::table('tests')->where('id',$id)->first();
        return view('student.nmat-next-quiz')->with(array('section_time'=>$section_time, 'section_type'=>$section_type,'qs_ques'=>$qs_ques,'test'=>$test,'nextdata'=>$nextdata));

    }

    public function nmatNextPage($id,$paperid,$sid,$nextid)
    {
        $section_time = DB::table('quiz_durations')
                            ->where('test_id',$id)
                            ->orderBy('id','DESC')
                            ->first();
        $qs_ques = DB::table('excel_questions')
                    ->where('test_id',$id)
                    ->where('section_name', 'like', "%$nextid%")
                    ->get();
    
        return view('student.nmat-next-page')->with(array('section_time'=>$section_time,'qs_ques'=>$qs_ques));
    }

    public function nmatReport($id,$paperid,$nextid)
    { 
        $userid =session()->get('id');
        $tests = DB::table('tests')
                ->where('id',$id)
                ->first();
                
        $subQuery = DB::table('student_quizes')
            ->select('section_type', DB::raw('MAX(id) as max_id'))
            ->where('test_id', $id)
            ->where('user_id', $userid)
            ->where('paper_id', $paperid)
            ->groupBy('section_type');
        
        
            $reports = DB::table('student_quizes')
                ->joinSub($subQuery, 'latest', function ($join) {
                $join->on('student_quizes.id', '=', 'latest.max_id');
            })
            ->where('student_quizes.test_id', $id)
            ->where('student_quizes.user_id', $userid)
            ->where('student_quizes.paper_id', $paperid)
            ->orderByRaw("CASE 
                WHEN student_quizes.section_type = 'Quantitative Skills' THEN 1
                WHEN student_quizes.section_type = 'Logical Reasoning' THEN 2
                WHEN student_quizes.section_type = 'Language Skills' THEN 3
                ELSE 4
            END")
            ->orderBy('student_quizes.id')
            ->get();

                
        $verbal_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                 ->where('section_type', 'like', "%Quantitative Skills%")
                 ->orderBy('id', 'DESC')
                ->first();
              //  dd($verbal_reports);
        if(!empty($verbal_reports->question_id)){
            $vString = $verbal_reports->question_id;
        }
       if(isset($vString)){
        $vArray = explode(',', $vString);
        $verbal_ques = DB::table('excel_questions')
        ->where('test_id',$id)
                ->whereIn('id',$vArray)
                ->get();
       }else{
                 $verbal_ques = []; 
    }

        $data_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                ->where('section_type', 'like', "%Language Skills%")
                ->orderBy('id', 'DESC')
                ->first();
               
        if(!empty($data_reports->question_id)){
               $dString = $data_reports->question_id;
        }
         if(isset($dString)){
         $dArray = explode(',', $dString);
         $data_ques = DB::table('excel_questions')
                   ->where('test_id',$id)
                    ->whereIn('id',$dArray)
                    ->get();
       
         }else{ 
             $data_ques = [];
         
         }
                    
     $qt_reports = DB::table('student_quizes')
                ->where('test_id',$id)
                ->where('user_id',$userid)
                ->where('paper_id',$paperid)
                 ->where('section_type', 'like', "%Logical Reasoning%")
               ->orderBy('id', 'DESC')
                ->first();
    if(!empty($qt_reports->question_id)){
        $qString = $qt_reports->question_id;
    }
           if(isset($qString)){
                 $qArray = explode(',', $qString);
        $qt_ques = DB::table('excel_questions')
                   ->where('test_id',$id)
                    ->whereIn('id',$qArray)
                    ->get();
              // dd($qt_ques);
           }else{
                $qt_ques = []; 
           }
        $cutoff = DB::table('cutoff')
               ->where('test_id',$id)
                ->get();
        return view('student.nmat-report')->with(array('tests'=>$tests,'reports'=>$reports,'verbal_reports'=>$verbal_reports,'data_reports'=>$data_reports,'qt_reports'=>$qt_reports,'verbal_ques'=>$verbal_ques,'data_ques'=>$data_ques,'qt_ques'=>$qt_ques,'cutoff'=>$cutoff));
        

    }


    public function nmatSolution($testid,$paperid)
    {
        ini_set('memory_limit', '512M');

         $userid =session()->get('id');
         
        $verbal_ques = DB::table('excel_questions')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%Quantitative Skills%")
                            ->get();
                            
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                             ->where('section_type', 'like', "%Quantitative Skills%")
                             ->orderBy('id', 'DESC')
                            ->first();
                            
        $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                             ->where('section_type', 'like', "%Quantitative Skills%")
                            ->get();

            $test = DB::table('tests')
                            ->where('id',$testid)
                            ->orderBy('id', 'DESC')
                            ->first();
                            
    return view('student.nmat-solution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }


    public function languageSolution($testid,$paperid)
    {
        ini_set('memory_limit', '512M');
         $userid =session()->get('id');
        $verbal_ques = DB::table('excel_questions')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%Language Skills%")
                            ->get();
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                             ->where('section_type', 'like', "%Language Skills%")
                             ->orderBy('id', 'DESC')
                            ->first();
        $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('section_type', 'like', "%Language Skills%")
                            ->get();

            $test = DB::table('tests')
                            ->where('id',$testid)
                             ->orderBy('id', 'DESC')
                            ->first();
    return view('student.languagesolution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }


    public function logicalSolution($testid,$paperid)
    {
        ini_set('memory_limit', '512M');
         $userid =session()->get('id');
        $verbal_ques = DB::table('excel_questions')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%Logical Reasoning%")
                            ->get();
        $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                             ->where('section_type', 'like', "%Logical Reasoning%")
                             ->orderBy('id', 'DESC')
                            ->first();
        $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                             ->where('section_type', 'like', "%Logical Reasoning%")
                            ->get();
                           // dd($verbal_r);
            $test = DB::table('tests')
                            ->where('id',$testid)
                             ->orderBy('id', 'DESC')
                            ->first();
    return view('student.logicalsolution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
    }


    public function profile(Request $request)
    {
        return view('student.profile');
    }

    public function profileUpdate(Request $request)
    {
         //$id = request()->id;
      if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name= $image->getClientOriginalName();
                $destinationPath = storage_path('app/files');
                $image->move($destinationPath, $image_name);
               }else{
                   $image_name = NULL;
               }
             
            $user =  DB::table('studentlogs')
            ->where('id',$request->id)
            ->update([
                'image'=>$image_name
                ]);
        return redirect()->back();
    }


   
    
    public function saveProctored(Request $request)
    {
        $validate = $request->validate([
            'proctored_code' => 'required|digits:6'
        ]);

         $test_id = $request->input('test_id');
         $test_name = $request->input('test_name');
         $pro_code = $request->input('pro_code');
         $paper = $request->input('paper');
         $maximum_attemp = $request->input('maximum_attemp');
         $proctored_code = $request->proctored_code;
         $course_id = $request->course_id;
         $status = $request->status;
        
         if($pro_code == $proctored_code){
            
            if(!empty($pro_code))
            {
                  
                if (strpos($test_name, "NMAT") !== false) {
                    if($paper != 0){
                        if($maximum_attemp > $paper){
                            return redirect()->route('student.nmat-instructions', $test_id);
                        }
                    }
                } elseif (($course_id == '4')) {
                    // if($paper != 0){
                    //     if($maximum_attemp > $paper){
                          return redirect()->route('student.section-instructions', $test_id);
                    //     }
                    // }    
                   
                }else{
                    return redirect()->route('student.instructions', $test_id);
                } 
            }
         }else{
            return redirect()->route('student.dashboard')->with('message', 'Enter valid proctored code!');  
         } 
       return redirect()->route('student.dashboard')->with('message', 'Something went wrong!');  
    }
    
    



    
    
    function appendResults($ssid, $tests, $alluserquiz, $pdfs, &$var_1, $i) {
        foreach ($alluserquiz as $alluserq) {
            $resultLink = '<a href="https://test.mbaguru.in/student/report/' . $ssid . '/' . $tests->id . '/' . $alluserq->paper_id . '" class="btn btn-info btn-sm text-white">Result' . ($i === 0 ? '' : $i) . '</a>&nbsp';
            $var_1 .= $resultLink;
    
            if (!empty($pdfs)) {
                foreach ($pdfs as $pdf) {
                    $var_1 .= '<a href="' . asset('assets/excel-formate/' . $pdf->file) . '" download>' . $pdf->pdf_name . '</a>';
                }
            }
            $i++;
        }
    return $i; // Return the updated index
}


    function generateProctoredForm($tests, $proctored) {
        $form = '<form action="https://test.mbaguru.in/student/student/save-proctored" method="post" enctype="multipart/form-data">';
        $form .= csrf_field();
        $form .= '<input type="text" name="proctored_code" class="resuminput input-box" data-id="' . $tests->id . '" placeholder="Enter Code">';
        $form .= '<p class="par' . $tests->id . ' text-red"></p>';
        $form .= '<input type="hidden" name="pro_code" value="' . $proctored->pro_code . '">';
        $form .= '<input type="hidden" name="id" value="' . $proctored->id . '">';
        $form .= '<input type="hidden" name="test_id" value="' . $tests->id . '">';
        $form .= '<input type="hidden" name="test_name" value="' . $tests->test . '">';
        $form .= '<input type="hidden" name="course_id" value="' . $tests->course_id . '">';
        $form .= '<input type="hidden" name="status" value="' . $proctored->status . '">';
        $form .= '<button type="submit" class="btn py-1 btn-success text-white" id="Launch-test-btn">Launch Test</button>';
        $form .= '</form>';
        return $form;
    }
    
    
    public function results(Request $request)
    {
        return view('student.results');
    }
    
    public function resume(Request $request)
    {
          return view('student.resume');
    }
    
    public function nextTests(Request $request)
    {
          return view('student.next-tests');
    }
    
    public function nextResults(Request $request)
    {
          return view('student.next-results');
        
    }
    public function nextResume(Request $request)
    {
          return view('student.next-resume');
        
    }
    public function verbalResume(Request $request)
    {
           $userid = session()->get('id');
           $paperid = request()->paperid;
           $id = request()->id;
        $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name', 'like', "%VERBAL%")
                        ->get();
                    
        $verbal_ques = DB::table('excel_questions')
            ->select('id', 'test_id', 'section_name', 'level', 'instruction', 'question', 'id', 'question_type', 'status', 'answer', 'option1', 'option2', 'option3', 'option4', 'option5')
            ->where('test_id', $id)
            ->where('section_name', 'LIKE', "%Verbal%")
            ->get();
         
        
        $section_time = DB::table('quiz_durations')
            ->select('id', 'verbal_time', 'duration')
            ->where('test_id', $id)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->first();
        return view('student.verbal-resume', compact('verbal_ques', 'section_time','verbal_qus'));
    }
    
    public function fetchHalfQuizData(Request $request)
    {
        $id = $request->input('test_id');
        $userid = $request->input('user_id');
        $paperid = $request->input('paper_id');
        $question_id = $request->input('question_id');
        $sr_no = $request->input('sr_no');
    
        // Fetch the specific quiz data
        $half_quiz = DB::table('half_student_quiz')
            ->where('test_id', $id)
            ->where('user_id', $userid)
            ->where('paper_id', $paperid)
            ->where('sr_no', $sr_no)
            ->where('section_name', 'like', '%verbal%')
            ->first();
    
        // Return the answer if exists
        if ($half_quiz) {
            return response()->json(['answer' => $half_quiz->answer]);
        } else {
            return response()->json(['answer' => null]);
        }
    }

    public function nmatTests(Request $request)
    {
      return view('student.nmat-tests');  
    }
    
     public function nmatResults(Request $request)
    {
      return view('student.nmat-results');  
    }
     public function nmatResume(Request $request)
    {
      return view('student.nmat-resume');  
    }
    
    
      public function xatTests(Request $request)
    {
      return view('student.xat-tests');
    }
    
    
    public function xatResume(Request $request)
    {
          return view('student.xat-resume');
        
    }
    
    public function xatResults(Request $request)
    {
          return view('student.xat-results');
    }
    
     public function sectionInstructions(Request $request)
        {
           
             return view('student.section-instructions');
            
        }
        
        public function sectionQuiz(Request $request)
        {
           // die("okk");
            $userid =session()->get('id');
            $id = request()->id;
            $section_name = request()->section_name;
            $paperid = request()->paperid;

            $noduration_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->get();
     
            // $verbal_ques = DB::table('excel_questions')
            //             ->where('test_id',$id)
            //           ->where('section_name','LIKE', "%$section_name%")
            //             ->get();

            $section_time = DB::table('quiz_durations')
                        ->where('test_id',$id)
                       -> orderBy('id','DESC')
                        ->first();
            $section_type = DB::table('student_quizes')
                            ->where('test_id',$id)
                            ->where('user_id',$userid)
                           -> orderBy('id','DESC')
                            ->first();
                           // dd($section_type);
                           
           $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                       ->where('section_name', 'like', "%$section_name%")
                        ->get();
        
                                            
                            
         $test = DB::table('tests')->where('id',$id)->first();
         
        return view('student.section-quiz')->with(array('section_time'=>$section_time,'verbal_qus'=>$verbal_qus,'test'=>$test));
        }
        
        public function nextSectionQuiz(Request $request)
        {
            $userid =session()->get('id');
          
            
               $id = $request->id;
            $section_name = $request->section_name;
            $paperid =$request->paperid;

           $noduration_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->get();
     
            $verbal_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name','LIKE', "%$section_name%")
                        ->get();

          
       
           $section_time = DB::table('quiz_durations')
                        ->where('test_id',$id)
                       -> orderBy('id','DESC')
                        ->first();
                        
            $section_type = DB::table('student_quizes')
                            ->where('test_id',$id)
                            ->where('user_id',$userid)
                           -> orderBy('id','DESC')
                            ->first();
                         
                           
            $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%$section_name%")
                            ->get();

           $test = DB::table('tests')->where('id',$id)->first();

        return view('student.next-section-quiz')->with(array('verbal_ques'=>$verbal_ques,'section_time'=>$section_time,'noduration_ques'=>$noduration_ques,'verbal_qus'=>$verbal_qus,'test'=>$test));
        }
        
        public function sectionReport(Request $request)
        {
             return view('student.section-report');
        }
        
        public function sectionSolution(Request $request)
        {
            $testid = request()->id;
            $paperid = request()->paperid;
            $section_name = request()->section_name;
            $userid =session()->get('id');
            $verbal_ques = DB::table('excel_questions')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%$section_name%")
                            ->get();
                            
            $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                            ->where('section_type', 'like', "%$section_name%")
                            ->orderBy('id', 'DESC')
                            ->first();
                            
            $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('section_type', 'like', "%$section_name%")
                            ->get();
                            
            $test = DB::table('tests')
                        ->where('id',$testid)
                        ->orderBy('id', 'DESC')
                        ->first();
                                
            return view('student.section-solution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
        }
        
        
        public function nextSectionSolution(Request $request)
        { 
            $testid = request()->id;
            $paperid = request()->paperid;
            $section_name = request()->section_name;
            $userid =session()->get('id');
            $verbal_ques = DB::table('excel_questions')
                                ->where('test_id',$testid)
                                ->where('section_name', 'like', "%$section_name%")
                                ->get();
                                
            $verbal_reports = DB::table('student_quizes')
                                ->where('test_id',$testid)
                                ->where('user_id',$userid)
                                ->where('paper_id',$paperid)
                                 ->where('section_type', 'like', "%$section_name%")
                                 ->orderBy('id', 'DESC')
                                ->first();
                                
            $verbal_r = DB::table('student_quizes')
                                ->where('test_id',$testid)
                                 ->where('section_type', 'like', "%$section_name%")
                                ->get();
    
            $test = DB::table('tests')
                                ->where('id',$testid)
                                 ->orderBy('id', 'DESC')
                                ->first();
                            
            return view('student.next-section-solution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
        } 
        
    public function savenexthalfquiznew11(Request $request)  
    {  
         
         $data = array(
                    'test_id' => $request->test_id,
                    'paper_id' => $request->paper_id,
                    'user_id' => $request->user_id, 
                    'question_id' => $request->question_id,
                    'section_name' => $request->section_name,
                    'answer' => $request->answer,
                    'sr_no' => $request->sr_no,
                    'set_type' => $request->set_type ?? 'null',
                    'ans_duration' => $request->ans_duration,
                );
             
                DB::table('half_student_quiz')->insert($data);
                DB::table('half_student_quiz_backup')->insert($data);

        return json_encode(array(
            "statusCode"=>200
        ));

    }
    
    
    public function savenexthalfquiznew(Request $request)  
    {  
        $data = array(
            'test_id'       => $request->test_id,
            'paper_id'      => $request->paper_id,
            'user_id'       => $request->user_id, 
            'question_id'   => $request->question_id,
            'section_name'  => $request->section_name,
            'answer'        => $request->answer,
            'sr_no'         => $request->sr_no,
            'set_type'      => $request->set_type ?? 'null',
            'ans_duration'  => $request->ans_duration,
            'created_at'    => now(),   // ✅ added
        );
    
        DB::table('half_student_quiz')->insert($data);
        DB::table('half_student_quiz_backup')->insert($data);
    
        return json_encode([
            "statusCode" => 200
        ]);
    }

    
    

    
    public function reportSectionQuiz(Request $request)
    {
       
         return view('student.report-section-quiz');
       
    }
    
    
      public function sectionWiseSolution(Request $request)
        {
            $testid = request()->id;
            $paperid = request()->paperid;
            $section_name = request()->section_name;
            $userid =session()->get('id');
            $verbal_ques = DB::table('excel_questions')
                            ->where('test_id',$testid)
                            ->where('section_name', 'like', "%$section_name%")
                            ->get();
                            
            $verbal_reports = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id',$paperid)
                            ->where('section_type', 'like', "%$section_name%")
                            ->orderBy('id', 'DESC')
                            ->first();
                            
            $verbal_r = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('section_type', 'like', "%$section_name%")
                            ->get();
                            
            $test = DB::table('tests')
                        ->where('id',$testid)
                        ->orderBy('id', 'DESC')
                        ->first();
                                
            return view('student.section-wise-solution')->with(array('verbal_ques'=>$verbal_ques,'verbal_reports'=>$verbal_reports,'test'=>$test,'verbal_r'=>$verbal_r));
        }
        
        
        public function nextSectionWiseSolution(Request $request)
        { 
            $userid =session()->get('id');
            $id = request()->id;
            $section_name = request()->section_name;
            $paperid =request()->paperid;

           $noduration_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->get();
     
            $verbal_ques = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->where('section_name','LIKE', "%$section_name%")
                        ->get();

          
       
           $section_time = DB::table('quiz_durations')
                        ->where('test_id',$id)
                       -> orderBy('id','DESC')
                        ->first();
                        
            $section_type = DB::table('student_quizes')
                            ->where('test_id',$id)
                            ->where('user_id',$userid)
                           -> orderBy('id','DESC')
                            ->first();
                         
                           
            $verbal_qus = DB::table('excel_questions')
                        ->where('test_id',$id)
                         ->where('section_name', 'like', "%$section_name%")
                            ->get();

           $test = DB::table('tests')->where('id',$id)->first();

        return view('student.next-section-wise-solution')->with(array('verbal_ques'=>$verbal_ques,'section_time'=>$section_time,'noduration_ques'=>$noduration_ques,'verbal_qus'=>$verbal_qus,'test'=>$test));
            
        }
        
            
public function savequizedatanew(Request $request)
{
   // dd($request->all());
    $data = [];
    foreach ($request->question_id as $index => $value) {
        $data[] = [
            'test_id' => $request->test_id[$index] ?? null,
            'user_id' => $request->user_id[$index] ?? null,
            'section_type' => $request->section_type[$index] ?? null,
            'student_duration' => $request->student_duration[$index] ?? null,
            'paper_id' => $request->paper_id[$index] ?? null,
            'answer_review' => $request->answer_review[$index] ?? null,
            'question_id' => $request->question_id[$index] ?? null,
            'level' => $request->level[$index] ?? null,
            'ans_duration' => $request->ans_duration[$index] ?? null,
            'answer' => $request->answer[$index] ?? null,
            'question_type' => $request->question_type[$index] ?? null,
        ];
    }

    if (!empty($data)) {
        foreach ($data as $item) {
            DB::table('section_student_quizes')->updateOrInsert(
                [
                    'user_id' => $item['user_id'],
                    'paper_id' => $item['paper_id'],
                    'test_id' => $item['test_id'],
                    'question_id' => $item['question_id'],
                ],
                [
                    'section_type' => $item['section_type'],
                    'student_duration' => $item['student_duration'],
                    'answer_review' => $item['answer_review'],
                    'level' => $item['level'],
                    'ans_duration' => $item['ans_duration'],
                    'answer' => $item['answer'],
                    'question_type' => $item['question_type'],
                ]
            );
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'All answers successfully submitted.',
    ]);
}


    public function stopSectionQuiz(Request $request)
    {
        
        $userid =session()->get('id');
        $paperid = request()->paperid;
         $id = request()->id;
        $ques = array();
        $ans = array();
        
        $totals = DB::table('section_student_quizes')
                ->where('test_id',$id)
                ->where('paper_id',$paperid)
                ->where('user_id',$userid)
                ->orderBy('id', 'DESC')
                ->get();
                foreach($totals as $total)
                {
                    $ques[] = $total->question_id;
                    $ans[] = $total->answer;
                    
                }
                
        $question = DB::table('excel_questions')
                    ->where('test_id', $id)
                    ->count();
                    
        $attemptedQuestionIds = DB::table('section_student_quizes')
                                ->where('test_id', $id)
                                ->where('paper_id', $paperid)
                                ->where('user_id', $userid)
                                ->whereNotNull('answer')
                                ->where('answer', '!=', '')
                                ->distinct()
                                ->pluck('question_id')
                                ->toArray();

    if(!empty($totals)){

        // $non_answer = count(array_filter($ans, function($value) {
        //     return is_null($value);
        // }));
        
        $attemptedCount = count($attemptedQuestionIds);
        $non_answer   = $question - $attemptedCount;
      
        $show_answer = count(array_filter($ans, function ($value) {
            return $value !== null;
        }));
    }else{
        $question = 0;
        $non_answer = 0;
        $show_answer=0;
    }

        return view('student.stop-section-quiz')->with(array('question'=>$question,'non_answer'=>$non_answer, 'show_answer'=>$show_answer));
    }


 public function timeAnalysis(Request $request)
        {
            return view('student.time_analysis');  
        }
        public function timeTakenPlotting(Request $request)
        {
            return view('student.time_taken_plotting');  
        }

}

