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

    /* Ensure the container enforces the desired size */
        #chart-container {
            width: 500px;
            height: 500px;
        }
        /* Set fixed size for the canvas */
        #myChart {
            width: 500px !important;
            height: 500px !important;
        }
        #myChart4{
            width: 283px !important;
        }
        #myChart3{
            width: 283px !important;
        }
        #myChart2{
            width: 283px !important;
        }
        #myChart1{
            width: 283px !important;
        }
        .custom-border {
            border: 1px solid #A83942; /* Adjust color and thickness */
            border-radius: 2px; /* Optional: rounded corners */
            padding: 5px; /* Optional: spacing inside */
            margin-right: -9px;
            margin-top:29px;
        }
        .section_name{
            background-color: #A83942;
            margin-left: -5px;
            margin-right: 3px;
            margin-bottom: -5px;
            color: white;
            text-align: center;
        }
        .section_name1{
            background-color: #A83942;
            margin-left: 3px;
            margin-right: 3px;
            margin-bottom: -7px;
            color: white;
            text-align: center;
        }
        .section_name2{
            background-color: #A83942;
            margin-left: 3px;
            margin-right: 3px;
            margin-bottom: -7px;
            color: white;
            text-align: center;
        }
        .section_name3{
            background-color: #A83942;
            margin-left: 3px;
            margin-right: -5px;
            margin-bottom: -7px;
            color: white;
            text-align: center;
        }
    </style>
    <?php
        $userid =session()->get('id');
        $sid = 'report';
        $paperid = request()->paperid;
        $testid = request()->testid;
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
        $subQuery = DB::table('student_quizes')
                    ->select('section_type', DB::raw('MAX(id) as max_id'))
                    ->where('test_id', $testid)
                    ->where('user_id', $userid)
                    ->where('paper_id', $paperid)
                    ->groupBy('section_type');

            $reports = DB::table('student_quizes')
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

                              if (isset($counts[1.0])) {
                                $neg2 = $counts[1.0];
                              } else {
                                  $neg2 = 0; 
                              }
                            
                              $neg1 = array_sum($neg);
                             // $totalmark = $pos1 - $neg1;
                             //$totalmark = $pos1 - $neg2;
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
<?php
    $test = DB::table('tests')
            ->where('id',$testid)
            ->limit(1)
            ->first();
          
//     $student_quizes = DB::table('student_quizes')
//                         ->where('user_id',$userid)
//                         ->where('test_id',$testid)
//                         ->where('paper_id',$paperid)
//                         ->where('section_type', 'like', "%Verbal%")
//                         ->limit(1)
//                         ->first();

//     $student_dataquiz = DB::table('student_quizes')
//                         ->where('user_id',$userid)
//                         ->where('test_id',$testid)
//                         ->where('paper_id',$paperid)
//                         ->where('section_type', 'like', "%Data%")
//                         ->limit(1)
//                         ->first();
                        
//     $student_qaquiz = DB::table('student_quizes')
//                         ->where('user_id',$userid)
//                         ->where('test_id',$testid)
//                         ->where('paper_id',$paperid)
//                         ->where('section_type', 'like', "%quantitative%")
//                         ->limit(1)
//                         ->first();
                        
//     $quiz_duration = DB::table('quiz_durations')
//                         ->where('test_id',$testid)
//                         ->orderBy('id','desc')
//                         ->limit(1)
//                         ->first();
//     $quizVerbalTime = $quiz_duration->verbal_time;
//     $quizVerbalseconds = $quizVerbalTime * 60;
    
//     $quizdataTime = $quiz_duration->interp_time;
//     $quizdataseconds = $quizdataTime * 60;
    
//     $quizquantTime = $quiz_duration->quantitative_time;
//     $quizquantseconds = $quizquantTime * 60;

//   // $vstudent_answer = explode(",", $student_quizes->answer);
   
//      $vstudent_answer = explode(",", $student_quizes->answer ?? '');

