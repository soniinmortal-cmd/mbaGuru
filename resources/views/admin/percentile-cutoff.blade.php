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
<div class="col-md-9" id="right-menu-bar" style="background-color:white">
     <div id="topbar-left-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
          <h3 class="fw-bold text-capitalize">Percentile Ranking</h3>
          @if(Session::has('message'))
               <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
          @endif
          <a href="{{ asset('assets/excel-formate/PercentileUploadNew.xlsx') }}" download>Download Percentile Formate</a>
     </div>
     <div class="row duration">
          <div class="row pt-5" style="border-bottom:1px solid lightgrey">
               <form action="{{route('admin.save-percentile')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="test_id" value="{{$id}}">
                    <div class="col-md-3">
                         <p>&nbsp;&nbsp;Section Quiz Percentile</p>
                    </div>
                    <div class="col-md-7 durationdata" style="border-bottom:1px solid lightgrey">
                         <input type="file" name="file" placeholder="">
                         <br/><br/>
                         <button class="btn btn-success" type="submit" style="margin-top:-20px;">Submit</button>
                    </div>
               </form>
          </div>
          <?php
            $id = request()->id;
          
            $cutoff = DB::table('cutoff')
                    ->where('test_id', $id)
                    ->orderBy('id','desc')
                    ->first();
          ?>
          <div class="row pt-5" style="border-bottom:1px solid lightgrey">
               <form action="{{route('admin.save-cutoff')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="test_id" value="{{$id}}">
                    <div class="cat" >
                         <div class="col-md-3">
                         <p><input type="radio" name="cutoff" class="cutoffc">Quiz Cutoff for CAT</p>
                         </div>
                         <div class="col-md-7 durationdata1 catc" style="border-bottom:1px solid lightgrey;display:none">
                              <table class="table table-bordered">
                                   <thead class="table-secondary">
                                        <tr>
                                             <th>Section</th>
                                             <th>Cutoff</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td><input type="hidden"name="type" value="verbal">Verbal Ability and Reading Comprehension</td>
                                             
                                                  <td><input type="number" name="verbal_cutoff" placeholder="" value="{{ isset($cutoff) ? $cutoff->verbal_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="data">Data Interpretation and Logical Reasoning</td>
                                                  <td><input type="number" name="data_cutoff" placeholder=""value="{{ isset($cutoff) ? $cutoff->data_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="quantitative">Quantitative Ability</td>
                                             <!--<td><input type="file" name="quantitative_percentile" placeholder=""></td>-->
                                             <td><input type="number" name="quantitative_cutoff" placeholder=""value="{{ isset($cutoff) ? $cutoff->quantitative_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="overall">Overall</td>
                                             <!--<td><input type="file" name="quantitative_percentile" placeholder=""></td>-->
                                             <td><input type="number" name="overall_cutoff" placeholder=""value="{{ isset($cutoff) ? $cutoff->overall_cutoff : '' }}"></td>
                                        </tr>
                                   </tbody>
                              </table>
                              
                         </div>
                    </div>
                    <div class="nmat" >
                         <div class="col-md-3">
                              <p><input type="radio" name="cutoff"class="cutoffn">Quiz Cutoff for NMAT</p>
                         </div>
                         <div class="col-md-7 durationdata1 nmatn" style="border-bottom:1px solid lightgrey;display:none">
                              <table class="table table-bordered">
                                   <thead class="table-secondary">
                                        <tr>
                                             <th>Section</th>
                                             <th>Cutoff</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td><input type="hidden"name="type" value="language">Language Skills</td>
                                        
                                             <td><input type="number" name="language_cutoff" placeholder="" value="{{ isset($cutoff) ? $cutoff->language_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="qs">Quantitative Skills</td>

                                             <td><input type="number" name="qs_cutoff" placeholder="" value="{{ isset($cutoff) ? $cutoff->qs_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="logical_reasoning">Quantitative Ability</td>
                                        
                                             <td><input type="number" name="logical_cutoff" placeholder="" value="{{ isset($cutoff) ? $cutoff->logical_cutoff : '' }}"></td>
                                        </tr>
                                        <tr>
                                             <td><input type="hidden"name="type" value="overall">Overall</td>
                                        
                                             <td><input type="number" name="overall_cutoff_nmat" placeholder=""></td> 
                                        </tr>
                                   </tbody>
                              </table> 
                         </div>
                    </div>
                    <button class="btn btn-success savebtn" type="submit" style="margin-top:302px;display:none">Submit</button>
               </form>
          </div>
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
    $(".sectionduration1").click(function(){
      $(".durationdata1").css('display','block');
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
<script> 
$( document ).ready(function() {
    
     $(".cutoffc").click(function(){
          $('.catc').css("display", 'block');
          $('.nmatn').css("display", 'none');
          $('.savebtn').css('display','block');
     });
     $(".cutoffn").click(function(){
          $('.catc').css("display", 'none');
          $('.nmatn').css("display", 'block');
          $('.savebtn').css('display','block');
     });
});
</script>
@endsection

