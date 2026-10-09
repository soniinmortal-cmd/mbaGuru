@extends('admin_template')
@section('css')
@endsection
@section('content')
<style>

    a>href {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: none;
}

a:active {
  text-decoration: none;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9" id="right-menu-bar">
   <?php 
      $course_id =request()->id;
      $course =  DB::table('testuploading')->where('id',$course_id)->first();
      ?>
      @if (session('success'))
    <div class="alert alert-success alert-dismissible show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
   <div>
      <h5 class="fw-bold text-capitalize">{{$course->title}}</h5>
   </div>
         <div class="col-md-12" style="height:100px;">
            <?php
               $sets = DB::table('sets')->where('course_id',$course_id)->get(); 
               
            ?>
            <div class="setdatav" data-value="{{$sets}}">
               @foreach($sets as $set) 
               @if($set->id)
               <?php
                  $counttest = DB::table('tests')
                              -> where('set_id','=',$set->id)
                              -> count();
                  
                  ?>
               <div class="card bg-white py-3 px-1 display-box-data rset" id="show">
                  <div class="row ">
                     <div class="col-md-12 col-sm-12">
                        <div class="setdata">
                           <div class="col-md-4 col-sm-4">
                              <p> {{$set->setname}}</p>
                           </div>
                           <div class="col-sm-8 col-md-8">
                              <div class="container-fluid">
                                 <div class="row">
                                 <div class="col-sm-4 col-md-4">
                                 <button data-toggle="modal" data-target="#mymodal123" class="cssbuttongo btn btn-default" data-sname="{{$set->setname}}" data-eid="{{$set->id}}">
                                 EDIT</button>
                                 <a href="{{route('admin.setdelete',$set->id)}}" class="delt" style="float:center">
                                 <i class="fas fa-trash" aria-hidden="true" style="font-size:24px; color:maroon;"></i>
                                 </a>
                              </div>
                              <div class="col-sm-4 col-md-4">
                                 <a href="#" class="show{{$set->id}}" data-id = "{{$set->id}}">
                                 <i class="fas fa-plus" aria-hidden="true" style="font-size:24px; float:center; color:#1b1b83;"></i>
                                 </a>
                              </div>
                              <h5 CLASS="col-sm-4 col-md-4" >{{$counttest}} Tests</h5>
                              </div>
                              </div>
                           </div>
                        </div>
                        <div class="menu{{$set->id}}" style="display: none;">
                              <table class="table" style=" border-style:hidden">
                                 <tbody>
                                      <tr style="">
                                      <td style="width:80px;"></td>
                                   </tr>
                                 <tbody>
                              </table>
                            <?php
                              $tests = DB::table('tests')->where('set_id',$set->id)->get();
                              $i = 1;

                            ?> 
                           @foreach($tests as $test) 
                           <div class="col-md-12 col-sm-12">
                              <table class="table">
                                 <tbody>
                                      <tr style="border-top-style:1 px solid">
                                      <td style="width:80px; background-color: lightgray;">
                                      {{$i++}}
                                    </td>
                                       <td style="width:55px; border-left-width:2px; border-left-style:solid; border-left-color:rgb(13 198 63);">
                                       <a href="{{route('admin.testdelete',$test->id)}}" class="delt flyout{{$test->id}}" style="display:none;" data-c="{{$test->id}}" id="flyout1">
                                              <i class="fas fa-trash" aria-hidden="true" style="font-size:18px; margin-left:10px; color:black"></i>
                                          </a>
                                      </td>
                                     
                                        <td style="width:500px; padding-top:15px; ">
                                            @if($test->testtempid == '4')
                                            <a class="">
                                                <p class="menucheck1 section-lesson-text" style="color:black" data-set ="{{$test->id}}">
                                                    <a href="{{route('admin.new-testbuilder',['id'=>$test->id,'testtemp_id'=>$test->testtempid])}}" style="color:black; text-transform: capitalize; font-size:18px;" >
                                                        {{$test->test}}{{$test->testincid}}
                                                    </a>
                                                </p>
                                            </a>
                                            @else
                                            <a class="">
                                                <p class="menucheck1 section-lesson-text" style="color:black" data-set ="{{$test->id}}">
                                                    <a href="{{route('admin.testbuilder',$test->id)}}" style="color:black; text-transform: capitalize; font-size:18px;" >
                                                        {{$test->test}}{{$test->testincid}}
                                                    </a>
                                                </p>
                                            </a>
                                            @endif
                                        </td>
                                          <td style="width:100px; padding-top:15px; "> <a href="{{route('admin.edit-test',$test->id)}}" style="text-decoration:none; color:black; font-size:16px;">Edit Test</a ></td>
                                          <?php
                                          $status = DB::table('publish_statuses')->where('test_id',$test->id)->orderBy('id', 'DESC')->first();
                                          ?>
                                          @if(empty($status))
                                          <td style="width:70px;"><h4>Unpublished</h4></td>
                                          @else
                                          @if($status->status == 4)
                                          <td style="width:70px;"><h6>Unpublished</h6></td>
                                          @else
                                          <td></td>
                                          @endif
                                          @endif
                                          <td></td>
                                        </tr>
                                 </tbody>
                              </table>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
               @else
               <div></div>
               @endif
               @endforeach
              
            </div>
         </div>
      </div>
   </div>
</div>
<?php 
   $course_id = request()->id;
   ?>
<!-- set Modal -->
<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('admin.setcreation')}}" method="post" enctype="multipart/form-data">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Set</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <input type ="hidden" name="course_id" value="{{$course_id}}"class="form-control">
               <p>Set Title</p>
               <input type ="text" name="setname" class="form-control"> 
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- endsetmodal -->
<!-- test Modal -->
<div class="modal fade" id="myModal1" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">SELECT TEST TEMPLATE</h4>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
         </div>
         <div class="modal-body">
            <div class="row">
               <?php
                  $tempsdata =  DB::table('test_templates')->get();
                  ?>
               <div class="col-md-3">
                  <input type="hidden" name="course_id" class="course_id"value="{{$course_id}}">
                  @foreach($tempsdata as $testtemp)
                  <div class="radio">
                     <label class="template-radio-btn">
                     @if($testtemp->name =='GENERAL')
                     <input type="radio" name="testtempid" id="c_b{{$testtemp->id}}" value="{{$testtemp->id}}" checked="checked" class="myselection">{{$testtemp->name}}
                     @else
                     <input type="radio" name="testtempid" id="c_b{{$testtemp->id}}" value="{{$testtemp->id}}" class="myselection">{{$testtemp->name}}
                     @endif
                     </label>
                  </div>
                  @endforeach
               </div>
               <?php
                  $tempsvalue =  DB::table('test_templatevalues')->get();
                ?>
               <div class="col-md-9 myDiv" id="show1">
                  <div class="template-content" id="js-template-content">
                     <div>
                        <p class="main-title">Description</p>
                        <h5 class="quiz-note">
                           <b>NOTE:</b> This is sample template. You can modify the quiz settings later anytime from settings.
                        </h5>
                        <table class="quiz-template-table table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="title">TOTAL QUESTION TYPES</td>
                                 <td class="title-data">
                                    <p class="title-data">MCQ, &nbsp; +1, &nbsp; -0.25</p>
                                    <p class="title-data">Non-MCQ, &nbsp; +1, &nbsp; -0</p>
                                    <p class="title-data">ESSAY, &nbsp; +1, &nbsp; -0</p>
                                    <p class="title-data">FEEDBACK, &nbsp; +0, &nbsp; -0</p>
                                    <p class="title-data">FILL IN THE BLANKS, &nbsp; +1, &nbsp; -0</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL SECTIONS</td>
                                 <td class="title-data">
                                    <p class="title-data">Section 1</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">EXAM INSTRUCTION</td>
                                 <td class="title-data">true</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-9 myDiv" id="show2" style="display:none">
                  <div class="template-content" id="js-template-content">
                     <div>
                        <p class="main-title">Description</p>
                        <h5 class="quiz-note">
                           <b>NOTE:</b> This is sample template. You can modify the quiz settings later anytime from settings.
                        </h5>
                        <table class="quiz-template-table table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="title">Total Marks</td>
                                 <td class="title-data">198</td>
                              </tr>
                              <tr>
                                 <?php
                                 $test_tempre = DB::table('test_templatevalues')->where('temp_id',2)->first();
                                 if(!empty($test_tempre->exam_duration)){
                                    $exam_duration = $test_tempre->exam_duration;
                                 }else{
                                    $exam_duration = '';
                                 }
                                 ?>
                                 <td class="title">EXAM DURATION (IN MIN)</td>
                                 <td class="title-data">
                                    <input type="number" name="exam_duration" class="examtime" placeholder ="time in min" value="{{$exam_duration}}">
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">Total Questions</td>
                                 <td class="title-data">100</td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL QUESTION TYPES</td>
                                 <td class="title-data">
                                    <p class="title-data">MCQ, &nbsp; +3, &nbsp; -1</p>
                                    <p class="title-data">Non-MCQ, &nbsp; +3, &nbsp; -0</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL SECTIONS</td>
                                 <td class="title-data">
                                    <p class="title-data">Verbal Ability and Reading Comprehension, &nbsp; 24Q, &nbsp; 40MIN</p>
                                    <p class="title-data">Data Interpretation and Logical Reasoning, &nbsp; 22Q, &nbsp; 40MIN</p>
                                    <p class="title-data">Quantitative Ability, &nbsp; 20Q, &nbsp; 40MIN</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">SECTION DURATION</td>
                                 <td class="title-data">Enabled</td>
                              </tr>
                              <tr>
                                 <td class="title">CALCULATOR TYPE</td>
                                 <td class="title-data">NORMAL CALCULATOR</td>
                              </tr>
                              <tr>
                                 <td class="title">EXAM INSTRUCTION</td>
                                 <td class="title-data">true</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-9 myDiv" id="show3" style="display:none">
                  <div class="template-content" id="js-template-content">
                     <div>
                        <p class="main-title">Description</p>
                        <p class="quiz-note">
                           <b>NOTE:</b> This is sample template. You can modify the quiz settings later anytime from settings.
                        </p>
                        <table class="quiz-template-table table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="title">Total Marks</td>
                                 <td class="title-data">360</td>
                              </tr>
                              <tr>
                                 <td class="title">EXAM DURATION (IN MIN)</td>
                                 <td class="title-data">120</td>
                              </tr>
                              <tr>
                                 <td class="title">Total Questions</td>
                                 <td class="title-data">120</td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL QUESTION TYPES</td>
                                 <td class="title-data">
                                    <p class="title-data">MCQ, &nbsp; +3, &nbsp; -0</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL SECTIONS</td>
                                 <td class="title-data">
                                    <p class="title-data">Language Skills, &nbsp; 32Q, &nbsp; 22MIN</p>
                                    <p class="title-data">Quantitative Skills, &nbsp; 48Q, &nbsp; 60MIN</p>
                                    <p class="title-data">Logical Reasoning, &nbsp; 40Q, &nbsp; 38MIN</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">SECTION DURATION</td>
                                 <td class="title-data">Enabled</td>
                              </tr>
                              <tr>
                                 <td class="title">Section order selection</td>
                                 <td class="title-data">ENABLED</td>
                              </tr>
                              <tr>
                                 <td class="title">EXAM INSTRUCTION</td>
                                 <td class="title-data">true</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
                <div class="col-md-9 myDiv" id="show4" style="display:none">
                  <div class="template-content" id="js-template-content">
                     <div>
                        <p class="main-title">Description</p>
                        <h5 class="quiz-note">
                           <b>NOTE:</b> This is sample template. You can modify the quiz settings later anytime from settings.
                        </h5>
                        <table class="quiz-template-table table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="title">TOTAL QUESTION TYPES</td>
                                 <td class="title-data">
                                    <p class="title-data">MCQ, &nbsp; +1, &nbsp; -0.25</p>
                                    <p class="title-data">Non-MCQ, &nbsp; +1, &nbsp; -0</p>
                                    <p class="title-data">ESSAY, &nbsp; +1, &nbsp; -0</p>
                                    <p class="title-data">FEEDBACK, &nbsp; +0, &nbsp; -0</p>
                                    <p class="title-data">FILL IN THE BLANKS, &nbsp; +1, &nbsp; -0</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">TOTAL SECTIONS</td>
                                 <td class="title-data">
                                    <p class="title-data">Sections</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="title">EXAM INSTRUCTION</td>
                                 <td class="title-data">true</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary editduration" id="butsave">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- </form> -->
   </div>
