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
            <a href="{{route('admin.assign-product',$user_id)}}" class="btn btn-primary">Assign Product</a>
        </div>
      
        <div class="container-fluid">
            <div class="row px-2 my-5">
                <!-- <div class="col-md-12 col-md-12 px-2 py-1 my-0 rounded-1 mx-2 text-white" id="Across-tests" style="">
                    Students Assign Test
                </div> -->
             
                <div class="col-md-9 px-2">
                    <div class="card bg-white pt-3 px-1 display-box-data">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row px-2"></div>
                            </div>
                            <div class="col-md-12 ms-2 mt-5">
                                <table class="table w-90 border-0 rounded-2">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($assign_tests as $assign_test) 
                                        <tr>
                                            <td>{{$assign_test->course_id}}</td>
                                            @if($assign_test->status == 1)
                                            <td>Active</td>
                                            @else
                                            <td>Inactive</td>
                                            @endif
                                            <td>
                                            @if($assign_test->status == 1)
                                                <a href= "" class="btn btn-danger updateassign" data-status="0" data-course="{{$assign_test->course_id}}" data-user="{{$user_id}}">Unassign</a>
                                            @else
                                                <a href= "" class="btn btn-primary updateassign" data-status="1" data-course="{{$assign_test->course_id}}" data-user="{{$user_id}}">Assign</a>
                                            @endif
                                            </td>
                                        </tr> 
                                    @endforeach   
                                    </tbody>
                                </table>
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
$(document).ready(function(){
    $('.updateassign').click(function(){
        var status = $(this).attr('data-status');
        var course_id = $(this).attr('data-course');
        var user_id = $(this).attr('data-user');
       //ajax
       $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        method: 'POST', 
        url: 'https://test.mbaguru.in/admin/updateAssignUser',
        data: {
            'user_id': user_id,
            'course_id': course_id,
            'status': status
        },
          success: function(response){
              console.log(response);
              location.reload();
          },
        error: function(jqXHR, textStatus, errorThrown) { 
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
    })
});

</script>
@endsection
