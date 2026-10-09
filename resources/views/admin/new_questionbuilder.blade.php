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
    </style>
  </head>
  <?php
  $id = request()->id;
  $testid = request()->testid;
  $testtempid = request()->testtemp_id;
  $type = request()->type;
  $section_name = DB::table('test_sections')->select('section_name','id')->where('id',$id)->first();
  $sections = DB::table('test_sections')->where('test_id',$testid)->get();
  ?>
  <body>
  <div class="card-header text-center" style="border:1px solid black;">{{$section_name->section_name}}</div>
  <div class="container-fluid col-md-10">
   @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <a  href="{{route('admin.new-testbuilder',['id'=>$testid,'testtemp_id'=>$testtempid])}}" class="btn btn-primary" style="float:right;">All Question</a>
     
        
    <!-- <div class="alert alert-danger"> -->
  
           @if ($errors->has('question'))
            <li>{{ $errors->first('question') }}</li>
         @endif
        
    <!-- </div> -->

          <div class="card-body" style="border:1px solid black; margin-top:40px;">
   <!-- Basic Body  -->
   <form action="{{route('admin.savequestion')}}" method="post" enctype="multipart/form-data">
      @csrf
      <!-- <div class="col-md-6">
      </div> -->
   <div id="editor_div">
      <input type="hidden" name= "test_id"  value="{{$testid}}"class="">
      <input type="hidden" name= "question_type"  value="{{$type}}"class="">
      <input type="hidden" name= "section_name"  value="{{$section_name->section_name}}"class="">
      <input type="hidden" name= "status"  value=""class="">
      <div class="row">
      <div class="form-group col-md-3">
           <label for="sel1" class="form-contol pt-2 col-md-12" >DIFFICULTY LEVEL</label>
         <select class="form-control col-md-12" name = "level">
         <option value="INTENSE">Difficult</option>
         <option value="MEDIUM">Intermediate</option>
         <option value="EASY">Easy</option>
           
            
         </select>
      </div>
        <div class="form-group col-md-3">

          <label for="sel1" class="form-contol pt-2 col-md-12">TAG QUESTION</label>
        
            <select class="form-control col-md-12" name = "tag">
                  @foreach($sections as $section)
                    <option value="{{$section->section_name}}" {{ $section->section_name == $section_name->section_name ? 'selected' : $section->section_name }}>
                             {{$section->section_name}}
                    </option> 
              @endforeach
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
                 <input name = "positive_mark" type="text" class="form-control key-checkDigit key-meta-attr q-marks-input-box" aria-describedby="basic-addon1" value="3.0">
               </div>
            </div>
            <div class="col-md-6">
               <div class="input-group q-negative-div">
                 <span class="input-group-addon q-marks-label-text" id="basic-addon1"><i class="fa fa-minus" aria-hidden="true" style="margin-top:10px;"></i></span>
                 <input name="negative_mark" type="text" min="0" class="form-control key-checkDigit key-meta-attr q-marks-input-box" aria-describedby="basic-addon1" value="0.0">
               </div>
            </div>
                 </div>
                  
             </div>
           
         </div>
            <div class="col-md-3">
                <label for="sel1" class="form-contol pt-2">GUIDELINE TIME</label>
                 <input type="number" name= "answer_time" class="form-control">
            </div>
             <div class="col-md-12">
                <h4>Instruction*</h4>
                  <textarea name ="instruction" id="editor17" cols="80" rows="10"></textarea>
            </div>
         </div>
         

      <!--start-->
        @if($type == 'multiple')
         <div class="multipletype">
               <h3>QUESTION*</h3>
               <div class="question-mul">
               <textarea name ="question" id="editor1" cols="80" rows="10"></textarea>
               </div>
            <p>CHOICE*</p>
            <div class="anschioce">
               <div class="col-lg-12">
                  <div id="row">
                     <div class="input-group col-md-6"  style="float:left; margin-top:20px;">
                     <input type="radio" name="correct_option"  value="1" checked="checked" class="">
                        <!-- <input type="text" name= "answer[]" class="form-control m-input col-xl-12"> -->
                         <textarea name ="option1" id="editor2" cols="80" rows="10"></textarea>
                        <div class="input-group-prepend">
                           <button class="btn btn-danger" id="DeleteRow" type="button">
                              <i class="fa fa-times" aria-hidden="true"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                  <div id="newinput"></div>
                     <button id="rowAdder" type="button" data-ans="{{$type}}" class="btn btn-dark">

                     <i class="fa fa-plus" aria-hidden="true"></i>
                     </button>  
                  </div>
               </div>
                <a class="showdata">EXPLANATION
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                     <div class="explanation" style="display:none">
                        <textarea name ="answer_explanation" id ="multieditor" rows="4" cols="50" class="form-control"></textarea>
                        <br/>
                       <lable>Video Link</label>
                        <input type="text" name="video_link" placeholder="Enter video link">
                     </div>
            </div>
        @elseif($type == 'numerical')
         <div class="numericaltype">
           <h3>QUESTION*</h3>
            <div class="question-num">
            <textarea cols="80" name="question" rows="10" id="editor1"></textarea>
            </div>
            <p>ANSWER*</p>
            <div class="ans-num">
               <input type ="text"name ="correct_option" class="form-control">
            </div>
             <a class="showdata">EXPLANATION
                <i class="fa fa-plus" aria-hidden="true"></i>
              </a>
               <div class="explanation" style="display:none">
                  <textarea name ="answer_explanation" rows="4" cols="50" id = "numeditor" class="form-control"></textarea>
                    <br/>
                   <lable>Video Link</label>
               <input type="text" name="video_link" placeholder="Enter video link">
               </div>
         </div>
       @elseif($type == 'essay')
         <div class="essaytype">
            <h3>QUESTION*</h3>
            <div class="question-num">
            <textarea cols="80" id="editor1" name="question" rows="10"></textarea>
            </div>
            <p>EVALUATION CRITERIA*</p>
            <div class="ans-essay">
            <div class="col-lg-12">
                  <div id="row">
                     <div class="input-group m-3">
                        <div class="col-md-6">
                           <input type="text" name= "percentage[]" class="form-control m-input" placeholder="Criteria">
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
                  <div id="newinput"></div>
                  <button id="rowAdder" data-ans="{{$type}}" type="button" class="btn btn-dark">
                     <i class="fa fa-plus" aria-hidden="true"></i>
                  </button>
               </div>
               <a class="showdata">EXPLANATION
                <i class="fa fa-plus" aria-hidden="true"></i>
              </a>
               <div class="explanation" style="display:none">
                  <textarea name ="answer_explanation" rows="4" cols="50" id="esseditor" class="form-control"></textarea>
                    <br/>
                   <lable>Video Link</label>
                <input type="text" name="video_link" placeholder="Enter video link">
               </div>
            </div>
         </div>
       @elseif($type =='fill_in_the_blanks')
         <div class="fill_blank">
            <div class="question-blank">
            <textarea cols="80" id="editor1" name="question" rows="10"></textarea>
            </div>
            <p>ANSWER*</p>
            <div class="ans-blank">
               <input type ="text"name ="correct_option" class="form-control">
            </div>
            <a class="showdata">EXPLANATION
             <i class="fa fa-plus" aria-hidden="true"></i>
           </a>
            <div class="explanation" style="display:none">
               <textarea name ="answer_explanation" rows="4" cols="50" id ="filleditor" class="form-control"></textarea>
                 <br/>
               <lable>Video Link</label>
                <input type="text" name="video_link" placeholder="Enter video link">
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
</div>
<script>
   var ckt = 1;
   var edito = 2;
   var op = 1;
   $("#rowAdder").click(function () {
      ckt +=1;
      edito +=1;
      op +=1;

      var paper_type = $(this).attr('data-ans');
      if(paper_type == 'multiple')
      {
         newRowAdd =
            '<div id="row"> <div class="input-group col-md-6"  style="float:left; margin-top:20px;">' +
            ' <input type="radio" name="correct_option"  value="'+ckt+'"  class=""><textarea name ="option'+op+'" id="editor'+edito+'" cols="80" rows="10"></textarea>'+
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            ' <i class="fa fa-times" aria-hidden="true"></i></button> </div>' +
            '</div> </div>';
      }else if(paper_type == 'essay'){
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
       $('.explanation').css('display','block');

     });
});

   </script>
   <script type="text/javascript" src="{{asset('assets/admin/js/ck.js')}}"></script>
  </body>
</html>