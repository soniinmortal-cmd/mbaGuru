<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body> -->
@extends('admin_template')
@section('css')
@endsection
@section('content') 
     <div class="col-md-9 bg-light py-3  " id="right-menu-bar">
         @if(Session::has('message'))
         <p class="alert {{ Session::get('alert-class', 'alert-success') }}">
        {{ Session::get('message') }}</p>
        @endif
          <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
               <h5 class="fw-bold text-capitalize">Import/Export</h5>
                <a href="{{ asset('assets/excel-formate/student-creation.xlsx') }}" download>Download Formate</a>
          </div>
          <div class="container-fluid mt-5 text-center">
            <div class="card">
                <div class="card-body">
                    
        <form action="{{route('admin.import2')}}" class="border py-4 px-4" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left ">
                   <label class="custom-file-label" for="customFile">Choose file</label>

                    <input type="file" name="file" class="custom-file-input mb-4 border w-100" id="customFile" required>
                    </forms>
                </div>
            <div class="text-left">
            <button class="btn btn-primary">Import Students</button>
            <a class="btn btn-success" href="{{route('admin.export')}}">Export Students</a>
            </div>
            </div>
            </div>
            </div>
    
        </div>
     </div>
    
    @endsection
@section('script')
@endsection
<!-- </body>
</html> -->
