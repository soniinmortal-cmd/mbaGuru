<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
    
    <style>
   
    .scroll{
        background-color:white;
        height:auto;
         padding:10px;
        margin:8px;
    }
.containerMine{
    background-color:white;
    min-height:76vh;
}
#firstColumn{
    max-height:70vh;
  height:auto;
  width: 58%;
  float:left;
   overflow-y:scroll;
   margin-top:10px;
   padding: 4px;
}

#secondColumn{
    height:auto;
    width: 41%;
    margin-left:53%;
    margin-top:10px;
    padding: 4px;
    overflow-y:scroll;
}
ol li{
  list-style-type: none;
}


 
 .header-content {
            background-color: #006DAA;
            height: 10vh;
            width: full;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }
 
  @media (max-width:550px) {
            .header-content {
                display: block;
                padding: 1rem 2rem;
                height: auto;
            }
        }
    </style>
</head>
<body style="margin: 0%; padding: 0%;">
    <?php
        $id =request()->id;
        $ins = DB::table('instruction')->where('test_id',$id)->orderBy('id', 'DESC')->first();
        $test = DB::table('tests')->where('id',$id)->orderBy('id', 'DESC')->first();
        $section =  request()->sid;
        $paper_id =  request()->paperid;
        $userid =session()->get('id');
       
       
       ///////
          if($section == 'nmat-section1' || $section == 'nmat-section2'){
                
            $max_sr_no = DB::table('half_student_quiz')
              ->where('test_id', $id)
              ->where('user_id', $userid)
              ->where('paper_id', $paper_id)
              ->where('section_name', 'like', "%Quantitative Skills%")
              ->max('sr_no'); 

           $half_quizfor = DB::table('half_student_quiz')
              ->where('test_id', $id)
              ->where('user_id', $userid)
              ->where('paper_id', $paper_id)
              ->where('section_name', 'like', "%Quantitative Skills%")
              ->where('sr_no', $max_sr_no) 
              ->orderBy('id', 'desc')
              ->first();
                                     
            ?>
            <input type ="hidden" name ="last_question" value="{{ isset($half_quizfor) ? $half_quizfor->sr_no :  ''}}" class="last_question">
           <?php                             
            }elseif($section == 'nmat-section3' || $section == 'nmat-section4'){
                
                $max_sr_no = DB::table('half_student_quiz')
                      ->where('test_id', $id)
                      ->where('user_id', $userid)
                      ->where('paper_id', $paper_id)
                      ->where('section_name', 'like', "%Language Skills%")
                      ->max('sr_no'); 
    
               $half_quizfor = DB::table('half_student_quiz')
                          ->where('test_id', $id)
                          ->where('user_id', $userid)
                          ->where('paper_id', $paper_id)
                          ->where('section_name', 'like', "%Language Skills%")
                          ->where('sr_no', $max_sr_no) 
                          ->orderBy('id', 'desc')
                          ->first();
        ?>
             <input type ="hidden" name ="last_question" value="{{ isset($half_quizfor) ? $half_quizfor->sr_no :  ''}}" class="last_question">                     
        <?php
      
          }elseif($section == 'nmat-section5' || $section == 'nmat-section6'){
                $max_sr_no = DB::table('half_student_quiz')
                  ->where('test_id', $id)
                  ->where('user_id', $userid)
                  ->where('paper_id', $paper_id)
                   ->where('section_name', 'like', "%Logical Reasoning%")
                  ->max('sr_no'); 

                $half_quizfor = DB::table('half_student_quiz')
                      ->where('test_id', $id)
                      ->where('user_id', $userid)
                      ->where('paper_id', $paper_id)
                     ->where('section_name', 'like', "%Logical Reasoning%")
                      ->where('sr_no', $max_sr_no) 
                      ->orderBy('id', 'desc')
                      ->first();
        ?>
                                
            <input type ="hidden" name ="last_question" value="{{ isset($half_quizfor) ? $half_quizfor->sr_no :  ''}}" class="last_question">                      
        <?php }?>  
    <div class="form ">
        <form action="" method = "post">
            <input type="hidden" name="test">
            <div class="header-content">
                <h3 style="color: white; ">{{$test->test}}</h3>
                <span style=" color: white; ">
                <h4 style="font-size:1.4rem;">🕒Time Left:
                @if($section == 'nmat-section1')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->qs_time}}"></span>
                @elseif($section == 'nmat-section2')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->qs_time}}"></span>
                @elseif($section == 'nmat-section3')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->language_time}}"></span>
                @elseif($section == 'nmat-section4')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->language_time}}"></span>
                @elseif($section == 'nmat-section5')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->logical_time}}"></span>
                @elseif($section == 'nmat-section6')
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->logical_time}}"></span>
                @else
                <span class="mys countdown"  data-id="{{$test->course_id}}" data-time="{{$section_time->qs_time}}"></span>
                @endif
             </h4>
                <div style="display:flex; ">  
                    <p id="btn1">⊟</p>
                    <p  id="text" class="number newnumber" style=""></p>
                </div>
            </span>
            </div>
            <div style="background-color: #80AEE1; height: 6vh; width: full; display: flex;">
                @if($section == 'nmat-section1')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Quantitative Skills</h5>
                    <input type="hidden" name="section_type" value="Quantitative Skills" class="section"> 
                    <input type="hidden" name="student_duration" value="{{$section_time->qs_time}}">
                @elseif($section == 'nmat-section2')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Quantitative Skills</h5>
                    <input type="hidden" name="section_type" value="Quantitative Skills" class="section">
                    <input type="hidden" name="student_duration" value="{{$section_time->qs_time}}">
                @elseif($section == 'nmat-section3')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Language Skills</h5>
                    <input type="hidden" name="section_type" value="Language Skills" class="section">
                    <input type="hidden" name="student_duration" value="{{$section_time->language_time}}">
                @elseif($section == 'nmat-section4')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Language Skills</h5>
                    <input type="hidden" name="section_type" value="Language Skills" class="section">
                    <input type="hidden" name="student_duration" value="{{$section_time->language_time}}">
                @elseif($section == 'nmat-section5')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Logical Reasoning</h5>
                    <input type="hidden" name="section_type" value="Logical Reasoning" class="section">
                    <input type="hidden" name="student_duration" value="{{$section_time->logical_time}}">
                @elseif($section == 'nmat-section6')
                    <h5 style="color: white;position:absolute;margin-left: 5px;">Logical Reasoning</h5>
                    <input type="hidden" name="section_type" value="Logical Reasoning" class="section">
                    <input type="hidden" name="student_duration" value="{{$section_time->logical_time}}">
                @else
                    <h5 style="color: white;position:absolute;margin-left: 5px;"></h5>
                @endif
            </div>
                <input type="hidden" name="test_id" value="{{$id}}" class="testid">
                <input type="hidden" name="user_id" value="{{$userid}}" class="userid">
                <input type="hidden" name="paper_id" value="{{$paper_id}}" class="paperid">
                <input type="hidden" name="set_type" value="{{$section}}" class="set_type">
            <div  style=" height:auto; width:full;" class="containerMine">
                <?php
                    $i =1;
                    $arr = array();
                   //dd($qs_ques); 
                ?>
                <div class="sloop">
                    @foreach($qs_ques as $qs_quess)
                        <?php
                            $arr[] = $qs_quess->id;
                            $half_quiz = DB::table('half_student_quiz')
                                        ->where('test_id',$id)
                                        ->where('user_id',$userid)
                                        ->where('paper_id',$paper_id)
                                        ->where('sr_no',$i)
                                        ->where('section_name', 'like', "%$qs_quess->section_name%")
                                        ->orderBy('id','desc')
                                        ->first(); 

                        ?>
                        <input type ="hidden"  name ="level[]" value="{{$qs_quess->level}}">   
                        <div class="ques{{$i}} question " style="display:none">    
                            @if(empty($qs_quess->instruction))
                                <!--question-->
                                <div class="scroll">
                                    <p><b>Q{{$i}}</b><?= htmlspecialchars_decode($qs_quess->question) ?></p>
                                    <input type="hidden" name="question_id[]" value="{{$qs_quess->id}}">
                                    @if($qs_quess->question_type == 'multiple' || $qs_quess->question_type == 'MULTI_CHOICE')
                                    <input type="hidden" name="question_type[]" value="multiple">
                                        <ol class="choices">
                                            <li style="display:flex;">
                                                <input type="radio" class="ans re1 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer :  1}}" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}>&nbsp;
                                                <div style="margin-top:15px; margin-left:5px;"><?= htmlspecialchars_decode($qs_quess->option1) ?></div>
                                            </li>
                                            <li style="display:flex;"><input type="radio" class="ans re2 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : 2 }}" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}>&nbsp;
                                            <div style="margin-top:15px; margin-left:5px;"><?= htmlspecialchars_decode($qs_quess->option2) ?></div>
                                            </li>
                                            <li style="display:flex;"><input type="radio" class="ans re3 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : 3 }}" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}>&nbsp;<span style="margin-top:15px; margin-left:5px;"><?= htmlspecialchars_decode($qs_quess->option3) ?></span></li>
                                            <li style="display:flex;"><input type="radio" class="ans re4 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : 4 }}" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}>&nbsp;<span style="margin-top:15px; margin-left:5px;"><?= htmlspecialchars_decode($qs_quess->option4) ?></span></li>
                                            @if($qs_quess->option5)
                                            <li style="display:flex;"><input type="radio" class="ans re5 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : 5 }}" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}>&nbsp;<span style="margin-top:15px; margin-left:5px;"><?= htmlspecialchars_decode($qs_quess->option5) ?></span></li>
                                            @endif
                                        </ol>   
                                    @else
                                        <input class="input-numeric ans re{{$i}} rs{{$i}}" name ="answer[]"  type="nember" />
                                    @endif
                                </div> 
                                <!--endquestion-->
                            @else
                            <!--newquestion-->
                                <div id="firstColumn">
                                    <p> <?= htmlspecialchars_decode($qs_quess->instruction) ?></p>
                                    <input type="hidden" name="question_id[]" value="{{$qs_quess->id}}">
                                </div> 
                                <div id="secondColumn">
                                    <p><b>Q{{$i}}</b><?= htmlspecialchars_decode($qs_quess->question) ?></p>
                                    @if($qs_quess->question_type == 'multiple'|| $qs_quess->question_type == 'MULTI_CHOICE')
                                        <input type="hidden" name="question_type[]" value="multiple">
                                        <ol class="choices">
                                            <li style="display:flex;">
                                                <input type="radio" class="ans re1 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : 1 }}" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}>
                                                <div>&nbsp;<div style="margin-left:10px; margin-top:-4px;"><?= htmlspecialchars_decode($qs_quess->option1) ?></div></div>
                                            </li>
                                            <li style="display:flex;"><input type="radio" class="ans re2 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : 2 }}" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}>&nbsp;<span style="margin-left:10px; margin-top:12px;"><?= htmlspecialchars_decode($qs_quess->option2) ?></span></li>
                                            <li style="display:flex;"><input type="radio" class="ans re3 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : 3 }}" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}>&nbsp;<span style="margin-left:10px; margin-top:12px;" ><?= htmlspecialchars_decode($qs_quess->option3) ?></span></li>
                                            <li style="display:flex;"><input type="radio" class="ans re4 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : 4 }}" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}>&nbsp;<span style="margin-left:10px; margin-top:12px;"><?= htmlspecialchars_decode($qs_quess->option4) ?></span></li>
                                            @if($qs_quess->option5)
                                            <li style="display:flex;"><input type="radio" class="ans re5 rs{{$i}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : 5 }}" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}>&nbsp;<span style="margin-left:10px; margin-top:12px;"><?= htmlspecialchars_decode($qs_quess->option5) ?></span></li>
                                            @endif
                                        </ol>
                                    @else
                                        <input class="input-numeric ans re{{$i}} rs{{$i}}" name ="answer[]"  type="nember" />
                                    @endif
                                </div>
                                <!--newendquestion-->
                            @endif
                        </div>
                        <?php $i++; ?>
                    @endforeach
                    <input type="hidden" id="output" name="ans_duration" value="">
                </div>
                <!--start-->
                <?php $j =1; ?>
                <div style="display:none;">
                    <div id="divs" data-vt="{{$qs_ques}}">
                        @foreach($qs_ques as $qs_quess)
                        <div class="sel{{$j}}  ssm">
                            <?php $j++; ?>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--end--> 
                <input type="hidden" class="new-all" data-new-all="{{count($arr)}}">
            </div>
            </div>
            
            
             @if($section == 'nmat-section1')
                    <input type="hidden" name="nextdata" class="nextdata" value="Language Skills">
                @elseif($section == 'nmat-section2')
                  <input type="hidden" name="nextdata" class="nextdata" value="Logical Reasoning">
                @elseif($section == 'nmat-section3')
                  <input type="hidden" name="nextdata" class="nextdata" value="Quantitative Skills">
                @elseif($section == 'nmat-section4')
                  <input type="hidden" name="nextdata" class="nextdata" value="Logical Reasoning">
                 @elseif($section == 'nmat-section5')
                  <input type="hidden" name="nextdata" class="nextdata" value="Language Skills">
                @elseif($section == 'nmat-section6')
                  <input type="hidden" name="nextdata" class="nextdata" value="Quantitative Skills">
                @endif
                
            <div>
            <div style="background-color: #006DAA; height:8vh;  width: full;">
                <a class="btn btn-primary btn-md newnext" style="float:right; margin:10px 10px 0 0;" data-all ="{{count($arr)}}">NEXT</a>
                @if($section == 'nmat-section1')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section1" data-next="Language Skills">Submit</a>
                @elseif($section == 'nmat-section2')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section2" data-next="Logical Reasoning">Submit</a>
                @elseif($section == 'nmat-section3')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section3" data-next="Quantitative Skills">Submit</a>
                @elseif($section == 'nmat-section4')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section4" data-next="Logical Reasoning">Submit</a>
                @elseif($section == 'nmat-section5')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section5" data-next="Language Skills">Submit</a>
                @elseif($section == 'nmat-section6')
                <a class="btn btn-primary btn-md submitbtn" style="float:right; margin:10px 10px 0 0; display:none;" data-section="nmat-section6" data-next="Quantitative Skills">Submit</a>
                @else
                @endif
            </div>
            <input type="hidden" name="newtest">
        </form>
    </div>
