
@extends('admin_template')
@section('css')
@endsection
@section('content') 
    <div class="col-md-9" id="right-menu-bar">
       <?php
            $test_id = request()->id;
            $testtemp_id = request()->testtemp_id;
            //dd($testtemp_id);
        ?>
        <div id="topbar-right-menu" class="d-flex  px-2 my-3 justify-content-between align-items-center">
              @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
              @endif
              <h5 class="fw-bold text-capitalize">test</h5>
        </div>
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right;">Add Section</button>
        <div id="right-menu-bar" class="col-md-12">
            <div class="container-fluid">
                <label class=" w-100 btnInstruction"><a href="{{route('admin.instruction',['id'=>$test_id])}}">Instruction</a></label>
            </div>
            <?php
            $i= 1;
           
            ?>
            @if(isset($sections))
                @foreach($sections as $section)
                <?php
                 $j =1;
                 $totalQ = array();
                  $excelQs = DB::table('excel_questions')->where('test_id',$test_id)->where('section_name',$section->section_name)->get();
                 // dd($excelQs);
                  foreach($excelQs as $excelQ){
                      $totalQ[] =  $excelQ->id;
                  }
                 
                ?>
                    <div class="card">
                        <div class="container-fluid accordion1">
                            <label style="width:65%;">{{$section->section_name}}</label>
                            <span >{{count($totalQ)}}Questions</span>
                            <span >Minutes</span>
                            <span></span>
                            <span></span>
                            <a class="multi"  data-id ="{{$i}}" data-row="{{$section->id}}" data-value="{{$section->testtemp_id}}" data-val="{{$section->test_id}}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                            <a data-toggle="modal" data-target="#editModal" data-id ="{{$section->id}}" data-name ="{{$section->section_name}}" class="editsection">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                            <a href="{{route('admin.delete-section',$section->id)}}" onclick="return confirm('Are you sure you want to delete this section?');">
                               <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            <div class="multidiv{{$i}} panel"  style="display:none;">
                                <table class="table responsive" style="width:890px;">
                                    @foreach($excelQs as $ques)
                                    <tr>
                                        <td>{{$j}}</td>
                                       <td><a href="{{route('admin.deletequestion',$ques->id)}}"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                                       <td><a href="{{route('admin.editquestion',['urlid'=>$test_id,'id'=>$ques->id,'sr'=>$j])}}"><?= htmlspecialchars_decode($ques->question)?></a></td>
                                    </tr> 
                                    <?php
                                    $j++;
                                    ?>
                                    @endforeach
                                    
                                </table>
                                <!-- <h2>PAPER1</h2> -->
                            </div>
                        </div>  
                    </div>
                    <br/>
                     <?php
                 $i++;
                 ?>
                 @endforeach
                
            @endif
            <br/>
           
        </div>
    </div>
    
    <!-- set Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
           
           <form action="{{route('admin.add-section')}}" method="post" enctype="multipart/form-data">
             @csrf
             <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="row">
                   <div class="col-md-10">
                       <input type ="hidden" name ="test_id" value="{{$test_id}}">
                       <input type ="hidden" name ="testtemp_id" value="{{$testtemp_id}}">
                       <input type ="text" name="section_name" class="form-control" placeholder="Enter Section Name">  
                   </div>
                </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
            </form>
      </div>
    </div>
    <!-- endsetmodal -->
    <!-- edit set Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
           
           <form action="{{route('admin.edit-section')}}" method="post" enctype="multipart/form-data">
             @csrf
             <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="row">
                   <div class="col-md-10">
                       <input type ="hidden" name ="id" value="" class="rowid">
                       <input type ="text" name="section_name" class="form-control section_name"  value ="" placeholder="Enter Section Name">  
                   </div>
                </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
            </form>
      </div>
    </div>
    <!-- endsetmodal -->
@endsection
@section('script')
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('.editsection').click(function(){
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            $('.rowid').val(id);
            $('.section_name').val(name);
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.multi').click(function(){
            var key = $(this).attr('data-id');
            var slide = $('.multidiv'+key).toggle("slide");
            var dataval = $(this).attr('data-value');
            var testid = $(this).attr('data-val');
            var id = $(this).attr('data-row');
            if(key){
                $('.multiplechoice').click(function(){
                    var mul = $(this).attr('data-mul');
                    var nu = $(this).attr('data-nu');
                    var ess = $(this).attr('data-ess');
                    var fillblanks = $(this).attr('data-fill');
                    if(mul){
                        var url = "{{ route('admin.new-questionbuilder', [':id',':testid', ':testtemp_id', ':type']) }}";
                        url = url.replace(':id', id);
                          url = url.replace(':testid', testid);
                        url = url.replace(':testtemp_id', dataval);
                        url = url.replace(':type', mul);
                         window.location.href=url;
                    }else if(nu){
                           var url = "{{ route('admin.new-questionbuilder', [':id',':testid', ':testtemp_id', ':type']) }}";
                        url = url.replace(':id', id);
                          url = url.replace(':testid', testid);
                          url = url.replace(':testtemp_id', dataval);
                          url = url.replace(':type', nu);
                          window.location.href=url;
                    }else if(ess){  
                           var url = "{{ route('admin.new-questionbuilder', [':id',':testid', ':testtemp_id', ':type']) }}";
                        url = url.replace(':id', id);
                          url = url.replace(':testid', testid);
                          url = url.replace(':testtemp_id', dataval);
                          url = url.replace(':type', ess);
                         window.location.href=url;
                    }else if(fillblanks){  
                          var url = "{{ route('admin.new-questionbuilder', [':id',':testid', ':testtemp_id', ':type']) }}";
                          url = url.replace(':id', id);
                          url = url.replace(':testid', testid);
                          url = url.replace(':testtemp_id', dataval);
                          url = url.replace(':type', fillblanks);
                          window.location.href=url;
                    }
               });
            }
        });
    });
    </script>



