<?php
//dd($question->section_name);
$testid = $question->test_id;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
     <!-- <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script> -->
      <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
            <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/translations/es.js"></script>
    </script>
     <style>
        body {
            display: flex;
            flex-direction: column;
            margin-top: 1%;
            justify-content: center;
            align-items: center;
            
        }
 
        #rowAdder {
           margin-top:20px;
        }

         .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }
            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }
           
           
           /* Loader Styles */
         .loader {
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -20px;
            margin-top: 70px;
         }

         @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
         }

         /* Hide content initially */
         .hidden {
            display: none;
         }
         
        .option-row {
            width: 50%;
            float: left;
            margin-top: 20px;
            display: flex;
            align-items: flex-start;
            position: relative;
            overflow: visible;
        }
        
        .option-radio-box {
            width: 28px;
            min-width: 28px;
            padding-top: 5px;
            position: relative;
            z-index: 999999;
            pointer-events: auto;
        }
        
        .option-radio-box input[type="radio"] {
            width: 16px;
            height: 16px;
            margin: 0;
            display: block;
            position: relative;
            z-index: 999999;
            cursor: pointer;
            pointer-events: auto;
        }
        
        .option-radio-box label {
            position: absolute;
            top: 0;
            left: 0;
            width: 26px;
            height: 30px;
            cursor: pointer;
            z-index: 999999;
            pointer-events: auto;
        }
        
        .option-editor-box {
            flex: 1;
            min-width: 0;
            position: relative;
            z-index: 1;
        }
        
        .option-editor-box .ck-editor {
            width: 100%;
            position: relative;
            z-index: 1;
        }
        
        .option-delete-box {
            position: relative;
            z-index: 10;
        }
        
        @media (max-width: 768px) {
            .option-row {
                width: 100%;
            }
        }
    </style>
  </head>
  <body>
  
   <h5>Question No:-{{$sr}}</h5>
  <div class="card-header text-center" style="border:1px solid black;">{{$question->section_name}}</div>
  <div class="container-fluid col-md-10">
 
   @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
   @endif
   <?php
    $testsection = DB::table('test_sections')
                 ->where('test_id',$urlid)
               ->first();
   ?>
    @if(!empty($testsection))
      <a href="{{route('admin.new-testbuilder',['id'=>$urlid,'testtemp_id'=>$testsection->testtemp_id])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @else
     <a href="{{route('admin.testbuilder',['id'=>$urlid])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @endif
   <!--<a href="{{route('admin.testbuilder',['id'=>$urlid])}}"class="btn btn-primary" style="float:right;">All Question</a>-->
   
<?php 
$preid = $id-1;
$nextid = $id+1;
$psr = $sr-1;
$nsr = $sr+1;


if($question->question_type == 'MULTI_CHOICE' || $question->question_type == 'multiple'){
   $typ= 'multiple';

}
elseif($question->question_type == 'NUMERIC' || $question->question_type == 'numerical'){
   $typ= 'numerical';
}
elseif($question->question_type == 'essay' || $question->question_type == 'EASY'){
   $typ= 'EASY';
}

elseif($question->question_type == 'FILL_IN_THE_BLANKS' || $question->question_type == 'fill_in_the_blanks' ){
   $typ= 'fill_in_the_blanks';
}else{
   $typ = 1;
}

if($question->section_name == 'Verbal and Reading Comprehension' || $question->section_name == 'VERBAL ABILITY AND READING COMPREHENSION' || $question->section_name == 'VERBAL ABILITY AND READING COMPREHENSION'){
   $section= 'VERBAL ABILITY AND READING COMPREHENSION';

}
elseif($question->section_name == 'Data Interpretation & Logical Reasoning' || $question->section_name == 'DATA INTERPRETATION AND LOGICAL REASONING' || $question->section_name == 'DATA INTERPRETATION AND LOGICAL REASONING'){
   $section= 'DATA INTERPRETATION AND LOGICAL REASONING';
}
elseif($question->section_name == 'QUANTITATIVE ABILITY' || $question->section_name == 'Quantitative Aptitude' ||$question->section_name == 'Quantitative Ability'){
   $section= 'QUANTITATIVE ABILITY';
}else if($question->section_name == 'Language Skills' || $question->section_name == 'Language Skills'){

    $section= 'Language Skills';
}else if($question->section_name == 'Quantitative Skills' || $question->section_name == 'Quantitative Skills'){

    $section= 'Quantitative Skills';

 }else if($question->section_name == 'Logical Reasoning' || $question->section_name == 'Logical Reasoning'){

    $section= 'Logical Reasoning';
 }else{
    $section= 1; 
 }
