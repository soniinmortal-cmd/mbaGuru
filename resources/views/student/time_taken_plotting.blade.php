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

 body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    #chartContainer {
      width: 100%;
      max-width: 1000px;
      margin: auto;
      margin-top: 72px;
      
    }
    h2 {
      text-align: center;
    }
 /*#timeChart {*/
 /*   max-height: 1000px; */
 /*   width: 100%;*/
 /* }*/
/* #timeChart {*/
/*    width: 100%;*/
/*    height: 200px !important;*/
/*    max-height: none;*/
/*}*/
#timeChart {
  max-height: 450px;
  width: 100%;
}
#sectionSelect {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #fff;
  border: 2px solid #078571; 
  border-radius: 8px;
  padding: 10px 40px 10px 16px;
  font-size: 16px;
  color: #078571;
  font-weight: 500;
  cursor: pointer;
  min-width: 111px;
  position: relative;
}

#sectionSelect:focus {
  border-color: #078571;
  outline: none;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php
        $userid =session()->get('id');
        $sid = 'report';
        $paperid = request()->paperid;
        $testid = request()->testid;
        $test = DB::table('tests')
                ->where('id',$testid)
                ->limit(1)
                ->first();  
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
        
         $duration = DB::table('quiz_durations')
                        ->where('test_id', $testid)
                        ->orderBy('id','desc')
                        ->limit(1)
                        ->first();

        $subQuery = DB::table('student_quizes')
                    ->select('section_type', DB::raw('MAX(id) as max_id'))
                    ->where('test_id', $testid)
                    ->where('user_id', $userid)
                    ->where('paper_id', $paperid)
                    ->groupBy('section_type');

            $reports =  DB::table('student_quizes')
                            ->joinSub($subQuery, 'latest', function ($join) {
                            $join->on('student_quizes.id', '=', 'latest.max_id');
                        })
                        ->where('student_quizes.test_id', $testid)
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
                      
                                $ansdata_lower = array_map('strtolower', array_change_key_case($ansdata, CASE_LOWER));
                                $answer_lower = array_map('strtolower', array_change_key_case($answer, CASE_LOWER));
                                $resultt = array_diff_assoc($ansdata_lower, $answer_lower);

                                $ansdata_lower = array_map('strtolower', array_change_key_case($ansdata, CASE_LOWER));
                                $resultt_lower = array_map('strtolower', array_change_key_case($resultt, CASE_LOWER));
                                $correct = array_diff_assoc($ansdata_lower, $resultt_lower);

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
    ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class = "conatiner-fluid">
  <div class="d-flex px-4 my-3 justify-content-between align-items-center">
        <h5 class = "">{{$test->test}}</h5>
        {{-- <a href="{{route('student.dashboard')}}" class="btn"style="background-color:#A83942;color:white;">Dashboard</a> --}}
        <a href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" class="btn"style="background-color:#A83942;color:white;">Report</a>
        </div>
      <!-- box image styling starts  -->
        <div class="row  Propzone" id="card-img-style-box">
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">Score</div>
                    <div class="card-body py-1">
                        <h5 class="card-title" style="position:relative; color: #6C5DD3;">{{array_sum($to1)}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">Correct Answers</div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position: relative;color: #2ED480;"> {{array_sum($c1)}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">
                       Incorrect Answers
                    </div>
                    <div class="card-body py-1 ">
                        <h5 class="card-title" style="position:relative; color: #FD8539;"> {{array_sum($inc12)}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color:white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">
                        Accuracy %
                    </div>
                    <div class="card-body py-1">
                        <h5 class="card-title" style="position:relative; color: #B758E3;">{{$pto}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <?php
                $sectionCounts = DB::table('excel_questions')
                                ->select('section_name', DB::raw('COUNT(*) as count'))
                                ->where('test_id', $testid)
                                ->where(function($query) {
                                    $query->where('section_name', 'like', '%quantitative%')
                                        ->orWhere('section_name', 'like', '%verbal%')
                                        ->orWhere('section_name', 'like', '%data%');
                                })
                                ->groupBy('section_name')
                                ->pluck('count', 'section_name');
                    $sectionCounts = collect($sectionCounts)->mapWithKeys(function($count, $name) {
                        return [strtolower($name) => $count];
                    });
                    $quantitativeCount = 0;
                    $verbalCount = 0;
                    $dataCount = 0;
                    foreach ($sectionCounts as $sectionName => $count) {
                          $lowerName = strtolower($sectionName);
                          if (Str::contains($lowerName, 'quantitative')) {
                              $quantitativeCount += $count;
                          }
                          if (Str::contains($lowerName, 'verbal')) {
                              $verbalCount += $count;
                          }
                          if (Str::contains($lowerName, 'data')) {
                              $dataCount += $count;
                          }
                    }
                    $excel_questions = DB::table('excel_questions')
                                        ->where('test_id',$testid)
                                        ->get();

                    $correct_answer = array();
                    $correct_dataAnswer = array();
                    $correct_quantAnswer = array();

                    foreach($excel_questions as $excel_question)
                    {
                      if (stripos($excel_question->section_name, 'verbal') !== false) {
                         $correct_answer[] = $excel_question->correct_option;
                      }
                     if (stripos($excel_question->section_name, 'data') !== false) {
                         $correct_dataAnswer[] = $excel_question->correct_option;
                      }
                       if (stripos($excel_question->section_name, 'quantitative') !== false) {
                         $correct_quantAnswer[] = $excel_question->correct_option;
                      }
                    }
                        $all_sections = DB::table('student_quizes')
                                          ->where('test_id', $testid)
                                          ->where('user_id', $userid)
                                          ->where('paper_id', $paperid)
                                          ->where(function($query) {
                                              $query->where('section_type', 'like', '%data%')
                                                    ->orWhere('section_type', 'like', '%verbal%')
                                                    ->orWhere('section_type', 'like', '%quantitative%');
                                          })
                                          ->get();
                                          
                      $verbal_section = $all_sections->first(function ($item) {
                          return stripos($item->section_type, 'verbal') !== false;
                      });

                      $data_section = $all_sections->first(function ($item) {
                          return stripos($item->section_type, 'data') !== false;
                      });
                      
                      $quant_section = $all_sections->first(function ($item) {
                          return stripos($item->section_type, 'quantitative') !== false;
                      });

                    // if ($verbal_section) {
                    //     $questionIds = explode(',', $verbal_section->question_id);
                    //     $useranswer = explode(',', $verbal_section->answer);
                    //     $verbalAnswer = array_pad($useranswer, count($questionIds), '');
                    //     $ans_duration = explode(',', $verbal_section->ans_duration);
                    //     $verbalDuration = array_pad($ans_duration, count($questionIds), '');
                    // }
                    $verbalAnswer = [];
                    $verbalDuration = [];
                    $questionIds = [];
                    if ($verbal_section) {
                        $questionIds = explode(',', $verbal_section->question_id);
                    
                        $useranswer = explode(',', $verbal_section->answer ?? '');
                        $verbalAnswer = array_pad($useranswer, count($questionIds), '');
                    
                        $ans_duration = explode(',', $verbal_section->ans_duration ?? '');
                        $verbalDuration = array_pad($ans_duration, count($questionIds), '');
                    }
                    $dataquestionIds =[];
                    $dataAnswer= [];
                    $dataDuration= [];
                    if($data_section){
                        $dataquestionIds = explode(',', $data_section->question_id);
                        $datauseranswer = explode(',', $data_section->answer);
                        $dataAnswer = array_pad($datauseranswer, count($dataquestionIds), '');
                        $dataans_duration = explode(',', $data_section->ans_duration);
                        $dataDuration = array_pad($dataans_duration, count($dataquestionIds), '');
                    }
                    $quantAnswer = [];
                    $quantquestionIds = [];
                    $quantDuration = [];
                     if($quant_section){
                        $quantquestionIds = explode(',', $quant_section->question_id);
                        $quantuseranswer = explode(',', $quant_section->answer);
                        $quantAnswer = array_pad($quantuseranswer, count($quantquestionIds), '');
                        $quantans_duration = explode(',', $quant_section->ans_duration);
                        $quantDuration = array_pad($quantans_duration, count($quantquestionIds), '');
                    }

                ////////////////////////////////////////////verbal Correct///////////////////////////////
                //   $verbalUserCorrect = [];
                //   foreach ($verbalAnswer as $index => $answer) {
                //       if (
                //           isset($correct_answer[$index]) &&
                //           strcasecmp(trim($correct_answer[$index]), trim($answer)) === 0
                //       ) {
                //           $verbalUserCorrect[$index] = $answer; 
                //       } 
                //   }
                
                $verbalUserCorrect = [];
                foreach ($verbalAnswer as $index => $answer) {
                    if (
                        isset($correct_answer[$index]) &&
                        strcasecmp(trim($correct_answer[$index]), trim($answer)) === 0
                    ) {
                        $verbalUserCorrect[$index] = $answer;
                    }
                }

                    $verbalUserDurations = [];
                    foreach ($questionIds as $index => $value) {
                      if (isset($verbalUserCorrect[$index]) && isset($verbalDuration[$index])) {
                          $verbalUserDurations[$index] = $verbalDuration[$index]; 
                      } else {
                          $verbalUserDurations[$index] = "0"; 
                      }
                    }
            ////////////////////////////////////////////verbal InCorrect///////////////////////////////
                 $verbalUserInCorrect = [];
                  foreach ($verbalAnswer as $index => $answer) {
                      if (
                          isset($correct_answer[$index]) &&
                          strcasecmp(trim($correct_answer[$index]), trim($answer)) !== 0
                      ) {
                          $verbalUserInCorrect[$index] = $answer; 
                      } 
                  } 

                  $verbalUserInDurations = [];
                  foreach ($questionIds as $index => $value) {
                      if (
                          isset($verbalUserInCorrect[$index]) &&
                          $verbalUserInCorrect[$index] !== '' &&
                          isset($verbalDuration[$index])
                      ) {
                          $verbalUserInDurations[$index] = $verbalDuration[$index]; 
                      }else{
                        $verbalUserInDurations[$index] = "0"; 
                      }
                  }
                 // dd($verbalUserInDurations);
              //////////////////////////////////////////Verbal Skip///////////////////////////////////
                $verbalSkip = [];
                foreach ($verbalAnswer as $index => $answer) 
                {
                    $verbalSkip[$index] = ($answer === "") ? $verbalDuration[$index] : '0';
                }
              ////////////////////////////////////////////data Correct///////////////////////////////
                  $dataUserCorrect = [];
                  foreach ($dataAnswer as $index => $answer) {
                      if (
                          isset($correct_dataAnswer[$index]) &&
                          strcasecmp(trim($correct_dataAnswer[$index]), trim($answer)) === 0
                      ) {
                          $dataUserCorrect[$index] = $answer; 
                      } 
                  }

                  $dataUserDurations = [];
                  foreach ($dataquestionIds as $index => $value) {
                      if (isset($dataUserCorrect[$index]) && isset($dataDuration[$index])) {
                          $dataUserDurations[$index] = $dataDuration[$index]; 
                      } else {
                          $dataUserDurations[$index] = "0"; 
                      }
                  }  

        ////////////////////////////////////////////data InCorrect///////////////////////////////
                 $dataUserInCorrect = [];
                  foreach ($dataAnswer as $index => $answer) {
                      if (
                          isset($correct_dataAnswer[$index]) &&
                          strcasecmp(trim($correct_dataAnswer[$index]), trim($answer)) !== 0
                      ) {
                          $dataUserInCorrect[$index] = $answer; 
                      } 
                  } 

                    $dataUserInDurations = [];
                    foreach ($dataquestionIds as $index => $value) {
                          if (
                              isset($dataUserInCorrect[$index]) &&
                              $dataUserInCorrect[$index] !== '' &&
                              isset($dataDuration[$index])
                          ) {
                              $dataUserInDurations[$index] = $dataDuration[$index]; 
                          }else{
                            $dataUserInDurations[$index] = "0"; 
                          }
                    }
        //////////////////////////////////////////data Skip///////////////////////////////////
                $dataSkip = [];
                foreach ($dataAnswer as $index => $answer) 
                {
                    $dataSkip[$index] = ($answer === "") ? $dataDuration[$index] : '0';
                }
        ////////////////////////////////////////////quant Correct///////////////////////////////
                    $quantUserCorrect = [];
                    foreach ($quantAnswer as $index => $answer) {
                      if (
                          isset($correct_quantAnswer[$index]) &&
                          strcasecmp(trim($correct_quantAnswer[$index]), trim($answer)) === 0
                      ) {
                          $quantUserCorrect[$index] = $answer; 
                      } 
                    }
                    $quantUserDurations = [];
                    foreach ($quantquestionIds as $index => $value) {
                      if (isset($quantUserCorrect[$index]) && isset($quantDuration[$index])) {
                          $quantUserDurations[$index] = $quantDuration[$index]; 
                      } else {
                          $quantUserDurations[$index] = "0"; 
                      }
                    } 
        ////////////////////////////////////////////quant InCorrect///////////////////////////////
                $quantUserInCorrect = [];
                foreach ($quantAnswer as $index => $answer) {
                    if (
                        isset($correct_quantAnswer[$index]) &&
                        strcasecmp(trim($correct_quantAnswer[$index]), trim($answer)) !== 0
                    ) {
                        $quantUserInCorrect[$index] = $answer; 
                    } 
                } 
                  $quantUserInDurations = [];
                  foreach ($quantquestionIds as $index => $value) {
                      if (
                          isset($quantUserInCorrect[$index]) &&
                          $quantUserInCorrect[$index] !== '' &&
                          isset($quantDuration[$index])
                      ) {
                          $quantUserInDurations[$index] = $quantDuration[$index]; 
                      }else{
                        $quantUserInDurations[$index] = "0"; 
                      }
                  }
            //////////////////////////////////////////quant Skip///////////////////////////////////
                $quantSkip = [];
                foreach ($quantAnswer as $index => $answer) 
                {
                    $quantSkip[$index] = ($answer === "") ? $quantDuration[$index] : '0';
                }
               
            ?>
            <div class="row my-6">
                <div class="col-md-12 custom-border">
                    <div id="chartContainer">
                        <select id="sectionSelect">
                          <option value = "verbal" data-qus="{{$verbalCount}}" data-correct = "{{ implode(',', $verbalUserDurations) }}" data-incorrect="{{ implode(',', $verbalUserInDurations) }}"
                            data-skipped = "{{ implode(',', $verbalSkip) }}" data-vduration= "{{$duration->verbal_time}}">VRC</option>
                            
                          <option value = "data" data-qus = "{{$dataCount}}"  data-correct="{{ implode(',', $dataUserDurations) }}"   data-incorrect="{{ implode(',', $dataUserInDurations) }}"
                             data-skipped = "{{ implode(',', $dataSkip) }}" data-dduration= "{{$duration->interp_time}}"> DILR </option>
                          <option value = "quantitative" data-qus = "{{$quantitativeCount}}" data-correct="{{ implode(',', $quantUserDurations) }}" data-incorrect = "{{ implode(',', $quantUserInDurations) }}"
                             data-skipped = "{{ implode(',', $quantSkip) }}" data-qduration= "{{$duration->quantitative_time}}">QA</option>
                        </select>
                        <!--<canvas id="timeChart" height="600"></canvas>-->
                        <!--<canvas id="timeChart" height="1000"></canvas>-->
                        <canvas id="timeChart" height="450"></canvas>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')


<script>

  const fullLabels = [
    "Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7", "Q8",
    "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16",
    "Q17", "Q18", "Q19", "Q20", "Q21", "Q22", "Q23", "Q24"
  ];

  const fullDatasets = {
    quantitative: { correct: [], incorrect: [], skipped: [] },
    verbal:       { correct: [], incorrect: [], skipped: [] },
    data:         { correct: [], incorrect: [], skipped: [] }
  };
  
  const ctx = document.getElementById('timeChart').getContext('2d');
  let timeChart;
  function updateChart(section) {
      const selectedOption = document.querySelector(`#sectionSelect option[value="${section}"]`);
      const qusCount = parseInt(selectedOption.dataset.qus);

      const newLabels = Array.from({ length: qusCount }, (_, i) => `Q${i + 1}`);
      const dataset = fullDatasets[section];

      const correct = selectedOption.dataset.correct.split(',').map(v => parseInt(v) / 60000); 
      const incorrect = selectedOption.dataset.incorrect.split(',').map(v => parseInt(v) / 60000);
      const skipped = selectedOption.dataset.skipped.split(',').map(v => parseInt(v) / 60000);

      dataset.correct = correct;
      dataset.incorrect = incorrect;
      dataset.skipped = skipped;

    //   const allTimes = [...correct, ...incorrect, ...skipped];
    //   let maxTime = Math.ceil(Math.max(...allTimes));

// const allTimes = [...correct, ...incorrect, ...skipped].filter(v => !isNaN(v));

// let maxTime = Math.ceil(Math.max(...allTimes, 0));

// // 
// if (maxTime <= 5) {
//     maxTime = 5;
// } else if (maxTime <= 10) {
//     maxTime = 10;
// } else {
//     maxTime = Math.ceil(maxTime / 5) * 5;
// }
    //   let sectionMax = 1;
    //   switch (section) {
    //       case 'verbal':
    //           sectionMax = parseFloat(selectedOption.dataset.vduration) || maxTime;
    //           break;
    //       case 'data':
    //           sectionMax = parseFloat(selectedOption.dataset.dduration) || maxTime;
    //           break;
    //       case 'quantitative':
    //           sectionMax = parseFloat(selectedOption.dataset.qduration) || maxTime;
    //           break;
    //   }

    //   if (sectionMax < 1) sectionMax = 1;
    //   maxTime = Math.max(maxTime, Math.ceil(sectionMax));
//   const allTimes = [...correct, ...incorrect, ...skipped]
//     .filter(v => !isNaN(v));

// let maxTime = Math.ceil(Math.max(...allTimes, 0));

// if (maxTime <= 5) {
//     maxTime = 5;
// } else if (maxTime <= 10) {
//     maxTime = 10;
// } else {
//     maxTime = Math.ceil(maxTime / 5) * 5;
// } //15 limit
const allTimes = [...correct, ...incorrect, ...skipped]
    .filter(v => !isNaN(v));

let maxTime = Math.ceil(Math.max(...allTimes, 0));

if (maxTime <= 5) {
    maxTime = 5;
} else if (maxTime <= 10) {
    maxTime = 10;
} else if (maxTime <= 15) {
    maxTime = 15;
} else if (maxTime <= 20) {
    maxTime = 20;
} else if (maxTime <= 30) {
    maxTime = 30;
} else {
    maxTime = Math.ceil(maxTime / 5) * 5;
}
      const newData = {
        labels: newLabels,
        datasets: [
          { label: 'Correct', data: dataset.correct.slice(0, qusCount), backgroundColor: '#7ECC45' },
          { label: 'Incorrect', data: dataset.incorrect.slice(0, qusCount), backgroundColor: '#C64225' },
          { label: 'Skipped', data: dataset.skipped.slice(0, qusCount), backgroundColor: '#4F4F4F' }
        ]
      };
      const options = {
        responsive: true,
        scales: {
      
//         y: {
//   beginAtZero: true,
//   min: 0,
//   max: maxTime,
//   ticks: {
//     stepSize: 1,           // distance between rows (0,5,10,15...)
//         padding: 10,
//          font: {
//           size: 12             // increase font size (optional)
//         },
//     autoSkip: false,
//     callback: function (value) {
//       return Number.isInteger(value) ? `${value}m` : '';
//     }
//   },
//   title: {
//     display: true,
//     text: 'TIME (Minutes)'
//   }
// },
// y: {
//   beginAtZero: false,
//   min: 1,
//   max: maxTime,
//   ticks: {
//     stepSize: 1,
//     autoSkip: false,
//     padding: 10,
//     font: {
//       size: 10
//     },
//     callback: function (value) {
//       return Number.isInteger(value) ? `${value}m` : '';
//     }
//   },
//   title: {
//     display: true,
//     text: 'TIME (Minutes)'
//   }
// },
// y: {
//   beginAtZero: true,
//   min: 0,
//   max: Math.max(5, maxTime),
//   ticks: {
//     stepSize: 1,
//     autoSkip: false,
//     padding: 10,
//     font: {
//       size: 10
//     },
//     callback: function (value) {
//       if (value === 0) return '0m';
//       if (value === 5) return '5m+';
//       return Number.isInteger(value) ? `${value}m` : '';
//     }
//   },
//   title: {
//     display: true,
//     text: 'TIME (Minutes)'
//   }
// },


    y: {
    beginAtZero: true,
    min: 0,
    max: maxTime,
    ticks: {
        stepSize: 1,
        autoSkip: false,
        callback(value) {
            return value + "m";
        }
    }
},
          x: {
            title: {
              display: true,
              text: 'QUESTIONS'
            }
          }
        },
        plugins: {
    tooltip: {
      callbacks: {
        label: function (context) {
          const valueInMinutes = context.raw;
          const totalSeconds = Math.round(valueInMinutes * 60);
          const minutes = Math.floor(totalSeconds / 60);
          const seconds = totalSeconds % 60;

          let timeStr = '';
          if (minutes > 0) timeStr += `${minutes}m `;
          if (seconds > 0 || minutes === 0) timeStr += `${seconds}s`;
          return `${context.dataset.label}: ${timeStr.trim()}`;
        }
      }
    }
  }
};
    


      if (timeChart) {
          timeChart.data = newData;
          timeChart.options = options;
          timeChart.update();
      } else {
          timeChart = new Chart(ctx, {
            type: 'bar',
            data: newData,
            options: options
          });
      }
  }

  document.addEventListener('DOMContentLoaded', function () {
      const initialSection = document.getElementById('sectionSelect').value;
      updateChart(initialSection);
  });

  document.getElementById('sectionSelect').addEventListener('change', function () {
      updateChart(this.value);
  });
</script>



@endsection