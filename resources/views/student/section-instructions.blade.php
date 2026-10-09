<html>
    <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
  <style>
     .scroll
  {
    float:left; 
    height:590px;
    overflow-x:scroll;
  }
  .btneditor
  {
    margin-left:670px; 
    margin-top:30px; 
    position:absolute; 
}


  </style>
    </head>
    <body>
      <div class="container" style=" border: 2px solid black;border-radius: 10px; margin-top: 20px;padding: 10px 10px;margin-bottom:12px;">
        <div class="instruction">
        <?php
        $id =request()->id;
        $ins = DB::table('instruction')->where('test_id',$id)->orderBy('id', 'DESC')->first(); 
        $testins = DB::table('test_sections')->where('test_id',$id)->orderBy('id', 'Asc')->first(); 
        $excel_questions = DB::table('excel_questions')
                        ->where('test_id',$id)
                        ->get();
                        
        foreach($excel_questions as $excel_question)
        {
            $section_name[] =   $excel_question->section_name;
        }
        $sectionArray = array_unique($section_name);
$search_terms = [
    'verbal' => 'verbal',
    'data' => 'data',
    'quantitative' => 'quantitative'
];


$result = [];
foreach ($search_terms as $key => $term) {
    foreach ($sectionArray as $value) {
        if (stripos($value, $term) !== false) {
            $result[] = $key; 
            break; 
        }
    }
}

    $result_string = implode(', ', $result);
    $exploded_array = explode(', ', $result_string);

        ?>
        <div class="col-md-12">       
                <h3 style="background-color:maroon; color:white; padding:10px 10px;border-radius: 10px;">INSTRUCTIONS</h3>
                
                @if(!empty($ins))
                    <?= htmlspecialchars_decode($ins->instruction) ?>
                    @else
                     <div id="heading"> <h3>General Instructions</h3></div>
                    1. The clock has been set on the server and countdown timer at top right corner of your screen will display the remaining time for you to complete the exam. When the clock runs out the exams ends by default- you are not required to end or submit your exam

                    2. The questions palette at the right of screen shows one of the following status of each of the questions numbered

                    15
                    You have not visited the question yet

                    15
                    You have not answered the question

                    15
                    You have answered the question

                    15
                    You have NOT answered the question but have marked the question for review

                    15
                    You have answered the question but marked it for review

                    The Marked for Review status simply acts as a reminder that you have set to look at the question again. If an answer is selected for a question that is Marked for Review, the answer will be considered in the final evaluation

                    <div id="heading"><h3>Navigation to a question</h3></div>
                    3. To select a question to answer, you can do one of the following:

                    Click on the question number on the question palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question

                    Click on Save and Next to save answer to current question, mark it for review, and to go to the next question in sequence

                    Click on Mark for Review and Next to save answer to current question

                    4. You can view the entire paper by clicking on the All Questions button

                    <div id="heading"><h3>Answering question</h3>
                    5. For multiple choice type question

                    a. To select your answer, click on one of the option buttons

                    b. To change your answer, click the another desired option button

                    c. To save your answer, you MUST click on save

                    d. To deselect a chosen answer, click on the chosen option again or click on the Clear Response button

                    e. To mark a question for review click on Mark for Review & Next If an answer is selected for a question that is Marked for Review, the answer will be considered in the final evaluation

                    6. To change an answer to a question, first select the question and then click on the new answer option followed by a click on the save button

                    7. Questions that are saved or marked for review after answering will ONLY be considered for evaluation

                    8. If quiz is paused, quiz can be continued from where left off within scheduled time

                    <div id="heading"><h3>Navigation through sections</h3></div>
                    9. Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by clicking on the section name. The section you are currently viewing is highlighted

                    10. After clicking the save button on the last question for a section,you will automatically be taken to the first question of the next section

                    11. You can move the mouse cursor over the section names to view the status of the questions for that section

                    12. You can shuffle between sections and questions anytime during the examination as per your convenience
                    @endif
                    <br/>
                    <?php
                        $userid =session()->get('id');
                        $paperid = rand(10,100);

                    ?>
                    <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                    <input type="hidden" name="test_id" class="testid" value="{{$id}}">
                    <input type="hidden" name="user_id" class="userid" value="{{$userid}}">
                    <input type="hidden" name="paper_id" class="paperid" value="{{$paperid}}">
                   
                         <a href ="{{route('student.section-quiz',['id'=>$id, 'paperid'=>$paperid,'section_name'=>$testins->section_name])}}" class="btn btn-primary btn-md submitpaper starttest mb-3">Start Test</a>
                    
        </div>  
        </div>
        </div>
</div>
<script>
    CKEDITOR.replace('editor4', {
    fullPage: true,
    extraPlugins: 'docprops',
    // Disable content filtering because if you use full page mode, you probably
    // want to  freely enter any HTML content in source mode without any limitations.
    allowedContent: true,
    height: 520,
    WIDTH:200,
    removeButtons: 'PasteFromWord'
    });
</script>
<script>
    $(document).ready(function(){

        $('.submitpaper').click(function (){
                var url1 = '{{route("student.savepaper")}}';
                var test_id =  $('.testid').val();
                var user_id =  $('.userid').val();
                var paper_id =  $('.paperid').val();
            $.ajax({
               url: url1,
               type: "POST",
               data: {
                   _token: $("#csrf").val(),
                   test_id: test_id,
                   user_id: user_id,
                   paper_id: paper_id
                 },
                 cache: false,
               success: function(dataResult){
                 console.log(dataResult);
                 var dataResult = JSON.parse(dataResult);
                 if(dataResult.statusCode==200){
                    //return false;
                   //location.reload(true);       
                 }
                 else if(dataResult.statusCode==201){
                   alert("Error occured !");
                 }
                }
            });
        });
    });
</script>

<script>
$(document).ready(function() {
    $('.starttest').click(function(){
        localStorage.clear();
    });
});
</script>
    </body>
</html>