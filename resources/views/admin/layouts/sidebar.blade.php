<!-- <div class="col-md-3 d-flex justify-content-center" id="left-menu-bar"> -->
<?php
 $testtemp_id =request()->testtemp_id;
       $test_id =request()->test_id;
 $id =request()->id;
    $ro = request()->path();
   if($ro == 'admin/newtest/'.$id) { ?>
    <ul class="nav mt-4 flex-column col-md-3 " >
        <h4><b>SERIES MAKER</b></h4>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <button type="button" class="nav-link1" data-toggle="modal" data-target="#myModal" >Add Set</button>
        </li>
        <h4><b>Tests</b></h4>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <button type="button" class="nav-link1" data-toggle="modal" data-target="#myModal1">Add New Test</button>
        </li>
    </ul> 
   <?php  } else if($ro == 'admin/testbuilder/'.$id) { ?>
    <div class="navHeading col-md-3">
            <p class="heading">QUIZ MAKER</p>
            <ul class="headingLeft">
                <p class="content">Questions</p>
                <li><button class="subheading multiplechoice"  data-mul="multiple">MULTIPLE CHOICE</button></li>
                <li><button class="subheading multiplechoice"  data-nu="numerical">NUMERICAL</button></li>
                <li><button class="subheading multiplechoice"  data-ess="essay">ESSAY</button></li>
                <li><button class="subheading multiplechoice"  data-fill="fill_in_the_blanks">FILL IN THE BLANKS</button></li>
                 <p class="content">Other Options</p>
                <li><button class="subheading"><a href="{{ route('admin.importwordexcel',$id) }}">IMPORT</a></button></li>
                <li><button class="subheading"><a href="{{ route('admin.duration',$id) }}">SETTING</a></button></li>
                <li><button class="subheading"><a href="{{ route('admin.publishstatus',$id) }}">PUBLISH STATUS</a></button></li>
            </ul>
            
        </div>
        
          <?php  } else if($ro == 'admin/new-testbuilder/'.$id.'/'.$testtemp_id) { ?>
        <div class="navHeading col-md-3">
            <p class="heading">QUIZ MAKER</p>
            <ul class="headingLeft">
                <p class="content">Questions</p>
                <li><button class="subheading multiplechoice"  data-mul="multiple">MULTIPLE CHOICE</button></li>
                <li><button class="subheading multiplechoice"  data-nu="numerical">NUMERICAL</button></li>
                <li><button class="subheading multiplechoice"  data-ess="essay">ESSAY</button></li>
                <li><button class="subheading multiplechoice"  data-fill="fill_in_the_blanks">FILL IN THE BLANKS</button></li>
                 <p class="content">Other Options</p>
                <li><button class="subheading"><a href="{{ route('admin.importwordexcel',$id) }}">IMPORT</a></button></li>
                <li><button class="subheading"><a href="{{ route('admin.duration',$id) }}">SETTING</a></button></li>
                <li><button class="subheading"><a href="{{ route('admin.publishstatus',$id) }}">PUBLISH STATUS</a></button></li>
            </ul>
            
        </div>
        
   <?php  } else if($ro == 'admin/importwordexcel/'.$id) { ?>
    <ul>
   </ul>
   <?php }else if($ro == 'admin/publishstatus/'.$id){ ?>
   <ul></ul>
   <?php }else if($ro == 'admin/seriesbuilder/'.$id){ ?>
    <ul></ul>
    <?php }else if($ro == 'admin/preview/'.$id){ ?>
        <ul></ul>
     <?php }else if($ro == 'admin/duration/'.$id){ ?>
        <ul class="nav flex-column mt-5 col-md-3">
            <!--<li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.dashboard') ? 'active' : '' }}">-->
            <!--    <a class="nav-link  text-dark" aria-current="page" href="{{ route('admin.dashboard') }}">Leaderboard</a>-->
            <!--</li>-->
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.duration',$id)}}">
                <a class="nav-link " href="{{ route('admin.duration',$id) }}">Duration Type</a>
            </li>
             <li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.maximum-attempt') ? 'active' : '' }}">
                <a class="nav-link  text-dark" aria-current="page" href="{{ route('admin.maximum-attempt',$id) }}">Maximum Attempt</a>
            </li>
            <!-- <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard')}}">-->
            <!--    <a class="nav-link " href="{{ route('admin.dashboard') }}">Randomisation & Rules</a>-->
            <!--</li>-->
            <!-- <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.assign-test')}}">
                <a class="nav-link " href="{{ route('admin.assign-test',$id) }}">Assign Test</a>
            </li> -->
          
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard')}}">
                <a class="nav-link " href="{{ route('admin.percentile-cutoff',$id) }}">Percentile Ranking</a>
            </li>
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.test-pdf',$id)}}">
                       <a class="nav-link " href="{{ route('admin.test-pdf',$id) }}">Upload Pdf</a>
             </li>
        </ul>
        <?php }else if($ro == 'admin/percentile-cutoff/'.$id){ ?>
        <ul class="nav flex-column col-md-3 mt-5">
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.duration',$id)}}">
                <a class="nav-link " href="{{ route('admin.duration',$id) }}">Duration Type</a>
            </li>
             <li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.maximum-attempt') ? 'active' : '' }}">
                <a class="nav-link  text-dark" aria-current="page" href="{{ route('admin.maximum-attempt',$id) }}">Maximum Attempt</a>
            </li>
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.percentile-cutoff')}}">
                <a class="nav-link " href="{{ route('admin.percentile-cutoff',$id) }}">Percentile Ranking</a>
            </li>
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.test-pdf',$id)}}">
                       <a class="nav-link " href="{{ route('admin.test-pdf',$id) }}">Upload Pdf</a>
             </li>
        </ul>
        
         <?php }else if($ro == 'admin/maximum-attempt/'.$id){ ?>
        <ul class="nav flex-column col-md-3 mt-5">
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.duration',$id)}}">
                <a class="nav-link " href="{{ route('admin.duration',$id) }}">Duration Type</a>
            </li>
            <li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.maximum-attempt') ? 'active' : '' }}">
                <a class="nav-link  text-dark" aria-current="page" href="{{ route('admin.maximum-attempt',$id) }}">Maximum Attempt</a>
            </li>
            <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard')}}">
                <a class="nav-link " href="{{ route('admin.percentile-cutoff',$id) }}">Percentile Ranking</a>
            </li>
             <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.test-pdf',$id)}}">
                       <a class="nav-link " href="{{ route('admin.test-pdf',$id) }}">Upload Pdf</a>
             </li>
        </ul>
        
         <?php }else if($ro == 'admin/test-pdf/'.$id){ ?>
            <ul class="nav flex-column col-md-3 mt-5">
                
                 <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.test-pdf',$id)}}">
                       <a class="nav-link " href="{{ route('admin.test-pdf',$id) }}">Upload Pdf</a>
                 </li>
                <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.duration',$id)}}">
                       <a class="nav-link " href="{{ route('admin.duration',$id) }}">Duration Type</a>
                </li>
                <li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.maximum-attempt') ? 'active' : '' }}">
                    <a class="nav-link  text-dark" aria-current="page" href="{{ route('admin.maximum-attempt',$id) }}">Maximum Attempt</a>
                </li>
                <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.dashboard')}}">
                    <a class="nav-link " href="{{ route('admin.percentile-cutoff',$id) }}">Percentile Ranking</a>
                </li>
            </ul>

        <?php }else if($ro == 'admin/student-excel-report/'.$id){ ?>
            <ul></ul>
        
    <?php } else { ?>
  <div class="col-md-3 flex-column float-left" id="left-menu-bar">

    <ul class="nav w-100">
        <li class="nav-item d-flex px-3  py-1 item-style {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <!--<span class="side-icon-menu bg-light">
                <i class="fa fa-th-large" aria-hidden="true"></i>
            </span>-->
            <a class="nav-link " aria-current="page" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.studentcreation') ? 'active' : '' }}">
            <!--<span class="side-icon-menu text-light">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            </span>-->
            <a class="nav-link " href="{{ route('admin.studentcreation') }}">Student Creation</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.test-uploading') ? 'active' : '' }}">
            <!--<span class="side-icon-menu" class="bg-dark">
                <i class="fa fa-upload" aria-hidden="true"></i>
            </span>-->
            <a class="nav-link " href="{{ route('admin.test-uploading') }}">Test Uploading</a>
        </li>
        
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.booking-report') ? 'active' : '' }}">
          
            <a class="nav-link" href="{{ route('admin.booking-report') }}">Student Booking</a>
        </li>
        
        <!-- <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.student-quiz-detail') ? 'active' : '' }}">-->
          
        <!--    <a class="nav-link" href="{{ route('admin.student-quiz-detail') }}">Student Quiz Detail</a>-->
        <!--</li>-->
        
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.center') ? 'active' : '' }}">
          
            <a class="nav-link" href="{{ route('admin.center') }}">Center</a>
        </li>
       
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.slot-booking')}}">
                <a class="nav-link " href="{{ route('admin.slot-booking') }}">Slot Booking</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.show-course')}}">
                <a class="nav-link " href="{{ route('admin.show-course') }}">Student Report</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.assign-test')}}">
            <a class="nav-link " href="{{ route('admin.assign-test') }}">Assign Test</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style">
           <!-- <span class="side-icon-menu" class="bg-dark">
                <i class="fa fa-sign-out" aria-hidden="true "></i>
            </span>-->
            <a href="{{ route('admin.logout') }}" class="nav-link">Log Out</a>
        </li>
    </ul>
    <?php } ?>
        
</div>




