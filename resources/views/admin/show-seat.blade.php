@extends('admin_template')

@section('css')
@endsection

@section('content')
    <div class="col-md-9 bg-light py-3 " id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">Slot Booking</h5>
             @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
               @endif
            <a href="{{ route('admin.slot-booking') }}" class="btn btn-danger">Add Seat</a>

        </div>
        <div class="container-fluid">
            <div class="row px-2 my-5">
                <div class="col-md-12 col-md-12 px-2 py-1 my-0 rounded-1 mx-2 text-white" id="Across-tests" style="">
                    Show Seat
                </div>
                <div class="col-md-11 px-2">
                    <div class="card bg-white pt-3 px-1 display-box-data" style="max-width:950px; max-height:900px; overflow:scroll;">
                        <div class="row mt-3">
                            <div class="col-md-12 ms-2 mt-5">
                                <table class="table w-90 border-0 rounded-2" >
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Test Name</th>
                                            <th>Center Name</th>
                                            <th>Seats</th>
                                            <th>Date</th>
                                            <!-- <th>To Date</th> -->
                                            <th>Time</th>
                                            <th></th>
                                             <th></th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($seats as $seat)
                                        <tr>
                                            <td>{{$seat->title}}</td>
                                            <td>{{$seat->test}}</td>
                                            <td>{{$seat->centername}}</td>
                                            <td>{{$seat->seats}}</td>
                                            <td>{{$seat->from_date}}</td>
                                            <!-- <td>{{$seat->to_date}}</td> -->
                                           <?php
                                            $from_times = explode(',',$seat->from_time);
                                            $to_times =  explode(',',$seat->to_time);
                                            foreach($from_times as $key1=> $from_time){
                                            foreach($to_times as $key2=> $to_time){
                                                if($key1 == $key2){
                                            ?>

                                            <td>{{$from_time}}-{{$to_time}}</td>
                                            <?php } ?>
                                            <?php } ?>
                                            <?php } ?>
                                            <td>
                                                <a href="{{ route('admin.edit-seat',$seat->id) }}" class="btn btn-primary">Edit</a>

                                                <a href="{{ route('admin.delete-seat',$seat->id) }}" class="btn btn-danger">Delete</a>
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
@endsection
