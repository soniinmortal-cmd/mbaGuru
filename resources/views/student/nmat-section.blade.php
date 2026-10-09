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
        <style>
    
    .scroll{
        background-color:white;
        height:auto;
    }
.containerMine{
    background-color:white;
    min-height:81vh;
    overflow-x:hidden;
}

ol li{
  list-style-type: none;
}
 
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
</head>
<body style="margin: 0%; padding: 0%;">
    <?php
        $id =request()->id;
        $ins = DB::table('instruction')->where('test_id',$id)->orderBy('id', 'DESC')->first();
        $test = DB::table('tests')->where('id',$id)->orderBy('id', 'DESC')->first(); 
       
    ?>
    <div>
        <div class="header-content">
            <h3 style="color: white; width:20%;">{{$test->test}}</h3>
            <span style=" color: white; margin-bottom: 20px; ">
            <h4 style="margin-top: 18px; font-size:1.4rem;">🕒Time Left:<span class="mys countdown" data-set="{{$id}}" style="margin-right:10px; font-weight:bold;"></span>
            <div>Section Ordering</div>
            </h4></span>
        </div>
        <div style="background-color:white; height: auto; width: full;" class="containerMine">
            <div class="" style="margin:1rem;"> 
              
                    <h3 style="text-color:#5959;text-align:center; font-size:2.9rem; font-weight:bold;">Ordering_intro</h3><br><br>
                    <p class="my-5">Select the order in which the exam sections are to be administered.</p><br>
                    <span class="my-5 "style="color:red;">NOTE: You have 3 minutes to make your selection. If you do not make your selection within 3 minutes, the first option listed will be selected and you will view the exam in the following order: Quantitative Skills, Language Skills, Logical Reasoning.</span>
                    <br><br> 
                    <p class="my-5">Once you select your section order, you must view ALL questions in each section, in the order you have selected, before moving on to the next section. You will NOT be able to return to this screen.</p><br>
                    
                    <!-- <div class="all-section">
                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering" value="nmat-section1">
                                        <div class="">
                                            <div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering" value="nmat-section2">
                                        <div class="">
                                            <div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div>
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering"value="nmat-section3">
                                        <div class="">
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering" value="nmat-section4">
                                        <div class="">
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div>
                                            <div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering" value="nmat-section5">
                                        <div class="">
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div>
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4 ">
                                <label class="">
                                    <div class="">
                                        <input type="radio" name="section_ordering" value="nmat-section6">
                                        <div class="">
                                            <div class="">
                                                <div class="">Logical Reasoning</div>
                                            </div><div class="">
                                                <div class="">Quantitative Skills</div>
                                            </div>
                                            <div class="">
                                                <div class="">Language Skills</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>  -->
                    <div class="all-section">
                        <div class="row">
    <!-- Section 1: Quantitative Skills, Language Skills, Logical Reasoning -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section1" data-id="{{$id}}">
                <div style="margin-left:3rem;">
                    <div>Quantitative Skills</div>
                    <div>Language Skills</div>
                    <div>Logical Reasoning</div>
                </div>
            </div>
        </label>
    </div>
    
    <!-- Section 2: Quantitative Skills, Language Skills, Logical Reasoning (same order as Section 1) -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section2" data-id="{{$id}}">
                <div style="margin-left:3rem;">
                    <div>Quantitative Skills</div>
                    <div>Logical Reasoning</div>
                    <div>Language Skills</div> 
                </div>
            </div>
        </label>
    </div>

    <!-- Section 3: Language Skills, Quantitative Skills, Logical Reasoning (different order) -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section3" data-id="{{$id}}">
                <div style="margin-left:3rem;">
                    <div>Language Skills</div>
                    <div>Quantitative Skills</div>
                    <div>Logical Reasoning</div>
                </div>
            </div>
        </label>
    </div>
</div>

                   <div class="row" style="margin-top:50px;">
    <!-- Section 4: Language Skills, Logical Reasoning, Quantitative Skills -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section4" data-id="{{$id}}">
                <div style="margin-left: 3rem;">
                    <div>Language Skills</div>
                    <div>Logical Reasoning</div>
                    <div>Quantitative Skills</div>
                </div>
            </div>
        </label>
    </div>
    <br>

    <!-- Section 5: Logical Reasoning, Language Skills, Quantitative Skills -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section5" data-id="{{$id}}">
                <div style="margin-left: 3rem;">
                    <div>Logical Reasoning</div>
                    <div>Language Skills</div>
                    <div>Quantitative Skills</div>
                </div>
            </div>
        </label>
    </div>
    <br>

    <!-- Section 6: Logical Reasoning, Quantitative Skills, Language Skills -->
    <div class="col-md-4" style="display: flex;">
        <label>
            <div style="display:flex;">
                <input type="radio" name="section_ordering" value="nmat-section6" data-id="{{$id}}">
                <div style="margin-left: 3rem;">
                    <div>Logical Reasoning</div>
                    <div>Quantitative Skills</div>
                    <div>Language Skills</div>
                </div>
            </div>
        </label>
    </div>
