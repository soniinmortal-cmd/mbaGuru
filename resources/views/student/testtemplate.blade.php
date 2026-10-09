@extends('student_template')
@section('content')
<div class="col-md-9 bg-light py-3  " id="right-menu-bar">
				<div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
					<h5 class="fw-bold text-capitalize">test template</h5>
					<div id="right-menubar-top" class="d-flex gap-1 justify-conetent-center align-items-center">
						<div class="dropdown ">
						    <!--dropdown-toggle-->
							<button id="more-btn" class="btn rounded-0  p-1" type="button"
								data-bs-toggle="dropdown" aria-expanded="false " >
								Manage
							</button>
							<!--<ul class="dropdown-menu">-->

							<!--	<li><button class="dropdown-item" type="button">Import Student</button></li>-->
							<!--	<li><button class="dropdown-item" type="button">Import History</button></li>-->
							<!--</ul>-->
						</div>
						<a href="#" class="btn  py-1 px-2 rounded-1" style="background-color: #A83942;">
							<div class=" text-white d-flex justify-content-center align-items-center gap-3">
								<span><i class="fa-solid fa-plus" style="font-size: 13px!important"></i></span>
								<span class="" id="add-btn" style="font-size: 13px!important;">Create</span>
							</div>
						</a>
					</div>
				</div>
				<div id="topbar-bottom-serbar" style="position: relative;"
					class="d-flex justify-conetent-center align-items-center ">
					<span id="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
					<input class="form-control py-1 px-2 border m-1 " type="text" placeholder="Search By test template"
						id="search-icon-input-2" aria-label="Search" style=" background-color: #F4F4F4;">
					<a href="#" class="btn py-1 px-2 rounded-1  " style="background-color:#A839428F ;width: 120px;">
						<div class=" text-white d-flex justify-conetent-between align-items-center gap-2">
							<span><i class="fa-solid fa-filter" style="font-size: 13px!important;"></i></span>
							<span style="font-size: 13px!important;">Add Filter</span>
						</div>
					</a>
				</div>

				<div id="moile-contains-filter-sec" class="d-flex m-1 ">
					<div id="mobile-content" class="d-flex justify-content-between align-items-center px-2 py-0">
						<span style="font-size: 12px;color: #808191;">Status is select a value</span>
						<!-- <span style="font-size: 12px;color: #808191;">Contains</span> -->
						<!-- <input class="form-control py-0 px-2 m-1 rounded-0 w-50" type="text" placeholder="" id="search-icon-input-2 " aria-label="Search" style=" background-color: #F4F4F4;box-shadow: none!important; "> -->
					</div>
					<a href="#" class="btn py-1 px-2 rounded-1 "
						style="margin-left:5px; background-color:#A83942 ;width: 120px;" >
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
							aria-expanded="false " >
							Filter By Published Date
						</button>
						<!-- <ul class="dropdown-menu">
                  <li><button class="dropdown-item" type="button">Action</button></li>
                  <li><button class="dropdown-item" type="button">Another action</button></li>
                  <li><button class="dropdown-item" type="button">Something else here</button></li>
                </ul> -->
					</div>
				</div>




			</div>


			
@endsection