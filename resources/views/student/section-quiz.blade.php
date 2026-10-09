@extends('student_template')
@section('css')
@endsection
@section('content')
<?php
   $quizeid1 = 1;
   $quizeid2 = 2;
   $data ='overall';
   $paperid =request()->paperid;
   ?>
<style>
   .data{
   padding:5px;
   margin:5px;
   width: 100%;
   height:470px;
   overflow-y: auto;
   overflow-x: hidden;
   text-align:justify;
   }

   .scroll-content{
      width:94%;
   }
   /* FOR CHECKBOX */
   input[type="radio"] {
       border:2px solid black;
    }
/*    .choices {*/
/*  position: absolute;*/
/*  z-index: -1;*/
/*}*/
/*.list-group-item{*/
/*    width:800px;*/
/*}*/

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{asset('assets/admin/css/keyboard.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/numeric-keypad.css')}}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<!--<input type="text" id="addressBar" placeholder="Click here to test">-->
<?php
$id = request()->id;
  $sectiontests = DB::table('test_sections')
                ->where('test_id',$id)
                ->get();
   $i=1;
   $k = 1;
   $allsection = array();
   foreach($sectiontests as $sectiondetail)
   {
      $allsection[] =  $sectiondetail->section_name;
   }
?>
<div class="all-quiz">

 <!--startverbalsection-->
   
    <div class ="verbal-formdata">
      <form action="" class="verbal" method = "post">
         <div class="col-md-12">
            <?php
               $id =request()->id;
               $section_name =request()->section_name;
               $userid =session()->get('id');
               $tests = DB::table('tests')->where('id',$id)->first(); 
               $userdata = DB::table('studentlogs')->where('id',$userid)->first(); 
               $test_templates = DB::table('test_templatevalues')->where('temp_id',$tests->testtempid)->first();
               $quiz_duration = DB::table('quiz_durations')->where('test_id',$id)->orderBy('id','desc')->first();
               ?>
            <div class="container-fluid verbal">
               <input type="hidden" name="test">
               <div class="w-100 row" style="border-bottom:2px solid grey;">
                  <div style="border-right:1px solid lightgrey; width:1%; float:left">
                     <!--<button class="btn btn-default iconclose" data-toggle="modal" data-target="#exit"><i class="fa fa-close"></i></button>-->
                     <a class="btn btn-default cls clrn" style="margin-left:-20px;"><i class="fa fa-close" aria-hidden="true"></i></a>
                  </div>
                  <div style="width:76%; float:left; padding-top:5px; border-right:2px solid lightgrey;">
                     <h6 style=" width:14%; float:left;">{{$tests->test}}{{$tests->testincid}}</h6>
                      <!--<a type="button my-2" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">+2 SECTIONS</a>-->
                      <a type="button my-2" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">{{ count($allsection) }} SECTIONS</a>
                      
                     <h6 style="float:right;">
                        Time :
                        <!-- <span id="timer"></span> -->
                        <?php
                         $m =1;
                         $half_quiz = DB::table('half_student_quiz')
                                    ->where('test_id',$id)
                                    ->where('user_id',$userid)
                                    ->where('paper_id',$paperid)
                                   // ->where('section_name', 'like', "%$section_name%")
                                    ->orderBy('id','desc')
                                    ->first();  
                                    //dd($quiz_duration);
                                    
                       ?>
                        <!--<span class="countdown" data-time="{{$quiz_duration->all_duration}}"></span>-->
                        @if(!empty($half_quiz->ans_duration))
                            <span class="countdown" data-time="{{$half_quiz->ans_duration}}"></span>
                        @else
                           <span class="countdown" data-time="{{$quiz_duration->all_duration}}"></span>
                        @endif
                     </h6>
                  </div>
                   <div style="width:13%; float:left;">
                     <h6 style="PADDING-TOP:4PX;">{{$userdata->email}}</h6>
                  </div>
               </div>
               <div class="form">
                    <div class="tab-content" >
                        <?php
                          $n =1;
                        ?>
                         @foreach($sectiontests as $index => $test_section)
                        <?php
                            $verbal_ques = DB::table('excel_questions')
                                        ->where('test_id',$id)
                                        ->where('section_name','LIKE', "%$test_section->section_name%")
                                        ->get();
                                        
                            $getLastById = DB::table('excel_questions')
                                            ->where('test_id', $id)
                                            ->where('section_name', 'like', "%$test_section->section_name%")
                                            ->selectRaw('MIN(id) as first_id, MAX(id) as last_id')
                                            ->limit(1)
                                             ->first();

                            $getfirstId = $getLastById->first_id;
                            $getlastId = $getLastById->last_id;
                                    
                        ?>
                         <div  class="tab-pane tbad{{$index}} tabr {{ $index === 0 ? 'active' : '' }}"  id="set{{$index}}">
                            <div class="row">  
                                 <div class="col-lg-9">
                                    <div style="border-bottom:2px solid lightgrey;">
                                        <button type="button" class="btn btn-outline-secondary my-2" disabled="disabled">{{$test_section->section_name}}</button>
                                         <div id="dvAccordion">
                                      <i class="fa fa-calculator accordion1 clossed fa-2x" style="float:right; margin-top:-40px;"></i>
                                      <div class="calculator default" style="display:none">
                                         <div id="displayM"></div>
                                         <div id="screen">
                                            <div id="outputScr"></div>
                                            <div id="inputScr">0</div>
                                         </div>
                                         <div id="buttons">
                                            <div id="mc">MC</div>
                                            <div id="mr">MR</div>
                                            <div id="ms">MS</div>
                                            <div id="mp">M+</div>
                                            <div id="mm">M-</div>
                                            <div id="backspace"><b>&#8592;</b></div>
                                            <div id="ce">CE</div>
                                            <div id="c">C</div>
                                            <div id="plusminus">&#177;</div>
                                            <div id="sqroot"><b>&#8730;</b></div>
                                            <div id="seven">7</div>
                                            <div id="eight">8</div>
                                            <div id="nine">9</div>
                                            <div id="divide"><b>/</b></div>
                                            <div id="percent">%</div>
                                            <div id="four">4</div>
                                            <div id="five">5</div>
                                            <div id="six">6</div>
                                            <div id="times">*</div>
                                            <div id="reciprocal">1/x</div>
                                            <div id="one">1</div>
                                            <div id="two">2</div>
                                            <div id="three">3</div>
                                            <div id="minus">-</div>
                                            <div id="equals">=</div>
                                            <div id="zero">0</div>
                                            <div id="decpoint">.</div>
                                            <div id="plus">+</div>
                                         </div>
                                      </div>
                                </div>
                                    </div>   
                                    <?php
                                      $i= 1;
                                    ?>
                                    <div style="height:370px" class="question-section">
                                        <div>
                                              @foreach($verbal_ques as $key=> $ques_paper)
                                              <?php
                                               $half_quiz = DB::table('half_student_quiz')
                                                               ->where('test_id',$id)
                                                               ->where('user_id',$userid)
                                                               ->where('paper_id',$paperid)
                                                               ->where('question_id',$ques_paper->id)
                                                              //->where('section_type', 'like', "%$test_section->section_name%")
                                                               ->orderBy('id','asc')
                                                               ->limit(1)
                                                               ->first(); 
                                                             
                                              ?>
                                                  <input type="hidden" name="section_type[{{$ques_paper->id}}]" value="{{$ques_paper->section_name}}" class="section" data-snamee ="{{$ques_paper->section_name}}">
                                                  <input type="hidden" name="test_id[{{$ques_paper->id}}]" value="{{$id}}" class="testid">
                                                  <input type="hidden" name="user_id[{{$ques_paper->id}}]" value="{{$userid}}" class="userid">
                                                  <input type="hidden" name="student_duration[{{$ques_paper->id}}]" value="{{$quiz_duration->all_duration}}">
                                                  <input type="hidden" name="paper_id[{{$ques_paper->id}}]" value="{{$paperid}}" class="paperid">
                                                  <div class="question qdata{{$ques_paper->id}} mydives"  data-i="{{$ques_paper->id}}">
                                                  <input type ="hidden" class ="ssnm" name ="ssname" data-sname ="{{$ques_paper->section_name}}">
                                                  <input type ="hidden"  name ="level[{{$ques_paper->id}}]" value="{{$ques_paper->level}}">
                                                    <!--<input type="hidden" id="output" name="ans_duration[{{$ques_paper->id}}]"value="">-->
                                                     <input type="hidden" class="output" name="ans_duration[{{$ques_paper->id}}]"  data-id ="{{$ques_paper->id}}" value="">
                                                    @if(empty($ques_paper->instruction) || ($ques_paper->instruction == 'empty'))
                                                     <!--startinc-->
                                                
                                                 <div class=" data ansvalue">
                                                    <div class="scroll-content">
                                                    <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                                                    </div>
                                                    <input type="hidden" name="question_id[{{$ques_paper->id}}]" value="{{$ques_paper->id}}">
                                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                                    <input type="hidden" name="question_type[{{$ques_paper->id}}]" value="multiple">
                                                    @if($ques_paper->status == 1)
                                                    <ol class="choices">
                                                       <?php
                                                          $ansstr = $ques_paper->answer;
                                                          $ans = explode(",",$ansstr);
                                                          $lk =0;
                                                          ?>
                                                       @foreach($ans as $value)
                                                       <!-- <li style="display:flex;">
                                                          <span>
                                                          <input type="radio" class="ans rem re{{$i}} shans{{$lk}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == $lk) ? $half_quiz->answer : '' }}" data-main="{{$lk}}"  {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>&nbsp;{{$value}}
                                                          </span>
                                                       </li> -->
                                                       <li class="list-group-item">
                                                           <div class="form-check">
                                                                <input type="radio" class="form-check-input rem re{{$ques_paper->id}} res{{$ques_paper->id}} shans{{$lk}}" data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == $lk) ? $half_quiz->answer : $lk }}" data-main="{{$lk}}"  {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>
                                                                
                                                                  <label class="form-check-label" >
                                                                        {{$value}}
                                                                  </label>
                                                           </div>
                                                       </li>
                                                       <?php $lk++; ?>
                                                       @endforeach
                                                    </ol>
                                                    @else
                                                   <ol class="choices">
                                                        @if($ques_paper->option1)
                                                       <!-- <li style="display:flex;"><input type="radio" class="ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]"value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}" data-main="1" data-main="1"  {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                                       <li class="list-group-item">
                                                           <div class="form-check">
                                                              <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} res{{$ques_paper->id}} shans1" data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]"value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : 1 }}" data-main="1" data-main="1"  {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>
                                                              <label class="form-check-label" >
                                                                    <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                              </label>
                                                           </div>
                                                       </li>
                                                       @endif
                                                        @if($ques_paper->option2)
                                                       <!-- <li style="display:flex;"><input type="radio" class="ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}"   data-main="2"  {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                                       <li class="list-group-item">
                                                           <div class="form-check">
                                                              <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} res{{$ques_paper->id}} shans2" data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : 2 }}"   data-main="2"  {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}/>
                                                              <label class="form-check-label" >
                                                              <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                              </label>
                                                           </div>
                                                       </li>
                                                       @endif
                                                        @if($ques_paper->option3)
                                                       <!-- <li style="display:flex;"><input type="radio" class="ans rem re{{$i}} shans3" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}"  data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                                       <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} res{{$ques_paper->id}} shans3" data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : 3 }}"  data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                          </label>
                                                       </div></li>
                                                       @endif
                                                        @if($ques_paper->option4)
                                                       <!-- <li style="display:flex;"><input type="radio" class="ans rem re{{$i}} shans4" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) &&($half_quiz->answer == 4) ? $half_quiz->answer : '' }}" data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                                       <li class="list-group-item">
                                                           <div class="form-check">
                                                              <input type="radio" class="form-check-input ans rem re{{$i}} shans4 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) &&($half_quiz->answer == 4) ? $half_quiz->answer : 4 }}" data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}/>
                                                              <label class="form-check-label" >
                                                              <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                              </label>
                                                           </div>
                                                       </li>
                                                       @endif
                                                       @if($ques_paper->option5)
                                                       <!-- <li style="display:flex;"><input type="radio" class="ans rem re{{$i}} shans5" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}"  data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                                        <li class="list-group-item">
                                                           <div class="form-check">
                                                              <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans5 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : 5 }}"  data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>
                                                              <label class="form-check-label" >
                                                                <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                              </label>
                                                           </div>
                                                        </li>
                                                       @endif
                                                    </ol>
                                                    @endif 
                                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                                    <input type="hidden" name="question_type[]" value="numerical">
                                                    <br/>
                                                    <!-- <b>ANSWER: </b> -->
                                                    <!--<input type ="text" class="ansi  exampledata rem" name ="answer[]"  data-value1="{{$i}}"/>-->
                                                    
                                                    <!--<div class="virtual-keyboard"></div>-->
                                                     <div class="input-numeric-container">
                                                        <input class="input-numeric ansi exampledatat rem re{{$ques_paper->id}} res{{$ques_paper->id}} " name ="answer[{{$i}}]"  data-value1="{{$ques_paper->id}}" type="number" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}" />
                                                        <table class="table-numeric">
                                                            <tbody>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="1" data-n="{{$ques_paper->id}}">1</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="2" data-n="{{$ques_paper->id}}">2</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="3"data-n="{{$ques_paper->id}}">3</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="4"data-n="{{$ques_paper->id}}">4</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="5"data-n="{{$ques_paper->id}}">5</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="6"data-n="{{$ques_paper->id}}">6</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="7"data-n="{{$ques_paper->id}}">7</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="8"data-n="{{$ques_paper->id}}">8</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="9"data-n="{{$ques_paper->id}}">9</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key-del newkey" disabled data-n="{{$ques_paper->id}}">Del</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="0" data-n="{{$ques_paper->id}}">0</button></td>
                                                                    <td><button type="button" class="key-clear newkey" disabled data-n="{{$ques_paper->id}}">Clear</button></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                 
                                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                                    <input type="hidden" name="question_type[]" value="essay">
                                                    <div class="row">
                                                       <div class="col-md-6">
                                                          <br/>
                                                          <b>ANSWER</b>
                                                          <textarea  name = "answer[{{$i}}]"rows="4" class="ansi rem re{{$ques_paper->id}} res{{$ques_paper->id}} " cols="50" style="height:200px;" placeholder="Write answer here..." class= "form-control" data-value1="{{$ques_paper->id}}"></textarea>
                                                       </div>
                                                    </div>
                                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                                    <input type="hidden" name="question_type[]" value="fill_in_the_blanks">
                                                    <br/><br/>
                                                    <b>ANSWER: </b>
                                                   <input type ="text" class="ansi exampledata rem re{{$ques_paper->id}} res{{$ques_paper->id}} " name ="answer[{{$i}}]" data-value1="{{$ques_paper->id}}" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}">
                                                  <div class="virtual-keyboard vk{{$i}}"data-key="{{$i}}"></div>
                                                    @endif
                                                 </div>
                                                  <!--endinc-->
                                                 
                                                 
                                                 @else
                                                  <!--newstartinc-->
                                                 <div class="scroll">
                                                    <div class="scroll-content">
                                                        <?= htmlspecialchars_decode($ques_paper->instruction) ?>
                                                    </div>
                                                 </div>
                                                 <div class="ansvalue">
                                                    <b>Q{{$i}}.</b>   <?= htmlspecialchars_decode($ques_paper->question) ?>
                                                    <input type="hidden" name="question_id[{{$ques_paper->id}}]" value="{{$ques_paper->id}}">
                                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                                        <input type="hidden" name= "question_type[{{$ques_paper->id}}]" value="multiple">
                                                    @if($ques_paper->status == 1)
                                                    <ol class="choices list-group">
                                                       <?php
                                                          $ansstr = $ques_paper->answer;
                                                          $ans = explode(",",$ansstr);
                                                          $lk =1;
                                                        ?>
                                                       @foreach($ans as $value)
                                                       <li style="display:flex;" class="list-group-item">
                                                          <span>
                                                          <input type="radio" class="ans rem re{{$ques_paper->id}} shans{{$lk}} res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) &&($half_quiz->answer == $lk) ? $half_quiz->answer : $lk }}" data-main="{{$lk}}"  data-main="{{$lk}}" {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>&nbsp;<?= htmlspecialchars_decode($value) ?>
                                                          </span>
                                                       </li>
                                                       <?php $lk++; ?>
                                                       @endforeach
                                                    </ol>
                                                    @else
                                                    <ol class="choices list-group">
                                                         @if($ques_paper->option1)
                                                       <!-- <li style="display:flex;" class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}"   data-main="1" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                                       <li class="list-group-item">
                                                           <div class="form-check">
                                                              <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans1 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : 1 }}"   data-main="1" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>
                                                              <label class="form-check-label" >
                                                                <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                                              </label>
                                                           </div>
                                                       </li>
                                                       @endif
                                                        @if($ques_paper->option2)
                                                       <!-- <li style="display:flex;" class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}" data-main="2" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }} />&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                                       <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans2 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : 2 }}" data-main="2" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }} />
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                                          </label>
                                                       </div></li>
                                                       @endif
                                                        @if($ques_paper->option3)
                                                       <!-- <li style="display:flex;" class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans3" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}" data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                                       <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans3 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : 3 }}" data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                                          </label>
                                                       </div></li>
                                                       @endif
                                                        @if($ques_paper->option4)
                                                       <!-- <li style="display:flex;" class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans4"   data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : '' }}"   data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }} />&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                                       <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans4 res{{$ques_paper->id}} "   data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : 4 }}"   data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }} />
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                                          </label>
                                                       </div></li>
                                                       @endif
                                                       @if($ques_paper->option5)
                                                       <!-- <li style="display:flex;" class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans5" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}" data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option5) ?></label></li> -->
                                                       <li class="list-group-item">
                                                       <div class="form-check">
                                                          <input type="radio" class="form-check-input ans rem re{{$ques_paper->id}} shans5 res{{$ques_paper->id}} " data-value="{{$ques_paper->id}}" name="answer[{{$ques_paper->id}}]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : 4 }}" data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>
                                                          <label class="form-check-label" >
                                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                                          </label>
                                                       </div></li>
                                                       @endif
                                                    </ol>
                                                    @endif 
                                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                                    <input type="hidden" name="question_type[{{$ques_paper->id}}]" value="numerical">
                                                    <br/>
                                                    <!-- <b>ANSWER: </b> -->
                                                 
                                                     <div class="input-numeric-container">
                                                        <input class="input-numeric ansi exampledatat rem re{{$ques_paper->id}} res{{$ques_paper->id}}" name ="answer[{{$i}}]"  data-value1="{{$ques_paper->id}}" type="number" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}" />
                                                         <table class="table-numeric">
                                                            <tbody>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="1" data-n="{{$ques_paper->id}}">1</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="2" data-n="{{$ques_paper->id}}">2</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="3"data-n="{{$ques_paper->id}}">3</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="4"data-n="{{$ques_paper->id}}">4</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="5"data-n="{{$ques_paper->id}}">5</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="6"data-n="{{$ques_paper->id}}">6</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key newkey" data-key="7"data-n="{{$ques_paper->id}}">7</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="8"data-n="{{$ques_paper->id}}">8</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="9"data-n="{{$ques_paper->id}}">9</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button type="button" class="key-del newkey" disabled data-n="{{$ques_paper->id}}">Del</button></td>
                                                                    <td><button type="button" class="key newkey" data-key="0" data-n="{{$ques_paper->id}}">0</button></td>
                                                                    <td><button type="button" class="key-clear newkey" disabled data-n="{{$ques_paper->id}}">Clear</button></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                     <!--<div class="virtual-keyboard"></div>-->
                                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                                    <input type="hidden" name="question_type[{{$ques_paper->id}}]" value="essay">
                                                    <div class="row">
                                                       <div class="col-md-6">
                                                          <b>ANSWER</b>
                                                          <textarea  name = "answer[{{$i}}]"rows="4" class="ansi rem re{{$ques_paper->id}} res{{$ques_paper->id}}" cols="50" style="height:200px;"placeholder="Write answer here..." class="form-control" data-value1="{{$ques_paper->id}}"></textarea>
                                                       </div>
                                                    </div>
                                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                                    <input type="hidden" name="question_type[{{$ques_paper->id}}]" value="fill_in_the_blanks">
                                                    <br/>
                                                    <b>ANSWER: </b>
                                                     <input type ="text" class="ansi exampledata rem re{{$ques_paper->id}} res{{$ques_paper->id}}" name ="answer[{{$i}}]" data-value1="{{$ques_paper->id}}" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}">
                                                    <div  style="width:100%; margin-top:10px;" class="virtual-keyboard vk{{$i}}"data-key="{{$i}}"></div>
                                                    @endif
                                                 </div>
                                                   <!--newendinc-->
                                                 @endif
                                            </div>
                                              <?php $i++; ?>
                                              @endforeach
                                             
                                        </div>
                                    </div>
                                <div class="review-section">
                                    
                                      <!-- <p id="output"></p> -->
                                     <input type="hidden" name="sdata">
                                    <div style="width:100%; float:left; background:lightgrey;padding:10px 20px; border-radius:10px;" class="d-flex justify-content-around mt-3 ">
                                      <!--<button type="button" class="btn btn-outline-secondary review" data-review=""> MARKED FOR REVIEW</button>-->
                                       <?php
                                      $testid= request()->id;
                                      $pid= request()->paperid;
        
                                      ?>
                                      <button type="button" class="btn btn-outline-secondary review" data-review="" data-section="data" data-pid="{{$pid}}"data-tid="{{$testid}}"> MARKED FOR REVIEW</button>
                                         <button type="button" class="btn btn-outline-secondary rev " data-rev='' >
                                          <!--<i class="fas fa-trash" style="font-size:18px;"></i>-->
                                          CLEAR
                                         </button>
                                         <button type="button" class="btn btn-primary next pagination "  data-save="" data-recordd=""  data-nlastid="{{$getlastId}}">&nbsp;&nbsp;Save & Next</button>
                                        <button type="button" class="btn btn-primary nextdata pagination"  data-save="" data-recorddy="" style="display:none;" 
                                        data-nlastid="{{$getlastId}}">Save & Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" style="border-left:1px solid lightgrey; float:left; padding-left:10px; padding-top:10px;">
                            <?php $j =1; ?>
                            <div style="height:390px; overflow-y:scroll;">
                               <div id="divs" data-vt="{{ json_encode($verbal_ques->pluck('id')) }}">
                                  @foreach($verbal_ques as $verbal_quess)
                                   <?php
                                  $half_ansdata = DB::table('section_student_quizes')
                                                ->where('test_id',$id)
                                                ->where('user_id',$userid)
                                                ->where('paper_id',$paperid)
                                                ->where('question_id',$verbal_quess->id)
                                                ->where('section_type', 'like', "%$test_section->section_name%")
                                                ->first(); 
                                    
                               ?>
                                    <div class="sel{{$verbal_quess->id}} ssm" >
                                      @if(!empty($half_ansdata->answer))
                                            <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$verbal_quess->id}}" class="qus btn btn-circle btn-lg sr{{$verbal_quess->id}}"data-equ="{{$verbal_quess->id}}" style ="background-color:green">{{$j}}</button>
                                      @else
                                        <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$verbal_quess->id}}" class="qus btn btn-circle btn-lg sr{{$verbal_quess->id}}"data-equ="{{$verbal_quess->id}}">{{$j}}</button>
                                      @endif
                                     <?php $j++; ?>
                                    </div>
                                  @endforeach
                                  
                                <!--<input type="hidden" name="check_color" class="check_color"data-half=""> -->
                                
                                <?php
                                    $half_review = DB::table('ansmark_review')
                                            ->where('test_id',$id)
                                            // ->where('user_id',$userid)
                                            ->where('ans_review',1)
                                            ->where('paper_id',$paperid)
                                           //->where('review_id',$half_data1->sr_no)
                                            ->where('section_name', 'like', "%$test_section->section_name%")
                                            ->orderBy('id','desc')
                                            ->get(); 
                                ?>
                                 <input type="hidden" name="check_review" class="check_review"data-review="{{ isset($half_review) ? $half_review : '' }}">  
    
                            </div>
                            </div>
                            <div style="margin-top:30px;">
                               <div class="indentation" style="width:auto;">
                                  <div style="height:20px; width:20px; background-color:green; border-radius:50%; margin:5px; float:left"></div>
                                  <div style="float:left; margin-top:4px">
                                     <p>Answered</p>
                                  </div>
                               </div>
                               <div class="indentation" style="width: 300px;">
                                  <div style="height:20px; width:20px; background-color:red; border-radius:50%; margin:5px; float:left"></div>
                                  <div style="float:left; margin-top:4px">
                                     <p>Not Answered</p>
                                  </div>
                               </div>
                               <div class="indentation" style="width: 300px;">
                                  <div style="height:20px; width:20px; background-color:purple; border-radius:50%; margin:5px; float:left"></div>
                                  <div style="float:left; margin-top:4px">
                                     <p>Marked for review</p>
                                  </div>
                               </div>
                               <div class="indentation" style="width: 300px;">
                                  <div style="height:20px; width:20px; background-color:lightgray; border-radius:50%; margin:3px; float:left"></div>
                                  <div style="float:left; margin-top:4px">
                                     <p>Not Visited</p>
                                  </div>
                               </div>
                               <div class="indentation" style="width: 184px;">
                                  <div style="height:20px; width:20px; background:linear-gradient(green, purple); border-radius:50%; margin:5px; float:left"></div>
                                      <div style="float:left; margin-top:4px">
                                         <p>Answered & Marked for review</p>
                                      </div>
                               </div>
                               <?php
                                  $id =request()->id;
                                  ?>
                               <div style="margin-top:-30px; margin-bottom:10px;">
                                  <a  class="btn btn-md btn-default allqus quesall">ALL QUESTIONS</a>
                                  <!-- <a href ="{{route('student.all-question',$id)}}" type="button" class="btn btn-md btn-default allqus qn" data-qn="{{$id}}">ALL QUESTION</a>-->
                                  <!--<a  href ="{{route('student.quiz_instructions',$id)}}" type="button" class="btn btn-md btn-default ins">INSTRUCTION</a>-->
                                   <a  type="button" class="btn btn-md btn-default ins inst">INSTRUCTIONS</a>
                               </div>
    
                               <button type="button" class="btn subform" style="width:100%; background-color:maroon; color:white"  data-toggle="modal" data-target="#submission" >
                               SUBMIT</button>
                            </div>
                            </div>
                        </div>
                                </div>
                        <?php
                        $n++;
                        ?>
                       @endforeach
                    </div>
               </div>
               <!--startquestion-->
                 <div class="row allqstd" style="display:none">
                <div class="col-md-12">
                    @foreach($verbal_qus as $question)
                   <div class="choice">
                     @if(!empty($question->instruction))
                        <p><?= htmlspecialchars_decode($question->instruction) ?></p>
                     @else
                     @endif
                        <p><b>Question:</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                           @if($question->question_type == 'multiple'||$question->question_type == 'MULTI_CHOICE')

                           @if($question->status =='1')
                                    <ol class="choices list-group">
                                       <?php
                                          $ansstr = $question->answer;
                                          $ans = explode(",",$ansstr);
                                         
                                          ?>
                                       @foreach($ans as $value)
                                       <li>
                                          <span>
                                          {{$value}}
                                          </span>
                                       </li style="display:flex;" class="list-group-item">
                                       @endforeach
                                    </ol>
                                    @else

                                    <ol class="choices list-group">
                                       <li style="display:flex;" class="list-group-item"><span><?= htmlspecialchars_decode($question->option1) ?></span></li>
                                       <li style="display:flex;" class="list-group-item"><span><?= htmlspecialchars_decode($question->option2) ?></span></li>
                                       <li style="display:flex;" class="list-group-item"><span><?= htmlspecialchars_decode($question->option3) ?></span></li>
                                       <li style="display:flex;" class="list-group-item"><span><?= htmlspecialchars_decode($question->option4) ?></span></li>
                                       @if($question->option5)
                                       <li style="display:flex;" class="list-group-item"><span><?= htmlspecialchars_decode($question->option5) ?></span></li>
                                       @endif
                                    </ol>
                           @endif
                           @endif
                    </div>
                    @endforeach
                </div>
            </div>
                <!--endquestion-->
                
                <!--startinst-->
                 <div class="col-md-12 inh" style="display:none"> 
                  <?php
                     $id =request()->id;
                     $ins = DB::table('instruction')->where('test_id',$id)->orderBy('id', 'DESC')->first(); 
                  ?>
                 <h3 style="background-color:maroon; color:white; padding:7px;">INSTRUCTIONS</h3>
                 @if(!empty($ins))
                    <?= htmlspecialchars_decode($ins->instruction) ?>
                    @else
                     <div id="heading"> General Instructions</div>
                    1. The clock has been set on the server and countdown timer at top right corner of your screen will display the remaining time for you to complete the exam. When the clock runs out the exams ends by default- you are not required to end or submit your exam
                    
                    2. The questions palette at the right of screen shows one of the following status of each of the questions numbered
                    15
                    You have not visited the question yet
                    15
                    You have not answered the question
                    15
                    You have answered the question

                    15
                    You have NOT answered the question but have marked the question for review

                    15
                    You have answered the question but marked it for review

                    The Marked for Review status simply acts as a reminder that you have set to look at the question again. If an answer is selected for a question that is Marked for Review, the answer will be considered in the final evaluation

                    <div id="heading">Navigation to a question</div>
                    3. To select a question to answer, you can do one of the following:

                    Click on the question number on the question palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question

                    Click on Save and Next to save answer to current question, mark it for review, and to go to the next question in sequence

                    Click on Mark for Review and Next to save answer to current question

                    4. You can view the entire paper by clicking on the All Questions button

                    <div id="heading">Answering question</div>
                    5. For multiple choice type question

                    a. To select your answer, click on one of the option buttons

                    b. To change your answer, click the another desired option button

                    c. To save your answer, you MUST click on save

                    d. To deselect a chosen answer, click on the chosen option again or click on the Clear Response button

                    e. To mark a question for review click on Mark for Review & Next If an answer is selected for a question that is Marked for Review, the answer will be considered in the final evaluation

                    6. To change an answer to a question, first select the question and then click on the new answer option followed by a click on the save button

                    7. Questions that are saved or marked for review after answering will ONLY be considered for evaluation

                    8. If quiz is paused, quiz can be continued from where left off within scheduled time

                    <div id="heading">Navigation through sections</div>
                    9. Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by clicking on the section name. The section you are currently viewing is highlighted

                    10. After clicking the save button on the last question for a section,you will automatically be taken to the first question of the next section

                    11. You can move the mouse cursor over the section names to view the status of the questions for that section

                    12. You can shuffle between sections and questions anytime during the examination as per your convenience
                    @endif
                    <br/>
                   
                
        </div>  
                <!--endinst-->
            </div>
         </div>
         <?php
         $verbalvalue = 'data';
         ?>
         <div class="modal fade" id="myModal" data-bs-backdrop="static" 
            aria-hidden="true" 
            aria-labelledby="myModalLabel" 
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-body" style="text-align:center">
                     <img src="{{ asset('assets/student/image/imgpsh_fullsize_anim(1).png') }}" style=" margin-top:50px;height:150px; width:200px;"/>
                     <h4>Your Session has expired</h4>
                     <h6>Please, Click Button to submit Your quiz</h6>
                  </div>
                  <div class="modal-footer border-0 mx-auto" >
                         <!--<a class ="submitbtn2" href="{{route('student.stop-quiz',['sid'=>$verbalvalue,'id'=>$id,'paperid'=>$paperid])}}">-->
                         <!--<button type="button" class="modalbtn submitbtn">-->
                         <!--SUBMIT-->
                         <!--</button>-->
                          <a href="{{route('student.stop-section-quiz',['id'=>$id,'paperid'=>$paperid])}}" >
                        <button type="button" class="modalbtn newsubmitbtn1" style="width: 109px;">SUBMIT</button>
                         </a>
                        <!--<button type="button" class="modalbtn">NEXT</button>-->
                       
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade " id="submission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
               <div class="modal-content">
                  <div class="modal-body" style="text-align:center">
                     <h4>Submit Your Quiz</h4>
                     <h6>When you are ready, click Submit button</h6>
                  </div>
                    <div class="modal-footer border-0 mx-auto" >
                        <a href="{{route('student.stop-section-quiz',['id'=>$id,'paperid'=>$paperid])}}" >
                          <button type="button" class="modalbtn newsubmitbtn1" style="width: 109px;">SUBMIT</button>
                        </a>
                        <!--<button type="button" class="modalbtn">NEXT</button>-->
                        <button type="button" class="btn btn-lg btn-default " data-dismiss="modal">Cancel</button>
                    </div>
               </div>
            </div>
         </div>
      </form>
    </div> 
        
