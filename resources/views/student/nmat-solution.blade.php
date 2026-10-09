@extends('student_template')
@section('css')
@endsection
@section('content')

<style>
   .green {
         appearance: none;
         padding: 10px;
         background-color: green;
         border-radius:50%;

      }
      .red {
         appearance: none;
         height:10px;
         width:2px;
         border-radius:50%;
         background-color: red;
      }
      
      input[type="radio"] {
       border:2px solid black;
       padding: 5;
       margin-bottom: -24px;
     }
   
   </style>
   
<div class="container-fluid">
   <?php
    $testid = request()->testid;
    $paperid = request()->paperid;
    $sid = 'nmat-section1';
        $excel_questions = DB::table('excel_questions')
                        ->where('test_id',$testid)
                        ->get();
                        
        foreach($excel_questions as $excel_question)
        {
            $section_name[] =   $excel_question->section_name;
        }
        $sectionArray = array_unique($section_name);
        $search_terms = [
            'Quantitative Skills' => 'Quantitative Skills',
            'Language Skills' => 'Language Skills',
            'Logical Reasoning' => 'Logical Reasoning'
        ];
        $result = [];
        foreach ($search_terms as $key => $term) {
            foreach ($sectionArray as $value) {
                if (stripos($value, $term) !== false) {
                    $result[] = $key; 
                    break; 
                }
            }
        }
    $result_string = implode(', ', $result);
    $exploded_array = explode(', ', $result_string);
   
    ?>
   <div class="row" id="detaildiv" >
      <div class="col-1 pt-3 px-3" id="crossbutton">
         <a href="{{route('student.nmat-report',['id'=>$testid,'paperid'=>$paperid,'nextid'=>$sid])}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
               <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
               <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
         </a>
      </div>
      <div class="col-8" style="border-right:1px solid lightgray; height:100%;">
         <h6 CLASS="py-3">{{$test->test}}{{$test->testincid}}</h6>
      </div>
      <div class="col-3">
         <?php
         $useremail =session()->get('email');
         ?>
         <h6 class="py-3"><b>User: {{$useremail}}</b></h6>
      </div>
   </div>
   <div class="row">
      <div class="col-LG-9" style="border-right:1px solid lightgray; height:100%;">
         <div class="row">
            <div class="col-12 py-2" style="border-bottom:1px solid lightgray">
               <!-- <button type="button" class="btn btn-outline-secondary verbal">VERBAL AND READING COMPREHENSIVE</button> -->
            <button class="btn btn-primary my-2" type="button" disabled="disabled">Quantitative Skills</button>
             <button type="button  my-2" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">+2 SECTIONS</button>
            </div>
         </div>
         <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
      <div class="offcanvas-header">
         <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Change Section</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p>By changing section, you will be shifted to a new section. If you are sure about section change, select any from below.</p>
     @if(in_array('Quantitative Skills', $exploded_array))
    <a class="btn btn-outline-secondary my-1  px-auto w-100" href="{{route('student.nmat-solution',['testid'=>$testid,'paperid'=>$paperid])}}">Quantitative Skills</a>
    @endif
    @if(in_array('Language Skills', $exploded_array))
    <a class="btn btn-outline-secondary my-1 px-auto w-100" href="{{route('student.languagesolution',['testid'=>$testid,'paperid'=>$paperid])}}">Language Skills</a>
    @endif
    @if(in_array('Logical Reasoning', $exploded_array))
    <a class="btn btn-outline-secondary my-1 px-auto w-100" href="{{route('student.logicalsolution',['testid'=>$testid,'paperid'=>$paperid])}}">Logical Reasoning</a>
    @endif
  </div>
