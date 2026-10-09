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
    min-height:80vh;
    height:auto;
}
#firstColumn{
    max-height:70vh;
  height:auto;
  width: 52%;
  float:left;
   overflow-y:scroll;
   margin-top:10px;
   padding: 4px;
}

#secondColumn{
    height:auto;
    width: 45%;
    margin-left:53%;
    margin-top:10px;
    padding: 4px;
    overflow-y:scroll;
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
            <h4 style="margin-top: 18px; font-size:1.4rem;">ðŸ•’Time Left:<span class="mys countdown"  data-id="{{$id}}"style="margin-right:10px;"></span>Instructions </h4></span>
        </div>
        <div style="height:auto; width:full;" class="containerMine">

           
            <div style="margin:1rem;">
              
                <h3 style="text-color:#5959;text-align:center; font-size:1.6rem; font-weight:bold;">NON DISCLOSURE AGREEMENT AND GENERAL TERM OF USE</h3>
                <p style=" font-size:1.2rem; "> 
                    <span style="color:rgb(255, 0, 0);text-align:center;">You have 2 minutes to accept the NON-Disclosure Agreement. If you do
                        not accept within 2 minutes, the exam will terminate and you will not able to forfeit your exam
                        fee.
                </span>
                </p>
                <p style=" font-size:1.2rem; ">Dear Candidate:</p>
                <p style=" font-size:1.2rem; ">This exam is confidential. Graduate Management Global Connection (India) Private Limited (GMGC), a
                subsidiary of Graduate Management Administration Council (GMAC) and owner of the NMAT by GMAC exam, owns
                the rights to the intellectual property, copyright and trademarks used in providing NMAT by GMAC exam, and
                these are protected by law. The exam is made available to you as a candidate, solely for the purpose of
                your assessment. You are expressly prohibited from disclosing, publishing, reproducing, or transmitting
                this exam, in whole or in part, in any form or by any means including visual, aural, verbal, written,
                electronic or mechanical, for any purpose. The examination questions and answers are not released or avail
                for viewing due to the secure nature of the examination and the process adopted by GMGC in establishing
                scoring.</p>
                <p style=" font-size:1.2rem; "> In order to proceed the exam you&nbsp;<strong>MUST</strong>&nbsp;Accept the terms of this Non-Disclosure
                Agreement. Please note exam fees for the candidate-terminated exams are not refundable. To proceed and
                accept these terms, Select 'Yes, I accept' below.</p>
                <p style=" font-size:1.2rem; ">If you require any further information about the exams please visit our website at
                www.pearsonvueindia.com/nmatbygmac.</p><br><br>
                <div class="css-1dj4wno" style=" font-size:1.2rem; ">
                    <div class="css-1dj4wno" >
                    <label class="css-knfhfe" style="display:flex;">
                        <input  type="checkbox" class="css-bwu766 mynewcheck">
                    <div class="css-sg8o3g" >
                        <div style=" font-size:1.2rem; margin-top:6px; margin-left:5px; " class="css-bwu766">Yes, I have read the End User License Agreement located at <a href="http://www.nmat.org.in/nmat-prep-by-gmac-eula/" target="_blank">&nbsp; End User License Agreement &nbsp; </a>and agree to terms.</div></div></label></div><br>
                        <div class="css-offwra">
                            <label class="css-knfhfe" style="display:flex;">
                                <input type="checkbox" class="css-bwu766 mynewcheck1" >
                                <div style=" font-size:1.2rem; margin-top:16px; margin-left:5px; "  class="css-bwu766 "> Yes, I acknowledge that I have read the NMAT By GMAC Privacy Policy and I agree to the use and disclosure of my personal information to GMAC and its service providers and I agree to be bound by the NMAT By GMAC privacy policy located at
                                    <a href="https://www.nmat.org.in/privacy-policy/" target="_blank">&nbsp; https://www.nmat.org.in/privacy-policy/  &nbsp;</a> 
                                    and any updates made to the privacy policy. I also agree that my information including my test scores will be sent to any score recipient that I designate.
                                </div>
                            </label>
                        </div>
                    </div><br>
                    <div class="css-1dj4wno" style=" font-size:1.2rem; ">
                        <div class="css-vurnku">
                            <label class="css-6iejk3" style="display:flex;">
                                <input type="radio" name="acknowledge"  value="yes" class="myCheckBox" disabled>
                                <div style=" font-size:1.2rem; margin-top:4px; margin-left:5px; "  class="css-sg8o3g">
                                    <div class="css-16vu25q"> &nbsp; YES I ACCEPT</div>
                                </div>
                            </label>
                        </div><br>
                        <div class="css-vurnku" style=" font-size:1.2rem; ">
                            <label class="css-18zt75f" style="display:flex;">
                                <input type="radio" name="acknowledge" value="no" class="myCheckBox1">
                                <div style=" font-size:1.2rem; margin-top:4px; margin-left:5px; "  class="css-sg8o3g">
                                    <div class="css-16vu25q"> &nbsp; NO, I DO NOT ACCEPT</div>
                                </div>
                            </label>
                        </div>
                    </div><br>
               
            </div>
        </div>
        <div>
         
            <div style="background-color: #006DAA; height:10vh;  width: full;">
              
                <a href ="{{route('student.nmat-section',$id)}}" class="btn btn-primary btn-md pre myButton" style="float:right; margin:10px 10px 0 0;" disabled>NEXT</a>
           </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('assets/admin/js/nmat.js')}}"></script>
    <script>
       
        
