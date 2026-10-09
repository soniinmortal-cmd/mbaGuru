@extends('student_template')
@section('content')
	
<div class="col-md-9 bg-light py-3  " id="right-menu-bar">
				<div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
					<h5 class="fw-bold">Student Creation</h5>
					<div id="right-menubar-top" class="d-flex gap-1 justify-conetent-center align-items-center">
						<div class="dropdown ">
							<button id="more-btn" class="btn rounded-0 dropdown-toggle p-1" type="button"
								data-bs-toggle="dropdown" aria-expanded="false " >
								More
							</button>
							<ul class="dropdown-menu">
								<li><button class="dropdown-item" type="button">Import Student</button></li>
								<li><button class="dropdown-item" type="button">Import History</button></li>
							</ul>
						</div>
						<a href="javascript:void(0)" onclick="$('#addstudentdialogbox').show();$('body').scrol('none')" class="btn rounded-1  p-1" style="background-color: #A83942;">
							<div class=" rounded-0 text-white d-flex justify-content-center align-items-center gap-3">
								<span><i class="fa-solid fa-plus" style="font-size: 13px!important"></i></span>
								<span class="" id="add-btn" style="font-size: 13px!important;">ADD</span>
							</div>
						</a>
					</div>
				</div>
				<div id="topbar-bottom-serbar" style="position: relative;"
					class="d-flex justify-conetent-center align-items-center ">
					<span id="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
					<input class="form-control py-1 border px-2 m-1 " type="text" placeholder="Search By Email"
						id="search-icon-input-2" aria-label="Search" style=" background-color: #F4F4F4;">
					<a href="#" class="btn py-1 px-3 rounded-1" style="background-color:#A839428F ;">
						<div class=" rounded-0 text-white d-flex justify-conetent-between align-items-center gap-2">
							<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 13px!important;">Add Filter</span>
						</div>
					</a>
				</div>
				<div id="moile-contains-filter-sec" class="d-flex m-1 ">
					<div id="mobile-content" class="d-flex justify-content-between align-items-center px-2 py-0">
						<span style="font-size: 12px;color: #808191;">Mobile</span>
						<span style="font-size: 12px;color: #808191;">Contains</span>
						<input class="form-control py-0 px-2 m-1 rounded-0 w-50" type="text" placeholder=""
							id="search-icon-input-2 " aria-label="Search"
							style=" background-color: #F4F4F4;box-shadow: none!important; ">
					</div>
					<a href="#" class="btn py-1 px-2 rounded-1"
						style="margin-left:5px;background-color:#A83942 ; width: 120px;" >
						<div class=" text-white d-flex justify-conetent-between align-items-center gap-2">
							<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 13px!important;">Apply Filter</span>
						</div>
					</a>
				</div>

				<a href="#" class="btn  text-dark rounded-1 mt-3 mb-4 ms-2"
					style="background-color: #F1EEEE;font-size: 13px!important;" >EXPORT</a>

				<div id="select-colunms" class="w-100  px-2 d-flex justify-content-end my-3">
					<div class="dropdown">
						<button id="more-btn" class="btn rounded-0 dropdown-toggle p-1 text-uppercase" type="button"
							data-bs-toggle="dropdown" aria-expanded="false " >
							Select Columns
						</button>
						<ul class="dropdown-menu">
							<li><button class="dropdown-item" type="button">Action</button></li>
							<li><button class="dropdown-item" type="button">Another action</button></li>
							<li><button class="dropdown-item" type="button">Something else here</button></li>
						</ul>
					</div>
				</div>

				<table class="table table-bordered mx-1" style="width:97%">
					<thead class="">
						<tr>
							<th scope="col">EMAIL</th>
							<th scope="col">MOBILE</th>
							<th scope="col">SIGNED ON</th>
							<th scope="col">LAST LOGIN</th>
						</tr>
					</thead>
					<tbody>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>

							<td>rahul@gmail.com</td>
							<td>----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>
							<td>rahul@gmail.com</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>
							<td>rahul@gmail.com</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
					</tbody>
				</table>

			</div>

	<div id="addstudentdialogbox">
		<div class="card mx-auto rounded-2 p-4" style="width: 18rem; border: none; padding:0px;margin-top: 5%;" id="card-style">
			<span onclick="$('#addstudentdialogbox').hide();"><i class="fa fa-arrow-left m-3" style="position: absolute; top: 0;left: 0;cursor:pointer;"></i></span>
			
				<!--<select name="" id="" class="form-select" style="background-color: #EFF0F2;">-->
					<!--	<option value="">Enter Student Name</option>-->
					<!--</select>-->
			<div class="card-body pb-0">

				<div class="my-3">
					<label for="studentname" class="text-start fs-6 fw-normal">StudentName </label>
				
				<input type="text" name="name" class="form-controls" style="background-color: #EFF0F2;">	
				</div>
					<div class="my-3">
					<label for="email" class="text-start fs-6 fw-normal">Student Email </label>
				<input type="text" name="email" class="form-controls" style="background-color: #EFF0F2;">	
				</div>
				
					<div class="my-3">
					<label for="mobile" class="text-start fs-6 fw-normal">Student Mobile </label>
				<input type="text" name="mobile" class="form-controls" style="background-color: #EFF0F2;">	
				</div>

				<!--<div id="pass-sect" class="my-3">-->
				<!--	<label for="password" class="align-self-start fs-6 fw-normal ">Email</label>-->
				<!--	<input type="text" class="form-control mx-auto outline-0  mt-0 mb-3"-->
				<!--		style="background-color: #EFF0F2;box-shadow:none" placeholder="select email">-->
				<!--	<span id="eyeicon"><i class="fa-solid fa-eye-slash" style="font-size:12px;"></i></span>-->
				<!--</div>-->

				<!--<div class="my-3">-->
				<!--	<label for="email" class="text-start fs-6 fw-normal">Mobile </label>-->
				<!--	<select name="" id="" class="form-select" style="background-color: #EFF0F2;">-->
				<!--		<option value="">Mobile</option>-->
				<!--	</select>-->
				<!--</div>-->
				
				<!--	<div class="my-3">-->
				<!--	<label for="name" class="text-start fs-6 fw-normal">StudentName </label>-->
				<!--    <input type="text" class="form-controls text-start fs-6 fw-normal" style="background-color: #EFF0F2; placeholder="Enter Student Name">-->
				<!--</div>-->
				
				
				<!--<div class="my-3">-->
				<!--	<label for="mobile" class="text-start fs-6 fw-normal"> Mobile </label>-->
				<!--    <input type="text" class="form-controls text-start fs-6 fw-normal" style="background-color: #EFF0F2; placeholder="Enter Student Mobile">-->
				<!--</div>-->

			

				<!--<div class="my-3">-->
				<!--	<label for="email" class="text-start fs-6 fw-normal">Mobile </label>-->
				<!--	<select name="" id="" class="form-select" style="background-color: #EFF0F2;">-->
				<!--		<option value="">Mobile</option>-->
				<!--	</select>-->
				<!--</div>-->

				<!--<div class="my-3">-->
				<!--	<label for="email" class="text-start fs-6 fw-normal">Amo </label>-->
				<!--	<input type="text" class="form-control mx-auto outline-0  mt-0 mb-3"-->
				<!--		style="background-color: #EFF0F2;box-shadow:none" placeholder="0">-->
					<!-- <input type="text" class="form-control" placeholder="0"  style="background-color: #F1EEEE;"> -->
				<!--</div>-->
				<!--<div class="my-3">-->
				<!--	<label for="email" class="text-start fs-6 fw-normal">Exp </label>-->
				<!--	<input type="text" class="form-control mx-auto outline-0  mt-0 mb-3"-->
				<!--		style="background-color: #EFF0F2;box-shadow:none" placeholder="dd-mm-yyyy">-->
					<!-- <input type="text" class="form-control" placeholder="0"  style="background-color: #F1EEEE;"> -->
				<!--</div>-->
				<!--<div class="form-check pl-0" style="padding-left:0">-->
				<!--	<input class="form-check-input p-2 m-2 border rounded-0" type="checkbox" value=""-->
				<!--		id="flexCheckDefault" style="box-shadow:none">-->
				<!--	<label class="form-check-label py-2" for="flexCheckDefault"-->
				<!--		style="color: #4d5959 !important;font-size: 15px;">-->
				<!--		Show custom fields-->
				<!--	</label>-->
				<!--</div>-->

				<div class="text-center"><a href="{{'/student/save'}}" class="btn btn-secondary px-5 py-2 mt-4 border-0 mx-auto"
						id="singIn-btn" style="background:#A83942">ADD NEW STUDENT</a>
				</div>

			</div>
		</div>
	</div>
@endsection