//     // $verbal_duration =   explode(",", $student_quizes->ans_duration ?? '');
    
//     $verbal_duration = explode(",", $student_quizes->ans_duration ?? '');

// // remove empty values + convert to int
// $verbal_duration = array_filter($verbal_duration);
// $verbal_duration = array_map('intval', $verbal_duration);

// $verbalAlltime = !empty($verbal_duration) 
//     ? array_sum($verbal_duration) / 1000 
//     : 0;
    
//     $verbalAlltime = (array_sum($verbal_duration)/1000);
//     $verbal_correct = array();
//     $data_correct = array();
//     $qa_correct = array();
//     $overall_correct = array();
//     //$verbal_duration  = array();
    
//     $excel_questions =  DB::table('excel_questions')
//                         ->where('test_id',$testid)
//                         ->get();
//     foreach($excel_questions as $excel_question)
//     {
//         if (stripos($excel_question->section_name, 'verbal') !== false) 
//         {
//           $verbal_correct[] =  $excel_question->correct_option;
//         }

//         if (stripos($excel_question->section_name, 'data') !== false) 
//         {
//             $data_correct[] =  $excel_question->correct_option;
//         } 
//         if (stripos($excel_question->section_name, 'quantitative') !== false) 
//         {
//             $qa_correct[] =  $excel_question->correct_option;
//         } 
//             $overall_correct[]  = $excel_question->correct_option;
//     }

//   ////////////////VRC///////////////////////////////////////////////////
  
//         $verbalCorrectTime = [];
//         $verbalInCorrectTime = [];
//         $verbalSkipTime = [];
//         // dd($vstudent_answer);
//         foreach ($verbal_correct as $index => $correctValue) {
//             $answer = $vstudent_answer[$index] ?? null;
//             $duration = $verbal_duration[$index] ?? 0;
       
//             if(empty($answer)){
              
//                  $verbalSkipTime[$index] = $duration;
//             }else{
//                 if(strcasecmp($answer, $correctValue) === 0){
//                     $verbalCorrectTime[$index] = $duration;
//                 }else{
//                   $verbalInCorrectTime[$index] = $duration; 
//                 }
//             }
//         }
//          // dd(array_sum($verbalSkipTime));
//         $attemptVerbalTime = array_sum($verbal_duration) / 1000;
//         $verbalAlltime = $attemptVerbalTime;
//         $verbalCorrectTimeInSeconds = array_sum($verbalCorrectTime) / 1000;
//         $verbalInCorrectTimeInSeconds = array_sum($verbalInCorrectTime) / 1000;
      
//         $verbalSkipTimeSeconds = array_sum($verbalSkipTime) / 1000;
//       // dd($verbalSkipTimeSeconds);
//         //$verbalpertime = ($verbalCorrectTimeInSeconds / $verbalAlltime) * 100;
//         $verbalpertime = $verbalAlltime > 0 
//                          ? ($verbalCorrectTimeInSeconds / $verbalAlltime) * 100 
//                         : 0;
                        
//         $verbalpertimeIn = $verbalAlltime > 0 
//                           ? ($verbalInCorrectTimeInSeconds  / $verbalAlltime) * 100
//                           : 0;
                          
//         $verbalpertimeskip = $verbalAlltime > 0
//                             ? ($verbalSkipTimeSeconds / $verbalAlltime) * 100
//                             : 0;
        
//         $formatedVerbalTime = number_format($verbalpertime, 2);
//         $formatedVerbalTimeIn = number_format($verbalpertimeIn, 2);
//         $formatedVerbalTimeSkip = number_format($verbalpertimeskip, 2);

//   ///////////////////////////DILR////////////////////////////////////////////////
//     //$dstudent_answer = explode(",", $student_dataquiz->answer);
//     $dstudent_answer = explode(",", $student_dataquiz->answer ?? '');
//     $data_duration =   explode(",", $student_dataquiz->ans_duration ?? '');
//   // $dataAlltime = (array_sum($data_duration)/1000);
//   $dataAlltime = array_sum(array_map('intval', $data_duration)) / 1000;

