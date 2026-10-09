@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<style>
        .pdf-page {
            width: 100%;
            height: auto;
            border: 1px solid #ccc;
        }
    </style>
<div class="col-md-9" id="">
   <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
      <!-- <h4 class="fw-bold text-capitalize">Maximum Attempt</h4> -->
   </div>
   <?php
   $id = request()->id;
   ?>
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
      <a href="{{route('admin.test-pdf',$id)}}" class="btn btn-danger btncolor" style="float:right;">Show</a>
   <form action="{{route('admin.save-pdf')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="test_id" value ="{{$id}}">
     
        <div class="col-md-6">
            <br/>
            <div class="form-group">
               <label>Pdf Name:</label>
              <input type="text" name="pdf_name" class="form-control"placeholder="Enter pdf_name">
            </div>
            <div class="form-group">
               <label>Upload File:</label>
              <input type="file" name="file" class="form-control"placeholder="Enter pdf" id="imageInput" >
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Submit</button>
              <!--<div id="pdf-viewer"></div>-->
               <!--<div id="preview"></div>-->
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

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
        $(document).ready(function() {
            $('.saveimg').css('display','block');
            $('#imageInput').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = $('<img>').attr('src', e.target.result).css('max-width', '200px');
                        $('#preview').empty().append(img);
                        $('.saveimg').css('display','none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
  </script>
    
   
