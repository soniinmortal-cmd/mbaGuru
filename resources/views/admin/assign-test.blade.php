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
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
        </div>
        <?php
            $test_id = request()->id;
        ?>
        <div class="container-fluid">
            <div class="row px-2 my-5">
                <form action="{{route('admin.assign-test')}}" method="GET">
                    <input class="form-group" type="text" name="search" placeholder="Search...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <div class="col-md-9 px-2">
                    <a class="btn btn-primary" href="{{route('admin.exportuser')}}" style="float:right;margin:1px;">Export Students</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"  style="float:right">Import</button>
                    <br><br>
                    <div class="card bg-white pt-3 px-1 display-box-data">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row px-2">  
                                </div>
                            </div>
                            <div class="col-md-12 ms-2 mt-5">
                                <table class="table w-90 border-0 rounded-2">
                                    <thead>
                                        <tr>
                                            <!-- <th>
                                                <label>
                                                    <input type="checkbox" id="select-all"data-testid="{{$test_id}}">Select All
                                                </label>
                                            </th> -->
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <!-- <td>
                                                <input type="checkbox" name="status" data-test="{{$test_id}}" value="{{$student->id}}" class="checkdata new{{$student->id}}" {{ isset($userdata) && ($userdata->user_id == $student->id) ? 'checked' : '' }}>
                                            </td> -->
                                             <td><a href="{{route('admin.assign-user',$student->id)}}">{{$student->name}}</a></td>
                                             <td> <a href="{{route('admin.assign-user',$student->id)}}">{{$student->email}}</a></td>
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
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Assign Product</h4>
        </div>
        <form action="{{route('admin.assignTestImport')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
            <a href="{{ asset('imagedata/assign-course-formate.xlsx') }}" style="float:right;" download>Download Formate</a>
            
            <input type="file" name="file" placeholder="">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script>
$(document).ready(function(){
    $('.checkdata').click(function(){
        var checkboxValue = $(this).val();
        var test_id = $(this).attr('data-test');
       //ajax
       $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        method: 'POST', 
        url: 'https://test.mbaguru.in/admin/assignUser',
        data: {
            'user_id': checkboxValue,
            'test_id': test_id
        },
          success: function(response){
              console.log(response);
          },
        error: function(jqXHR, textStatus, errorThrown) { 
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
    })
});

$(document).ready(function(){
    $('#select-all').click(function(){
        var test_id = $(this).attr('data-testid');
         console.log(test_id);
        // return false;
        $('input[type="checkbox"]').each(function(){
            $(this).prop('checked', true);
        });
        getAllCheckboxValues(test_id);
    });


    function getAllCheckboxValues(test_id) {
        var checkboxValues = []; 
        $('input[type="checkbox"]:checked').each(function(){
            checkboxValues.push($(this).val());
        });
        //ajax
        var array = checkboxValues;
        var filteredArray = array.filter(function(item) {
            return item !== "on";
        });
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        method: 'POST', 
        url: 'https://test.mbaguru.in/admin/saveAllUser',
        data: {
            'user_id': JSON.stringify(filteredArray),
            'test_id':test_id
        },
          success: function(response){
              console.log(response);
          },
        error: function(jqXHR, textStatus, errorThrown) { 
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      }); 
    }
});

// $(document).ready(function(){
//     $("#deselectAll").click(function(){
//         $("input[type='checkbox']").prop('checked', false);
//     });
// });
</script>
@endsection
