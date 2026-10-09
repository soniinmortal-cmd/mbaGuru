@extends('student_template')
@section('css')
@endsection
@section('content')
    <div class="col-md-9 bg-light py-3" id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h6 class="fw-bold ">Your booked slot</h6>
        </div>
        <div class="container">
            <?php
              $userid =session()->get('id');
            ?>
            <div class="row px-2 my-5">
                <!-- <div class="col-md-12 col-md-12 px-2 py-1 my-0 rounded-1 mx-2 text-white" id="Across-tests">
                    Booking Detail
                </div> -->
                <div class="col-md-12 px-2">
                    <div class="card bg-white pt-3 px-1 display-box-data">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row px-2"></div>
                            </div>
                            <div class="col-md-12 ms-2 mt-5">
                                <table class="table w-90 border-0 rounded-2">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Test Name</th>
                                            <th>Center Name</th>
                                            <th>Test Date</th>
                                            <th>Test Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($reports as $report)
                                        <?php
                                         $userreports = DB::table('student_quizes')
                                                       ->where('test_id',$report->test_id)
                                                       ->get();
                                            $userd= array();
                                            foreach($userreports as $userreport)
                                            {
                                                $userd[] = $userreport->user_id;
                                                
                                            }
                                        ?>
                                        @if (!in_array($userid, $userd))
                                        <?php
                                            $bDate = $report->booking_date;
                                            $formatted_booking_date = date("d-m-Y", strtotime($bDate));
                                        ?>
                                        <tr>
                                            <td>{{$report->title}}</td>
                                            <td>{{$report->test}}</td>
                                            <td>{{$report->centername}}</td>
                                            <td>{{$formatted_booking_date}}</td>
                                            <td>{{$report->booking_time}}</td>
                                        </tr>
                                         @endif
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
@endsection