<!--edittestmodal -->
<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content" style="background-color: #006DAA;">
         <div class="modal-header">
            <h4 class="modal-title" style="color:white;">Answer Required</h4>
            <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
         </div>
         <div class="modal-body">
         <p><center style="color:white;"> In order to proceed to the next question, you must mark an answer to this question.</center></p>
         </div>
         <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-primary" id="butedit">Edit</button> -->
            <center><button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #006DAA; color:white;">OK</button></center>
         </div>
      </div>
   </div>
</div>
<!--endeditmodal--->
    <script type="text/javascript" src="{{asset('assets/admin/js/nmat-quiz.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#btn1").click(function () {
                $('#text').toggle();
            });
        });
    </script>
<script>
//startnewtimer
// $(document).ready(function() {
//   $('.sel1').addClass('selected');
//    var divs = $('#divs > div');
//    output = $('#output');
//    var arr = $('#divs').attr('data-vt');
//    var sert1 = [];
//    $.each(JSON.parse(arr), function(index, value) {
//       var sert = 0;
//       sert1.push(sert);
//    });

// if(typeof localStorage.getItem("tarr") !== 'undefined' && localStorage.getItem("tarr")!= null){  
//       tarr =  localStorage.getItem("tarr").split(',');         
// } else {
//     tarr = sert1;
// }
// //tarr = sert1; 
// delay = 1000;
// divs.click(function() {
//   $(this).addClass('selected').siblings().removeClass('selected');
// });
// setInterval(function() {
//   localStorage.setItem("tarr", tarr);
//    var idx = divs.filter('.selected').index();
//       tarr[idx] = parseInt(tarr[idx]) +delay;
//       output.val(tarr);
//    }, delay);
// });