//   ///////////////////////////////////DILR Skip missing elements//////////////////////////////////////
//     $dataAnswer = [];
//     foreach ($data_correct as $index => $value) {
//         $dataAnswer[$index] = $dstudent_answer[$index] ?? null;
//     }
    
//     $dataCorrect = [];
//     $dataInCorrect = [];
//     $dataSkipped = [];
//     $dataCorrectTime = [];
//     $dataInCorrectTime = [];
//     $dataSkipTime = [];
    
//     // Exclusive categorization
//     foreach ($dataAnswer as $index => $answer) {
//         $correctValue = $data_correct[$index] ?? null;
//         $duration = $data_duration[$index] ?? 0;

//         // if (empty($answer)) {
//         //     $dataSkipped[$index] = $answer;
//         //     $dataSkipTime[$index] = $duration;
//         // } elseif ($answer === $correctValue) {
            
//         //     $dataCorrect[$index] = $answer;
//         //     $dataCorrectTime[$index] = $duration;
//         // } else {
//         //    
//         //         $dataInCorrect[$index] = $answer;
//         //         $dataInCorrectTime[$index] = $duration;
//         // }
//         if (empty($answer)) {
//             $dataSkipped[$index] = $answer;
//             $dataSkipTime[$index] = $duration;
//         }else{
//           if (strcasecmp($answer, $correctValue) === 0) {
//               $dataCorrect[$index] = $answer;
//               $dataCorrectTime[$index] = $duration;
//             }else{
//               $dataInCorrect[$index] = $answer;
//               $dataInCorrectTime[$index] = $duration;
//             }
//         }
//     }
//     // Convert durations from ms to seconds
//     $dataCorrectTimeInSeconds = array_sum($dataCorrectTime) / 1000;
//     $dataInCorrectTimeInSeconds = array_sum($dataInCorrectTime) / 1000;
//     $dataSkipTimeSeconds = array_sum($dataSkipTime) / 1000;
    
//     if ($dataAlltime > 0) {
//         $datapertimeCorrect = ($dataCorrectTimeInSeconds / $dataAlltime) * 100;
//         $datapertimeIncorrect = ($dataInCorrectTimeInSeconds / $dataAlltime) * 100;
//         $datapertimeSkip = ($dataSkipTimeSeconds / $dataAlltime) * 100;
//     } else {
//         $datapertimeCorrect = $datapertimeIncorrect = $datapertimeSkip = 0;
//     }
//     // Format percentages
//     $formatedDataTime = number_format($datapertimeCorrect, 2);
//     $formatedDataTimeIn = number_format($datapertimeIncorrect, 2);
//     $formatedDataTimeSkip = number_format($datapertimeSkip, 2);

//   ///////////////////////////////QA///////////////////////////////////////////
  
//     $qastudent_answer = explode(",", $student_qaquiz->answer ?? '');
    
//     // $quant_duration =   explode(",", $student_qaquiz->ans_duration ?? '');
//     // $quantAlltime =    (array_sum($quant_duration)/1000);
    
    
//     $quant_duration = array_map('intval', array_filter(explode(",", $student_qaquiz->ans_duration ?? '')));
//     $quantAlltime = array_sum($quant_duration) / 1000;
    
//     $quantAnswer = [];
//     foreach ($qa_correct as $index => $value) {
//         $quantAnswer[$index] = $qastudent_answer[$index] ?? null;
//     }

//     // First, identify skipped answers (empty/null)
//     $quantElements = [];
//     foreach ($quantAnswer as $index => $value) {
//         if (empty($value)) {
//             $quantElements[$index] = $value;
//         }
//     }
//     // QA Skip Time
//     $quantSkipTime = [];
//     // foreach ($quantElements as $index => $value) {
//     //     $quantSkipTime[$index] = $quant_duration[$index];
//     // }
//     foreach ($quantElements as $index => $value) {
//     $quantSkipTime[$index] = $quant_duration[$index] ?? 0;
// }
//     $quantSkipTimeSeconds = (array_sum($quantSkipTime) / 1000);
    
