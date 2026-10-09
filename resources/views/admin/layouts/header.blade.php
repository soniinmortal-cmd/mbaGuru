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
  top: 0;
  width: 100%;
  left: 0;
  background-color: var(--white-color);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 30px;
  z-index: 1000;
  box-shadow: 0 0 2px var(--grey-color-light);
}
.logo_item {
  display: flex;
  align-items: center;
  column-gap: 10px;
  font-size: 22px;
  font-weight: 500;
  color: var(--blue-color);
}
.profile {
  width: 35px;
  height: 35px;
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
    font-size: 25px;
    display: block;
    margin-right: 10px;
    cursor: pointer;
    color: var(--grey-color);
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

.navbar:before{
  content:none !important ;
}
.navbar:after{
  content:none !important ;

}

</style>
<header>
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"></i>
        <a  href="{{ route('admin.dashboard') }}">
        <img src="{{asset('assets/student/image/Logo-2.png')}}" alt="" class="logoimg">
        </a>
      </div>


      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        
        <i class='bx bx-bell' ></i>
        <img src="{{asset('assets/student/image/profile-img.webp')}}" alt="" class="profile" />
      </div>
    </nav>
    <div class="offcanvas offcanvas-start w-75" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-body">
    <div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" style="float:right"></button>
    
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
            <!--<span class="side-icon-menu" class="bg-dark">
                <i class="fa fa-book" aria-hidden="true"></i>
            </span>-->
            <a class="nav-link" href="{{ route('admin.booking-report') }}">Student Booking</a>
        </li>
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.center') ? 'active' : '' }}">
            <!--<span class="side-icon-menu" class="bg-dark">
                <i class="fa fa-book" aria-hidden="true"></i>
            </span>-->
            <a class="nav-link" href="{{ route('admin.center') }}">Center</a>
        </li>
       
        <li class="nav-item d-flex px-3 py-1 item-style {{ Route::is('admin.slot-booking')}}">
                <a class="nav-link " href="{{ route('admin.slot-booking') }}">Slot Booking</a>
            </li>
       
        <li class="nav-item d-flex px-3 py-1 item-style">
           <!-- <span class="side-icon-menu" class="bg-dark">
                <i class="fa fa-sign-out" aria-hidden="true "></i>
            </span>-->
            <a href="{{ route('admin.logout') }}" class="nav-link ">Log Out</a>
        </li>
    </ul>   

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