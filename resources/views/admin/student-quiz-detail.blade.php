@extends('admin_template')

@section('css')
@endsection
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/css/tableexport.min.css">
    <div class="col-md-9 bg-light py-3 " id="right-menu-bar">
        
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">Students Quiz Detail</h5>
        </div>

        <div class="container-fluid">
            <div class="row px-2 my-5">
                <div class="col-md-12 col-md-12 px-2 py-1 my-0 rounded-1 mx-2 text-white" id="Across-tests" style=""> </div>
                <div class="col-md-9 px-2">
                    <div class="card bg-white pt-3 px-1 display-box-data">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row px-2">
                                  
                                </div>
                            </div>
                            <div class="col-md-12 ms-2 mt-5">
                                 <button id="exportButton">Export to Excel</button>
                                <table class="table w-90 border-0 rounded-2" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>SR.</th>
                                            <th>Student</th>
                                            <th>Test Name</th>
                                            <th>Question No.</th>s
                                            <th>Section Name</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =1; ?>
                                        @foreach($halfquizes as $report)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$report->email}}</td>
                                            <td>{{ !empty($report->test) ? $report->test : ' ' }}</td>
                                            <td>{{$report->sr_no}}</td>
                                            <td>{{$report->section_name}}</td>
                                            <td>{{$report->answer}}</td>
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

 <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include SheetJS (xlsx) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#exportButton').click(function(){
                console.log("Export button clicked");
                var wb = XLSX.utils.table_to_book(document.getElementById('myTable'), {sheet: "Sheet1"});
                XLSX.writeFile(wb, 'export.xlsx');
                console.log("Export function executed");
            });
        });
    </script>


