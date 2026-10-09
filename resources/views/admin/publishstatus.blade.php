@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
        h1 {
            color: green;
        }
               
        /* toggle in label designing */
        .toggle {
            position : relative ;
            display : inline-block;
            width : 100px;
            height : 52px;
            background-color: red;
            border-radius: 30px;
            border: 2px solid gray;
        }
               
        /* After slide changes */
        .toggle:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: gray;
            top: 1px; 
            left: 1px;
            transition:  all 0.5s;
        }
               
        /* Toggle text */
        p {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }
               
        /* Checkbox checked effect */
        .checkbox:checked + .toggle::after {
            left : 49px; 
        }
               
        /* Checkbox checked toggle label bg color */
        .checkbox:checked + .toggle {
            background-color: green;
        }
               
        /* Checkbox vanished */
        .checkbox { 
            display : none;
        }
    </style>



<div class="col-md-12" id="">
   <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
      <h4 class="fw-bold text-capitalize">Publish Quiz</h4>
   </div>
   <?php
      $id= request()->id;
       $tst = DB::table('tests')
      ->where('id',$id)
      ->first();
      
      $tst = DB::table('sets')
      ->where('id',$tst->set_id)
      ->first();
      $publish = DB::table('publish_statuses')
      ->where('test_id',$id)
      ->where('course_id',$tst->course_id)
        ->orderBy('id', 'desc')
      ->first();
        $testsection = DB::table('test_sections')
                 ->where('test_id',$id)
               ->first();
     // dd($testsection);
      ?>
   <h6>Publish/Unpublish the quiz for your learners</h6>
    @if(!empty($testsection))
      <a href="{{route('admin.new-testbuilder',['id'=>$id,'testtemp_id'=>$testsection->testtemp_id])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @else
     <a href="{{route('admin.testbuilder',['id'=>$id])}}"class="btn btn-primary" style="float:right;">All Question</a>
    @endif
    <div class="col-md-6">
        <form action="{{route('admin.savepublish')}}" method="post" enctype="multipart/form-data">
         @csrf
            <div class="form">
                <input type="hidden" name="test_id" value="{{$id}}"  class="">
                <input type="hidden" name="course_id" value="{{$tst->course_id}}"  class="">
                <div class="card">
                   <div class="container">
                      <label class="radio-btn">
                      <input type="radio" name="status" value="1"  class="" @if(!empty($publish->status)) {{  ($publish->status == 1 ? ' checked' : '') }} @endif>
                      Live
                      </label>
                      <h6 class="css-8rmghh">It will publish quiz for learners to enroll &amp; access</h6>
                   </div>
                </div>
                <br/>
                <div class="card">
                   <div class="container">
                      <label class="radio-btn">
                      <input type="radio" name="status" value="2"  class="" @if(!empty($publish->status)) {{  ($publish->status == 2 ? ' checked' : '') }} @endif>
                      Coming Soon
                      </label>
                      <h6 class="css-8rmghh">It will show the quiz status to the learners as coming soon</h6>
                   </div>
                </div>
                <br/>
                <div class="card">
                   <div class="container">
                      <label class="radio-btn">
                      <input type="radio" name="status" value="3"  class="hidedate" @if(!empty($publish->status)) {{  ($publish->status == 3 ? ' checked' : '') }} @endif>
                      Scheduled
                      </label>
                      <div class="showdate" style="display:none">
                         <input type="date" name="start_date"  value="{{ isset($publish) ? $publish->start_date : '' }}">
                         <input type="date" name="end_date" value="{{ isset($publish) ? $publish->end_date : '' }}">
                      </div>
                      <h6 class="css-8rmghh">Scheduled quiz will be released on the preset future dates</h6>
                   </div>
                </div>
                <br/>
                <div class="card">
                   <div class="container">
                      <label class="radio-btn">
                      <input type="radio" name="status" value="4"  class=""@if(!empty($publish->status)) {{  ($publish->status == 4 ? ' checked' : '') }} @endif>
                      Unpublished
                      </label>
                      <h6 class="css-8rmghh">Unpublished quiz will not be visible to learners</h6>
                   </div>
                </div>
                <br/>
                <button type="submit" id ="" class="btn btn-primary">Publish</button>
            </div>
      </form>
   </div>
    <div class="col-md-4">
        <h3><b>Proctored</b></h3>
        <!-- <form action="{{route('admin.saveproctored')}}" method="post" enctype="multipart/form-data"> -->
            @csrf
            <div class="form">
                <?php
                $procc = DB::table('proctored')
                    ->where('test_id',$id)
                    ->where('course_id',$tst->course_id)
                    ->first();
                ?>
                <input type="hidden" name="test_id" value="{{$id}}"  class="testid">
                <input type="hidden" name="course_id" value="{{$tst->course_id}}"  class="courseid">
                <div class="card">
                    <div class="container">
                      <label class="radio-btn">Status:</label>&nbsp;
                           <div class="form-check form-switch switch1">
                              <input class="form-check-input switch" type="checkbox" role="switch" id="" name="status" value="" {{ isset($procc) && ($procc->status == 1) ? 'checked' : '' }}>
                            </div>
                            
                      <h5 class="css-8rmghh">Proctored code: {{ (isset($procc) && $procc->status == 1) ? $procc->pro_code : '' }}</h5>
                    </div>
                </div>
               <!-- <button type="submit" id ="" class="btn btn-primary">Submit</button> -->
            </div>
        <!-- </form> -->

    </div>
</div>
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
      if ($('.hidedate').is(':checked')) {
           $('.showdate').css('display','block');
      }
       $('.hidedate').click(function(){
           $('.showdate').css('display','block');
       })
   })
</script>
<script>
$(document).ready(function(){
     var url1 = '{{route("admin.saveproctored")}}';
    $('.switch').click(function(){

     let isChecked = $('.switch').is(':checked');
        if(isChecked == true){
          var status =   $('.switch').val(1);
         }else{
          var satus =  $('.switch').val(0);
         }
         $('.switch1').click(function(){
            var test_id = $('.testid').val();
            var course_id = $('.courseid').val();
            // var status = status;
            var pro_code = Math.floor(Math.random() * 1000000);
            console.log(pro_code);
            //return false;
                $.ajaxSetup({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
             $.ajax({
               url: url1,
               type: "POST",
               data: {
                   test_id: test_id,
                   course_id: course_id,
                   pro_code: pro_code
                 },
                 cache: false,
                 success: function(dataResult){
                 var dataResult = JSON.parse(dataResult);
             console.log(dataResult);
            // return false;
                 if(dataResult.statusCode==200){
                  rurl  = "{{ route('admin.publishstatus',':id') }}"; 
                  rurl1 = rurl.replace(':id', dataResult.id);
                  window.location.href = rurl1;
                 }
                 else if(dataResult.statusCode==201){
                   alert("Error occured !");
                 }
               }
             });

         })
            
    })
})
</script>