$(document).ready(function() {
  $('.sel1').addClass('selected');
 // $('.selr'). ('selected');
 var divs = $('#divs > div');
 var output = $('#output');
 var arr = $('#divs').attr('data-vt');
 var sert1 = [];
    $.each(JSON.parse(arr), function(index, value) {
        var sert = 0;
        sert1.push(sert);
    });
    tarr = sert1;
    delay = 1000;
    divs.click(function() {
        $(this).addClass('selected').siblings().removeClass('selected');
    });
    setInterval(function() {
        var idx = divs.filter('.selected').index();
        tarr[idx] = parseInt(tarr[idx])+ delay;
        output.val(tarr);
    }, delay);
});

//endnewtimer
//time save data
var  crtt = 1;
$(document).ready(function() {
    $('.newnext').on('click', function() {
        crtt +=1; 
        $('.ssm').removeClass('selected');
        $('.sel'+crtt).addClass('selected');
    })
})
 // end time save data
</script>
<script>
$(document).ready(function(event) {
   var newall =  $('.new-all').attr('data-new-all');
        $('.number').text('1 of '+newall);
        var lastques = $('.last_question').val();
        console.log(lastques);
        if(lastques){
             $('.ques'+lastques).css('display','block');
        }else{
             $('.ques1').css('display','block');
        }
       
        $('.ans').click(function(){
            var val = $(this).attr('data-value');
            var isCheck =  $(this).is(":checked");
            if(isCheck == true){
                $('.newnext').click(function(){
                    var newval = parseInt(val)+1;
                    var ctn = $(this).attr('data-all');
                    $('.number').text(newval+' of '+newall);
                    $('.question').css('display','none');
                    $('.ques'+newval).css('display','block');
                    if(newval == ctn) {
                        $('.submitbtn').css('display','block');
                        $('.newnext').css('display','none');
                    }
                    //savehalfquiz
                    var sr_no = [newval - 1];
                    var section_name = [$('.section').val()];
                    var test_id = [$('.testid').val()];
                    var user_id = [$('.userid').val()];
                    var paper_id = [$('.paperid').val()];
                    var set_type = [$('.set_type').val()];
                    var ansset = newval-1;
                   console.log(ansset,"ansset");
                        var answer = $('.rs'+ansset).filter(':checked').map(function() {
                            return this.value;
                        }).get();
        //console.log(answer,"answer");
                        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        });
                        $.ajax({
                            url: 'https://test.mbaguru.in/student/savenmatnexthalfquiz',
                            type: "POST",
                            data: {
                            test_id: test_id,
                            paper_id: paper_id,
                            section_name: section_name,
                            user_id: user_id,
                            answer: answer,
                            sr_no: sr_no,
                            set_type: set_type
                            },
                            cache: false,
                            success: function(dataResult){
                                if(dataResult.statusCode==200){
                                    console.log(dataResult,"success");
                                }
                                else if(dataResult.statusCode==201){
                                     console.log("failed");
                                }
                            }
                        });
                    //endsave
                })
            }
        })  
})

