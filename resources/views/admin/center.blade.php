@extends('admin_template')
     @section('content') 
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <div class="col-md-9" id="right-menu-bar">
               <div id="topbar-right-menu">
                    <div class="row">
                        <div class="col-xl-4">
                            <h1 style="font-weight:bold">Center</h1>
                            <!-- <h5>Create And Manage Question Pools</h5> -->
                             @if(Session::has('message'))
                              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                        </div>
                        <div class="col-xl-6"></div>
                        <div  class="col-xl-2" style="text-align:right; margin-top:30px;">
                            <a href="{{route('admin.create-center')}}" class="btn btn-danger btncolor">CREATE</a>
                        </div>
                    </div>
                    
                    <div class="row col-10">
                        <table class="table table-bordered">
                            <!-- <thead> -->
                                <tr>
                                    <th>SR.</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $i=1;
                                ?>
                                @foreach($centers as $center)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$center->centername}}</td>
                                    <td>
                                        <a href="{{route('admin.edit-center',$center->id)}}" class="btn btn-primary btncolor mx-2" style="float:left;">Edit</a>
                                        <a href="{{route('admin.delete-center',$center->id)}}" class="btn btn-danger btncolor" style="float:left;">Delete</a>&nbsp;&nbsp;
                                    </td>
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