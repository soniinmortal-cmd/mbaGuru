@extends('admin_template')
@section('css')
@endsection
@section('content') 
<div class="col-md-12">
    <div id="topbar-right-menu"  >
      <button id="downloadExcel" class="btn btn-primary" style="float:right;margin-top:-30px;">Download Excel</button>
        <div class="row"style="margin-top:50px;">
            <?php
                $i=1;
                $id = request()->id;
                $ansdata =array();
                $positive = array();
                $negative = array();
                $data = 1;
                $muser_id = array();
                $newreports = DB::table('student_quizes')
                              ->where('test_id',$id)
                              ->get();
                foreach($newreports as $newreport)
                {
                    $muser_id[] = $newreport->user_id;
                }
                $studentlogs = DB::table('studentlogs')
                            ->whereIn('id',$muser_id)
                            ->orderBy('id','desc')
                            ->get();
            
            ?>
            <div class="col-md-4" style="margin-top:20px;">            
                <table id="" class="table table-bordered table-responsive myTable">
                    <!--<h5 colspan = "3">user data</h5>-->
                    <thead>
                        <tr>
                            <th colspan="3">user data</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td>s no.</td>
                            <td>name</td>
                            <td>email</td>
                        </tr>
                    </tbody>
                    <tbody>
                        @if(!empty($studentlogs))
                        @foreach($studentlogs as $studentlog) 
                        <tr>  
                            <td>{{$i++}}</td>
                            <td>{{$studentlog->name}}</td>
                            <td>{{$studentlog->email}}</td> 
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class=" col-md-4" style="margin-top:20px;">
                <table id="" class="table table-bordered table-responsive myTable">
                     <thead>
                        <tr>
                            <th colspan="7">Verbal and Reading Comprehension</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr> 
                            <td>Attempt</td>
                            <td>Missed</td>
                            <td>Correct</td>
                            <td>InCorrect</td>
                            <td>Score</td>
                            <td>Percentage%</td>
                            <td>Time Taken(sec)</td>  
                        </tr>
                    </tbody>
                    <tbody>
                    <?php
                        $ansdata =array();
                        $positive = array();
                        $negative = array();
                        $an1 = array();
                    ?>
                    @if(!empty($studentlogs))
                    @foreach($studentlogs as $studentlog)
                        <?php
                            $student_quizes = DB::table('student_quizes')
                                        ->where('user_id',$studentlog->id)
                                        ->where('test_id',$id)
                                        ->where('section_type', 'like', "%VERBAL%")
                                        ->get();

                            foreach($student_quizes as $student_quize)
                            {
                                $aners = explode(',',$student_quize->answer);
                                $question_id = explode(',',$student_quize->question_id);
                                $totaltime = explode(',',$student_quize->ans_duration);
                                if (!is_array($totaltime)) {
                                // Case 1: If it's a JSON string like "[10,20,30]"
                                if (is_string($totaltime) && $decoded = json_decode($totaltime, true)) {
                                    $totaltime = $decoded;
                                }
                                // Case 2: If it's a comma-separated string like "10,20,30"
                                elseif (is_string($totaltime) && str_contains($totaltime, ',')) {
                                    $totaltime = explode(',', $totaltime);
                                }
                                // Case 3: If it's a single number string like "25"
                                elseif (is_numeric($totaltime)) {
                                    $totaltime = [(float) $totaltime];
                                }
                                // Case 4: Anything else → make it empty
                                else {
                                    $totaltime = [];
                                }
                            }
                            
                            // Convert all elements to numeric
                            $totaltime = array_map('floatval', $totaltime);
                            // Now safely sum
                            $totaltime1 = array_sum($totaltime);

                                //$totaltime1 = array_sum($totaltime);
                                $attempttime = date("H:i:s", $totaltime1 / 1000);
                                $ques_ans = DB::table('excel_questions')
                                            ->where('test_id',$id)
                                            ->whereIn('id', $question_id)
                                            ->get();

                               foreach($ques_ans as $qst)
                               {
                                  $ansdata[] =   $qst->correct_option;
                                  $positive[] = $qst->positive_mark;
                                  $negative[] = $qst->negative_mark;
                               }
                                $ansdata = array_map('strtolower', $ansdata);
                                $aners = array_map('strtolower', $aners);
                                $resultt = array_diff_assoc($ansdata, $aners);
                                $resultt = array_map('strtolower', $resultt);
                                $correct = array_diff_assoc($ansdata,$resultt);
                            }
                            //dd($correct);
                            $result = [];
                            if(isset($question_id)){
                                foreach ($question_id as $key => $value) {
                                    $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
                                }
                            }
                            $filteredArray = array_filter($result, function($value) {
                                return $value === '';
                            });
                            $filteredArray = $filteredArray ?? [];
                            $totalskip = count($filteredArray);
                            $aners = $aners ?? [];
                            $an1[] = count($aners);
                            $correct = $correct ?? [];
                            $incorrect = count(array_filter($aners)) - count($correct);
                            $pos = array_intersect_key($positive ,$correct);
                            $pos1 = array_sum($pos);
                            $a = array();
                            for($i =0;$i<$incorrect; $i++)
                            {
                              $a[$i] = 1.0; 
                            }
                            $neg = array_intersect_key($negative,$a);
                            $counts = array_count_values($neg);
                            if (isset($counts[1.0])) {
                               $neg2 = $counts[1.0];
                            } else {
                               $neg2 = 0; 
                            }
                            $neg1 = array_sum($neg);
                            $totalmark = $pos1 - $neg2;
                            $show_answer = count($aners);
                            $attp = array_filter($aners);
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
                            }else{
                                $per2 =  $per3;
                            } 
                            $skip1 =   count(($aners))-count($attp);
                       
                        ?>
                    <tr>
                        <td>{{count($attp)}}</td>
                        <!--<td>{{$totalskip}}</td>-->
                        <td>{{$skip1}}</td>
                        <td>{{count($correct)}}</td>
                        <td>{{$incorrect}}</td>
                        <td>{{$totalmark}}</td>
                        <td>{{$per2}}</td>
                        @if(!empty($attempttime))
                            <td>{{$attempttime}}</td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                    
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <?php
             $ansdata =array();
             $positive = array();
             $negative = array();
             $an2 = array();
            ?>
            <div class=" col-md-4" style="margin-top:20px;">
                <!--<h5>Data Interpretation & Logical Reasoning</h5>-->
                <table id="" class="table table-bordered table-responsive myTable ">
                    <thead>
                        <tr>
                            <th colspan="7">Data Interpretation & Logical Reasoning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Attempt</td>
                            <td>Missed</td>
                            <td>Correct</td>
                            <td>InCorrect</td>
                            <td>Score</td>
                            <td>Percentage%</td>
                            <td>Time Taken(sec)</td>
                        </tr>
                    </tbody>
                <tbody>
                    @if(!empty($studentlogs))
                @foreach($studentlogs as $studentlog)
                    <?php
                        $student_quizes = DB::table('student_quizes')
                                            ->where('user_id',$studentlog->id)
                                            ->where('test_id',$id)
                                            ->where('section_type', 'like', "%Data%")
                                            ->get();
                                            $aners11 =array();
                        foreach($student_quizes as $student_quiz)
                        {
                            $aners1 = explode(',',$student_quiz->answer);
                            //dd($aners1);
                             $aners11[] = explode(',',$student_quiz->answer);
                            $aners = array_filter($aners1);
                            $question_id = explode(',',$student_quiz->question_id);
                            $totaltime = explode(',',$student_quiz->ans_duration);
                            $totaltime1 = array_sum($totaltime);
                            $attempttime = date("H:i:s", $totaltime1 / 1000);
                            
                            $ques_ans = DB::table('excel_questions')
                                            ->where('test_id',$id)
                                            ->whereIn('id', $question_id)
                                            ->get();

                            foreach($ques_ans as $qst)
                            {
                                $ansdata[] =   $qst->correct_option;
                                $positive[] = $qst->positive_mark;
                                $negative[] = $qst->negative_mark;
                            }
                            $ansdata = array_map('strtolower', $ansdata);
                            $aners = array_map('strtolower', $aners);
                            $resultt = array_diff_assoc($ansdata, $aners);
                            $resultt = array_map('strtolower', $resultt); 
                            $correct = array_diff_assoc($ansdata,$resultt);
                        }
                        $result = [];
                        if(isset($question_id)){
                            foreach ($question_id as $key => $value) {
                                $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
                            }
                        }
                        $filteredArray = array_filter($result, function($value) {
                            return $value === '';
                        });
                        $filteredArray = $filteredArray ?? [];
                        $totalskip = count($filteredArray);
                        $totalskip2 = $totalskip;
                        $aners = $aners ?? [];
                        $aners2 = array_filter($aners);
                        $an2[] = count(array_filter($aners2));

                        $correct = $correct ?? [];
                        $correct2 = $correct;
                        $incorrect = count(($aners)) - count($correct);
                        $incorrect2 = $incorrect;
                        $pos = array_intersect_key($positive ,$correct);
                        $pos1 = array_sum($pos);

                        $a = array();
                        for($i =0;$i<$incorrect; $i++)
                        {
                          $a[$i] = 1.0; 
                        }
                        $neg = array_intersect_key($negative,$a);
                        $counts = array_count_values($neg);
                        if (isset($counts[1.0])) {
                          $neg2 = $counts[1.0];
                        } else {
                            $neg2 = 0; 
                        }
                        $neg1 = array_sum($neg);
                        $totalmark = $pos1 - $neg2;
                        $totalmark2 = $totalmark;
                        $show_answer = count($aners);
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
                          }else{
                              $per2 =  $per3;
                          }
                        //   $per22 = $per2;
                        //   $skip2 = count($aners1) - count($aners2);
                        
                     
                        $per22 = $per2;
                       // dd($aners11);
                        $skip2 = count($aners11) - count($aners2);
                    ?>
                        <tr>
                            <td>{{count($aners2)}}</td>
                            <!--<td>{{$totalskip2}}</td>-->
                            <td>{{$skip2}}</td>
                            <td>{{count($correct2)}}</td>
                            <td>{{$incorrect2}}</td>
                            <td>{{$totalmark2}}</td>
                            <td>{{$per22}}</td>
                            <td>{{$attempttime}}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
                </table>
            </div> 
            
            <?php
             $ansdata =array();
             $positive = array();
             $negative = array();
             $an3 = array();
            ?>
            <div class=" col-md-4" style="">
                <!--<h5>Quantitative Aptitude</h5>-->
                <table id="" class="table table-bordered table-responsive myTable ">
                    <thead>
                        <tr>
                            <th colspan="7">Quantitative Aptitude</th>
                        </tr>
                    </thead>
                <tbody>
                    <tr>
                        <td>Attempt</td>
                        <td>Missed</td>
                        <td>Correct</td>
                        <td>InCorrect</td>
                        <td>Score</td>
                        <td>Percentage%</td>
                        <td>Time Taken(sec)</td>
                    </tr>
                </tbody>
              <tbody>
    @if(!empty($studentlogs))
        @foreach($studentlogs as $log)
            <?php
                // Reset variables for each student
                $answerList = [];
                $positiveMarks = [];
                $negativeMarks = [];
                $studentAnswers = [];
                $correctAnswers = [];
                $questionIds = [];
                $formattedTime = "00:00:00"; // Initialize default time
                $studentQuizRecords = DB::table('student_quizes')
                                        ->where('user_id', $log->id)
                                        ->where('test_id', $id)
                                        ->where('section_type', 'like', "%Quantitative%")
                                        ->get();

                foreach ($studentQuizRecords as $quizRecord) {
                    $studentAnswers = !empty($quizRecord->answer) ? explode(',', $quizRecord->answer) : [];
                    $studentAnswers = array_filter($studentAnswers); // Remove empty values
                    $questionIds = !empty($quizRecord->question_id) ? explode(',', $quizRecord->question_id) : [];
                    $timeDurations = !empty($quizRecord->ans_duration) ? explode(',', $quizRecord->ans_duration) : [];
                    $totalTimeSpent = array_sum($timeDurations);
                    // Check if totalTimeSpent is valid before formatting
                    if ($totalTimeSpent > 0) {
                        $formattedTime = date("H:i:s", $totalTimeSpent / 1000);
                    }
                    $questionData = DB::table('excel_questions')
                                      ->where('test_id', $id)
                                      ->whereIn('id', $questionIds)
                                      ->get();

                    foreach ($questionData as $question) {
                        $answerList[] = strtolower($question->correct_option);
                        $positiveMarks[] = $question->positive_mark;
                        $negativeMarks[] = $question->negative_mark;
                    }

                    $studentAnswers = array_map('strtolower', $studentAnswers);
                    $incorrectAnswers = array_diff_assoc($answerList, $studentAnswers);
                    $incorrectAnswers = array_map('strtolower', $incorrectAnswers);
                    $correctAnswers = array_diff_assoc($answerList, $incorrectAnswers);
                }

                // Ensure arrays are properly initialized
                $answerMapping = [];
                if (!empty($questionIds)) {
                    foreach ($questionIds as $key => $value) {
                        $answerMapping[$key] = isset($studentAnswers[$key]) ? $studentAnswers[$key] : '';
                    }
                }

                $unansweredQuestions = array_filter($answerMapping, function ($value) {
                    return $value === '';
                });

                $totalSkipped = count($unansweredQuestions ?? []);
                $studentAnswersFinal = $studentAnswers ?? [];
                $correctAnswersFinal = $correctAnswers ?? [];
                $totalIncorrect = count($studentAnswersFinal) - count($correctAnswersFinal);

                $positiveScore = array_intersect_key($positiveMarks, $correctAnswers);
                $totalPositive = array_sum($positiveScore);

                $negativePenalty = array_fill(0, $totalIncorrect, 1.0);
                $negativeScore = array_intersect_key($negativeMarks, $negativePenalty);
                $negativeCount = isset(array_count_values($negativeScore)[1.0]) ? array_count_values($negativeScore)[1.0] : 0;
                $finalScore = $totalPositive - $negativeCount;

                $attemptedCount = max(count($studentAnswersFinal), 1); // Prevent division by zero
                $percentageScore = number_format((count($correctAnswersFinal) / $attemptedCount) * 100, 2, '.', '');
                $finalPercentage = max($percentageScore, 0);
            ?>
            <tr>
                <td>{{ count($studentAnswersFinal) }}</td>
                <td>{{ $totalSkipped }}</td>
                <td>{{ count($correctAnswersFinal) }}</td>
                <td>{{ $totalIncorrect }}</td>
                <td>{{ $finalScore }}</td>
                <td>{{ $finalPercentage }}</td>
                <td>{{ $formattedTime }}</td>
            </tr>
        @endforeach
    @endif
