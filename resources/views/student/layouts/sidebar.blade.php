<?php
$id =request()->id;
$sid =request()->sid;
$paperid =request()->paperid;
$courseid =request()->course_id;
$ro = request()->path();
$testid =request()->testid;
$sectionid =request()->sectionid;
$nextid =request()->nextid;
$section_name = request()->section_name;
$section_name = str_replace(' ', '%20', $section_name);
//dd($nextid);
?>
<?php if($ro == 'student/start-quize/'.$id.'/'.$paperid) { ?>
	<ul></ul>
<?php }elseif($ro == 'student/start-test/'.$id) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/all-question/'.$id) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/launchtest/'.$id) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/quiz_instructions/'.$id) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/stop-quiz/'.$sid.'/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/instructions/'.$id) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/data-quiz/'.$sid.'/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/quantitative-quiz/'.$sid.'/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/report/'.$sid.'/'.$id.'/'.$paperid) { ?>	
<ul></ul>	
<?php }elseif($ro == 'student/nmat-report/'.$id.'/'.$paperid.'/'.$nextid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/nmat-solution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/languagesolution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/logicalsolution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/solution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/datasolution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/qtsolution/'.$testid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/solution-question/'.$testid.'/'.$sectionid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/solution-instruction/'.$testid.'/'.$sectionid.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/verbal-resume/'.$id.'/'.$paperid) { ?>	
<ul></ul>

<?php } elseif($ro == 'student/section-quiz/'.$id.'/'.$paperid.'/'.$section_name) { ?>
 <ul></ul>
<?php }elseif($ro == 'student/next-section-quiz/'.$id.'/'.$paperid.'/'.$section_name) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/section-report/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/section-solution/'.$id.'/'.$paperid.'/'.$section_name) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/next-section-solution/'.$id.'/'.$paperid.'/'.$section_name) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/verbal-resume/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/stop-section-quiz/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/report-section-quiz/'.$id.'/'.$paperid) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/section-wise-solution/'.$id.'/'.$paperid.'/'.$section_name) { ?>	
<ul></ul>
<?php }elseif($ro == 'student/next-section-wise-solution/'.$id.'/'.$paperid.'/'.$section_name) { ?>	
<ul></ul>

<?php }elseif($ro == 'student/time_analysis/'.$testid.'/'.$paperid) { ?>	
  <ul></ul>	
<?php }elseif($ro == 'student/time_taken_plotting/'.$testid.'/'.$paperid) { ?>	
    <ul></ul>	

<?php }else{?>
<div class="col-md-3" id="left-menu-bar" >
<ul class="nav w-100">
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.dashboard') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-th-large" aria-hidden="true"></i>
				</span>
				<a class="nav-link text-dark" aria-current="page" href="{{route('student.dashboard')}}">Dashboard</a>
			</li>
			<!-- <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.studentcreation') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-graduation-cap" aria-hidden="true" ></i>


				</span>
				<a class="nav-link text-dark" href="{{route('student.propzone')}}" >Propzone</a> 
			</li> -->
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.accross-test') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-upload" aria-hidden="true"></i>


				</span>
				<a class="nav-link text-dark" href="{{route('student.accross-test')}}">Across AIRCAT Analysis</a>
			</li>
			<!-- <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.booking_detail') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-book" aria-hidden="true"></i>
				</span>
				<a class="nav-link text-dark" href="{{route('student.booking_detail')}}">Booking Detail</a>
			</li> -->
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.slot-booking') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-address-book-o" aria-hidden="true"></i>

				</span>
				<a class="nav-link text-dark" href="{{route('student.slot-booking')}}">Slot Booking</a>
			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.testtemplate') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-commenting-o" aria-hidden="true"></i>

				</span>
		
<a class="nav-link text-dark" href="{{ route('student.logout') }}">Log Out</a>
</li>
</ul>
</div>

<!-- <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
        
          <li class="item">
            <div href="#" class="nav_link submenu_item {{ Route::is('student.dashboard') ? 'active' : '' }}">
              <span class="navlink_icon">
                <i class='bx bxs-dashboard'></i>
              </span>
              <span class="navlink">
                  <a href="{{route('student.dashboard')}}">Dashboard</a>
            </span>
             
            </div>
          </li>
          
          <li class="item {{ Route::is('student.studentcreation') ? 'active' : '' }}">
            <div href="#" class="nav_link submenu_item ">
              <span class="navlink_icon">
                <i class='bx bxs-graduation'></i> 

              </span>
              <span class="navlink">
              <a href="{{route('student.propzone')}}" >Propzone</a>
                  
              </span>
              
            </div>

           </li>
           <li class="item">
            <div href="#" class="nav_link submenu_item  {{ Route::is('student.test-analytics') ? 'active' : '' }}">
              <span class="navlink_icon">
                <i class='bx bxs-objects-vertical-bottom' ></i>
             </span>
              <span class="navlink">
                  <a href="{{route('student.test-analytics')}}">Test Analytics</a>
              </span>
              
            </div>

           </li>
          
           <li class="item">
            <div href="#" class="nav_link submenu_item {{ Route::is('student.slot-booking') ? 'active' : '' }}">
              <span class="navlink_icon">
              <i class='bx bx-bookmark-plus'></i>
              </span>
              <span class="navlink">
                  <a href="{{route('student.slot-booking')}}">Slot Booking Option</a>
            </span>
              
            </div>

           </li>
           <li class="item">
            <div href="#" class="nav_link submenu_item {{ Route::is('student.testtemplate') ? 'active' : '' }}">
              <span class="navlink_icon">
                <i class='bx bx-log-out'></i>
              </span>
              <span class="navlink">
                  <a href="{{ route('student.logout') }}">Log Out</a>
              </span>
              
            </div>

           </li>
          
        </ul>
      </div>
    </nav> -->
    
<?php }?>

<script type="text/javascript" src="{{asset('assets/admin/js/navbar.js')}}"></script>