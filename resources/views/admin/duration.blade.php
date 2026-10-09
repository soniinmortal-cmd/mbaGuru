@extends('admin_template')
@section('css')
@endsection
@section('content') 

<?php
$id =request()->id;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
  $test = DB::table('tests')
          ->where('id', $id)
        ->limit(1)
         // ->orderBy('id','desc')
          ->first();
?>

     <div class="col-md-9" style="background-color:white">
          <div id="topbar-left-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
             
               <h4 class="fw-bold text-capitalize" style="margin-top:30px;">Duration Type</h4>
                <p style="margin-top:30px;">{{ $test->test }}</p>
               @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
               @endif
          </div>
          <p>Select duration type for your quiz</p>
          <?php
                     $id = request()->id;
                    
                    $duration = DB::table('quiz_durations')
                              ->where('test_id', $id)
                              ->where('duration','section_duration')
                              ->orderBy('id','desc')
                              ->first();
                    $nmat_duration = DB::table('quiz_durations')
                              ->where('test_id', $id)
                              ->where('duration','nmat_duration')
                              ->orderBy('id','desc')
                              ->first();
                              //dd($duration);
                    $all_duration = DB::table('quiz_durations')
                              ->where('test_id', $id)
                              ->where('duration','overall_quiz_duration')
                              ->orderBy('id','desc')
                              ->first();
                    ?>
          <div class="row duration">
               <form action="{{route('admin.quiz-duration')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form">
                         <input type="hidden" name="test_id" value="{{$id}}">
                         <div class="row pb-4" style="border-bottom:1px solid lightgrey">
                              <div class="col-md-5">
                                   <input type="radio" class="alldata" name="duration" value="overall_quiz_duration"/>&nbsp;&nbsp;Overall Quiz Duration
                                   <p>Set overall time limit for your quiz</p>
                              </div>
                              <div class="col-md-7">
                                   <input type="number" name="all_duration" class="all_duration" placeholder="min(s)" value="{{ isset($all_duration ) ? $all_duration->all_duration : '' }}" disabled="true">
                              </div>
                         </div>
                         <div class="row pt-5">
                              <div class="col-md-5">
                                   <input type="radio" class="sectionduration" name="duration" value="section_duration"/>&nbsp;&nbsp;Section Quiz Duration For CAT
                                   <p>Set time limit individually for each section of your quiz</p>
                                   <!-- <button class="btn btn-success" type="submit" style="margin-top:50px;">Submit</button> -->
                              </div>
                              <div class="col-md-7 durationdata" style="display:none;">
                                   <table class="table table-bordered">
                                        <thead class="table-secondary">
                                             <tr>
                                                  <th>Section</th>
                                                  <th>Duration (Mins)</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td>Verbal Ability and Reading Comprehension</td>
                                                  <td><input type="number" name="verbal_time" placeholder="min(s)" value="{{ isset($duration) ? $duration->verbal_time : '' }}"></td>
                                             </tr>
                                             <tr>
                                                  <td>Data Interpretation and Logical Reasoning</td>
                                                  <td><input type="number" name="interp_time" placeholder="min(s)"value="{{ isset($duration) ? $duration->interp_time : '' }}"></td>
                                             </tr>
                                             <tr>
                                                  <td>Quantitative Ability</td>
                                                  <td><input type="number" name="quantitative_time" placeholder="min(s)"value="{{ isset($duration) ? $duration->quantitative_time : '' }}"></td>
                                             </tr>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                          <div class="row pt-5">
                              <div class="col-md-5">
                                   <input type="radio" class="nmatduration" name="duration" value="nmat_duration"/>&nbsp;&nbsp;Section Quiz Duration For NMAT
                                   <p>Set time limit individually for each section of your quiz</p>
                                   <!-- <button class="btn btn-success" type="submit" style="margin-top:50px;">Submit</button> -->
                              </div>
                              <div class="col-md-7 durationnmat" style="display:none;">
                                   <table class="table table-bordered">
                                        <thead class="table-secondary">
                                             <tr>
                                                  <th>Section</th>
                                                  <th>Duration (Mins)</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td>Language Skills</td>
                                                  <td><input type="number" name="language_time" placeholder="min(s)" value="{{ isset($nmat_duration) ? $nmat_duration->language_time : '' }}"></td>
                                             </tr>
                                             <tr>
                                                  <td>Quantitative Skills</td>
                                                  <td><input type="number" name="qs_time" placeholder="min(s)" value="{{ isset($nmat_duration) ? $nmat_duration->qs_time : '' }}"></td>
                                             </tr>
                                             <tr>
                                                  <td>Logical Reasoning</td>
                                                  <td><input type="number" name="logical_time" placeholder="min(s)" value="{{ isset($nmat_duration) ? $nmat_duration->logical_time : '' }}"></td>
                                             </tr>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                         <button class="btn btn-success" type="submit" style="margin-top:50px;">Submit</button>
                    </div>
               </form>
          </div>
     </div>
     
@endsection
@section('script')
<script> 
$( document ).ready(function() {
    $(".sectionduration").click(function(){
      $(".durationdata").css('display','block');
     });
});
</script>
<script> 
$( document ).ready(function() {
    $(".nmatduration").click(function(){
      $(".durationnmat").css('display','block');
     });
});
</script>
<script> 
$( document ).ready(function() {
     $(".alldata").click(function(){
          $('.all_duration').attr("disabled", false);
     });
});
</script>
@endsection