<!--endverbalsection-->
<!--start popup -->

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby = "offcanvasWithBackdropLabel">
       <div class="offcanvas-header">
         <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Change Section</h5>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label = "Close"></button>
       </div>
        <div class="offcanvas-body">
            
            <p>By changing sections, you will be moved to a new section. If you are certain about changing sections, please select an option from below.</p>
            @foreach($sectiontests as $sectiontest)
             <!--<a href ="{{ route('student.next-section-quiz',['id'=>$id,'paperid'=>$paperid,'section_name'=>$sectiontest->section_name]) }}"  class="btn btn-outline-secondary my-1 px-auto w-100 da" data-id ="{{$id}}" data-paperid ="{{$paperid}}" data-section ="{{$sectiontest->section_name}}">{{$sectiontest->section_name}} </a>-->
            @endforeach
               <ul class="nav nav-tabs">
    @foreach($sectiontests as $index => $test_section)
    <?php
    // $excelquesid  = DB::table('excel_questions')
    //                 ->select('id')
    //               ->where('test_id',$id)
    //               ->where('section_name', 'like', "%$test_section->section_name%")
    //               ->orderBy('id','asc')
    //               ->limit(1)
    //               ->first(); 
    
    $firstLastIds = DB::table('excel_questions')
                    ->where('test_id', $id)
                    ->where('section_name', 'like', "%$test_section->section_name%")
                    ->selectRaw('MIN(id) as first_id, MAX(id) as last_id')
                    ->first();
    $firstId = $firstLastIds->first_id;
    $lastId = $firstLastIds->last_id;
                ?>
        <li class="nav-item">
            <a class="btn btn-outline-secondary my-2 showtab {{ $index === 0 ? 'active' : '' }} newtab" 
                data-bs-toggle="tab" 
                href="#set{{$index}}" 
                data-set="{{ $index }}" data-quesid ="{{ $firstId }}" 
                id="activateTabButton" data-lastid ="{{ $lastId }}">
                {{$test_section->section_name}}
            </a>
        </li>
    @endforeach
