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
    $testid = request()->id;
    $paperid = request()->paperid;
    
    $section_name = array();  
    $excel_questions = DB::table('excel_questions')
                        ->where('test_id',$testid)
                        ->get();
                        
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
    $first_element = $exploded_array[0];
    ?>


<?php 
                            $q1 = array();
                            $t1 = array();
                            $s1 = array();
                            $c1 = array();
                            $in1 = array();
                            $na1 = array();
                            $to1 = array();
                            $pe1 = array();
                            $fs1 = array();
                            $tc1 = array();
                            $tinct1 = array();
                            $tnt1 = array();
                            $percet = array();
                            $percet1 = array();
                            $inc12 = array();
                            $prci = array();
                            $verbalc = array();
                            $datac = array();
                            $qc = array();
                            $overall = array();
                            $popro = array();
                            ?>       
                            @foreach($reports as $key=> $report)
                            <?php
                               $question_id = explode(",",$report->question_id);
                               $timedata = explode(",",$report->ans_duration);
                                $newtm = array_sum($timedata);
                                $drep = $report->student_duration*60000;
                               
                                $ques_ans = DB::table('excel_questions')
                                            ->where('test_id',$report->test_id)
                                            ->whereIn('id', $question_id)
                                            ->get();

                               $question = count($question_id);
                               $q1[] = $question;
                               $answer = explode(",",$report->answer);
                               $ansdata = array();
                               $positive = array();
                               $negative  = array();
                               foreach($ques_ans as $qst)
                               {
                                  $ansdata[] =   $qst->correct_option;
                                  $positive[] = $qst->positive_mark;
                                  $negative[] = $qst->negative_mark;
                               }
                               $resultt = array_diff_assoc($ansdata, $answer);
                               $correct = array_diff_assoc($ansdata,$resultt);
                               // $inctime = array_intersect_key($timedata,$resultt);
                               $incorrect = count($resultt);
                               $in1[] = $incorrect;
                               $cttr = count($correct);
                               $c1[] = count($correct);
                               $ctime = array_intersect_key($timedata,$correct);

                               $tctime = array_sum($ctime);

                               $tc1[] = $tctime;
                               $fctime = date("H:i:s", $tctime / 1000);
                              
                              $pos = array_intersect_key($positive ,$correct);
                              $popro[] = $pos;
                              $pos1 = array_sum($pos);
                              $show_answer1 = array_filter($answer);
                             // print_r($cttr);
                               $show_answer = count($show_answer1);
                              
                                if($show_answer>$cttr){
                                 
                                  $inctr =     $show_answer- $cttr;
                                }elseif($show_answer == $cttr){
                                 
                                  $inctr =     $show_answer-$cttr;
                                }else{
                                  $inctr =     $cttr-$show_answer;
                                }
                              
                                 
                              $inctrr[] =     $show_answer- $cttr;
                              $sdf = array_diff_key($show_answer1,$correct);
                              
                              $inctime = array_intersect_key($timedata,$sdf);
                                 
                              $tinctime = array_sum($inctime);
                              
                               $tinct1[] =  $tinctime;
                               $finctime = date("H:i:s", $tinctime / 1000);
                               $totalinctime =  $tinctime+$tctime;
                               $tolf =   date("H:i:s", $totalinctime / 1000);

                              // $neg = array_intersect_key($negative , $resultt);
                              // $neg2 =  $inctr*1;
                             
                             
                              // if($inctr == 0){
                              //   $inctr =1;
                              // }else{
                              //   $inctr = $inctr;
                              // }
                              $a = array();
                              for($i =0;$i<$inctr; $i++)
                              {
                                $a[$i] = 1.0; 
                              }
                                               
                              
                                
                            $ansarray = array_filter($answer, function($value) {
                              return $value !== '';
                          });
                            $array1 =($ansdata);
                            $array2 = ($answer);
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
                           
                            $newneg = array_intersect_key($negative,$mismatch_values);

                            $neg = array_intersect_key($negative,$a);
                         
                             $neg3 =  array_sum($a);
                              $counts = array_count_values($neg);
                              //$neg2 =  $counts['1.0'];
                              if (isset($counts[1.0])) {
                                $neg2 = $counts[1.0];
                              } else {
                                  $neg2 = 0; 
                              }
                            
                           
                            //print_r($incorrect);
                              
                              $neg1 = array_sum($neg);
                             
                             // $totalmark = $pos1 - $neg1;
                               //$totalmark = $pos1 - $neg2;
                             $totalmark = $pos1 - array_sum($newneg);

                          
                           //  print_r($totalmark);
                              $to1[] = $totalmark; 
                              if(!empty($positive)){
                                  $per = array_sum($positive);
                              }else{
                                   $per = 1;
                              }

                              if($show_answer == 0)
                              {
                                  $show_answer123 = 1;
                                  
                              }else{
                                  $show_answer123 = $show_answer;
                                  
                              }
                             
                               $ctrc =  count($correct);
                               $per1 = ($ctrc/$show_answer123)*100;
                               $per3 = number_format($per1, 2, '.', '');
                              if($per3 <= -1){
                                  $per2 = 0;
                                  $pe1[] = $per2;
                              }else{
                                  $per2 =  $per3;
                                  $pe1[] = $per2;
                              }
                              $stime = array_intersect_key($timedata,$show_answer1);
                               $tstime = array_sum($stime);
                           
                               $fstime = date("H:i:s", $tstime / 1000); 
                                $s1[] = $show_answer; 
                                if(array_keys($question_id ) == array_keys($answer )){
                                    $non_answer1 =   array_intersect($answer, ['']);
                                    $non_answer  = count($non_answer1);
                                    $na1[] = $non_answer;
                                    $ntime = array_intersect_key($timedata,$non_answer1);
                                    $tntime = array_sum($ntime);
                                    //$tnt1[] = $tntime;
                                    $fntime = date("H:i:s", $tntime / 1000);
                                }else{ 
                                  $newarr = array_diff_key($question_id, $answer);
                                  $qusarr = count($newarr);
                                  $ansarr1 =  array_intersect($answer, ['']);
                                  $ansarr = count($ansarr1);
                                  $non_answer = $qusarr+$ansarr;
                                  $na1[] = $non_answer;
                                  $marr =     array_intersect_key($ansarr1+$newarr);
                                  $ntime = array_intersect_key($timedata,$marr);
                                  $tntime = array_sum($ntime);
                                  //$tnt1[] = $tntime;
                                  $fntime = date("H:i:s", $tntime / 1000);
                                }
                               $inc12[] = $inctr;
                               $email = session()->get('email');
                               $prec = DB::table('percentiles')
                                        ->where('score', $totalmark)
                                        ->where('section_type', 'like', $report->section_type)
                                        ->orderBy('id',"DESC")
                                        ->first();

                                $cutoff = DB::table('cutoff')
                                          ->where('test_id',$report->test_id)
                                          ->orderBy('id',"DESC")
                                          ->first();
                                
                               
                                if($newtm>$drep){
                                  $total_time = date("H:i:s", $drep / 1000);
                                  $newtm = $drep;
                                  if($non_answer == 0){
                                    $tolf = date("H:i:s", $drep / 1000);
                                    $tntime = $drep-$drep;
                                    
                                    $newfctime = $drep-$tctime;
                                    $fs1[] = $drep;
                                  }else{
                                    $newdrep = $drep/2;
                                    $tolf = date("H:i:s", $newdrep / 1000);
                                    $newfctime = $newdrep-$tctime;
                                    $fs1[] = $newdrep;
                                    $tntime = $newdrep;
                                  }
                                  $tnt1[] =$tntime;
                               // }elseif(($newtm>$drep) && ($non_answer!=0)){
                                 
                                  $tntime = $drep/2;
                                 }elseif($question == $show_answer){
                                   $total_time = date("H:i:s", $drep / 1000);
                                   $newtm = $drep;
                                   $tolf = date("H:i:s", $drep / 1000);
                                   $newfctime = $drep-$tctime;
                                   $fs1[] = $drep;
                                   $tntime = $drep-$drep;
                                   $tnt1[] =$tntime;
                                 }else{
                                   $total_time = date("H:i:s", $newtm / 1000);
                                   $newtm = array_sum($timedata);
                                   $newtm = $newtm;
                                   $tolf = $tolf;
                                   $newfctime = $totalinctime-$tctime;
                                   $fs1[] = $tstime;
                                   $tntime = $tntime;
                                   $tnt1[] =$tntime;
                                 }
                                 $t1[] = $newtm;
                                 $finctime = date("H:i:s", $newfctime / 1000);  
                                 $fntime = date("H:i:s", $tntime / 1000);

                                //  $correct11 =  count($correct);
                                //  if($correct11>$show_answer){
                                //   $inctr =  count($correct)-$show_answer;
                                //  }elseif($show_answer>$correct11){
                                //   $inctr =  $show_answer-count($correct);
                                //  }
                                
                            ?>
                            @endforeach
                            <?php
                            $t2  = array_sum($t1);
                            $t3 = date("H:i:s", $t2 / 1000);
                            $fs2 = array_sum($fs1);
                            $fs3 = date("H:i:s", $fs2 / 1000);
                            $tc2 = array_sum($tc1);
                            $tc3 = date("H:i:s", $tc2 / 1000);
                           //$tinct2 = array_sum($tinct1);
                            $tinct2 = $fs2-$tc2;
                           //print_r($tinct2);
                            $tinct3 = date("H:i:s", $tinct2 / 1000);
                            $tnt2 = array_sum($tnt1);
                            $tnt3 = date("H:i:s", $tnt2 / 1000);
                            $tnt13 = array_sum($tnt1);
                            $tnt345 = date("H:i:s", $tnt13 / 1000);
                           $s11 = (array_sum($s1));
                           if($s11 == 0){
                               $s11 = 1;
                           }else{
                               $s11 = (array_sum($s1));
                           }
                           $c11 = (array_sum($c1));
                           $toperpp = ($c11/$s11)*100;
                           $pto =  number_format($toperpp, 2, '.', '');
                          //  echo'<pre>';
                          //  print_r($popro);
                            ?>
