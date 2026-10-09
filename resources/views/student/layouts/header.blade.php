<!--<header class="fixed-top">
   <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid d-flex justify-conetent-center  align-items-center px-5">
         <div id="logo-sec" class="d-flex justify-content-center align-items-center">
            <a class="navbar-brand" href="#">
            <img src="{{asset('assets/student/image/Logo-2.png')}}" alt="logo-img" class="img-fluid pt-2">
            </a>
            
         </div>
         <form class="d-flex justify-conetent-center gap-3 align-items-center" role="search">
            <span id="bell-icon" class="p-1"> <i class="fa-regular fa-bell fs-5" tyle="position:relative;"></i>
            <span id="bell-red-background" class="rounded-circle"
               style="background-color: red;width: 10px;height: 10px;position: absolute; top: 28px;right: 99px;"></span>
            </span>
            <div id="profile-img">
               <img src="{{asset('assets/student/image/profile-img.webp')}}" alt="" class="fluid-img rounded-circle p-1"
                  style="width:50px;height:50px;object-fit:cover;">
            </div>
         </form>
      </div>
   </nav>
</header>-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
<style>
 * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  
}
:root {
  --white-color: #fff;
  --blue-color: #A83942;
  --grey-color: #707070;
  --grey-color-light: #aaa;
}

/* navbar */
.navbar {
    
  position: fixed;
  height:80px;
  /* display:-webkit-flex; */
  top: 0;
  width: 100%;
  left: 0;
  background-color: white;
  display: flex;
  display: -webkit-flex;
  align-items: center;
  /* justify-content: space-between; */
  padding: 15px 30px;
  /* margin-top:100px; */
   z-index: 1000; 
  box-shadow: 0 0 2px var(--grey-color-light);
}
.logo_item {
  object-fit: cover;
  margin-left:auto;
  height: 100px;
  margin-right:auto;
  /* display: flex;
  align-items: center;
  column-gap: 10px;
  font-size: 22px;
  font-weight: 500;
  color: var(--blue-color); */
}
.profile {
  width: 35px;
  height: 35px;
  padding-top: -30%;
  object-fit: cover;
  border-radius: 50%;
}
.search_bar {
  height: 47px;
  max-width: 400px;
  width: 100%;
}
.search_bar input {
  height: 100%;
  width: 100%;
  border-radius: 25px;
  font-size: 18px;
  outline: none;
  background-color: var(--white-color);
  color: var(--grey-color);
  border: 1px solid var(--grey-color-light);
  padding: 0 10px;
}
.navbar_content {
  display: flex;
  align-items: center;
  column-gap: 25px;
}
.navbar_content i {
  cursor: pointer;
  font-size: 20px;
  color: var(--grey-color);
}

/* sidebar */
.sidebar {
  background-color: var(--white-color);
  width: 280px;
  position: fixed;
    left: 0;
    top:75px;
  height: 100%;
  padding: 20px 20px;
  z-index: 100;
  overflow-y: scroll;
  box-shadow: 0 0 1px var(--grey-color-light);
  transition: all 0.5s ease;
}
.sidebar.close {
  padding: 60px 0;
  width: 80px;
}
.sidebar::-webkit-scrollbar {
  display: none;
}
.sidebar.close .menu_title {
  padding: 6px 30px;
}
.menu_title::before {
  color: var(--grey-color);
  white-space: nowrap;
}
.menu_dahsboard::before {
  content: "Dashboard";
}
.menu_editor::before {
  content: "Editor";
}
.menu_setting::before {
  content: "Setting";
}
.sidebar.close .menu_title::before {
  content: "";
  position: absolute;
  height: 2px;
  width: 18px;
  border-radius: 12px;
  background: var(--grey-color-light);
}
.menu_items {
  padding: 0;
  list-style: none;
}
.navlink_icon {
  position: relative;
  font-size: 22px;
  min-width: 50px;
  line-height: 40px;
  display: inline-block;
  text-align: center;
  border-radius: 6px;
}
.navlink_icon::before {
  content: "";
  position: absolute;
  height: 100%;
  width: calc(100% + 100px);
  left: -20px;
}
.navlink_icon:hover {
  background: var(--blue-color);
}
.sidebar .nav_link {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 15px;
  border-radius: 8px;
  text-decoration: none;
  color: var(--grey-color);
  white-space: nowrap;
}
.sidebar.close .navlink {
  display: none;
}
.nav_link:hover {
  color: var(--white-color);
  background: var(--blue-color);
}
.sidebar.close .nav_link:hover {
  background: var(--white-color);
}
.sidebar.hoverable .collapse_sidebar {
  display: none;
}
#sidebarOpen {
  display: none;
}
.logoimg
{
    height:50%;
    margin-top:5%;
    width:120px;
    
}
@media screen and (max-width: 768px) {
  #left-menu-bar
  {
    display:none;
  }
  #sidebarOpen {
    /* font-size: 25px;
    display: block;
    margin-right: 10px;
    cursor: pointer;
    color: var(--grey-color); */
    font-size: 22px;
    display: block;
    /* margin-top: 5rem; */
    cursor: pointer;
    color: var(--grey-color);
    margin-left: -11rem;

  }
  .sidebar.close {
    left: -100%;
  }
  .search_bar {
    display: none;
  }
  .sidebar.close .bottom_content {
    left: -100%;
  }
}