</ul>
        </div>
    </div>
<!--end popup-->
</div>

<!--start allquestion-->
  
<!--end allquestion-->
<!--start instruction-->
  
<!--end instruction-->
<script type="text/javascript" src="{{asset('assets/admin/js/keyboard-initializer.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/keyboard-handler.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/numeric-keypad.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/section_calcu.js')}}"></script>

<script>

$('.showtab').click(function(){
  
   // $('.showtab').off('click').click(function() {
        var lastid = $(this).attr('data-lastid');
        $('.nextdata').css('display','none'); 
        $('.next').css('display','block'); 
        var nextCounter = 0; // Counter for the 'next' button
        var nextDataCounter = 0; // Counter for the 'nextdata' button
         // alert('.qdata' + newid);
        var newid = $('.output').attr('data-id');
        $('.question').css('display', 'none');
        $('.qdata' + newid).css('display', 'block');
        var neda =    $('.res'+newid).val();
        var type =   $('.res'+newid).attr('type');
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+newid).val();
            if(val){
                 $('.sr' + newid).css('background-color', 'green');
            }else{
                 $('.sr' + newid).css('background-color', 'red');
            }
        }else if(type == 'radio'){
            let isChecked = $('.res'+newid).is(':checked');
            if(isChecked == true){
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + newid).css('background-color', 'green');
            }else{
                $('.sr' + newid).css('background-color', 'red');
            }
        }
    
        $(".review").attr('data-review', newid);
        $(".review").click(function(){
            var rv1 =  $('.review').attr('data-review');
            $('.sr'+rv1).css('background-color','purple');
        })

        $('.res'+ newid).click(function() {
            var valv = $(this).attr('data-main');
            $(this).val(valv);
            $('.sr' + newid).css('background-color', 'green');
            $(".review").click(function(){
                var rv1 =  $('.review').attr('data-review');
                $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
        });
        
      $('.rev').attr('data-rev',newid);
      $('.rev').click ( function(){
          var rev = $(this).attr('data-rev');
          var csr = $('.sr'+rev).css('background-color');
          $('.re'+rev).val(''); 
           $('.re'+rev).prop('checked', false);
          $('.sr'+rev).css('background-color','red');
          if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
             $('.sr'+rev).removeAttr("style");
             $('.sr'+rev).css('background-color','red');
           }
          
      })

    $('.next').attr('data-recordd', newid);
    $('.next').off('click').click(function() {
        nextCounter++; // Increment the next button counter
        var save = $(this).attr('data-recordd');
        var save1 = parseInt(save) + nextCounter;
        console.log(save1,"save1fornewtab");
        $('.ssm').removeClass('selected');
        $('.sel'+save1).addClass('selected');
        
        $('.question').css('display', 'none');
        $('.qdata'+save1).css('display', 'block');
        var type =   $('.res'+save1).attr('type');
        if(type == 'text' || type == 'number'){
            console.log("text");
            var val =  $('.res'+save1).val();
            if(val){
                 $('.sr' + save1).css('background-color', 'green');
            }else{
                 $('.sr' + save1).css('background-color', 'red');
            }
        }else if(type == 'radio'){
            let isChecked = $('.res'+save1).is(':checked');
            if(isChecked == true){
                console.log(isChecked,"radio");
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + save1).css('background-color', 'green');
            }else{
                 console.log(isChecked,"radio1");
                $('.sr' + save1).css('background-color', 'red');
            }
        }
        
        $('.rev').attr('data-rev',save1);
      $('.rev').click ( function(){
          var rev = $(this).attr('data-rev');
          var csr = $('.sr'+rev).css('background-color');
           $('.re'+rev).prop('checked', false);
          $('.re'+rev).val(''); 
          $('.sr'+rev).css('background-color','red');
          if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
             $('.sr'+rev).removeAttr("style");
             $('.sr'+rev).css('background-color','red');
           }
          
      })
        
        $(".review").attr('data-review', save1);
        $(".review").click(function(){
            var rv1 =  $('.review').attr('data-review');
            $('.sr'+rv1).css('background-color','purple');
        })
        $('.res' + save1).click(function() {
            var valv = $(this).attr('data-main');
            $(this).val(valv);
            $('.sr' + save1).css('background-color', 'green');
            $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
        });
    });

  $('.qus').click(function() {
  
        // Reset the nextDataCounter when clicking on 'qus'
        nextDataCounter = 0;
        $('.next').css('display', 'none');
        $('.nextdata').css('display', 'block');
        var qus = $(this).attr('data-equ');
        $('.question').css('display', 'none');
        $('.qdata' + qus).css('display', 'block');
        
        var type =   $('.res'+qus).attr('type');
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+qus).val();
            if(val){
                 $('.sr' + qus).css('background-color', 'green');
            }else{
                 $('.sr' + qus).css('background-color', 'red');
            }
        }else if(type == 'radio'){
           let isChecked = $('.res'+qus).is(':checked');
           if(isChecked == true){
               console.log(qus,isChecked,"quesischeck")
                $('.sr' + qus).css('background-color', 'green');
            }else{
                $('.sr' + qus).css('background-color', 'red');
            }
        }
        
        $('.ssm').removeClass('selected');
        $('.sel'+qus).addClass('selected');
        $(".review").attr('data-review', qus);
        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css('background-color','purple');
        })
        $('.res' + qus).click(function() {
            var valv = $(this).attr('data-main');
            $(this).val(valv);
            $('.sr' + qus).css('background-color', 'green');
            $(".review").click(function(){
                var rv1 =  $('.review').attr('data-review');
                $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
            
              $('.rev').attr('data-rev',qus);
              $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
              })
        
        });

        $('.nextdata').attr('data-recorddy', qus);
        $('.nextdata').off('click').click(function() {
            nextDataCounter++; // Increment the nextdata counter
            var save2 = $(this).attr('data-recorddy');
            var save3 = parseInt(save2) + nextDataCounter;
            console.log(save3, "save1forqus");
            var nlastid = $(this).attr('data-nlastid');
           
            if((parseInt(save3)) > (parseInt(nlastid))){
                 console.log(nlastid,"okk1");
                $('.ssm').removeClass('selected');
                $('.sel' + newid).addClass('selected');
                $('.question').css('display', 'none');
                $('.qdata' + newid).css('display', 'block');
                var type =   $('.res'+newid).attr('type');
            }else{
                console.log(lastid,"okk2");
                $('.ssm').removeClass('selected');
                $('.sel' + save3).addClass('selected');
                $('.question').css('display', 'none');
                $('.qdata' + save3).css('display', 'block');
                var type =   $('.res'+save3).attr('type');
            }
            if(type == 'text' || type == 'number'){
                var val =  $('.res'+save3).val();
                if(val){
                     $('.sr' + save3).css('background-color', 'green');
                }else{
                     $('.sr' + save3).css('background-color', 'red');
                }
                
            }else if(type == 'radio'){
                let isChecked = $('.res'+save3).is(':checked');
                if(isChecked == true){
                    // $('.sr'+newid).removeAttr("style");
                    $('.sr' + save3).css('background-color', 'green');
                }else{
                    $('.sr' + save3).css('background-color', 'red');
                }
            }
            
            $(".review").attr('data-review', save3);
            $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
               $('.sr'+rv1).css('background-color','purple');
            })
            
            $('.rev').attr('data-rev',save3);
              $('.rev').click ( function(){
                  //alert("okk");
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
              })
            
            $('.res' + save3).click(function() {
                var valv = $(this).attr('data-main');
                $(this).val(valv);
                $('.sr' + save3).css('background-color', 'green');
                $(".review").click(function(){
                    var rv1 =  $('.review').attr('data-review');
                    $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
                })
            });
        });
    });
})

