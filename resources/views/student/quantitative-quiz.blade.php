@extends('student_template')
@section('css')
@endsection
@section('content')
<?php
   $quizeid1 = 1;
   $quizeid2 = 2;
$data ='overall';
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
   input[type="radio"] {
       border:2px solid black;
    }
/*.choices {*/
/*  position: absolute;*/
/*  z-index: -1;*/
/*}*/
.list-group-item{
    width:800px;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{asset('assets/admin/css/keyboard.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/numeric-keypad.css')}}">
<?php
$paperid =request()->paperid;

?>
<div>
@if($section_time->duration == 'section_duration') 
 <!--startverbalsection-->
   <div class ="qt-formdata">
      <form action="" class="qt" method = "post">
         <div class="col-md-12">
            <?php
          
               $id =request()->id;
               $userid =session()->get('id');
               $tests = DB::table('tests')->where('id',$id)->first(); 
               $test_templates = DB::table('test_templatevalues')->where('temp_id',$tests->testtempid)->first(); 
                $email = DB::table('studentlogs')->where('id',$userid)->first(); 
               ?>
            <div class="verbal" >
               <input type="hidden" name="test">
               <div class="w-100 row" style="border-bottom:2px solid grey;">
                  <div style="border-right:1px solid lightgrey; width:1%; float:left">
                     <!--<button class="btn btn-default iconclose" data-toggle="modal" data-target="#exit"><i class="fa fa-close"></i></button>-->
                     <a class="btn btn-default cls clrn" style="margin-left:-20px;"><i class="fa fa-close" aria-hidden="true"></i></a>
                  </div>
                  <div style="width:76%; float:left; padding-top:5px; border-right:2px solid lightgrey;">
                     <input type="hidden" name="test_id" value="{{$id}}" class="testid">
                     <input type="hidden" name="user_id" value="{{$userid}}" class="userid">
                     <input type="hidden" name="section_type" value="quantitative" class="section">
                     <input type="hidden" name="student_duration" value="{{$section_time->interp_time}}">
                     <input type="hidden" name="paper_id" value="{{$paperid}}" class="paperid">
                     <h6 style=" width:70%; float:left;">{{$tests->test}}{{$tests->testincid}}</h6>
                     <h6 style="text-align:right; width:30%; float:left;">
                     <?php
                        $half_quiz = DB::table('half_student_quiz')
                                      ->where('test_id',$id)
                                      ->where('user_id',$userid)
                                      ->where('paper_id',$paperid)
                                      ->where('section_name', 'like', "%quantitative%")
                                      ->orderBy('id','desc')
                                      ->first(); 
                       ?>
                        Time :
                        <!-- <span id="timer"></span> -->
                        <!-- <span class="countdown" data-time="{{$section_time->interp_time}}"></span> -->
                        @if(!empty($half_quiz->ans_duration))
                        
                        <span class="countdown" data-time="{{$half_quiz->ans_duration}}"></span>
                        @else
                        <span class="countdown" data-time="{{$section_time->quantitative_time}}"></span>
                        @endif
                     </h6>
                  </div>
                   <div style="width:13%; float:left;">
                     <h6 style=" PADDING-TOP:4PX;">{{$email->email}}</h6>
                  </div>
               </div>
               <?php
               $countsection = DB::table('excel_questions')
               ->select('section_name','test_id')
                            ->where('test_id', $id)
                            ->distinct('section_name') 
                            ->count('section_name');
                            if($countsection >'1'){
                                 
                                  $nmaee = $countsection. ' SECTIONS';
                                 //$nmaee = '+'.$countsection. 'SECTIONS';
                            }else{
                               $nmaee = '1 SECTION';
                                
                            }
               ?>
               <div class="form">
                  <div class="row">
                     <div class="col-lg-9">
                        <div style="border-bottom:2px solid lightgrey;">
                            <button type="button" class="sname btn btn-outline-secondary my-2" disabled="disabled"> </button>
                           <button type="button" class="btn btn-outline-primary my-2" disabled="disabled">{{$nmaee}}</button>
                           <div style="z-index:100;" id="dvAccordion">
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
                        <div style="height:400px;">
                           <?php
                              $i= 1;
                              ?>
                           <div class="">
                               <!--<div class="noqus" style="display:none;height:100px;">-->
                               <!--   <h4 class="tdata">No Question Available</h4>-->
                               <!--  </div>-->
                              @foreach($qt_ques as $ques_paper)
                              <?php
                               $half_quiz = DB::table('half_student_quiz')
                                              ->where('test_id',$id)
                                             ->where('user_id',$userid)
                                                ->where('paper_id',$paperid)
                                             //  ->where('question_id',$ques_paper->id)
                                                 ->where('sr_no',$i)
                                                ->where('section_name', 'like', "%quantitative%")
                                                ->orderBy('id','desc')
                                               ->first(); 
                                             // dd($half_quiz);
                              ?>
                              <div class="question qdata{{$i}}" class="question{{$i}}">
                                 <input type ="hidden" class ="ssnm" name ="ssname" data-sname ="{{$ques_paper->section_name}}">
                                 <input type ="hidden"  name ="level[]" value="{{$ques_paper->level}}">
                                 @if(empty($ques_paper->instruction) || ($ques_paper->instruction == 'empty'))
                                 <!--startinc-->
                                 <div class=" data ansvalue">
                                    <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                                    <input type="hidden" name="question_id[]" value="{{$ques_paper->id}}">
                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                    <input type="hidden" name="question_type[]" value="multiple">
                                    @if($ques_paper->status == 1)
                                    <ol class="choices list-group">
                                       <?php
                                          $ansstr = $ques_paper->answer;
                                          $ans = explode(",",$ansstr);
                                          $lk =1;
                                          ?>
                                       @foreach($ans as $value)
                                       <!-- <li class="list-group-item">
                                         <label>
                                             <input type="radio" class="ans rem re{{$i}} shans{{$lk}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == $lk) ? $half_quiz->answer : '' }}" data-main="{{$lk}}"  {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>&nbsp;{{$value}}
                                          </label>
                                       </li> -->
                                       <li class="list-group-item ">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans{{$lk}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == $lk) ? $half_quiz->answer : '' }}" data-main="{{$lk}}"  {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          {{$value}}
                                          </label>
                                       </div></li>
                                       <?php $lk++; ?>
                                       @endforeach
                                    </ol>
                                    @else
                                    <ol  class="choices list-group">
                                      @if($ques_paper->option1 || $ques_paper->option1 == 0)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]"value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}" data-main="1" data-main="1"  {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]"value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}" data-main="1" data-main="1"  {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                      @endif
                                         @if($ques_paper->option2 || $ques_paper->option2 == 0)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}"   data-main="2"  {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}"   data-main="2"  {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?> 
                                          </label>
                                       </div></li>
                                       @endif
                                        @if($ques_paper->option3 || $ques_paper->option3 == 0)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans3" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}"  data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans3" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}"  data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                       @endif
                                        @if($ques_paper->option4 || $ques_paper->option4 == 0)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans4" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) &&($half_quiz->answer == 4) ? $half_quiz->answer : '' }}" data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans4" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) &&($half_quiz->answer == 4) ? $half_quiz->answer : '' }}" data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }}/>
                                          <label class="form-check-label">
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                       @endif
                                       @if($ques_paper->option5)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans5" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}"  data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-inputans ans rem re{{$i}} shans5" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}"  data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                       
                                       @endif
                                    </ol>
                                    @endif 
                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                    <input type="hidden" name="question_type[]" value="numerical">
                                    <br/>
                                    <!-- <div><b>Answer</b></div> -->
                                    <!--<input type ="text" class="ansi exampledata rem" name ="answer[]"  data-value1="{{$i}}"/>-->
                                    <!--<div class="virtual-keyboard"></div>-->
                                     <div class="input-numeric-container">
                                        <input class="input-numeric ansi exampledatat rem re{{$i}}" name ="answer[{{$i}}]"  data-value1="{{$i}}" type="number" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}" />
                                         <table class="table-numeric">
                                            <tbody>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="1" data-n="{{$i}}">1</button></td>
                                                    <td><button type="button" class="key newkey" data-key="2" data-n="{{$i}}">2</button></td>
                                                    <td><button type="button" class="key newkey" data-key="3"data-n="{{$i}}">3</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="4"data-n="{{$i}}">4</button></td>
                                                    <td><button type="button" class="key newkey" data-key="5"data-n="{{$i}}">5</button></td>
                                                    <td><button type="button" class="key newkey" data-key="6"data-n="{{$i}}">6</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="7"data-n="{{$i}}">7</button></td>
                                                    <td><button type="button" class="key newkey" data-key="8"data-n="{{$i}}">8</button></td>
                                                    <td><button type="button" class="key newkey" data-key="9"data-n="{{$i}}">9</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key-del newkey" disabled data-n="{{$i}}">Del</button></td>
                                                    <td><button type="button" class="key newkey" data-key="0" data-n="{{$i}}">0</button></td>
                                                    <td><button type="button" class="key-clear newkey" disabled data-n="{{$i}}">Clear</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                    <input type="hidden" name="question_type[]" value="essay">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <b>ANSWER</b>
                                          <textarea  name = "answer[{{$i}}]"rows="4" class="ansi rem re{{$i}}" cols="50" style="height:200px;"placeholder="Write answer here..." class="form-control" data-value1="{{$i}}"></textarea>
                                       </div>
                                    </div>
                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                    <input type="hidden" name="question_type[]" value="fill_in_the_blanks">
                                    <br/>
                                    <b>ANSWER: </b>
                                    <input type ="text" class="ansi exampledata rem re{{$i}}" name ="answer[{{$i}}]" data-value1="{{$i}}" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}">
                                     <div class="virtual-keyboard"></div>
                                    @endif
                                 </div>
                                  <!--endinc-->
                                 @else
                                
                                  <!--newstartinc-->
                                   <div class="scroll" style="max-height: 500px; overflow-y: scroll;">
                                   <?= htmlspecialchars_decode($ques_paper->instruction) ?>
                                 </div>
                                  <div class="scroll ansvalue">
                                    <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                                    <input type="hidden" name="question_id[]" value="{{$ques_paper->id}}">
                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                    <input type="hidden" name="question_type[]" value="multiple">
                                    @if($ques_paper->status == 1)
                                    <ol  class="choices list-group">
                                       <?php
                                          $ansstr = $ques_paper->answer;
                                          $ans = explode(",",$ansstr);
                                          $lk =1;
                                          ?>
                                       @foreach($ans as $value)
                                       <!-- <li class="list-group-item">
                                          <label>
                                             <input type="radio" class="ans rem re{{$i}} shans{{$lk}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) &&($half_quiz->answer == $lk) ? $half_quiz->answer : '' }}" data-main="{{$lk}}"  data-main="{{$lk}}" {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>&nbsp;{{$value}}
                                          </label>
                                       </li> -->

                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans{{$lk}}" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) &&($half_quiz->answer == $lk) ? $half_quiz->answer : '' }}" data-main="{{$lk}}"  data-main="{{$lk}}" {{ isset($half_quiz) && ($half_quiz->answer == $lk) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          {{$value}} ?>
                                          </label>
                                       </div></li>
                                       <?php $lk++; ?>
                                       @endforeach
                                    </ol>
                                    @else
                                     <ol  class="choices list-group">
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}"   data-main="1" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans1" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 1) ? $half_quiz->answer : '' }}"   data-main="1" {{ isset($half_quiz) && ($half_quiz->answer == 1) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}" data-main="2" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }} />&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li>
                                       -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans2" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 2) ? $half_quiz->answer : '' }}" data-main="2" {{ isset($half_quiz) && ($half_quiz->answer == 2) ? 'checked' : '' }} />
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans3" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}" data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans3"  data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 3) ? $half_quiz->answer : '' }}" data-main="3" {{ isset($half_quiz) && ($half_quiz->answer == 3) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                      
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans4"   data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : '' }}"   data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }} />&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans4"   data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 4) ? $half_quiz->answer : '' }}" data-main="4" {{ isset($half_quiz) && ($half_quiz->answer == 4) ? 'checked' : '' }} />
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                       @if($ques_paper->option5)
                                       <!-- <li class="list-group-item"><input type="radio" class="ans rem re{{$i}} shans5" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}" data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>&nbsp;<span><?= htmlspecialchars_decode($ques_paper->option5) ?></label></li> -->
                                      
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input ans rem re{{$i}} shans5"  data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{ isset($half_quiz) && ($half_quiz->answer == 5) ? $half_quiz->answer : '' }}" data-main="5" {{ isset($half_quiz) && ($half_quiz->answer == 5) ? 'checked' : '' }}/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                       @endif
                                    </ol>
                                    @endif 
                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                    <input type="hidden" name="question_type[]" value="numerical">
                                    <br/>
                                    <!-- <b>ANSWER: </b> -->
                                    <!--<input type ="text" class="ansi exampledata rem" name ="answer[]"  data-value1="{{$i}}"/>-->
                                    <!--<div class="virtual-keyboard"></div>-->
                                     <div class="input-numeric-container">
                                       <input class="input-numeric ansi exampledatat rem re{{$i}}" name ="answer[{{$i}}]"  data-value1="{{$i}}" type="number" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}" />
                                        
                                        <table class="table-numeric">
                                            <tbody>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="1" data-n="{{$i}}">1</button></td>
                                                    <td><button type="button" class="key newkey" data-key="2" data-n="{{$i}}">2</button></td>
                                                    <td><button type="button" class="key newkey" data-key="3"data-n="{{$i}}">3</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="4"data-n="{{$i}}">4</button></td>
                                                    <td><button type="button" class="key newkey" data-key="5"data-n="{{$i}}">5</button></td>
                                                    <td><button type="button" class="key newkey" data-key="6"data-n="{{$i}}">6</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key newkey" data-key="7"data-n="{{$i}}">7</button></td>
                                                    <td><button type="button" class="key newkey" data-key="8"data-n="{{$i}}">8</button></td>
                                                    <td><button type="button" class="key newkey" data-key="9"data-n="{{$i}}">9</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" class="key-del newkey" disabled data-n="{{$i}}">Del</button></td>
                                                    <td><button type="button" class="key newkey" data-key="0" data-n="{{$i}}">0</button></td>
                                                    <td><button type="button" class="key-clear newkey" disabled data-n="{{$i}}">Clear</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                    <input type="hidden" name="question_type[]" value="essay">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <b>ANSWER</b>
                                          <textarea  name = "answer[{{$i}}]"rows="4" class="ansi rem re{{$i}}" cols="50" style="height:200px;"placeholder="Write answer here..." class="form-control" data-value1="{{$i}}"></textarea>
                                       </div>
                                    </div>
                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                    <input type="hidden" name="question_type[]" value="fill_in_the_blanks">
                                    <br/>
                                    <b>ANSWER: </b>
                                   <input type ="text" class="ansi exampledata rem re{{$i}}" name ="answer[{{$i}}]" data-value1="{{$i}}" value="{{ isset($half_quiz) ? $half_quiz->answer : '' }}">
                                     <div class="virtual-keyboard"></div>
                                    @endif
                                 </div>
                                   <!--newendinc-->
                                 @endif
                                   
                              </div>
                              <?php $i++; ?>
                              @endforeach
                           </div>
                        </div>
                        <div>
                           <input type="hidden" id="output" name="ans_duration" value="">
                           <input type="hidden" name="sdata">
                           <div style="width:100%; float:left; background:lightgrey;padding:10px 20px; border-radius:10px;" class="d-flex justify-content-around mt-3 ">
                              <!--<button type="button" class="btn btn-outline-secondary review" data-review=""> MARKED FOR REVIEW</button>-->
                              <?php
                              $testid= request()->id;
                              $pid= request()->paperid;
                              ?>
                              <button type="button" class="btn btn-outline-secondary review" data-review="" data-section="report" data-pid="{{$pid}}"data-tid="{{$testid}}">MARKED FOR REVIEW</button>
                              
                              <button type="button" class="btn btn-outline-secondary rev " data-rev=''>
                                  <!--<i class="fas fa-trash" style="font-size:18px;"></i>-->
                                  CLEAR
                                 </button>
                                 <button type="button" class="btn btn-primary next pagination "  data-save="">&nbsp;&nbsp;Save & Next</button>
                                <button type="button" class="btn btn-primary nextdata pagination"  data-save="" style="display:none;">Save & Next</button>
                           </div>
                           
                        </div>
                     </div>
                     <div class="col-lg-3" style="border-left:1px solid lightgrey; float:left; padding-left:10px; padding-top:10px;">
                        <?php $j =1; ?>
                        <div style="height:390px; overflow-y:scroll; margin-bottom:25px;">
                           <div id="divs" data-vt="{{$qt_ques}}">
                              @foreach($qt_ques as $verbal_quess)
                              <div class="sel{{$j}} ssm">
                              <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$j}}" class="qus btn btn-circle btn-lg sr{{$j}}"data-equ="{{$verbal_quess->id}}">{{$j}}</button>
                              <?php $j++; ?>
                           </div>
                              @endforeach
                              <?php
                              $half_data = DB::table('half_student_quiz')
                                    ->where('test_id',$id)
                                    ->where('user_id',$userid)
                                    ->where('paper_id',$paperid)
                                 // ->where('question_id',$verbal_quess->id)
                                    ->where('section_name', 'like', "%quantitative%")
                                    ->get(); 
                                 // dd($half_data);
                           ?>
                            <input type="hidden" name="check_color" class="check_color"data-half="{{ isset($half_data) ? $half_data : '' }}"> 
                            
                            <?php
                            $half_review = DB::table('ansmark_review')
                                    ->where('test_id',$id)
                                   // ->where('user_id',$userid)
                                ->where('ans_review',1)
                                    ->where('paper_id',$paperid)
                                 // ->where('review_id',$half_data1->sr_no)
                                    ->where('section_name', 'like', "%report%")
                                    ->orderBy('id','desc')
                                    ->get(); 
                            ?>
                             <input type="hidden" name="check_review" class="check_review"data-review="{{ isset($half_review) ? $half_review : '' }}">
                        </div>
                     </div>
                        <div margin-top:30px;>
                           <div class="indentation" style="width: 300px;">
                              <div style="height:20px; width:20px; background-color:green; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p style="font-size: 13px;">Answered</p>
                              </div>
                           </div>
                           <div class="indentation" style="width: 300px;">
                              <div style="height:20px; width:20px; background-color:red; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p style="font-size: 13px;">Not Answered</p>
                              </div>
                           </div>
                           <div class="indentation" style="width: 184px;">
                              <div style="height:20px; width:20px; background-color:purple; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p style="font-size: 13px;">Marked for review</p>
                              </div>
                           </div>
                           <div class="indentation" style="width: 300px;">
                              <div style="height:20px; width:20px; background-color:lightgray; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p style="font-size: 13px;">Not Visited</p>
                              </div>
                           </div>
                           <div class="indentation" style="width: 300px;"> 
                            <div style="height:20px; width:20px; background:linear-gradient(green, purple); border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p style="font-size: 13px;">Answered & Marked for review</p>
                              </div>
                           </div>
                           <?php
                              $id =request()->id;
                              ?>
                           <div style="margin-top:-30px; margin-bottom:10px;">
                              <!--<a href ="{{route('student.all-question',$id)}}" type="button" class="btn btn-md btn-default">ALL QUESTION</a>-->
                              <a class="btn btn-md btn-default allqus quesall">ALL QUESTIONS</a>
                              <!--<a  href ="{{route('student.quiz_instructions',$id)}}" type="button" class="btn btn-md btn-default ins">INSTRUCTION</a>-->
                              <a type="button" class="btn btn-md btn-default ins inst">INSTRUCTIONS</a>
                           </div>
                           <button type="button" class="btn subform disabled" style="width:100%; background-color:maroon; color:white"  data-toggle="modal" data-target="#submission" >
                           SUBMIT</button>
                        </div>
                     </div>
                  </div>
               </div>
                 <!--startquestion-->
                 <div class="row allqstd" style="display:none">
                <div class="col-md-12">
                    @foreach($qt_qus as $question)
                   <div class="choice">
                     @if(!empty($question->instruction))
                        <p><?= htmlspecialchars_decode($question->instruction) ?></p>
                     @else
                     @endif
                        <!-- <p>Q.1 of 22</p> -->
                        <p><b>Question</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                           @if($question->question_type == 'multiple'||$question->question_type == 'MULTI_CHOICE')

                           @if($question->status =='1')
                                    <ol class="choices list-group">
                                       <?php
                                          $ansstr = $question->answer;
                                          $ans = explode(",",$ansstr);
                                         
                                          ?>
                                       @foreach($ans as $value)
                                       <li class="list-group-item">
                                          <span>
                                          {{$value}}
                                          </span>
                                       </li>
                                       
                                       @endforeach
                                    </ol>
                                    @else

                                    <ol class="choices list-group">
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option1) ?></span></li>

                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option2) ?></span></li>
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option3) ?></span></li>
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option4) ?></span></li>
                                       @if($question->option5)
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option5) ?></span></li>
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
         $qt = 'report';
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
                       <a class ="submitbtn2" href="{{route('student.stop-quiz',['sid'=>$qt,'id'=>$id,'paperid'=>$paperid])}}">
                    <!-- <button type="button" class="modalbtn submitbtn">-->
                    <!--SUBMIT-->
                    <!-- </button>-->
                    <button type="button" class="modalbtn submitbtn">SUBMIT</button>
                    
                      <a  class ="submitbtn2" href="{{route('student.stop-quiz',['sid'=>$qt,'id'=>$id,'paperid'=>$paperid])}}" style="display:none">
                           <button type="button" class="modalbtn">NEXT</button>
                           </a>
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
                     <button type="button" class="btn btn-lg btn-success submitbtn1">
                     <a class ="submitbtn3" href="{{route('student.stop-quiz',['sid'=>$qt, 'id'=>$id,'paperid'=>$paperid])}}">SUBMIT</a>
                     </button>
                     <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>    