</tbody>
    </table>
</div> 
            
             <?php
             $ansdata =array();
             $positive = array();
             $negative = array();
             $an3 = array();
            ?>
            <div class="col-md-4" style="">
                <!--<h5>OverAll Section</h5>-->
                <table id="" class="table table-bordered table-responsive myTable ">
                     <thead>
                        <tr>
                            <th colspan="7">OverAll Section</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Attempt</td>
                        <td>Missed</td>
                        <td>Correct</td>
                        <td>InCorrect</td>
                        <td>Score</td>
                        <td>Percentage%</td>
                        <td>Time Taken(sec)</td>
                    </tr>
                </tbody>
                <tbody>
                <?php
               /// $id = $request->id;
        $section_name = 'overall'; 
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
            }
             
            if($section_name =='overall'){
                $reports = DB::table('student_quizes')
                        ->where('test_id',$id)
                        //->where('section_type', 'like', "%$section_name%")
                        ->where('user_id',$user->id)
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
                    foreach($stu_id as $stu_idss){
                       $qid[] =  $stu_idss;   
                    }
                    foreach($stu_ans as $stu_ans){
                       $sid[] =  $stu_ans; 
                    }
                    foreach($timedata as $timedatas)
                    {
                       $timedatasnwe[] =  $timedatas;
                    }
                }
            }
            
            if($section_name == 'overall'){
                 $all_ans = array_filter($sid);
                 $ex_correct = array_map('strtolower', $ex_correct);
                 $all_ans = array_map('strtolower', $all_ans);
                  $acorrect = array_intersect_assoc($ex_correct, $all_ans);
                  
                 //$acorrect = array_intersect_assoc($ex_correct,$all_ans);
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
                if (!is_array($timedatasnwe)) {
    // If it's a JSON string like "[10,20,30]"
    if (is_string($timedatasnwe) && $decoded = json_decode($timedatasnwe, true)) {
        $timedatasnwe = $decoded;
    }
    // If it's a comma-separated string like "10,20,30"
    elseif (is_string($timedatasnwe) && str_contains($timedatasnwe, ',')) {
        $timedatasnwe = explode(',', $timedatasnwe);
    }
    // If it's a single numeric string like "45"
    elseif (is_numeric($timedatasnwe)) {
        $timedatasnwe = [(float) $timedatasnwe];
    }
    // Anything else → make it an empty array
    else {
        $timedatasnwe = [];
    }
}

// Convert all values to numbers just in case
$timedatasnwe = array_map('floatval', $timedatasnwe);

// Now safely sum
$timevalue = array_sum($timedatasnwe);

              
                 //$timevalue =  array_sum($timedatasnwe); 
                 $totime = ($timevalue / 1000);
            }
          
            ?>
            <tr>
                <td>{{count($all_ans)}}</td>
                <td>{{$miss}}</td>
                <td>{{ count($acorrect) }}</td>
                <td>{{ $incorrect }}</td>
                <td>{{ $score }}</td>
                <td>{{ round($per,2) }}</td>
                <td>{{ $totime }}</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
                </table>
            </div> 
            
            <?php
             $ansdata =array();
             $positive = array();
             $negative = array();
             $student_quizes = DB::table('student_quizes')
                        //->whereIn('user_id',$user->id)
                        ->where('test_id',$id)
                        ->get();
            ?>
            <?php
             $verbal_ques = DB::table('excel_questions')
                            ->where('section_name', 'like', "%VERBAL%")
                            ->where('test_id',$id)
                            ->get();
             $nnverbal_ques = DB::table('excel_questions')
                        ->where('section_name', 'like', "%VERBAL%")
                        ->where('test_id',$id)
                        ->get();
             $i = 1;
            ?>

            <div class=" col-md-4" style="">
                <!--<h5></h5>-->
                <table id="" class="table table-bordered table-responsive myTable">
                     <thead>
                        <tr>
                            <th colspan="24">Verbal and Reading Comprehension</th>
                        </tr>
                    </thead>
                    @if(!empty($studentlogs))
                @foreach($studentlogs as $studentlog)
                    <?php
                    $stuques = DB::table('student_quizes')
                                ->where('test_id', $id)
                                ->where('user_id', $studentlog->id)
                                ->where('section_type', 'like', "%VERBAL%")
                                ->first();

                        if($stuques) {
                            $ans = explode(',', $stuques->answer);
                        } else {
                            $ans = []; 
                        }
                    ?>
                    <tbody>
                    <tr class="">
                        @if($i == 1)
                            @foreach($verbal_ques as $verbal_quess)
                                <td>{{$i++}}</td>
                            @endforeach
                        @endif
                    </tr>
                </tbody>
                    <tbody>
                    <tr class="">
                        @foreach($nnverbal_ques as $key => $verbal_quesse)  
                              <?php  if (isset($ans[$key]) && strcasecmp($ans[$key], $verbal_quesse->correct_option) === 0) { ?>
                                    <td>Correct</td>
                               <?php } elseif(empty($ans[$key])) { ?>
                                    <td>Not Attempted </td>
                                <?php } else { ?>
                                    <td>Wrong</td>
                               <?php } ?>
                        @endforeach
                    </tr>
                </tbody>
                @endforeach
                @endif
                </table>
            </div> 
            
            <?php
             $data_ques = DB::table('excel_questions')
                           ->where('section_name', 'like', "%Data%")
                           ->where('test_id',$id)
                           ->get();
            $i = 1;
            ?>
        <div class=" col-md-4" style="">
            <!--<h5></h5>-->
                <table id="" class="table table-bordered table-responsive myTable ">
                     <thead>
                        <tr>
                            <th colspan="20">Data Interpretation & Logical Reasoning</th>
                        </tr>
                    </thead>
                    @if(!empty($studentlogs))
                @foreach($studentlogs as $studentlog)
                    <?php
                        $datastuques = DB::table('student_quizes')
                                        ->where('test_id', $id)
                                        ->where('user_id', $studentlog->id)
                                        ->where('section_type', 'like', "%Data%")
                                        ->first();
                        if($datastuques) {
                            $ans = explode(',', $datastuques->answer);
                        } else {
                            $ans = []; 
                        }
                    ?>
                    <tbody>
                    <tr class="">
                        @if($i == 1)
                            @foreach($data_ques as $verbal_quess)
                                <td>{{$i++}}</td>
                            @endforeach
                        @endif
                    </tr>
                    </tbody>
                    <tbody>
                    <tr class="">
                        @foreach($data_ques as $key => $verbal_quesse) 
                            <?php  if (isset($ans[$key]) && strcasecmp($ans[$key], $verbal_quesse->correct_option) === 0) { ?>
                                 <td>Correct</td>
                            <?php  } elseif(empty($ans[$key])) { ?>
                                 <td>Not Attempted</td>
                            <?php } else { ?>
                                <td>Wrong </td>
                            <?php  }  ?>
                        @endforeach
                    </tr>
                </tbody>
                @endforeach
                @endif
                </table>
            </div> 
        <?php
            $qs_ques = DB::table('excel_questions')
                        ->where('section_name', 'like', "%quantitative%")
                        ->where('test_id',$id)
                        ->get();
            $i = 1;
        ?>
            <div class="col-md-4" style="">
                <!--<h5></h5>-->
                <table id="" class="table table-bordered table-responsive myTable">
                     <thead>
                        <tr>
                            <th colspan="22">Quantitative Aptitude</th>
                        </tr>
                    </thead>
                    @if(isset($studentlogs))
                @foreach($studentlogs as $studentlog)
                    <?php
                    $qsstuques = DB::table('student_quizes')
                        ->where('test_id', $id)
                        ->where('user_id', $studentlog->id)
                        ->where('section_type', 'like', "%quantitative%")
                        ->first();

                        if($qsstuques) {
                            $ans = explode(',', $qsstuques->answer);
                        } else {
                            $ans = [];
                        }
                    ?>
                        @if($i == 1)
                            <tr class="">
                                @foreach($qs_ques as $verbal_quess)
                                    <td>{{$i++}}</td>
                                @endforeach
                            </tr>
                        @endif
                        <tbody>
                            
                        <tr class="">
                            @foreach($qs_ques as $key => $verbal_quesse)
                                <?php  if (isset($ans[$key]) && strcasecmp($ans[$key], $verbal_quesse->correct_option) === 0) { ?>     
                                    <td>Correct</td>
                                <?php } elseif(empty($ans[$key])) { ?>
                                    <td>Not Attempted</td>
                                <?php  } else { ?>
                                    <td>Wrong</td>
                                <?php } ?>  
                            @endforeach
                        </tr>  
                @endforeach
                @endif
                </tbody>
                </table>
            </div> 
        </div>
    </div>