$(document).ready(function() {
    // Loop through each radio button with class 'shans2'
    $('input.rem').each(function() {
        // Check if the radio button is checked
        if ($(this).prop('checked')) {
            // Get the associated data-value attribute
            var value = $(this).data('value');
            // Find the button related to the data-value and change its color to green
            $('.sr'+ value).css('background-color', 'green');
        }
    });
});
   ///firstwhole section
    $(document).ready(function() {
   
    var nextCounter = 0; // Counter for the 'next' button
    var nextDataCounter = 0; // Counter for the 'nextdata' button
    var newid = $('.output').attr('data-id');
    $('.question').css('display', 'none');
    $('.qdata' + newid).css('display', 'block');
    var neda =    $('.res'+newid).val();
    var type =   $('.res'+newid).attr('type');
    if(type == 'text' || type == 'number'){
        var val =  $('.res'+newid).val();
        if(val){
             $('.sr' + newid).css('background-color', 'green');
        }else{
             $('.sr' + newid).css('background-color', 'red');
        }
        
    }else if(type == 'radio'){
       let isChecked = $('.res'+newid).is(':checked');
       if(isChecked == true){
            // $('.sr'+newid).removeAttr("style");
            $('.sr' + newid).css('background-color', 'green');
        }else{
            $('.sr' + newid).css('background-color', 'red');
        }
    }
    
        $(".review").attr('data-review', newid);
        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css('background-color','purple');
        })
        
         $('.rev').attr('data-rev',newid);
              $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
              })

    $('.res'+ newid).click(function() {
        var valv = $(this).attr('data-main');
        $(this).val(valv);
        $('.sr' + newid).css('background-color', 'green');
        $(".review").click(function(){
          var rv1 =  $('.review').attr('data-review');
          $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
        })
    });

    $('.next').attr('data-recordd', newid);
    $('.next').off('click').click(function() {
        nextCounter++; // Increment the next button counter
        var save = $(this).attr('data-recordd');
        var save1 = parseInt(save) + nextCounter;
        $('.ssm').removeClass('selected');
        $('.sel'+save1).addClass('selected');
        $('.question').css('display', 'none');
        $('.qdata' + save1).css('display', 'block');
        
        var type =   $('.res'+save1).attr('type');
            if(type == 'text' || type == 'number'){
                var val =  $('.res'+save1).val();
                if(val){
                     $('.sr' + save1).css('background-color', 'green');
                }else{
                     $('.sr' + save1).css('background-color', 'red');
                }
                
            }else if(type == 'radio'){
                 let isChecked = $('.res'+save1).is(':checked');
               if(isChecked == true){
                    console.log(isChecked,"radio");
                    // $('.sr'+newid).removeAttr("style");
                    $('.sr' + save1).css('background-color', 'green');
                }else{
                     console.log(isChecked,"radio1");
                    $('.sr' + save1).css('background-color', 'red');
                }
            }
        
        $(".review").attr('data-review', save1);
        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css('background-color','purple');
        })
        
          $('.rev').attr('data-rev',save1);
              $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
              })
              
        $('.res' + save1).click(function() {
            var valv = $(this).attr('data-main');
          $(this).val(valv);
            $('.sr' + save1).css('background-color', 'green');
            $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
        });
    });

    $('.qus').click(function() {
       
        // Reset the nextDataCounter when clicking on 'qus'
        nextDataCounter = 0;
        $('.next').css('display', 'none');
        $('.nextdata').css('display', 'block');
        var qus = $(this).attr('data-equ');
        $('.question').css('display', 'none');
        $('.qdata' + qus).css('display', 'block');
        var type =   $('.res'+qus).attr('type');
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+qus).val();
            if(val){
                 $('.sr' + qus).css('background-color', 'green');
            }else{
                 $('.sr' + qus).css('background-color', 'red');
            }
            
        }else if(type == 'radio'){
           let isChecked = $('.res'+qus).is(':checked');
           
           if(isChecked == true){
               console.log(isChecked,"isChecked","radio");
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + qus).css('background-color', 'green');
            }else{
                $('.sr' + qus).css('background-color', 'red');
            }
        }
        
        $('.ssm').removeClass('selected');
        $('.sel'+qus).addClass('selected');
        $(".review").attr('data-review', qus);
        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
               $('.sr'+rv1).css('background-color','purple');
        })
        
         $('.rev').attr('data-rev',qus);
              $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
              })
              
        $('.res' + qus).click(function() {
            var valv = $(this).attr('data-main');
          $(this).val(valv);
            $('.sr' + qus).css('background-color', 'green');
             $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
                $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
        })
        });

        $('.nextdata').attr('data-recorddy', qus);
        $('.nextdata').off('click').click(function() {
            nextDataCounter++; // Increment the nextdata counter
            var save2 = $(this).attr('data-recorddy');
            var save3 = parseInt(save2) + nextDataCounter;
            console.log(save3, "save1forqus");
            var nlastid = $(this).attr('data-nlastid');
            if((parseInt(save3)) > (parseInt(nlastid))){
                console.log(nlastid,"okk1");
                $('.ssm').removeClass('selected');
                $('.sel' + newid).addClass('selected');
                $('.question').css('display', 'none');
                $('.qdata' + newid).css('display', 'block');
                var type =   $('.res'+newid).attr('type');
                 if(type == 'text' || type == 'number'){
                var val =  $('.res'+newid).val();
                if(val){
                     $('.sr' + newid).css('background-color', 'green');
                }else{
                     $('.sr' + newid).css('background-color', 'red');
                }
                
            }else if(type == 'radio'){
                 let isChecked = $('.res'+newid).is(':checked');
               if(isChecked == true){
                    // $('.sr'+newid).removeAttr("style");
                    $('.sr' + newid).css('background-color', 'green');
                }else{
                    $('.sr' + newid).css('background-color', 'red');
                }
            }
            }else{
                console.log(nlastid,"okk2");
                $('.ssm').removeClass('selected');
                $('.sel' + save3).addClass('selected');
                $('.question').css('display', 'none');
                $('.qdata' + save3).css('display', 'block');
                var type =   $('.res'+save3).attr('type');
                 if(type == 'text' || type == 'number'){
                var val =  $('.res'+save3).val();
                if(val){
                     $('.sr' + save3).css('background-color', 'green');
                }else{
                     $('.sr' + save3).css('background-color', 'red');
                }
                
            }else if(type == 'radio'){
                 let isChecked = $('.res'+save3).is(':checked');
               if(isChecked == true){
                    // $('.sr'+newid).removeAttr("style");
                    $('.sr' + save3).css('background-color', 'green');
                }else{
                    $('.sr' + save3).css('background-color', 'red');
                }
            }
            }
            
           
            
              $(".review").attr('data-review', save3);
              $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
               $('.sr'+rv1).css('background-color','purple');
        })
              $('.rev').attr('data-rev',save3);
               $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
               })
               
            $('.res' + save3).click(function() {
                var valv = $(this).attr('data-main');
                $(this).val(valv);
                $('.sr' + save3).css('background-color', 'green');
                $(".review").click(function(){
                    var rv1 =  $('.review').attr('data-review');
                    $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
                })
            });
        });
    });
});
//end first whole section