<!--endverbalsection-->
   @endif
</div>
<script type="text/javascript" src="{{asset('assets/admin/js/keyboard-initializer.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/keyboard-handler.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/numeric-keypad.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/calcu.js')}}"></script>
<script>
// $(document).ready(function() {
//   $('.sel1').addClass('selected');
//  // $('.selr').removeClass('selected');
// var divs = $('#divs > div');
//   output = $('#output');
//   var arr = $('#divs').attr('data-vt');
//   var  sert1 = [];
//   $.each(JSON.parse(arr), function(index, value) {
 
//       var sert = 0;
//       sert1.push(sert);
// });
//  // tarr = [0, 0, 0, 0];
//   tarr = sert1;
 
//   delay = 1000;
// divs.click(function() {
//   $(this).addClass('selected').siblings().removeClass('selected');
// });

// setInterval(function() {
//   var idx = divs.filter('.selected').index();
//   tarr[idx] = tarr[idx] + delay;
//   output.val(tarr);
// }, delay);
// });
//startnewtimer
// $(document).ready(function() {
//   $('.sel1').addClass('selected');
//    var divs = $('#divs > div');
//   // var di = $('#divs > div');
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
// second timer
// $(document).ready(function() {
//     var totaltime = $('.countdown').attr('data-time');
//     var milliseconds = totaltime * 60 * 1000;