//         $(document).ready(function() {
//     function toggleCheckboxState() {
//         var mynewcheck = $(".mynewcheck").is(':checked');
//         var mynewcheck1 = $(".mynewcheck1").is(':checked');
        
//         if(mynewcheck && mynewcheck1) {
//             $('.myCheckBox').removeAttr('disabled');
//         } else {
//             $('.myCheckBox').attr('disabled', 'disabled');
//         }
//     }

//     // Attach change event listeners to both checkboxes
//     $(".mynewcheck, .mynewcheck1").change(function() {
//         toggleCheckboxState();
//     });

//     // Initial call in case checkboxes are pre-checked
//     toggleCheckboxState();
// });


$(document).ready(function() {
    function toggleCheckboxState() {
        var mynewcheck = $(".mynewcheck").is(':checked');
        var mynewcheck1 = $(".mynewcheck1").is(':checked');
        
        if (mynewcheck && mynewcheck1) {
            $('.myCheckBox').removeAttr('disabled');
        } else {
            $('.myCheckBox').attr('disabled', 'disabled').prop('checked', false); 
            $('.myButton').attr('disabled', 'disabled');
           
        }
    }

    // Attach change event listeners to both checkboxes
    $(".mynewcheck, .mynewcheck1").change(function() {
        toggleCheckboxState();
    });

    // Initial call in case checkboxes are pre-checked
    toggleCheckboxState();
});


  $(document).ready(function() {
        $(".myButton").click(function(e) {
            if ($(this).is("[disabled]")) {
                e.preventDefault(); // Prevent the click action
            }
        });
    });

    </script>
<script>
    //newtime correct
        // $(document).ready(function(event) {
        //     var datatime = $('.countdown').attr('data-time'); 
        //      var id = $('.countdown').attr('data-id'); 
        //     //var timer2 = datatime+":0";
        //     var timer2 = "02:00";
        //     var interval = setInterval(function() {
        //     var timer = timer2.split(':');
        //     //by parsing integer, I avoid all extra string processing
        //     var minutes = parseInt(timer[0], 10);
        //     var seconds = parseInt(timer[1], 10);
        // --seconds;
        // minutes = (seconds < 0) ? --minutes : minutes;
        //     if (minutes < 0) clearInterval(interval);
        //         if(minutes == 0 && seconds ==0){
        //             var url = "{{ route('student.nmat-section', [':id']) }}";
        //             url = url.replace(':id', id);
        //             window.location.href=url;
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
        
        
        
        $(document).ready(function () {
    let datatime = $('.countdown').attr('data-time');
    let id = $('.countdown').attr('data-id');
    let timer2 = "02:00"; // or use datatime if dynamic

    let interval = setInterval(function () {
        let timer = timer2.split(':');
        let minutes = parseInt(timer[0], 10);
        let seconds = parseInt(timer[1], 10);

        seconds--;
        if (seconds < 0) {
            seconds = 59;
            minutes--;
        }

        if (minutes < 0) {
            clearInterval(interval);
            minutes = 0;
            seconds = 0;
        }

        // When countdown ends → redirect
        if (minutes === 0 && seconds === 0) {
            clearInterval(interval);
            let url = "{{ route('student.nmat-section', [':id']) }}";
            url = url.replace(':id', id);
            window.location.href = url;
            return;
        }

        // Format
        let displaySeconds = seconds < 10 ? '0' + seconds : seconds;
        $('.countdown').text(minutes + ':' + displaySeconds);

        // Disable keyboard (once)
        document.onkeydown = function (e) {
            return false;
        };

        timer2 = minutes + ':' + seconds;
    }, 1000);
});
    //endnewtime

     //startrightclick
    //  $(window).on('keydown',function(event)
    //  {
    //    if(event.keyCode == 116){
    //        return false;
    //    }
    //    if(event.keyCode == 17){
    //       return false; 
    //    }else if(event.keyCode == 16){
    //        return false;
    //    }else if(event.keyCode == 82){
    //        return false;
    //    }
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
</body>
</html>