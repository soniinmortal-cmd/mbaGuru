@extends('admin_template')
@section('content')
<style>	
#more-btn
{
    height:35px;
    border-radius:5px;
    background-color: #A83942;
    color:white;
}
.student-form{
	padding: 7px 10px;
}
.student-form h3{ 
	font-size: 26px;
    padding-bottom: 9px;
    font-weight: bold;
    margin-bottom: 14px;
    text-align: center;
    color: #9b010c;
    border-bottom: 1px solid #9b010c;
    text-transform: capitalize;
}
.email-th{
	width: 120px;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9 bg-light py-3  " id="right-menu-bar">
				<div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
					<h5 class="fw-bold">Student Creation</h5>
				
					<div id="right-menubar-top" class="d-flex gap-1 justify-conetent-center align-items-center">
					@if(Session::has('message'))
      					<p class="alert {{ Session::get('alert-class', 'alert-info') }}" id="success-alert">{{ Session::get('message') }}</p>
    				@endif
						<div class="dropdown ">
						     <form action="{{route('admin.import')}}" method="post" enctype="multipart/form-data">
              					@csrf
							<button id="more-btn"  class="btn  dropdown-toggle p-1" type="button"
								data-bs-toggle="dropdown" aria-expanded="false " >
								More
							</button>
							<ul class="dropdown-menu">
							    <a href="{{route('admin.import')}}" style="text-decoration:none">
								<li><button  id="import" name="import" class="dropdown-item" type="button">Import/Export Students</button></li>
								</a>
								<!--<li><button type="submit" id="importhistory" class="dropdown-item" type="button">Export Students</button></li>-->
							</ul>
							</form>
						</div>
						<button id="more-btn" class="btn p-1" type="button" data-toggle="modal"  data-target="#myModal3">
						<span><i class="fa-solid fa-plus" style="font-size: 13px!important"></i></span>
								<span class="" id="add-btn" style="font-size: 13px!important;">ADD</span>
							</button>
						
					</div>
				</div>
                 @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <p>{{ $message }}</p>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endif
				<!--<div id="topbar-bottom-serbar" style="position: relative;"-->
				<!--	class="d-flex justify-conetent-center align-items-center ">-->
				<!--	<span id="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>-->
				<!--	<input class="form-control py-1 border px-2 m-1 " type="text" placeholder="Search By Email"-->
				<!--		id="search-icon-input-2" aria-label="Search" style=" background-color: #F4F4F4;">-->
				<!--	<a href="#" class="btn py-1 px-3 rounded-1" style="background-color:#A839428F ;">-->
				<!--		<div class=" rounded-0 text-white d-flex justify-conetent-between align-items-center gap-2">-->
				<!--			<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>-->
				<!--			<span style="font-size: 13px!important;">Add Filter</span>-->
				<!--		</div>-->
				<!--	</a>-->
				<!--</div>-->
				<div id="moile-contains-filter-sec" class="d-flex m-1 ">
				    	<form action="{{ route('admin.studentcreation') }}" method="GET">
					<div id="mobile-content" class="d-flex justify-content-between align-items-center px-2 py-0">
						    <input class="form-control" name="search" type="text" placeholder="Enter Email"
							id="search-icon-input-2 " aria-label="Search"
							style=" background-color: #F4F4F4;box-shadow: none!important; ">
							
                       
					</div>
					 <button type="submit" class ="btn py-1 px-2 rounded-1 btn-filter">
						<div class=" text-white d-flex justify-content-between align-items-center gap-2">
							<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 16px!important;">Apply Filter</span>
						</div>
						</button>
					 </form>
				</div>
				<a href="{{route('admin.export')}}" class="btn  text-dark rounded-1 mt-3 mb-4 ms-2"
					style="background-color: #F1EEEE;font-size: 13px!important;" >EXPORT</a>
					<div class="table-responsive"> 
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
						 	<th>ID</th>    
							<th>NAME</th>
							<th class="email-th">EMAIL</th>
							<th>PASSWORD</th>
							<th>MOBILE</th>
							<th>DATE OF BIRTH</th>
							<th>ADMISSION</th>
							<th>ADDRESS</th>
							<th>CENTER</th>
						    <th>BATCH CODE</th>
							<th>CAT YEAR</th>
							<th>COLLAGE</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i =1;
					
						?>
					   @foreach($record as $user)
					  <?php
					  /////admission///////////////////////////////
                        $adminssionDate = $user->admissiondate;
                       // $adminssionDate = $user->dateofbirth;
                        if (is_numeric($adminssionDate)) {
                            $adminssionDate = (int)$adminssionDate;
                            $unixTimestampp1 = ($adminssionDate - 25569) * 86400;
                            $adminssDate = date('Y-m-d', $unixTimestampp1);
                        } else {
                            $parsedDate1 = date_create($adminssionDate);
                            if ($parsedDate1) {
                                $adminssDate = $parsedDate1->format('Y-m-d');
                            } else {
                                $adminssDate = null; 
                            }
                        }
                        //////dob////////////////////////////////////
                        $dobDate = $user->dateofbirth;
                        if (is_numeric($dobDate)) {
                            $dobDate = (int)$dobDate;
                            $unixTimestampp = ($dobDate - 25569) * 86400;
                            $dobbDate = date('Y-m-d', $unixTimestampp);
                        } else {
                            $parsedDate = date_create($dobDate);
                            if ($parsedDate) {
                                $dobbDate = $parsedDate->format('Y-m-d');
                            } else {
                                $dobbDate = null; 
                            }
                        }
					  ?>
						<tr>   
              			<td> {{$i++}}</td>
							<td>{{$user->name}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->show_password}}</td>
							<td>{{$user->mobile}}</td>
							<td>{{$dobbDate}}</td>
							<td>{{ $adminssDate }}</td>
						  <td>{{$user->address}}</td>
						   <td>{{$user->centercode}}</td>
						   <td>{{$user->batch_code}}</td>
						    <td>{{$user->catyear}}</td>
						     <td>{{$user->college}}</td>
					    <td>
							<div class="d-flex">
				        <a href="{{route('admin.editstudent',$user->id)}}" class="btn btn btn-primary" style="color:white;margin-right:5px;">Edit</a><br/><br/>

				        <a href="{{route('admin.delete-student',$user->id)}}" onclick="return confirm('Are you sure you want to delete this student?');" class="btn btn btn-danger" style="color:white;margin-right:5px;">Delete</a>
						</div>
							</td>
            </tr>
					@endforeach
					</tbody>
				</table>
