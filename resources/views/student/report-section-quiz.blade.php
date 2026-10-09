@extends('student_template')
@section('css')
@endsection
@section('content')
<style>
    .active
    {
        background-color:white !important;
        color:black !important;
    }
    td, th{
      text-align:center;
    }
    .sr_th{
      width: 20px;
    }
    
     .highlight {
        color: red;
    }
</style>
   <?php
      $test_id = request()->id;
     // dd($test_id);
      $paper_id = request()->paperid;
      $userid =session()->get('id');
      $test_sections = DB::table('test_sections')
                    ->select('section_name')
                    ->where('test_id',$test_id)
                    ->get();
  $section_record = DB::table('test_sections')
                    ->select('section_name')
                    ->where('test_id',$test_id)
                    ->orderBy('id','Asc')
                    ->limit(1)
                    ->first();
                    
      $tests = DB::table('tests')
                    ->select('test')
                    ->where('id',$test_id)
                    ->orderBy('id','Asc')
                    ->limit(1)
                    ->first();
                    
    ?>
<div class="conatiner-fluid">
   <div class="d-flex  px-4 my-3 justify-content-between align-items-center">
      <h5 class="">{{$tests->test}}</h5>
      <a href="{{route('student.dashboard')}}" class="btn"style="background-color:#A83942;color:white;">Dashboard</a>
   </div>
   
   
    <?php
    $score1 = array();
     $correct_answer1 = array();
   $incorrect1 = array();
   $newans_duration31 = array();
   
    foreach($test_sections as $test_section){
        $question_id = array();
        $answer = array();
        $ans_duration = array();
        $correct_answer = array();
        $incorrect_ans = array();
        $total_positive_marks = 0;
        $total_negative_marks = 0;
        $negative = array();
        $positivem = array();
        $excel_questions = DB::table('excel_questions')
                            ->where('test_id',$test_id)
                            ->where('section_name',$test_section->section_name)
                            ->get();
        foreach($excel_questions as $excel_question)
        {
            $question_id[] = $excel_question->id;
            $negative[] =  $excel_question->negative_mark;
            $positivem[] = $excel_question->positive_mark;
            
            $student_quizs = DB::table('section_student_quizes')
                            ->where('test_id',$test_id)
                            ->where('paper_id',$paper_id)
                            ->where('user_id',$userid)
                            ->where('question_id',$excel_question->id)
                            ->where('section_type',$test_section->section_name)
                            ->first();
                            
             //$answer[] =$student_quizs->answer;
             //$ans_duration[] =$student_quizs->ans_duration;
            $answer[]       = $student_quizs ? $student_quizs->answer : null;
$ans_duration[] = $student_quizs ? $student_quizs->ans_duration : null;


            if(isset($student_quizs)){
                $correct  = $excel_question->correct_option;
                $user_answer = $student_quizs->answer;
                $positive = $excel_question->positive_mark;
               if (strcasecmp($correct, $user_answer) === 0) {
                    $matched_answer = $user_answer;
                    $correct_answer[] = $matched_answer;
                    $total_positive_marks += $excel_question->positive_mark;
                }else{
                    $incorrect_ans[] = $user_answer;
                    //$total_negative_marks += $excel_question->negative_mark;
                }
            }         
        }
        
       $newanswer = array_filter($answer); 
       $newans_duration = array_filter($ans_duration);
       
        $newans_duration2 = array_sum($newans_duration);
        $newans_duration3 = date("H:i:s",  $newans_duration2 / 1000);
        
        //attempttime
       $attempttime = [];
        foreach (array_keys($newanswer) as $index) {
            if (isset($newans_duration[$index])) {
                $attempttime[] = $newans_duration[$index];
            }
        }
         $attempttime1 = array_sum($attempttime);
       
         $attempttime2 = date("H:i:s",  $attempttime1 / 1000);


        $correcttime = [];
        foreach (array_keys($correct_answer) as $index) {
            if (isset($newans_duration[$index])) {
                $correcttime[] = $newans_duration[$index];
            }
        }
         $correcttime1 = array_sum($correcttime);
       
         $correcttime2 = date("H:i:s",  $correcttime1 / 1000);
         //incorrecttime
        $incorrecttime = ($attempttime1) - ($correcttime1);
       $incorrecttime1 = date("H:i:s",  $incorrecttime / 1000);
       //skiptime
       
         $skiptime = ($attempttime1) - ($newans_duration2);
       $skiptime1 = date("H:i:s",  $skiptime / 1000);
       //
       $skip =  count($question_id)-count($newanswer);
       $incorrect = count($newanswer)-count($correct_answer);

       if(count($newanswer) == 0){
          $nsa =   1; 
       }else{
           $nsa =   (count($newanswer)); 
       }
        $accuracy = (count($correct_answer)/$nsa)*100;
        
        $negativeArray = array_filter($incorrect_ans, function ($value) {
                return trim($value) !== '';
        });

    $positiveArray = array_filter($correct_answer, function ($value) {
                return trim($value) !== '';
        });
    $negativevalue = array();
    foreach ($negativeArray as $key => $value) {
        if (isset($negative[$key])) {
            $negativevalue[] = $negative[$key];
        }
    }
    
     $positivevalue = array();
    foreach ($positiveArray as $key => $value) {
        if (isset($positivem[$key])) {
            $positivevalue[] = $positivem[$key];
        }
    }
   $score =  (array_sum($positivevalue)-array_sum($negativevalue));
   
   $score1[] =$score;
   $correct_answer1[] = count($correct_answer);
   $incorrect1[] = ($incorrect);
   $newans_duration31[] = count($newanswer);
  
    ?>
   
       <?php
    }
 
    if(array_sum($newans_duration31) == 0){
         $accu = 0;
    }else{
        $accu = ((array_sum($correct_answer1))/(array_sum($newans_duration31))*100);
    }
   
