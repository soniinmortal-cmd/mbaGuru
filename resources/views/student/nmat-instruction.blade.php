<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
</head>
<style>
.header-content {
            background-color: #006DAA;
            height: 10vh;
            width: full;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }
        
@media (max-width:550px) {
            .header-content {
                display: block;
                padding: 1rem 2rem;
                height: auto;
            }
        }
</style>
   <body style="margin: 0%; padding: 0%;">
    <?php
        $id =request()->id;
        $ins = DB::table('instruction')->where('test_id',$id)->orderBy('id', 'DESC')->first();
        $test = DB::table('tests')->where('id',$id)->orderBy('id', 'DESC')->first(); 
    ?>
    <div>
        <div class="header-content">
            <h3 style="color: white; position:  relative; margin-left:1rem;  ">{{$test->test}}</h3>
            <span style="position: relative; color: white;  margin-bottom: 10px; ">
            <h4 style="margin-top: 18px; font-size:1.4rem;">ðŸ•’Time Left:<span class="mys countdown" data-id="{{$id}}" style="margin-right:10px;"></span>Instructions </h4></span>
        </div>
        <div style="background-color:white; height: 80vh; width: full;">
            <div class="mainins prepage" style="">
                @if(!empty($ins))
                    <?= htmlspecialchars_decode($ins->instruction) ?>
                @else   
            <div style="margin:1rem;" >

                <div > 
                    <h5 style="color:blue; font-weight:bold;">General Instructions</h5>
                    <div style=" font-size:1.2rem; ">  
                    <p>  1. The clock has been set on the server and countdown timer at top right corner of your screen will display the remaining time for you to complete the exam. When the clock runs out the exams ends by default- you are not required to end or submit your exam</p>
                    <p>    2. The questions palette at the right of screen shows one of the following status of each of the questions numbered</p>
                    <p style=" display: flex; align-items: center;"> 
                    <span style="height: 25px; width: 25px; display: flex; border-radius:50%; background-color:#EEEEEE; color:black;  justify-content: center; align-items: center;
                    ">15</span><span style="margin-left:1rem;">You have <b>not visited</b> the question yet</span>
                    </p>
                    <p style=" display: flex; align-items: center;"> 
                    <span style=" height: 25px; width: 25px;  display: flex; border-radius:50%; background-color:#C64225 ; color:white;  justify-content: center; align-items: center;
                    ">15</span><span style="margin-left:1rem;">You have <b>not visited</b> the question </span>
                    </p>
                    <p style=" display: flex; align-items: center;"> 
                    <span style=" height: 25px; width: 25px;  display: flex; border-radius:50%; background-color:#7DCB3E; color:white;  justify-content: center; align-items: center;
                    ">15</span><span style="margin-left:1rem;">You have <b>answered</b> the question  </span>
                    </p>
                    <p style=" display: flex; align-items: center;"> 
                    <span style=" height: 25px; width: 25px;  display: flex; border-radius:50%; background-color:#8251A0; color:white;  justify-content: center; align-items: center;
                    ">15</span><span style="margin-left:1rem;">You have <b>NOT answered</b> the question but have <b>marked the question for review</b></span>
                    </p>
                    <p style=" display: flex; align-items: center;"> 
                    <span style=" height: 25px; width: 25px;  display: flex; border-radius:50%; background-color:#8251A0; color:white;  justify-content: center; align-items: center;
                    ">15</span><span style="margin-left:1rem;">You have <b>answered</b> the question but marked it for review</span>
                    </p>
                 <p>   The Marked for Review status simply acts as a reminder that you have set to look at the question again. If an answer is selected for a question that is Marked for Review, the answer will be considered in the final evaluation</p>
                </div>
                </div>
                <div style=" font-size:1.2rem; " >
                    <h5 style="color:blue; font-weight:bold; ">Navigation to a question</h5>
                    3. To select a question to answer, you can do one of the following:<br><br>
                    <p style="margin-left:3rem;">Click on the <b>question</b> number on the question palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question<br><br>
                    Click on Save and Next to save answer to current question, <b>mark it for review</b>, and to go to the next question in sequence<br><br>
                    Click on Mark for Review and <b>Next to save answer</b> to current question</P>
                    4. You can view the entire paper by clicking on the <b>All Questions</b> button
                </div>
                <div style=" font-size:1.2rem; ">
                    <h5 style="color:blue; font-weight:bold; "> Answering question</h5>
                    5. For multiple choice type question<br><br>
                   <p style="margin-left:3rem;">
                    a. <b>To select your answer</b>, click on one of the option buttons<br><br>
                    b. <b>To change your answer</b>, click the another desired option button<br><br>
                    c. <b>To save your answer</b>, you MUST click on save<br><br>
                    d. <b>To deselect a chosen answer</b>, click on the chosen option again or click on the Clear Response button<br><br>
                    e. <b>To mark a question for review</b> click on Mark for Review & Next If an answer is selected for a question that is Marked for Review, the answer will be considered in the <b>final evaluation</b><br><br></p>
                    6. <b>To change an answer </b>to a question, first select the question and then click on the new answer option followed by a click on the save button<br><br>
                    7. Questions that are saved or marked for review after answering will ONLY be considered for evaluation<br><br>
                    8. If quiz is paused, quiz can be continued from where left off within scheduled time
                </div>
                  <div style=" font-size:1.2rem; " >
                        <h5 style="color:blue; font-weight:bold; "> Navigation through sections</h5>
                        9. Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by clicking on the section name. The section you are currently viewing is highlighted
                        10. After clicking the save button on the last question for a section,you will automatically be taken to the first question of the next section
                        11. You can move the mouse cursor over the section names to view the status of the questions for that section
                        12. You can shuffle between sections and questions anytime during the examination as per your convenience
                        </div>
                        @endif
                    </div>
            </div>   
            <div style="background-color: #006DAA; height:10vh; width: full;" class="container-fluid">
             <a href ="{{route('student.non-disclosure',$id)}}" class="btn btn-primary btn-md submitpaper starttest"style="float:right;margin:10px 10px 0 0;">NEXT</a>
        </div>
        </div>

            <?php
                $userid =session()->get('id');
                $paperid = rand(10,100);
            ?>
        </div>
        <div>
           
        </div>
    </div>
    <script type="text/javascript" src="{{asset('assets/admin/js/nmat.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".mynewcheck").click(function(){
                var mynewcheck = $(this).is(':checked');
                $(".mynewcheck1").click(function(){
                    var mynewcheck1 = $(this).is(':checked');
                    if((mynewcheck == true) && (mynewcheck1)){
                        $('.myCheckBox').removeAttr('disabled');
                    }else{
                        $('.myCheckBox').attr('disabled');
                    }
                }) 
            })
            $(".mynewcheck1").click(function(){
                var mynewcheck1 = $(this).is(':checked');
                $(".mynewcheck").click(function(){
                    var mynewcheck = $(this).is(':checked');
                    if((mynewcheck1 == true) && (mynewcheck)){
                        $('.myCheckBox').removeAttr('disabled');
                    }else{
                        $('.myCheckBox').attr('disabled');
                    }
                }) 
            })
        })
    </script>