</div>
<!-- endtestmodal -->

<!--edittestmodal -->
<div class="modal fade" id="mymodal123" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Section Title</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-10">
                  <input type ="text" name="setname" class="form-control esetname" value="" id="edsetname">  
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="butedit">Edit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<!--endeditmodal--->
@endsection
@section('script')
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
<script>
   var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
   myModal.show()
</script>
<script>
$(document).ready(function(){
    var url1 = '{{route("admin.edittime")}}';
   $(".myselection").on("click", function() {
     if ($(this).is(":checked")) {
       var temp_id = $(this).val();
     }
      $('.examtime').on('blur', function() {
         var temp_id = temp_id;
         var exam_duration = $('.examtime').val();
         $.ajax({
               url: url1,
               type: "POST",
                  data: {
                      _token: $("#csrf").val(),
                      temp_id: temp_id,
                      exam_duration: exam_duration
                  },
                 cache: false,
               success: function(dataResult){
                 var dataResult = JSON.parse(dataResult);
                 if(dataResult.statusCode==200){
                  location.reload();
                 }
                 else if(dataResult.statusCode==201){
                   alert("Error occured !");
                 }
               }
             });
         });
   });
});
</script>
<script>
   $(document).ready(function(){
     var data = $(".setdatav").attr('data-value');
     var url1 = '{{route("admin.testcreation")}}';
     $.each(JSON.parse(data), function(index, value){
      var setid = value.id;
       $('.show'+setid).click(function(){
         $('.mytext').text('hello');
         var slide = $('.menu'+setid).toggle("slide");
         $('.menu'+setid).css('display','block');
         $(".myselection").on("click", function() {
           if ($(this).is(":checked")) {
             var testtemp_id = $(this).val();
           }
           $('#butsave').on('click', function() {
             var set_id = setid;
             var test = "test";
             var testtempid = testtemp_id;
             var course_id = $('.course_id').val();
             $.ajax({
               url: url1,
               type: "POST",
               data: {
                   _token: $("#csrf").val(),
                   set_id: set_id,
                   test: test,
                   testtempid: testtempid,
                   course_id: course_id
                 },
                 cache: false,
               success: function(dataResult){
                 var dataResult = JSON.parse(dataResult);
             
                 if(dataResult.statusCode==200){
                //   rurl  = "{{ route('admin.testbuilder',':id') }}";	
                //   rurl1 = rurl.replace(':id', dataResult.id);
                //      window.location.href = rurl1;
                     location.reload();
                 }
                 else if(dataResult.statusCode==201){
                   alert("Error occured !");
                 }
               }
             });
           });
         });
       });
     });
   });
