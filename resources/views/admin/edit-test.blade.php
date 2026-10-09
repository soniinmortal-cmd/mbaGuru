@extends('admin_template')
@section('css')
@endsection
@section('content') 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9" id="">
   <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
      <h4 class="fw-bold text-capitalize">EDIT TEST</h4>
   </div>
   <!-- <h6>Publish/Unpublish the quiz for your learners</h6> -->
   <form action="{{route('admin.edit-test-record')}}" method="post" enctype="multipart/form-data">
      @csrf
        <div class="col-md-6">
            <input type="hidden" name="id" value="{{$tests->id}}"  class="">
            <input type="hidden" name="testincid" value=""class="">
            <!-- <div class="card">
                <div class="container">
                    <label class="radio-btn">
                        <input type="radio" name="status" value="1"  class="">
                        Live
                    </label>
                    <h6 class="css-8rmghh">It will publish quiz for learners to enroll &amp; access</h6>
                </div>
            </div> -->
            <br/>
          <!--   <div class="card">
                <div class="container">
                    <label class="radio-btn">
                        <input type="radio" name="status" value="2"  class="">
                        Coming Soon
                    </label>
                    <h6 class="css-8rmghh">It will show the quiz status to the learners as coming soon</h6>
                </div>
            </div> -->
            <br/>
            <!-- <div class="card">
                <div class="container">
                    <label class="radio-btn">
                        <input type="radio" name="status" value="3"  class="">
                        Scheduled
                    </label>
                    <h6 class="css-8rmghh">Scheduled quiz will be released on the preset future dates</h6>
                </div>
            </div> -->
            <br/>
           <div class="form-group">
             <input type="text" name="test" value="{{$tests->test}}{{$tests->testincid}}"  class="form-group"/>
        
           </div>
            <br/>
            <button type="submit" id ="" class="btn btn-primary">Submit</button>
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