/* CodebyV */

.bg-cyan{
  background-color:#27a9e3!important;
}
.bg-cyan1{
background-color: #28b779!important;
}
.bg-cyan2{
background-color:#da542e!important;
}
.form-contorl:focus {
  box-shadow:none !important;
}


</style>
<header>
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"></i>
        <img src="{{asset('assets/student/image/Logo-2.png')}}" alt="" class="logoimg">
      </div>
      <?php
          $userid =session()->get('id');
          $user_image = DB::table('studentlogs')
                      ->where('id',$userid)
                      ->first();
                      $words = explode(' ', $user_image->name);
                    
                      $first_chars = '';
                  foreach ($words as $word) {
                      $first_chars .= substr($word, 0, 1);
                  }
                     // dd($first_chars);
      ?>
       <div class="navbar_content " style="margin-bottom:55px;">
        <!-- <i class="bi bi-grid"></i>
        
        <i class='bx bx-bell' ></i> -->
        {{-- <a href="{{route('student.profile')}}" class="btn prof"> --}}
        @if(!empty($user_image->image))
        
        <!-- <img src="{{asset('assets/student/image/profile-img.webp')}}" alt="" class="profile" /> -->
        <!-- <img src="{{ url('storage/app/files/'.$user_image->image) }}" alt="" class="profile" /> -->
        <!-- <img src="{{asset('assets/student/image/removedp.jpg')}}" alt="" class="profile" /> -->
        <div style="height:40px; width:40px; background-color:#e3e4e6; border-radius:50%; " ><p style="color:#A83942; text-align: center; margin-top:8px;" >{{$first_chars}}</p></div>
        @else
        <!-- <img src="{{asset('assets/student/image/profile-img.webp')}}" alt="" class="profile" /> -->
        {{-- <img src="{{asset('assets/student/image/removedp.jpg')}}" alt="" class="profile"style="position:relative;" /> --}}
        <div style="height:40px; width:40px; background-color:#e3e4e6; border-radius:50%; " ><p style="color:#A83942; text-align: center; margin-top:8px;" >{{$first_chars}}</p></div>
        @endif
        {{-- </a> --}}
      </div> 
    </nav>
    <div class="offcanvas offcanvas-start w-75" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-body">
    <div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" style="float:right"></button>
    
<ul class="nav w-100">
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.dashboard') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-th-large" aria-hidden="true"></i>
				</span>
				<a class="nav-link text-dark" aria-current="page" href="{{route('student.dashboard')}}">Dashboard</a>
			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.studentcreation') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-graduation-cap" aria-hidden="true" ></i>


				</span>
				<a class="nav-link text-dark" href="{{route('student.propzone')}}" >Propzone</a>
			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.test-analytics') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-upload" aria-hidden="true"></i>

				</span>
				<a class="nav-link text-dark" href="{{route('student.test-analytics')}}">Test Analytics</a>
			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.booking_detail') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-book" aria-hidden="true"></i>
				</span>
				<a class="nav-link text-dark" href="{{route('student.booking_detail')}}">Across Tests</a>

			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.slot-booking') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-address-book-o" aria-hidden="true"></i>

				</span>
				<a class="nav-link text-dark" href="{{route('student.slot-booking')}}">Slot Booking Option</a>
			</li>
			<li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('student.testtemplate') ? 'active' : '' }}">
				<span class="side-icon-menu" class="bg-dark">
					<i class="fa fa-commenting-o" aria-hidden="true"></i>

				</span>
		
<a class="nav-link text-dark" href="{{ route('student.logout') }}">Log Out</a>
</li>
</ul>

    </div>
  </div>
</div>
</header>
<script>
    $(".bx-menu").click(function() {    
    $(".sidebar").toggle();
});

</script>
<script type="text/javascript" src="{{asset('assets/admin/js/navbar.js')}}"></script>