</div>
  @if((isset($verbal_ques)) && (isset($verbal_reports)) && (isset($verbal_r)))
      <?php
      if(isset($verbal_r)){
            foreach($verbal_r as $verbal_rs){
               $aner[] = explode(',', $verbal_rs->answer);
               $avgtime[] = explode(',', $verbal_rs->ans_duration);
               $alluser[] =  $verbal_rs->user_id;
            }
      }
      ?>
         <div class="row">
            <div class="col-12 py-2">
               <div class="row" style="background-color:#fdf7f7; min-height:50px; height:auto">
                  <div class="col-4 py-2">
                      <span style="display:flex;">&nbsp;&nbsp;Marks
                        <?php
                        $i = 1; 
                        ?>
                        @if(isset($verbal_ques))
                      @foreach($verbal_ques as $key=> $ques_paper)
                        <span class="text-success pos posti{{$i}}" style="display:none">&nbsp;{{$ques_paper->positive_mark}},</span>
                        @if($ques_paper->negative_mark == 0)
                        <span class="text-secondary neg negti{{$i}}" style="display:none">&nbsp;{{$ques_paper->negative_mark}}</span>
                        @else
                        <span class="text-secondary neg negti{{$i}}" style="display:none">&nbsp;-{{$ques_paper->negative_mark}}</span>
                        @endif
                        <?php
                        $i++;
                        ?>
                     @endforeach
                     @endif
               </span>
                     <!-- <span><b>You have missed this question, you scored</b></span> -->
                     <!-- <span class="text-danger"><b>0.0</b></span> -->
                  </div>
                  <?php
                   $artf = array();
                   $qdatay = array();
                   $alluser = array();
                  // $avgtime  = array();
                   $k =1;
                   if(isset($verbal_reports)){
                  $qus_id = explode(',', $verbal_reports->ans_duration);
                  foreach($verbal_r as $verbal_rs){
                     $aner[] = explode(',', $verbal_rs->answer);
                     $avgtime[] = explode(',', $verbal_rs->ans_duration);
                     $alluser[] =  $verbal_rs->user_id;
                  }
                   }
                  ?>
                  <div class="col-8">
                     <div class="row">
                        @foreach($verbal_ques as $key=> $ques_p)
                           <div class="anstime ansti{{$k}}" style="display:none;" >
                              @foreach($qus_id as $key1=> $qus_ids)
                                <?php
                                $qtime = date("H:i:s", $qus_ids / 1000);
                                ?>
                                 @if(isset($key) && isset($key1) && $key == $key1)
                                
                                    <div class="col-4 text-end" style="float:left; text-align:center !important;">
                                       YOUR TIME</br>{{$qtime}}
                                    </div>
                                 @endif
                              @endforeach
                          <?php
                           $anerwrr = array();
                           $anerwrr1 = array();
                           
                          ?>
                            @foreach($aner as $key2=> $anerw)
                              @foreach($anerw as $key1=> $anerws)
                              
                                  @if(isset($key) && isset($key1) && $key == $key1)
                                   @if(strcasecmp($ques_p->correct_option, $anerws) == 0)
                                    <?php
                                      $anerwrr[] = $anerws;
                                    ?>
                                    @endif
                                       @if(strcasecmp($ques_p->correct_option, $anerws) != 0)
                                    <?php
                                      $anerwrr1[] = $anerws;
                                    ?>
                                     @endif
                                 @endif
                              @endforeach
                           @endforeach
                           <?php
                          $tota0 =  (count($anerwrr))+(count($anerwrr1));
                          
                          if($tota0 == 0){
                              $tota0 =1;
                          }
                           $da1 = count($anerwrr);
                           
                          /// $newans =($da1/$tota0) *100;
                           $newans = ceil(($da1/$tota0) *100);
                          
                           ?>
                           <div class="col-4 text-end " style=" float:left; text-align:center !important;">
                               OVERALL CORRECT</br>{{$newans}}%
                           </div>
                              <?php
                                // $dtw = array();
                                // $a = array();  // Initialize $a as an empty array
                                // for ($i = 0; $i < count($avgtime); $i++) {
                                //     for ($j = 0; $j < count($avgtime[$i]); $j++) {
                                //         if (!isset($a[$j])) {
                                //             $a[$j] = 0;  // Ensure $a[$j] is initialized
                                //         }
                                //         $a[$j] += $avgtime[$i][$j];
                                //     }
                                // }
                                $dtw = array();
                                $a = array();  
                                
                                for ($i = 0; $i < count($avgtime); $i++) {
                                    for ($j = 0; $j < count($avgtime[$i]); $j++) {
                                        // Ensure $a[$j] is initialized
                                        if (!isset($a[$j])) {
                                            $a[$j] = 0;
                                        }
                                        $value = isset($avgtime[$i][$j]) ? floatval($avgtime[$i][$j]) : 0;
                                        $a[$j] += $value;
                                    }
                                }

                            ?>

                           <!--avragetime-->
                           @foreach($avgtime as $key3=> $avgtimes)
                            @foreach($avgtimes as $key4=> $avgtimess)
                           <?php
                              $dtw[] =  $avgtimess;
                           ?>
                           @endforeach
                           @endforeach
                           <!--endavrg-->
                           <?php
                           $avg = array();
                           foreach($verbal_ques as $key=> $ques_paper)
                           {
                              foreach($a as $key1=> $val)
                              {
                                 if($key == $key1)
                                 {
                                    $numberuser = count($alluser);
                                    $avg[] = $val/$numberuser;
                                    //$tid[] = date("H:i:s", $avg / 1000);
                                 }
                              }
                           }     
                           ?>
                              <div class="col-4 text-end " style="float:left; text-align:center !important;">
                                 AVERAGE TIME<br/>
                                 <?php
                                    $i =1;
                                    foreach($avg as $key=> $val)
                                    {
                                       $newval = date("H:i:s", $val / 1000);
                                       echo'<p class="newavg avg'.$i.'" data-avg="'.$i.'" style="display:none;">'.$newval.'</p>';
                                       $i++;
                                    }
                                 ?>
                              </div>
                               </div>
                           <?php $k++; ?>
                        @endforeach  
                     </div>
                  </div>
               </div>
            <div class="maindiv">
              
               <?php
               
               $i =1;
               $arr = array();
               $qid = explode(',', $verbal_reports->question_id);
               $ans = explode(',', $verbal_reports->answer);
                 $ans = array_pad($ans, count($qid), '');
               ?>
                @foreach($verbal_ques as $key=> $ques_paper)
                

                @if((empty($ques_paper->instruction))  || ($ques_paper->instruction == 'empty'))
                
               <div class="row ques{{$i}} qusn" style="display:none;">
               
                   <div class="col-12"id="divcontent">
                       <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                       <br/>
                      ANSWER
                      @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                       @if($ques_paper->status == 1)
                                    <ol class="list-group choices">
                                       <?php
                                          $ansstr = $ques_paper->answer;
                                          $ans = explode(",",$ansstr);
                                          $lk =1;
                                          ?>
                                       @foreach($ans as $value)
                                       <!-- <li class="list-group-item"><input type="radio" name="options">
                                          <span>
                                          <?= htmlspecialchars_decode($value) ?>
                                          </span>
                                       </li> -->
                                       <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($value) ?>
                                          </label>
                                       </div></li>
                                       <?php $lk++; ?>
                                       @endforeach
                                    </ol>
                                    @else
                                    <!--start-->
                                         <ol class="list-group choices">
                                    @foreach($ans as $key1=> $anss)                   
                                       @if($key == $key1)
                                      
                                       @if($anss ==1)
                                       @if($ques_paper->correct_option ==1)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options" class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                        
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                         
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                         
                                           @endif

                                       @if($anss ==2)
                                       @if($ques_paper->correct_option ==2)
                                          <!-- <li class="list-group-item"><input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                         
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                           @endif

                                        @if($anss ==3)
                                       @if($ques_paper->correct_option ==3)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                         
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                       @if($anss ==4)
                                       @if($ques_paper->correct_option ==4)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                         
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                           @endif

                                          @if($ques_paper->option5)
                                       @if($anss ==5)
                                       @if($ques_paper->correct_option ==5)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                         
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li  class="list-group-item"> <input type="radio" name="options"  class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @endif
                                          @endif
                                    @endforeach
                                     </ol>
                                    <!--end-->
                                    @endif
                      @else
                         @foreach($ans as $key1=> $anss)                   
                           @if($key == $key1)
                             {{$anss}}
                           @endif
                        @endforeach
                      @endif
                  </div> 
                  <!-- <div class="corretans cns{{$i}}" style="display:none"><span class="text-success">Correct Answer{{$ques_paper->correct_option}}</span></div> -->
               </div>
               @else
                <div class="row ques{{$i}} qusn" style="display:none;">
                  <div class="col-6" id="divcontent" style="width:50%; float:left;">
                    <?= htmlspecialchars_decode($ques_paper->instruction) ?>
                  </div>
                   <div class="col-6" id="divcontent" style="width:50%; float:left;">
                     <b>Q{{$i}}.</b><?= htmlspecialchars_decode($ques_paper->question) ?>
                     ANSWER
                     @if($ques_paper->question_type =='MULTI_CHOICE' || ($ques_paper->question_type == 'multiple'))
                                    @if($ques_paper->status == 1)
                                       <ol class="list-group choices">
                                          <?php
                                             $ansstr = $ques_paper->answer;
                                             $ans = explode(",",$ansstr);
                                             $lk =1;
                                             ?>
                                          @foreach($ans as $value)
                                          <!-- <li class="list-group-item">
                                            <input type="radio" name="options" style=" accent-color: #232323;" checked /><span>
                                            <?= htmlspecialchars_decode($value) ?>
                                             </span>
                                          </li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input" name="options" style=" accent-color: #232323;" checked />
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($value) ?>
                                          </label>
                                       </div></li>
                                          <?php $lk++; ?>
                                          @endforeach
                                       </ol>
                                    @else
                                     <!--start-->
                                         <ol class="list-group choices">
                                    @foreach($ans as $key1=> $anss)                   
                                       @if($key == $key1)
                                      
                                       @if($anss ==1)
                                       @if($ques_paper->correct_option ==1)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options" class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option1) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option1) ?>
                                          </label>
                                       </div></li>
                                           @endif

                                       @if($anss ==2)
                                       @if($ques_paper->correct_option ==2)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                         
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="showdata" /><span><?= htmlspecialchars_decode($ques_paper->option2) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option2) ?>
                                          </label>
                                       </div></li>
                                           @endif

                                        @if($anss ==3)
                                       @if($ques_paper->correct_option ==3)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option3) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option3) ?>
                                          </label>
                                       </div></li>
                                           @endif

                                       @if($anss ==4)
                                       @if($ques_paper->correct_option ==4)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options" class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"   class="showdata"/><span><?= htmlspecialchars_decode($ques_paper->option4) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option4) ?>
                                          </label>
                                       </div></li>
                                           @endif
                                          @if($ques_paper->option5)
                                       @if($anss ==5)
                                       @if($ques_paper->correct_option ==5)
                                          <!-- <li class="list-group-item"> <input type="radio" name="options"  class="green showdata" /><span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                          <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input green showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                          @else
                                           <!-- <li class="list-group-item"> <input type="radio" name="options"  class="red showdata" /><span><?= htmlspecialchars_decode($ques_paper->option5) ?></span></li> -->
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input red showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                        
                                           @endif
                                          @else
                                         
                                           <li class="list-group-item">
                                       <div class="form-check">
                                          <input type="radio" class="form-check-input  showdata" name="options"/>
                                          <label class="form-check-label" >
                                          <?= htmlspecialchars_decode($ques_paper->option5) ?>
                                          </label>
                                       </div></li>
                                           @endif


                                          @endif
                                      
                                          @endif
                                    @endforeach
                                     </ol>
                                    <!--end-->
                                      
                                    @endif
                                    @else
                                          @foreach($ans as $key1=> $anss)                   
                                          @if($key == $key1)
                                            {{$anss}}
                                          @endif
                                          @endforeach
                                     @endif
                  </div> 
                 <!--  <div class="corretans cns{{$i}}" style="display:none">
                     <span class="text-success"> Correct Answer: {{$ques_paper->correct_option}}</span>
                  </div> -->
               </div>
               @endif
               <?php 
               $arr[] = $ques_paper;
               $i++; 
               ?>

               @endforeach
            </div>
               <div class="row">
                  <div class="col-12 py-2 d-flex justify-content-around">
                     <button type="button" class="btn btn-primary expt" data-bs-toggle="modal" data-bs-target="#exampleModal" data-set="">EXPALANTION&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button>
                      <button type="button" class="btn btn-primary exptt" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-set="">Correct Answer&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button>
                       <!-- <button type="button" class="btn btn-primary showcol">Show Answer&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></button> -->
                      <?php
                        $total = count($arr);
                      ?>
                     <a type="button" class="btn btn-primary nxt" STYLE="float:right" data-ntx ="" data-total="{{$total}}">NEXT&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="buttondiv">
            <?php
               $j =1;
               $correct = array();
               $data = array();
               $aners= explode(',', $verbal_reports->answer);
               $question_id= explode(',', $verbal_reports->question_id);
               $result = [];

               foreach ($question_id as $key => $value) {
                  $result[$key] = isset($aners[$key]) ? $aners[$key] : '';
               }



            ?>
             @foreach($verbal_ques as $key=>$ques_paper)
             <?php
              $correct = $ques_paper->correct_option;
             
              foreach($result as $key1=>$anerss)
              {
              
             ?>
               @if($key == $key1)
                  @if(strcasecmp($anerss, $correct) == 0)
                     <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" style="background-color:green;">{{$j}}</button>
                  @elseif(empty($anerss))
                     <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" >{{$j}}</button>
                  @else
                     <button type="button" class="btn btn-secondary buttonround mt-2 mx-1 ans{{$j}} answer" data-value="{{$j}}" style="background-color:red;">{{$j}}</button>
                  @endif 
               @endif
           <?php }?>
           <?php $j++;?>
            @endforeach
         </div>
         <div id="identation">
            <div class="row">
               <div class="col-12">
                  <span style="height:20px; width:20px; background-color:green; border-radius:50%; margin:5px; float:left"></span>
                  <span style="float:left;font-size:13px;margin-top:5px;">
                    <p>Correct Answer</p>
                  </span>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <span style="height:20px; width:20px; background-color:RED; border-radius:50%; float:left"></span>
                  <span style="float:left;font-size:13px;margin-top: 0px;margin-left: 11px;">
                     <p>&nbsp;Wrong Answer</p>
                  </span>
               </div>
               <div class="col-6">
                  <span style="height:20px; width:20px; background-color:lightgrey; border-radius:50%; margin:5px; float:left"></span>
                  <span style="float:left;font-size:13px; margin-top:5px">
                     <p>Not Answered</p>
                  </span>
               </div>
            </div>
         </div>
         <div>

            <?php
            $sectionid =1;
            ?>
            <a class="btn btn-default" href="{{route('student.solution-question',['testid'=>$testid,'sectionid'=>$sectionid,'paperid'=>$paperid])}}">All Questions</a>
            <!-- <button type="button" class="btn bg-transparent">INSTRUCTION</button> -->

              <a class="btn btn-default" href="{{route('student.solution-instruction',['testid'=>$testid,'sectionid'=>$sectionid,'paperid'=>$paperid])}}">Instructions
            </a>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Answer Explanation</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php 
               $l =1; 
            ?>
               @foreach($verbal_ques as $ques_paper)
            <div class="expl excp{{$l}}" style="display:none;"><?= htmlspecialchars_decode($ques_paper->answer_explanation) ?></div>
            <?php $l++;?>
            @endforeach
            </div>
         </div>
   </div>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Correct Answer</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php 
               $lk =1; 
            ?>
               @foreach($verbal_ques as $ques_paper)
            <div class="cre crtc{{$lk}}" style="display:none;">
            @if($ques_paper->question_type == 'multiple' || $ques_paper->question_type == 'MULTI_CHOICE')
            @if($ques_paper->correct_option == 1)
               A
            @elseif($ques_paper->correct_option == 2)
             B
            @elseif($ques_paper->correct_option == 3)
             C
            @elseif($ques_paper->correct_option == 4)
             D
            @else
            <?= htmlspecialchars_decode($ques_paper->correct_option) ?>

            @endif

            @else
            <?= htmlspecialchars_decode($ques_paper->correct_option) ?>
            @endif
            </div>
            <?php $lk++;?>
            @endforeach
            </div>
         </div>
   </div>
