@extends('student_template')
@section('css')
  <style>
    body {
      background-color: rgb(249, 242, 242);
    }

    .dropdown-menu {
      width: 100%;
      max-height: 220px;
      overflow-y: auto;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 15px;
      transition: background-color 0.2s;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }

    .dropdown-item input[type="checkbox"] {
      margin: 0;
      accent-color: crimson;
      pointer-events: none; /* Prevent direct checkbox click */
    }

    .dropdown-item.selected {
      background-color: #fddede;
      color: #b02a37;
      font-weight: 500;
    }

    .dropdown-toggle::after {
      margin-left: auto;
    }

    .custom-thead {
    background-color: #9b2c2c !important;
    color: white;
}

.custom-thead th {
    color: white !important;
    background-color: #9b2c2c !important;
    border: 1px solid #ffffff !important;
    text-align: center;
}
.custom-tbody td{
   text-align: center;
}
  </style>
@endsection
@section('content')
    <div class="col-md-9 bg-light py-3" id="right-menu-bar">
        <div id="topbar-right-menu" class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <!-- <h5 class="fw-bold text-capitalize">Test Analysis(AIRCATs)</h5> -->
        </div>
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label fw-bold">Choose Section</label>
                    <select class="form-control" name ="section_id" id="section-dropdown">
                        <option value="overall">Overall</option>
                        <option value="Verbal">Verbal Ability and Reading Comprehension</option>
                        <option value="Data">Data Interpretation & Logical Reasoning</option>
                        <option value="Quantitative">Quantitative Aptitude</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label fw-bold">Choose Level</label>
                    <select class="form-control" name ="diff_id" id="diff-dropdown">
                        {{-- <option>Choose Difficulty Level</option> --}}
                        <option value="overall">Overall</option>
                        <option value="EASY">Easy</option>
                        <option value="MEDIUM">Intermediate</option>
                        <option value="INTENSE">Difficult</option>
                        <option value="TITA">TITA</option>
                       
                    </select>
                </div>
            </div>
        </div>
            <div class="row my-4">
             <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive table-bordered custom-table rounded-2">
                        <table class="table table-bordered  rounded-2" >
                                <thead class="custom-thead" style= "background-color: #9b2c2c !important; color: white;">
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Total Questions</th>
                                        <th>Attempted</th>
                                        <th>Correct</th>
                                        <th>Score</th>
                                        <th>Accuracy</th>
                                    </tr>
                                </thead>
                                <tbody class="mytable custom-tbody"> </tbody>  

                                <tbody class="mytablenew custom-tbody"> 
                                    <?php
                                        $userid =session()->get('id');
                                        $course = DB::table('testuploading')
                                                    ->where('title', 'like', "%AIRCAT%")
                                                    ->first('id');

                                        $test = DB::table('tests')
                                                ->where('course_id',$course->id)
                                                ->get();
                                    ?>
                                    @foreach($test as $testss)
                                    <?php
                                     $extest1 = DB::table('excel_questions')
                                                ->where('test_id', $testss->id)
                                                 ->where('section_name', 'like', "%VERBAL%")
                                                ->get();  
                                    $ex_correct1 = array();
                                    $positive1 = array();
                                    $negative1 = array();
                                    foreach($extest1 as $key=>$tests)
                                        {
                                            $ex_correct1[] = $tests->correct_option;
                                            $positive1[] = $tests->positive_mark;
                                            $negative1[] = $tests->negative_mark; 
                                        }
                                        $extest2 = DB::table('excel_questions')
                                                ->where('test_id', $testss->id)
                                                 ->where('section_name', 'like', "%DATA%")
                                                ->get();  
                                    $ex_correct2 = array();
                                    $positive2 = array();
                                    $negative2 = array();
                                    foreach($extest2 as $key=>$tests)
                                        {
                                            $ex_correct2[] = $tests->correct_option;
                                            $positive2[] = $tests->positive_mark;
                                            $negative2[] = $tests->negative_mark; 
                                        }
                                        
                                        
                                    $extest3 = DB::table('excel_questions')
                                                ->where('test_id', $testss->id)
                                                ->where('section_name', 'like', "%QUANTITATIVE%")
                                                ->get();  
                                                
                                    $ex_correct3 = array();
                                    $positive3 = array();
                                    $negative3 = array();
                                    foreach($extest3 as $key=>$tests)
                                        {
                                            $ex_correct3[] = $tests->correct_option;
                                            $positive3[] = $tests->positive_mark;
                                            $negative3[] = $tests->negative_mark; 
                                        }
                                      $ex_correct = array_merge($ex_correct1,$ex_correct2,$ex_correct3);  
                                      $positive = array_merge($positive1,$positive2,$positive3);  
                                      $negative = array_merge($negative1,$negative2,$negative3);
                                       
                                       
                                    $stu_test = DB::table('student_quizes')
                                            ->where('test_id', $testss->id)
                                            ->where('user_id',$userid)
                                            ->get();
                                    
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
                                        $proarr[] = $newAns1;
                                        $result12 = array();
                                        foreach ($stu_leve as $key => $value) {
                                                $result12[$key] =  $newAns1[$key]; 
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
                                     // $stu_an = $newwwresult;
                                        $newstuans[] = $stu_an;
                                        $newstuans1[] = $result12;
                                        foreach ($ex_correct as $key => $value) {
                                            if (isset($stu_an[$key]) && $value == $stu_an[$key]) {
                                                $newcorrectans[$key] = $stu_an[$key];
                                            
                                            }
                                            if (isset($stu_an[$key]) && $value != $stu_an[$key]) {
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
                                    foreach ($stu_level1 as $index => $value) 
                                    {
                                        $valuesFromArray2[] = $newAns[$index];  
                                    }
                                    $totalquestion = array();
                                    foreach ($stu_level1 as $value) {
                                            $totalquestion[] = $value;
                                    }

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
                                    foreach ($ex_correct as $key => $value) {
                                        if (isset($stu_ann[$key]) && $value == $stu_ann[$key]) {
                                            $newcorrectans1[$key] = $stu_ann[$key];
                                        
                                        }
                                        if (isset($stu_ann[$key]) && $value != $stu_ann[$key]) {
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
                                        
                                        $combinedArrayynew_lower = array_map('strtolower', array_change_key_case($combinedArrayynew, CASE_LOWER));
                                        $ex_correct_lower = array_map('strtolower', array_change_key_case($ex_correct, CASE_LOWER));
                     
                                        $procrt = array_intersect_assoc($combinedArrayynew_lower, $ex_correct_lower);

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


                                        //newoverwithiem
                    $totalquestion12 = array(); 
                    foreach ($stu_level as $array) {
                        foreach ($array as $value) {
                          
                                $totalquestion12[] = $value;
                 
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
                    $newresult = array_intersect_assoc($combinedArrayy2, $ex_correct);
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
                if(count($combinedData) != 0){               
                    echo'<tr><td>'.$testss->test.'</td><td>'.count($combinedData).'</td><td>'. count(array_filter($combinedData1)).'</td><td>'.count($procrt).'</td><td>'.$iemscoreo.'</td>';
                    echo'<td>'.$perrr.'</td></tr>';
                }                       
               ?>
            @endforeach 
                                </tbody>
                        </table>
                    </div>
                </div>
             </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

<script>
// $('#section-dropdown').on('change', function () {
//       $('.mytablenew').empty();
//     $('.mytablenew').css('display','none'); 
   
//     $('.mytable').empty();
//     $('#diff-dropdown').val('');
//     var section_id = this.value;
    
//     $('#diff-dropdown').on('change', function () {
       
//         var diff_id = this.value;
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         $.ajax({
//             url: "{{route('student.fetch-accross')}}",
//             type: "POST",
//             data: {
//                 section_id: section_id,
//                 diff_id: diff_id,
//             },
//             dataType: 'json',
//             success: function (result) {
//                 $('.mytable').empty();
//                 $('.mytable').append(result.var_1);
//                 // location.reload();
//             }
//         });
//     });
// });

// $('#diff-dropdown').on('change', function () {  
//       $('.mytablenew').empty();
//       $('.mytablenew').css('display','none'); 
//             $('.mytable').empty();
          
//           // $('#diff-dropdown').val('');
//             //$('.mytablenew').empty();
//         var diff_id = this.value;
//         var section_id = 'overall';
//         //alert(section_id);
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         $.ajax({
//             url: "{{route('student.fetch-accross')}}",
//             type: "POST",
//             data: {
//                 section_id: section_id,
//                 diff_id: diff_id,
//             },
//             dataType: 'json',
//             success: function (result) {
//                 $('.mytable').empty();
//                 $('.mytable').append(result.var_1);
//                 // location.reload();
//             }
//         });
// });

$(document).ready(function() {
    var section_id = 'overall';
    $('#section-dropdown').on('change', function () {
         $('#diff-dropdown').val('');
        section_id = this.value;
        resetTables();
    });

    $('#diff-dropdown').on('change', function () {
        var diff_id = this.value;
        if (section_id === '') {
            section_id = 'overall'; 
        }
        resetTables();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('student.fetch-accross')}}",
            type: "POST",
            data: {
                section_id: section_id,
                diff_id: diff_id,
            },
            dataType: 'json',
            success: function (result) {
                $('.mytable').empty();
                $('.mytable').append(result.var_1 || '<p>No data found</p>'); 
            }
        });
    });

    function resetTables() {
        $('.mytablenew').empty().css('display', 'none');
        $('.mytable').empty();
        // Optionally reset the diff-dropdown value
    }
});

</script>



{{-- <script>
    $(document).ready(function(){
       $('.mytablenew').css('display','block'); 
      $('.newtb').css('display','block');
    })
</script> --}}

@endsection