<div class="conatiner-fluid">
   <div class="d-flex  px-4 my-3 justify-content-between align-items-center">
      <h3 class="fw-bold text-capitalize">REPORT</h3>
      <a href="{{route('student.dashboard')}}" class="btn"style="background-color:#A83942;color:white;">Dashboard</a>
   </div>
   <!-- box image styling starts  -->
    <div class="row px-3 Propzone" id="card-img-style-box">
     
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style " style="background-color: white;">
                    <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">Score
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #6C5DD3;">
                            {{array_sum($to1)}}
                        </h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">Correct Answers
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #2ED480;">
                        {{array_sum($c1)}}
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
                        {{array_sum($inc12)}}
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
                        {{$pto}}
                        </h5>
                        <p class="card-text">
                        </p>
                    </div>
                </div>
            </div>
       
   <!-- display box styling starts-->
    <div class="row my-4">
        <div class="col-md-12 ">
         <h3>Scorecard</h3>
         </div>
    </div>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#all">All Sections</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#difficulty">Use of Time</a>
      </li>
      @if($first_element == 'verbal')
       <li class="nav-item">
        <a class="btn btn-default" href="{{route('student.solution',['testid'=>$testid,'paperid'=>$paperid])}}"><b>Solutions</b></a>
      </li>
      @elseif($first_element == 'data')
      <li class="nav-item">
        <a class="btn btn-default" href="{{route('student.datasolution',['testid'=>$testid,'paperid'=>$paperid])}}"><b>Solutions</b></a>
      </li>
      @elseif($first_element == 'quantitative')
      <li class="nav-item">
        <a class="btn btn-default" href="{{route('student.qtsolution',['testid'=>$testid,'paperid'=>$paperid])}}"><b>Solutions</b></a>
      </li>
      @endif


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
                                <th>Precentile</th>
                                <th>Benchmark Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $q1 = array();
                            $t1 = array();
                            $s1 = array();
                            $c1 = array();
                            $in1 = array();
                            $na1 = array();
                            $to1 = array();
                            $pe1 = array();
                            $fs1 = array();
                            $tc1 = array();
                            $tinct1 = array();
                            $tnt1 = array();
                            $percet = array();
                            $percet1 = array();
                            $inc12 = array();
                            $prci = array();
                            $verbalc = array();
                            $datac = array();
                            $qc = array();
                            $overall = array();
                            $popro = array();
                            ?>       
                            @foreach($reports as $key=> $report)
                            <?php
                               $question_id = explode(",",$report->question_id);
                               $timedata = explode(",",$report->ans_duration);
                                $newtm = array_sum($timedata);
                                $drep = $report->student_duration*60000;
                               
                                $ques_ans = DB::table('excel_questions')
                                            ->where('test_id',$report->test_id)
                                            ->whereIn('id', $question_id)
                                            ->get();

                               $question = count($question_id);
                               $q1[] = $question;
                               $answer = explode(",",$report->answer);
                               $ansdata = array();
                               $positive = array();
                               $negative  = array();
                               foreach($ques_ans as $qst)
                               {
                                  $ansdata[] =   $qst->correct_option;
                                  $positive[] = $qst->positive_mark;
                                  $negative[] = $qst->negative_mark;
                               }
                               $resultt = array_diff_assoc($ansdata, $answer);
                               $correct = array_diff_assoc($ansdata,$resultt);
                               // $inctime = array_intersect_key($timedata,$resultt);
                               $incorrect = count($resultt);
                               $in1[] = $incorrect;
                               $cttr = count($correct);
                               $c1[] = count($correct);
                               $ctime = array_intersect_key($timedata,$correct);

                               $tctime = array_sum($ctime);

                               $tc1[] = $tctime;
                               $fctime = date("H:i:s", $tctime / 1000);
                              
                              $pos = array_intersect_key($positive ,$correct);
                              $popro[] = $pos;
                              $pos1 = array_sum($pos);
                              $show_answer1 = array_filter($answer);
                             // print_r($cttr);
                               $show_answer = count($show_answer1);
                              
                                if($show_answer>$cttr){
                                 
                                  $inctr =     $show_answer- $cttr;
                                }elseif($show_answer == $cttr){
                                 
                                  $inctr =     $show_answer-$cttr;
                                }else{
                                  $inctr =     $cttr-$show_answer;
                                }
                              
                                 
                              $inctrr[] =     $show_answer- $cttr;
                              $sdf = array_diff_key($show_answer1,$correct);
                              
                              $inctime = array_intersect_key($timedata,$sdf);
                                 
                              $tinctime = array_sum($inctime);
                              
                               $tinct1[] =  $tinctime;
                               $finctime = date("H:i:s", $tinctime / 1000);
                               $totalinctime =  $tinctime+$tctime;
                               $tolf =   date("H:i:s", $totalinctime / 1000);

                              // $neg = array_intersect_key($negative , $resultt);
                              // $neg2 =  $inctr*1;
                             
                             
                              // if($inctr == 0){
                              //   $inctr =1;
                              // }else{
                              //   $inctr = $inctr;
                              // }
                              $a = array();
                              for($i =0;$i<$inctr; $i++)
                              {
                                $a[$i] = 1.0; 
                              }
                                               
                              
                                
                            $ansarray = array_filter($answer, function($value) {
                              return $value !== '';
                          });
                            $array1 =($ansdata);
                            $array2 = ($answer);
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
                           
                            $newneg = array_intersect_key($negative,$mismatch_values);

                            $neg = array_intersect_key($negative,$a);
                         
                             $neg3 =  array_sum($a);
                              $counts = array_count_values($neg);
                              //$neg2 =  $counts['1.0'];
                              if (isset($counts[1.0])) {
                                $neg2 = $counts[1.0];
                              } else {
                                  $neg2 = 0; 
                              }
                            
                             $neg1 = array_sum($neg);
                             $totalmark = $pos1 - array_sum($newneg);
                              $to1[] = $totalmark; 
                              if(!empty($positive)){
                                  $per = array_sum($positive);
                              }else{
                                   $per = 1;
                              }

                              if($show_answer == 0)
                              {
                                  $show_answer123 = 1;
                                  
                              }else{
                                  $show_answer123 = $show_answer;
                                  
                              }
                             
                               $ctrc =  count($correct);
                               $per1 = ($ctrc/$show_answer123)*100;
                               $per3 = number_format($per1, 2, '.', '');
                              if($per3 <= -1){
                                  $per2 = 0;
                                  $pe1[] = $per2;
                              }else{
                                  $per2 =  $per3;
                                  $pe1[] = $per2;
                              }
                              $stime = array_intersect_key($timedata,$show_answer1);
                               $tstime = array_sum($stime);
                           
                               $fstime = date("H:i:s", $tstime / 1000); 
                                $s1[] = $show_answer; 
                                if(array_keys($question_id ) == array_keys($answer )){
                                    $non_answer1 =   array_intersect($answer, ['']);
                                    $non_answer  = count($non_answer1);
                                    $na1[] = $non_answer;
                                    $ntime = array_intersect_key($timedata,$non_answer1);
                                    $tntime = array_sum($ntime);
                                    //$tnt1[] = $tntime;
                                    $fntime = date("H:i:s", $tntime / 1000);
                                }else{ 
                                  $newarr = array_diff_key($question_id, $answer);
                                  $qusarr = count($newarr);
                                  $ansarr1 =  array_intersect($answer, ['']);
                                  $ansarr = count($ansarr1);
                                  $non_answer = $qusarr+$ansarr;
                                  $na1[] = $non_answer;
                                  $marr =     array_intersect_key($ansarr1+$newarr);
                                  $ntime = array_intersect_key($timedata,$marr);
                                  $tntime = array_sum($ntime);
                                  //$tnt1[] = $tntime;
                                  $fntime = date("H:i:s", $tntime / 1000);
                                }
                               $inc12[] = $inctr;
                               $email = session()->get('email');
                               $prec = DB::table('percentiles')
                                        ->where('test_id',$report->test_id)
                                        ->where('score', $totalmark)
                                        ->where('section_type', 'like', $report->section_type)
                                        ->orderBy('id',"DESC")
                                        ->first();

                                $cutoff = DB::table('cutoff')
                                          ->where('test_id',$report->test_id)
                                          ->orderBy('id',"DESC")
                                          ->first();
                                
                               
                                if($newtm>$drep){
                                  $total_time = date("H:i:s", $drep / 1000);
                                  $newtm = $drep;
                                  if($non_answer == 0){
                                    $tolf = date("H:i:s", $drep / 1000);
                                    $tntime = $drep-$drep;
                                    
                                    $newfctime = $drep-$tctime;
                                    $fs1[] = $drep;
                                  }else{
                                    $newdrep = $drep/2;
                                    $tolf = date("H:i:s", $newdrep / 1000);
                                    $newfctime = $newdrep-$tctime;
                                    $fs1[] = $newdrep;
                                    $tntime = $newdrep;
                                  }
                                  $tnt1[] =$tntime;
                               // }elseif(($newtm>$drep) && ($non_answer!=0)){
                                 
                                  $tntime = $drep/2;
                                 }elseif($question == $show_answer){
                                   $total_time = date("H:i:s", $drep / 1000);
                                   $newtm = $drep;
                                   $tolf = date("H:i:s", $drep / 1000);
                                   $newfctime = $drep-$tctime;
                                   $fs1[] = $drep;
                                   $tntime = $drep-$drep;
                                   $tnt1[] =$tntime;
                                 }else{
                                   $total_time = date("H:i:s", $newtm / 1000);
                                   $newtm = array_sum($timedata);
                                   $newtm = $newtm;
                                   $tolf = $tolf;
                                   $newfctime = $totalinctime-$tctime;
                                   $fs1[] = $tstime;
                                   $tntime = $tntime;
                                   $tnt1[] =$tntime;
                                 }
                                 $t1[] = $newtm;
                                 $finctime = date("H:i:s", $newfctime / 1000);  
                                 $fntime = date("H:i:s", $tntime / 1000);

                              if($inctr == 0){
                                $newfctime = 0;
                                $finctime = date("H:i:s", $newfctime / 1000);
                                $fctime = $tolf;
                              }
                                
                            ?>
                            <tr>
                                @if($report->section_type == 'verbal')
                                <td>Verbal Ability and Reading Comprehension</td>
                                @elseif($report->section_type == 'data')
                                <td>Data Interpretation & Logical Reasoning</td>
                                @elseif($report->section_type == 'quantitative')
                                <td>Quantitative Aptitude</td>
                                @else
                                <td>Overall</td>
                                @endif
                                <td>{{$question}}</td>
                                <td>{{$total_time}}</td>
                                <td>{{$show_answer}}<br>({{$tolf}})</td>
                                <td>{{count($correct)}}<br>({{$fctime}})</td>
                                <td>{{$inctr}}<br>({{$finctime}})</td>
                                <td>{{$non_answer}}<br>({{$fntime}})</td>
                                <td>{{$totalmark}}</td>
                                <td>{{$per2}}</td>
                                <?php
                                if(!empty($prec)){
                                  $prece =  round($prec->percentile, 2); 
                                }
                                ?>
                                @if($report->section_type == 'verbal')
                                    @if(!empty($prec))

                                    <td>{{$prece}}</td>
                                    @else
                                   <td>-</td>
                                   @endif
                                @elseif($report->section_type == 'data')
                                 @if(!empty($prec))
                                    <td>{{$prece}}</td>
                                    @else
                                   <td>-</td>
                                   @endif
                                @elseif($report->section_type == 'quantitative')
                               @if(!empty($prec))
                                    <td>{{$prece}}</td>
                                    @else
                                   <td>-</td>
                                   @endif
                                @else
                                <td>-</td>
                                @endif
                                
                                @if($report->section_type == 'verbal')
                                  @if(!empty($cutoff))
                                <td>{{$cutoff->verbal_cutoff}}</td>
                                  @else
                                   <td>-</td>
                                   @endif
                                @elseif($report->section_type == 'data')
                                  @if(!empty($cutoff))
                                 <td>{{$cutoff->data_cutoff}}</td>
                                  @else
                                   <td>-</td>
                                   @endif
                                @elseif($report->section_type == 'quantitative')
                                  @if(!empty($cutoff))
                              <td>{{$cutoff->quantitative_cutoff}}</td>
                               @else
                                   <td>-</td>
                                   @endif
                                @else
                                <td>-</td>
                                 @endif
                            </tr>
                            @endforeach
                            <?php
                            $t2  = array_sum($t1);
                            $t3 = date("H:i:s", $t2 / 1000);
                            $fs2 = array_sum($fs1);
                            $fs3 = date("H:i:s", $fs2 / 1000);
                            $tc2 = array_sum($tc1);
                            $tc3 = date("H:i:s", $tc2 / 1000);
                           //$tinct2 = array_sum($tinct1);
                            $tinct2 = $fs2-$tc2;
                           //print_r($tinct2);
                            $tinct3 = date("H:i:s", $tinct2 / 1000);
                            $tnt2 = array_sum($tnt1);
                            $tnt3 = date("H:i:s", $tnt2 / 1000);
                            $tnt13 = array_sum($tnt1);
                            $tnt345 = date("H:i:s", $tnt13 / 1000);
                           $s11 = (array_sum($s1));
                           if($s11 == 0){
                               $s11 = 1;
                           }else{
                               $s11 = (array_sum($s1));
                           }
                           $c11 = (array_sum($c1));
                           $toperpp = ($c11/$s11)*100;
                          $pto =  number_format($toperpp, 2, '.', '');
                          
                        if((array_sum($inc12)) == 0){
                         
                          $tinct2 = 0;
                          $tinct3 = date("H:i:s", $tinct2 / 1000);
                          $tc3 = $fs3;
                        }
                        $to133 =  array_sum($to1);
                        $npv = DB::table('percentiles')
                                        ->where('score', $to133)
                                        ->where('section_type', 'overall')
                                        ->where('test_id',$testid)
                                        ->orderBy('id',"DESC")
                                        ->first();

                        $newcutoff = DB::table('cutoff')
                              ->where('test_id',$testid)
                              ->orderBy('id',"DESC")
                              ->first();
                            ?>
                            <tr>
                                <td>Overall</td>
                                <td>{{array_sum($q1)}}</td>
                                <td>{{$t3}}</td>
                                <td>{{array_sum($s1)}}<br>({{$fs3}})</td>
                                <td>{{array_sum($c1)}}<br>({{$tc3}})</td>
                                <td>{{array_sum($inc12)}}<br>({{$tinct3}})</td>
                                <td>{{array_sum($na1)}}<br>({{$tnt345}})</td>
                                <td>{{array_sum($to1)}}</td>
                                <!-- <td>{{array_sum($pe1)}}</td> -->
                                 <td>{{$pto}} </td>
                                 @if(!empty($npv))
                                 <td>{{round($npv->percentile, 2)}}</td> 
                                 @else
                                <td>-</td>
                                @endif
                                 @if(!empty($newcutoff))
                                 <td>{{round($newcutoff->overall_cutoff, 2)}}</td> 
                                 @else
                                <td>-</td>
                                @endif
                                <!-- <td>{{array_sum($prci)}}</td> -->
                            </tr>
                    </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
    <!--endall-->
    <!--startdiff-->
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
                </tr>
          </thead>
              <tbody class="table">
                      <?php
                        //new calculation
                        //verbal
                        $inscorr = [];
                        $easycorr = [];
                        $mediumcorr = [];

                        $insskip = [];
                        $easyskip = [];
                        $mediumskip = [];

                        $insincorrect = [];
                        $easyincorrect = [];
                        $mediumincorrect = [];

                        $inscorrecttime = [];
                        $easycorrecttime = [];
                        $mediumcorrecttime= [];

                        $insskiptime = [];
                        $easyskiptime = [];
                        $mediumskiptime= [];

                        $insincorrecttime = [];
                        $easyincorrecttime = [];
                        $mediumincorrecttime= [];

                        $positive= [];
                        $negative = [];

                    if(isset($verbal_reports)){
                        $qus_id = explode(',', $verbal_reports->ans_duration);
                        $ans = explode(',', $verbal_reports->answer);
                  
                        $qqn_id= explode(',', $verbal_reports->question_id);
                        

                       foreach ($array2 as $key => $value) {
                            if (!isset($array1[$key])) {
                                $array1[$key] = '';
                            }
                        }
                  if(isset($verbal_ques)){
                    
                        foreach($verbal_ques as $key=> $que)
                        {
                          $positive[] = $que->positive_mark;
                          $negative[] = $que->negative_mark;
                         
                  
                            //   if(isset($ans[$key]) && $ans[$key] === $que->correct_option)
                          if(isset($ans[$key]) && $ans[$key] === $que->correct_option)
                          {
                            if($que->level == 'INTENSE'){
                              $inscorr[] = $ans[$key];
                              }
                              if($que->level == 'EASY'){
                                $easycorr[] = $ans[$key];
                              }
                              if($que->level == 'MEDIUM'){
                                $mediumcorr[] = $ans[$key];
                              }
                              //correct time
                            
                            foreach($qus_id as $key1=> $qus_ids){
                              if($key == $key1){
                                if($que->level == 'INTENSE'){
                                  $inscorrecttime[] =  $qus_ids;
                                }
                                if($que->level == 'EASY'){
                                  $easycorrecttime[] =  $qus_ids;
                                }
                                if($que->level == 'MEDIUM'){
                                  $mediumcorrecttime[] =  $qus_ids;
                                }
                              }
                            }
                   
                        }elseif(empty($ans[$key])){
                            if($que->level == 'INTENSE'){
                              if (isset($ans[$key])) {
                                $insskip[] = $ans[$key];
                              } else {
                                $insskip[] = 0;
                              }
                            }
                            if($que->level == 'EASY'){
                              if (isset($ans[$key])) {
                               $easyskip[] = $ans[$key];
                               
                              } 
                              else {
                               $easyskip[] = 0;
                              }
                            
                            }
                            if($que->level == 'MEDIUM'){
                              if (isset($ans[$key])) {
                                $mediumskip[] = $ans[$key];
                              } else {
                                $mediumskip[] = 0;
                              }
                            }
                           
                            //skiptime
                            foreach($qus_id as $key1=> $qus_ids){
                              if($key == $key1){
                                if($que->level == 'INTENSE'){
                                  $insskiptime[] =  $qus_ids;
                                }
                                if($que->level == 'EASY'){
                                  $easyskiptime[] =  $qus_ids;
                                }
                                if($que->level == 'MEDIUM'){
                                  $mediumskiptime[] =  $qus_ids;
                                }
                              }
                            }
                          }else{
                            //verbalincorrect
                            if($que->level == 'INTENSE'){
                              if (isset($ans[$key])) {
                                $insincorrect[$key] = $ans[$key];
                              } else {
                                $insincorrect[$key] = 0;
                              }
                            }
                            if($que->level == 'EASY'){
                              if (isset($ans[$key])) {
                                $easyincorrect[$key] = $ans[$key];
                              } else {
                                $easyincorrect[$key] = 0;
                              }
                            }
                            if($que->level == 'MEDIUM'){
                              if (isset($ans[$key])) {
                                $mediumincorrect[$key] = $ans[$key];
                              } else {
                                $mediumincorrect[$key] = 0;
                              }
                            }

                            //incorrect time
                            
                            foreach($qus_id as $key1=> $qus_ids){
                              if($key == $key1){
                                if($que->level == 'INTENSE'){
                                  $insincorrecttime[] =  $qus_ids;
                                }
                                if($que->level == 'EASY'){
                                  $easyincorrecttime[] =  $qus_ids;
                                }
                                if($que->level == 'MEDIUM'){
                                  $mediumincorrecttime[] =  $qus_ids;
                                }
                              }
                            }

                          }
                            
                        }
                    }
                    }
                     
                    if((isset($data_reports)) && (isset($data_ques))){
                      $qus_id = explode(',', $data_reports->ans_duration);
                      $ans = explode(',', $data_reports->answer);
                      
                      $inscorr2 = [];
                      $easycorr2 = [];
                      $mediumcorr2 = [];
                      //skip
                      $insskip2 = [];
                      $easyskip2 = [];
                      $mediumskip2 = [];
                      //medium
                      $insincorrect2 = [];
                      $easyincorrect2 = [];
                      $mediumincorrect2 = [];

                      $inscorrecttime2 = [];
                      $easycorrecttime2 = [];
                      $mediumcorrecttime2 = [];

                      $insskiptime2 = [];
                      $easyskiptime2 = [];
                      $mediumskiptime2 = [];

                      $insincorrecttime2 = [];
                      $easyincorrecttime2 = [];
                      $mediumincorrecttime2 = [];
                      $positive2 = [];
                      $negative2 = [];
                    if(isset($data_ques)){
                    foreach($data_ques as $key => $que)
                    { 
                        $positive2[] = $que->positive_mark;
                        $negative2[] = $que->negative_mark; 
                        if(isset($ans[$key]) && $ans[$key] === $que->correct_option) {
                         //correct
                        if($que->level == 'INTENSE'){
                         $inscorr2[] = $ans[$key];
                        }
                        if($que->level == 'EASY'){
                          $easycorr2[] = $ans[$key];
                         }
                         if($que->level == 'MEDIUM'){
                          $mediumcorr2[] = $ans[$key];
                         }
                         
                         //correct time
                            
                         foreach($qus_id as $key1=> $qus_ids){
                          if($key == $key1){
                            if($que->level == 'INTENSE'){
                              $inscorrecttime2[] =  $qus_ids;
                            }
                            if($que->level == 'EASY'){
                              $easycorrecttime2[] =  $qus_ids;
                            }
                            if($que->level == 'MEDIUM'){
                              $mediumcorrecttime2[] =  $qus_ids;
                            }
                          }
                        }
                      }elseif(empty($ans[$key])) {
                       //skip
                          if($que->level == 'INTENSE'){
                            if (isset($ans[$key])) {
                              $insskip2[] = $ans[$key];
                            } else {
                              $insskip2[] = 0;
                            }
                          }

                          if($que->level == 'EASY'){
                            if (isset($ans[$key])) {
                              $easyskip2[] = $ans[$key];
                            } else {
                            $easyskip2[] = 0;
                             
                            }
                          }
  
                          if($que->level == 'MEDIUM'){
                            if (isset($ans[$key])) {
                              $mediumskip2[] = $ans[$key];
                            } else {
                            $mediumskip2[] = 0;
                             
                            }
                          }

                           //skiptime
                           foreach($qus_id as $key1=> $qus_ids){
                            if($key == $key1){
                              if($que->level == 'INTENSE'){
                                $insskiptime2[] =  $qus_ids;
                              }
                              if($que->level == 'EASY'){
                                $easyskiptime2[] =  $qus_ids;
                              }
                              if($que->level == 'MEDIUM'){
                                $mediumskiptime2[] =  $qus_ids;
                              }
                            }
                          }
                        }else{
                          //data incorrect
                          if($que->level == 'INTENSE'){
                            if (isset($ans[$key])) {
                              $insincorrect2[$key] = $ans[$key];
                            } else {
                              $insincorrect2[$key] = 0;
                            }
                          }
                          if($que->level == 'EASY'){
                            if (isset($ans[$key])) {
                              $easyincorrect2[$key] = $ans[$key];
                            } else {
                              $easyincorrect2[$key] = 0;
                            }
                          }
                          if($que->level == 'MEDIUM'){
                            if (isset($ans[$key])) {
                              $mediumincorrect2[$key] = $ans[$key];
                            } else {
                              $mediumincorrect2[$key] = 0;
                            }
                          }

                           //incorrect time
                            
                           foreach($qus_id as $key1=> $qus_ids){
                            if($key == $key1){
                              if($que->level == 'INTENSE'){
                                $insincorrecttime2[] =  $qus_ids;
                              }
                              if($que->level == 'EASY'){
                                $easyincorrecttime2[] =  $qus_ids;
                              }
                              if($que->level == 'MEDIUM'){
                                $mediumincorrecttime2[] =  $qus_ids;
                              }
                            }
                          }

                          
                        }
                      }
                    }
                    }
                    //enddata

                    //quantitative
                    if(isset($qt_reports)){
                      $qus_id = explode(',', $qt_reports->ans_duration);
                      $ans = explode(',', $qt_reports->answer);
                      $inscorr3 = [];
                      $easycorr3 = [];
                      $mediumcorr3 = [];

                      $insskip3 = [];
                      $easyskip3 = [];
                      $mediumskip3 = [];

                      $insincorrect3 = [];
                      $easyincorrect3 = [];
                      $mediumincorrect3 = [];

                      $inscorrecttime3 = [];
                      $easycorrecttime3 = [];
                      $mediumcorrecttime3 = [];

                      $insskiptime3 = [];
                      $easyskiptime3 = [];
                      $mediumskiptime3 = [];

                      $insincorrecttime3 = [];
                      $easyincorrecttime3 = [];
                      $mediumincorrecttime3 = [];
                      $positive3 = [];
                      $negative3 = [];
                      //$correcttime3 = [];
                    if(isset($qt_ques)){
                      foreach($qt_ques as $key=> $que){
                        $positive3[] = $que->positive_mark;
                        $negative3[] = $que->negative_mark; 

                      if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                      {
                        if($que->level == 'INTENSE'){
                          $inscorr3[] = $ans[$key];
                         }
                         if($que->level == 'EASY'){
                           $easycorr3[] = $ans[$key];
                          }
                          if($que->level == 'MEDIUM'){
                           $mediumcorr3[] = $ans[$key];
                          }

                          //correct time
                            
                         foreach($qus_id as $key1=> $qus_ids){
                          if($key == $key1){
                            if($que->level == 'INTENSE'){
                              $inscorrecttime3[] =  $qus_ids;
                            }
                            if($que->level == 'EASY'){
                              $easycorrecttime3[] =  $qus_ids;
                            }
                            if($que->level == 'MEDIUM'){
                              $mediumcorrecttime3[] =  $qus_ids;
                            }
                          }
                        }
                      }elseif(empty($ans[$key])) {
                    
                        if($que->level == 'INTENSE'){
                            if (isset($ans[$key])) {
                              $insskip3[] = $ans[$key];
                          } else {
                            $insskip3[] = 0;
                             
                          }
                        }
                        if($que->level == 'EASY'){
                          if (isset($ans[$key])) {
                            $easyskip3[] = $ans[$key];
                          } else {
                          $easyskip3[] = 0;
                          
                          }
                        }

                        if($que->level == 'MEDIUM'){
                          if (isset($ans[$key])) {
                            $mediumskip3[] = $ans[$key];
                          } else {
                          $mediumskip3[] = 0;
                          
                          }
                        }

                         //skiptime
                         foreach($qus_id as $key1=> $qus_ids){
                          if($key == $key1){
                            if($que->level == 'INTENSE'){
                              $insskiptime3[] =  $qus_ids;
                            }
                            if($que->level == 'EASY'){
                              $easyskiptime3[] =  $qus_ids;
                            }
                            if($que->level == 'MEDIUM'){
                              $mediumskiptime3[] =  $qus_ids;
                            }
                          }
                        }

                      }else{
                        //incorrect

                        if($que->level == 'INTENSE'){
                          if (isset($ans[$key])) {
                            $insincorrect3[$key] = $ans[$key];
                          } else {
                            $insincorrect3[$key] = 0;
                          }
                        }
                        if($que->level == 'EASY'){
                          if (isset($ans[$key])) {
                            $easyincorrect3[$key] = $ans[$key];
                          } else {
                            $easyincorrect3[$key] = 0;
                          }
                        }
                        if($que->level == 'MEDIUM'){
                          if (isset($ans[$key])) {
                            $mediumincorrect3[$key] = $ans[$key];
                          } else {
                            $mediumincorrect3[$key] = 0;
                          }
                        }
                        //incorrect time
    
                        foreach($qus_id as $key1=> $qus_ids){
                          if($key == $key1){
                            if($que->level == 'INTENSE'){
                              $insincorrecttime3[] =  $qus_ids;
                            }
                            if($que->level == 'EASY'){
                              $easyincorrecttime3[] =  $qus_ids;
                            }
                            if($que->level == 'MEDIUM'){
                              $mediumincorrecttime3[] =  $qus_ids;
                            }
                          }
                        }
                      }
                    }
                    }
                    }
                    
                    
                     if(isset($verbal_reports)){
                         $inscorrecttime = $inscorrecttime;
                         $easycorrecttime = $easycorrecttime;
                         $mediumcorrecttime = $mediumcorrecttime;
                         $mediumskiptime = $mediumskiptime;
                         $insskiptime = $insskiptime;
                         $easyskiptime = $easyskiptime;
                         $mediumskiptime = $mediumskiptime;
                         $insincorrecttime = $insincorrecttime;
                         $easyincorrecttime = $easyincorrecttime;
                         $mediumincorrecttime = $mediumincorrecttime;
                         $insskip = $insskip;
                         $inscorr = $inscorr;
                         $easycorr = $easycorr;
                         $mediumskip = $mediumskip;
                         $easyskip =$easyskip;
                         $insincorrect = $insincorrect;
                         $mediumcorr = $mediumcorr;
                         $easyincorrect = $easyincorrect;
                         $mediumincorrect = $mediumincorrect;
                         $negative = $negative;
                         $positive = $positive;
                     }else{
                         $inscorrecttime = [];
                         $easycorrecttime = [];
                         $mediumcorrecttime = [];
                         $mediumskiptime = [];
                         $insskiptime = [];
                         $easyskiptime = [];
                         $mediumskiptime = [];
                         $insincorrecttime = [];
                         $easyincorrecttime = [];
                         $mediumincorrecttime = [];
                         $insskip = [];
                         $inscorr = [];
                         $easycorr = [];
                         $mediumskip = [];
                         $easyskip = [];
                         $insincorrect = [];
                         $mediumcorr = [];
                         $easyincorrect = [];
                         $mediumincorrect = [];
                         $negative = [];
                         $positive = [];
                     }
                     
                    if(isset($data_reports)){
                       $inscorrecttime2 = $inscorrecttime2;
                       $easycorrecttime2 = $easycorrecttime2;
                       $mediumcorrecttime2 = $mediumcorrecttime2;
                       $mediumskiptime2 = $mediumskiptime2;
                       $insskiptime2 = $insskiptime2;
                       $easyskiptime2 = $easyskiptime2;
                       $insincorrecttime2 = $insincorrecttime2;
                       $easyincorrecttime2 = $easyincorrecttime2;
                       $mediumincorrecttime2 = $mediumincorrecttime2;
                       $insskip2=$insskip2;
                       $inscorr2 = $inscorr2;
                       $easycorr2 = $easycorr2;
                       $mediumskip2 = $mediumskip2;
                       $easyskip2 = $easyskip2;
                       $mediumskip2 = $mediumskip2;
                       $insincorrect2 = $insincorrect2;
                       $mediumcorr2 = $mediumcorr2;
                       $easyincorrect2 = $easyincorrect2;
                       $mediumincorrect2 = $mediumincorrect2;
                       $negative2 = $negative2;
                       $positive2 = $positive2;
                    }else{
                      $inscorrecttime2 = []; 
                      $easycorrecttime2 = [];
                      $mediumcorrecttime2 = [];
                      $mediumskiptime2 = [];
                      $insskiptime2 = [];
                      $easyskiptime2 = [];
                      $insincorrecttime2 = [];
                      $easyincorrecttime2 = [];
                      $mediumincorrecttime2 = [];
                      $insskip2 = [];
                      $inscorr2 = [];
                      $easycorr2 = [];
                      $mediumskip2 = [];
                      $easyskip2 = [];
                      $mediumskip2 = [];
                      $insincorrect2 = [];
                      $mediumcorr2 = [];
                      $easyincorrect2 = [];
                      $mediumincorrect2 = [];
                      $negative2 = [];
                      $positive2 = [];
                    }
                    
                    if(isset($qt_reports)){
                       $inscorrecttime3  = $inscorrecttime3;
                       $easycorrecttime3 = $easycorrecttime3;
                       $mediumcorrecttime3 = $mediumcorrecttime3;
                       $insskiptime3 = $insskiptime3;
                       $easyskiptime3 = $easyskiptime3;
                       $mediumskiptime3 = $mediumskiptime3;
                       $insincorrecttime3= $insincorrecttime3;
                       $easyincorrecttime3 = $easyincorrecttime3;
                       $mediumincorrecttime3 = $mediumincorrecttime3;
                       $insskip3 = $insskip3;
                       $inscorr3 = $inscorr3;
                       $easycorr3 = $easycorr3;
                       $mediumskip3 = $mediumskip3;
                       $easyskip3 = $easyskip3;
                       $mediumskip3 = $mediumskip3;
                       $insincorrect3 = $insincorrect3;
                       $mediumcorr3 =$mediumcorr3;
                       $easyincorrect3 = $easyincorrect3;
                       $mediumincorrect3 = $mediumincorrect3;
                       $negative3 = $negative3;
                       $positive3 = $positive3;
                    }else{
                        $inscorrecttime3 = [];
                        $easycorrecttime3 = [];
                        $mediumcorrecttime3 = [];
                        $insskiptime3 = [];
                        $easyskiptime3 = [];
                        $mediumskiptime3 = [];
                        $insincorrecttime3 =[];
                        $easyincorrecttime3 = [];
                        $mediumincorrecttime3 = [];
                        $insincorrect3 = [];
                        $easycorr3 = [];
                        $insskip3 = [];
                        $mediumskip3 = [];
                        $easyskip3 = [];
                        $mediumskip3 = [];
                        $mediumcorr3 = [];
                        $inscorr3 = [];
                        $easyincorrect3 = [];
                        $mediumincorrect3 = [];
                        $negative3 = [];
                        $positive3 = [];
                    }
                     $totalinsskip = count($insskip) + count($insskip2) + count($insskip3);
                      $totaleasyskip = count($easyskip)+ count($easyskip2)+ count($easyskip3);
                    $totalmediumskip = count($mediumskip)+ count($mediumskip2)+ count($mediumskip3);
                    
                    $totalinscorrecttime = array_sum($inscorrecttime) + array_sum($inscorrecttime2) + array_sum($inscorrecttime3);
                    
                    $totalinscorrecttime1 =  date("H:i:s", $totalinscorrecttime / 1000);

                    $totaleasycorrecttime = array_sum($easycorrecttime) + array_sum($easycorrecttime2) + array_sum($easycorrecttime3);
                    $totaleasycorrecttime1 =  date("H:i:s", $totaleasycorrecttime / 1000);

                    $totalmediumcorrecttime = array_sum($mediumcorrecttime) + array_sum($mediumcorrecttime2) + array_sum($mediumcorrecttime3);
                    $totalmediumcorrecttime1 =  date("H:i:s", $totalmediumcorrecttime / 1000);

                    //skiptime
                    $totalinsskiptime = array_sum($insskiptime) + array_sum($insskiptime2) + array_sum($insskiptime3);
                    $totalinsskiptime1 =  date("H:i:s", $totalinsskiptime / 1000);

                    $totaleasyskiptime = array_sum($easyskiptime) + array_sum($easyskiptime2) + array_sum($easyskiptime3);
                    $totaleasyskiptime1 =  date("H:i:s", $totaleasyskiptime / 1000);

                    $totalmediumskiptime = array_sum($mediumskiptime) + array_sum($mediumskiptime2) + array_sum($mediumskiptime3);
                    $totalmediumskiptime1 =  date("H:i:s", $totalmediumskiptime / 1000);

                     //incorrecttime
                     $totalinsincorrecttime = array_sum($insincorrecttime) + array_sum($insincorrecttime2) + array_sum($insincorrecttime3);
                     $totalinsincorrecttime1 =  date("H:i:s", $totalinsincorrecttime / 1000);

                     $totaleasyincorrecttime = array_sum($easyincorrecttime) + array_sum($easyincorrecttime2) + array_sum($easyincorrecttime3);
                     $totaleasyincorrecttime1 =  date("H:i:s", $totaleasyincorrecttime / 1000);

                     $totalmediumincorrecttime = array_sum($mediumincorrecttime) + array_sum($mediumincorrecttime2) + array_sum($mediumincorrecttime3);
                     $totalmediumincorrecttime1 =  date("H:i:s", $totalmediumincorrecttime / 1000);
                    
                     //insattempt
                     $insattempttime = ($totalinscorrecttime) + ($totalinsincorrecttime);
                      $insattempttime1 = date("H:i:s", $insattempttime / 1000);
                    //easyattempt
                    $easyattempttime =  ($totaleasycorrecttime)+ ($totaleasyincorrecttime);
                    $easyattempttime1 =  date("H:i:s", $easyattempttime / 1000);

                    //mediumattempt
                    $mediumattempttime = ($totalmediumincorrecttime)+($totalmediumcorrecttime);
                    $mediumattempttime1 =  date("H:i:s", $mediumattempttime / 1000);

                    //instime taken 

                   $instimetaken =  $totalinscorrecttime+$totalinsskiptime+$totalinsincorrecttime;
                   $instimetaken1 =  date("H:i:s", $instimetaken / 1000);
                   //easytime taken

                     $easytimetaken  = $totaleasycorrecttime+$totaleasyskiptime+ $totaleasyincorrecttime;
                     $easytimetaken1 =  date("H:i:s", $easytimetaken / 1000);

                     //mediumtime taken
                     
                     $mediumtimetaken = $totalmediumcorrecttime+ $totalmediumskiptime+$totalmediumincorrecttime;
                     $mediumtimetaken =  date("H:i:s", $mediumtimetaken / 1000);

                     //correct 
                    $totalinscorrect = count($inscorr)+ count($inscorr2)+ count($inscorr3);
                    $totaleasycorrect = count($easycorr)+ count($easycorr2)+ count($easycorr3);
                    $totalmediumcorrect = count($mediumcorr)+ count($mediumcorr2)+ count($mediumcorr3);
               
                   
                   

                    $totalinsincorrect = count($insincorrect)+ count($insincorrect2)+ count($insincorrect3);
                    $totaleasyincorrect = count($easyincorrect)+ count($easyincorrect2)+ count($easyincorrect3);
                    $totalmediumincorrect = count($mediumincorrect)+ count($mediumincorrect2)+ count($mediumincorrect3);

                    $totalinsquestion = $totalinscorrect+$totalinsskip+$totalinsincorrect;

                    $totaleasyquestion = $totaleasycorrect+$totaleasyskip+$totaleasyincorrect;

                    $totalmediumquestion = $totalmediumcorrect+$totalmediumskip+$totalmediumincorrect;

                    $totalinsattempt = $totalinscorrect+$totalinsincorrect;
                    $totaleasyattempt = $totaleasycorrect+$totaleasyincorrect;
                    $totalmediumattempt = $totalmediumcorrect+$totalmediumincorrect;

                        //ins
                         //pos
                         $inspos = array_intersect_key($positive ,$inscorr);
                         $inspos2 = array_intersect_key($positive ,$inscorr2);
                         $inspos3 = array_intersect_key($positive ,$inscorr3);
                         $instotalpos = array_sum($inspos)+array_sum($inspos2)+array_sum($inspos3);
                         //neg
                         $insneg = array_intersect_key($negative, $insincorrect);
                         $insneg2 = array_intersect_key($negative2, $insincorrect2);
                         $insneg3 = array_intersect_key($negative3, $insincorrect3);
                         $totalinsneg = array_sum($insneg)+array_sum($insneg2)+array_sum($insneg3);
                         

                          //total
                          $instotalmark =  $instotalpos-$totalinsneg;
                         //per
                          $instotalpos = array_sum($positive);
                          if($instotalpos == 0){
                            $instotalpos =1;
                          }else{
                            $instotalpos = $instotalpos;
                          }
                          $insper= ($instotalmark/$instotalpos)*100;
                          if ($insper < 0) {
                              $insper = 0;
                          }else{
                            $insper = $insper;
                          }
                        //easy
                         //pos
                        $easypos = array_intersect_key($positive2 ,$easycorr);
                        $easypos2 = array_intersect_key($positive2 ,$easycorr2);
                        $easypos3 = array_intersect_key($positive2 ,$easycorr3);
                        $easytotalpos = array_sum($easypos)+array_sum($easypos2)+array_sum($easypos3);
                        //neg
                        $easyneg = array_intersect_key($negative2, $easyincorrect);
                        $easyneg2 = array_intersect_key($negative2, $easyincorrect2);
                        $easyneg3 = array_intersect_key($negative3, $easyincorrect3);
                        $totaleasyneg = array_sum($easyneg)+array_sum($easyneg2)+array_sum($easyneg3);
                         //total
                         $easytotalmark =  $easytotalpos-$totaleasyneg;
                        //per
                         $easytotalpos = array_sum($positive2);
                         if($easytotalpos == 0){
                          $easytotalpos = 1;
                         }else{
                          $easytotalpos = $easytotalpos;
                         }
                         $easyper=($easytotalmark/$easytotalpos)*100;
                        if ($easyper < 0) {
                          $easyper = 0;
                        }else{
                          $easyper = $easyper;
                        }

                        //medium
                         //pos
                         $mediumpos = array_intersect_key($positive3 ,$mediumcorr);
                         $mediumpos2 = array_intersect_key($positive3 ,$mediumcorr2);
                         $mediumpos3 = array_intersect_key($positive3 ,$mediumcorr3);
                         $mediumtotalpos = array_sum($mediumpos)+array_sum($mediumpos2)+array_sum($mediumpos3);
                         //neg
                         $mediumneg = array_intersect_key($negative3, $mediumincorrect);
                         $mediumneg2 = array_intersect_key($negative3, $mediumincorrect2);
                         $mediumneg3 = array_intersect_key($negative3, $mediumincorrect3);


                         $totaleasyneg = array_sum($mediumneg)+array_sum($mediumneg2)+array_sum($mediumneg3);
                          //total
                          $mediumtotalmark =  $mediumtotalpos-$totaleasyneg;
                         //per
                          $mediumtotalpos = array_sum($positive3);
                          if($mediumtotalpos == 0){
                            $mediumtotalpos =1;
                          }else{
                            $mediumtotalpos = $mediumtotalpos;
                          }
                          $mediumper=($mediumtotalmark/$mediumtotalpos)*100;
                          if ($mediumper < 0) {
                            $mediumper = 1;
                          }else{
                            $mediumper = $mediumper;
                          }
                        //(count($easyskip)+ count($easyskip2)+ count($easyskip3));
                        $nonEmptyValues = array_filter($easyskip, function($value) {
                          return $value == '' && $value == null;
                      });
                    ///newperdata1
                    if($totalinsattempt == 0){
                      $totalinsattempt = 1;
                    }else{
                      $totalinsattempt= $totalinsattempt;
                    }
                    $per1 =  ($totalinscorrect/$totalinsattempt)*100;

                        if($per1<0){
                          $per1 = 0;
                        } else{
                          $per1 =$per1;
                        }

                         ///newperdata2
                    if($totaleasyattempt == 0){
                      $totaleasyattempt = 1;
                    }else{
                      $totaleasyattempt= $totaleasyattempt;
                    }
                    $per2 =  ($totaleasycorrect/$totaleasyattempt)*100;

                        if($per2<0){
                          $per2 = 0;
                        } else{
                          $per2 =$per2;
                        }
                        
                    ///newperdata3
                    if($totalmediumattempt == 0){
                      $totalmediumattempt = 1;
                    }else{
                      $totalmediumattempt= $totalmediumattempt;
                    }
                    $per3 =  ($totalmediumcorrect/$totalmediumattempt)*100;

                        if($per3<0){
                          $per3 = 0;
                        } else{
                          $per3 =$per3;
                        }
                        
                        
                    //TITA for Fill in blank
                    $userid =session()->get('id');
                    $qtype = array();
                    $ans_time = array();
                    $answer= array();
                    $qid = array();
                    $titas = DB::table('student_quizes')
                            ->where('test_id',$testid)
                            ->where('user_id',$userid)
                            ->where('paper_id', $paperid)
                            ->get();
                            
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
                    
                    $exceltitas = DB::table('excel_questions')
                                    ->where('test_id',$testid)
                                    ->whereIn('id', $qid)
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
                            
                             $correctresult = array();
                            foreach ($key1 as $key => $value) {
                                if (isset($excel_correct[$key])) {
                                    $correctresult[$key] = $excel_correct[$key];
                                }
                            }
                         $allcorrect =  array_intersect_assoc($correctresult,$ansresult);
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
                      if (stripos($value, 'numerical') === 0) {
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
                    
                    $exceltitas = DB::table('excel_questions')
                                    ->where('test_id',$testid)
                                    ->whereIn('id', $qid)
                                    ->get();
                            $excel_correct2 = array();
                            $excel_negative2 = array();
                            $excel_positive2 = array();
                            foreach($exceltitas as $exceltita)
                            {
                                $excel_correct2[] = $exceltita->correct_option;
                                $excel_negative2[] = $exceltita->negative_mark;
                                $excel_positive2[] = $exceltita->positive_mark;
                            }
                            
                             $correctresult2 = array();
                            foreach ($key2 as $key => $value) {
                                if (isset($excel_correct2[$key])) {
                                    $correctresult2[$key] = $excel_correct2[$key];
                                }
                            }
                         $allcorrect2 =  array_intersect_assoc($correctresult2,$ansresult2);
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
                                if (isset($excel_negative2[$key])) {
                                    $allneg2[$key] = $excel_negative2[$key];
                                }
                            }
                            
                            $allpos2 = array();
                            foreach ($allcorrect2 as $key => $value) {
                                if (isset($excel_positive2[$key])) {
                                    $allpos2[$key] = $excel_positive2[$key];
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
                   // }
                      ?>
                        <tr>
                          <td>EASY</td>
                          
                       
                          <td>{{$totaleasyquestion}}</td>

                          <td>{{$easytimetaken1}}</td>

                          <td>{{$totaleasyattempt}}<br/>{{$easyattempttime1}}</td>

                          <td>{{$totaleasycorrect}}<br/>{{$totaleasycorrecttime1 }}</td>

                          <td>{{$totaleasyincorrect}}<br/>{{$totaleasyincorrecttime1}}</td>
                          
                          <td>{{$totaleasyskip}}<br/>{{$totaleasyskiptime1}}</td>

                          <td>{{$easytotalmark}}</td>
                          <?php
                          $per2 =  number_format($per2, 2, '.', '');
                          ?>
                          <td>{{$per2}}</td>

                          {{-- <td>{{round($easyper,2)}}</td> --}}
                        
                        </tr>
                        <tr>
                          <td>INTERMEDIATE</td>
                        
                          <td>{{$totalmediumquestion }}</td>
                     
                          <td>{{$mediumtimetaken}}</td>

                       
                          <td>{{$totalmediumattempt}}<br/>{{$mediumattempttime1}}</td>

                         
                          <td>{{$totalmediumcorrect}}<br/>{{$totalmediumcorrecttime1}}</td>


                        
                          <td>{{$totalmediumincorrect}}<br/>{{$totalmediumincorrecttime1}}</td>

                        
                          <td>{{$totalmediumskip}}<br/>{{$totalmediumskiptime1}}</td>

                          
                          <td>{{$mediumtotalmark}}</td>
                          <?php
                            $per3 =  number_format($per2, 2, '.', '');
                          ?>
                          <td>{{$per3}}</td>
                          {{-- <td>{{round($mediumper,2)}}</td>   --}}
                        
                        </tr>
                        <tr>
                          <td>DIFFICULT</td>
                          <td>{{$totalinsquestion}}</td>
                          <td>{{$instimetaken1}}</td>
                          <td>{{$totalinsattempt}}<br/>{{$insattempttime1}}</td>
                          <td>{{$totalinscorrect}}<br/>{{$totalinscorrecttime1}}</td>
                          <td>{{$totalinsincorrect}}<br/>{{$totalinsincorrecttime1}}</td>
                          <td>{{$totalinsskip}}<br/>{{$totalinsskiptime1}}</td>
                          <td>{{$instotalmark}}</td>
                          <?php
                          $per1 =  number_format($per1, 2, '.', '');
                          ?>
                          {{-- <td>{{round($insper,2)}}</td> --}}
                          <td>{{$per1}}</td>
                          
                        </tr>
                          <tr>
                            <td>TITA</td> 
                            <td>{{$key3}}</td>
                            <td>{{$totaltimef25}}</td>
                            <td>{{$non_empty_ans3}}<br/>{{$attempttime33}}</td>
                            <td>{{$allcorrect3}}<br/>{{$correctttime33}}</td>
                            <td>{{$incorrect3}}<br/>{{$incorrecttime33}}</td>
                            <td>{{$skip2}}<br/>{{$skiptime33}}</td>
                            <td>{{$score3}}</td>
                            <td>{{round($accury3,2)}}</td>
                          </tr>
                   </tdody>
            </table>
  </div>
</div>
        </div>
    </div>
    <!--enddiff-->
    <div class="container col-md-12" style="margin-top: 10px; margin-bottom:10px;">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  @if(in_array('verbal', $exploded_array))
                  <li class="nav-item">
                    <a class="nav-link {{($first_element == 'verbal') ? 'active' : ''}}" data-bs-toggle="tab" href="#msg">Verbal Ability and Reading Comprehension</a>
                  </li>
                  @else
                   <li class="nav-item"></li>
                  @endif
                  @if(in_array('data', $exploded_array))
                  <li class="nav-item">
                    <a class="nav-link {{($first_element == 'data') ? 'active' : ''}}" data-bs-toggle="tab" href="#pro">Data Interpretation And Logic</a>
                  </li>
                   @else
                   <li class="nav-item"></li>
                  @endif
                  @if(in_array('quantitative', $exploded_array))
                  <li class="nav-item {{($first_element == 'quantitative') ? 'active' : ''}}">
                    <a class="nav-link" data-bs-toggle="tab" href="#set">Quantitative Aptitude</a>
                  </li>
                   @else
                   <li class="nav-item"></li>
                  @endif
                </ul>
                <div class="tab-content" >
                    @if(in_array('verbal', $exploded_array))
                      <div class="tab-pane {{($first_element == 'verbal') ? 'active' : 'fade'}}" id="msg">
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
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                <?php
                                if(isset($verbal_reports)){
                                $i = 1;
                                $paperid = request()->paperid;
                                $id = request()->id;
                                $qus_id = explode(',', $verbal_reports->ans_duration);
                                $ans = explode(',', $verbal_reports->answer);
                                $anss = explode(',', $verbal_reports->answer);
                                $qqn_id = explode(',', $verbal_reports->question_id);
                                $userid = session()->get('id');
                                $result = [];
                                $inscorr = [];
                                $easycorr = [];
                                $mediumcorr = [];
                                $insskip = [];
                                $correcttime = [];
                                $insskiptime = [];
                                foreach ($qqn_id as $key => $value) {
                                    $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
                                }
                               
                                $times = [];
                                foreach ($qus_id as $time) {
                                    $times[] = (int) $time;
                                }
                                // Sort the times and get the five highest
                                rsort($times);
                                $highest_times = array_slice($times, 0, 3);
                                }
                                ?>
                                @if(isset($verbal_ques))
                                @foreach($verbal_ques as $key => $que)
                                <?php
                                $qrts = strip_tags($que->question);
                                $smallq = substr($qrts, 0, 150);
                                $correct = $que->correct_option;
                                $qr = strlen($qrts);
                                $smal = strlen($smallq);
                                ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    @if($smallq)
                                    <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                        <span class="first{{$i}}"><?=$smallq;?></span>
                                        <span class="second{{$i}}" style="display:none;"><?=$qrts;?></span>
                                        @if($qr > 150 && $smal > 150)
                                        <button class="tsl more{{$i}}" data-set="{{$i}}">Read More</button>
                                        <button class="tsd less{{$i}}" data-set="{{$i}}" style="display:none">Read Less</button>
                                        @endif
                                    </td>
                                    @else
                                    <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                        <?= htmlspecialchars_decode($que->question) ?>
                                    </td>
                                    @endif
                                    @if($que->question_type == 'multiple' ||  $que->question_type == 'MULTI_CHOICE')
                                    <td>MULTI CHOICE</td>
                                    @elseif($que->question_type == 'fill_in_the_blanks' || $que->question_type == 'Fill_in_the_blanks' || $que->question_type == 'numerical'||  $que->question_type == 'NUMERICAL' || $que->question_type == 'NUMERIC')
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
                                    @foreach($anss as $key1=> $qus_ids)
                                      @if($key == $key1)
                                          @if($qus_ids)
                                            @if($qus_ids == '1')
                                            <td style="text-align:center;">A</td>
                                            @elseif($qus_ids == '2')
                                            <td style="text-align:center;">B</td>
                                            @elseif($qus_ids == '3')
                                            <td style="text-align:center;">C</td>
                                            @elseif($qus_ids == '4')
                                            <td style="text-align:center;">D</td>
                                            @else
                                            <td style="text-align:center;">{{$qus_ids}}</td>
                                            @endif
                                            @else
                                            <td></td>
                                          @endif
                                      @endif
                                    @endforeach
                                    @if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                                                <td>{{$que->positive_mark}}</td>
                                            @elseif(empty($ans[$key])) 
                                                <td>0</td>
                                            @else
                                               @if($que->negative_mark == '1.0')
                                                <td>-1</td>
                                                @else
                                                 <td>{{$que->negative_mark}}</td>
                                                @endif
                                            @endif
                                    @if($que->level == 'INTENSE')
                                    <td>DIFFICULT</td>
                                    @elseif($que->level == 'EASY')
                                    <td>EASY</td>
                                    @elseif($que->level == 'MEDIUM')
                                    <td>INTERMEDIATE</td>
                                    @endif
                                    @foreach($qus_id as $key1 => $qus_ids)
                                    <?php
                                    $qtime = date("H:i:s", $qus_ids / 1000);
                                    $time_in_seconds = (int) $qus_ids;
                                    ?>
                                    @if($key == $key1)
                                        @if($qtime != '00:00:00')
                                             <td style="color: {{ in_array($time_in_seconds, $highest_times) ? 'red' : 'inherit' }};">
                                                {{$qtime}}
                                            </td>
                                            @else
                                             <td >
                                                {{$qtime}}
                                            </td>
                                        @endif
                                    @endif
                                    @endforeach
                                    
                                    @if((!empty($ans[$key])) &&  ($que->level == 'INTENSE'))
                                     <td>DIFFICULT ATTEMPED?</td>
                                    @elseif((empty($ans[$key])) &&  ($que->level == 'EASY'))
                                        <td>Easy Left?</td>
                                        @else
                                        <td></td>
                                    @endif
                                    
                                    @if(isset($ans[$key]) && $ans[$key] === $que->correct_option)
                                    <?php
                                    if ($que->level == 'INTENSE') {
                                        $inscorr[] = $ans[$key];
                                    }
                                    if ($que->level == 'EASY') {
                                        $easycorr[] = $ans[$key];
                                    }
                                    if ($que->level == 'MEDIUM') {
                                        $mediumcorr[] = $ans[$key];
                                    }
                                    ?>
                                    <td>Correct</td>
                                    @elseif(empty($ans[$key]))
                                    <?php
                                    if ($que->level == 'EASY') {
                                        if (isset($ans[$key])) {
                                            $insskip[] = $ans[$key];
                                        } else {
                                            $insskip[] = 0;
                                        }
                                    }
                                    foreach ($qus_id as $key1 => $qus_ids) {
                                        if ($key == $key1) {
                                            if ($que->level == 'EASY') {
                                                $insskiptime[] = $qus_ids;
                                            }
                                        }
                                    }
                                    ?>
                                    <td>Skip</td>
                                    @else
                                    <td>Wrong</td>
                                    @endif 
                                   
                                </tr>
                                <?php
                                $i++;
                                ?>
                                @endforeach
                                @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @endif
                                </tbody>
                              </table>
                              
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(in_array('data', $exploded_array))
                      <div class="tab-pane {{($first_element == 'data') ? 'active' : 'fade'}} " id="pro">
                        <div class="col-md-12 px-2">
                        <div class="card bg-white display-box-data">
                            <table class="table table-bordered table-striped w-100 ">
                                <thead class="table-danger">
                                    <tr>
                                        <th class="sr_th">Sr.No</th>
                                        <th style="width:700px; text-align:center;">Question </th>
                                            <!-- <th>Your Answer</th> -->
                                            <th>Type</th>
                                            <th>Correct Answer</th>
                                            <th>Your Answer</th>
                                            <th>Marks</th>
                                            <th>Difficulty Level</th>
                                            <th>Time Taken</th>
                                            <th>Level Analysis</th>
                                            <th>Status</th>
                                                
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data_reports)){
                                          $qus_id = explode(',', $data_reports->ans_duration);
                                          $ans = explode(',', $data_reports->answer);
                                          $anss  = explode(',', $data_reports->answer);
                                           foreach ($qus_id as $key => $value) {
                                                $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
                                            }
                               
                                            $times = [];
                                            foreach ($qus_id as $time) {
                                                $times[] = (int) $time;
                                            }
                                            rsort($times);
                                            $highest_times = array_slice($times, 0, 3);
                                
                                          $i=1;
                                          $inscorr2 = [];
                                          $easycorr2 = [];
                                          $mediumcorr2 = [];
                                          $insskip2 = [];
                                        }
                                        ?>
                                        @if(isset($data_ques))
                                        @foreach($data_ques as $key => $que)
                                       <?php
                                      $qrts = strip_tags($que->question);
                                      $smallq = substr($qrts, 0, 150);
                                    $qr = strlen($qrts);
                                    $smal = strlen($smallq);
                                        
                                      ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            @if($smallq)
                                            <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                               <span class="first{{$i}}"><?=$smallq;?></span>
                                                <span class="second{{$i}}" style="display:none;"><?=$qrts;?></span>
                                                @if($qr>=150 && $smal>=150)
                                                 <button class="tsl more{{$i}}" data-set="{{$i}}">Read More</button>  
                                                 <button class="tsd less{{$i}}" data-set="{{$i}}" style="display:none">Read Less</button>             
                                                @endif
                                                </td>
                                            @else
                                            <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                            <?= htmlspecialchars_decode($que->question) ?>
                                            </td>
                                            @endif
                                            @if($que->question_type == 'multiple' ||  $que->question_type == 'MULTI_CHOICE')
                                                <td>MULTI CHOICE</td>
                                                 @elseif($que->question_type == 'fill_in_the_blanks' || $que->question_type == 'Fill_in_the_blanks' || $que->question_type == 'numerical'||  $que->question_type == 'NUMERICAL' || $que->question_type == 'NUMERIC')
                                                 <td>TITA</td>
                                                @else
                                                 <td>{{$que->question_type}}</td>
                                                @endif
                                            <!-- <td>C</td> -->
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

                                            @foreach($anss as $key1=> $qus_ids)
                                             @if($key == $key1)
                                               @if($qus_ids)
                                                 @if($qus_ids == '1')
                                                 <td style="text-align:center;">A</td>
                                                 @elseif($qus_ids == '2')
                                                 <td style="text-align:center;">B</td>
                                                 @elseif($qus_ids == '3')
                                                 <td style="text-align:center;">C</td>
                                                 @elseif($qus_ids == '4')
                                                 <td style="text-align:center;">D</td>
                                                 @else
                                                 <td style="text-align:center;">{{$qus_ids}}</td>
                                                 @endif
                                                 @else
                                                 <td></td>
                                               @endif
                                             @endif
                                           @endforeach

                                             @if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                                             <td>{{$que->positive_mark}}</td>
                                           @elseif(empty($ans[$key])) 
                                             <td>0</td>
                                           @else
                                            @if($que->negative_mark == '1.0')
                                             <td>-1</td>
                                             @else
                                              <td>{{$que->negative_mark}}</td>
                                             @endif
                                           @endif
                                             @if($que->level == 'INTENSE')
                                             <td>DIFFICULT</td>
                                             @elseif($que->level == 'EASY')
                                             <td>EASY</td>
                                             @elseif($que->level == 'MEDIUM')
                                             <td>INTERMEDIATE</td>
                                             @endif
                                             @foreach($qus_id as $key1=> $qus_ids)
                                            <?php
                                              $qtime = date("H:i:s", $qus_ids / 1000);
                                               
                                                 $time_in_seconds = (int) $qus_ids;
                                            ?>  
                                             @if($key == $key1)
                                                @if($qtime != '00:00:00')
                                             <td style="color: {{ in_array($time_in_seconds, $highest_times) ? 'red' : 'inherit' }};">
                                                {{$qtime}}
                                            </td>
                                            @else
                                             <td >
                                                {{$qtime}}
                                            </td>
                                            @endif
                                            @endif
                                            @endforeach
                                             
                                            @if((!empty($ans[$key])) &&  ($que->level == 'INTENSE'))
                                            <td>DIFFICULT ATTEMPED?</td>
                                           @elseif((empty($ans[$key])) &&  ($que->level == 'EASY'))
                                               <td>Easy Left?</td>
                                                @else
                                               <td></td>
                                           @endif

                                            @if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                                            <?php
                                            if($que->level == 'INTENSE'){
                                             $inscorr2[] = $ans[$key];
                                            }
                                            if($que->level == 'EASY'){
                                              $easycorr2[] = $ans[$key];
                                            }
                                             if($que->level == 'MEDIUM'){
                                              $mediumcorr2[] = $ans[$key];
                                            }
                                            ?> 
                                            <!-- <td><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i></td> -->
                                             <td>Correct</td>
                                            @elseif(empty($ans[$key])) 
                                            <?php
                                              if($que->level == 'INTENSE'){
                                                if (isset($ans[$key])) {
                                                  $insskip2[] = $ans[$key];
                                                } else {
                                                  $insskip2[] = 0;
                                                    // Handle the case where the key doesn't exist in $ans
                                                }
                                              }
                                            ?>
                                            <!-- <td><i class="fa fa-times-circle-o" aria-hidden="true" style=""></i></td> -->
                                             <td>Skip</td>
                                            @else
                                            <!-- <td><i class="fa fa-times-circle-o" aria-hidden="true" style="color:red"></i></td> -->
                                             <td>Wrong</td>
                                            @endif
                                           
                                         
                                             
                                        </tr>
                                        <?php
                                        $i++;
                                        ?>
                                        @endforeach
                                         @else
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        @endif
                                    </tbody>
                            </table>
                        </div>
                    </div>
                      </div>
                     @endif
                     @if(in_array('quantitative', $exploded_array))
                      <div class="tab-pane  {{($first_element == 'quantitative') ? 'active' : 'fade'}}" id="set">
                          <div class="col-md-12 ">
                        <div class="card bg-white display-box-data">
                            <table class="table table-bordered table-striped w-100">
                                <thead class="table-danger">
                                    <tr>
                                            <th class="sr_th">Sr.No</th>
                                            <th style="width:700px; text-align:center;">Question </th>
                                            <!-- <th>Your Answer</th> -->
                                            <th>Type</th>
                                            <th>Correct Answer</th>
                                            <th>Your Answer</th> 
                                            <th>Marks</th>
                                            <th>Difficulty Level</th>
                                            <th>Time Taken</th>
                                            <th>Level Analysis</th>
                                            <th>Status</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        if(isset($qt_reports)){
                                        $qus_id = explode(',', $qt_reports->ans_duration);
                                        $ans = explode(',', $qt_reports->answer);
                                        $anss = explode(',', $qt_reports->answer);
                                         foreach ($qus_id as $key => $value) {
                                                $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
                                            }
                               
                                            $times = [];
                                            // if($qus_id != 0){
                                                
                                            // }
                                            foreach ($qus_id as $time) {
                                                $times[] = (int) $time;
                                            }
                                            rsort($times);
                                            $highest_times = array_slice($times, 0, 3);
                                            
                                        $i=1;
                                        $inscorr3 = [];
                                        $easycorr3 = [];
                                        $mediumcorr3 = [];
                                        $insskip3 = [];
                                        $correcttime3 = [];
                                        }
                                        ?>
                                        @if(isset($qt_ques))
                                        @foreach($qt_ques as $key=> $que)
                                      <?php
                                      $qrts = strip_tags($que->question);
                                      $smallq = substr($qrts, 0, 150);
                                      // dd($smallq);
                                      $qr = strlen($qrts);
                                      $smal = strlen($smallq);
                                        
                                      ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            @if($smallq)
                                            <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                               <span class="first{{$i}}"><?=$smallq;?></span>
                                                <span class="second{{$i}}" style="display:none;"><?=$qrts;?></span>
                                                @if($qr>=150 && $smal>=150)
                                                <button class="tsl more{{$i}} " data-set="{{$i}}">Read More</button>  
                                                 <button class="tsd less{{$i}} " data-set="{{$i}}" style="display:none">Read Less</button>             
                                                @endif
                                                </td>
                                            @else
                                            <td style="text-align:justify; padding: 15px 27px 17px 23px;">
                                            <?= htmlspecialchars_decode($que->question) ?>
                                            </td>
                                            @endif
                                            @if($que->question_type == 'multiple' ||  $que->question_type == 'MULTI_CHOICE')
                                                <td>MULTI CHOICE</td>
                                                @elseif($que->question_type == 'fill_in_the_blanks' || $que->question_type == 'Fill_in_the_blanks' || $que->question_type == 'numerical'||  $que->question_type == 'NUMERICAL' || $que->question_type == 'NUMERIC')
                                                 <td>TITA</td>
                                                @else
                                                 <td>{{$que->question_type}}</td>
                                                @endif
                                            <!-- <td>C</td> -->
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

                                             @foreach($anss as $key1=> $qus_ids)
                                             @if($key == $key1)
                                               @if($qus_ids)
                                                 @if($qus_ids == '1')
                                                 <td style="text-align:center;">A</td>
                                                 @elseif($qus_ids == '2')
                                                 <td style="text-align:center;">B</td>
                                                 @elseif($qus_ids == '3')
                                                 <td style="text-align:center;">C</td>
                                                 @elseif($qus_ids == '4')
                                                 <td style="text-align:center;">D</td>
                                                 @else
                                                 <td style="text-align:center;">{{$qus_ids}}</td>
                                                 @endif
                                                 @else
                                                 <td></td>
                                               @endif
                                             @endif
                                         @endforeach

                                             @if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                                             <td>{{$que->positive_mark}}</td>
                                         @elseif(empty($ans[$key])) 
                                             <td>0</td>
                                         @else
                                            @if($que->negative_mark == '1.0')
                                             <td>-1</td>
                                             @else
                                              <td>{{$que->negative_mark}}</td>
                                             @endif
                                         @endif

                                             @if($que->level == 'INTENSE')
                                             <td>DIFFICULT</td>
                                             @elseif($que->level == 'EASY')
                                             <td>EASY</td>
                                             @elseif($que->level == 'MEDIUM')
                                             <td>INTERMEDIATE</td>
                                             @endif
                                            @foreach($qus_id as $key1=> $qus_ids)
                                            <?php
                                            $qtime = date("H:i:s", $qus_ids / 1000);
                                            $time_in_seconds = (int) $qus_ids;

                                            ?>  
                                             @if($key == $key1)
                                             @if($qtime != '00:00:00')
                                             <td style="color: {{ in_array($time_in_seconds, $highest_times) ? 'red' : 'inherit' }};">
                                                {{$qtime}}
                                            </td>
                                            @else
                                             <td >
                                                {{$qtime}}
                                            </td>
                                            @endif
                                            @endif
                                            @endforeach

                                            @if((!empty($ans[$key])) &&  ($que->level == 'INTENSE'))
                                            <td>DIFFICULT ATTEMPED?</td>
                                           @elseif((empty($ans[$key])) &&  ($que->level == 'EASY'))
                                               <td>Easy Left?</td>
                                               @else
                                               <td></td>
                                           @endif
                                              
                                            @if(isset($ans[$key]) && $ans[$key] === $que->correct_option) 
                                            <!-- <td><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i></td> -->
                                             <td>Correct</td>
                                            @elseif(empty($ans[$key])) 
                                            <!-- <td><i class="fa fa-times-circle-o" aria-hidden="true" style=""></i></td> -->
                                             <td>Skip</td>
                                            @else
                                            <!-- <td><i class="fa fa-times-circle-o" aria-hidden="true" style="color:red"></i></td> -->
                                             <td>Wrong</td>
                                            @endif
                                             
                                         
                                           
                                            
                                           
                                        </tr>
                                        <?php
                                        $i++;
                                        ?>
                                        @endforeach
                                         @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                        @endif
                                    </tbody>
                            </table>
                        </div>
                    </div>
                      </div>
                      @endif
                      <?php
                      // echo'<pre>';
                      // print_r($insskiptime);
                      // $insskiptime = array_sum($insskiptime);
                      // print_r(date("H:i:s", $insskiptime / 1000));
                                    //    print_r(count($inscorr)+ count($inscorr2)+ count($inscorr3));
                                       // print_r(count($easycorr)+ count($easycorr2)+ count($easycorr3));
                                        //print_r(count($mediumcorr)+ count($mediumcorr2)+ count($mediumcorr3));
                                        // print_r(count($insskip));
                                        // print_r(count($insskip2));
                                        // print_r(count($insskip3));
                                        //print_r(count($insskip)+ count($insskip2)+ count($insskip3));
                                        ?>
                </div>
                <!-- end Tab panes -->
            </div>
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
</script>
@endsection
@section('script')
@endsection
