
@extends('admin_template')
@section('css')
@endsection
@section('content') 
<div class="col-md-9" id="right-menu-bar">
     <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
          @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <h5 class="fw-bold text-capitalize">{{$tests->test}}{{$tests->testincid}}</h5>
     </div>
     <div id="right-menu-bar" class="col-md-12">
          <?php
          $url_id =request()->id;
          $tests_record = DB::table('tests')->where('id',$url_id)->first();
          $quiz_durations = DB::table('quiz_durations')
                              ->where('test_id',$url_id)
                              ->orderBy('id', 'DESC')
                              ->first();
          $tests = DB::table('test_templatevalues')->where('temp_id',$tests->testtempid)->first();
          $test_temp = DB::table('test_templates')->where('id',$tests->temp_id)->first();
         
          $arr = $tests->total_section;
          
          $arr1 =  explode(",",$arr);
         
          foreach($arr1 as $value => $arr2)
          {
               $arr3 =   $arr2;
               $data = str_replace("[",' ',$arr3);
               $data1[] = str_replace("]",' ',$data);     
          }
         
          if($test_temp->name == 'CAT'){
               $key0 = array_search($data1[0],$data1);
               $key3 = array_search($data1[3],$data1);
               $key6 = array_search($data1[6],$data1);
          }elseif($test_temp->name == 'NMAT'){
               $key0 = array_search($data1[0],$data1);
               $key3 = array_search($data1[3],$data1);
               $key6 = array_search($data1[6],$data1);   
          }
          ?>
            @if($test_temp->name == 'CAT')
            <?php
            $question = DB::table('excel_questions')->where('test_id',$url_id)->get();
          //  dd($question);
            ?>
          <div class="container-fluid">
      <label class=" w-100 btnInstruction"><a href="{{route('admin.instruction',$url_id)}}">Instruction</a></label>
    </div>
          <div class="card">
               <div class="container-fluid accordion1">
                    <label>{{$data1[0]}}</label>
                   <!-- <span class="edit">EDIT</span>
                <i class="fas fa-trash"></i>-->
                <span style="margin-left:220px;">{{$total_verbal}} Questions</span>
               @if(!empty($quiz_durations->duration))
               @if($quiz_durations->duration == 'section_duration')
                <span style="margin-left:20px;">{{$quiz_durations->verbal_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
                <!-- <button class="edit1">
                <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a>
                </button> -->
                    <a class="multiplech" data-id = "{{$key0}}" data-value="{{$data1[0]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key0}} panel" style="display:none;">
                    <table class="table responsive" style="width:890px;">
                         <?php
                          $i =1;
                         
                         ?>
                    @foreach($question as $ques)
                         <?php
                         
                         $sentence=  $ques->section_name;
                         $verbal = strtok($sentence, " ");
                        
                         ?>
                         @if($verbal =='VERBAL' || $verbal =='Verbal')
                              <tr>
                                   <td>{{$i}}</td>
                                <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                               
                         <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$i])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                              </tr>
                              <?php
                              $i++;
                              ?>
                         @endif    
                    @endforeach  
                    </table>

                         <!-- <h2>PAPER1</h2> -->
                    </div>
               </div>
          </div>
            <br/>
            <div class="card">
                <div class="container-fluid accordion1">
                    <label>{{$data1[3]}}</label>
                    <!--<span class="edit">EDIT</span>
                <i class="fas fa-trash"></i>-->
                <span style="margin-left:220px;">{{$total_data}} Questions</span>
                @if(!empty($quiz_durations->duration))
                @if($quiz_durations->duration == 'section_duration')
                <span style="margin-left:20px;">{{$quiz_durations->interp_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
                <!-- <button class="edit1">
                <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a>
                </button> -->
                    <a class="multiplech" data-id = "{{$key3}}" data-value="{{$data1[3]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key3}} PANEL" style="display:none">
                         <!-- <h2>PAPER2</h2> -->
                         <table class="table responsive" style="width:890px;">
                              <?php
                              $j=1;
                              ?>
                              @foreach($question as $ques)
                                   <?php
                                   $sentence=  $ques->section_name;
                                   $verbal1 = strtok($sentence, " ");
                                   ?>
                                   @if($verbal1 =='DATA' || $verbal1 =='Data')
                                        <tr>
                                             <td>{{$j}}</td>
                                             <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                                        <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$j])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                        </tr>
                                        <?php
                                             $j++;
                                        ?>
                                   @endif     
                              @endforeach  
                         </table>
                    </div>
                </div>
            </div>
            <br/>
            <div class="card">
                <div class="container-fluid accordion1">
                    <label style="margin-right:200px;">{{$data1[6]}}</label>
                    <!--<span class="edit">EDIT</span>
                <i class="fas fa-trash"></i>-->
                <span style="margin-left:220px;">{{$total_qt}} Questions</span>
                @if(!empty($quiz_durations->duration))
                 @if($quiz_durations->duration == 'section_duration')
                <span style="margin-left:20px;">{{$quiz_durations->quantitative_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
               <!--  <button class="edit1">
                <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a>
                </button> -->
                    <a class="multiplech" data-id = "{{$key6}}" data-value="{{$data1[6]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key6}} panel" style="display:none">
                     <table class="table responsive" style="width:890px;">
                         <?php
                         $k=1;
                         ?>
                              @foreach($question as $ques)
                                   <?php
                                   $sentence=  $ques->section_name;
                                   $verbal2 = strtok($sentence, " ");
                                   ?>
                                   @if($verbal2 =='QUANTITATIVE' || $verbal2 =='Quantitative')
                                        <tr>
                                             <td>{{$k}}</td>
                                             <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                                        <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$k])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                        </tr>
                                         <?php
                                             $k++;
                                        ?>
                                   @endif     
                              @endforeach  
                         </table>
                         <!-- <h2>PAPER3</h2> -->
                    </div>
                </div>
            </div>
            <br/>
            @elseif($test_temp->name == 'NMAT')
            <?php
            $question = DB::table('excel_questions')->where('test_id',$url_id)->get();
            ?>
          <div class="container-fluid">
      <label class="w-100 btnInstruction"><a href="{{route('admin.instruction',$url_id)}}">Instruction</a></label>
    </div>
     <br/>
          
               <div class="container-fluid accordion1">
                    <label style="margin-right:260px;">{{$data1[0]}}</label>
                    <!-- <span class="edit">EDIT</span> -->
                <!-- <i class="fas fa-trash"></i> -->
                <span style="margin-left:20px;">{{$total_language}}Questions</span>
                <!-- <span style="margin-left:20px;">60 Minutes</span> -->
                @if(!empty($quiz_durations->duration))
               @if($quiz_durations->duration == 'nmat_duration')
                <span style="margin-left:20px;">{{$quiz_durations->language_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
                <!-- <button class="edit1"> -->
                <!-- <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a> -->
                <!-- </button> -->
                    <a class="multiplech" data-id = "{{$key0}}" data-value="{{$data1[0]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key0}} panel" style="display:none">
                    <table class="table responsive" style="width:890px;">
                    <table class="table responsive" style="width:890px;">
                         <?php
                         $l =1;
                         ?>
                              @foreach($question as $ques)
                                   <?php
                                   $verbal2=  $ques->section_name;

                                  // $verbal2 = strtok($sentence, " ");
                                  // dd($verbal2);
                                   ?>
                                   @if($verbal2 =='Language Skills' || $verbal2 =='Language Skills')

                                        <tr>
                                             <td>{{$l}}</td>
                                             <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$l])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                        </tr>
                                         <?php
                                             $l++;
                                        ?>
                                   @endif     
                              @endforeach  
                         </table> 
                    </table>
                         <!-- <h2>PAPER1</h2> -->
                    </div>
               </div>
            <br/>
            
                <div class="container-fluid accordion1">
                    <label style="margin-right:240px;">{{$data1[3]}}</label>
                   <!--  <span class="edit">EDIT</span>
                <i class="fas fa-trash"></i> -->
                <span style="margin-left:20px;">{{$total_qs}}Questions</span>
                <!-- <span style="margin-left:20px;">60 Minutes</span> -->
                  @if(!empty($quiz_durations->duration))
               @if($quiz_durations->duration == 'nmat_duration')
                <span style="margin-left:20px;">{{$quiz_durations->qs_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
                <!-- <button class="edit1"> -->
                <!-- <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a> -->
                <!-- </button> -->
                    <a class="multiplech" data-id = "{{$key3}}" data-value="{{$data1[3]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key3}} panel" style="display:none">
                         <!-- <h2>PAPER2</h2> -->
                       <!--   <table class="table responsive" style="width:890px;">
                              @foreach($question as $ques)
                                   @if($ques->question_type =='Quantitative Skills')
                                        <tr>
                                        <td><a href="#"><?= strip_tags($ques->question)?></a></td>
                                        </tr>
                                   @endif    
                              @endforeach  
                         </table> -->
                         <table class="table responsive" style="width:890px;">
                              <?php
                              $m=1;
                              ?>
                              @foreach($question as $ques)
                                   <?php
                                   $verbal2=  $ques->section_name;

                                  // $verbal2 = strtok($sentence, " ");
                                  // dd($verbal2);
                                   ?>
                                   @if($verbal2 =='Quantitative Skills' || $verbal2 =='Quantitative Skills')

                                        <tr>
                                             <td>{{$m}}</td>
                                             <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$m])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                        </tr>
                                         <?php
                                             $m++;
                                        ?>
                                   @endif     
                              @endforeach  
                         </table> 
                    </table>
                    </div>
                </div>
          
            <br/>
           
                <div class="container-fluid accordion1">
                    <label style="margin-right:240px;">{{$data1[6]}}</label>
                <!--     <span class="edit">EDIT</span>
                <i class="fas fa-trash"></i> -->
                <span style="margin-left:20px;">{{$total_logical}}Questions</span>
                <!-- <span style="margin-left:20px;">60 Minutes</span> -->
                 @if(!empty($quiz_durations->duration))
               @if($quiz_durations->duration == 'nmat_duration')
                <span style="margin-left:20px;">{{$quiz_durations->logical_time}}Minutes</span>
                @else
                <span></span>
                @endif
                @else
                <span></span>
                @endif
                <!-- <button class="edit1"> -->
                <!-- <a href="{{route('admin.preview',[$data1[0],$url_id])}}">Preview</a> -->
                <!-- </button> -->
                    <a class="multiplech" data-id = "{{$key6}}" data-value="{{$data1[6]}}" data-val="{{$tests_record->id}}">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <div class="multidiv{{$key6}} panel" style="display:none">
                        <!--  <table class="table responsive" style="width:890px;">
                              @foreach($question as $ques)
                                   @if($ques->question_type =='Logical Reasoning')
                                        <tr>
                                             <td><a href="#"><?= strip_tags($ques->question)?></a></td>
                                        </tr>
                                   @endif    
                              @endforeach  
                         </table> -->

                          <table class="table responsive" style="width:890px;">
                              <?php
                              $n =1;
                              ?>
                              @foreach($question as $ques)
                                   <?php
                                   $verbal2=  $ques->section_name;

                                  // $verbal2 = strtok($sentence, " ");
                                  // dd($verbal2);
                                   ?>
                                   @if($verbal2 =='Logical Reasoning' || $verbal2 =='Logical Reasoning')

                                        <tr>
                                             <td>{{$n}}</td>
                                             <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        <td><a href="{{route('admin.editquestion',['urlid'=>$url_id,'id'=>$ques->id,'sr'=>$n])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                        </tr>
                                         <?php
                                             $n++;
                                        ?>
                                   @endif     
                              @endforeach  
                         </table> 
                         <!-- <h2>PAPER3</h2> -->
                    </div>
                </div>
          
            <br/>
          @endif
          <!-- <button class="btnSection">Drag And Drop New Section</button> -->
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
     $('.multiplech').click(function(){
          var key = $(this).attr('data-id');
          var dataval = $(this).attr('data-value');
           var testid = $(this).attr('data-val');
          var slide = $('.multidiv'+key).toggle("slide");
          if(key){
               
               $('.multiplechoice').click(function(){
                    var mul = $(this).attr('data-mul');
                    var nu = $(this).attr('data-nu');
                    var ess = $(this).attr('data-ess');
                    var fillblanks = $(this).attr('data-fill');
                    if(mul){
                         var url = "{{ route('admin.questionbuilder', [':slug', ':mul', ':id']) }}";
                         url = url.replace(':slug', dataval);
                         url = url.replace(':mul', mul);
                         url = url.replace(':id', testid);
                         window.location.href=url;
                    }else if(nu){
                         var url = "{{ route('admin.questionbuilder', [':slug', ':nu', ':id']) }}";
                         url = url.replace(':slug', dataval);
                         url = url.replace(':nu', nu);
                         url = url.replace(':id', testid);
                         window.location.href=url;
                    }else if(ess){  
                         var url = "{{ route('admin.questionbuilder', [':slug', ':ess', ':id']) }}";
                         url = url.replace(':slug', dataval);
                         url = url.replace(':ess', ess);
                         url = url.replace(':id', testid);
                         window.location.href=url;
                    }else if(fillblanks){  
                         var url = "{{ route('admin.questionbuilder', [':slug', ':fillblanks', ':id']) }}";
                         url = url.replace(':slug', dataval);
                         url = url.replace(':fillblanks', fillblanks);
                         url = url.replace(':id', testid);
                         window.location.href=url;
                    }
                   
               });
          }  
     });
});
</script>




