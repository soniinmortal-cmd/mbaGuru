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
        $paperid =request()->paperid;
        $nextid =request()->nextid;
        $sid =request()->sid;
    ?>
    <div>
        <div class="header-content">
            <h3 style="color: white; position:  relative; ">{{$test->test}}</h3>
            <span style="position: relative; color: white;  margin-bottom: 20px; ">
            <h4 style="margin-right: 10px;">🕒Time Left:<span class="mys countdown" data-id="{{$id}}"></span></h4></span>
        </div>
        <div style="background-color:white; height: 80vh; width: full;">
            <center>
                <h3 style="margin-bottom:4px">{{$nextid}}</h3>
                <br/>
                <h4 style="margin-bottom:4px">There are {{count($qs_ques)}} exams questions in this section</h4>
                @if($nextid == 'Quantitative Skills')
                <h4 style="margin-bottom:4px">You have {{$section_time->qs_time}} minutes to complete this section.</h4>
                @elseif($nextid == 'Language Skills')
                <h4 style="margin-bottom:4px">You have {{$section_time->language_time}} minutes to complete this section.</h4>
                @else
                <h4 style="margin-bottom:4px">You have {{$section_time->logical_time}} minutes to complete this section.</h4>
                @endif
                <h4 style="margin-bottom:4px">click 'next' to begin.</h4>
                

            </center>
            
        </div>
        <div style="background-color: #006DAA; height:8vh;  width: full;">
            <a class="btn btn next-quiz" style="background-color:#006DAA; color:white;margin:10px 10px 0 0;float: right;" data-testid ="{{$id}}" data-sid ="{{$sid}}" 
                data-paperid ="{{$paperid}}"data-nextid ="{{$nextid}}">Next</a>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('assets/admin/js/nmat.js')}}"></script>
<script>
    //startrightclick
// $(window).on('keydown',function(event){
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
// });
// $(document).on("contextmenu",function(e)
// {
// return false;
// });

    //endrightclick
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
//endnewtime


//newtimer
$(document).ready(function(event) {
    var datatime = $('.countdown').attr('data-time'); 
    var id = $('.countdown').attr('data-id'); 
    var timer2 = "02:00";
    
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        
        if (minutes < 0) {
            clearInterval(interval);
        }
        
        // If the time has reached 0:00, redirect to the desired page
        if (minutes == 0 && seconds == 0) {
            clearInterval(interval);
            var url = "{{ route('student.non-disclosure', [':id']) }}";
            url = url.replace(':id', id);
            window.location.href = url;
        }
        
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
    
        if (minutes == -1 && seconds == 59) {
            $('.countdown').html('0:00');
        } else {
            $('.countdown').html(minutes + ':' + seconds);
        }
        
        if (minutes > 0 && seconds <= 59) {
            document.onkeydown = function (e) {
                return false; // Disable keydown when timer is running
            }
        }
        
        // Update the timer for the next interval
        timer2 = minutes + ':' + seconds;
        
    }, 1000); // 1 second interval

});

//endnewtimer

</script>
<script>
    $('.next-quiz').click(function (){
        var test_id = $(this).attr('data-testid');
        var paper_id = $(this).attr('data-paperid');
        var sid = $(this).attr('data-sid');
        var nextid  = $(this).attr('data-nextid');
        var url = "{{ route('student.nmat-next-quiz', [':id',':paperid',':sid',':nextid']) }}";
                    url = url.replace(':id', test_id);
                    url = url.replace(':paperid', paper_id);
                    url = url.replace(':sid', sid);
                    url = url.replace(':nextid', nextid);
                    window.location.href=url;

    })
</script>
</body>
</html>