$('.showtab').click(function() {
 //$('.showtab').off('click').click(function() {
     var nextCounter = 0; // Counter for the 'next' button
     var nextDataCounter = 0; // Counter for the 'nextdata' button
     //var newid = $('.output').attr('data-id');
     var newid = $(this).attr('data-quesid');
     var lastid = $(this).attr('data-lastid');
     $('.question').css('display', 'none');
     $('.qdata'+newid).css('display', 'block');
     //testing
     //$('.sr' + newid).css('background-color', 'red');
        var neda =    $('.res'+newid).val();
        var type =   $('.res'+newid).attr('type');
        
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+newid).val();
            if(val){
                 $('.sr' + newid).css('background-color', 'green');
            }else{
                 $('.sr' + newid).css('background-color', 'red');
            }
        }else if(type == 'radio'){
            let isChecked = $('.res'+newid).is(':checked');
            if(isChecked == true){
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + newid).css('background-color', 'green');
            }else{
                $('.sr' + newid).css('background-color', 'red');
            }
        }
     
     $(".review").attr('data-review', newid);
     $(".review").click(function(){
             var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css('background-color','purple');
      })

    $('.res' + newid).click(function() {
        var valv = $(this).attr('data-main');
          $(this).val(valv);
        $('.sr' + newid).css('background-color', 'green');
         $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
        })
    });

    $('.next').attr('data-recordd', newid);
    $('.next').click(function() {
        nextCounter++; // Increment the next button counter
        var save = $(this).attr('data-recordd');
        var save1 = parseInt(save) + nextCounter;
        if(save1>lastid){
            $('.ssm').removeClass('selected');
            $('.sel' + newid).addClass('selected');
            $('.question').css('display', 'none');
            $('.qdata' + newid).css('display', 'block');
           // $('.sr' + newid).css('background-color', 'red');
            var type =   $('.res'+newid).attr('type');
            if(type == 'text' || type == 'number'){
                var val =  $('.res'+newid).val();
                if(val){
                     $('.sr' + newid).css('background-color', 'green');
                }else{
                     $('.sr' + newid).css('background-color', 'red');
                }
            }else if(type == 'radio'){
              let isChecked = $('.res'+newid).is(':checked');
               if(isChecked == true){
                    // $('.sr'+newid).removeAttr("style");
                    $('.sr' + newid).css('background-color', 'green');
                }else{
                    $('.sr' + newid).css('background-color', 'red');
                }
            }
            $(".review").attr('data-review', newid);
        }else{
           $('.ssm').removeClass('selected');
           $('.sel' + save1).addClass('selected');
           $('.question').css('display', 'none');
           $('.qdata' + save1).css('display', 'block');  
           //$('.sr' + save1).css('background-color', 'red');
           var type =   $('.res'+save1).attr('type');
        
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+save1).val();
            if(val){
                 $('.sr' + save1).css('background-color', 'green');
            }else{
                 $('.sr' + save1).css('background-color', 'red');
            }
        }else if(type == 'radio'){
          let isChecked = $('.res'+save1).is(':checked');
           if(isChecked == true){
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + save1).css('background-color', 'green');
            }else{
                $('.sr' + save1).css('background-color', 'red');
            }
        }
           $(".review").attr('data-review', save1);
        }

        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css('background-color','purple');
        })
        $('.res' + save1).click(function() {
            var valv = $(this).attr('data-main');
          $(this).val(valv);
            $('.sr' + save1).css('background-color', 'green');
            $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
            
            $('.rev').attr('data-rev',save1);
               $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                   $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
               })
        });
    });

    $('.qus').click(function() {
        // Reset the nextDataCounter when clicking on 'qus'
        nextDataCounter = 0;
        $('.next').css('display', 'none');
        $('.nextdata').css('display', 'block');
        var qus = $(this).attr('data-equ');
        $('.question').css('display', 'none');
        $('.qdata' + qus).css('display', 'block');
        //$('.sr' + qus).css('background-color', 'black');
         var type =   $('.res'+qus).attr('type');
        if(type == 'text' || type == 'number'){
            var val =  $('.res'+qus).val();
            if(val){
                 $('.sr' + qus).css('background-color', 'green');
            }else{
                 $('.sr' + qus).css('background-color', 'red');
            }
        }else if(type == 'radio'){
           let isChecked = $('.res'+qus).is(':checked');
           if(isChecked == true){
               console.log(isChecked,"isChecked","radio");
                // $('.sr'+newid).removeAttr("style");
                $('.sr' + qus).css('background-color', 'green');
            }else{
                $('.sr' + qus).css('background-color', 'red');
            }
        }
        $(".review").attr('data-review', qus);
        $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
               $('.sr'+rv1).css('background-color','purple');
        })
        $('.res' + qus).click(function() {
          var valv = $(this).attr('data-main');
          $(this).val(valv);
            $('.sr' + qus).css('background-color', 'green');
            $(".review").click(function(){
              var rv1 =  $('.review').attr('data-review');
              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
            })
        });
        $('.nextdata').attr('data-recorddy', qus);
        $('.nextdata').off('click').click(function() {
            nextDataCounter++; // Increment the nextdata counter
            var save2 = $(this).attr('data-recorddy');
            var save3 = parseInt(save2) + nextDataCounter;
         if(save3>lastid){
             $('.ssm').removeClass('selected');
             $('.sel' + newid).addClass('selected');
             $('.question').css('display', 'none');
             $('.qdata' + newid).css('display', 'block');
            // $('.sr' + newid).css('background-color', 'red');
             var type =   $('.res'+newid).attr('type');
                if(type == 'text' || type == 'number'){
                    var val =  $('.res'+newid).val();
                    if(val){
                         $('.sr' + newid).css('background-color', 'green');
                    }else{
                         $('.sr' + newid).css('background-color', 'red');
                    }
                }else if(type == 'radio'){
                  let isChecked = $('.res'+newid).is(':checked');
                   if(isChecked == true){
                        // $('.sr'+newid).removeAttr("style");
                        $('.sr' + newid).css('background-color', 'green');
                    }else{
                        $('.sr' + newid).css('background-color', 'red');
                    }
                }
                
                $('.rev').attr('data-rev',newid);
          $('.rev').click ( function(){
              var rev = $(this).attr('data-rev');
              var csr = $('.sr'+rev).css('background-color');
               $('.re'+rev).prop('checked', false);
              $('.re'+rev).val(''); 
              $('.sr'+rev).css('background-color','red');
              if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                 $('.sr'+rev).removeAttr("style");
                 $('.sr'+rev).css('background-color','red');
               }
              
          })
             $(".review").attr('data-review', newid);
             
              $('.rev').attr('data-rev',newid);
               $('.rev').click ( function(){
                  var rev = $(this).attr('data-rev');
                  var csr = $('.sr'+rev).css('background-color');
                    $('.re'+rev).prop('checked', false);
                  $('.re'+rev).val(''); 
                  $('.sr'+rev).css('background-color','red');
                  if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
                     $('.sr'+rev).removeAttr("style");
                     $('.sr'+rev).css('background-color','red');
                   }
                  
               })
         }else{
             $('.ssm').removeClass('selected');
             $('.sel' + save3).addClass('selected');
             $('.question').css('display', 'none');
             $('.qdata' + save3).css('display', 'block');
             //$('.sr' + save3).css('background-color', 'red'); 
              var type =   $('.res'+save3).attr('type');
                if(type == 'text' || type == 'number'){
                    var val =  $('.res'+save3).val();
                    if(val){
                         $('.sr' + save3).css('background-color', 'green');
                    }else{
                         $('.sr' + save3).css('background-color', 'red');
                    }
                }else if(type == 'radio'){
                  let isChecked = $('.res'+save3).is(':checked');
                    if(isChecked == true){
                        // $('.sr'+newid).removeAttr("style");
                        $('.sr' + save3).css('background-color', 'green');
                    }else{
                        $('.sr' + save3).css('background-color', 'red');
                    }
                }
             $(".review").attr('data-review', save3);
         }

            $(".review").click(function(){
               var rv1 =  $('.review').attr('data-review');
               $('.sr'+rv1).css('background-color','purple');
            })
            $('.res' + save3).click(function() {
                var valv = $(this).attr('data-main');
                $(this).val(valv);
                $('.sr' + save3).css('background-color', 'green');
                $(".review").click(function(){
                    var rv1 =  $('.review').attr('data-review');
                    $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
                })
                
                
            });
        });
    });
})

