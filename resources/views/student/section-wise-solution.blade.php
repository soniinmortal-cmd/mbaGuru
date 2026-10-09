@extends('student_template')
@section('css')
@endsection
@section('content')

<style>
  .green {
         appearance: none;
         padding: 10px;
         background-color: green;
         border-radius:50%;

      }
      .red {
         appearance: none;
         height:10px;
         width:2px;
         border-radius:50%;
         background-color: red;
      }
      input[type="radio"] {
       border:2px solid black;
       padding: 5;
       margin-bottom: -24px;
      
    }
   
   </style>
   
<div class="container-fluid">
   <?php
   //dd($verbal_ques);
    $testid = request()->id;
    $paperid = request()->paperid;
     $userid =session()->get('id');
    $sid = request()->section_name;
       //dd($sid); 
    $test_sections = DB::table('test_sections')
                    ->select('section_name')
                    ->where('test_id',$testid)
                    ->get();
    $test_sectionsname = DB::table('test_sections')
                    ->select('section_name')
                    ->where('test_id',$testid)
                    ->limit(1)
                    ->first();

    ?>
   <div class="row" id="detaildiv" >
      <div class="col-1 pt-3 px-3" id="crossbutton">
         <a href="{{route('student.report-section-quiz',['id'=>$testid,'paperid'=>$paperid])}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
               <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
               <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
         </a>
      </div>
      <div class="col-8" style="border-right:1px solid lightgray; height:100%;">
         <h6 class="py-3">{{$test->test}}{{$test->testincid}}</h6>
      </div>
      <div class="col-3">
         <?php
         $useremail =session()->get('email');
         ?>
         <h6 class="py-3"><b>User: {{$useremail}}</b></h6>
      </div>
   </div>
   <div class="row">
      <div class="col-LG-9" style="border-right:1px solid lightgray; height:100%;">
         <div class="row">
            <div class="col-12 py-2" style="border-bottom:1px solid lightgray">
               <!-- <button type="button" class="btn btn-outline-secondary verbal">VERBAL AND READING COMPREHENSIVE</button> -->
               <button class="btn btn-primary my-2" type="button" disabled="disabled">{{$test_sectionsname->section_name}}</button>
               <button type="button my-2" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">+2 SECTIONS</button>
            </div>
         </div>
         <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
      <div class="offcanvas-header">
         <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Change Section</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p>By changing sections, you will be moved to a new section. If you are certain about changing sections, please select an option from below.</p>
   @foreach($test_sections as $test_section)
    <a class="btn btn-outline-secondary my-1  px-auto w-100" href="{{route('student.next-section-wise-solution',['id'=>$testid,'paperid'=>$paperid,'section_name'=>$test_section->section_name])}}">{{$test_section->section_name}}</a>
    @endforeach
   
  </div>
