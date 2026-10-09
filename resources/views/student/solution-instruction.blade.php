@extends('student_template')
@section('css')
@endsection
@section('content')
<style>
     .scroll
  {
    float:left; 
    height:590px;
    overflow-x:scroll;
  }
  .btneditor
  {
    margin-left:670px; 
    margin-top:30px; 
    position:absolute; 
}
#heading
{
     color: blue;
    font-size: 20px;
    font-weight: 600;ue;
}
</style>

<div class="container verbal">
<div class="container" style=" border: 2px solid black;border-radius: 10px; margin-top: 20px;padding: 10px 10px;margin-bottom:12px;">
        <div class="instruction">
   <?php
      $i =1;
      $sectionid =request()->sectionid;
      $paperid =request()->paperid;
      $testid =request()->testid;
      //dd( $sectionid);
      ?>
   <div class="row" style="border-bottom:2px solid lightgrey">
      <div class="col-md-1" style="border-right:2px solid lightgray; float:left">
         @if($sectionid ==1)
         <a class="btn btn-default" href="{{route('student.solution',['testid'=>$testid,'paperid'=>$paperid])}}">
         <i class="fa fa-close"></i>
         </a>
         @elseif($sectionid == 2)
         <a class="btn btn-default" href="{{route('student.datasolution',['testid'=>$testid,'paperid'=>$paperid])}}">
         <i class="fa fa-close"></i>
         </a>
         @else
         <a class="btn btn-default" href="{{route('student.qtsolution',['testid'=>$testid,'paperid'=>$paperid])}}">
         <i class="fa fa-close"></i>
         </a>
         @endif
      </div>
   </div>
   <!--startinst-->
   <div class="col-md-12">
      <h3 style="background-color:maroon; color:white; padding:10px 10px;border-radius: 10px;margin-top:10px;">INSTRUCTION</h3>
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
</div>
</div>
<!--endinst-->
@endsection
@section('css') 
@endsection