//     $quantpertimeskip = $quantAlltime > 0 
//                     ? ($quantSkipTimeSeconds / $quantAlltime) * 100
//                     : 0;
    
//     $formatedQuantTimeSkip = number_format($quantpertimeskip, 2);
//     // Now filter out skipped answers before processing correct/incorrect
//     $filteredQuantAnswer = array_diff_key($quantAnswer, $quantElements);
//     // QA Correct
//     $quantCorrect = array_filter($filteredQuantAnswer, function ($value, $key) use ($qa_correct) {
//         return isset($qa_correct[$key]) && $value === $qa_correct[$key];
//     }, ARRAY_FILTER_USE_BOTH);

//     $quantCorrectTime = [];
//     foreach ($quantCorrect as $index => $value) {
//         $quantCorrectTime[$index] = $quant_duration[$index];
//     }
    
//     $quantCorrectTimeInSeconds = (array_sum($quantCorrectTime) / 1000);
    
//     $quantpertime = $quantAlltime > 0
//                   ? ($quantCorrectTimeInSeconds / $quantAlltime) * 100
//                   : 0;
    
//     $formatedQuantTime = number_format($quantpertime, 2);
    
//     // QA Incorrect (non-skipped and non-correct answers)
//     $qunatInCorrect = array_diff_key($filteredQuantAnswer, $quantCorrect);
//     $quantInCorrectTime = [];
//     foreach ($qunatInCorrect as $index => $value) {
//         $quantInCorrectTime[$index] = $quant_duration[$index];
//     }
//     $quantInCorrectTimeInSeconds = (array_sum($quantInCorrectTime) / 1000);
    
//     $quantpertimeIn = $quantAlltime > 0
//                     ? ($quantInCorrectTimeInSeconds / $quantAlltime) * 100
//                     : 0;
    
//     $formatedquantTimeIn = number_format($quantpertimeIn, 2);
    
//     ////////////////////////////////////////////OVERALL////////////////////////////

//     $overAlltime = $verbalAlltime + $dataAlltime + $quantAlltime;
//     // All correct time
//     $allCorrectTimeInSeconds = $verbalCorrectTimeInSeconds + $dataCorrectTimeInSeconds + $quantCorrectTimeInSeconds;
//     $allpertime = ($allCorrectTimeInSeconds / $overAlltime) * 100;
//     $formatedAllTime = number_format($allpertime, 2);
    
//     // All incorrect time
//     $allInCorrectTimeInSeconds = $verbalInCorrectTimeInSeconds + $dataInCorrectTimeInSeconds + $quantInCorrectTimeInSeconds;
//     $allIncorrectpertime = ($allInCorrectTimeInSeconds / $overAlltime) * 100;
//     $formatedIncorrectAllTime = number_format($allIncorrectpertime, 2);
    
//     // All skipped time
//     $allSkipTimeInSeconds = $verbalSkipTimeSeconds + $dataSkipTimeSeconds + $quantSkipTimeSeconds;
//     $allSkippertime = ($allSkipTimeInSeconds / $overAlltime) * 100;
//     $formatedSkipAllTime = number_format($allSkippertime, 2);


function normalizeSection($name) {
    $name = strtolower($name);

    if (str_contains($name, 'verbal') || str_contains($name, 'language')) {
        return 'VRC';
    }

    if (str_contains($name, 'data') || str_contains($name, 'logical')) {
        return 'DILR';
    }

    if (str_contains($name, 'quantitative') || str_contains($name, 'quant')) {
        return 'QA';
    }

    return 'OTHER';
}

function isBlankAnswer($value) {
    return $value === null || trim((string)$value) === '';
}