</div>

			</div>
			
			<!--Update Form-->
			<div id="update" style="display:none">
			    
		<div class="card mx-auto rounded-2 p-4 " style="width:18rem; border: none; padding:0px;margin-top: 5%;" id="card-style">
		    			<span onclick="$('#addstudentdialogbox').hide();"><i class="fa fa-arrow-left m-3" style="position: absolute; top: 0;left: 0;cursor:pointer;"></i></span>

			    	<div class="card-body pb-0 col-sm-8">
			    <form id="" name="" action="">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="my-3">
					<label for="name" class="text-start fs-6 fw-normal">StudentName </label>
				
				<input type="text" name="name"  class="form-controls" style="background-color: #EFF0F2;">	
				</div>
				<div class="my-3">
				    <label for="email" class="text-start fs-6 fw-normal">Student Email </label>
				    <input type="text" name="email"  class="form-controls" style="background-color: #EFF0F2;">	
				</div>
				
				</form>
				</div>
			    </div>

	     <div id="addstudentdialogbox">
		    <div class="card mx-auto rounded-2 p-4 " style="width:18rem; padding:0px;margin-top: 5%;" id="card-style">
			<div class="card-body pb-0 col-sm-8 ">
			    <form id="" name="studentform" action="">
                 <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> -->
				<div class="my-3">
					<label for="name" class="text-start fs-6 fw-normal">StudentName </label>
				
				<input type="text" name="name"  class="form-control" style="background-color: ">	
				</div>
					<div class="my-3">
					<label for="email" class="text-start fs-6 fw-normal">Student Email </label>
				<input type="text" name="email" id="email" class="form-control" style="background-color: #EFF0F2;">	
				</div>
				
					<div class="my-3">
					<label for="mobile" class="text-start fs-6 fw-normal">Student Mobile </label>
				<input type="text" name="mobile" id="mobile" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="username" class="text-start fs-6 fw-normal">UserName </label>
				
				<input type="text" name="username" id="username" class="form-control" style="background-color: #EFF0F2;">	
				</div>
				
					<div class="my-3">
					<label for="tpassword" class="text-start fs-6 fw-normal">Password </label>
				
				<input type="password" name="password" id="password" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="centercode" class="text-start fs-6 fw-normal">Center Code</label>
				
				<input type="text" name="centercode" id="centercode" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
    					<label for="batchcode" class="text-start fs-6 fw-normal">Batch Code </label>
    				    <input type="text" name="batchcode" id="batchcode" class="form-control " style="background-color: #EFF0F2; width:70%;">	
				    </div>
				    
					<div class="my-3">
					  <label for="batchcode" class="text-start fs-6 fw-normal">Center</label>
				      <input type="text" name="centercode" id="centercode" class="form-control" style="background-color: #EFF0F2; width:70%;">	
				    </div>
				    
					<div class="my-3">
					<label for="catyear" class="text-start fs-6 fw-normal">CAT Year </label>
				
				<input type="date" name="catyear" id="catyear" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="admissiondate" class="text-start fs-6 fw-normal">Admission Date </label>
				
				<input type="date" name="admissiondate" id="admissiondate" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="dateofbirth" class="text-start fs-6 fw-normal">DateofBirth </label>
				
				<input type="date" name="dateofbirth" id="dateofbirth" class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="" class="text-start fs-6 fw-normal">Address </label>
				
				<input type="text" name="address" id=""  class="form-control" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="college" class="text-start fs-6 fw-normal">College/Company </label>
				
				<input type="text" name="college" id="college" class="form-control" style="background-color: #EFF0F2;">	
				</div>

				<div class="form-check pl-0" style="padding-left:0">
					<input class="form-check-input p-2 m-2 border rounded-0" type="checkbox" value=""
						id="flexCheckDefault" style="box-shadow:none">
					<label class="form-check-label py-2" for="flexCheckDefault"
						style="color: #4d5959 !important;font-size: 15px;">
						Show custom fields
					</label>
				</div>

				</div>
				<!--<buttonn  type="submit"  id="mybtnn" class="btn btn-secondary px-5 py-2 mt-4 border-0 mx-auto" style="background:#A83942" >Add Student</button>-->
				<!--  <div class="text-center">-->
    <!--                            <button onclick="$('#addstudentdialogbox').hide();"  id="mybtn" class="btn px-5 py-1 my-2 text-white border-0 mx-auto"-->
    <!--                                style="background-color: #A83942;">ADD STUDENT</button>-->

    <!--                        </div>-->
    
    	<div class="text-center">
    	    <a href="javascript:void()" onclick="$('#addstudentdialogbox').hide();">
					<button type="submit" class="btn btn-secondary px-5 py-2 mt-4 border-0 mx-auto" id="mybt" 	style="background: #a83942">Add</button>
					<br />
					</a>
					<!--<a href="javascript:void()" onclick="$('#addstudentdialogbox').hide();" class="btn px-5 py-2 mt-4 border-0 mx-auto text-dark" -->
					<!--	style="background-color: #f1eeee">Cancel</a>-->
                
                </div>
            </form>
			</div>
				
			
		</div>
	
	</div>
	
	 <!-- set Modal -->
	 <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('admin.save')}}" method="post" enctype="multipart/form-data" id="studentForm1">
          @csrf
        <div class="modal-content">

        <!-- <div class="modal-header">
        <h3 class="modal-title">Student detail</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left:60%;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      
          	<div class="modal-body">
				<div class="student-form">
					<h3>Student Details</h3>
			  	<div class="form-group">
					<label for="">Student Name:</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Email:</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Password:</label>
					<input type="text" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Mobile:</label>
					<input type="number" name="mobile" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Admission Date:</label>
					<input type="date" name="admissiondate" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">DOB:</label>
					<input type="date" name="dateofbirth" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Batch code :</label>
					<input type="text" name="batch_code" class="form-control" id="batch_code">
					
					@error('batch_code')
                     <span class="text-danger">{{ $message }}</span>
                    @enderror

				</div>
				<div class="form-group">
					<label for="name">Center :</label>
					<input type="text" name="centercode" class="form-control">
				</div>
					<div class="form-group">
					<label for="name">CAT Year :</label>
					<input type="text" name="catyear" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Address:</label>
					<textarea id="address" class="form-control" name="address" rows="4" cols="41"></textarea>
				</div>
					<div class="form-group">
					<label for="name">Collage:</label>
					<textarea id="college" class="form-control" name="college" rows="4" cols="41"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          	</div>
			</div>
        <!-- <div class="modal-footer">
         
        </div> -->
     </div>
     </form>
	 
    </div>
  </div>
