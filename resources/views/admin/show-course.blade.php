@extends('admin_template')
     @section('content') 
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <div class="col-md-9" id="right-menu-bar">
               <div id="topbar-right-menu">
                    <div class="row">
                        <div class="col-xl-4">
                            <h4 style="font-weight:bold">ALL COURSE</h4>
                           
                        </div>
                        <div class="col-xl-6"></div>
                        <div  class="col-xl-2" style="text-align:right; margin-top:30px;">
                           
                        </div>
                    </div>
                    
                    <div class="row col-10">
                        <table class="table table-bordered">
                            <!-- <thead> -->
                                <tr>
                                    <th>SR.</th>
                                    <th>Title</th>
                                </tr>
                                <?php
                                $i=1;
                                ?>
                                @foreach($courses as $course)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><a href="{{route('admin.showtest',$course->id)}}" class="">{{$course->title}}</a></td> 
                                </tr>
                                @endforeach
                            <!-- </tbody> -->
                        </table>
                    </div>
               </div>
          </div>
     @endsection
@section('script')
@endsection