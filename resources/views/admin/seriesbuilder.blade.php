@extends('admin_template')
@section('content')
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
<?php
 $id =request()->id;
 $tests = DB::table('tests')->where('id',$id)->first();
 $testname = $tests->test.$tests->testincid;
?>
    <div class="col-md-9" id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-2 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">{{$series->title}}|{{$series->setname}}|{{$series->test}}{{$series->testincid}}</h5>
        </div>
        <div class="form">
            <form action="{{route('admin.save-series-builder')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="test_id" value="{{$id}}">
                <div class="row">
                    <div class="showtable">
                        <legend>TEST:</legend>
                        <!-- <p class="title">Test</p> -->
                        <table class="table">
                            <thead>
                                <tr id="">
                                    <th class="">No Of Questions</th>
                                    <th class="">Duration</th>
                                    <th class="">Total Marks</th>
                                    <th class="">Status</th>
                                    <th class="">Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="">
                                    <td>100</td>
                                    <td>180</td>
                                    <td>300.0</td>
                                    <td>Published</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>   
                <div class="testcreate">
                    <legend>CREATE TEST:</legend>
                    <!-- <p class="title">CREATE TEST</p> -->
                    <div class="row">
                        <div class="col-md-6 form-contol">
                            <label for="text">Title:</label>
                            <input type="text" class="form-control" placeholder="Enter test" name="title" value="{{$testname}}">
                        </div>
                        <div class="col-md-6 form-contol">
                            <label for="text">Test Tag:</label>
                            <select  class="form-control"  name="test_tag">
                                <option>--SELECT--</option>
                                <option value="1">DATA INTERPRETATION AND LOGICAL REASONING</option>
                                <option value="2">VERBAL ABILITY AND READING COMPREHENSION</option>
                                <option value="3">QUANTITATIVE ABILITY</option>
                                <option value="4">Quantitative Skills</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-contol">
                            <legend>Test Type:</legend>
                            <label for="trail">Trail</label>
                            <input type="radio" name="test_type" id="trail" value="trail" checked >
                            <label for="female">Paid</label>
                            <input type="radio" name="test_type" id="paid" value="paid">
                        </div>
                        <div class="col-md-6 form-contol">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea6">Short description</label>
                                <textarea class="form-control z-depth-1" name="s_description" id="exampleFormControlTextarea6" rows="3" placeholder="Write a short lesson description" name="short_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-contol">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea6">Long description</label>
                                <textarea cols="10" id="editor5" name="l_description" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lession">
                    <legend>LESSON THUMBNAIL:</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <input name="lession_thumb" id="fuUpload1" type="file" multiple="multiple" />
                            <!-- <button id="btn-file-reset-id" type="button">Reset file</button> -->
                            <div id="dvPreview"></div>
                        </div>
                    </div>
                </div>
                <div class="lessionurl">
                    <legend>LESSON URL:</legend>
                    <div class="row">
                        <h6>Copy and use lesson URL anywhere in the school to embed as content.</h6>
                        <p>Lesson URL can be copied and used within Curriculum, Newsfeeds and Community posts.</p>
                        <div class="col-md-6">
                            <div id="textToCopy"><input type="text"name="lession_url" value="">test</div>
                            <!-- <input type ="hidden" name="copy" value="test" id=""> -->
                            <button id="copyButton" class="btn btn-primary">Click to copy</button> 
                            <span id="copyResult"></span>
                        </div>
                    </div>
                </div>
                <legend></legend>
                <div class="attachment">
                    <legend>ATTACHMENTS:</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="file" class="form-control" name="attachments">
                        </div>
                        <div class="col-md-4">
                            <!--start-->
                            <!-- <button type="button" class="btn btn-primary lr-small-btn-template lr-btn-create-lesson lesson-attachment-disable" data-toggle="modal" data-target="#urlmodal">Upload Form URL</button>
                            <div class="modal fade" id="urlmodal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title mx-auto">External Link</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Provide public file storage URL like Amazon S3, Dropbox.</p>
                                            <label for="text">URL:</label>
                                            <input name="urlupload"  type="text" class="form-control" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">submit</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <label for="text">UPLOAD FORM URL:</label>
                            <input type="text"name="form_url" value="">
                            <!--end-->
                        </div>
                        <div class="col-md-4">
                            <!-- <button type="button" class="btn btn-primary lr-small-btn-template lr-btn-create-lesson lesson-attachment-disable" data-toggle="modal" data-target="#addlink">Add Link</button>
                            <div class="modal fade" id="addlink" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title mx-auto">Add Link</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Provide link for the attachment.</p>
                                            <label for="text">URL:</label>
                                            <input name="addlink"  type="text" class="form-control" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">submit</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <label for="text">ADD LINK:</label>
                            <input type="text"name="add_link" value="">
                        </div>
                    </div>
                    <div class="row">
                    <legend></legend>
                    </div>
                </div>
                <div class="saveform">
                    <button type ="submit" class="btn btn-primary">Submit</button> 
                </div>
            </form>
        </div>
    </div>   
@endsection
@section('script')
<script>
    CKEDITOR.replace('editor5', {
      fullPage: true,
      extraPlugins: 'docprops',
      // Disable content filtering because if you use full page mode, you probably
      // want to  freely enter any HTML content in source mode without any limitations.
      allowedContent: true,
      height: 320,
      removeButtons: 'PasteFromWord'
    });
  </script>
  <script type="text/javascript">
    $(function () {
        $('[id*=fuUpload1]').change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("[id*=dvPreview]");
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                $($(this)[0].files).each(function () {
                    var file = $(this);
                   // console.log(regex.test(file[0].name.toLowerCase()));
                    //return false;
                    //if (regex.test(file[0].name.toLowerCase())) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "max-height:250px;width: 150px");
                            img.attr("src", e.target.result);
                            var div = $("<div style='float:left;' />");
                            $(div).html("<span style='float:right;' class='closeDiv'>X<span>");
                            div.append(img);

                            dvPreview.append(div);
                        }
                        reader.readAsDataURL(file[0]);
                    //} else {
                        // alert(file[0].name + " is not a valid image file.");
                        // dvPreview.html("");
                        // return false;
                    //}
                });
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        });

        $('body').on('click', '.closeDiv', function () {
            $(this).closest('div').remove();
        });
    });
</script>
<script>
const answer = document.getElementById("copyResult");
const copy   = document.getElementById("copyButton");
const selection = window.getSelection();
const range = document.createRange();
const textToCopy = document.getElementById("textToCopy")
copy.addEventListener('click', function(e) {
    range.selectNodeContents(textToCopy);
    selection.removeAllRanges();
    selection.addRange(range);
    const successful = document.execCommand('copy');
    if(successful){
      answer.innerHTML = 'Copied!';
    } else {
      answer.innerHTML = 'Unable to copy!';  
    }
    window.getSelection().removeAllRanges()
});
</script>
@endsection


    