<script>
//newtime
    // $(document).ready(function(event) {
    //     var datatime = $('.countdown').attr('data-time'); 
    //     var id = $('.countdown').attr('data-id'); 
    //     //var timer2 = datatime+":0";
    //     var timer2 = "02:00";
    //     var interval = setInterval(function() {
    //     var timer = timer2.split(':');
    //     //by parsing integer, I avoid all extra string processing
    //     var minutes = parseInt(timer[0], 10);
    //     var seconds = parseInt(timer[1], 10);
    //   --seconds;
    //   minutes = (seconds < 0) ? --minutes : minutes;
    //     if (minutes < 0) clearInterval(interval);
    //         if(minutes == 0 && seconds ==0){
    //             var url = "{{ route('student.non-disclosure', [':id']) }}";
    //             url = url.replace(':id', id);
    //             window.location.href=url;

    //         }
    //   seconds = (seconds < 0) ? 59 : seconds;
    //   seconds = (seconds < 10) ? '0' + seconds : seconds;
    //   //minutes = (minutes < 10) ?  minutes : minutes;
    
    //   if(minutes == -1 && seconds ==59){
    //     $('.countdown').html('0:00'); 
    //     // $('.countdown1').html(minutes + ':' + seconds); 
    //   }else{
    //      $('.countdown').html(minutes + ':' + seconds);
    //   }
    //     if(minutes > 0 && seconds <=59){
    //         document.onkeydown = function (e) {
    //         return false;
    //         }
    //         if(minutes > 0 || seconds <=59){
    //           window.location.reload();
    //              window.stop();
                    
    //         }
    //     }
    //     timer2 = minutes + ':' + seconds;
    //     }, 1000);

    // });
    
    $(document).ready(function() {
    let datatime = $('.countdown').attr('data-time'); 
    let id = $('.countdown').attr('data-id'); 

    // Default timer (if data-time not set)
    let timer2 = datatime ? datatime : "02:00"; 

    // Disable keyboard during countdown
    document.onkeydown = function(e) {
        e.preventDefault();
        return false;
    };

    let interval = setInterval(function() {
        let timer = timer2.split(':');
        let minutes = parseInt(timer[0], 10);
        let seconds = parseInt(timer[1], 10);

        seconds--;
        if (seconds < 0) {
            minutes--;
            seconds = 59;
        }

        if (minutes < 0) {
            clearInterval(interval);
            return;
        }

        // Format display
        let display = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
        $('.countdown').text(display);

        // When time’s up
        if (minutes === 0 && seconds === 0) {
            clearInterval(interval);
            let url = "{{ route('student.non-disclosure', [':id']) }}";
            url = url.replace(':id', id);
            window.location.href = url;
        }

        // Update timer for next iteration
        timer2 = minutes + ':' + seconds;

    }, 1000);
});
//endnewtime
 //startrightclick
//  $(window).on('keydown',function(event)
//      {
//        if(event.keyCode == 116){
//            return false;
//        }
//        if(event.keyCode == 17){
//           return false; 
//        }else if(event.keyCode == 16){
//            return false;
//        }else if(event.keyCode == 82){
//            return false;
//        }
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
//     });
//     $(document).on("contextmenu",function(e)
//     {
//     return false;
//     });

    //endrightclick

</script>


</body>
</html>