</div>
@endif
<script type="text/javascript" src="{{asset('assets/admin/js/solution.js')}}"></script>
<script>
//   // newavg avg'.$key.'" 
//    var ctr = 1;
//    $(document).ready(function(){
//       $('.posti1').css('display','block');
//    $('.nxt').click(function(){
     
//       ctr +=1;
//       $('.pos').css('display','none');
//       $('.posti'+ctr).css('display','block');
//       //$('.newavg').css('display','none');
//    })
// });
</script>
<script type="text/javascript">
   $(document).ready(function() {
        // Disable text selection
        $(document).on("selectstart dragstart", function(event) {
           event.preventDefault();
        });
     });
     $(document).ready(function() {
         $('body').bind('cut copy paste', function(event) {
            event.preventDefault();
         });
     });
     
     </script>
      <script>
//      $(window).on('keydown',function(event)
//      {
//      //  console.log(event);
//       if(event.keyCode == 116){
//           return false;
//              //event.preventDefault();
//       }
//       if(event.keyCode == 17){
//           return false; 
//       }else if(event.keyCode == 16){
//           return false;
//       }else if(event.keyCode == 82){
//           return false;
//       }
//      // //   else if(event.keyCode == 116){
//      // //      return false; 
//      // //   }
//      if(event.keyCode==123)
//      {
      
//          return false;
//      }
//      else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
//      {
        
//          return false;  //Prevent from ctrl+shift+i
//      }
//      else if(event.ctrlKey && event.keyCode==73)
//      {
//         // alert('Entered ctrl+shift+i')
//          return false;  //Prevent from ctrl+shift+i
//      }
// });
//  $(document).on("contextmenu",function(e)
//  {
//  return false;
// });

</script>
@endsection
@section('css') 
@endsection

