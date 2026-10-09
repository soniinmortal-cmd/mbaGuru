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
                                $tests = DB::table('tests')->where('id',$id)->first();
                            ?>
                            <h4 style="font-weight:bold;margin-left:12px;">{{$tests->test}}</h4>
                        </div>
                        <div class="col-xl-6">
                            <a href="{{ route('admin.student-excel-report',$id) }}" class="btn btn-primary" style="float:right;margin-top:14px;">Download</a>
                        </div>
                        <div class = "col-xl-2" style="text-align:right; margin-top:30px;"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Section Name:</label>
                                <select class="form-control" name ="section_name" id= "section-dropdown" data-testid = "{{$id}}">
                                    <option>Select Section</option>
                                    <option value="verbal">Verbal and Reading Comprehension</option>
                                    <option value="data">Data Interpretation & Logical Reasoning</option>
                                    <option value="quantitative">Quantitative Aptitude</option>
                                    <option value="overall">All Sections</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row col-10">
                        <table class="table table-bordered" style="margin:11px;">
                            <thead>
                                <tr>
                                    <th>SR.</th>
                                    <th>Email</th>
                                    <th>Total Questions</th>
                                    <th>Attempt</th>
                                    <th>Missed</th>
                                    <th>Correct</th>
                                    <th>InCorrect</th>
                                    <th>Score</th>
                                    <th>Percentage%</th>
                                    <th>Time Taken(sec)</th>
                                </tr>
                            </thead>  
                            <tbody class="mytable"></tbody>
                        </table>
                    </div>
               </div>
          </div>
    @endsection
@section('script')
<script>
    $('#section-dropdown').on('change', function () {
        $('.mytable').empty(); 
        var section_name = this.value;
        var id = $(this).attr('data-testid');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url: "{{route('admin.fetch-report')}}",
            type: "POST",
            data: {
                section_name: section_name,
                id: id
            },
            dataType: 'json',
            success: function (result) {
              $('.mytable').append(result.var_1);
            }
        });
    })
</script>
@endsection