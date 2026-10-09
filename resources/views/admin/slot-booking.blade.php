@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9 mt-5">
    <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
      <h4 class="fw-bold text-capitalize">Slot Booking</h4>

    </div>
   	@if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
   	@endif
 	<a href="{{ route('admin.show-seat') }}" class="btn btn-danger" style="float:right;">Seats List</a>
    <div class="col-md-12">
    	<div class="form" >
    		<?php
    		$testid = request()->id;
    		?>
    		<form action="{{route('admin.save-seat')}}" method="post" enctype="multipart/form-data">
      			@csrf
      		<!-- 	<input type="hidden" class="course_id" name="course_id" value=""data-course="" >
      			<input type="hidden" class="test_id" name="test_id" value="" data-test="">
      			<input type="hidden"  name="newtest_id" value="{{$testid}}"> -->


      			<div class="getdata row">
			        <div class="form-group col-lg-6 col-md-6 col-sm-12">
			          <label>Course Name:</label>
			          <select class="form-control form-control-lg" name ="course_id" id="course-dropdown">
			          	<option>Select Course</option>
			          	@foreach($courses as $course)
				        <option value="{{$course->id}}">{{$course->title}}</option>
				      
				        @endforeach
				      </select>
			        </div>
			        
			        <div class="form-group col-lg-6 col-md-6 col-sm-12">
			          <label>Test Name:</label>
			          <select class="form-control form-control-lg" name ="test_id" id="test-dropdown">
				      </select>
			        </div>
      		<!-- <div class="form-group"> -->
			        <div class="form-group col-lg-6 col-md-6 col-sm-12">
			          <label>Center Name:</label>
			          <select class="form-control form-control-lg" name ="center_id" id="center">
			          	<option>Select Center</option>
			          	@foreach($centers as $center)
				        <option value="{{$center->id}}">{{$center->centername}}</option>
				        @endforeach
				      </select>
	        		</div>
	        
		    		<div class="form-group col-lg-6 col-md-6 col-sm-12">
	               		<label>Number Of Seats:</label>
		             	<input type="text" name="seats" class="form-control seat" placeholder="No Of Seats" value="" >
		            </div>
		            
		            <div class="form-group col-lg-6 col-md-6 col-sm-12">
	               		<label>From Date:</label>
		             	<input type="date" name="from_date" class="form-control from_date"  placeholder="Enter Form Date"value="">
		            </div>
	            
	            <div class="form-group col-lg-6 col-md-6 col-sm-12">
               		<label>To Date:</label>
	             	<input type="date" name="to_date" class="form-control to_date m-input" placeholder="Enter To Date"value="" >
	            </div>
	            
	            <div id="row">
		            <div class="form-group col-lg-5 col-md-5 col-sm-12 " style="margin-left:-5px!important;">
	               		<label>From Time:</label>
		             	<input type="text" name="from_time[]" class="form-control from_time" value="">
		            </div>
		             
		            <div class="form-group col-lg-5 col-md-5 col-sm-12" >
	               		<label>To Time:</label>
		             	<input type="text" name="to_time[]" class="form-control to_time" value="">
		            </div>
		            <br>
	              	<a class="btn btn-danger mt-2 col-lg-1 col-md-2 col-sm-12" id="DeleteRow" type="button"><i class="fa fa-times" aria-hidden="true"></i></a>
	            </div>
                  <div id="newinput"></div>
                  <a id="rowAdderr" type="button" class="btn btn-primary ml-4 my-2 col-lg-1 col-md-2 col-sm-12 d-flex ">
                     <i class="fa fa-plus" aria-hidden="true"></i>
                  </a>
                  
 
            </div>

	          <button type="submit" class="btn btn-primary col-lg-1  d-flex">Submit</button>
	        </form>
    	</div>
    </div>
</div>


@endsection
@section('script')
<script>
$(document).ready(function () {
    $('#course-dropdown').on('change', function () {
    	$('.seats').css('display','none');
    	//$('.form').css('display','none');
        var idCourse = this.value;
      	$('.course_id').val(idCourse);

        $("#test-dropdown").html('');
        $.ajaxSetup({
		      headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		      }
		});
        $.ajax({
            url: "{{route('admin.fetch-test')}}",
            type: "POST",
            data: {
                course_id: idCourse,
            },
            dataType: 'json',
            success: function (result) {
            	
                $('#test-dropdown').html('<option value="">-- Select Test --</option>');
                $.each(result.test, function (key, value) {
                    $("#test-dropdown").append('<option value="' + value
                        .id + '">' + value.test + '</option>');
                });
              
            }
        });
    });

    
    $('#test-dropdown').on('change', function () {
		var idTest= this.value;
		if(idTest){
		// $('.form').css('display','block');
		 $('.test_id').val(idTest);
		 var test_id = $('.test_id').val();
		 var course_id = $('.course_id').val();
		  $.ajaxSetup({
		      headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		      }
		});
        $.ajax({
            url: "{{route('admin.fetch-seat')}}",
            type: "POST",
            data: {
                test_id: test_id,
                course_id: course_id
            },
            dataType: 'json',
            success: function (result) {
                $('.seat').val(result.seats);
                $('.from_date').val(result.from_date);
                $('.to_date').val(result.to_date);

              
            }
        });
		}else{
		 	$('.seats').css('display','none');
		 	$('.form').css('display','none');
		}
    });

    // $('.seats').on('click', function () {
    // 	$('.seats').css('display','none');
    // 	$('.form').css('display','block');
    // });
});



 $("#rowAdderr").click(function () {   
 	newRowAdd ='<div id="row"><div class="form-group col-lg-5 col-md-5 col-sm-12"><label>From Time:</label>'+
		'<input type="text" name="from_time[]" class="form-control from_time" value=""></div>'+
		'<div class="form-group col-lg-5 col-md-5 col-sm-12"><label>To Time:</label>'+
		'<input type="text" name="to_time[]" class="form-control to_time" value=""></div>'+
	    '<a class="btn btn-danger col-lg-1 col-md-1 col-sm-12" id="DeleteRow" style="margin-top:25px;" type="button">'+
	    '<i class="fa fa-times" aria-hidden="true"></i></a></div>';
	     $('#newinput').append(newRowAdd);
})
 $("body").on("click", "#DeleteRow", function () {
      $(this).parents("#row").remove();
   })
</script>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

