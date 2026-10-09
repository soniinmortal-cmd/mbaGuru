@extends('admin_template')
@section('content') 
<div class="col-md-9" id="right-menu-bar">
  <?php
    //echo 'VERBAL ABILITY AND READING'; 
  // dd($questions); 
  ?>
  @foreach($questions as $question)
  <?php
  //dd($question)
  ?>
  @if($question->paper_type == 'multiple')
  <ol class="quiz">
    <li>
      <span  id="question"><?= strip_tags($question->question)?></span>
      <ol class="choices">
        <li>
            <label>
              <span>ANS2</span>
            </label>
        </li>
        <li>
            <label>
              <span>Ans1</span>
            </label>
        </li>
        <li>
            <label>
              <span>ANS3</span>
            </label>
        </li>
        <li>
            <label>
              <span>ANS4</span>
            </label>
        </li>
      </ol>
    </li>
    <!-- <li>
      <span  id="question">How many letters are there in "JS"?</span>
      <ol class="choices">
        <li>
            <label>
              <span>ANS2</span>
            </label>
        </li>
        <li>
            <label>
              <span>Ans1</span>
            </label>
        </li>
        <li>
            <label>
              <span>ANS3</span>
            </label>
        </li>
        <li>
            <label>
              <span>ANS4</span>
            </label>
        </li>
      </ol>
    </li> -->
  </ol>
  @endif
  @endforeach
</div>

@endsection
@section('script')
@endsection