</div>
 
     
         <div class="row">
            <div class="col-12 py-2">
               <div class="row" style="background-color:#fdf7f7; min-height:50px; height:auto">
                  <div class="col-4 py-2">
                      <span style="display:flex;">&nbsp;&nbsp;Marks
                        <?php
                        $i = 1; 
                        
                        ?>
                        @if(isset($verbal_ques))
                            @foreach($verbal_ques as $key=> $ques_paper)
                                <span class="text-success pos posti{{$i}}" style="display:none">&nbsp;{{$ques_paper->positive_mark}},</span>
                                @if($ques_paper->negative_mark == 0)
                                <span class="text-secondary neg negti{{$i}}" style="display:none">&nbsp;{{$ques_paper->negative_mark}}</span>
                                @else
                                <span class="text-secondary neg negti{{$i}}" style="display:none">&nbsp;-{{$ques_paper->negative_mark}}</span>
                                @endif
                                <?php
                                $i++;
                                ?>
                            @endforeach
                        @endif
               </span>
                     <!-- <span><b>You have missed this question, you scored</b></span> -->
                     <!-- <span class="text-danger"><b>0.0</b></span> -->
                  </div>
                  <?php
                    // $totalQuestions = count($verbal_ques);
                    // $totalCorrectAnswers = 0;
                    // $alltimeduration = 0;
                    // $timedura = array();
                    // foreach ($verbal_ques as $key => $ques_paper) {
                    //     $allCorrect = $ques_paper->correct_option;
                    //     $sectionStudentQuizs = DB::table('section_student_quizes')
                    //                     ->where('question_id', $ques_paper->id)
                    //                     ->where('section_type', $sid)
                    //                     ->where('test_id', $testid)
                    //                     ->get();
                    //     foreach ($sectionStudentQuizs as $sectionStudentQuiz) {
                    //         if (trim($sectionStudentQuiz->answer) === trim($allCorrect)) {
                    //             $totalCorrectAnswers++;
                    //         }
                    //         $alltimeduration += ($sectionStudentQuiz->ans_duration);
                    //       // $timedura[] = $sectionStudentQuiz->ans_duration;
                    //     }
                    // }
               
                    // $alltimeduration1 = date("H:i:s", $alltimeduration / 1000);

                    // // Avoid division by zero
                    // if ($totalQuestions > 0) {
                    //     $averagePercentage = ($totalCorrectAnswers / $totalQuestions) * 100;
                    //     //echo "Average Percentage of Correct Answers: " . $averagePercentage . "%";
                    // } else {
                    //     $averagePercentage = 0;
                    //     //echo "No questions available to calculate average.";
                    // }
                    ///////////////////////////new //////////////////////////////////////////////
                    $totalQuestions = count($verbal_ques);

                    $totalCorrectAnswers = 0;
                    $alltimeduration = 0;
                    $totalAttempts = 0; 
                    
                    foreach ($verbal_ques as $key => $ques_paper) {
                    
                        $allCorrect = $ques_paper->correct_option;
                    
                        $sectionStudentQuizs = DB::table('section_student_quizes')
                            ->where('question_id', $ques_paper->id)
                            ->where('section_type', $sid)
                            ->where('test_id', $testid)
                            ->whereNotNull('answer') 
                            ->get();
                    
                        foreach ($sectionStudentQuizs as $sectionStudentQuiz) {
                    
                            $totalAttempts++;
                    
                            if (trim($sectionStudentQuiz->answer) === trim($allCorrect)) {
                                $totalCorrectAnswers++;
                            }
                    
                            $alltimeduration += (int) $sectionStudentQuiz->ans_duration;
                        }
                    }
                    
                    $averageTimeMs = $totalAttempts > 0 
                        ? $alltimeduration / $totalAttempts 
                        : 0;
                    
                    $averageTimeFormatted = gmdate("H:i:s", $averageTimeMs / 1000);
                    $averageCorrectPercentage = $totalAttempts > 0
                        ? round(($totalCorrectAnswers / $totalAttempts) * 100, 2)
                        : 0;


                  ?>
                  
                  <div class="col-8">
                     <div class="row">
                        <!--<div class="anstime ansti" style="display:none;" >-->
                         <div class="" >
                            <div class="col-4 text-end" style="float:left; text-align:center !important;">
                                   YOUR TIME:<p class="showusertime"></br></p>   
                            </div>
                            <?php
                                $k = 1;
                                foreach ($verbal_ques as $key => $ques_paper) {
                                    $totalCorrectAnswers = 0;
                                    $alltimeduration = 0;
                                    $totalAttempts = 0;
                                
                                    $allCorrect = trim($ques_paper->correct_option);
                                
                                    $sectionStudentQuizs = DB::table('section_student_quizes')
                                                            ->where('question_id', $ques_paper->id)
                                                            ->where('section_type', $sid)
                                                            ->where('test_id', $testid)
                                                            ->whereNotNull('answer')
                                                            ->get();
                                
                                    foreach ($sectionStudentQuizs as $sectionStudentQuiz) {
                                
                                        $totalAttempts++;
                                
                                        if (trim($sectionStudentQuiz->answer) === $allCorrect) {
                                            $totalCorrectAnswers++;
                                        }
                                
                                        $alltimeduration += (int) $sectionStudentQuiz->ans_duration;
                                    }
                                
                                    // ---- CALCULATIONS (PER QUESTION) ----
                                    $averageCorrectPercentage = $totalAttempts > 0
                                        ? ($totalCorrectAnswers / $totalAttempts) * 100
                                        : 0;
                                
                                    $averageTimeMs = $totalAttempts > 0
                                        ? $alltimeduration / $totalAttempts
                                        : 0;
                                
                                    $averageTimeFormatted = gmdate("H:i:s", $averageTimeMs / 1000);
                            ?>
                           <div class="anstime ansti{{$k}}" style="display:none;">
                                <div class="col-4 text-end" style="float:left; text-align:center !important;">
                                    OVERALL CORRECT<br>
                                    {{ number_format($averageCorrectPercentage, 2) }} %
                                </div>
                            
                                <div class="col-4 text-end" style="float:left; text-align:center !important;">
                                    AVERAGE TIME<br>
                                    {{ $averageTimeFormatted }}
                                </div>
                            </div>
                              <?php $k++; ?>
                            <?php  }  ?>    
                        </div>
                     </div>
                  </div>
               </div>
            <div class="maindiv">
                <?php
                  $i =1;
                       $arr = array();
                ?>
                @foreach($verbal_ques as $key=> $ques_paper)
                 <?php
                        $verbal_reports = DB::table('section_student_quizes')
                                        ->where('test_id',$testid)
                                        ->where('user_id',$userid)
                                        ->where('paper_id',$paperid)
                                        ->where('section_type', $ques_paper->section_name)
                                        ->where('question_id',$ques_paper->id)
                                        ->orderBy('id', 'DESC')
                                        ->first();
                        $user_answer = $verbal_reports->answer;
                        $correct = $ques_paper->correct_option;
                        //dd($correct);
                        $ans_duration = $verbal_reports->ans_duration;
                        $ans_duration1 = date("H:i:s", $ans_duration / 1000); 
                  ?>

                @if((empty($ques_paper->instruction))  || ($ques_paper->instruction == 'empty'))
               
                    <div class="row ques{{$i}} qusn" style="display:none;">
                        <input type ="hidden" class="users_time uti{{$i}}" value ="{{ $ans_duration1 }}">
                        <div class="col-12"id="divcontent">
                           <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                           <br/>
                          Your Answer: 
                            @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                <ol class="list-group choices">
                                    @if($ques_paper->option1)
                                        @if($user_answer == 1 || strcasecmp($user_answer, 'A') == 0)
                                            @if($ques_paper->correct_option ==1)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                            <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif
                                    @endif
                                    
                                    @if($ques_paper->option2)
                                        @if($user_answer == 2 || strcasecmp($user_answer, 'B') == 0)
                                            @if($ques_paper->correct_option ==2)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                      </label>
                                                   </div>
                                                </li>  
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif 
                                    @endif
                                    @if($ques_paper->option3)
                                        @if($user_answer == 3 || strcasecmp($user_answer, 'C') == 0)
                                             @if($ques_paper->correct_option ==3)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                             <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input  showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                        @endif
                                    @endif
                                    @if($ques_paper->option4)
                                        @if($user_answer == 4 || strcasecmp($user_answer, 'D') == 0)
                                            @if($ques_paper->correct_option ==4)
                                                    <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input green showdata" name="option"/>
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                          </label>
                                                       </div>
                                                    </li> 
                                            @else
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                      </label>
                                                    </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                     <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                  </label>
                                                </div>
                                            </li>
                                        @endif
                                    @endif
                                     @if($ques_paper->option5)
                                        @if($user_answer == 5 || strcasecmp($user_answer, 'E') == 0)
                                            @if($ques_paper->correct_option ==5)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                      </label>
                                                   </div>
                                                </li>   
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input  showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif
                                    @endif
                                </ol>
                            @else
                                <?= htmlspecialchars_decode($ques_paper->answer) ?>
                            @endif
                        </div>  
                    </div>
               @else
                    <div class="row ques{{$i}} qusn" style="display:none;">
                            <input type ="hidden" class="users_time uti{{$i}}" value ="{{ $ans_duration1 }}">
                      <div class="col-6" id="divcontent" style="width:50%; float:left;">
                        <?= htmlspecialchars_decode($ques_paper->instruction) ?>
                      </div>
                       <div class="col-6" id="divcontent" style="width:50%; float:left;">
                         <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                         Your Answer:
                            @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                 <ol class="list-group choices">
                                    @if($ques_paper->option1)
                                        @if($user_answer == 1 || strcasecmp($user_answer, 'A') == 0)
                                            @if($ques_paper->correct_option ==1)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                            <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif
                                    @endif
                                    
                                    @if($ques_paper->option2)
                                        @if($user_answer == 2 || strcasecmp($user_answer, 'B') == 0)
                                            @if($ques_paper->correct_option ==2)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                      </label>
                                                   </div>
                                                </li>  
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif 
                                    @endif
                                    @if($ques_paper->option3)
                                        @if($user_answer == 3 || strcasecmp($user_answer, 'C') == 0)
                                             @if($ques_paper->correct_option ==3)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                             <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input  showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                        @endif
                                    @endif
                                    @if($ques_paper->option4)
                                        @if($user_answer == 4 || strcasecmp($user_answer, 'D') == 0)
                                            @if($ques_paper->correct_option ==4)
                                                    <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input green showdata" name="option"/>
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                          </label>
                                                       </div>
                                                    </li> 
                                            @else
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                      <input type="radio" class="form-check-input red showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                      </label>
                                                    </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                     <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                  </label>
                                                </div>
                                            </li>
                                        @endif
                                    @endif
                                     @if($ques_paper->option5)
                                        @if($user_answer == 5 || strcasecmp($user_answer, 'E') == 0)
                                            @if($ques_paper->correct_option ==5)
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input green showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                      </label>
                                                   </div>
                                                </li>   
                                            @else
                                                <li class="list-group-item">
                                                   <div class="form-check">
                                                      <input type="radio" class="form-check-input  showdata" name="option"/>
                                                      <label class="form-check-label" >
                                                      <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                      </label>
                                                   </div>
                                                </li>
                                            @endif 
                                        @else
                                            <li class="list-group-item">
                                               <div class="form-check">
                                                  <input type="radio" class="form-check-input  showdata" name="option"/>
                                                  <label class="form-check-label" >
                                                  <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                  </label>
                                               </div>
                                            </li>
                                        @endif
                                    @endif
                                </ol>
                            @else
                                <?= htmlspecialchars_decode($user_answer) ?>
                            @endif

                      </div> 
                   <!--  <div class="corretans cns{{$i}}" style="display:none">
                     <span class="text-success"> Correct Answer: {{$ques_paper->correct_option}}</span>
                  </div> -->
               </div>
               @endif
               <?php 
               $arr[] = $ques_paper;
               $i++; 
               ?>

               @endforeach
            </div>
               <div class="row">
                  <div class="col-12 py-2 d-flex justify-content-around">
                     <button type="button" class="btn btn-primary expt" data-bs-toggle="modal" data-bs-target="#exampleModal" data-set="">EXPLANATION&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button>
                      <button type="button" class="btn btn-primary exptt" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-set="">Correct Answer&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button>
                       <!-- <button type="button" class="btn btn-primary showcol">Show Answer&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button> -->
                      <?php
                        $total = count($arr);
                      ?>
                       <a type="button" class="btn btn-primary nxt" STYLE="float:right" data-ntx ="" data-total="{{$total}}">NEXT&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="buttondiv">
            <?php
            $j =1;
            ?>
             @foreach($verbal_ques as $key=>$ques_paper)
            <?php
           $student_quizs = DB::table('section_student_quizes')
                            ->where('test_id',$testid)
                            ->where('paper_id',$paperid)
                            ->where('user_id',$userid)
                            ->where('question_id',$ques_paper->id)
                            ->where('section_type',$ques_paper->section_name)
                            ->limit(1)
                            ->first();
                $correct  = $ques_paper->correct_option;
                $user_answer = $student_quizs->answer;
                $positive = $ques_paper->positive_mark;
                //  echo'<pre>';
                //  print_r($user_answer); 
            ?>
                @if(!empty($user_answer))
                    @if ((strcasecmp($correct, $user_answer) === 0) || ($correct == $user_answer)) 
                     <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" style="background-color:green;">{{$j}}</button>
                    @else
                        <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" style="background-color:red;">{{$j}}</button>
                    @endif  
                @else
                     <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" >{{$j}}</button>
                @endif
                
           <?php $j++;?>
            @endforeach
            <?php
           // die;
            ?>
         </div>
         <div id="identation">
            <div class="row">
               <div class="col-12">
                  <span style="height:20px; width:20px; background-color:green; border-radius:50%; float:left"></span>
                  <span style="float:left;font-size:13px;margin-top:-1px;">
                     <p>&nbsp;CORRECT ANSWER</p>
                  </span>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <span style="height:20px; width:20px; background-color:RED; border-radius:50%; float:left"></span>
                  <span style="float:left;font-size:13px;">
                     <p>&nbsp;WRONG ANSWER</p>
                  </span>
               </div>
               <div class="col-6">
                  <span style="height:20px; width:20px; background-color:lightgrey; border-radius:50%; margin:5px; float:left"></span>
                  <span style="float:left;font-size:13px; margin-top:5px">
                     <p>NOT ANSWERED</p>
                  </span>
               </div>
            </div>
         </div>
         <div>

            <?php
            $sectionid =1;
            ?>
             
            <a class="btn btn-default" href="{{route('student.solution-question',['testid'=>$testid,'sectionid'=>$sectionid,'paperid'=>$paperid])}}">All Questions</a>
            <!-- <button type="button" class="btn bg-transparent">INSTRUCTION</button> -->

              <a class="btn btn-default" href="{{route('student.solution-instruction',['testid'=>$testid,'sectionid'=>$sectionid,'paperid'=>$paperid])}}">Instructions
            </a>
             </span>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Answer Explanation</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php 
               $l =1; 
            ?>
               @foreach($verbal_ques as $ques_paper)
            <div class="expl excp{{$l}}" style="display:none;"><?= htmlspecialchars_decode($ques_paper->answer_explanation) ?></div>
            <?php $l++;?>
            @endforeach
            </div>
         </div>
   </div>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Correct Answer</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php 
               $lk =1; 
            ?>
               @foreach($verbal_ques as $ques_paper)
            <div class="cre crtc{{$lk}}" style="display:none;">
            @if($ques_paper->question_type == 'multiple' || $ques_paper->question_type == 'MULTI_CHOICE')
            @if($ques_paper->correct_option == 1)
               A
            @elseif($ques_paper->correct_option == 2)
             B
            @elseif($ques_paper->correct_option == 3)
             C
            @elseif($ques_paper->correct_option == 4)
             D
            @else
            <?= htmlspecialchars_decode($ques_paper->correct_option) ?>

            @endif

            @else
            <?= htmlspecialchars_decode($ques_paper->correct_option) ?>
            @endif
            </div>
            <?php $lk++;?>
            @endforeach
            </div>
         </div>
   </div>