function percentVal($part, $total) {
    return $total > 0 ? number_format(($part / $total) * 100, 2, '.', '') : '0.00';
}

$sectionStats = [
    'VRC' => ['correct_time' => 0, 'incorrect_time' => 0, 'skip_time' => 0, 'total_time' => 0],
    'DILR' => ['correct_time' => 0, 'incorrect_time' => 0, 'skip_time' => 0, 'total_time' => 0],
    'QA' => ['correct_time' => 0, 'incorrect_time' => 0, 'skip_time' => 0, 'total_time' => 0],
];

foreach ($reports as $report) {
    $sectionKey = normalizeSection($report->section_type);

    if (!isset($sectionStats[$sectionKey])) {
        continue;
    }

    $questionIds = array_values(array_filter(explode(',', $report->question_id), function ($v) {
        return trim((string)$v) !== '';
    }));

    $answers = explode(',', $report->answer ?? '');

    // IMPORTANT: array_filter yaha use mat karo, index disturb hota hai
    $durations = array_map('intval', explode(',', $report->ans_duration ?? ''));

    $questions = DB::table('excel_questions')
        ->where('test_id', $report->test_id)
        ->whereIn('id', $questionIds)
        ->orderByRaw("FIELD(id," . implode(',', $questionIds) . ")")
        ->get();

    foreach ($questions as $index => $question) {
        $correctAnswer = trim(strtolower((string)$question->correct_option));
        $studentAnswer = $answers[$index] ?? null;
        $duration = $durations[$index] ?? 0;

        $sectionStats[$sectionKey]['total_time'] += $duration;

        if (isBlankAnswer($studentAnswer)) {
            $sectionStats[$sectionKey]['skip_time'] += $duration;
        } elseif (trim(strtolower((string)$studentAnswer)) === $correctAnswer) {
            $sectionStats[$sectionKey]['correct_time'] += $duration;
        } else {
            $sectionStats[$sectionKey]['incorrect_time'] += $duration;
        }
    }
}

/* VRC */
$formatedVerbalTime = percentVal($sectionStats['VRC']['correct_time'], $sectionStats['VRC']['total_time']);
$formatedVerbalTimeIn = percentVal($sectionStats['VRC']['incorrect_time'], $sectionStats['VRC']['total_time']);
$formatedVerbalTimeSkip = percentVal($sectionStats['VRC']['skip_time'], $sectionStats['VRC']['total_time']);

/* DILR */
$formatedDataTime = percentVal($sectionStats['DILR']['correct_time'], $sectionStats['DILR']['total_time']);
$formatedDataTimeIn = percentVal($sectionStats['DILR']['incorrect_time'], $sectionStats['DILR']['total_time']);
$formatedDataTimeSkip = percentVal($sectionStats['DILR']['skip_time'], $sectionStats['DILR']['total_time']);

/* QA */
$formatedQuantTime = percentVal($sectionStats['QA']['correct_time'], $sectionStats['QA']['total_time']);
$formatedquantTimeIn = percentVal($sectionStats['QA']['incorrect_time'], $sectionStats['QA']['total_time']);
$formatedQuantTimeSkip = percentVal($sectionStats['QA']['skip_time'], $sectionStats['QA']['total_time']);

/* Overall */
$overallCorrectTime =
    $sectionStats['VRC']['correct_time'] +
    $sectionStats['DILR']['correct_time'] +
    $sectionStats['QA']['correct_time'];

$overallIncorrectTime =
    $sectionStats['VRC']['incorrect_time'] +
    $sectionStats['DILR']['incorrect_time'] +
    $sectionStats['QA']['incorrect_time'];

$overallSkipTime =
    $sectionStats['VRC']['skip_time'] +
    $sectionStats['DILR']['skip_time'] +
    $sectionStats['QA']['skip_time'];

$overallTotalTime = $overallCorrectTime + $overallIncorrectTime + $overallSkipTime;