<!-- endsetmodal -->
	
	
	 <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="{{ asset('public/assets/admin/js/javascript.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    $(document).on('click','#at_edit',function(e){
    alert("fjl");
           $('#update').css('display','flex');
    });
    //  $("#mybtn").click(function(e){
      $(document).on('click','#mybt',function(e) {
      
            e.preventDefault();
        //   alert("Fjldj");
                    //var name = $('#name').value();
                    var name = $('#studentform  input[name=name]').val();
                    var email = $('#studentform  input[name=email]').val();
                   
                      var mobile = $('#studentform input[name=mobile]').val();
                       var username = $('#studentform input[name=username]').val();
                      var password = $('#studentform input[name=password]').val();
                     var centercode = $('#studentform input[name=centercode]').val();
                     var batchcode = $('#studentform input[name=batchcode]').val(); 
                     var catyear = $('#studentform input[name=catyear]').val(); 
                     var admissiondate = $('#studentform input[name=admissiondate]').val();
                     var dateofbirth = $('#studentform input[name=dateofbirth]').val();  
                     var address = $('#studentform input[name=address]').val(); 
                     
                     var college = $('#studentform input[name=college]').val(); 

            $.ajax({
              'async': false,
                type:'post',
                url:'{{route('admin.save')}}',
                 dataType: 'json',
                data : {
                        //_token: $('meta[name="csrf-token"]').attr('content'),
                        "_token": "{{ csrf_token() }}",
                        
                        name:name,
                        email:email,
                        mobile:mobile,
                         username:username,
                          password:password,
                          centercode:centercode,
                            batchcode:batchcode,
                             catyear:catyear,
                              admissiondate:admissiondate,
                              dateofbirth:dateofbirth,
                              adress:address,
                              college:college
                        
                    }, 
                 
                    
                success:function(response){
                     window.location = '{{ route('admin.studentcreation') }}'
    //                   var msg = '';
    //                   if(response.status == 1){
    //                 msg = 'Data Insert Succsessfully ';
                  
				// 	}else{
				// 	    msg= 'Data not Insert';
				// 	}
    //                  toastr.success(msg);
                }
                
          });
          
      
                
     });
                
       
      
    </script>
    
    
    
    <!-- For Auto Remove Alert  -->
	<script>
	
		$(document).ready(function() {
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
      $("#success-alert").slideUp(500);
 
  });
});
	</script>
	
	
	<script>
document.getElementById('batch_code').addEventListener('input', function() {
    this.value = this.value.trimStart();
});
document.getElementById('batch_code').addEventListener('blur', function() {
    this.value = this.value.trim();
});

//  Trim before submit
document.getElementById('studentForm').addEventListener('submit', function() {
    let batchInput = document.getElementById('batch_code');
    batchInput.value = batchInput.value.trim(); // removes both left & right spaces
});
</script>
    
@endsection