
@extends('admin_template')
@section('css')
@endsection
@section('content')
<?php
 $totalst = DB::table('studentlogs')	
            ->select('id')
            ->get();
$countt =$totalst->count();

session_start(); 
if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views']+1;
else
    $_SESSION['views']=1;
      
$view = $_SESSION['views'];

//$data = $_SERVER['SERVER_ADDR'];
//$ip = request()->ip();
//dd($data);
 // $users = DB::table('studentlogs')->get();
 //    $counter = 0;
 //    foreach ($users as $user) {
 //        dd($user);
 //        if (Cache::has('user-is-online-' . $user->id)) {
 //            $counter++;   
 //        }
 //    }
//dd($counter);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9 bg-light py-3" id="right-menu-bar">
    <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
       <h5 class="fw-bold text-capitalize">Dashboard</h5>
    </div>
    <div class="row">
         <div class="col-md-6 col-lg-6 col-xlg-3">
              <div class="card card-hover mb-3">
                <div class="box bg-cyan text-center">
                  <h1 class="font-light text-white">
                  <i class="fa-solid fa-users mt-2 mb-2" style="" aria-hidden="true"></i>
                  </h1>
                  <h6 class="text-white">Total Registration</h6>
                  <h5 class="text-white"> {{$countt}}</h5>
                </div>
              </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xlg-3 py3">
              <div class="card card-hover">
                <div class="box bg-cyan1  text-center">
                  <h1 class="font-light text-white">
                  <i class="fa-solid fa-users mt-2 mb-2" style="" aria-hidden="true"></i>
                  </h1>
                  <h6 class="text-white">Login Students</h6>
                  <h5 class="text-white"> {{$view}}</h5>
                </div>
              </div>
    </div>

   
    </div>
    
</div>
@endsection
@section('script')
@endsection