$(document).ready(function(event) {
    var val= $('input[type="radio"]:checked').val();
    var newall =  $('.new-all').attr('data-new-all');
    $('.number').text('1 of '+newall);
    var lastques = $('.last_question').val();
    console.log(lastques);
    if(lastques){
         var ct = parseInt(lastques);;
    }else{
        var ct = 1;
    }
    //var ct = 1;
    var cty = 0
    $('.newnext').click(function(){
            ct += 1;
            cty += 1;
            let isChecked = $('.rs'+cty).is(':checked');
            if(isChecked == true)
            { 
                //console.log(isChecked,"isChecked");
                var ctn = $(this).attr('data-all');
                var ctn = $(this).attr('data-all');
                $('.question').css('display','none');
                $('.ques'+ct).css('display','block');
                $('.number').text(ct+' of '+newall);
                if(ct == ctn) {
                    $('.submitbtn').css('display','block');
                    $('.newnext').css('display','none');
                }
                //savehalfquiz
                var sr_no = [ct - 1];
                var section_name = [$('.section').val()];
                var test_id = [$('.testid').val()];
                var user_id = [$('.userid').val()];
                var paper_id = [$('.paperid').val()];
                var set_type = [$('.set_type').val()];
                var ansset = ct-1;
               // console.log(ansset,"ansset");
                    var answer = $('.rs'+ansset).filter(':checked').map(function() {
                        return this.value;
                    }).get();
                var sid = $(this).attr('data-section');
                var nextid = $(this).attr('data-next');
                
             // console.log(answer,"ansset");
                
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    url: 'https://test.mbaguru.in/student/savenmatnexthalfquiz',
                    type: "POST",
                    data: {
                    test_id: test_id,
                    paper_id: paper_id,
                    section_name: section_name,
                    user_id: user_id,
                    answer: answer,
                    sr_no: sr_no,
                    set_type: set_type
                    },
                    cache: false,
                    success: function(dataResult){
                    
                        if(dataResult.statusCode==200){
                            console.log('success');
                        }
                        else if(dataResult.statusCode==201){
                             console.log('failed');
                        }
                    }
                });
                //endsave
            }
        //}
    })
})
</script>
<script>
//newtime old
    // $(document).ready(function(event) {
    //         var datatime = $('.countdown').attr('data-time'); 
    //          var id = $('.countdown').attr('data-id'); 
    //         var timer2 = datatime+":0";
    //       // var timer2 = "00:10";
    //         var interval = setInterval(function() {
    //         var timer = timer2.split(':');
    //         //by parsing integer, I avoid all extra string processing
    //         var minutes = parseInt(timer[0], 10);
    //         var seconds = parseInt(timer[1], 10);
    //     --seconds;
    //     minutes = (seconds < 0) ? --minutes : minutes;
    //         if (minutes < 0) clearInterval(interval);
    //             if(minutes == 0 && seconds ==0){
    //                 // var url = "{{ route('student.start-test', [':id']) }}";
    //                 // url = url.replace(':id', id);
    //                 // window.location.href=url;
                    
    //                     var test_id = $('.testid').val();
    //                     var paper_id = $('.paperid').val();
    //                     var sid = $('.set_type').val();
    //                     var nextid = $('.nextdata').val();
    //                     var datastring = $("form").serialize();
                          
    //                         $.ajaxSetup({
    //                             headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                             }
    //                         });
    //                         $.ajax({
    //                             method: 'POST', 
    //                             url: 'https://test.mbaguru.in/student/savequizedata',
    //                             data: JSON.stringify(datastring),
    //                             success: function(response){
    //                               // console.log(response.message);
    //                                     var url = "{{ route('student.nmat-next-page', [':id',':paperid',':sid',':nextid']) }}";
    //                                     url = url.replace(':id', test_id);
    //                                     url = url.replace(':paperid', paper_id);
    //                                     url = url.replace(':sid', sid);
    //                                     url = url.replace(':nextid', nextid);
    //                                     window.location.href=url;
    //                                 },
    //                                 error: function(jqXHR, textStatus, errorThrown) { 
    //                                     console.log(JSON.stringify(jqXHR));
    //                                     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    //                                 }
    //                         });

    //             }
    //     seconds = (seconds < 0) ? 59 : seconds;
    //     seconds = (seconds < 10) ? '0' + seconds : seconds;
    //     //minutes = (minutes < 10) ?  minutes : minutes;
        
    //     if(minutes == -1 && seconds ==59){
    //         $('.countdown').html('0:00'); 
    //     }else{
    //         $('.countdown').html(minutes + ':' + seconds);
    //     }
    //         if(minutes > 0 && seconds <=59){
    //             document.onkeydown = function (e) {
    //             return false;
    //             }
    //             if(minutes > 0 || seconds <=59){
    //             window.location.reload();
    //                 window.stop();
                        
    //             }
    //         }
    //         timer2 = minutes + ':' + seconds;
    //         }, 1000);
    //     });