</script>

<script>

// $(document).ready(function() {
//   var totaltime = $('.countdown').attr('data-time');
//   var milliseconds = totaltime * 60 * 1000;

//   $('.sel1').addClass('selected');
//   var divs = $('#divs > div');
//   var output = $('.output'); // Change selector to handle multiple hidden inputs
//   var arr = $('#divs').attr('data-vt');
//   var sert1 = [];
  
//   $.each(JSON.parse(arr), function(index, value) {
//     var sert = 0;
//     sert1.push(sert);
//   });

//   var tarr;
//   if (localStorage.getItem("tarr") !== null) {  
//     tarr = localStorage.getItem("tarr").split(',');         
//   } else {
//     tarr = sert1;
//   }

//   var delay = 1000;
//   divs.click(function() {
//     $(this).addClass('selected').siblings().removeClass('selected');
//   });

//   var timer = setInterval(function() {
//     localStorage.setItem("tarr", tarr);
//     var idx = divs.filter('.selected').index();
//     tarr[idx] = parseInt(tarr[idx]) + delay;

//     // Update hidden input values based on question IDs
//     output.each(function(index) {
//       $(this).val(tarr[index]);
//     });

//     console.log(tarr, "okk");

//     // Check if sum of tarr elements exceeds 5 minutes
//     var sum = tarr.reduce((acc, curr) => acc + parseInt(curr), 0);
//     if (sum == milliseconds) {
//       clearInterval(timer); // Stop the timer
//       console.log("Timer stopped at 5 minutes.");
//     }
//   }, delay);
// });

