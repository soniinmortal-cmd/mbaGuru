@extends('admin_template')
     @section('content') 
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <div class="col-md-9" id="right-menu-bar">
               <div id="topbar-right-menu">
                    <div class="row">
                        <div class="col-xl-4">
                            <?php
                                $id=  request()->id;
                                $userid=  request()->userid;
                                $tests = DB::table('tests')->where('id',$id)->first();
                                $users = DB::table('studentlogs')->where('id',$userid)->first();
                            ?>
                             <h4 style="font-weight:bold">{{$users->email}}/{{$tests->test}}</h4>
                            <!-- <h5 style="font-weight:bold"></h5> -->

                           

                        </div>
                        <div class="col-xl-6"></div>
                        <div  class="col-xl-2" style="text-align:right; margin-top:30px;">
                            <!-- <a href="{{route('admin.student-report',$id)}}" class="btn btn-primary">
                            Student Report</a> -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Section Name:</label>
                                <select class="form-control" name ="section_name" id="section-dropdown" data-testid = "{{$id}}" data-user="{{$userid}}">
                                    <option>Select Section</option>
                                    <option value="verbal">Verbal and Reading Comprehension</option>
                                 <option value="data">Data Interpretation & Logical Reasoning</option>
                                    <option value="quantitative">Quantitative Aptitude</option>
                                    <!-- <option value="overall">All sections</option> -->
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row col-10">
                        <table class="table table-bordered mytable">
                            <thead>
                                <tr>
                                    <th>Question No.</th>
                                    <th>Student Answer</th>
                                </tr>
                            </thead>
                            <tbody class="mytable">
                              
                            </tbody>
                        </table>
                    </div>
               </div>
          </div>
    @endsection
@section('script')
<script>
    $('#section-dropdown').on('change', function () {
        var section_name = this.value;
        var id = $(this).attr('data-testid');
        var userid = $(this).attr('data-user');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url: "{{route('admin.fetch-question')}}",
            type: "POST",
            data: {
                section_name: section_name,
                id: id,
                userid: userid
            },
            dataType: 'json',
            success: function (result) {
              $('.mytable').empty().append(result.var_1);
            }
        });
    })
</script>
@endsection