@extends('admin_template')
@section('content')
<?php
//dd($students->admissiondate);
 $dobDate = $students->dateofbirth;
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
    <div class="col-md-9" id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
           <h5 class="fw-bold text-capitalize">Edit</h5>
        </div>
        @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
        <div class=""  style="width:50%;">
            <form action="{{route('admin.editstudentdata')}}" method="post" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name ="id" value="{{$students->id}}">
			  	<div class="form-group">
					<label for="name">Student Name:</label>
					<input type="text" name="name" value="{{$students->name}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Email:</label>
					<input type="email" name="email" value="{{$students->email}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Password:</label>
					<input type="text" name="show_password" value="{{$students->show_password}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Mobile:</label>
					<input type="number" name="mobile" value="{{$students->mobile}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Admission Date:</label>
					<input type="date" name="admissiondate" value="{{$students->admissiondate}}" class="form-control">
				</div>
				<!--<div class="form-group">-->
				<!--	<label for="name">Admission Date:</label>-->
				<!--	<input type="date" name="admissiondate" value="{{$students->admissiondate}}" class="form-control">-->
				<!--</div>-->
				<div class="form-group">
					<label for="name">DOB:</label>
					<input type="date" name="dateofbirth" value="{{$dobbDate}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Address:</label>
					<input type="text" id="address" name="address" value="{{$students->address}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Batch Code:</label>
					<input type="text" id="batch_code" name="batch_code" value="{{$students->batch_code}}" class="form-control">
				</div>
					<div class="form-group">
					<label for="name">Center:</label>
					<input type="text" id="centercode" name="centercode" value="{{$students->centercode}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">CAT YEAR:</label>
					<input type="text" id="catyear" name="catyear" value="{{$students->catyear}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name">Collage:</label>
					<input type="text" id="college" name="college" value="{{$students->college}}" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
      	</div>
       
    </div>

@endsection
@section('script')
@endsection




