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
                  //->where('title', 'not like', "%AIRCAT%")
                    ->select('id', 'title') 
                   ->orderBy('id', 'DESC')
            ->get();
            $newcourses = DB::table('testuploading')
            ->select('id', 'title') 
                         ->where('title', 'like', "%AIRCAT%")
                         ->orderBy('id', 'DESC')
                          ->get();
            foreach($newcourses as $newcourse)
            {
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
                    <a href="{{ route('student.results') }}" class="btn btn-success text-white">
                        Result
                    </a>
                    <a href="{{ route('student.resume') }}" class="btn btn-warning text-white">
                        Resume
                    </a>
                </div>
            </div>
        </div>
      <!-- end dropdownbuttton -->
      <div class="card mt-4">
         <div class="card-body table-responsive mt-4">
               <table class="table  w-100 text-center table-bordered table-striped ">
                  <thead>
                     <tr style ="background-color: #9b2c2c;color: white;">
                         <th class="w-33">Test Name</th>
                         <th class="w-33">Test duration (in Min.)</th>
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
                       $test = \App\Models\Test::whereIn('tests.course_id', $course_id)
                                ->leftJoin('quiz_durations', 'tests.id', '=', 'quiz_durations.test_id')
                                ->leftJoin('publish_statuses', 'tests.id', '=', 'publish_statuses.test_id')
                                ->leftJoin('proctored', 'tests.id', '=', 'proctored.test_id')
                                ->leftJoin('student_quizes', function ($join) use ($userid) {
                                    $join->on('tests.id', '=', 'student_quizes.test_id')
                                         ->where('student_quizes.user_id', '=', $userid)
                                         ->where('publish_statuses.status', '1')
                                         ->where(function ($query) {
                                             $query->where('student_quizes.section_type', 'like', "%verbal%")
                                                   ->orWhere('student_quizes.section_type', 'like', "%Data%")
                                                   ->orWhere('student_quizes.section_type', 'like', "%quantitative%");
                                         });
                                })
                                ->leftJoin('half_student_quiz', function ($join) use ($userid) {
                                    $join->on('tests.id', '=', 'half_student_quiz.test_id')
                                         ->where('half_student_quiz.user_id', '=', $userid);
                                })
                            ->select(
                                'tests.id',
                                'tests.test',
                                \DB::raw('MAX(quiz_durations.verbal_time) as verbal_time'),
                                \DB::raw('MAX(quiz_durations.interp_time) as interp_time'),
                                \DB::raw('MAX(quiz_durations.quantitative_time) as quantitative_time'),
                                \DB::raw('MAX(publish_statuses.status) as publ_status'),
                                \DB::raw('MAX(proctored.status) as pro_status'),
                                \DB::raw('MAX(proctored.pro_code) as pro_code')
                            )
                            ->whereNull('half_student_quiz.test_id') 
                            ->whereNotExists(function ($query) use ($userid) {
                                $query->select(\DB::raw(1))
                                      ->from('student_quizes')
                                      ->whereRaw('student_quizes.test_id = tests.id')
                                      ->where('student_quizes.user_id', '=', $userid);
                            })
                            ->groupBy('tests.id', 'tests.test')
                            ->orderBy('verbal_time', 'desc')
                            ->orderBy('interp_time', 'desc') 
                            ->orderBy('quantitative_time', 'desc')
                            ->orderBy('tests.id','Asc')
                            ->get();
                           // dd($test);
            $i=1;

                    ?>

@if($test->isEmpty())
    <tr><td colspan="5">No tests available</td></tr>
@else
    @foreach($test as $tests)
    <?php
    $duration = DB::table('quiz_durations')->where('test_id',$tests->id)->orderBy('id','desc')->limit(1)->first();
    $pstatus = DB::table('publish_statuses')->select('status')->where('test_id',$tests->id)->orderBy('id','desc')->limit(1)->first();
    ?>
        @php
            $vti = $duration->verbal_time ?? 0;  
            $dti = $duration->interp_time ?? 0;
            $qti = $duration->quantitative_time ?? 0;
            $totime = $vti + $dti + $qti;
        @endphp
        
      @if($pstatus->status == 1)
        <tr style="height:27px;">
            <td>{{ $tests->test }}</td>
            <td>{{ $totime }}</td>
            <td>
                @if($tests->pro_status == '1')
                <div>
                    <form action="https://test.mbaguru.in/student/save-proctored" method="post" enctype="multipart/form-data" style="display:flex;justify-content:space-around;">
                    @csrf
                    <input type="text" name="proctored_code" class="resuminput input-box" data-id="{{ $tests->id }}" placeholder="Enter Code" style="width: 150px; margin-top:-1px;height: 27px; margin-bottom: 0px;">
                        <input type="hidden" name="pro_code" value="{{ $tests->pro_code }}">
                        <input type="hidden" name="id" value="{{ $tests->id }}">
                        <input type="hidden" name="test_id" value="{{ $tests->id }}">
                        <input type="hidden" name="test_name" value="{{ $tests->test }}">
                        <input type="hidden" name="course_id" value="{{ $tests->course_id }}">
                        <input type="hidden" name="status" value="{{ $tests->pro_status }}">
                        <button type="submit" class="btn py-1 btn-success text-white" id="Launch-test-btn" style="height: 27px;">Launch Test</button></br>
                    </form>
                      <span class="par{{ $tests->id }} text-red"></span>
                </div>
                @else
                    <a href="https://test.mbaguru.in/student/instructions/{{ $tests->id }}" class="btn py-1 btn-success text-white pro" id="Launch-test-btn" style="height: 27px; margin-left: 169px;">Launch Test</a>
                @endif
            </td>
        </tr>
        <?php
        $i++;
        ?>
        @endif
    @endforeach
@endif


                  </tbody> 
                  <!--end-->
               </table>
            <!-- Add this loader somewhere in your HTML -->
        <!--<div id="loader" class="loader" style="display: none; margin-top:150px;"></div>-->
          
            
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
    document.getElementById('testTypeSelect').addEventListener('change', function () {
        if (this.value) {
            window.location.href = this.value;
        }
    });
</script>
@endsection




