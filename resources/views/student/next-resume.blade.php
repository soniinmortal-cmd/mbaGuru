@extends('student_template')
<style>
    .dropdown-menu{
    width: max-content !important;
    }
    .ml-auto{
    margin-left:auto;
    }
 
    .input-box{
   width:150px
 }
 .card .box h3{
    color: white;
     font-size: 20px;
     font-weight: bold;
     margin-bottom: 12px;
     text-align: center;
     padding: 13px;
     border-bottom: 1px solid white;
 }
 .card .box ul{
    color:white;
    font-size: 15px;
    list-style:none;
 
 }
 .card .box ul li{
    /* border-bottom: 1px solid white; */
     margin-bottom: 10px;
     text-align: center;
 }
 #Launch-test-btn {
     background-color: #28b779 !important;
     color: #FFFFFF;
     font-size: 10px;
     
 }
 
 
 /* Loader styles */
.loader {
  border: 8px solid #f3f3f3; /* Light grey */
  border-top: 8px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* Spin animation */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

  .table th, .table td {
      width: 33.33%; 
      height: 20px;  
      vertical-align: middle;
   }
   
    svg {
      visibility: hidden;
    }
    .form-select {
        transition: border-color 0.3s, box-shadow 0.3s;
        background-color: rgba(193, 39, 45, 0.04) !important;
        border: 1px solid #c1272d !important;
        color: #c1272d !important;
    }

    .form-select:focus {
        border-color: #c1272d !important;
        box-shadow: 0 0 5px rgba(193, 39, 45, 0.5) !important;
    }
 </style>
@section('css')
@endsection
@section('content')

<div class="col-md-9 bg-light py-3 " id="right-menu-bar">
   <div id="topbar-right-menu " class="d-flex  px-3 my-3 justify-content-between align-items-center">
      {{-- <h5 class="fw-bold text-capitalize">Dashboard</h5> --}}
   </div>
   <?php
        $userid =session()->get('id');
        $cid = request()->courseid;
  
/////////////start AIRCAT ////////////
    $course_id = array();
    $testId = array();
    $publishId = array();
    $quiz_id = array();
    $testuploadings = DB::table('testuploading')
                     ->select('id', 'title') 
                    ->where('title','like', "%AIRCAT%")
                    ->orderBy('id','desc')
                    ->get();
   foreach($testuploadings as $testuploading)
   {
            $course_id[] = $testuploading->id;
   }
  
   $tests = DB::table('tests')
              ->select('id', 'course_id') 
                ->whereIn('course_id',$course_id)
                ->get();
         
    foreach($tests as $test){
        $testId[] = $test->id;
    }

    $publishs = DB::table('publish_statuses')
                ->select('test_id')
                ->whereIn('test_id',$testId)
                ->where('status',1)
                ->groupBy('test_id')
                ->get();
    foreach($publishs as $publish)
    {
        $publishId[] = $publish->test_id;
    }

    // $reports = DB::table('student_quizes')
    //                  ->select('paper_id')
    //                 ->where('user_id',$userid)
    //                 ->whereIn('test_id',$testId)
    //                 ->groupBy('paper_id')
    //                 ->get();
    
    $reports = DB::table('student_quizes as sq1')
    ->select('sq1.test_id', 'sq1.paper_id')
    ->where('sq1.user_id', $userid)
    ->whereIn('sq1.test_id', $testId)
    ->whereRaw('sq1.id = (
        SELECT MAX(sq2.id)
        FROM student_quizes as sq2
        WHERE sq2.test_id = sq1.test_id
        AND sq2.user_id = sq1.user_id
    )')
    ->get();
    
           // dd($reports);        
    foreach($reports as $report)
    {
        $quiz_id[] = $report;
    }
    
/////////////End AIRCAT ////////////

/////////////startSectional ////////////
    $course_id1 = array();
    $testId1 = array();
    $publishId1 = array();
    $quiz_id1 = array();
    
    // $testuploadings = DB::table('testuploading')
    //                  ->select('id', 'title') 
    //                  ->where('title','like', "%Sectional%")
    //                  ->get();
    
    $testuploadings = DB::table('testuploading')
                    ->select('id', 'title')
                    ->whereRaw("TRIM(LOWER(title)) LIKE ?", ['%sectional%'])
                    ->get();
                    //dd($testuploadings);
   foreach($testuploadings as $testuploading)
   {
            $course_id1[] = $testuploading->id;
   }
  
   $tests = DB::table('tests')
                ->select('id', 'course_id') 
                ->whereIn('course_id',$course_id1)
                ->get();
                
           
    foreach($tests as $test){
        $testId1[] = $test->id;
    }
   
    $publishs = DB::table('publish_statuses')
                ->select('test_id')
                ->whereIn('test_id',$testId1)
                ->where('status',1)
                ->groupBy('test_id')
                ->get();
                
    foreach($publishs as $publish)
    {
        $publishId1[] = $publish->test_id;
    }
  
    // $reports = DB::table('student_quizes')
    //             ->select('paper_id')
    //             ->where('user_id',$userid)
    //             ->whereIn('test_id',$testId1)
    //             ->groupBy('paper_id')
    //             ->get();
                        
    $reports = DB::table('student_quizes as sq1')
                ->select('sq1.test_id', 'sq1.paper_id')
                ->where('sq1.user_id', $userid)
                ->whereIn('sq1.test_id', $testId1)
                ->whereRaw('sq1.id = (
                    SELECT MAX(sq2.id)
                    FROM student_quizes as sq2
                    WHERE sq2.test_id = sq1.test_id
                    AND sq2.user_id = sq1.user_id
                )')
                ->get();
               
    foreach($reports as $report)
    {
        $quiz_id1[] = $report->paper_id;
    }
// dd($quiz_id1);
/////////////End Sectional ////////////

/////////////start NonCAT ////////////
$course_id2 = array();
    $testId2 = array();
    $publishId2 = array();
    $quiz_id2 = array();
    $testuploadings = DB::table('testuploading')
                 ->select('id', 'title') 
                ->where('title', 'NOT LIKE', '%CAT%')
                ->where('title', 'NOT LIKE', '%Sectional%')
                ->get();
            //dd($testuploadings);
   foreach($testuploadings as $testuploading)
   {
            $course_id2[] = $testuploading->id;
   }
  
   $tests = DB::table('tests')
                ->select('id', 'course_id','test') 
                ->whereIn('course_id',$course_id2)
                ->get();
                     
    foreach($tests as $test){
        $testId2[] = $test->id;
    }
    //dd($testId2);
    $publishs = DB::table('publish_statuses')
                ->select('test_id')
                ->whereIn('test_id',$testId2)
                ->where('status',1)
                ->groupBy('test_id')
                ->get();
    foreach($publishs as $publish)
    {
        $publishId2[] = $publish->test_id;
    }
   
    // $reports = DB::table('student_quizes')
    //                  ->select('paper_id')
    //                  ->where('user_id',$userid)
    //                  ->whereIn('test_id',$testId2)
    //                  ->groupBy('paper_id')
    //                  ->get();
    
     $reports = DB::table('student_quizes as sq1')
                ->select('sq1.test_id', 'sq1.paper_id')
                ->where('sq1.user_id', $userid)
                ->whereIn('sq1.test_id', $testId2)
                ->whereRaw('sq1.id = (
                    SELECT MAX(sq2.id)
                    FROM student_quizes as sq2
                    WHERE sq2.test_id = sq1.test_id
                    AND sq2.user_id = sq1.user_id
                )')
                ->get();
                     
    foreach($reports as $report)
    {
        $quiz_id2[] = $report->paper_id;
    }

/////////////End NonCAT ////////////



/////////////start pastcat ////////////
    $course_id3 = array();
    $testId3 = array();
    $publishId3 = array();
    $quiz_id3 = array();
    
    $testuploadings = DB::table('testuploading')
                        ->select('id', 'title') 
                        //->where('title', 'NOT LIKE', '%CAT%')
                        ->where('title','like', "%Past CAT Papers%")
                        //->where('title', 'NOT LIKE', '%Sectional%')
                        ->get();

   foreach($testuploadings as $testuploading)
   {
            $course_id3[] = $testuploading->id;
   }

   $tests = DB::table('tests')
                ->select('id', 'course_id','test') 
                ->whereIn('course_id',$course_id3)
                ->get();
                 
                 //dd($tests);    
    foreach($tests as $test){
        $testId3[] = $test->id;
    }
    //dd($testId2);
    $publishs = DB::table('publish_statuses')
                ->select('test_id')
                ->whereIn('test_id',$testId3)
                ->where('status',1)
                ->groupBy('test_id')
                ->get();
    foreach($publishs as $publish)
    {
        $publishId3[] = $publish->test_id;
    }
   
    // $reports = DB::table('student_quizes')
    //                  ->select('paper_id')
    //                  ->where('user_id',$userid)
    //                  ->whereIn('test_id',$testId3)
    //                  ->groupBy('paper_id')
    //                  ->get();
    
     $reports = DB::table('student_quizes as sq1')
                ->select('sq1.test_id', 'sq1.paper_id')
                ->where('sq1.user_id', $userid)
                ->whereIn('sq1.test_id', $testId3)
                ->whereRaw('sq1.id = (
                    SELECT MAX(sq2.id)
                    FROM student_quizes as sq2
                    WHERE sq2.test_id = sq1.test_id
                    AND sq2.user_id = sq1.user_id
                )')
                ->get();
    foreach($reports as $report)
    {
        $quiz_id3[] = $report->paper_id;
    }
///////////// End PastCAT ////////////
?>
   <div class="conatiner-fluid">
        <div class="row mt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
            @endif
                  <div class="col-12 col-sm-6 col-lg-3">
                <div class="p-3 bg-white  shadow-sm">
                    <h6 class="text-start">AIRCATs</h6>
                    <div class="ratio ratio-1x1 crt" data-testid = {{count($testId) }} data-publishId = {{count($publishId) }} data-quiz_id = {{count($quiz_id) }}>
                        <canvas id="bar-chart-1"></canvas>
                    </div>
                </div>
            </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-white  shadow-sm">
                        <h6 class="text-start">Past CAT Papers</h6>
                        <div class="ratio ratio-1x1 crt3" data-testid3 = {{count($testId3) }} data-publishId3 = {{count($publishId3) }} data-quiz_id3 = {{count($quiz_id3) }}>
                            <canvas id="bar-chart-2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-white shadow-sm">
                        <h6 class="text-start">Sectional Tests</h6>
                        <div class="ratio ratio-1x1 crt1" data-testid1 = {{count($testId1) }} data-publishId1 = {{count($publishId1) }} data-quiz_id1 = {{count($quiz_id1) }}>
                            <canvas id="bar-chart-3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-white shadow-sm">
                        <h6 class="text-start">Non CATs</h6>
                        <div class= "ratio ratio-1x1 crt2" data-testid2 = {{count($testId2) }} data-publishId2 = {{count($publishId2) }} data-quiz_id2 = {{count($quiz_id2) }}>
                            <canvas id="bar-chart-4"></canvas>
                        </div>
                    </div>
                </div>
        </div>
        <?php
         $title = array();
            $courses = DB::table('testuploading')
         //   ->where('title', 'not like', "%AIRCAT%")
                    ->select('id', 'title') 
            ->orderBy('id', 'DESC')
            ->get();
            $newcourses = DB::table('testuploading')
            ->select('id', 'title') 
                         ->where('title', 'like', "%AIRCAT%")
                         ->orderBy('id', 'DESC')
                          ->get();
            foreach($newcourses as $newcourse){
               $course_id[] =  $newcourse->id;

            }
        ?>
       
      <!-- dropdownbutton -->
      <!-- Example single danger button -->
         <div class="row mt-4 align-items-center">
        <!-- Select Test Type -->
            <div class="col-12 col-md-4 col-lg-3 mb-2 mb-md-0">
             <select class="form-select" id="testTypeSelect">
            <option value="">Select Test Type</option>
            @foreach($courses as $course)
                @php
                    $useremail = DB::table('studentlogs')
                                ->where('id', $userid)
                                ->value('email');

                    $assign_test = DB::table('assign_test')
                                    ->where('email', $useremail)
                                    ->where('course_id', $course->title)
                                    ->where('status', 1)
                                    ->first();

                    $checktest = DB::table('tests')
                                ->where('course_id', $course->id)
                                ->orderBy('id', 'desc')
                                ->first();
                @endphp

                @if($assign_test && $checktest)
                    @if(!empty($checktest->testtempid) && $checktest->testtempid == '4')
                        <option value="{{ route('student.xat-tests', $course->id) }}">
                            {{ $course->title }}    
                        </option>

                    @elseif(strpos($course->title, 'NMAT') !== false && $checktest->testtempid != '4')
                        <option value="{{ route('student.nmat-tests', $course->id) }}">
                            {{ $course->title }}
                        </option>
                    @else
                        <option value="{{ route('student.next-tests', $course->id) }}">
                            {{ $course->title }}
                        </option>
                    @endif
                @endif
            @endforeach
        </select>
    </div>
            <!-- Buttons -->
            <div class="col-12 col-md-8 col-lg-6">
                <div class="d-flex gap-3">
                    <a href="{{route('student.next-results',$cid)}}" class="btn btn-success text-white">
                        Result
                    </a>
                    <a href="{{route('student.next-resume',$cid)}}" class="btn btn-warning text-white">
                        Resume
                    </a>
                </div>
            </div>
        </div>
      <!-- end dropdownbuttton -->
      <div class="card mt-4">
         <div class="card-body table-responsive mt-4">
               <table class="table  w-100 text-center table-bordered table-striped">
                  <thead>
                     <tr style ="background-color: #9b2c2c;color: white;">
                         <th class="w-33">Test Name</th>
                         <th class="w-33">Test duration (in Min.)</th>
                         <!--<th>Pdf</th>-->
                         <th class="w-33">Action</th>
                     </tr>
                  </thead>
                  <!--noaircatdata-->
                  <tbody class="mytable"> 
                  </tbody>
                  <!--endnoaircatdat--> 
                  <!--aircatdata--->
                  <tbody class="nomytable"> 
                  <?php 
                    $tests = \App\Models\Test::where('tests.course_id', $cid)
                        ->leftJoin('quiz_durations', 'tests.id', '=', 'quiz_durations.test_id')
                        ->leftJoin('publish_statuses', 'tests.id', '=', 'publish_statuses.test_id')
                        ->join('half_student_quiz', function ($join) use ($userid) {
                            $join->on('tests.id', '=', 'half_student_quiz.test_id')
                                 ->where('half_student_quiz.user_id', '=', $userid);
                        })
                        ->leftJoin('student_quizes as verbal_quiz', function ($join) use ($userid) {
                            $join->on('tests.id', '=', 'verbal_quiz.test_id')
                                 ->where('verbal_quiz.user_id', '=', $userid)
                                 ->where('verbal_quiz.section_type', 'like', '%verbal%');
                        })
                        ->leftJoin('student_quizes as data_quiz', function ($join) use ($userid) {
                            $join->on('tests.id', '=', 'data_quiz.test_id')
                                 ->where('data_quiz.user_id', '=', $userid)
                                 ->where('data_quiz.section_type', 'like', '%data%');
                        })
                        ->leftJoin('student_quizes as quantitative_quiz', function ($join) use ($userid) {
                            $join->on('tests.id', '=', 'quantitative_quiz.test_id')
                                 ->where('quantitative_quiz.user_id', '=', $userid)
                                 ->where('quantitative_quiz.section_type', 'like', '%quantitative%');
                        })
                        ->where(function ($query) {
                            // Only include tests where any section is still incomplete
                            $query->whereNull('verbal_quiz.id')
                                  ->orWhereNull('data_quiz.id')
                                  ->orWhereNull('quantitative_quiz.id');
                        })
                        ->select(
                            'tests.id',
                            'tests.test',
                            \DB::raw('MAX(quiz_durations.verbal_time) as verbal_time'),
                            \DB::raw('MAX(quiz_durations.interp_time) as interp_time'),
                            \DB::raw('MAX(quiz_durations.quantitative_time) as quantitative_time'),
                            \DB::raw('MAX(publish_statuses.status) as publ_status'),
                            \DB::raw('MAX(half_student_quiz.section_name) as half_section_name'),
                            \DB::raw('MAX(half_student_quiz.paper_id) as half_paper_id'),
                            \DB::raw('MAX(verbal_quiz.id) as verbal_completed'),
                            \DB::raw('MAX(data_quiz.id) as data_completed'),
                            \DB::raw('MAX(quantitative_quiz.id) as quantitative_completed')
                        )
                        ->groupBy('tests.id', 'tests.test')
                        //->groupBy('tests.id', 'tests.test','half_student_quiz.test_id', 'half_student_quiz.section_name', 'half_student_quiz.paper_id')
                        ->paginate(5);
            //dd($tests);  
        ?>
                    
@if($tests->isEmpty())
    <tr><td colspan="5">No tests available</td></tr>
@else
 @foreach($tests as $test)
    <?php
     $excel_question = DB::table('excel_questions')
                        ->select('section_name')
                        ->where('test_id',$test->id)
                        ->limit(1)
                        ->first();
    
    $excel_questions = DB::table('excel_questions')
                        ->where('test_id',$test->id)
                        ->get();
                
    $section_name = array();   
    foreach($excel_questions as $excel_question)
    {
        $section_name[] =   $excel_question->section_name;
    }
        $sectionArray = array_unique($section_name);

        $search_terms = [
             'verbal' => 'verbal',
            'data' => 'data',
            'quantitative' => 'quantitative'
        ];
        
      
        $result = [];
        foreach ($search_terms as $key => $term) {
            foreach ($sectionArray as $value) {
                if (stripos($value, $term) !== false) {
                    $result[] = $key; 
                    break; 
                }
            }
        }
        $result_string = implode(', ', $result);
        $exploded_array = explode(', ', $result_string);

      // NEW: ordering logic (preserves original order from DB)  
        $section_order = [];
        foreach ($sectionArray as $value) {
            foreach ($search_terms as $key => $term) {
                if (stripos($value, $term) !== false) {
                    $section_order[] = $key;
                    break;
                }
            }
        }
      $section_order = array_map('strtolower', array_map('trim', $section_order));
      $duration = DB::table('quiz_durations')->where('test_id',$test->id)->orderBy('id','desc')->limit(1)->first();
    ?>

        @php
            $vti = $duration->verbal_time ?? 0;  
            $dti = $duration->interp_time ?? 0;
            $qti = $duration->quantitative_time ?? 0;
            $totime = $vti + $dti + $qti;
        @endphp

        <!-- Check if the test has any incomplete sections before rendering the row -->
       
        @if(($test->half_section_name == 'verbal' || is_null($test->verbal_completed)) ||
            ($test->half_section_name == 'data' || is_null($test->data_completed)) ||
            ($test->half_section_name == 'quantitative' || is_null($test->quantitative_completed)))
          
        <tr>
              
            @if(($section_order === ["verbal","data","quantitative"]) && (in_array('verbal', $exploded_array) && in_array('data', $exploded_array) && in_array('quantitative', $exploded_array))) 
                    
                    @if(($test->half_section_name == 'verbal') && is_null($test->verbal_completed))
                      <td>{{ $test->test }}</td>
                      <td>{{ $totime }}</td>
                        <td>
                            <a href="{{ url('/student/start-quize/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                    @elseif((($test->half_section_name == 'verbal') || ($test->half_section_name == 'data')) && (is_null($test->data_completed)) && (!is_null($test->verbal_completed)) )
                        <td>{{ $test->test }}</td>
                        <td>{{ $totime }}</td>
                        <td>
                            <a href="{{ url('/student/data-quiz/data/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                    @elseif((!is_null($test->verbal_completed)) && (!is_null($test->data_completed)) && (is_null($test->quantitative_completed)) && (($test->half_section_name == 'verbal') || ($test->half_section_name == 'data') || ($test->half_section_name == 'quantitative')))
     
                            <td>{{ $test->test }}</td>
                            <td>{{ $totime }}</td>
                            <td>
                                <a href="{{ url('/student/quantitative-quiz/quantitative/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                            </td>
                    @else
                        <!--<td></td>-->
                    @endif
                @elseif((($section_order === ["data","quantitative","verbal"]) || ($section_order === ["quantitative","data","verbal"]) || ($section_order === ["verbal","quantitative","data"]) ) && (in_array('data', $exploded_array) && in_array('quantitative', $exploded_array) && in_array('verbal', $exploded_array) ))
                    @if(($test->half_section_name == 'verbal') && is_null($test->verbal_completed))
                     <td>{{ $test->test }}</td>
                            <td>{{ $totime }}</td>
                         <td>
                            <a href="{{ url('/student/start-quize/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                    @elseif(($test->half_section_name == 'verbal') && (is_null($test->data_completed)) && (!is_null($test->verbal_completed)) )
                     <td>{{ $test->test }}</td>
                            <td>{{ $totime }}</td>
                         <td>
                            <a href="{{ url('/student/data-quiz/data/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                    @elseif(($test->half_section_name == 'data') && (!is_null($test->verbal_completed)) && (!is_null($test->data_completed)) && (is_null($test->quantitative_completed)))
                     <td>{{ $test->test }}</td>
                            <td>{{ $totime }}</td>
                           <td>
                                <a href="{{ url('/student/quantitative-quiz/quantitative/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                            </td>
                    @else
                        <td></td>
                    @endif

               
            @elseif(in_array('verbal', $exploded_array) && in_array('data', $exploded_array))  
            
                @if(($test->half_section_name == 'verbal') && is_null($test->verbal_completed))
                    <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                     <td>
                        <a href="{{ url('/student/start-quize/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @elseif(($test->half_section_name == 'data') && is_null($test->data_completed) && !is_null($test->verbal_completed) )
                    <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                     <td>
                        <a href="{{ url('/student/data-quiz/data/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @else
                    <td></td>
                @endif
            @elseif(in_array('verbal', $exploded_array) && in_array('quantitative', $exploded_array))
            
                @if(($test->half_section_name == 'verbal') && is_null($test->verbal_completed))
                    <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                     <td>
                        <a href="{{ url('/student/start-quize/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @elseif(($test->half_section_name == 'quantitative') && (!is_null($test->verbal_completed))  && (is_null($test->quantitative_completed)))
                      <td>{{ $test->test }}</td>
                      <td>{{ $totime }}</td>
                       <td>
                            <a href="{{ url('/student/quantitative-quiz/quantitative/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                @else
                    <td></td>
                @endif
            @elseif(in_array('data', $exploded_array) && in_array('quantitative', $exploded_array))
                @if(($test->half_section_name == 'data') && is_null($test->data_completed))
                   <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                     <td>
                        <a href="{{ url('/student/data-quiz/data/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @elseif(($test->half_section_name == 'quantitative') && (!is_null($test->data_completed))  && (is_null($test->quantitative_completed)))
                       <td>{{ $test->test }}</td>
                        <td>{{ $totime }}</td>
                       <td>
                            <a href="{{ url('/student/quantitative-quiz/quantitative/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                        </td>
                @else
                    <td></td>
                @endif
             
             
            @elseif(in_array('verbal', $exploded_array))
                @if(($test->half_section_name == 'verbal') && is_null($test->verbal_completed))
                 <td>{{ $test->test }}</td>
                <td>{{ $totime }}</td>
                <td>
                    <a href="{{ url('/student/start-quize/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                </td>
                @endif
            @elseif(in_array('data', $exploded_array))
                @if(($test->half_section_name == 'data') && is_null($test->data_completed))
                   <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                    <td>
                        <a href="{{ url('/student/data-quiz/data/'.$test->id.'/'.$test->half_paper_id) }}" class="btn btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @endif
             
            @elseif(in_array('quantitative', $exploded_array))
                @if(($test->half_section_name == 'quantitative') && is_null($test->quantitative_completed))
                   <td>{{ $test->test }}</td>
                    <td>{{ $totime }}</td>
                    <td>
                        <a href="{{ url('/student/quantitative-quiz/quantitative/'.$test->id.'/'.$test->half_paper_id) }}" class="btn  btn-sm text-white resum" style="background-color: #A83942; color:white">Resume</a>
                    </td>
                @endif
            @else
                <td></td> 
            @endif
            
        </tr>
            @endif
        @endforeach
    @endif

                  </tbody> 
                  <!--end-->
               </table>
               
            <!-- Add this loader somewhere in your HTML -->
        <!--<div id="loader" class="loader" style="display: none; margin-top:150px;"></div>-->
            <div class="pagination">
                {{ $tests->links() }}
            </div>
            
         <div id="loader" class="loader" style="display: none; margin-top:150px;"></div>
          <div id="pagination-controls"style="display:none">
            <button id="prev-page" disabled>Previous</button>
            <button id="next-page" disabled>Next</button>
        </div>
            <div id="pagination" ></div>
            <p class="showpagin" style="display:none">Showing <span id="current_page">1</span> to <span id="total_pages">1</span><span class="no-test"></span></p>
       
        <!-- End this loader somewhere in your HTML -->
         </div>
      </div>
   </div>
</div>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>





@endsection
@section('script')

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
 
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
  Chart.register(ChartDataLabels);
const chartIds = ["bar-chart-1", "bar-chart-2", "bar-chart-3", "bar-chart-4"];

    let chartData = [];
    var testid = Number($('.crt').attr('data-testid')) || 0;  
    var publishId = Number($('.crt').attr('data-publishId')) || 0;
    var quiz_id = Number($('.crt').attr('data-quiz_id')) || 0;

    var testid1 = Number($('.crt1').attr('data-testid1')) || 0;  
    var publishId1 = Number($('.crt1').attr('data-publishId1')) || 0;
    var quiz_id1 = Number($('.crt1').attr('data-quiz_id1')) || 0;

    
    var testid2 = Number($('.crt2').attr('data-testid2')) || 0;  
    var publishId2 = Number($('.crt2').attr('data-publishId2')) || 0;
    var quiz_id2 = Number($('.crt2').attr('data-quiz_id2')) || 0;

    var testid3 = Number($('.crt3').attr('data-testid3')) || 0;  
    var publishId3 = Number($('.crt3').attr('data-publishId3')) || 0;
    var quiz_id3 = Number($('.crt3').attr('data-quiz_id3')) || 0;

    chartData = [
        [testid, publishId, quiz_id], // AIRCATs
        [testid3, publishId3, quiz_id3], 
    
      [testid1, publishId1, quiz_id1],   // Sectional
      [testid2, publishId2, quiz_id2], // Non CATs

    ];
     //console.log(testid,'chartData');
</script>
<script type="text/javascript" src="{{asset('assets/admin/js/script.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/admin/js/dashboard.js')}}"></script>
<script>
    $(document).ready(function() {
    $('.resum').click(function(){
        localStorage.clear();
    });
});
</script>

<script>
    document.getElementById('testTypeSelect').addEventListener('change', function () {
        if (this.value) {
            window.location.href = this.value;
        }
    });
</script>

<script>
// function preventBackNavigation() {
//     // Initial state to create an entry
//     history.pushState(null, null, window.location.href);
//     console.log(history.pushState(null, null, window.location.href));
//     // Listen for the back navigation event
//     window.addEventListener("popstate", function () {
//         const confirmLeave = confirm("Are you sure you want to go back?");
//         //   var url = "{{ route('student.dashboard')}}";
//         //   window.location.href=url;
//           window.location.href = "https://test.mbaguru.in/student/dashboard"; // Replace with your next page URL
//         if (!confirmLeave) {
//             // Prevent back navigation by adding the state again
//             history.pushState(null, null, window.location.href);
//         }
//     });
// }
// preventBackNavigation();
</script>
@endsection




