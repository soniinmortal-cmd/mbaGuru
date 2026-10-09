@extends('student_template')

@section('css')
@endsection
@section('content')
<?php
$id = request()->id;

?>
<div class="col-md-12 bg-light py-3 " id="right-menu-bar">
        <div class="container">
            <div class="row px-2 my-5">
                <div class="col-md-2"></div>
                <div class="col-md-8 px-1">
                    <div class="card bg-white py-4 px-2 display-box-data">
                        <table class="table w-100 text-center">
                            <thead>
                                <tr>
                                    <th>Test</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sets as $set)
                            
                                <tr class="border-transparent" style="border: transparent!important;">
                                    <td>{{$set->setname}}</td>
                                    
                                     <td><a href="{{route('student.start-test',['id' => $set->id, 'course_id' => $id])}}" class="btn py-1" id="Launch-test-btn">Start Test</a></td>
                                    </tr>
                                    @endforeach
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
               <!-- <div class="col-md-4 px-1">
                    <div class="card bg-white py-4 px-2 display-box-data">
                        <table class="table w-100">
                            <thead>
                                <tr id="thead">
                                    <th class="w-50">News</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border: transparent!important;">
                                    <td>No Record</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
@endsection
@section('css') 
@endsection

