<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Admin - Forget Password</title>
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

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">


</head>

<body>
    <div class="container-fluid">
        <div class="row" id="main-content-sign">
            <div class="col-sm-5 p-0" id="left-section">

            </div>
            <div class="col-sm-7 p-0" id="right-section">
                <div class="card p-4" style="width: 18rem; border: none;" id="card-style">
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <h3 class="text-center fw-bold">
                                <img src="{{ asset('assets/admin/image/Logo-2.png') }}" alt="logo"
                                    class="img-fluid">
                            </h3>
                            <h5 class="text-center">Reset Password</h5>
                            <p class="text-center" style="font-size:10px;">Enter the email id associated with your
                                account
                                <br> to recieve an email to reset your password <a href="#">
                                    <!-- <span class="text-primary" id="signup-text-style fw-bold">SING IN</span> -->
                                </a>
                            </p>
                            <div>
                                <label for="email" class="text-start fs-6 fw-normal">Email*</label>
                                <input type="email" class="form-control mx-auto outline-0 mt-0 mb-3 py-2 px-3"
                                    style="background-color: #F1EEEE;" placeholder="Email Address">

                            </div>

                            <div class="text-center">
                                <button type="button"
                                    class="btn  px-5 text-white py-1 my-2 border-0 mx-auto d-inline-block"
                                    id="singIn-btn" style="background-color: #A83942;">SUBMIT</button>
                                <br>
                                <a href="{{ route('admin.login') }}"
                                    class="btn btn-light px-5 py-1 my-2 border-0 mx-auto d-inline-block" id="singIn-btn"
                                    style="background-color: #F1EEEE; color: #838383;">CANCEL</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js
            "></script>
    <script src="{{ asset('public/assets/admin/js/javascript.js') }}"></script>
</body>

</html>
