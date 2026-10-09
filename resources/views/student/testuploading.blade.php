@extends('student_template')
@section('content')
		
			<div class="col-md-9 bg-light py-3  " id="right-menu-bar">
				<div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
					<h5 class="fw-bold">Test uploading</h5>
					<div id="right-menubar-top" class="d-flex gap-1 justify-conetent-center align-items-center">
						<div class="dropdown ">
						    <!--dropdown-toggle-->
							<button id="more-btn" class="btn rounded-0  p-1" type="button"
								data-bs-toggle="dropdown" aria-expanded="false">
								Manage
							</button>
							<!--<ul class="dropdown-menu">-->
							<!--	<li><button class="dropdown-item" type="button">Import Student</button></li>-->
							<!--	<li><button class="dropdown-item" type="button">Import History</button></li>-->
							<!--</ul>-->
						</div>
						<a href="javascript:void(0)" onclick="$('#addstudentdialogbox').show();" class="btn  py-1 px-2 rounded-1" style="background-color: #A83942; width: 120px;">
							<div class="text-white d-flex justify-content-center align-items-center gap-3">
								<span><i class="fa-solid fa-plus" style="font-size: 13px!important"></i></span>
								<span class="" id="add-btn" style="font-size: 13px!important;">Create</span>
							</div>
						</a>
					</div>
				</div>
				<div id="topbar-bottom-serbar" style="position: relative;"
					class="d-flex justify-conetent-center align-items-center ">
					<span id="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
					<input class="form-control py-1 border px-2 m-1" type="text" placeholder="Search By Test Uploading"
						id="search-icon-input-2" aria-label="Search" style=" background-color: #F4F4F4;">
					<a href="#" class="btn p-0  py-1 px-2 rounded-1" style="background-color:#A839428F ;width: 120px;">
						<div class=" text-white d-flex justify-conetent-between align-items-center gap-2">
						<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 13px!important;">Add Filter</span>
						</div>
					</a>
				</div>
				<div id="moile-contains-filter-sec" class="d-flex m-1">
					<div id="mobile-content" class="d-flex justify-content-between align-items-center px-2 py-0">
						<span style="font-size: 12px;color: #808191;">Status is select a value</span>
						<!-- <span style="font-size: 12px;color: #808191;">Contains</span> -->
						<!-- <input class="form-control py-0 px-2 m-1 rounded-0 w-50" type="text" placeholder="" id="search-icon-input-2 " aria-label="Search" style=" background-color: #F4F4F4;box-shadow: none!important; "> -->
					</div>
					<a href="#" class="btn p-0 py-1 px-2 rounded-1"
						style="margin-left:5px;background-color:#A83942 ;width: 120px;" >
						<div class="text-white d-flex justify-conetent-between align-items-center gap-2">
						<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 13px!important;">Apply Filter</span>
						</div>
					</a>
				</div>
				<!-- <a href="#" class="btn  text-dark mt-3 mb-4 ms-2" style="background-color: #F1EEEE;font-size: 13px!important;">EXPORT</a> -->
				<div id="select-colunms" class="w-100  px-2 d-flex justify-content-end my-3">
					<div class="dropdown">
						<button id="more-btn" class="btn rounded-0 p-1 text-uppercase" type="button"
							aria-expanded="false">
							Filter By Published Date
						</button>
					</div>
				</div>
				<div id="container">
					<div class="row row-cols-1 row-cols-md-3 g-4">
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."style="position: relative;">
								<span id="overlay">FLTs 2019</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">FLTs 2019</h5>
									<p class="card-text" style="color:#11142DA6;font-size:12px;font-weight:normal;">15
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer  d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."
									style="position: relative;">
								<span id="overlay">Past CAT Papers-1</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">Past CAT Papers-1
									</h5>
									<p class="card-text " style="color:#11142DA6;font-size:12px;font-weight:normal;">21
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."
									style="position: relative;">
								<span id="overlay">AIRCATS-2021</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">AIRCATS-2021</h5>
									<p class="card-text " style="color:#11142DA6;font-size:12px;font-weight:normal;">34
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."
									style="position: relative;">
								<span id="overlay">FLTs 2019</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">FLTs 2019</h5>
									<p class="card-text " style="color:#11142DA6;font-size:12px;font-weight:normal;">15
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer  d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."
									style="position: relative;">
								<span id="overlay">Past CAT Papers-1</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">Past CAT Papers-1
									</h5>
									<p class="card-text " style="color:#11142DA6;font-size:12px;font-weight:normal;">21
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card m-auto h-25 w-75">
								<img src="{{asset('assets/student/image/profile-img.webp')}}" class="card-img-top rounded" alt="..."
									style="position: relative;">
								<span id="overlay">AIRCATS-2021</span>
								<div class="card-body p-2 border border-top-0">
									<h5 class="card-title" style="font-size:15px;font-weight:600;">AIRCATS-2021</h5>
									<p class="card-text " style="color:#11142DA6;font-size:12px;font-weight:normal;">34
										Tests</p>
									<div class="d-flex justify-content-between align-items-center fw-normal"
										style="color:#11142D;font-size: 12px;">
										<span id="" class="fw-bold">free</span>
										<span style="color:#11142DA6">31 Days</span>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between align-items-center"
									style="background-color:#A83942BA">
									<a href="#"
										class="btn btn-dark text-dark py-1 px-2 fw-bold bg-white rounded border-0"
										style="font-size:12px">Unpublished</a>
									<span><i class="fa-solid fa-circle-exclamation" style="color: white;"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		
	

	<div id="addstudentdialogbox">
		<div class="card mx-auto p-4" style="width: 18rem; border: none; border-radius:10px!important; margin-top:2%!important;" id="card-style">
			<div class="card-header py-4" style="background: transparent!important;border: none!important;">
				<div id="top-sect-create-uploading " class=" d-flex text-center justify-content-center flex-column">
					<span onclick="$('#addstudentdialogbox').hide();"><i class="fa fa-arrow-left m-3" style="position: absolute; top: 0;left: 0;cursor:pointer;"></i></span>
					<h4 class="text-capitalize fw-bold">create test uploading</h4>
					<p class="fw-normal">Start creating a new test uploading</p>
				</div>
			</div>
			<div class="card-body pb-0">
				<div class="my-3">
					<div class="d-flex justify-content-between align-items-center">
						<label for="email" class="text-start fs-6 fw-bold fw-normal">Title * </label><span
							class="fw-normal">0/60</span>
					</div>
					<input type="text" class="form-control mx-auto outline-0 mt-0 mb-3"
						style="background-color: #f1eeee; box-shadow: none" placeholder="Enter test uploading" />
					<!-- <input type="text" class="form-control" placeholder="0"  style="background-color: #F1EEEE;"> -->
				</div>
				<div class="my-3">
					<label for="email" class="text-start fs-6 fw-bold fw-normal">Price
					</label>
					<input type="text" class="form-control mx-auto outline-0 mt-0 mb-3"
						style="background-color: #f1eeee; box-shadow: none" placeholder="price" />
					<!-- <input type="text" class="form-control" placeholder="0"  style="background-color: #F1EEEE;"> -->
				</div>
				<div class="form-check pl-0" style="padding-left: 0">
					<input class="form-check-input p-2 m-2 border rounded-0" type="checkbox" value=""
						id="flexCheckDefault" style="box-shadow: none" />
					<label class="form-check-label py-2" for="flexCheckDefault"
						style="color: #4d5959 !important; font-size: 15px">
						Make a free test uploading
					</label>
				</div>

				<div class="text-center">
					<a href="#" class="btn btn-secondary px-5 py-2 mt-4 border-0 mx-auto" id="singIn-btn"
						style="background: #a83942">Create</a>
					<br />
					<a href="javascript:void()" onclick="$('#addstudentdialogbox').hide();" class="btn px-5 py-2 mt-4 border-0 mx-auto text-dark" id="singIn-btn"
						style="background-color: #f1eeee">Cancel</a>
				</div>
			</div>
		</div>
	</div>


	@endsection