//   echo'<pre>';
//   print_r(count($correct_answer1));
       ?>
   <!-- box image styling starts  -->
    <div class="row px-3 Propzone" id="card-img-style-box">
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">Score 
                   
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #6C5DD3;">
                            {{ array_sum($score1) }}
                        </h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">Correct Answers<br/>
                   
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #2ED480;">
                         {{array_sum ($correct_answer1) }}
                        </h5>
                        <p class="card-text">
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">
                       Incorrect Answers
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #FD8539;">
                      {{ array_sum($incorrect1) }}
                        </h5>
                        <p class="card-text">
                        </p>
                    </div>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color:white;">
                    <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">
                       Accuracy %
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #B758E3;">
                        {{number_format($accu, 2)}}
                        </h5>
                        <p class="card-text">
                        </p>
                    </div>
                </div>
            </div>
       
   <!-- display box styling starts-->
    <div class="row my-4">
        <div class="col-md-12 ">
       
         </div>
    </div>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#all">Scorecard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#difficulty">Use of Time</a>
      </li>
       <li class="nav-item">
            <a class="btn btn-default" href="{{route('student.section-wise-solution',['id'=>$test_id,'paperid'=>$paper_id,'section_name'=>$section_record->section_name])}}"><b>Solutions</b></a>
       </li>
    </ul>
   
    <!--startall-->
        <div class="tab-content">
        <div class="tab-pane active" id="all">
            <div class="row">
                <div class="card col-lg-12 display-box-data">
                    <table class="table mt-2 table-bordered table-striped" >
                        <thead class="table-danger">
                            <tr>
                                <th style="text-align:center;">Name</th>
                                <th>Questions </th>
                                <th>Time Taken</th>
                                <th>Attempted</th>
                                <th>Correct</th>
                                <th>Incorrect</th>
                                <th>Skipped</th>
                                <th>Score</th>
                                <th>Accuracy%</th>
                                <th>Percentile</th>
                                <th>Benchmark Score</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                            $score2 = array();
                         $correct_answer2 = array();
                         $incorrect2 = array();
                         $newans_duration32 = array();
                         $question_id2 = array();
                         $skip2 = array();
                         $udu = array();
                         $attempttime12 = array();
                         $correcttime12 = array();
                         $incorrecttime2 = array();
                         $skiptime2 = array();
                         $cutoffr1 = array();
                           ?>
                            @foreach($test_sections as $test_section)
                            <?php
                                $question_id = array();
                                $answer = array();
                                $ans_duration = array();
                                $correct_answer = array();
                                $incorrect_ans = array();
                                $total_positive_marks = 0;
                                $total_negative_marks = 0;
                                $negative = array();
                                $positivem = array();
                                $excel_questions = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->where('section_name',$test_section->section_name)
                                            ->get();
                                foreach($excel_questions as $excel_question)
                                {
                                    $question_id[] = $excel_question->id;
                                    $negative[] =  $excel_question->negative_mark;
                                    $positivem[] = $excel_question->positive_mark;
                                    $student_quizs = DB::table('section_student_quizes')
                                                    ->where('test_id',$test_id)
                                                    ->where('paper_id',$paper_id)
                                                    ->where('user_id',$userid)
                                                    ->where('question_id',$excel_question->id)
                                                    ->where('section_type',$test_section->section_name)
                                                    ->first();
                                                    
                                    //  $answer[] =$student_quizs->answer;
                                    //  $ans_duration[] =$student_quizs->ans_duration;
                                    
                                      $answer[]       = $student_quizs ? $student_quizs->answer : null;
                                    $ans_duration[] = $student_quizs ? $student_quizs->ans_duration : null;
                                     
                                    if(isset($student_quizs)){
                                        $correct  = $excel_question->correct_option;
                                        $user_answer = $student_quizs->answer;
                                    
                                        $positive = $excel_question->positive_mark;
                                       if (strcasecmp($correct, $user_answer) === 0) {
                                            $matched_answer = $user_answer;
                                            $correct_answer[] = $matched_answer;
                                            $total_positive_marks += $excel_question->positive_mark;
                                        }else{
                                            $incorrect_ans[] = $user_answer;
                                            //$total_negative_marks += $excel_question->negative_mark;
                                        }
                                    }         
                                }
                                
                               $newanswer = array_filter($answer); 
                               $newans_duration = array_filter($ans_duration);
                               
                                $newans_duration2 = array_sum($newans_duration);
                                $newans_duration3 = date("H:i:s",  $newans_duration2 / 1000);
                                
                                //attempttime
                               $attempttime = [];
                                foreach (array_keys($newanswer) as $index) {
                                    if (isset($newans_duration[$index])) {
                                        $attempttime[] = $newans_duration[$index];
                                    }
                                }
                                 $attempttime1 = array_sum($attempttime);
                               
                                 $attempttime2 = date("H:i:s",  $attempttime1 / 1000);
                  
                   
                                $correcttime = [];
                                foreach (array_keys($correct_answer) as $index) {
                                    if (isset($newans_duration[$index])) {
                                        $correcttime[] = $newans_duration[$index];
                                    }
                                }
                                 $correcttime1 = array_sum($correcttime);
                               
                                 $correcttime2 = date("H:i:s",  $correcttime1 / 1000);
                                 //incorrecttime
                                $incorrecttime = ($attempttime1) - ($correcttime1);
                               $incorrecttime1 = date("H:i:s",  $incorrecttime / 1000);
                               //skiptime
                               
                                 $skiptime = ($newans_duration2) - ($attempttime1);
                          
                                 if($skiptime<0){
                                     $skiptime = 0;
                                 }else{
                                      $skiptime = $skiptime;
                                 }
                               $skiptime1 = date("H:i:s",  $skiptime / 1000);
                               //
                               $skip =  count($question_id)-count($newanswer);
                               $incorrect = count($newanswer)-count($correct_answer);

                               if(count($newanswer) == 0){
                                  $nsa =   1; 
                               }else{
                                   $nsa =   (count($newanswer)); 
                               }
                                $accuracy = (count($correct_answer)/$nsa)*100;
                                
                                $negativeArray = array_filter($incorrect_ans, function ($value) {
                                        return trim($value) !== '';
                                });

                            $positiveArray = array_filter($correct_answer, function ($value) {
                                        return trim($value) !== '';
                                });
                            $negativevalue = array();
                            foreach ($negativeArray as $key => $value) {
                                if (isset($negative[$key])) {
                                    $negativevalue[] = $negative[$key];
                                }
                            }
                            
                            $positivevalue = array();
                            foreach ($positiveArray as $key => $value) {
                                if (isset($positivem[$key])) {
                                    $positivevalue[] = $positivem[$key];
                                }
                            }
                           $score =  (array_sum($positivevalue)-array_sum($negativevalue));
                           
                             $prec = DB::table('percentiles')
                                        ->where('test_id',$test_id)
                                        ->where('score', $score)
                                        ->where('section_type', $test_section->section_name)
                                        ->orderBy('id',"DESC")
                                        ->first();
                                       // dd($prec);
                                if(!empty($prec)){
                                  $prece =  round($prec->percentile, 2); 
                                }else{
                                    $prece =0;
                                }
                                
                                 $cutoff = DB::table('section_cutoff')
                                        ->where('test_id',$test_id)
                                       // ->where('score', $score)
                                        ->where('section_type', $test_section->section_name)
                                        ->orderBy('id',"DESC")
                                        ->first();
                                       // dd($prec);
                                if(!empty($cutoff)){
                                  $cutoffr =  round($cutoff->section_cutoff, 2); 
                                }else{
                                    $cutoffr =0;
                                }
                                
                               $cutoffr1[] = $cutoffr
                            ?>
                            <tr>
                                <td>{{$test_section->section_name}}</td>
                                <td>{{count($question_id)}}</td>
                                <td>{{$newans_duration3}}</td>
                                <td>{{count($newanswer)}}<br/>{{$attempttime2}}</td>
                                <td>{{count($correct_answer)}}<br/>{{$correcttime2}}</td>
                                <td>{{$incorrect}}<br/>{{$incorrecttime1}}</td>
                                <td>{{$skip}}<br/>{{$skiptime1}}</td>
                                <td>{{$score}}</td>
                                <td>{{number_format($accuracy, 2)}}</td> 
                                <td>{{$prece}}</td>
                                <td>{{$cutoffr}}</td>
                            </tr>
                             <?php
                             
                           
                                        
                             $question_id2[] = count($question_id);
                               $score2[] =$score;
                               $correct_answer2[] = count($correct_answer);
                               $incorrect2[] = $incorrect;
                               $newans_duration32[] = count($newanswer);
                               $skip2[] = ($skip);
                               $udu[] = $newans_duration2;
                               $attempttime12[] = $attempttime1;
                               $correcttime12[] = $correcttime1;
                               $incorrecttime2[] = $incorrecttime;
                               $skiptime2[] = $skiptime;
                                ?>
                                @endforeach
                               <?php
                               $udu1 = array_sum($udu);
                               $alldura =  date("H:i:s",  $udu1 / 1000);
                               
                                $attempttime123 =  array_sum($attempttime12);
                               $attempttime1233 =  date("H:i:s",  $attempttime123 / 1000);
                               
                               $correcttime123 =  array_sum($correcttime12);
                               $correcttime1233 =  date("H:i:s",  $correcttime123 / 1000);
                               
                               $incorrecttime23 =  array_sum($incorrecttime2);
                               $incorrecttime233 =  date("H:i:s",  $incorrecttime23 / 1000);
                               
                               $skiptime23 =  array_sum( $skiptime2);
                               $skiptime233 =  date("H:i:s",  $skiptime23 / 1000);
                              
                               
                               if(array_sum($newans_duration32) == 0){
                                     $accu22 = 0;
                                }else{
                                    $accu22 = ((array_sum($correct_answer2))/(array_sum($newans_duration32))*100);
                                }
                               $score23 = array_sum($score2);
                                 $prec1 = DB::table('percentiles')
                                        ->where('test_id',$test_id)
                                        ->where('score', $score23)
                                        ->where('section_type','like', '%overall%')
                                        ->orderBy('id',"DESC")
                                        ->first();
                                       // dd($prec);
                                if(!empty($prec1)){
                                  $prece1 =  round($prec1->percentile, 2); 
                                }else{
                                    $prece1 =0;
                                }
                                                           ?>
                              <tr>
                                <td>Overall</td>
                                <td>{{array_sum($question_id2)}}</td>
                                <td>{{$alldura}}</td>
                                <td>{{array_sum($newans_duration32)}}<br/>{{$attempttime1233}}</td>
                                <td>{{array_sum($correct_answer2)}}<br/>{{$correcttime1233}}</td>
                                <td>{{array_sum($incorrect2)}}<br/>{{$incorrecttime233}}</td>
                                <td>{{array_sum($skip2)}}<br/>{{$skiptime233}}</td>
                                <td>{{array_sum($score2)}}</td>
                                <td>{{number_format($accu22, 2)}}</td> 
                                <td>{{$prece1}}</td>
                                <td>{{ array_sum($cutoffr1) }}</td>
                            </tr>   
                        </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
    <!--endall-->
     
   <?php
   $i= 1;
   $j =1;
   ?>
    
         <!--startdiff-->
        <div class="tab-content" >
           <div class="tab-pane " id="difficulty">
                <div class="row">
                    <div class="card col-lg-12 ">
                        <table class="table table-bordered table-striped mt-2">
                            <thead class="table table-danger w-100">
                                <tr>
                                  <th class="float-left">Use of Time</th>
                                  <th> Questions </th>
                                  <th>Time Taken</th>
                                  <th>Attempted</th>
                                  <th>Correct</th>
                                  <th>Incorrect</th>
                                  <th>Skipped</th>
                                  <th>Score</th>
                                  <th>Accuracy%</th>
                                  <!--<th>Marks per Min</th> -->
                                </tr>
                            </thead>
                            <tbody class="table">
                                <tr>
                            <?php
                                $level = array();
                                $answer = array();
                                $question_id = array();
                                $correct = array();
                                $positive = array();
                                $negative = array();
                                $ans_duration = array();
                                
                                $student_quizs = DB::table('section_student_quizes')
                                            ->where('test_id',$test_id)
                                            ->where('paper_id',$paper_id)
                                            ->where('user_id',$userid)
                                            ->where('level', 'like', "%EASY%")
                                            ->get();
                                foreach($student_quizs as $student_quiz)
                                {
                                   $level[] =  $student_quiz->level;
                                   $answer[] =  $student_quiz->answer;
                                   $ans_duration[] =  $student_quiz->ans_duration;
                                   $question_id[] =  $student_quiz->question_id;
                                }
                             
                                $user_answer= array_filter($answer);
                                $easyans_duration= array_filter($ans_duration);
                                
                                  $easytime1 = array_sum($easyans_duration);
                                 $easytime2 = date("H:i:s",  $easytime1 / 1000);
                                
                                $easyattempttime = [];
                                foreach (array_keys($user_answer) as $index) {
                                    if (isset($easyans_duration[$index])) {
                                        $easyattempttime[] = $easyans_duration[$index];
                                    }
                                }
                                 $easyattempttime1 = array_sum($easyattempttime);
                                 $easyattempttime2 = date("H:i:s",  $easyattempttime1 / 1000);
                                 
                                $excel_questions = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->whereIn('id',$question_id)
                                            ->get();
                                foreach($excel_questions as $excel_question)
                                {
                                  $correct[] =  $excel_question->correct_option;
                                  $positive[] =  $excel_question->positive_mark;
                                  $negative[] =  $excel_question->negative_mark;
                                }
                            
                            $correct_ans = [];
                            foreach ($answer as $key => $value) {
                                if ($value !== null && isset($correct[$key]) && strcasecmp($value, $correct[$key]) === 0) {
                                    $correct_ans[$key] = $value;
                                }
                            }
                           ///
                            $easycorrecttime = [];
                                foreach (array_keys($correct_ans) as $index) {
                                    if (isset($easyans_duration[$index])) {
                                        $easycorrecttime[] = $easyans_duration[$index];
                                    }
                                }
                                 $easycorrecttime1 = array_sum($easycorrecttime);
                                 $easycorrecttime2 = date("H:i:s",  $easycorrecttime1 / 1000);
                                 ///incorrect
                                 $incorrecttime1 = ($easyattempttime1 -$easycorrecttime1);
                                 $incorrecttime2 = date("H:i:s",  $incorrecttime1 / 1000);
                                 
                                 //skip time
                                  $skiptime1 = ($easytime1- $easyattempttime1);
                                  $skiptime2 = date("H:i:s",  $skiptime1 / 1000);
                                 
                          $incorrectAnswers = [];

                            foreach ($answer as $key => $value) {
                            
                                if (
                                    $value !== null &&
                                    array_key_exists($key, $correct) &&
                                    strcasecmp($value, $correct[$key]) !== 0
                                ) {
                                    $incorrectAnswers[$key] = $value;
                                }
                            }
                                                        
                           $skip = (count($level)) -(count($user_answer));
                           
                            $matchingPositive = array_intersect_key($positive, $correct_ans);
                            $matchingNegative = array_intersect_key($negative, $incorrectAnswers);
                            $score = (array_sum($matchingPositive)) - (array_sum($matchingNegative));
                           // print_r($matchingNegative);
                            
                           
                            if(count($user_answer)==0 ){
                              $uans =   1;
                            }else{
                               $uans =  count($user_answer);
                            }
                            $accuracy = (count($correct_ans)/$uans)*100;
                            ?>
                            <td>Easy</td>
                            <td>{{count($level)}}</td>
                            <td>{{$easytime2}}</td>
                            <td>{{count($user_answer)}}<br/>{{$easyattempttime2}}</td>
                            <td>{{count($correct_ans)}}<br/>{{$easycorrecttime2}}</td>
                            <td>{{count($incorrectAnswers)}}<br/>{{$incorrecttime2}}</td>
                            <td>{{$skip}}<br/>{{$skiptime2}}</td>
                            <td>{{$score}}</td>
                            <td>{{ number_format($accuracy, 2) }}</td>
                            </tr>
                            <tr>   
                            <?php
                                $level1 = array();
                                $answer1 = array();
                                $question_id1 = array();
                                $correct1 = array();
                                $positive1 = array();
                                $negative1 = array();
                                $midumans_duration1 = array();
                                $student_quizs1 = DB::table('section_student_quizes')
                                            ->where('test_id',$test_id)
                                            ->where('paper_id',$paper_id)
                                            ->where('user_id',$userid)
                                            ->where('level', 'like', "%MEDIUM%")
                                            ->get();
                                foreach($student_quizs1 as $student_quiz)
                                {
                                   $level1[] =  $student_quiz->level;
                                   $answer1[] =  $student_quiz->answer;
                                    $midumans_duration1[] =  $student_quiz->ans_duration;
                                   $question_id1[] =  $student_quiz->question_id;
                                }
                             
                                $user_answer1= array_filter($answer1);
                                
                                $anstime = array_filter($midumans_duration1);
                                $anstime1 = array_sum($anstime);
                                $anstime2 = date("H:i:s",  $anstime1 / 1000);
                                
                                
                                $mediumattempttime = [];
                                foreach (array_keys($user_answer1) as $index) {
                                    if (isset($midumans_duration1[$index])) {
                                        $mediumattempttime[] = $midumans_duration1[$index];
                                    }
                                }
                                 $mediumattempttime1 = array_sum($mediumattempttime);
                                 $mediumattempttime2 = date("H:i:s",  $mediumattempttime1 / 1000);
                                  
                                $excel_questions1 = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->whereIn('id',$question_id1)
                                            ->get();
                                foreach($excel_questions1 as $excel_question)
                                {
                                  $correct1[] =  $excel_question->correct_option;
                                  $positive1[] =  $excel_question->positive_mark;
                                  $negative1[] =  $excel_question->negative_mark;
                                }
                            
                            $correct_ans1 = [];
                            foreach ($answer1 as $key => $value) {
                                if ($value !== null && isset($correct1[$key]) && strcasecmp($value, $correct1[$key]) === 0) {
                                    $correct_ans1[$key] = $value;
                                }
                            }
                            ///correct time
                             $mediumcorrecttime = [];
                                foreach (array_keys($correct_ans1) as $index) {
                                    if (isset($midumans_duration1[$index])) {
                                        $mediumcorrecttime[] = $midumans_duration1[$index];
                                    }
                                }
                                 $mediumcorrecttime1 = array_sum($mediumcorrecttime);
                                 $mediumcorrecttime2 = date("H:i:s",  $mediumcorrecttime1 / 1000);
                              /// incorrect time
                                $incorrecttime = ($mediumattempttime1 - $mediumcorrecttime1); 
                                $incorrecttime1 = date("H:i:s",  $incorrecttime / 1000);
                                
                                ///skip time
                                $skiptime = ($anstime1-$mediumattempttime1); 
                                $skiptime1 = date("H:i:s",  $skiptime / 1000);
                                
                            $incorrectAnswers1 = [];

                            foreach ($answer1 as $key => $value) {
                            
                                if (
                                    $value !== null &&
                                    array_key_exists($key, $correct1) &&
                                    strcasecmp($value, $correct1[$key]) !== 0
                                ) {
                                    $incorrectAnswers1[$key] = $value;
                                }
                            }

                            $skip1 = (count($level1)) -(count($user_answer1));
                            $matchingPositive1 = array_intersect_key($positive1, $correct_ans1);
                            $matchingNegative1 = array_intersect_key($negative1, $incorrectAnswers1);
                            $score1 = (array_sum($matchingPositive1)) - (array_sum($matchingNegative1));
                          
                            if(count($user_answer1)==0 ){
                              $uans1 =   1;
                            }else{
                               $uans1 =  count($user_answer1);
                            }
                            $accuracy1 = (count($correct_ans1)/$uans1)*100;
                            ?>
                                <td>Intermediate</td>
                                <td>{{count($level1)}}</td>
                                <td>{{$anstime2}}</td>
                                <td>{{count($user_answer1)}}<br/>{{$mediumattempttime2}}</td>
                                <td>{{count($correct_ans1)}}<br/>{{ $mediumcorrecttime2 }}</td>
                                <td>{{count($incorrectAnswers1)}}<br/>{{$incorrecttime1}}</td>
                                <td>{{$skip1}}<br/>{{$skiptime1}}</td>
                                <td>{{$score1}}</td>
                                <td>{{ number_format($accuracy1, 2) }}</td>
                                
                            </tr>
                            <tr>
                            <?php
                                $level2 = array();
                                $answer2 = array();
                                $question_id2 = array();
                                $correct2 = array();
                                $positive2 = array();
                                $negative2 = array();
                                $diffans_duration2 = array();
                                $student_quizs2 = DB::table('section_student_quizes')
                                            ->where('test_id',$test_id)
                                            ->where('paper_id',$paper_id)
                                            ->where('user_id',$userid)
                                            ->where('level', 'like', "%INTENSE%")
                                            ->get();
                                foreach($student_quizs2 as $student_quiz)
                                {
                                   $level2[] =  $student_quiz->level;
                                   $answer2[] =  $student_quiz->answer;
                                   $diffans_duration2[] =  $student_quiz->ans_duration;
                                   $question_id2[] =  $student_quiz->question_id;
                                }
                             
                                $user_answer2= array_filter($answer2);
                                $difftime = array_sum($diffans_duration2);
                                $difftime1 = date("H:i:s",  $difftime / 1000);
                                
                                
                                
                                $diffattempttime = [];
                                foreach (array_keys($user_answer2) as $index) {
                                    if (isset($diffans_duration2[$index])) {
                                        $diffattempttime[] = $diffans_duration2[$index];
                                    }
                                }
                                 $diffattempttime1 = array_sum($diffattempttime);
                                 $diffattempttime2 = date("H:i:s",  $diffattempttime1 / 1000);
                                 
                                $excel_questions2 = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->whereIn('id',$question_id2)
                                            ->get();
                                foreach($excel_questions2 as $excel_question)
                                {
                                  $correct2[] =  $excel_question->correct_option;
                                  $positive2[] =  $excel_question->positive_mark;
                                  $negative2[] =  $excel_question->negative_mark;
                                }
                            
                            $correct_ans2 = [];
                            foreach ($answer2 as $key => $value) {
                                if ($value !== null && isset($correct2[$key]) && strcasecmp($value, $correct2[$key]) === 0) {
                                    $correct_ans2[$key] = $value;
                                }
                            }
                            ///correct time
                             $diffcorrecttime = [];
                                foreach (array_keys($correct_ans2) as $index) {
                                    if (isset($diffans_duration2[$index])) {
                                        $diffcorrecttime[] = $diffans_duration2[$index];
                                    }
                                }
                                 $diffcorrecttime1 = array_sum($diffcorrecttime);
                                 $diffcorrecttime2 = date("H:i:s",  $diffcorrecttime1 / 1000);
                                 
                           ///incorrect time
                            $diffincorrecttime =  ($diffattempttime1)-($diffcorrecttime1);
                            $diffincorrecttime1 = date("H:i:s",  $diffincorrecttime / 1000);
                            //skip
                            $diffskiptime =  ($difftime)-($diffattempttime1);
                            $diffskiptime1 = date("H:i:s",  $diffskiptime / 1000);
                             
                           $incorrectAnswers2 = [];

                            foreach ($answer2 as $key => $value) {
                            
                                if (
                                    $value !== null &&
                                    array_key_exists($key, $correct2) &&
                                    strcasecmp($value, $correct2[$key]) !== 0
                                ) {
                                    $incorrectAnswers2[$key] = $value;
                                }
                            }

                            $skip2 = (count($level2)) -(count($user_answer2));
                            $matchingPositive2 = array_intersect_key($positive2, $correct_ans2);
                            $matchingNegative2 = array_intersect_key($negative2, $incorrectAnswers2);
                            $score2 = (array_sum($matchingPositive2)) - (array_sum($matchingNegative2));
                          
                            if(count($user_answer2)==0 ){
                              $uans2 =   1;
                            }else{
                               $uans2 =  count($user_answer2);
                            }
                            $accuracy2 = (count($correct_ans2)/$uans2)*100;
                            ?>   
                                <td>Difficult</td>
                                <td>{{count($level2)}}</td>
                                <td>{{$difftime1}}</td>
                                <td>{{count($user_answer2)}}<br/>{{$diffattempttime2}}</td>
                                <td>{{count($correct_ans2)}}<br/>{{$diffcorrecttime2}}</td>
                                <td>{{count($incorrectAnswers2)}}<br/>{{$diffincorrecttime1}}</td>
                                <td>{{$skip2}}<br/>{{$diffskiptime1 }}</td>
                                <td>{{$score2}}</td>
                                <td>{{ number_format($accuracy2, 2) }}</td>
                            </tr>
                            <tr>
                                <?php
                                 $question_type = array();
                                 $answer3 = array();
                                 $question_id3 = array();
                                $correct3 = array();
                                $positive3 = array();
                                $negative3 = array();
                                $titaans_duration3 = array();
                                 $student_quizs3 = DB::table('section_student_quizes')
                                            ->where('test_id',$test_id)
                                            ->where('paper_id',$paper_id)
                                            ->where('user_id',$userid)
                                            ->where('question_type', 'not like', "%multi%")
                                            ->get();
                                foreach($student_quizs3 as $student_quiz3)
                                {
                                    $question_type[] = $student_quiz3->question_type;
                                   $answer3[] = $student_quiz3->answer;
                                   $titaans_duration3[] = $student_quiz3->ans_duration;
                                   $question_id3[] =  $student_quiz->question_id;
                                }
                                // dd($answer3); 
                                $user_answer3 =  array_filter($answer3);
                                
                                 $titatime =  array_sum($titaans_duration3);
                                 $titatime1 = date("H:i:s",  $titatime / 1000);
                                 
                                 $titaattempttime = [];
                                foreach (array_keys($user_answer3) as $index) {
                                    if (isset($titaans_duration3[$index])) {
                                        $titaattempttime[] = $titaans_duration3[$index];
                                    }
                                }
                                 $titaattempttime1 = array_sum($titaattempttime);
                                 $titaattempttime2 = date("H:i:s",  $titaattempttime1 / 1000);
                                
                                $excel_questions3 = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->whereIn('id',$question_id3)
                                            ->get();
                                foreach($excel_questions3 as $excel_question)
                                {
                                  $correct3[] =  $excel_question->correct_option;
                                  $positive3[] =  $excel_question->positive_mark;
                                  $negative3[] =  $excel_question->negative_mark;
                                }
                            
                            $correct_ans3 = [];
                            foreach ($answer3 as $key => $value) {
                                if ($value !== null && isset($correct3[$key]) && strcasecmp($value, $correct3[$key]) === 0) {
                                    $correct_ans3[$key] = $value;
                                }
                            }
                            ////correct time
                             $titacorrecttime = [];
                                foreach (array_keys($correct_ans3) as $index) {
                                    if (isset($titaans_duration3[$index])) {
                                        $titacorrecttime[] = $titaans_duration3[$index];
                                    }
                                }
                                 $titacorrecttime1 = array_sum($titacorrecttime);
                                 $titacorrecttime2 = date("H:i:s",  $titacorrecttime1 / 1000);
                                 ///incorrect time
                                 $titaincorrecttime1 = ($titaattempttime1)-($titacorrecttime1);
                                 $titaincorrecttime2 = date("H:i:s",  $titaincorrecttime1 / 1000);
                                 
                                   ///skip time
                                 $titaskiptime1 = ($titatime) - ($titaattempttime1);
                                 $titaskiptime2 = date("H:i:s",  $titaskiptime1 / 1000);
                                 
                            $incorrectAnswers3 = [];
                            foreach ($answer3 as $key => $value) {
                              
                                if ($value !== null && strcasecmp($value, $correct3[$key]) !== 0) {
                                    $incorrectAnswers3[$key] = $value;
                                }
                            }
                            $skip3 = (count($question_type)) -(count($user_answer3));
                            $matchingPositive3 = array_intersect_key($positive3, $correct_ans3);
                            $matchingNegative3 = array_intersect_key($negative3, $incorrectAnswers3);
                            $score3 = (array_sum($matchingPositive3)) - (array_sum($matchingNegative3));
                          
                            if(count($user_answer3)==0 ){
                              $uans3 =   1;
                            }else{
                               $uans3 =  count($user_answer3);
                            }
                            $accuracy3 = (count($correct_ans3)/$uans3)*100;
                                ?>
                               <td>TITA</td>
                               <td>{{count($question_type)}}</td>
                               <td>{{$titatime1}}</td>
                               <td>{{count( $user_answer3)}}<br/>{{$titaattempttime2}}</td>
                               <td>{{count($correct_ans3)}}<br/>{{$titacorrecttime2}}</td>
                                <td>{{count($incorrectAnswers3)}}<br/>{{$titaincorrecttime2}}</td>
                                <td>{{$skip3}}<br/>{{$titaskiptime2}}</td>
                                <td>{{$score3}}</td>
                                <td>{{ number_format($accuracy3, 2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
        <!--enddiff-->
       <!-- start section wise-->
        <div class="container col-md-12" style="margin-top: 10px; margin-bottom:10px;">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    @foreach($test_sections as $test_section)
                  <li class="nav-item">
                    <a class="nav-link showtab" data-bs-toggle="tab" href="#set{{$i}}" data-set ="{{$i}}">{{$test_section->section_name}}</a>
                  </li>
                  <?php
                    $i++;
                  ?>
                  @endforeach
                </ul>
                 @foreach($test_sections as $test_section)
                 <?php
                  $question_id4 = array();
                  $anss = array();
                  $ans = array();
                $seen_ins = array();
                $allans_duration = array();
                   $student_quizs4 = DB::table('section_student_quizes')
                                ->where('test_id',$test_id)
                                ->where('paper_id',$paper_id)
                                ->where('user_id',$userid)
                                ->where('section_type', $test_section->section_name)
                                ->get();
                              //  dd($student_quizs4);
                    foreach($student_quizs4 as $student_quiz4)
                    {
                        $question_id4[] =$student_quiz4->question_id;
                        $anss[] =$student_quiz4->answer;
                        $ans[]=$student_quiz4->answer;
                        $allans_duration[]=$student_quiz4->ans_duration;
                    }
                    
                                 
                     $excel_questions4 = DB::table('excel_questions')
                                            ->where('test_id',$test_id)
                                            ->whereIn('id',$question_id4)
                                            ->get();
                    $i = 1;
                  
                 ?>
                <div class="tab-content" >
                      <div class="tab-pane tbad{{$j}} tabr" id="set{{$j}}">
                        <div class="col-md-12 ">
                            <div class="card bg-white display-box-data ">
                                <table class="table table-bordered table-striped w-100 ">
                                    <thead class="table-danger">
                                        <tr>
                                            <th class="sr_th">Sr.No</th>
                                            <th style="width:700px; text-align:center;">Question</th>
                                            <th>Type</th>
                                            <th>Correct Answer</th>
                                            <th>Your Answer</th>
                                            <th>Marks</th>
                                            <th>Difficulty Level</th>
                                            <th>Time Taken</th>
                                            <th>Level Analysis</th>
                                            <th>Status</th>
                                            <th>SQ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($excel_questions4 as $key=> $que)
                                        
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td><?= htmlspecialchars_decode($que->question) ?></td>
                                            @if($que->question_type == 'multiple' ||  $que->question_type == 'MULTI_CHOICE')
                                    <td>Multi Choice</td>
                                    @elseif($que->question_type =='FILL_IN_THE_BLANKS' || $que->question_type == 'fill_in_the_blanks' || $que->question_type == 'Fill_in_the_blanks' || $que->question_type == 'numerical'||  $que->question_type == 'NUMERICAL' || $que->question_type == 'NUMERIC')
                                     <td>TITA</td>
                                    @else
                                     <td>{{$que->question_type}}</td>
                                    @endif
                                    @if($que->correct_option == '1')
                                    <td style="text-align:center;">A</td>
                                    @elseif($que->correct_option == '2')
                                    <td style="text-align:center;">B</td>
                                    @elseif($que->correct_option == '3')
                                    <td style="text-align:center;">C</td>
                                    @elseif($que->correct_option == '4')
                                    <td style="text-align:center;">D</td>
                                    @else
                                    <td style="text-align:center;">{{$que->correct_option}}</td>
                                    @endif
                                    <?php
                                        $anssv = array_filter($anss);
                                        $found = false; 
                                    ?>
                                    @if(!empty($anssv))
                                        @foreach($anssv as $key1 => $nqus_ids)
                                            @if($key == $key1)
                                                <?php $found = true; ?>  <!-- Mark match found -->
                                                @if(!empty($nqus_ids))
                                                    @if($nqus_ids == '1')
                                                        <td style="text-align:center;">A</td>
                                                    @elseif($nqus_ids == '2')
                                                        <td style="text-align:center;">B</td>
                                                    @elseif($nqus_ids == '3')
                                                        <td style="text-align:center;">C</td>
                                                    @elseif($nqus_ids == '4')
                                                        <td style="text-align:center;">D</td>
                                                    @else
                                                        <td style="text-align:center;">{{$nqus_ids}}</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                            @endif
                                            @endforeach
                                             @if(!$found)
                                           
                                            <td></td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                    @if(isset($ans[$key]) && strcasecmp($ans[$key], $que->correct_option) === 0)
                                        <td>{{$que->positive_mark}}</td>
                                    @elseif(empty($ans[$key])) 
                                        <td>0.0</td>
                                    @else
                                       @if($que->negative_mark == '1.0')
                                        <td>-1.0</td>
                                        @else
                                         <td>{{$que->negative_mark}}</td>
                                        @endif
                                    @endif
                                    @if($que->level == 'INTENSE')
                                        <td>Difficult</td>
                                    @elseif($que->level == 'EASY')
                                        <td>Easy</td>
                                    @elseif($que->level == 'MEDIUM')
                                        <td>Intermediate</td>
                                    @endif
                                    <?php
                                      $allans_durationv = array_filter($allans_duration);
                                      $found = false; 
                                       ?>
                                  @if(!empty($allans_durationv))
                                      @foreach($allans_durationv as $key1 => $allans_ids)
                                      <?php
                                      $allans_ids1 = date("H:i:s",  $allans_ids / 1000);
                                      ?>
                                          @if($key == $key1)
                                              <?php $found = true; ?>  <!-- Mark match found -->
                                              @if(!empty( $allans_ids))
                                                 <td>{{$allans_ids1}}</td>
                                              @else
                                                  <td></td>
                                              @endif
                                          @endif
                                          @endforeach
                                           @if(!$found)
                                         
                                          <td></td>
                                      @endif
                                  @else
                                      <td></td>
                                  @endif
                                    @if((!empty($ans[$key])) &&  ($que->level == 'INTENSE'))
                                     <td>Difficult Attemped?</td>
                                    @elseif((empty($ans[$key])) &&  ($que->level == 'EASY'))
                                        <td>Easy Left?</td>
                                        @else
                                        <td></td>
                                    @endif
                                    @if(isset($ans[$key]) && strcasecmp($ans[$key], $que->correct_option) === 0)
                                      
                                      <td>Correct</td>
                                    @elseif(empty($ans[$key]))
                                        
                                        <td>Skipped</td>
                                    @else
                                        <td>Wrong</td>
                                    @endif 
                                     <?php
                                      $ins = trim(strip_tags($que->instruction));
                                      if (!empty($ins)) {
                                        if (!isset($seen_ins[$ins])) {
                                            echo "<td>Y</td>";
                                            $seen_ins[$ins] = true;
                                        } else {
                                            echo "<td></td>";
                                        }
                                      } else {
                                        echo "<td></td>"; 
                                      }
                                    ?>
                                        </tr>
                                        @endforeach
                                    </tbody>
                              
                              </table>
                              
                            </div>
                        </div>
                    </div>
                </div>
                 <?php
                    $j++;
                  ?>
                  @endforeach
                
                <!-- end Tab panes -->
            </div>
       <!-- end section wise -->
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(".tsl").click(function() {
      var set = $(this).attr('data-set');
      $(".second"+set).css('display','block');
      $(".first"+set).css('display','none');
      $('.less'+set).css('display','block');
      $('.more'+set).css('display','none');
    });
});

 $(document).ready(function() {
    $(".tsd").click(function() {
      var set = $(this).attr('data-set');
      $(".second"+set).css('display','none');
      $(".first"+set).css('display','block');
      $('.less'+set).css('display','none');
      $('.more'+set).css('display','block');
    });
});

 $(document).ready(function() {
    $('.tbad1').addClass('active');
    $('.showtab').click(function(){
        $('.tabr').removeClass('active');
        var set = $(this).attr('data-set');
        $('.tbad'+set).addClass('active')
        
    })
});


</script>
@endsection
@section('script')
@endsection
