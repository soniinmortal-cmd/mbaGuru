<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME') }} | Admin - Login</title>
        <!-- bootstrap cdn link  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <!-- font family  cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
            integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row logincss" id="main-content-sign">
                <div class="col-md-6" id="adminimnage">
                    <img src="{{ asset('assets/admin/image/Education-in-Sierra-Leoen.jpg') }}" alt="logo"class="img-fluid">
                </div>
                <div class="col-md-6 p-0" id="right-section">
                    <div class="card" style="border: none;" id="card-style">
                        <div class="card-body">
                            <form action="#" id="login-form">
                                <h3 class="text-center fw-bold">
                                    <img src="{{ asset('assets/admin/image/Logo-2.png') }}" alt="logo"class="img-fluid">
                                </h3>
                                <h5 class="text-center">Sign In To Your Account</h5>
                                {{-- <p class="text-center">Don't have an account?
                                    <a href="{{ route('admin.register') }}" style="color:#A83942"><span class="fw-bold" id="signup-text-style fw-bold">SIGN UP</span></a>
                                </p> --}}
                                <div>
                                    <label for="email" class="text-start fs-6 fw-normal">Email*</label>
                                    <input type="email" name="email"
                                        class="form-control mx-auto outline-0 mt-0 mb-3 px-3 py-2"
                                    style="background-color: #F1EEEE;" placeholder="Enter Your email here">
                                </div>
                                <div id="pass-sect">
                                    <label for="password" class="align-self-start fs-6 fw-normal ">Password*</label>
                                    <input type="password" name="password" class="form-control mx-auto outline-0  mt-0 mb-3 px-3 py-2 "
                                    style="background-color: #F1EEEE;" placeholder="Enter your Password">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn px-5 py-1 text-white  my-2 border-0 mx-auto "
                                    style="background-color: #A83942;" id="singIn-btn">SIGN IN</button>
                                    <a href="{{ route('admin.forget-password') }}" style="color:#A83942;font-size:14px;">
                                        {{-- <p id="btn-bottom-paragrap" class="fw-bold">FORGET PASSWORD</p> --}}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid process_loader"
            style="position:fixed;top:0px;left:0px;background: rgba(0,0,0,0.7);z-index: 1000000;width:100%;height:100%;padding-top: 25%;display: none;">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('public/assets/admin/js/javascript.js') }}"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                $(document).on('submit', '#login-form', function(e) {
                    e.preventDefault();
                    var email = $('#login-form input[name=email]').val();
                    var password = $('#login-form input[name=password]').val();
                    if (email == '' || password == '') {
                        toastr.error('Please enter Email & Password correctly.');
                        return false;
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.authentication') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $('.process_loader').show();
                        },
                        success: function(data) {
                            var msg = '';
                            if (data.code == 0) {
                                if (typeof data.message === 'object' && Object.keys(data.message).length > 0) {
                                    $.each(data.message, function(key, value) {
                                        msg += value + '<br/>';
                                    });
                                } else {
                                    msg = data.message;
                                }
                                toastr.error(msg);
                            } else {
                                msg = data.message;
                                toastr.success(msg);
                                window.location.href = "{{ route('admin.dashboard') }}";
                            }
                        },
                        complete: function() {
                            $('.process_loader').hide();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