//endnewtimer
//newworking code
// $(document).ready(function() {
//   var totaltime = $('.countdown').attr('data-time');
//  
//   var milliseconds = totaltime * 60 * 1000;
// var newid = $('.output').attr('data-id');
//   $('.sel'+newid).addClass('selected');
//   var divs = $('#divs > div');
 
//   var output = $('.output');
//   //console.log(output,"output");
//   var arr = $('#divs').attr('data-vt');
//   console.log(arr,"arr");
//   var sert1 = [];
  
//   // Initialize sert1 with zeros based on the length of the parsed array
//   $.each(JSON.parse(arr), function(index, value) {
//     sert1.push(0); // Initialize with 0
//   });

//   var tarr;
//   if (localStorage.getItem("tarr") !== null) {  
//     tarr = localStorage.getItem("tarr").split(',').map(Number); // Ensure all values are numbers
//   } else {
//     tarr = sert1;
//   }

//   var delay = 1000;
//   divs.click(function() {
//     $(this).addClass('selected').siblings().removeClass('selected');
//   });

//   var timer = setInterval(function() {
//     var idx = divs.filter('.selected').index();
//     if (idx !== -1) { // Ensure a valid selection
//       tarr[idx] = parseInt(tarr[idx]) + delay; // Increment selected index value
//     }