$formatedAllTime = percentVal($overallCorrectTime, $overallTotalTime);
$formatedIncorrectAllTime = percentVal($overallIncorrectTime, $overallTotalTime);
$formatedSkipAllTime = percentVal($overallSkipTime, $overallTotalTime);

 ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class = "conatiner-fluid">
        <div class="d-flex px-4 my-3 justify-content-between align-items-center">
        <h5 class="">{{$test->test}}</h5>
        {{-- <a href="{{route('student.dashboard')}}" class="btn" style="background-color:#A83942;color:white;">Dashboard</a> --}}
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
                        <h5 class="card-title" style="position: relative;color: #2ED480;">{{array_sum($c1)}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                    <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important">
                       Incorrect Answers
                    </div>
                    <div class="card-body py-1">
                        <h5 class="card-title" style="position:relative; color:#FD8539;">{{array_sum($inc12)}}</h5>
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
                        <h5 class="card-title" style="position:relative; color:#B758E3;">{{$pto}}</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3 custom-border">
                    <div id="chart-container">
                        <canvas id="myChart4"></canvas>
                    </div>
                    <br/>
                    <p style="margin-top:-194px;margin-left:30px;" class="allcorrect" data-allcorrect="{{$formatedAllTime}}"><span style="color:#74B72E;">{{$formatedAllTime}}%</span>on correct answer</p>
                    <br/>
                    <p style="margin-left:30px;margin-top:-31px;" class="allIncorrect" data-allIncorrect="{{$formatedIncorrectAllTime}}"><span style="color:#C63921;" >{{$formatedIncorrectAllTime}}%</span>on incorrect answer</p>
                    <br/>
                    <p style="margin-left:30px;margin-top:-31px;" class="allskip" data-allskip = "{{$formatedSkipAllTime}}">
                        <span style="color:#343434;">{{$formatedSkipAllTime}}%</span>on skipped
                    </p>
                    <br/>
                    {{-- <p style="margin-left:81px;margin-top:-31px;color:#C63921;">Overall</p> --}}
                    <div class ="section_name">Overall</div>
                </div>
                <div class="col-md-3 custom-border">
                    <div id="chart-container1">
                        <canvas id="myChart1"></canvas>
                    </div>
                    <br/>
                    <p style = "margin-top:21px;margin-left:30px;" class="vrcco" data-cvrc ="{{$formatedVerbalTime}}"><span style="color:#74B72E;">{{$formatedVerbalTime}}%</span>on correct answer</p>
                    <br/>
                    <p style = "margin-left:30px;margin-top:-31px;" class="vrcin" data-ivrc ="{{$formatedVerbalTimeIn}}"><span style="color:#C63921;">{{$formatedVerbalTimeIn}}%</span> on incorrect answer</p>
                    <br/>
                    <p style = "margin-left:30px;margin-top:-31px;" class="vrcsk" data-skvrc ="{{$formatedVerbalTimeSkip}}"><span style="color:#343434;">{{$formatedVerbalTimeSkip}}%</span>on skippped</p>
                    <br/>
                    <div class ="section_name1">VRC</div>
                </div>
                <div class="col-md-3 custom-border">
                    <div id="chart-container">
                        <canvas id="myChart2"></canvas>
                    </div>
                    <br/>
                    <p style = "margin-top:-194px;margin-left:30px;" class="dataco" data-cdilr ="{{$formatedDataTime}}"><span style="color:#74B72E;">{{$formatedDataTime}}%</span>on correct answer</p>
                    <br/>
                    <p style = "margin-left:30px;margin-top:-31px;" class="datain" data-idilr ="{{$formatedDataTimeIn}}"><span style="color:#C63921;">{{$formatedDataTimeIn}}%</span>on incorrect answer</p>
                    <br/>
                    <p style = "margin-left:30px;margin-top:-31px;" class="datask" data-skdilr ="{{$formatedDataTimeSkip}}"><span style="color:#343434;">{{$formatedDataTimeSkip}}%</span>on skippped</p>
                    <br/>
                    <div class ="section_name2">DILR</div>
                </div>
                <div class="col-md-3 custom-border">
                    <div id="chart-container">
                        <canvas id="myChart3"></canvas>
                    </div>  
                    <br/>
                    <p style="margin-top:-194px;margin-left:30px;" class="qaco" data-cqa ="{{$formatedQuantTime}}"><span style="color:#74B72E;">{{$formatedQuantTime}}%</span>on correct answer</p>
                    <br/>
                    <p style="margin-left:30px;margin-top:-31px;" class="qain" data-iqa ="{{$formatedquantTimeIn}}"><span style="color:#C63921;" >{{$formatedquantTimeIn}}%</span>on incorrect answer</p>
                    <br/>
                    <p style="margin-left:30px; margin-top:-31px;" class="qask" data-skqa ="{{$formatedQuantTimeSkip}}"><span style="color:#343434;">{{$formatedQuantTimeSkip}}%</span>on skipped</p>
                    <br/>
                    <div class ="section_name3">QA</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var ctx = document.getElementById('myChart1').getContext('2d');
    var vrcCorrect = $('.vrcco').attr('data-cvrc');
    var vrcIncorrect = $('.vrcin').attr('data-ivrc');
    var vrcskip = $('.vrcsk').attr('data-skvrc');
    var myChart = new Chart(ctx, {
        type: 'pie', 
        data: {
            // labels: ['#343434', '#74B72E','#C63921'],
            // labels: ['Black', 'Green','Red'],
            datasets: [{
                data: [vrcskip, vrcCorrect, vrcIncorrect], 
                  backgroundColor: ['#4F4F4F', '#7ECC45','#C64225']
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false, 
        }
    });

    var ctx = document.getElementById('myChart2').getContext('2d');
    var dilrCorrect = $('.dataco').attr('data-cdilr');
    var dilrIncorrect = $('.datain').attr('data-idilr');
    var dirlskip = $('.datask').attr('data-skdilr');
  
    var myChart = new Chart(ctx, {
        type: 'pie',  
        data: {
            // labels: ['#343434', '#74B72E','#C63921'],
            // labels: ['Black', 'Green','Red'],
            datasets: [{
                data: [dirlskip, dilrCorrect, dilrIncorrect],  
                 backgroundColor: ['#4F4F4F', '#7ECC45','#C64225']
            }]
        },
        options: {
            responsive: false, 
            maintainAspectRatio: false, 
        }
    });
        var ctx = document.getElementById('myChart3').getContext('2d');
        var qaCorrect = $('.qaco').attr('data-cqa');
        var qaIncorrect = $('.qain').attr('data-iqa');
        var qalskip = $('.qask').attr('data-skqa');
        var myChart = new Chart(ctx, {
        type: 'pie', 
        data: {
            // labels: ['#343434', '#74B72E','#C63921'],
            // labels: ['Black', 'Green','Red'],
            datasets: [{
                data: [qalskip, qaCorrect, qaIncorrect],  
                  backgroundColor: ['#4F4F4F', '#7ECC45','#C64225']
            }]
        },
        options: {
            responsive: false, 
            maintainAspectRatio: false,
        }
    });

    var ctx = document.getElementById('myChart4').getContext('2d');
    var allcorrect = $('.allcorrect').attr('data-allcorrect');
    var allIncorrect = $('.allIncorrect').attr('data-allIncorrect');
    var allskip = $('.allskip').attr('data-allskip');
    var myChart = new Chart(ctx, {
        type: 'pie', 
        data: {
            // labels: ['#343434', '#74B72E','#C63921'],
            // labels: ['Black','Green','Red'],
            datasets: [{
                data: [allskip, allcorrect, allIncorrect],  
                backgroundColor: ['#4F4F4F', '#7ECC45','#C64225']
            }]
        },
        options: {
            responsive: false, 
            maintainAspectRatio: false, 
        }
    });
</script>
@endsection
