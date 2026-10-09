@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9" id="">
   <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
      <!-- <h4 class="fw-bold text-capitalize">Maximum Attempt</h4> -->
   </div>
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
      <a href="{{route('admin.center')}}" class="btn btn-danger btncolor" style="float:right;">Show Center</a>
   <form action="{{route('admin.update-center')}}" method="post" enctype="multipart/form-data">
      @csrf
      
        <div class="col-md-6">
         <input type="hidden" name="id" value="{{$center->id}}">
            <br/>
            <div class="form-group">
               <label>Center Name:</label>
             <input type="text" name="centername" class="form-control"placeholder="Enter center Name" value="{{ !empty($center) ? $center->centername : '' }}">
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>

@endsection
@section('script')
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