//     // Save updated tarr to localStorage
//     localStorage.setItem("tarr", tarr);

//     // Update hidden input values based on question IDs
    
//     output.each(function(index) {
//       $(this).val(tarr[index]);
//      // console.log(tarr[index],"index");
     
//     });

//     // Log the array in desired format
   

//     // Check if sum of tarr elements exceeds 5 minutes
//     var sum = tarr.reduce((acc, curr) => acc + parseInt(curr), 0);
//     if (sum >= milliseconds) {
//       clearInterval(timer); // Stop the timer
//       console.log("Timer stopped at 5 minutes.");
//     }
//   }, delay);
// });
//endnewtimerworking

///with tab timer


$(document).ready(function() {

    var totaltime = $('.countdown').attr('data-time');
    var milliseconds = totaltime * 60 * 1000;

    $('.nav-tabs .showtab').click(function() {
        var activeTab = $(this).attr('href');
        var tabId = $(this).attr('data-set');

        // Fetch data-vt for the active tab
        var arr = $(activeTab).find('#divs').attr('data-vt');
        //console.log('Active tab arr:', JSON.parse(arr));

        // Initialize sert1 and tarr for the current tab
        var sert1 = [];
        $.each(JSON.parse(arr), function() {
            sert1.push(0); // Initialize with 0
        });

        // Use a unique key for localStorage
        var storageKey = `tarr_${tabId}`;
        var tarr;

        if (localStorage.getItem(storageKey) !== null) {
            tarr = localStorage.getItem(storageKey).split(',').map(Number); // Load existing tarr
        } else {
            tarr = [...sert1]; // Initialize with zeros
        }
        var newid = $('.output').attr('data-id');
        $('.sel'+newid).addClass('selected');
        
        var divs = $(activeTab).find('#divs > div');
        var output = $(activeTab).find('.output');

        // Ensure the first div is selected in the active tab
        divs.removeClass('selected');  // Clear any existing selection
        divs.first().addClass('selected');  // Select the first div

        // Handle div click
        divs.click(function() {
            $(this).addClass('selected').siblings().removeClass('selected');
        });

        // Clear previous interval
        clearInterval(window.timer);

        // Start new timer for the active tab
        window.timer = setInterval(function() {
            var idx = divs.filter('.selected').index();

            // Ensure a valid selection is made
            if (idx !== -1) {
                tarr[idx] = tarr[idx] + 1000; // Increment selected index value
            }

            // Save updated tarr to localStorage
            localStorage.setItem(storageKey, tarr);

            // Update hidden input values
            output.each(function(index) {
                $(this).val(tarr[index]);
            });

            // Log the updated tarr
          // console.log(`Updated tarr for tab ${tabId}:`, tarr);

            // Stop timer if sum exceeds allowed time
            var sum = tarr.reduce((acc, curr) => acc + curr, 0);
            if (sum >= milliseconds) {
                clearInterval(window.timer);
                console.log(`Timer stopped for tab ${tabId} at 5 minutes.`);
            }
        }, 1000);
    });

    // Trigger click on the first tab to initialize
    $('.nav-tabs .showtab.active').trigger('click');
});
///end with tab timer



$(document).ready(function() {
    $('.da').click(function(){
        localStorage.clear();
    });
});
</script>
<script language="JavaScript">
        var version = navigator.appVersion;
        function showKeyCode(e) {
          //  console.log(e);
            var keycode = (window.event) ? event.keyCode : e.keyCode;
            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }    
            }
        }
    </script>
 <script>
// $(window).ready(function(event) {
//     console.log(event.keyCode);
//     if (event.keyCode == undefined) {
//     return false;
//     }
    
// })
        // $(document).ready(function() {
        //      $(window).on('focus', function(event) {
        //         event.preventDefault();
        //         // Your custom code to handle the address bar click
        //         alert("Address bar click prevented");
        //     });
        // });
       
        // $(document).ready(function() {
        //     return false;
        //     alert("okk");
            
        // })
        
// $(window).mousedown(function(e){
//   e.preventDefault();
//   $(this).blur();
//   return false;
// });
// $(window).on('focus', function(e) { 
//     e.preventDefault();
//     $(this).blur();
// }

//  $(window).bind("keyup keypress", function(e) {
//   var code = e.keyCode || e.which; 
//   if (code  == 13) {    
//       if($(this).val()==''){
//           e.preventDefault();
//           return false;
//       }
//   }
// });
        
        //function openSecuredWindow() {
        //  $(document).ready(function() {
        //      window.open("https://inmortaltechnologies.com/RootEducation/student/start-quize/1/34", "", "width=" + window.innerWidth +",height=" + window.innerHeight);
        //  });
//}

// $(function () {
// $(window).keydown(function (event) {
// if (event.keyCode == 13) {
// event.preventDefault();
// return false;
// }
// });
// });


// $(window).on('keydown',function(event)
//      {
//      //  console.log(event);
//        if(event.keyCode == 116){
//            return false;
//              //event.preventDefault();
//        }
//        if(event.keyCode == 17){
//           return false; 
//        }else if(event.keyCode == 16){
//            return false;
//        }else if(event.keyCode == 82){
//            return false;
//        }
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
<script>
   $(document).ready(function() {
      $('.clrn').css('display','none');
      $('.quesall').click(function(){
      $('.clrn').css('display','block');
      })
      $('.clrn').click(function(){
      $('.clrn').css('display','none');
      })
      $('.inst').click(function(){
         $('.clrn').css('display','block');
      })
   })
   $(document).ready(function() {
      $('.prof').prop("disabled", true).addClass("disabled");
   })


   $(document).keydown(function(event) {
        if ((event.ctrlKey || event.metaKey) && event.keyCode === 70) { 
           
            event.preventDefault();
          
            console.log("Ctrl + F is disabled");
        }
    });


// $(document).on('click', '.offcanvas-body a', function(e) {
//   window.location.href = $(this).attr('href');
// });


    // $(".da").click(function(){
    //       var datastring = $("form").serialize();
    //       var id = $(this).attr('data-id');
    //       var paperid = $(this).attr('data-paper');
    //       var section_name = $(this).attr('data-section')
    //         // $.ajaxSetup({
    //         //         headers: {
    //         //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         //         }
    //         // });
    //         // $.ajax({
    //         //     method: 'get', 
    //         //     url: 'https://inmortaltechnologies.com/mbaguru/student/next-section-quiz',
    //         //   data: {
    //         //           id: id,
    //         //           section_name: section_name,
    //         //           paperid: paperid
    //         //          },
    //         //     success: function(response){
    //         //         console.log(response.message);
    //         //     },
    //         //     error: function(jqXHR, textStatus, errorThrown) { 
    //         //     console.log(JSON.stringify(jqXHR));
    //         //     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    //         //     },
    //         // });
            
//               var url = "{{ route('student.next-section-quiz', [':id',':paperid', ':section_name']) }}";
//               url = url.replace(':id', id);
//               url = url.replace(':paperid', paperid);
//               url = url.replace(':section_name', section_name);
//               window.location.href=url;

    //     });
   
</script>
<script>
   $(document).on('click', '.showtab', function (e) {
       //location.reload();
    e.preventDefault();
    // Remove active class from all tabs and contents
    $('.nav-tabs .showtab').removeClass('active');
    $('.tab-content .tab-pane').removeClass('active show');
    
    // Add active class to the clicked tab and corresponding content
    $(this).addClass('active');
    $($(this).attr('href')).addClass('active show');
});




</script>
<script>
//for tab
// $(document).on('click', '.newtab', function() {
//     const offcanvasEl = document.getElementById('offcanvasWithBackdrop');
//     const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
//     ///console.log(offcanvas);
//     if (offcanvas) {
//         offcanvas.hide();
//     }
//     setTimeout(() => {
//         $('.offcanvas-backdrop.show').fadeOut(200, function() {
//             $(this).remove();
//         });
//         //$('body').css('overflow', 'auto'); 
//     }, 300); 
// });

</script>
@endsection
@section('css') 
@endsection