
<html lang="en">
   <head>
       <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ env('APP_NAME') }}</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css
         ">
      <!-- font family  cdn link  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
         integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
         crossorigin="anonymous" referrerpolicy="no-referrer">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
      <!-- font awesome cdn link  -->
      <script src="https://kit.fontawesome.com/c7929e68c3.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
         integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
      <link rel="stylesheet" href="{{asset('assets/admin/css/numeric-keypad.css')}}">
      <link rel="stylesheet" href="jquery.paginate.css">
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      
      <script src="https://code.jquery.com/jquery-3.6.4.js"
         integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
   </head>
   <body style="overflow-y:auto;" >
      @include('student.layouts.header')
      @include('student.layouts.footer')
      <div class="container-fluid "  id="main-content">
         <div class="row m-0">
             <div style="position:fixed; z-index:1100; left:0; background-color:white; overflow-y:auto;"> </div>
            @include('student.layouts.sidebar')
            @yield('content')
         </div>
      </div>
      
      @yield('footer')
      <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
      
      <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
      @yield('script')
   </body>
</html>