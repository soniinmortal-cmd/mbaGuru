@extends('student_template')

@section('css')
@endsection
@section('content')
<?php
    $sid =request()->sid;
    $testid =request()->id;
    $paper_id =request()->paperid;
    $userid = session()->get('id');
    $review = DB::table('ansmark_review')
            ->where('user_id',$userid)
            ->where('test_id',$testid)
            ->where('paper_id',$paper_id)
            ->where('ans_review',1)
            ->where('section_name',$sid)
            ->get();
            
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
   // dd($exploded_array);
?>
<div class="col-md-12" id="">
    <div class="container-fluid">
            <div class="row"> 
                <div class="col-sm-1" style="padding-left:80px;">
                   <!--  <button class="rounded-circle shadow-lg p-2 mb-5 bg-white rounded btn">
                        <i class='fas fa-angle-double-left' style='font-size:18px'></i>
                    </button> -->
                </div>
                <div class="col-sm-3">
                    <!--<h6 style="margin-top:8px;">TEST</h6> -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-6 mx-auto" style="margin-top:120px;">
                    <div class="card bg-white py-4 px-2 display-box-data">
                        <h4 style="text-align:center">Submit Quiz</h4>
                        <!-- <p style="text-align:center; font-size:12px;">Before you submit the test, please make sure you have attended all the question</p> -->
                        <p style="text-align:center; font-size:12px;">Please make sure you have attempted all the questions</p>
                        <table class="table w-100 table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Total Questions</th>
                                <th>{{$question}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><i class="fa fa-circle" style="color:green"></i>&nbsp;Answered</td>
                                <td>{{$show_answer}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle" style="color:red"></i>&nbsp;Skipped / Not attempted</td>
                                <td>{{$non_answer}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle" style="color:purple"></i>&nbsp;Marked for review</td>
                                <td>{{count($review)}}</td>
                            </tr>
                            </tbody>                        
                        </table>
                            <?php
                                $paperid = request()->paperid;
                             ?>
                            @if((in_array('verbal', $exploded_array)) && (in_array('data', $exploded_array)) && (in_array('quantitative', $exploded_array)))
                          
                                @if($sid == 'data')
                                    <a class="btn starttest"  href="{{route('student.data-quiz',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @elseif($sid == 'quantitative')
                                    <a class="btn starttest"  href="{{route('student.quantitative-quiz',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @elseif($sid == 'report')
                                    <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                             
                            @elseif((in_array('verbal', $exploded_array)) && (in_array('data', $exploded_array)))
                             
                                   @if($sid == 'data')
                                   <?php
                                   $sid = 'data';
                                   ?>
                                    <a class="btn starttest"  href="{{route('student.data-quiz',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                  @elseif($sid == 'quantitative')
                                    <?php
                                        $sid = 'report';
                                    ?>
                                   <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                            @elseif((in_array('verbal', $exploded_array)) && (in_array('quantitative', $exploded_array)))
                              @if($sid == 'data')
                                   <?php
                                   $sid = 'quantitative';
                                   ?>
                                    <a class="btn starttest"  href="{{route('student.quantitative-quiz',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                  @elseif($sid == 'report')
                                    <?php
                                        $sid = 'report';
                                    ?>
                                   <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                            @elseif((in_array('data', $exploded_array)) && (in_array('quantitative', $exploded_array)))
                              @if($sid == 'quantitative')
                                   <?php
                                   $sid = 'quantitative';
                                   ?>
                                    <a class="btn starttest"  href="{{route('student.quantitative-quiz',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                  @elseif($sid == 'report')
                                    <?php
                                        $sid = 'report';
                                    ?>
                                   <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                                
                           
                            @elseif(in_array('verbal', $exploded_array))
                                 @if($sid == 'data')
                                   <?php
                                   $sid = 'report';
                                   ?>
                                <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                            @elseif(in_array('data', $exploded_array))
                                 @if($sid == 'quantitative')
                                   <?php
                                   $sid = 'report';
                                   ?>
                                <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                                @endif
                            @elseif(in_array('quantitative', $exploded_array))
                              @if($sid == 'report')
                                   <?php
                                   $sid = 'report';
                                   ?>
                                <a class="btn starttest"  href="{{route('student.report',['sid'=>$sid,'id'=>$testid,'paperid'=>$paperid])}}" style="background-color:maroon; color:white">SUBMIT</a>
                              @endif
                        @endif
                    </div>
                 
            </div>
        </div>
    </div>
</div>
@endsection
@section('css') 
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // window.onload = function() {
    //      window.history.pushState(null, null, window.location.href);
    // };  
    // window.onpopstate = function(event) {
    //     const confirmation = confirm("Are you sure you want to go back?");
    //     if (confirmation) {
    //         window.location.href = "https://inmortaltechnologies.com/mbaguru/student/dashboard"; 
    //     } else {
    //         window.history.pushState(null, null, window.location.href);
    //     }
    // };

    window.addEventListener('beforeunload', () => {
        console.log('User clicked back button');
     });
</script>
    
<script>
    $(document).ready(function() {
        $('.starttest').click(function(){
            localStorage.clear();
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Check if the page has been refreshed before
        if (!localStorage.getItem('pageRefreshed')) {
            // Set the flag in localStorage
            localStorage.setItem('pageRefreshed', 'true');
            // Refresh the page
            location.reload();
        }
    });
</script>