if($typ == 1){
   die("Please Add Valid Question Type!");
}else{
   $typ = $typ;
 
}
 $testsection = DB::table('test_sections')
                 ->where('test_id',$urlid)
               ->first();
if($section == 1 && (empty($testsection))){
   die("Please Add Valid Section Type!");
}else{
   $section = $section;
 
}
//dd($question->section_name);
?>


   <a href="{{route('admin.editquestion',['urlid'=>$urlid,'id'=>$preid,'sr'=>$psr])}}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
   <a  class="btn btn-primary multiplechoice" data-type="{{$typ}}" data-section="{{$section}}"data-test="{{$testid}}">ADD NEW</a>
   <!-- <a href="{{route('admin.editquestion',['urlid'=>$urlid,'id'=>$nextid,'sr'=>$nsr])}}" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i></a> -->
   
    <a href="{{route('admin.editquestion',['urlid'=>$urlid,'id'=>$nextid,'sr'=>$nsr])}}" class="btn btn-primary last" data-last = "{{$last}}"><i class="fa fa-arrow-right" aria-hidden="true" disabled=""></i></a><p class="newtest"></p>
    
   <?php
   $data = DB::table('excel_questions')
            ->where('id',$question->id)
            ->first();
   ?>

<div class="card-body" style="border:1px solid black; margin-top:40px;">
   <!-- Basic Body  -->
   <form action="{{route('admin.updatequestion')}}" method="post" enctype="multipart/form-data">
      @csrf
      <!-- <div class="col-md-6">
       
      </div> -->
   <div id="editor_div">
      <input type="hidden" name= "id"  value="{{$id}}"class="">
      <input type="hidden" name= "test_id"  value="{{$testid}}"class="">
      <input type="hidden" name= "question_type"  value="{{$question->question_type}}"class="">
      <input type="hidden" name= "section_name"  value="{{$question->section_name}}"class="">
      <input type="hidden" name= "status"  value="{{$question->status}}" class="">
      <div class="row">
      <div class="form-group col-md-3">
           <label for="sel1" class="form-contol pt-2 col-md-12" >DIFFICULTY LEVEL</label>
         <select class="form-control col-md-12" name = "level">
            <option value="INTENSE" {{ strtolower($data->level) == strtolower('INTENSE') ? 'selected' : '' }}>Difficult</option>
            <option value="MEDIUM" {{ strtolower($data->level) == strtolower('MEDIUM') ? 'selected' : '' }}>Intermediate</option>
            <option value="EASY" {{ strtolower($data->level) == strtolower('EASY') ? 'selected' : '' }}>Easy</option>
         </select>
      </div>
        <div class="form-group col-md-3">
          <label for="sel1" class="form-contol pt-2 col-md-12">TAG QUESTION</label>
         <select class="form-control col-md-12" name = "tag">
   <option value="VERBAL ABILITY AND READING COMPREHENSION" {{ strtolower(explode(' ', $data->section_name)[0]) == strtolower('VERBAL') ? 'selected' : '' }}>VERBAL ABILITY AND READING COMPREHENSION</option> 
    <option value="DATA INTERPRETATION AND LOGICAL REASONING" {{ strtolower(explode(' ', $data->section_name)[0]) == strtolower('DATA') ? 'selected' : '' }}>DATA INTERPRETATION AND LOGICAL REASONING</option>
            <option value="QUANTITATIVE ABILITY" {{ strtolower(explode(' ', $data->section_name)[0]) == strtolower('QUANTITATIVE') ? 'selected' : '' }}>QUANTITATIVE ABILITY</option>
         </select>
         </div>
         <br/>
         
         <div class ="form-group col-md-3">
             <label class="form-contol pt-2 col-md-6">MARKS</label>
             <div class="col-md-12">
                 <div class="row">
                <div class="col-md-6">
               <div class="input-group q-positive-div">
                 <span class="input-group-addon q-marks-label-text" id="basic-addon1"><i class="fa fa-plus" aria-hidden="true" style="margin-top:10px;"></i></span>
                 <input name = "positive_mark"  type="text" class="form-control key-checkDigit key-meta-attr q-marks-input-box" aria-describedby="basic-addon1" value="{{$question->positive_mark}}">
               </div>
            </div>
            <div class="col-md-6">
               <div class="input-group q-negative-div">
                 <span class="input-group-addon q-marks-label-text" id="basic-addon1"><i class="fa fa-minus" aria-hidden="true" style="margin-top:10px;"></i></span>
                 <input name="negative_mark" type="text" min="0" class="form-control key-checkDigit key-meta-attr q-marks-input-box" aria-describedby="basic-addon1" value="{{$question->negative_mark}}">
               </div>
            </div>
                 </div>
                  
             </div>
           
         </div>
            <div class="col-md-3">
                <label for="sel1" class="form-contol pt-2">GUIDELINE TIME</label>
                <input type="number" name= "answer_time" value="{{$question->answer_time}}"class="form-control">
            </div>
             <div class="col-md-12">
                <h4>Instruction*</h4>
                <textarea name ="instruction" id="editor17" cols="80" rows="10">{{$question->instruction}}</textarea>
            </div>
         </div>
         

      <!--start-->
      @if($question->question_type == 'multiple'|| $question->question_type == 'MULTI_CHOICE')
         <div class="multipletype">
               <h3>QUESTION*</h3>
               <div class="question-mul">
               <textarea name ="question" id="editor1" cols="80" rows="10">{{$question->question}}</textarea>
               </div>
              <p>CHOICE*</p>
            <div class="anschioce">
               <div class="col-lg-12">
                   @if($question->status == 1)
                    <?php
                      $ansstr = $question->answer;
                      $ans = explode(",",$ansstr);
                      $i =1;
                     ?>
                  @foreach($ans as $value)
                    <div id="row">
                        <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                           <input type="radio" name="correct_option"  value="{{$i}}" class="" {{  ($question->correct_option == $i ? ' checked' : '') }}>
                            <input type="text" name= "answer[]" value="{{$value}}" class="form-control m-input col-xl-12">
                            <div class="input-group-prepend">
                               <button class="btn btn-danger" id="DeleteRow" type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                  <?php
                 $i++;
                  ?>
                  @endforeach
                  @else
                 
                   <div id="row">
                        <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                           <input type="radio" name="correct_option"  value="1" class="" {{  ($question->correct_option == 1 ? ' checked' : '') }}>

                              <textarea name ="option1" id="edieditor1" cols="80" rows="10" class="form-control m-input col-xl-12">{{$question->option1}}</textarea>

                            <!-- <input type="text" name= "option1" value="<?= strip_tags($question->option1) ?>" class="form-control m-input col-xl-12"> -->

                            <div class="input-group-prepend">
                               <button class="btn btn-danger" id="DeleteRow" type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                      <div id="row">
                        <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                           <input type="radio" name="correct_option"  value="2" class="" {{  ($question->correct_option == 2 ? ' checked' : '') }}>

                            <!-- <input type="text" name= "option2" value="<?= strip_tags($question->option2) ?>" class="form-control m-input col-xl-12"> -->

                             <textarea name ="option2" id="edieditor2" cols="80" class="form-control m-input col-xl-12" rows="10">{{$question->option2}}</textarea>

                            <div class="input-group-prepend">
                               <button class="btn btn-danger" id="DeleteRow" type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                    <div id="row">
                        <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                           <input type="radio" name="correct_option"  value="3" class="" {{  ($question->correct_option == 3 ? ' checked' : '') }}>

                            <!-- <input type="text" name= "option3" value="<?= strip_tags($question->option3) ?>" class="form-control m-input col-xl-12"> -->

                             <textarea name ="option3" id="edieditor3" cols="80" class="form-control m-input col-xl-12" rows="10">{{$question->option3}}</textarea>

                            <div class="input-group-prepend">
                               <button class="btn btn-danger" id="DeleteRow" type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                    <div id="row">
                        <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                           <input type="radio" name="correct_option"  value="4" class="" {{  ($question->correct_option == 4 ? ' checked' : '') }}>

                            <!-- <input type="text" name= "option4" value="<?= strip_tags($question->option4) ?>" class="form-control m-input col-xl-12"> -->
                             <textarea name ="option4" id="edieditor4" cols="80" class="form-control m-input col-xl-12" rows="10">{{$question->option4}}</textarea>

                            <div class="input-group-prepend">
                               <button class="btn btn-danger" id="DeleteRow" type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                   
                    @if($question->option5)
                    <!-- <div id="row">-->
                    <!--    <div class="input-group col-md-6"  style="float:left; margin-top:20px;">-->
                    <!--        <input type="radio" name="correct_option"  value="5" class="" {{  ($question->correct_option == 5 ? ' checked' : '') }}>-->
                    <!--         <textarea name ="option5" id="edieditor5" cols="80" class="form-control m-input col-xl-12" rows="10">{{$question->option5}}</textarea>-->

                    <!--        <div class="input-group-prepend">-->
                    <!--           <button class="btn btn-danger" id="DeleteRow" type="button">-->
                    <!--              <i class="fa fa-times" aria-hidden="true"></i>-->
                    <!--           </button>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                        <div class="option-row option-five-row">
                            <div class="option-radio-box">
                                <input
                                    type="radio"
                                    id="correct_option_5"
                                    name="correct_option"
                                    value="5"
                                    {{ (int)$question->correct_option === 5 ? 'checked' : '' }}
                                >
                        
                                <label for="correct_option_5"></label>
                            </div>
                        
                            <div class="option-editor-box">
                                <textarea
                                    name="option5"
                                    id="edieditor5"
                                    cols="80"
                                    rows="10"
                                    class="form-control m-input"
                                >{{$question->option5}}</textarea>
                            </div>
                        
                            <div class="option-delete-box">
                                <button class="btn btn-danger delete-row-btn" type="button">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        
                        </div>
                    @endif
                  @endif
                  <div id="newinput"></div>
                     <button id="rowAdder" type="button" data-ans="{{$question->question_type}}" data-value = "{{$question->answer}}" class="btn btn-dark">
                     <!-- <span class="bi bi-plus-square-dotted">
                        </span> Add Choice -->
                     <i class="fa fa-plus" aria-hidden="true"></i>
                     </button>  
                  </div>
                     <a class="showdata1">EXPLANATION
                         <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
                    </a>
                     <div class="explanation">
                        <textarea name ="answer_explanation" rows="4" cols="50" id ="multieditor" class="form-control"><?= ($question->answer_explanation) ?></textarea>
                         <br/>
                        <lable>Video Link</label>
                        <input type="text" name="video_link" value="{{$question->video_link}}" placeholder="enter link">
                     </div>
               </div>
            </div>
      @elseif($question->question_type == 'numerical'|| $question->question_type == 'NUMERIC')
         <div class="numericaltype">
         <h3>QUESTION*</h3>
            <div class="question-num">
            <textarea cols="80" name="question" rows="10" id="editor1">{{$question->question}}</textarea>
            </div>
            <p>ANSWER*</p>
            <div class="ans-num">
               <input type ="text"name ="correct_option" value="<?= strip_tags($question->correct_option) ?>" class="form-control">
            </div>
             <a class="showdata">EXPLANATION
                <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
              </a>
               <div class="explanation" >
                  <textarea name ="answer_explanation" rows="4" cols="50" id ="numeditor" class="form-control"><?= ($question->answer_explanation) ?></textarea>
                  <br/>
                        <lable>Video Link</label>
                        <input type="text" name="video_link" value="{{$question->video_link}}" placeholder="enter link">
               </div>
         </div>
      @elseif($question->question_type == 'essay'||$question->question_type == 'ESSAY')
         <div class="essaytype">
            <h3>QUESTION*</h3>
            <div class="question-num">
            <textarea cols="80" id="editor1" name="question" rows="10"></textarea>
            </div>
            <p>EVALUATION CRITERIA*</p>
            <div class="ans-essay">
            <div class="col-lg-12">
                 @if($question->status == 1)
                    <?php
                      $perstr = $question->percentage;
                      $per = explode(",",$perstr);
                      $ctrstr = $question->criteria;
                      $ctr = explode(",",$ctrstr);
                      $j =1;
                     ?>
                       @foreach($per as $pers)
                    <div id="row">
                        <div class="input-group m-3">
                            <div class="col-md-6">
                               <input type="text" name= "percentage[]" value="{{$pers}}" class="form-control m-input" placeholder="Criteria">
                            </div>
                            <div class="col-md-4">
                               <label class="form-group">
                                  <input type="number" name="criteria[]" class="form-control" placeholder="Percentage for this criteria">
                               </label>
                            </div>
                            
                            <div class="col-md-2">
                               <div class="input-group-prepend">
                                  <button class="btn btn-danger"
                                     id="DeleteRow"
                                     type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                     <div id="row">
                        <div class="input-group m-3">
                            <div class="col-md-6">
                               <input type="text" name= "percentage1" value="{{$question->percentage1}}" class="form-control m-input" placeholder="Criteria">
                            </div>
                            <div class="col-md-4">
                               <label class="form-group">
                                  <input type="number" name="criteria1" value="{{$question->criteria1}}" class="form-control" placeholder="Percentage for this criteria">
                               </label>
                            </div>
                            <div class="col-md-2">
                               <div class="input-group-prepend">
                                  <button class="btn btn-danger"
                                     id="DeleteRow"
                                     type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                     <div id="row">
                        <div class="input-group m-3">
                            <div class="col-md-6">
                               <input type="text" name= "percentage2" value="{{$question->percentage2}}" class="form-control m-input" placeholder="Criteria">
                            </div>
                            <div class="col-md-4">
                               <label class="form-group">
                                  <input type="number" name="criteria2" value="{{$question->criteria2}}" class="form-control" placeholder="Percentage for this criteria">
                               </label>
                            </div>
                            <div class="col-md-2">
                               <div class="input-group-prepend">
                                  <button class="btn btn-danger"
                                     id="DeleteRow"
                                     type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                     <div id="row">
                        <div class="input-group m-3">
                            <div class="col-md-6">
                               <input type="text" name= "percentage3" value="{{$question->percentage3}}" class="form-control m-input" placeholder="Criteria">
                            </div>
                            <div class="col-md-4">
                               <label class="form-group">
                                  <input type="number" name="criteria3" value="{{$question->criteria3}}" class="form-control" placeholder="Percentage for this criteria">
                               </label>
                            </div>
                            <div class="col-md-2">
                               <div class="input-group-prepend">
                                  <button class="btn btn-danger"
                                     id="DeleteRow"
                                     type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                     <div id="row">
                        <div class="input-group m-3">
                            <div class="col-md-6">
                               <input type="text" name= "percentage4" value="{{$question->percentage4}}" class="form-control m-input" placeholder="Criteria">
                            </div>
                            <div class="col-md-4">
                               <label class="form-group">
                                  <input type="number" name="criteria4" value="{{$question->criteria4}}" class="form-control" placeholder="Percentage for this criteria">
                               </label>
                            </div>
                            <div class="col-md-2">
                               <div class="input-group-prepend">
                                  <button class="btn btn-danger"
                                     id="DeleteRow"
                                     type="button">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                    @endif
                  <div id="newinput"></div>
                  <button id="rowAdder" data-ans="{{$question->question_type}}" type="button" class="btn btn-dark">
                     <!-- <span class="bi bi-plus-square-dotted">
                        </span> Add Choice -->
                     <i class="fa fa-plus" aria-hidden="true"></i>
                  </button>
               </div>
               <a class="showdata">EXPLANATION
                <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
              </a>
               <div class="explanation" >
                  <textarea name ="answer_explanation" rows="4" cols="50" id ="esseditor"class="form-control"><?= ($question->answer_explanation) ?></textarea>
                  <br/>
                        <lable>Video Link</label>
                        <input type="text" name="video_link" value="{{$question->video_link}}" placeholder="enter link">
               </div>
            </div>
         </div>
         @elseif($question->question_type == 'fill_in_the_blanks'|| $question->question_type =='FILL_IN_THE_BLANKS' || $question->question_type == 'Fill_in_the_blanks')
         <div class="fill_blank">
            <div class="question-blank">
            <textarea cols="80" id="editor1" name="question" rows="10">{{$question->question}}</textarea>
            </div>
            <p>ANSWER*</p>
            <div class="ans-blank">
               <input type ="text"name ="correct_option" value="{{$question->correct_option}}" class="form-control">
            </div>
            <a class="showdata">EXPLANATION
             <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
           </a>
            <div class="explanation" >
               <textarea name ="answer_explanation" rows="4" cols="50" id ="filleditor" class="form-control"><?= ($question->answer_explanation) ?></textarea>
               <br/>
                <lable>Video Link</label>
                <input type="text" name="video_link" value="{{$question->video_link}}" placeholder="enter link">
            </div>
         </div>
      @endif
      <!--end-->
      <br/>
      <button type="submit" id ="" class="btn btn-primary btn-lg" style="width:100px; margin-left:45%;">Save</button>
   </div>
      </form>
   <!--end Basic Body  -->