</script>
<script>
   $(document).ready(function(){
     $(".myselection").on("click", function() {
       if ($(this).is(":checked")) {
         var demovalue = $(this).val();
         if(demovalue==1){
           $("#show1").show();
           $("#show2").hide();
           $("#show3").hide();
            $("#show4").hide();
         }else if(demovalue==2){
           $("#show1").hide();
           $("#show2").show();
           $("#show3").hide();
           $("#show4").hide();
         }else if(demovalue==3){
           $("#show1").hide();
           $("#show2").hide();
           $("#show3").show();
           $("#show4").hide();
         }else if(demovalue==4){
           $("#show1").hide();
           $("#show2").hide();
           $("#show3").hide();
           $("#show4").show();
         }else{
           $("#show1").hide();
           $("#show2").hide();
           $("#show3").show();
           $("#show4").hide();
         }
       } 
     });
   });
</script> 
<script>
   $(document).ready(function(){
       $('.cssbuttongo').click(function (){
         var sname = $(this).attr('data-sname');
         var sid = $(this).attr('data-eid');
         $('.esetname').val(sname);
         var url1 = '{{route("admin.setedit")}}';
         $('#butedit').on('click', function() {
                 var id = sid;
                 var setname =  $('#edsetname').val();
                 var course_id = course_id;
                 $.ajax({
                   url: url1,
                   type: "POST",
                   data: {
                       _token: $("#csrf").val(),
                       id: id,
                       setname: setname,
                       course_id: course_id
                     },
                     cache: false,
                   success: function(dataResult){
                     console.log(dataResult);
                     var dataResult = JSON.parse(dataResult);
                     if(dataResult.statusCode==200){
                       location.reload(true);		
                     }
                     else if(dataResult.statusCode==201){
                       alert("Error occured !");
                     }
                   }
                 });
                 });
         
       $('#myModal123').modal('show');
       });
   });
</script>
<script>
   $(document).ready(function(){
      $(".menucheck1").hover(function() {
       //$("p").hover(function () {
       var id = $(this).attr('data-set');
       console.log(id);
       var clickid = $('.flyout'+id).attr('data-c');
      // console.log(id,"id");
      // console.log(clickid,"clickid");
       //if(id == clickid){
         $('.flyout'+id).css('display','block');
       //}
     //   else{
     //  // $('#flyout1').css('display','none');
     //   }
     }, function() {
     //  $('#flyout1').css('display','none');
     });
   });
</script>

