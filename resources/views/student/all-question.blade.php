@extends('student_template')
@section('css')
@endsection
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="col-md-12">
    <div class="container-fluid all-question">
        <div class="row" style="border-bottom:1px solid whitesmoke">
            <div class="col-md-1" style="border-right:2px solid whitesmoke; float:left">
                <button class="btn btn-default iconclose" data-toggle="modal" data-target="#exit"><i class="fa fa-close"></i></button>
            </div>
            <div class="col-md-6">
                <p style=" PADDING-TOP:5PX;">{{$test->test}}{{$test->testincid}}</p>
            </div>
            <div class="col-md-3" STYLE="border-right:2px solid whitesmoke;">
                <h6 style="margin-left:45%; PADDING-TOP:5PX;">Time : <span class="countdown" data-time="1">0:43</span></h6>
            </div>
            <div class="col-md-2">
                <h6 style=" PADDING-TOP:4PX;">MBA Guru</h6>
            </div>
        </div> 
        <div class="">
        <!--startverbal-->
        @if($verbal_qus)
        <div class ="sectionwise">  
            <div class="row" style="border-bottom:1px solid lightgrey; height:50px;">
                <div class="col-md-6">
                    <h6 style="padding-top:10px;">Verbal And Reading Comprehensive</h6>
                </div>
                <!-- <div class="col-md-6">
                    <button class="btn btn-default" style="float:right; padding-top:10px;">GO BACK</button>
                </div> -->
            </div>   
            <div class="row">
                <div class="col-md-12">
                    @foreach($verbal_qus as $question)
                    <div class="choice">
                        <p>Q.1 of 22</p>
                        <p><b>Question</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> 
        @endif 
        <!--endverbal-->
        <!--startdata-->
        @if($data_qus)
        <div class ="sectionwise">  
            <div class="row" style="border-bottom:1px solid lightgrey; height:50px;">
                <div class="col-md-6">
                    <h6 style="padding-top:10px;">DATA INTERPRETATION AND LOGICAL REASONING</h6>
                </div>
                <!-- <div class="col-md-6">
                    <button class="btn btn-default" style="float:right; padding-top:10px;">GO BACK</button>
                </div> -->
            </div>   
            <div class="row">
                <div class="col-md-12">
                    @foreach($data_qus as $question)
                    <div class="choice">
                        <p>Q.1 of 22</p>
                        <p><b>Question</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                    </div>
                    @endforeach
                   
                </div>
            </div>
        </div> 
        @endif
        <!--enddata-->
        <!--startqt-->
         @if($qt_qus)
        <div class ="sectionwise">  
            <div class="row" style="border-bottom:1px solid lightgrey; height:50px;">
                <div class="col-md-6">
                    <h6 style="padding-top:10px;">QUANTITATIVE ABILITY</h6>
                </div>
                <!-- <div class="col-md-6">
                    <button class="btn btn-default" style="float:right; padding-top:10px;">GO BACK</button>
                </div> -->
            </div>   
            <div class="row">
                <div class="col-md-12">
                    @foreach($qt_qus as $question)
                    <div class="choice">
                        <p>Q.1 of 22</p>
                        <p><b>Question</b></p>
                        <p><?= htmlspecialchars_decode($question->question) ?></p>
                    </div>
                    @endforeach
                   
                </div>
            </div>
        </div> 
        @endif
        <!--endqt-->
        </div>
    </div>
</div>
<script>
     var sec = 10;
    var time = setInterval(myTimer, 1000);
    function myTimer() {
        document.getElementById('timer').innerHTML = sec + "sec left";
        sec--;
        if (sec == -1) {
            clearInterval(time);
            // $('#myModal').modal('show');
        }
    }
    var msec=sec*1000;
    $(window).load(function(){
   setTimeout(function(){
       $('#myModal').modal({
        backdrop: 'static', 
        keyboard: false
    },'show');
   }, msec);
});
</script>
@endsection
@section('css') 
@endsection