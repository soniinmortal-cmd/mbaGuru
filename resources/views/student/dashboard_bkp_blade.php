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
         // dd($tests);   
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

    $reports = DB::table('student_quizes')
                     ->select('paper_id')
                        ->where('user_id',$userid)
                        ->whereIn('test_id',$testId)
                        ->groupBy('paper_id')
                        ->get();
                        
    foreach($reports as $report)
    {
        $quiz_id[] = $report->paper_id;
    }
/////////////End AIRCAT ////////////

/////////////startSectional ////////////
    $course_id1 = array();
    $testId1 = array();
    $publishId1 = array();
    $quiz_id1 = array();
    
    $testuploadings = DB::table('testuploading')
                     ->select('id', 'title') 
                ->where('title','like', "%Sectional%")
                ->get();
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
  
    $reports = DB::table('student_quizes')
                     ->select('paper_id')
                        ->where('user_id',$userid)
                        ->whereIn('test_id',$testId1)
                        ->groupBy('paper_id')
                        ->get();
    foreach($reports as $report)
    {
        $quiz_id1[] = $report->paper_id;
    }

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
   
    $reports = DB::table('student_quizes')
                     ->select('paper_id')
                     ->where('user_id',$userid)
                     ->whereIn('test_id',$testId2)
                     ->groupBy('paper_id')
                     ->get();
                     
    foreach($reports as $report)
    {
        $quiz_id2[] = $report->paper_id;
    }

/////////////End NonCAT ////////////
    ?>
   <div class="conatiner-fluid">
        <div class="row">
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
         <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box " style="background-color:#8b82cf;">
                 <h3>  AIRCATs</h3>
                  <ul>
                  <li>Total Tests : {{count($testId)}}</li>
                  <hr>
                  <li>Tests Released  : {{count($publishId)}}</li>
                  <hr>
                  <li>Tests Attempted : {{count($quiz_id)}}</li>
                  </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box text-center" style="background-color:#D4AF37;">
                   <h3>  Sectional Tests</h3>
                    <ul>
                      <li>Total Tests : {{count($testId1)}}</li>
                      <hr>
                      <li>Tests Released  : {{count($publishId1)}}</li>
                      <hr>
                      <li>Tests Attempted : {{count($quiz_id1)}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box text-center" style="background-color:#ad68a5;">
                   <h3>Non CATs </h3>
                   <ul>
                    <!--<li>Total Tests : {{count($testId2)}}</li>-->
                    <li>Total Tests : {{count($testId2)}}</li>
                    <hr>
                    <li>Tests Released  : {{count($publishId2)}}</li>
                    <hr>
                    <li>Tests Attempted : {{count($quiz_id2)}}</li>
                  </ul>
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
      <button class="btn  mt-3 dropdown-toggle ml-auto " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #A83942; color:white">
         Select Test Type
      </button>
         <a class="btn mt-3 ml-auto" href="{{route('student.results')}}" style="background-color: #A83942; color:white;">Result</a>
         <a class="btn mt-3 ml-auto" href="{{route('student.resume')}}" style="background-color: #A83942; color:white;">Resume</a>
         
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
           @foreach($courses as $course)
              <?php
                 $useremail =  DB::table('studentlogs')
                             ->select('id', 'email') 
                                ->where('id',$userid)
                                ->first();
                 
                 $assign_test = DB::table('assign_test')
                             ->where('email',$useremail->email)
                             ->where('course_id',$course->title)
                             ->where('status',1)
                             ->first();
                             
                $checktest = DB::table('tests')
                             ->where('course_id',$course->id)
                            ->orderBY('id','desc')
                             ->first();
                             
                                
                 ?>
                @if($assign_test)
                  <!--<a class="dropdown-item newcenter" data-id ="{{$course->id}}" data-name ="{{$course->title}}"href="#">{{$course->title}}</a>-->
                    @if(!empty($checktest->testtempid) && ($checktest->testtempid == '4'))
                       <a class="dropdown-item " data-id ="{{$course->id}}" data-name ="{{$course->title}}" href="{{route('student.xat-tests',$course->id)}}">{{$course->title}}</a>
                    @elseif((strpos($course->title, "NMAT") !== false) && ($checktest->testtempid != '4'))
                      <a class="dropdown-item " data-id ="{{$course->id}}" data-name ="{{$course->title}}" href="{{route('student.nmat-tests',$course->id)}}">{{$course->title}}</a>
                    @else
                     <a class= "dropdown-item" data-id = "{{$course->id}}" data-name ="{{$course->title}}" href="{{route('student.next-tests',$course->id)}}">{{$course->title}}</a>
                    @endif
                @endif
            @endforeach
            <?php
             //dd($title);
             $valueToCheck = "AIRCAT";
            ?>
      </div>
      <!-- end dropdownbuttton -->
      <div class="card mt-4">
         <div class="card-body">
               <table class="table  w-100 text-center table-bordered table-striped ">
                  <thead>
                     <tr>
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

<script type="text/javascript" src="{{asset('assets/admin/js/dashboard.js')}}"></script>
@endsection




