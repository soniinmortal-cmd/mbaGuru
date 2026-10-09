@extends('admin_template')
     @section('content') 
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
   $id = request()->id;
   ?>
          <div class="col-md-9" id="right-menu-bar">
               <div id="topbar-right-menu">
                    <div class="row">
                        <div class="col-xl-4">
                            <!--<h1 style="font-weight:bold">Center</h1>-->
                          
                             @if(Session::has('message'))
                              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                        </div>
                        <div class="col-xl-6"></div>
                        <div  class="col-xl-2" style="text-align:right; margin-top:30px;">
                            <a href="{{route('admin.cerate-test-pdf',$id)}}" class="btn btn-danger btncolor">CREATE</a>
                        </div>
                    </div>
                    
                    <div class="row col-10">
                        <table class="table table-bordered">
                                <tr>
                                  <th>SR.</th>
                                   <th>PDF NAME</th>
                                    <th>PDF</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                    $i=1;
                                ?>
                               @foreach($pdfs as $pdf)
                                    <tr>
                                        <td>{{$i++}}</td>
                                         <td>{{$pdf->pdf_name}}</td>
                                       @if(!empty($pdf))
                                        <td>{{$pdf->file}}</td>
                                        <td>
                                            <!--<a href="{{route('admin.edit-test-pdf',$pdf->id)}}" class="btn btn-primary btncolor mx-2" style="float:left;">Edit</a>-->
                                            <a href="{{route('admin.delete-test-pdf',$pdf->id)}}" class="btn btn-danger btncolor" style="float:left;">Delete</a>
                                        </td>
                                          @endif
                                    </tr>
                                  @endforeach
                              
                        </table>
                    </div>
               </div>
          </div>
     @endsection
@section('script')
@endsection