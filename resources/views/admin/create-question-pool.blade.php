@extends('admin_template')
    @section('content') 
        <div class="col-md-9" id="right-menu-bar">
            <form action="{{route('admin.savequestionpool')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="topbar-right-menu">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn" style="width:120px">
                            <i class='fas fa-angle-double-left' style='padding-top:10px; float:left'></i><h4>BACK</h4>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h3>Create Question Pool</h3>
                        <h6>Start creating a New Question Pool</h6>
                    </div>
                </div>
                <div class="row" STYLE="margin-top:10px;">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title" style="margin-bottom:-20px; margin-left:10px;">
                            <h4>Title*</h4>
                            </label>
                            <input class="form-control" type="text" name="title" value="" placeholder="Enter Question Pool Title"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btncolor">CREATE</button>
                        <button type="button" class="btn btn-default">CANCEL</button>
                    </div>
                </div>
            </div>  
            </form>     
        </div>
     @endsection
@section('script')
@endsection