//endnewtime old
    
//newtime new  correct timer
$(document).ready(function() {
    var datatime = $('.countdown').attr('data-time'); 
    var id = $('.countdown').attr('data-id'); 
    var timer2 = datatime + ":0";

    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);

        if (minutes == 0 && seconds == 0) {
            var test_id = $('.testid').val();
            var paper_id = $('.paperid').val();
            var sid = $('.set_type').val();
            var nextid = $('.nextdata').val();
            var datastring = $("form").serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST', 
                url: 'https://test.mbaguru.in/student/savequizedata',
                data: datastring,
                success: function(response){
                    var url = "{{ route('student.nmat-next-page', [':id',':paperid',':sid',':nextid']) }}";
                    url = url.replace(':id', test_id);
                    url = url.replace(':paperid', paper_id);
                    url = url.replace(':sid', sid);
                    url = url.replace(':nextid', nextid);
                    window.location.href = url;
                },
                error: function(jqXHR, textStatus, errorThrown) { 
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        
        if (minutes < 0) {
            $('.countdown').html('0:00'); 
        } else {
            $('.countdown').html(minutes + ':' + seconds);
        }

        if (minutes > 0 && seconds <= 59) {
            document.onkeydown = function(e) {
                return false;
            }
        }

        timer2 = minutes + ':' + seconds;
    }, 1000);
});
//endnewtime new

    
    //startrightclick
    // $(window).on('keydown',function(event)
    //  {
    //    if(event.keyCode == 116){
    //        return false;
    //    }
    //    if(event.keyCode == 17){
    //       return false; 
    //    }else if(event.keyCode == 16){
    //        return false;
    //    }else if(event.keyCode == 82){
    //        return false;
    //    }
    //  if(event.keyCode==123)
    //  {
    //      return false;
    //  }
    //  else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
    //  {
    //      return false;  //Prevent from ctrl+shift+i
    //  }
    //  else if(event.ctrlKey && event.keyCode==73)
    //  {
    //     // alert('Entered ctrl+shift+i')
    //      return false;  //Prevent from ctrl+shift+i
    //  }
    // });
    //     $(document).on("contextmenu",function(e)
    // {
    //     return false;
    // });
    //endrightclick
    //stop cut copy past
    </script> 
