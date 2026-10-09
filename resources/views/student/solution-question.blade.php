 

@extends('student_template')
@section('css')
@endsection
@section('content')
<style>
.solution-content{
   margin-top: 26px;
    margin-bottom: 20px;
    border: 2px solid black;
    padding: 20px 30px;
    border-radius: 20px;
}
.choice{
   margin-bottom: 15px;
}
</style>

<div class="container-fluid verbal">
<div class="container ">
   <div class="solution-content">

<?php
   $i =1;
  $sectionid =request()->sectionid;
$paperid =request()->paperid;
$testid =request()->testid;
//dd( $sectionid);
?>
               <div class="row" style="border-bottom:2px solid lightgrey">
                  <div class="col-md-1" style="border-right:2px solid lightgray; float:left">
                     @if($sectionid ==1)
                     <a class="btn btn-default" href="{{route('student.solution',['testid'=>$testid,'paperid'=>$paperid])}}">
                        <i class="fa fa-close"></i>
                     </a>
                     @elseif($sectionid == 2)
                       <a class="btn btn-default" href="{{route('student.datasolution',['testid'=>$testid,'paperid'=>$paperid])}}">
                        <i class="fa fa-close"></i>
                     </a>
                     @else
                        <a class="btn btn-default" href="{{route('student.qtsolution',['testid'=>$testid,'paperid'=>$paperid])}}">
                        <i class="fa fa-close"></i>
                     </a>
                     @endif
                  </div>
               </div>

 <div class="row ">
  
                <div class="col-md-12">
                    @foreach($verbal_qus as $question)
                   <div class="choice">
                        <!-- <p>Q.1 of 22</p> -->
                        <p><b>Question{{$i}}</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                           @if($question->question_type == 'multiple'||$question->question_type == 'MULTI_CHOICE')

                           @if($question->status =='1')
                                    <ol class="list-group choices">
                                       <?php
                                          $ansstr = $question->answer;
                                          $ans = explode(",",$ansstr);
                                         
                                          ?>
                                       @foreach($ans as $value)
                                       <li class="list-group-item">
                                          <span>
                                          {{$value}}
                                          </span>
                                       </li>
                                       
                                       @endforeach
                                    </ol>
                                    @else

                                    <ol class="list-group choices">
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option1) ?></span></li>

                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option2) ?></span></li>
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option3) ?></span></li>
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option4) ?></span></li>
                                       @if($question->option5)
                                       <li class="list-group-item"><span><?= htmlspecialchars_decode($question->option5) ?></span></li>
                                       @endif
                                    </ol>
                           @endif
                           @endif
                    </div>
                    <?php $i++;?>
                    @endforeach
                </div>
            </div>
         </div>
         </div>
         </div>
         
                <!--endquestion-->
                

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

            // var version = navigator.appVersion;
            //       function showKeyCode(e) {
            //         //  console.log(e);
            //           var keycode = (window.event) ? event.keyCode : e.keyCode;
            //           if ((version.indexOf('MSIE') != -1)) {
            //               if (keycode == 116) {
            //                   event.keyCode = 0;
            //                   event.returnValue = false;
            //                   return false;
            //               }
            //           }
            //           else {
            //               if (keycode == 116) {
            //                   return false;
            //               }    
            //           }
            //       }
          // $(window).ready(function(event) {
          //     console.log(event.keyCode);
          //     if (event.keyCode == undefined) {
          //     return false;
          //     }
              
          // })
                  // $(document).ready(function() {
                  //      $(window).on('focus', function(event) {
                  //         event.preventDefault();
                  //         // Your custom code to handle the address bar click
                  //         alert("Address bar click prevented");
                  //     });
                  // });
                 
                  // $(document).ready(function() {
                  //     return false;
                  //     alert("okk");
                      
                  // })
                  
          // $(window).mousedown(function(e){
          //   e.preventDefault();
          //   $(this).blur();
          //   return false;
          // });
          // $(window).on('focus', function(e) { 
          //     e.preventDefault();
          //     $(this).blur();
          // }
          
          //  $(window).bind("keyup keypress", function(e) {
          //   var code = e.keyCode || e.which; 
          //   if (code  == 13) {    
          //       if($(this).val()==''){
          //           e.preventDefault();
          //           return false;
          //       }
          //   }
          // });
                  
                  //function openSecuredWindow() {
                  //  $(document).ready(function() {
                  //      window.open("https://inmortaltechnologies.com/RootEducation/student/start-quize/1/34", "", "width=" + window.innerWidth +",height=" + window.innerHeight);
                  //  });
          //}
          
          // $(function () {
          // $(window).keydown(function (event) {
          // if (event.keyCode == 13) {
          // event.preventDefault();
          // return false;
          // }
          // });
          // });
          
          
          $(window).on('keydown',function(event)
               {
               //  console.log(event);
                 if(event.keyCode == 116){
                     return false;
                       //event.preventDefault();
                 }
                 if(event.keyCode == 17){
                    return false; 
                 }else if(event.keyCode == 16){
                     return false;
                 }else if(event.keyCode == 82){
                     return false;
                 }
               // //   else if(event.keyCode == 116){
               // //      return false; 
               // //   }
               if(event.keyCode==123)
               {
                
                   return false;
               }
               else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
               {
                  
                   return false;  //Prevent from ctrl+shift+i
               }
               else if(event.ctrlKey && event.keyCode==73)
               {
                  // alert('Entered ctrl+shift+i')
                   return false;  //Prevent from ctrl+shift+i
               }
          });
           $(document).on("contextmenu",function(e)
           {
           return false;
          });
          
          </script>
          

@endsection


