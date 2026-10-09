@extends('admin_template')

@section('css')
@endsection

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <div class="col-md-9 bg-light py-3 " id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">Assign Test</h5>
            <?php
                $user_id = request()->id;
            ?>
            <a href="{{route('admin.assign-user',$user_id)}}" class="btn btn-primary">Show Product</a>
        </div>
      
        <div class="container-fluid">
            <div class="row px-2 my-5">
                <!-- <div class="col-md-12 col-md-12 px-2 py-1 my-0 rounded-1 mx-2 text-white" id="Across-tests" style="">
                    Students Assign Test
                </div> -->
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
             
                <div class="col-md-9 px-2">
                    <div class="card bg-white pt-3 px-1 display-box-data">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row px-2">  
                               
                                </div>
                            </div>
                            <div class="col-md-12 ms-2 mt-5">
                                <form action="{{route('admin.saveProduct')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form">
                                        <input type="hidden"name="user_id" value="{{$user_id}}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sector">Product Name</label>
                                                <select class="form-control" name="course_id">
                                                    <option  value="">Select</option>
                                                    @foreach($courses as $course)
                                                    <option value="{{$course->title}}">{{$course->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br><br><br><br><br><br>
                                        <button type="submit" class="btn btn-primary" >Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

</script>
@endsection
