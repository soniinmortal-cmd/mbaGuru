@extends('student_template')
@section('css')
@endsection
@section('content')
<div class="col-md-12 bg-light py-3 ">
   <div class="container">
      <?php
         $id= request()->id;
         ?>
          <a href="{{route('student.dashboard')}}" class="btn"style="background-color:#A83942;color:white;">HOME</a>
      <div class="row px-2 my-5">
         <div class="col-md-8 px-1">
            <div class="cardScreen py-4 px-2">
               <img src="{{asset('assets/student/image/liveblue.png')}}" style="height:30px; width:30px;"/>
              

               <h4 style="margin:-30px 0px 0px 30px;" class="statusname">Live</h4>
               <h6 style="display:none" class="fdate"></h6>
               <h6 style="display:none" class="edate"></h6>
               <h3 class="papername1">Tests</h3>
               <h4 class="papername" style="display:none;"></h4>
               <!-- <input type="text" name ="paper" class="papername" value ="" style="display:none;"> -->
               <div class="col-md-12 d-flex  justify-content-center" style="margin-top:120px; height:40px;">
                  <div class="newbtnn">
                  </div>
                  <div class="newbtnn11">
                  </div>
                  <button class="instructions btn btn-primary cont text-white mx-4"  style="display:none">Continue</button>
                  <!-- <a class="report btn btn-primary result text-white mx-4" style="display:none;">View Result</a> -->
                  <input type ="text" class="proin h-100" name ="proin" placeholder="Enter Proctored Code" style="display:none; margin:0px;">
                  <!-- <div class="cont">
                     <a href ="#"  style="float:right;color:white;">Continue</a>
                     </div> -->
                  <!-- <div class="result" >
                     <a href ="#" class="report btn btn-primary" style="float:right;color:white;">View Result</a>
                     </div> -->
               </div>
            </div>
         </div>
         <div class="col-md-1"></div>
         <div class="col-md-3 px-1">
            <div class="card bg-white py-4 px-2 display-box-data" style="height:425px; overflow-y:scroll;">
               <table class="table w-100">
                  <thead>
                     <tr id="thead">
                        <th class="w-50">
                           <h4 style="color:maroon; font-weight:bold">Tests</h4>
                        </th>
                     </tr>
                  </thead>
                  <tbody class="scroll2">
                     @foreach($tests as $test)
                     <?php
                        $userid =session()->get('id');
                        $status = DB::table('publish_statuses')
                                    ->where('test_id',$test->id)
                                    ->where('course_id', $id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                        
                          $pro = DB::table('proctored')
                                    ->where('course_id', $id)
                                    ->where('test_id', $test->id)
                                    ->orderBy('id', 'desc')
                                    ->first();   
                        
                        $quizz = DB::table('student_quizes')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_type','quantitative')
                                    ->get(); 
                        
                        $vquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name', 'like', "%verbal%")
                                    ->orderBy('id', 'desc')
                                    ->first();
                       // dd($vquizz);
                        
                            if(isset($vquizz)){
                                
                                $isverbalquiz = DB::table('student_quizes')
                                        ->where('test_id',$test->id)
                                        ->where('user_id',$userid)
                                        ->where('paper_id',$vquizz->paper_id)
                                        ->where('section_type', 'like', "%verbal%")
                                        ->orderBy('id', 'desc')
                                        ->first(); 
                                        //dd($isverbalquiz);
                            }
                        
                        
                        $dquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name', 'like', "%Data%")
                                    ->orderBy('id', 'desc')
                                    ->first();
                          
                            
                        if(isset($dquizz)){
                            $isdataquiz = DB::table('student_quizes')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('paper_id',$dquizz->paper_id)
                                    ->where('section_type', 'like', "%Data%")
                                    ->orderBy('id', 'desc')
                                    ->first(); 
                                    //dd($isdataquiz->paper_id);
                        
                                   
                        }
                        $qquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name', 'like', "%quantitative%")
                                    ->orderBy('id', 'desc')
                                    ->first();
                        
                         if(isset($qquizz)){
                        
                        $isqtquiz = DB::table('student_quizes')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('paper_id',$qquizz->paper_id)
                                    ->where('section_type', 'like', "%quantitative%")
                                    ->orderBy('id', 'desc')
                                    ->first(); 
                                    
                        
                                    }
                        
                        $qsquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name','like', "%Quantitative Skills%")
                                    ->orderBy('id', 'desc')
                                    ->first();
                                    
                        $lsquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name','Language Skills')
                                    ->orderBy('id', 'desc')
                                    ->first();
                        
                        $lrquizz = DB::table('half_student_quiz')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->where('section_name','Logical Reasoning')
                                    ->orderBy('id', 'desc')
                                    ->first();
                        
                        $countquizz = DB::table('student_quizes')
                                   //  ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->select('student_quizes.paper_id as paper_id','student_quizes.test_id')
                                    ->groupBy('student_quizes.paper_id','student_quizes.test_id')
                                     ->get();
                        
                        $countquizzall = DB::table('student_quizes')
                                    ->where('test_id',$test->id)
                                    ->where('user_id',$userid)
                                    ->select('student_quizes.paper_id as paper_id','student_quizes.test_id','student_quizes.section_type','student_quizes.set_type')
                                    ->groupBy('student_quizes.paper_id','student_quizes.test_id','student_quizes.section_type','student_quizes.set_type')
                                    ->get();
                        
                        $datacount = count($countquizz);
                        
                        $attempt = DB::table('maximum_attempt_count')
                                    ->where('test_id',$test->id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                        
                        if(!empty($attempt))
                        {
                             $totalatt = $attempt->maximum_attempt;    
                        }
                        $date = date('Y-m-d');
                        $users = DB::table('studentlogs')
                                        ->where('id',$userid)
                                        ->first();
                        $cour = DB::table('testuploading')
                                            ->where('id',$id)
                                            ->first();
                                            
                        $assign_test = DB::table('assign_test')
                                        ->where('course_id',$cour->title)
                                        ->where('email',$users->email)
                                        ->where('status',1)
                                        ->first();
                        
                        //dd($assign_test);
                        ?>
                     <tr id="textrow" class="newcolor{{$test->id}} newcolordata">
                        @if(isset($assign_test))
                        <td>
                           <a href ="#" class="test setcolor paper checkatt pro" data-current ="{{$date}}"data-id="{{$test->id}}" data-status="{{ isset($status)  ? $status->status : '' }}" data-fdate="{{ isset($status)  ? $status->start_date : '' }}" data-edate="{{ isset($status)  ? $status->end_date : '' }}" data-name="{{$test->test}}{{$test->testincid}}" data-paperid="{{ isset($quizz)  ? $quizz : '' }}" data-vpaperid="{{ isset($vquizz)  ? $vquizz->paper_id : '' }}" data-dpaperid="{{ isset($dquizz)  ? $dquizz->paper_id : '' }}"
                              data-attempt="{{ isset($totalatt)  ? $totalatt : '' }}" 
                              data-qcount="{{$datacount}}" data-pros="{{ isset($pro) ? $pro->status: '' }}" data-procode="{{ isset($pro) ? $pro->pro_code: '' }}" data-mtype="{{$test->testtempid}}"  data-qspaperid="{{ isset($qsquizz)  ? $qsquizz->paper_id : '' }}" 
                              data-qsset-type="{{ isset($qsquizz)  ? $qsquizz->set_type : '' }}" data-lspaperid="{{ isset($lsquizz)  ? $lsquizz->paper_id : '' }}" data-lsset-type="{{ isset($lsquizz)  ? $lsquizz->set_type : '' }}" data-lrpaperid="{{ isset($lrquizz)  ? $lrquizz->paper_id : '' }}" data-lrset-type="{{ isset($lrquizz)  ? $lrquizz->set_type : '' }}" data-allrecord ="{{ isset($countquizzall)  ? $countquizzall : '' }}"   data-isvpaperid="{{ isset($isverbalquiz)  ? $isverbalquiz->paper_id : '' }}"  data-isdpaperid="{{ isset($isdataquiz)  ? $isdataquiz->paper_id : '' }}"   data-isqtpaperid="{{ isset($isqtquiz)  ? $isqtquiz->paper_id : '' }}">
                           @if(isset($pro) && $pro->status == 1)
                           {{$test->test}}{{$test->testincid}}(Proctored)
                           @else
                           {{$test->test}}{{$test->testincid}}(Non Proctored)
                           @endif 
                           </a>
                        </td>
                        @endif
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('css') 
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$('.test').click(function(e){
    e.preventDefault();
     $(this).prop('disabled', true);
})

   $(document).ready(function () {
       $(".test").click(function(){
            var testname = $(this).attr('data-name');
            var statusname = $(this).attr('data-status');
            var fdate = $(this).attr('data-fdate');
            var edate = $(this).attr('data-edate');
            var attempt = parseInt($(this).attr('data-attempt'));
            var qcount = parseInt($(this).attr('data-qcount'));
            if((statusname ==1) && (qcount <= attempt)){
               $('.cont').css('display','block');
                var status = 'Live';
                $('.fdate').text('Start Date:'+fdate).css('display','none');
                $('.edate').text('End Date:'+edate).css('display','none');
            }else if((statusname ==2) && (qcount <= attempt)){
                var status = 'Coming Soon'; 
                 $('.cont').css('display','none');
                 $('.fdate').text('Start Date:'+fdate).css('display','none');
                   $('.edate').text('End Date:'+edate).css('display','none');
            }else if((statusname ==3) && (qcount <= attempt)){
                  var status = 'Scheduled';
                  var fdate = fdate;
                  var edate = edate;
                  var cd =$(this).attr('data-current');
                   // console.log(cd,'cd');
                   // console.log(edate,'edate');
                 if(cd <= edate){
                       $('.cont').css('display','block');
                 }
                   $('.fdate').text('Start Date:'+fdate).css('display','block');
                   $('.edate').text('End Date:'+edate).css('display','block');
           }else if(statusname ==4) {
                  var status = 'Unpublished'; 
                   $('.cont').css('display','none');
                   $('.fdate').text('Start Date:'+fdate).css('display','none');
                   $('.edate').text('End Date:'+edate).css('display','none');
           }
               $('.papername').text(testname).css('display','block');
               $('h3').remove();
               $('.statusname').text(status);
            
           })
       });
       
       $(document).ready(function() {
           $('.setcolor').click(function(){
               $('.newcolordata').removeAttr('style');
               var id = $(this).attr('data-id');
               $('.newcolor'+id).css('background-color','#a6c8f9');
           });
       });
       $(document).ready(function() {
           $('.paper').click(function(e){
               var id = $(this).attr('data-id');
               var paperid = $(this).attr('data-paperid');
               var vpaperid = $(this).attr('data-vpaperid');
               var dpaperid = $(this).attr('data-dpaperid');
               var isverbal = $(this).attr('data-isvpaperid');
               var isdata = $(this).attr('data-isdpaperid');
               //console.log(isdata);
               var isqt = $(this).attr('data-isqtpaperid');
               var attempt = $(this).attr('data-attempt');
               var qcount = $(this).attr('data-qcount');
               var qspaperid = $(this).attr('data-qspaperid');
               var lspaperid = $(this).attr('data-lspaperid');
               var lrpaperid = $(this).attr('data-lrpaperid');
               var qs_set_type =  $(this).attr('data-qsset-type');
               var ls_set_type =  $(this).attr('data-lsset-type');
               var lr_set_type =  $(this).attr('data-lrset-type');
               var i=0;
               var myArray = JSON.parse($(this).attr('data-paperid'));
               var allarr = JSON.parse($(this).attr('data-allrecord'));
               var newarr = $(this).attr('data-allrecord');
               var sid = 'report';
               var i=0;
               if(myArray.length>=1)    
               {
                    console.log("lokk");
                   console.log(myArray.length,"myArray.length");
                   $('.cont').css('display','none'); 
                   $('.newbtnn11').off('click', '.report').empty();
                   $.each(JSON.parse(paperid), function(index, value) {
                       if((value.section_type == 'quantitative')){
                           if(i==0){
                               var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result</a>');   
                               $('.newbtnn11').append(e);
                               console.log(e,"lokk");
                           }else{
                               var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i)+'</a>');   
                               $('.newbtnn11').append(e);
                           }
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.report', [':sid', ':id', ':paperid']) }}";
                               url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               window.location.href=url;
                           })
                       }
                       i++;
                   })   
                }
            //else{
            //       //  console.log("mokk");
            //        $('.cont').css('display','block'); 
            //            $('.report').css('display','none');
            //           //$('.newbtnn').off('click', '.retake').empty(); 
            //     }
               if(allarr.length>=1)    
               {
                   $.each(JSON.parse(newarr), function(index, value) {
                       //console.log(value.set_type,"value.set_type")
                       if((value.set_type== 'nmat-section1') && (value.section_type == 'Logical Reasoning')){
                               var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }else if((value.set_type== 'nmat-section2') && (value.section_type == 'Language Skills')){
                           var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }else if((value.set_type== 'nmat-section3') && (value.section_type == 'Logical Reasoning')){
                           var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }else if((value.set_type== 'nmat-section4') && (value.section_type == 'Quantitative Skills')){
                           var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }else if((value.set_type== 'nmat-section5') && (value.section_type == 'Quantitative Skills')){
                           var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }else if((value.set_type== 'nmat-section6') && (value.section_type == 'Language Skills')){
                           var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(i++)+'</a>');   
                               $('.newbtnn11').append(e); 
                           $('.result'+value.paper_id).click(function(){
                               var url = "{{ route('student.nmat-report', [':id', ':paperid', ':nextid']) }}";
                              // url = url.replace(':sid', sid);
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', value.paper_id);
                               url = url.replace(':nextid', value.set_type);
                               window.location.href=url;
                           })
                       }
                   })
                }else{
                  // $('.report').css('display','none');
                }
              //  if(parseInt(attempt) >= parseInt(qcount)){
                  
                   $('.newbtnn').off('click', '.retake').empty();
                    if((qs_set_type) || (ls_set_type) || (lr_set_type)){
                       if(qs_set_type=='nmat-section1' && qspaperid){
                             //console.log(qs_set_type,"qokk");
                           var e = $('<a class="retake btn btn-primary re'+qspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+qspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', qspaperid);
                               url = url.replace(':sid', qs_set_type);
                               window.location.href=url;
                           });
                       }else if(ls_set_type=='nmat-section1' && lspaperid){
                         //  console.log(qs_set_type,"lokk");
                           var e = $('<a class="retake btn btn-primary re'+lspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lspaperid);
                               url = url.replace(':sid', ls_set_type);
                               window.location.href=url;
                           });
                       }else{
                         //  $('.retake').css('display','none');
                       }
                       if(qs_set_type=='nmat-section2' && qspaperid){
                           var e = $('<a class="retake btn btn-primary re'+qspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                            $('.re'+qspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', qspaperid);
                               url = url.replace(':sid', qs_set_type);
                               window.location.href=url;
                            });
   
                       }else if(lr_set_type=='nmat-section2' && lrpaperid){
                           var e = $('<a class="retake btn btn-primary re'+lrpaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lrpaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lrpaperid);
                               url = url.replace(':sid', lr_set_type);
                               window.location.href=url;
                           });
                       }else{
                        //   $('.retake').css('display','none'); 
                       }
                       if(ls_set_type=='nmat-section3' && lspaperid){
                           var e = $('<a class="retake btn btn-primary re'+lspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lspaperid);
                               url = url.replace(':sid', ls_set_type);
                               window.location.href=url;
                           });
   
                        }else if(qs_set_type=='nmat-section3' && qspaperid){
                           var e = $('<a class="retake btn btn-primary re'+qspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+qspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', qspaperid);
                               url = url.replace(':sid', qs_set_type);
                               window.location.href=url;
                           });
   
                       }else{
                          // $('.retake').css('display','none'); 
                       }
                       if(ls_set_type=='nmat-section4' && lspaperid){
                           var e = $('<a class="retake btn btn-primary re'+lspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lspaperid);
                               url = url.replace(':sid', ls_set_type);
                               window.location.href=url;
                           });
   
                       }else if(lr_set_type=='nmat-section4' && lrpaperid){
                           var e = $('<a class="retake btn btn-primary re'+lrpaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lrpaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lrpaperid);
                               url = url.replace(':sid', lr_set_type);
                               window.location.href=url;
                           });
   
                       }else{
                         //  $('.retake').css('display','none'); 
                       }
                       if(lr_set_type=='nmat-section5' && lrpaperid){
                           var e = $('<a class="retake btn btn-primary re'+lrpaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lrpaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lrpaperid);
                               url = url.replace(':sid', lr_set_type);
                               window.location.href=url;
                           });
   
                       }else if(ls_set_type=='nmat-section5' && lspaperid){
                           var e = $('<a class="retake btn btn-primary re'+lspaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lspaperid);
                               url = url.replace(':sid', ls_set_type);
                               window.location.href=url;
                           });
   
                       }else{
                          // $('.retake').css('display','none');
                       }
                        if(lr_set_type=='nmat-section6' && lrpaperid){
                           var e = $('<a class="retake btn btn-primary re'+lrpaperid+' text-white mx-4">Retake</a>');   
                           $('.newbtnn').append(e); 
                           $('.re'+lrpaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', lrpaperid);
                               url = url.replace(':sid', lr_set_type);
                               window.location.href=url;
                           });
                       }else if(qs_set_type=='nmat-section6' && qspaperid){
                               var e = $('<a class="retake btn btn-primary re'+qspaperid+' text-white mx-4">Retake</a>');   
                               $('.newbtnn').append(e); 
                           $('.re'+qspaperid).click(function(){
                               var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                               url = url.replace(':id', id);
                               url = url.replace(':paperid', qspaperid);
                               url = url.replace(':sid', qs_set_type);
                               window.location.href=url;
                           });
                       }else{
                         //  $('.retake').css('display','none');
                       }
                    }else{
                    //    console.log(isverbal,"isverbal");
                    // //   console.log(vpaperid,"vpaperid");
                    if(vpaperid ==''){
                       // console.log("newokk");
                        $('.cont').css('display','block');
                    }
                        if(vpaperid && isverbal == ''){
                           console.log("okk");
                            $('.cont').css('display','none'); 
                            var e = $('<a class="retake btn btn-primary re'+vpaperid+' text-white mx-4">Resume</a>');   
                            $('.newbtnn').append(e); 
                            $('.re'+vpaperid).click(function(){
                                var url = "{{ route('student.start-quize', [':id', ':paperid']) }}";
                                url = url.replace(':id', id);
                                url = url.replace(':paperid', vpaperid);
                                window.location.href=url;
                            })
                           
                            
                        }else if((isverbal && isdata== '')){
                            console.log(isdata,"okk1");
                            $('.cont').css('display','none'); 
                            var sid = 'data';
                            var e = $('<a class="retake btn btn-primary re'+isverbal+' text-white mx-4">Resume</a>');   
                            $('.newbtnn').append(e); 
                            $('.re'+isverbal).click(function(){
                                var url = "{{ route('student.data-quiz', [':sid', ':id', ':paperid']) }}";
                                url = url.replace(':sid', sid);
                                url = url.replace(':id', id);
                                url = url.replace(':paperid', isverbal);
                                window.location.href=url;
                            })
                        }else if(isdata && isqt == ''){
                            console.log("okk2");
                            $('.cont').css('display','none'); 
                            var sid = 'quantitative';
                            var e = $('<a class="retake btn btn-primary re'+isdata+' text-white mx-4">Resume</a>');   
                            $('.newbtnn').append(e); 
                            $('.re'+isdata).click(function(){
                                var url = "{{ route('student.quantitative-quiz', [':sid', ':id', ':paperid']) }}";
                                url = url.replace(':sid', sid);
                                url = url.replace(':id', id);
                                url = url.replace(':paperid', isdata);
                                window.location.href=url;
                            })
                        }else if(isverbal && isdata && isqt){
                            console.log("okk098");
                           $('.retake').css('display','none');
                          if(parseInt(attempt) > parseInt(qcount)){
                               $('.cont').css('display','block'); 
                           }else{
                               $('.cont').css('display','none');  
                            }
                        
                            var j=0;
                            if(myArray.length>=1 && isqt)    
                            {
                                    $('.newbtnn11').off('click', '.report').empty();
                                    $.each(JSON.parse(paperid), function(index, value) {
                                        if((value.section_type == 'quantitative')){
                                            if(j==0){
                                                var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result</a>');   
                                                $('.newbtnn11').append(e);
                                            }else{
                                                var e = $('<a class="report btn btn-primary result'+value.paper_id+' text-white mx-4">Result'+(j)+'</a>');   
                                                $('.newbtnn11').append(e);
                                            }
                                            $('.result'+value.paper_id).click(function(){
                                                var url = "{{ route('student.report', [':sid', ':id', ':paperid']) }}";
                                                url = url.replace(':sid', sid);
                                                url = url.replace(':id', id);
                                                url = url.replace(':paperid', value.paper_id);
                                                window.location.href=url;
                                            })
                                        }
                                        j++;
                                    })   
                            }else{
                                    $('.report').css('display','none');
                                    $('.cont').css('display','block'); 
                            } 
                        }else{  
                            $('.retake').css('display','none');  
                        }
                    }
                  
                // }else{  
                //     $('.retake').css('display','none');  
                //      $('.cont').css('display','none'); 
                // }
           })
       })
       $(document).ready(function() {
           $('.pro').click(function(){
               var pro = $(this).attr('data-pros');
               var code =  $(this).attr('data-procode');
               var id = $(this).attr('data-id');
               var motype =  $(this).attr('data-mtype');
               $('.cont').click(function(){
                   if(motype == 2){
                       if(pro == 1){
                           $('.proin').css('display','block');
                           $('.proin').on('blur', function() {
                               var checkcode =  $(this).val();
                               if(code == checkcode){
                                   var url = "{{ route('student.instructions', ':id') }}";
                                   url = url.replace(':id', id);
                                   window.location.href=url;
                               } else{
                                   alert('Please Enter Correct Proctored Code');
                               }
                           })
                       }else{
                           $(".instructions").click(function(){
                               var url = "{{ route('student.instructions', ':id') }}";
                               url = url.replace(':id', id);
                               window.location.href=url;
                           });    
                       }
                   }else if(motype == 3){
                       $(".instructions").click(function(){
                           var url = "{{ route('student.nmat-instructions', ':id') }}";
                           url = url.replace(':id', id);
                           window.location.href=url;
                       }); 
                   }
               })   
           })
       })


$(document).ready(function() {
    $('.paper').click(function(){
        localStorage.clear();
    });
});


</script>