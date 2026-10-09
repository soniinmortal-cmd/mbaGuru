@extends('student_template')
@section('css')
@endsection
@section('content')
<div class="col-md-9 bg-light py-3 " id="right-menu-bar">
   <div id="topbar-right-menu " class="d-flex  px-3 my-3 justify-content-between align-items-center"></div>
   <?php
      $userid =session()->get('id');
      $reports = DB::table('student_quizes')
                      ->where('user_id',$userid)
                     ->where('section_type','verbal')
                      ->get();
     
      ?>
    <div class="conatiner-fluid">
        <div class="card mt-4">
            <div class="col-md-6">
                <div class="card-body">
                <form action="{{route('student.profile-update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name ="id" value={{$userid}}>
                        <div class="form-group">
                            <label for="email">Profile Image:</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
@endsection