@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script> 


//ALLWORKDONE
$(document).ready(function() {
    $('#downloadExcel').click(function() {
        var tables = $('.myTable');
        var combinedCsv = '';
        var topHeaderText = tables.find('h5').text();
        var headers = [];

        // Center the heading of each table
        tables.each(function(index, table) {
            $(table).find('h5').css('text-align', 'center'); // Center the heading
        });

        // Process each table
        tables.each(function(index, table) {
            var tableHeaders = [];
            $(table).find('thead th').each(function() {
                var colspan = $(this).attr('colspan') || 1;
                var headerText = $(this).text();
                // for (var i = 0; i < colspan; i++) {
                //     tableHeaders.push(headerText);
                // }
                
                if (colspan) {
                    tableHeaders.push(headerText);
                    for (var i = 1; i < colspan; i++) {
                        tableHeaders.push(''); 
                    }
                } else {
                    for (var i = 0; i < colspan; i++) {
                        tableHeaders.push(headerText);
                    }
                }
            });
            headers = headers.concat(tableHeaders);
        });

        // Add top header text as the first row (if applicable)
        if (topHeaderText) {
            combinedCsv += '"' + topHeaderText + '"\n';
        }

        // Add headers row
        combinedCsv += headers.map(function(header) {
            return '"' + header + '"';
        }).join(',') + '\n';

        // Find the maximum number of rows
        var maxRows = Math.max.apply(null, tables.map(function() {
            return $(this).find('tbody tr').length;
        }).get());

        // Add data rows
        for (var i = 0; i < maxRows; i++) {
            var rowArray = [];
            tables.each(function(index, table) {
                var $row = $(table).find('tbody tr').eq(i);
                if ($row.length) {
                    $row.find('td').each(function() {
                        rowArray.push('"' + $(this).text().trim() + '"');
                    });
                } else {
                    for (var j = 0; j < headers.length; j++) {
                        rowArray.push('""');
                    }
                }
            });
            combinedCsv += rowArray.join(',') + '\n';
        }
        // Create a Blob from the CSV string
        var blob = new Blob([combinedCsv], { type: 'text/csv;charset=utf-8;' });
        // Download the file
        var a = document.createElement('a');
        var url = URL.createObjectURL(blob);
        a.href = url;
        a.download = 'student_report.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
});
//END ALL WORK DONE



</script> 







