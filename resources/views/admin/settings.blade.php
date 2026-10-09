<style>
.quizsection {
  width:  255px;
  border: 1px solid #9e9e9e;
  padding: 14px;
  margin: -2px;
  float:left;
}
a {
    color: #2e3a59;
    text-decoration: none;
}

</style>
<div class="container-fluid">
  <div class="row pl-4" style=" padding-left:50px;">
    <h2 style="padding-top: 25px">Quiz Settings</h2>
    <p>Manage quiz settings and preferences</p>
    <div class="row">
      <h2>Advanced Features</h1>
      <p>Use advanced features to enhance your quiz</p>
      <div class="col-md-4 quizsection" style="float:left; margin-left:10px; height:112px;">
        <a href="#">
        <h3>Leaderboard</h3>
        <p class="css-1swykzw">Leaderboard allows learner to view the names and current scores of the leading competitors for the current quiz</p>
        </a>
      </div>
      <div class="col-md-4 quizsection" style="margin-left:10px; height: 112px">
        <a href="{{route('admin.duration',$id)}}">
        <h3>Duration Type</h3>
        <p class="css-1swykzw">Select duration type for your quiz</p>
        </a>
      </div>
      <div class="col-md-4 quizsection" style="margin-left:30px">
        <a href="#">
        <h3>Randomisation & Rules</h3>
        <p class="css-1swykzw">Randomise quiz questions or set up sections rules for your quiz</p>
        </a>
      </div>
    </div>
  </div>
</div>