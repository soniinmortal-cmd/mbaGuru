@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-12" id="">
   <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
          @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          
                   <?php
        $testsection = DB::table('test_sections')
                 ->where('test_id',$testid)
               ->first();
      ?>
   
    
      <h5 class="fw-bold text-capitalize"></h5>
   </div>
   @if(!empty($testsection))
      <a href="{{route('admin.new-testbuilder',['id'=>$testid,'testtemp_id'=>$testsection->testtemp_id])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @else
     <a href="{{route('admin.testbuilder',['id'=>$testid])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @endif
   <div class="import-div">
      <div class="import-data-div" style="display: inherit;">
         <div class="import-selection-desc-div" style="">
            <p class="import-title">IMPORT QUESTIONS <span class="js-update-steps"></span></p>
         </div>
         <hr class="import-divider" style="">
         <div class="import-selection-div" style="">
            <div class="row import-margin" style="">
               <div class="col-md-6 word-import-styles" style="">
                  <div class="center-style">
                     <img src="https://res-cdn.learnyst.com/pro/admin/coursebuilder/styles/images/cb_word_import_icon.svg" alt="" style="width:100px">
                     <div class="radio-div">
                        <div class="radio">
                           <label class="radio-btn">
                              <input type="radio" name="import-type" value="1"  class="checkimport">Word import
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 excel-import-styles" style="">
                  <div class="center-style">
                     <img src="https://res-cdn.learnyst.com/pro/admin/coursebuilder/styles/images/cb_excel_import_icon.svg" alt="" style="width:100px">
                     <div class="radio-div">
                        <div class="radio">
                           <label class="radio-btn"><input type="radio" name="import-type" value="2" class="checkimport">Excel import</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br/>
            <?php 
            $tests =   DB::table('tests')->where('id',$testid)->first();
            //dd($tests->id);
            ?>
            <div class="import-next-btn-div" style="float:left">
               <button type="button" class="btn btn-primary showimport" data-im ="{{$tests->id}}">Upload</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!--word-->
<div class="modal" id="importword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
   <div class="modal-dialog  modal-dialog-centered">

   <form action="{{route('admin.saveword')}}" method="post" enctype="multipart/form-data">
      @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">IMPORT QUESTIONS</h4>
            </div>
            <div class="modal-body">
            <input type ="hidden" name="test_id" value =""id ="test_id1">
              <input type ="hidden" name="importvalue" value =""id ="importvalue1">
               <div class="import-data-div import-data-div-word" id="fileselection" style="display: block;">
                  <div class="import-margin">
                     <?php
                   $url_id =request()->id;
                  ?>
                  <p>Note1: Please Enter Given TestId in Word File.</p>
                  <p>TestID: {{$url_id}}</p>
                  </div>
                  <div class="import-steps">
                     <div class="word-height">
                        <div class="import-steps-padding">
                           <p class="import-steps-desc">
                              <span>Note: </span>
                           Download<a href="{{ asset('assets/excel-formate/WordQuestionTemplate.docx') }}" download>QuestionsImportTemplate-v3.xlsx</a>(MS Word format)
                           </p>
                        </div>
                       
                        <div class="import-file-chooser-btn"  >
                           <input  name ="filename" type="file" accept=".doc,.docx" style="box-shadow:none;"/>
                           <span class="label label-info file-status js-upload-file-info"></span>
                        </div>
                        <span class="settings-content-error-msg" id="test-import-upload-error"></span>
                       
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<!--endword-->
<!--excel-->
<div class="modal" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
   <!-- <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}"> -->
      <!-- Modal content-->
      <form action="{{route('admin.saveexcelword')}}" method="post" enctype="multipart/form-data">
      @csrf
     
         <div class="modal-content">
            <?php
            $test_id =request()->id;
            ?>
             <input type="hidden" name="test_id"  value="{{$test_id}}">
            <div class="modal-header">
               <h4 class="modal-title">Import</h4>
            </div>
            <div class="modal-body">
             <!--  <input type ="hidden" name="test_id" value =""id ="test_id">
              <input type ="hidden" name="importvalue" value =""id ="importvalue"> -->
               <div class="import-data-div import-data-div-excel" id="fileselection" style="display: block;">
                  <div class="import-margin">
                     <p class="import-title">IMPORT QUESTIONS <span class="js-update-steps"></span></p>
                  </div>
                  <!--<hr class="import-divider">-->
                  <?php
                   $url_id =request()->id;
                  ?>
                  <p>Note1: Please Enter Given TestId in Excel Sheet</p>
                  <p>TestID: {{$url_id}}</p>
                  <div class="import-steps">
                     <div class="excel-height">
                        <div class="import-steps-padding">
                           <p class="import-steps-desc">
                              <span>Note2: </span>
                                Download <a href="{{ asset('assets/excel-formate/new-AIRCAT2227.xlsx') }}" download>QuestionsImportTemplate-v3.xlsx</a> (Excel format)
                           </p>
                        </div>
                        <div class="import-file-chooser-btn">
                           <!-- <input  id ="filename" name ="filename" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /> -->
                           <input type="file" name="file" class="form-control">
                           <span class="label label-info file-status js-upload-file-info"></span>
                        </div>
                        <span class="settings-content-error-msg" id="test-import-upload-error"></span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id ="butexcel" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<!--excel-->
@endsection
@section('script')
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('.checkimport').click(function(){
      var importvalue = $(this).val();
      $('.showimport').click(function(){
        var test_id = $(this).attr('data-im');
        if(importvalue==1){
         $('#test_id1').val(test_id);
          $('#importvalue1').val(importvalue);
          $('#importword').modal('show');
          $(".btn").click(function(){
            $("#importword").modal('hide');
        });
        }else if(importvalue==2){
          $('#test_id').val(test_id);
          $('#importvalue').val(importvalue);
          $('#importexcel').modal('show');
          $(".btn").click(function(){
            $("#importexcel").modal('hide');
        });
        }
      }); 
  });
 
});
</script>
<script>
</script>