//     $('.sel1').addClass('selected');
//     var divs = $('#divs > div');
//     var output = $('#output');
//     var arr = $('#divs').attr('data-vt');
//     var sert1 = [];

//     $.each(JSON.parse(arr), function(index, value) {
//         var sert = 0;
//         sert1.push(sert);
//     });

//     var tarr;
//     if (localStorage.getItem("tarr") !== null) {
//         tarr = localStorage.getItem("tarr").split(',');
//     } else {
//         tarr = sert1;
//     }

//     var delay = 1000;

//     divs.click(function() {
//         $(this).addClass('selected').siblings().removeClass('selected');
//     });

//     var timerInterval = setInterval(function() {
//         var idx = divs.filter('.selected').index();
//         tarr[idx] = parseInt(tarr[idx]) + delay;
//         output.val(tarr);

//         console.log(tarr);

//         // Check if any value in tarr exceeds the total time
//         var stopTimer = tarr.some(function(value) {
//             return parseInt(value) > milliseconds;
//         });

//         if (stopTimer) {
//             clearInterval(timerInterval); // Stop the timer interval
//             console.log("Timer stopped because a value in tarr exceeds total time.");
//         }
//     }, delay);
// });
//third timer

$(document).ready(function() {
  var totaltime = $('.countdown').attr('data-time');
  var milliseconds = totaltime * 60 * 1000;

  $('.sel1').addClass('selected');
  var divs = $('#divs > div');
  var output = $('#output');
  var arr = $('#divs').attr('data-vt');
  var sert1 = [];
  
  $.each(JSON.parse(arr), function(index, value) {
    var sert = 0;
    sert1.push(sert);
  });

  var tarr;
  if (localStorage.getItem("tarr") !== null) {  
    tarr = localStorage.getItem("tarr").split(',');         
  } else {
    tarr = sert1;
  }

  var delay = 1000;
  divs.click(function() {
    $(this).addClass('selected').siblings().removeClass('selected');
  });

  var timer = setInterval(function() {
    localStorage.setItem("tarr", tarr);
    var idx = divs.filter('.selected').index();
    tarr[idx] = parseInt(tarr[idx]) + delay;
    output.val(tarr);

   // console.log(tarr, "okk");

    // Check if sum of tarr elements equals milliseconds
    var sum = tarr.reduce((acc, curr) => acc + parseInt(curr), 0);
    if (sum >= milliseconds) {
   //  if (sum >= milliseconds) {
      clearInterval(timer); // Stop the timer
      console.log("Timer stopped.");
    }

  }, delay);
});

//endnewtimer
</script>
<script language="JavaScript">


        var version = navigator.appVersion;


        function showKeyCode(e) {
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
    // Check if the key combination is Ctrl + F
    if ((event.ctrlKey || event.metaKey) && event.keyCode === 70) { // 70 is the keyCode for the 'F' key
        // Prevent the default action
        event.preventDefault();
        // Optionally, you can add a message or perform any other action
        console.log("Ctrl + F is disabled");
    }
});

// $(window).on('keydown',function(event)
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


// $('.submitbtn').click(function() {
//     location.reload();
// });
</script>

@endsection
@section('css') 
@endsection