</div>
<br>

        </div>
            
                <?php
                    $userid =session()->get('id');
                    $paperid = rand(10,100);
                ?>
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                <input type="hidden" name="test_id" class="testid" value="{{$id}}">
                <input type="hidden" name="user_id" class="userid" value="{{$userid}}">
                <input type="hidden" name="paper_id" class="paperid" value="{{$paperid}}">
            </div>
        </div>
        <div>
         
            <div style="background-color: #006DAA; height:10vh;  width: full;">
                <!-- <a class="btn btn-primary btn-md nextpage" style="float:right; margin-top:10px;">NEXT</a>
                <a class="btn btn-primary btn-md pre myButton" style="float:right; margin-top:10px;display:none;" disabled>NEXT</a> -->
                <a class="btn btn-primary btn-md starttest" style="float:right; margin:10px 10px 0 0;">NEXT</a>
           </div>
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
        //     var id = $('.countdown').attr('data-set');
        //     //var timer2 = datatime+":0";
        //     var timer2 = "03:00";
        //     var interval = setInterval(function() {
        //     var timer = timer2.split(':');
        //     //by parsing integer, I avoid all extra string processing
        //     var minutes = parseInt(timer[0], 10);
        //     var seconds = parseInt(timer[1], 10);
        //     --seconds;
        //     minutes = (seconds < 0) ? --minutes : minutes;
        //     if (minutes < 0) clearInterval(interval);
        //         if(minutes == 0 && seconds ==0){
        //         var sid = 'nmat-section1';
        //         var paper_id =   Math.floor(Math.random() * 90 + 10)
        //         var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
        //         url = url.replace(':sid', sid);
        //         url = url.replace(':id', id);
        //         url = url.replace(':paperid', paper_id);
        //         window.location.href=url;
        //         }
        // seconds = (seconds < 0) ? 59 : seconds;
        // seconds = (seconds < 10) ? '0' + seconds : seconds;
        // //minutes = (minutes < 10) ?  minutes : minutes;
        
        // if(minutes == -1 && seconds ==59){
        //     $('.countdown').html('0:00'); 
        //     // $('.countdown1').html(minutes + ':' + seconds); 
        // }else{
        //     $('.countdown').html(minutes + ':' + seconds);
        // }
        //     if(minutes > 0 && seconds <=59){
        //         document.onkeydown = function (e) {
        //         return false;
        //         }
        //         if(minutes > 0 || seconds <=59){
        //         window.location.reload();
        //             window.stop();
                        
        //         }
        //     }
        //     timer2 = minutes + ':' + seconds;
        //     }, 1000);

        // });
  ///////start correct timer      
$(document).ready(function() {
    var datatime = $('.countdown').attr('data-time'); 
    var id = $('.countdown').attr('data-set');
    var timer2 = "03:00";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);

        // Decrement seconds and adjust minutes if necessary
        seconds--;
        if (seconds < 0) {
            seconds = 59;
            minutes--;
        }

        // Update the timer display
        $('.countdown').html(minutes + ':' + (seconds < 10 ? '0' + seconds : seconds));

        // Check if the timer has reached 0:00
        if (minutes <= 0 && seconds <= 0) {
            clearInterval(interval);  // Stop the timer
            var sid = 'nmat-section1';
            var paper_id = Math.floor(Math.random() * 90 + 10);
            var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
            url = url.replace(':sid', sid);
            url = url.replace(':id', id);
            url = url.replace(':paperid', paper_id);
            // Redirect to the new page
            window.location.href = url;
        }
        // Update the timer for the next iteration
        timer2 = minutes + ':' + (seconds < 10 ? '0' + seconds : seconds);
    }, 1000);

    // Optional: Disable keyboard actions to prevent cheating (if needed)
    document.onkeydown = function(e) {
        return false;
    };
});
  ///////end correct timer  
    //endnewtime
</script>
<script>
    $(document).ready(function(event) {
        $("input[name='section_ordering']").click(function(){
            var sid = $(this).val();
            var id = $(this).attr('data-id');
            $('.starttest').click(function(){
                var paper_id =   Math.floor(Math.random() * 90 + 10);
                var url = "{{ route('student.nmat-quiz', [':id', ':paperid',':sid']) }}";
                url = url.replace(':sid', sid);
                url = url.replace(':id', id);
                url = url.replace(':paperid', paper_id);
                window.location.href=url;
            })

        })
    
    })
     //startrightclick
    //  $(window).on('keydown',function(event)
    //  {
    //   if(event.keyCode == 116){
    //       return false;
    //   }
    //   if(event.keyCode == 17){
    //       return false; 
    //   }else if(event.keyCode == 16){
    //       return false;
    //   }else if(event.keyCode == 82){
    //       return false;
    //   }
    //  if(event.keyCode==123)
    //  {
    //      return false;
    //  }
    //  else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
    //  {
    //      return false;  //Prevent from ctrl+shift+i
    //  }
    //  else if(event.ctrlKey && event.keyCode==73)
    //  {
    //     // alert('Entered ctrl+shift+i')
    //      return false;  //Prevent from ctrl+shift+i
    //  }
    // });
    // $(document).on("contextmenu",function(e)
    // {
    // return false;
    // });

    //endrightclick

</script>
<script>
$(document).ready(function() {
    $('.starttest').click(function(){
        localStorage.clear();
    });
});
</script>
</body>
</html>