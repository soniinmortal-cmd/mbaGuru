<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Admin - Register</title>
    <!-- bootstrap cdn link  -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css
        ">
    <!-- font family  cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    

    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">


</head>

<body>
    
<style type="text/css">
        .lds-ellipsis {
            display: inline-block;
            position: fixed;
            top: 49%;
            left: 50%;
            width: 110px;
            height: 60px;
            background: #fff;
            border-radius: 8px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 42%;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #3498db;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 25px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 25px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 50px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 70px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }
    </style>

<div class="container-fluid process_loader"
        style="position:fixed;top:0px;left:0px;background: rgba(0,0,0,0.7);z-index: 1000000;width:100%;height:100%;padding-top: 25%;display: none;">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row" id="main-content-sign">
            <div class="col-sm-5 p-0" id="left-section">
            </div>
            <div class="col-sm-7  p-0" id="right-section">
                <div class="card   p-4" style="width: 18rem; border: none;" id="card-style">
                    <div class="card-body">
                        <form action="#" method="post" id="register-form">
                            <h3 class="text-center fw-bold">
                                <img src="{{ asset('assets/admin/image/Logo-2.png') }}" alt="logo"
                                    class="img-fluid">
                            </h3>
                            <h5 class="text-center">Create Your Account</h5>
                            <p class="text-center">Already have an account?
                                <a href="{{ route('admin.login') }}" style="color:#A83942"><span class="fw-bold"
                                        id="signup-text-style fw-bold">SIGN IN</span></a>
                            </p>
                            <div>
                                <label for="email" class="text-start fs-6 fw-normal">Email*</label>
                                <input type="email" name="email"
                                    class="form-control mx-auto outline-0 mt-0 mb-3 py-2 px-3 "
                                    style="background-color: #F1EEEE;" placeholder="Enter your Email">

                            </div>
                            <div id="pass-sect">
                                <label for="password" class="align-self-start fs-6 fw-normal ">Password*</label>
                                <input type="password" autocomplete="off" class="form-control mx-auto outline-0  mt-0 mb-3 py-2 px-3"
                                    style="background-color: #F1EEEE;" name="password"
                                    placeholder="Enter your Password">
                                <!-- <span id="eyeicon"><i class="fa-solid fa-eye-slash" style="font-size:12px"></i></span> -->
                            </div>
                            <div id="pass-conf-sect">
                                <label for="password_confirmation" class="align-self-start fs-6 fw-normal ">Confirm
                                    Password*</label>
                                <input type="password" autocomplete="off" class="form-control mx-auto outline-0  mt-0 mb-3 py-2 px-3"
                                    style="background-color: #F1EEEE;" name="password_confirmation"
                                    placeholder="Confirm your Password">
                                <!-- <span id="eyeicon"><i class="fa-solid fa-eye-slash" style="font-size:12px"></i></span> -->
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn px-5 py-1 my-2 text-white border-0 mx-auto"
                                    style="background-color: #A83942;" id="singIn-btn">SIGN UP</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js
                "></script>
    <script src="{{ asset('public/assets/admin/js/javascript.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '#register-form', function(e) {
                e.preventDefault();
                var email = $('#register-form input[name=email]').val();
                var password = $('#register-form input[name=password]').val();
                if (email == '' || password == '') {
                    toastr.error('Please enter Email & Password correctly.');
                    return false;
                    console.log('name');
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                   
                });
                $.ajax({
                    url: "{{ route('admin.register-code') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.process_loader').show();
                    },
                    
                    success: function(data) {
                        var msg = '';
                       

                        if (data.code == 0) {
                            if (typeof data.message === 'object' && Object.keys(data.message)
                                .length > 0) {
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
                            window.location.href = "{{ route('admin.login') }}";
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