<script>
    // $(document).ready(function(){
    //     $('.row').on("cut copy paste",function(e) {
    //         e.preventDefault();
    //     });
    // });
    // (function($){
    //     $.fn.disableSelection = function() {
    //     return this
    //             .attr('unselectable', 'on')
    //             .css('user-select', 'none')
    //             .on('selectstart', false);
    //     };
    // })(jQuery);
    // $('body').disableSelection();
    </script>  
    
<script>
//old submit quiz
//$(document).ready(function () {
//         $(".submitbtn").click(function(event){ 
//             event.preventDefault();
//             var sid = $(this).attr('data-section');
//             var nextid = $(this).attr('data-next');
//             var test_id = $('.testid').val();
//             var paper_id = $('.paperid').val();
//             var datastring = $("form").serialize();
//             $.ajaxSetup({
//             headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//             });
//             $.ajax({
//             method: 'POST', 
//             url: 'https://test.mbaguru.in/student/savequizedata',
//             data: JSON.stringify(datastring),
//             success: function(response){
//           // console.log(response.message);
//                 var url = "{{ route('student.nmat-next-page', [':id',':paperid',':sid',':nextid']) }}";
//                 url = url.replace(':id', test_id);
//                 url = url.replace(':paperid', paper_id);
//                 url = url.replace(':sid', sid);
//                 url = url.replace(':nextid', nextid);
//                 window.location.href=url;
//             },
//             error: function(jqXHR, textStatus, errorThrown) { 
//             console.log(JSON.stringify(jqXHR));
//             console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//             }
//         });
//         });
// });
//end old submit quiz

//new submit quiz
    $(".submitbtn").click(function(event) { 
        event.preventDefault();
        var sid = $(this).attr('data-section');
        var nextid = $(this).attr('data-next');
        var test_id = $('.testid').val();
        var paper_id = $('.paperid').val();
        var datastring = $("form").serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST', 
            url: 'https://test.mbaguru.in/student/savequizedata',
            data: datastring,
            success: function(response){
                var url = "{{ route('student.nmat-next-page', [':id',':paperid',':sid',':nextid']) }}";
                url = url.replace(':id', test_id);
                url = url.replace(':paperid', paper_id);
                url = url.replace(':sid', sid);
                url = url.replace(':nextid', nextid);
                window.location.href = url;
            },
            error: function(jqXHR, textStatus, errorThrown) { 
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });
//end new submit quiz

</script>  
<script>
    var i = 0;
    $('.newnext').click(function(){
        i+=1;
        var rs = $('.rs'+i).is(':checked');
        if(rs == false){
            i -=1;
            $("#myModal").modal();
        }
    })
</script>
</body>
</html>