</div>

<script type="text/javascript" src="{{asset('assets/admin/js/solution.js')}}"></script>
<script>
//   // newavg avg'.$key.'" 
//    var ctr = 1;
//    $(document).ready(function(){
//       $('.posti1').css('display','block');
//    $('.nxt').click(function(){
     
//       ctr +=1;
//       $('.pos').css('display','none');
//       $('.posti'+ctr).css('display','block');
//       //$('.newavg').css('display','none');
//    })
// });
</script>
<script type="text/javascript">
   $(document).ready(function() {
        // Disable text selection
        $(document).on("selectstart dragstart", function(event) {
           event.preventDefault();
        });
     });
     $(document).ready(function() {
         $('body').bind('cut copy paste', function(event) {
            event.preventDefault();
         });
     });
     
     </script>
      <script>
//      $(window).on('keydown',function(event)
//      {
//      //  console.log(event);
//       if(event.keyCode == 116){
//           return false;
//              //event.preventDefault();
//       }
//       if(event.keyCode == 17){
//           return false; 
//       }else if(event.keyCode == 16){
//           return false;
//       }else if(event.keyCode == 82){
//           return false;
//       }
//      // //   else if(event.keyCode == 116){
//      // //      return false; 
//      // //   }
//      if(event.keyCode==123)
//      {
      
//          return false;
//      }
//      else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
//      {
        
//          return false;  //Prevent from ctrl+shift+i
//      }
//      else if(event.ctrlKey && event.keyCode==73)
//      {
//         // alert('Entered ctrl+shift+i')
//          return false;  //Prevent from ctrl+shift+i
//      }
// });
//  $(document).on("contextmenu",function(e)
//  {
//  return false;
// });

</script>
@endsection
@section('css') 
@endsection