</div>
</div> 
</div>
<!-- </div> -->
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    
    setTimeout(() => {
        hideLoader();
        showContent();
    }, 3000); 

      function hideLoader() {
        const loader = document.getElementById("loader");
        loader.style.display = "none";
      }

      function showContent() {
        const content = document.getElementById("content");
        content.style.display = "block";
      }
});

</script>



<script>
    CKEDITOR.replace('editor1', {
      fullPage: true,
      extraPlugins: 'docprops',
      allowedContent: true,
      height: 320,
      removeButtons: 'PasteFromWord'
    });
  </script>
  <script>
    CKEDITOR.replace('editor17', {
      fullPage: true,
      extraPlugins: 'docprops',
      allowedContent: true,
      height: 320,
      removeButtons: 'PasteFromWord'
    });
  </script>

<script>
   var ckt = 1;
   var edito = 2;
   var op = 1;
   $("#rowAdder").click(function () {
       ckt +=1;
      edito +=1;
      op +=1;
      var paper_type = $(this).attr('data-ans');
      if(paper_type == 'multiple' || paper_type == 'MULTI_CHOICE')
      {
         newRowAdd =
            '<div id="row"> <div class="input-group col-md-6"  style="float:left; margin-top:20px;">' +
            ' <input type="radio" name="correct_option"  value="'+ckt+'"  class=""><textarea name ="option'+op+'" id="editor'+edito+'" cols="80" rows="10"></textarea>'+
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            ' <i class="fa fa-times" aria-hidden="true"></i></button> </div>' +
            '</div> </div>';
      }else if(paper_type == 'essay'|| paper_type == 'Essay'){
         newRowAdd =
            '<div id="row"> <div class="input-group m-3">' +
            '<div class="col-md-6"><input type="text" name= "percentage[]" class="form-control m-input" placeholder="criteria"></div>'+ 
            '<div class="col-md-4"><label class="form-group"><input type="number" class="form-control" name="criteria[]"placeholder="Percentage for this criteria"></label></div>'+
            '<div class="col-md-2"><div class="input-group-prepend"></div>' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            ' <i class="fa fa-times" aria-hidden="true"></i></button> </div>' +
            '</div> </div>';
      }
     

      $('#newinput').append(newRowAdd);
   });
   $("body").on("click", "#DeleteRow", function () {
      $(this).parents("#row").remove();
   })
</script>
<script>
$(document).ready(function(){
     $('.showdata').click(function(){
       $('.explanation').toggle("slide");

     });
});
   </script>
  </body>
   <script type="text/javascript" src="{{asset('assets/admin/js/ck.js')}}"></script>
<script>



$(document).ready(function(){
   $('.multiplechoice').click(function(){
     var mul = $(this).attr('data-type');
     var dataval = $(this).attr('data-section');
      var testid = $(this).attr('data-test');
     if(mul){
          var url = "{{ route('admin.questionbuilder', [':slug', ':mul', ':id']) }}";
          url = url.replace(':slug', dataval);
          url = url.replace(':mul', mul);
          url = url.replace(':id', testid);
          window.location.href=url;
      } 
          
   });
});
           

</script>

<script>
   $(document).ready(function(){
      $(".last").mouseenter(function(){
         var last= $(this).attr('data-last');
         if(last == 1){
                  $('.newtest').text('last question');
                  $('.last').css("display","none");
               }else{

               }
         //$("p").css("background-color", "yellow");
      });
   });
</script>
</html>