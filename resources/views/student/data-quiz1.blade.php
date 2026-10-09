	
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
   width: 954px;
   height: 490px;
   overflow-y: auto;
   overflow-x: hidden;
   text-align:justify;
   }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div>
   @if($section_time->duration == 'section_duration') 
   <!--startverbalsection-->
   <div class ="data-formdata" >
      <form action="" class="verbal" method = "post">
         <div class="col-md-12">
            <?php
               $id =request()->id;
               $userid =session()->get('id');
               $tests = DB::table('tests')->where('id',$id)->first(); 
               $test_templates = DB::table('test_templatevalues')->where('temp_id',$tests->testtempid)->first(); 
               ?>
            <div class="container-fluid verbal" >
               <input type="hidden" name="test">
               <div class="row" style="border-bottom:2px solid lightgrey;">
                  <div class="col-md-1" style="border-right:2px solid lightgray; float:left">
                     <button class="btn btn-default iconclose" data-toggle="modal" data-target="#exit"><i class="fa fa-close"></i></button>
                  </div>
                  <div class="col-md-6">
                     <input type="hidden" name="test_id" value="{{$id}}">
                     <input type="hidden" name="user_id" value="{{$userid}}">
                     <input type="hidden" name="section_type" value="data">
                     <input type="hidden" name="student_duration" value="{{$section_time->interp_time}}">
                     <input type="hidden" name="paper_id" value="{{$paperid}}">
                     <h5 style=" PADDING-TOP:5PX;">{{$tests->test}}{{$tests->testincid}}</h5>
                  </div>
                  <div class="col-md-3" STYLE="border-right:2px solid lightgray;">
                     <h5 style="margin-left:45%; PADDING-TOP:5PX;">
                        Time :
                        <!-- <span id="timer"></span> -->
                        <span class="countdown" data-time="{{$section_time->interp_time}}"></span>
                     </h5>
                  </div>
                  <div class="col-md-2">
                     <h5 style=" PADDING-TOP:4PX;">MBA Guru</h5>
                  </div>
               </div>
               <div class="form">
                  <div class="row">
                     <div class="col-md-9">
                        <div style="padding:10px 0px;  border-bottom:2px solid lightgrey;">
                           <button type="button" class="sname btn btn-outline-secondary"> 
                           </button>
                           <button type="button" class="btn btn-outline-primary">+2 SECTIONS</button>
                           <div id="dvAccordion">
                              <i class="fa fa-calculator accordion1 clossed fa-2x" style="float:right"></i>
                              <div class="calculator default">
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
                        <div style="height:490px;">
                           <?php
                              $i= 1;
                              ?>
                           <div class="data">
                              @foreach($data_ques as $ques_paper)
                              <div class="question qdata{{$i}}" class="question{{$i}}">
                                 <input type ="hidden" class ="ssnm" name ="ssname" data-sname ="{{$ques_paper->section_name}}">
                                 @if(!empty($ques_paper->instruction))
                                 <div class="scroll" style="max-height: 500px; overflow-y: scroll;">
                                    <?= htmlspecialchars_decode($ques_paper->instruction) ?>
                                 </div>
                                  <div class="scroll ansvalue">
                                    <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                                    <input type="hidden" name="question_id[]" value="{{$ques_paper->id}}">
                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                    <input type="hidden" name="question_type[]" value="multiple">
                                    @if($ques_paper->status == 1)
                                    <ol class="choices">
                                       <?php
                                          $ansstr = $ques_paper->answer;
                                          $ans = explode(",",$ansstr);
                                          $lk =1;
                                          ?>
                                       @foreach($ans as $value)
                                       <li>
                                          <label>
                                          <input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{$lk}}" />&nbsp;{{$value}}
                                          </label>
                                       </li>
                                       <?php $lk++; ?>
                                       @endforeach
                                    </ol>
                                    @else
                                    <ol class="choices">
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="1" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option1) ?></label></li>

                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="2" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option2) ?></label></li>
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="3" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option3) ?></label></li>
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="4" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option4) ?></label></li>
                                       @if($ques_paper->option5)
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="5" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option5) ?></label></li>
                                       @endif
                                    </ol>
                                    @endif 
                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                    <input type="hidden" name="question_type[]" value="numerical">
                                    <b>ANSWER: </b>
                                    <input type ="text" class="ansi use-keyboard-input" name ="answer[]"  data-value1="{{$i}}"/>
                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                    <input type="hidden" name="question_type[]" value="essay">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <b>ANSWER</b>
                                          <textarea  name = "answer[]"rows="4" class="ansi" cols="50" style="height:200px;"placeholder="Write answer here..." class="form-control" data-value1="{{$i}}"></textarea>
                                       </div>
                                    </div>
                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                    <input type="hidden" name="question_type[]" value="fill_in_the_blanks">
                                    <b>ANSWER: </b>
                                    <input type ="text" class="ansi use-keyboard-input" name ="answer[]" data-value1="{{$i}}">
                                    @endif
                                 </div>
                                 @else
                                 <div class="ansvalue">
                                    <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                                    <input type="hidden" name="question_id[]" value="{{$ques_paper->id}}">
                                    @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                    <input type="hidden" name="question_type[]" value="multiple">
                                    @if($ques_paper->status == 1)
                                    <ol class="choices">
                                       <?php
                                          $ansstr = $ques_paper->answer;
                                          $ans = explode(",",$ansstr);
                                          $lk =1;
                                          ?>
                                       @foreach($ans as $value)
                                       <li>
                                          <label>
                                          <input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="{{$lk}}" />&nbsp;{{$value}}
                                          </label>
                                       </li>
                                       <?php $lk++; ?>
                                       @endforeach
                                    </ol>
                                    @else
                                    <ol class="choices">
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="1" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option1) ?></label></li>

                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="2" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option2) ?></label></li>
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="3" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option3) ?></label></li>
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="4" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option4) ?></label></li>
                                       @if($ques_paper->option5)
                                       <li><input type="radio" class="ans" data-value="{{$i}}" name="answer[<?php echo $i; ?>]" value="5" />&nbsp;<label><?= htmlspecialchars_decode($ques_paper->option5) ?></label></li>
                                       @endif
                                    </ol>
                                    @endif 
                                    @elseif($ques_paper->question_type =='NUMERIC'|| ($ques_paper->question_type =='numerical'))
                                    <input type="hidden" name="question_type[]" value="numerical">
                                    <b>ANSWER: </b>
                                    <input type ="text" class="ansi use-keyboard-input" name ="answer[]"  data-value1="{{$i}}"/>
                                    @elseif($ques_paper->question_type =='essay' || $ques_paper->question_type =='ESSAY')
                                    <input type="hidden" name="question_type[]" value="essay">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <b>ANSWER</b>
                                          <textarea  name = "answer[]"rows="4" class="ansi" cols="50" style="height:200px;"placeholder="Write answer here..." class="form-control" data-value1="{{$i}}"></textarea>
                                       </div>
                                    </div>
                                    @elseif($ques_paper->question_type =='FILL_IN_THE_BLANKS' || ($ques_paper->question_type =='fill_in_the_blanks'))
                                    <input type="hidden" name="question_type[]" value="fill_in_the_blanks">
                                    <b>ANSWER: </b>
                                    <input type ="text" class="ansi use-keyboard-input" name ="answer[]" data-value1="{{$i}}">
                                    @endif
                                 </div>
                                 @endif
                              </div>
                              <?php $i++; ?>
                              @endforeach
                           </div>
                        </div>
                        <div>
                           <input type="hidden" id="output" name="ans_duration" value="">
                           <input type="hidden" name="sdata">
                           <div style="width:40%; float:left">
                              <button type="button" class="btn btn-default review" data-review=""><i class="fa fa-star-o" style="font-size:18px;"></i>MARKED FOR REVIEW</button>
                              <button type="button" class="btn btn-default"><i class="fas fa-trash" style="font-size:18px;"></i>CLEAR</button>
                           </div>
                           <div style="width:20%; margin-left:10%; float:left;" class="pagination">
                              <a class="prev" href="#"><i class="fa-solid fa-caret-left"></i></a>
                              <p>1 OF 24</p>
                              <a class="next" href="#"><i class="fa-solid fa-caret-right"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-3"  style="">
                        <?php $j =1; ?>
                        <!--  <div style="height:360px;">
                           @foreach($data_ques as $verbal_quess)
                           <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$j}}" class="qus btn btn-circle btn-lg sr{{$j}}">{{$j}}</button>
                           <?php $j++; ?>
                           @endforeach
                        </div> -->
                        <div style="height:360px; ">
                           <div id="divs" data-vt="{{$data_ques}}">
                              @foreach($data_ques as $verbal_quess)
                              <div class="sel{{$j}}">
                                 <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$j}}" class="qus btn btn-circle btn-lg sr{{$j}}">{{$j}}</button>
                                 <?php $j++; ?>
                              </div>
                              @endforeach
                           </div>
                        </div>

                        <div>
                           <div class="indentation">
                              <div style="height:20px; width:20px; background-color:green; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p>Answered</p>
                              </div>
                           </div>
                           <div class="indentation">
                              <div style="height:20px; width:20px; background-color:red; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p>Not Answered</p>
                              </div>
                           </div>
                           <div class="indentation" style="width:60%;">
                              <div style="height:20px; width:20px; background-color:purple; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p>Marked for review</p>
                              </div>
                           </div>
                           <div class="indentation" style="width:40%;">
                              <div style="height:20px; width:20px; background-color:lightgray; border-radius:50%; margin:5px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p>Not Visited</p>
                              </div>
                           </div>
                           <div>
                              <div style="height:20px; width:20px; background-color:green; border-radius:50%; margin:5px; float:left"></div>
                              <div style="height:15px; width:15px; background-color:purple; border-radius:50%; margin-left:-16px; margin-top:12px; float:left"></div>
                              <div style="float:left; margin-top:4px">
                                 <p>Answered & Marked for review</p>
                              </div>
                           </div>
                           <?php
                              $id =request()->id;
                              ?>
                           <div style="margin-top:-30px; margin-bottom:10px;">
                              <a href ="{{route('student.all-question',$id)}}" type="button" class="btn btn-md btn-default">ALL QUESTION</a>
                              <a  href ="{{route('student.instructions',$id)}}" type="button" class="btn btn-md btn-default ins">INSTRUCTION</a>
                           </div>
                           <button type="button" class="btn subform disabled" style="width:100%; background-color:maroon; color:white"  data-toggle="modal" data-target="#submission" >
                           SUBMIT</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php
            $qt = 'quantitative';
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
                     <button type="button" class="modalbtn submitbtn">
                     <a class ="submitbtn3" href="{{route('student.stop-quiz',['sid'=>$qt,'id'=>$id,'paperid'=>$paperid])}}">SUBMIT</a>
                     </button>
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
                     <a class ="submitbtn3" href="{{route('student.stop-quiz',['sid'=>$qt,'id'=>$id,'paperid'=>$paperid])}}">SUBMIT</a>
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
<script type="text/javascript" src="{{asset('assets/admin/js/calcu.js')}}"></script>

<script>
$(document).ready(function() {
  $('.sel1').addClass('selected');
 // $('.selr').removeClass('selected');
var divs = $('#divs > div');
  output = $('#output');
  var arr = $('#divs').attr('data-vt');
  var  sert1 = [];
  $.each(JSON.parse(arr), function(index, value) {
 
      var sert = 0;
      sert1.push(sert);
});
 // tarr = [0, 0, 0, 0];
  tarr = sert1;
 
  delay = 1000;
divs.click(function() {
  $(this).addClass('selected').siblings().removeClass('selected');
});

setInterval(function() {
  var idx = divs.filter('.selected').index();
  //console.log(idx);
  tarr[idx] = tarr[idx] + delay;
  // tarr[idx] = tarr[idx]/1000;
  output.val(tarr);
}, delay);
});
</script>
@endsection
@section('css') 
@endsection