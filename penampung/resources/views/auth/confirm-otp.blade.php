<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                {{-- <a href="" class="logo d-flex align-items-center w-auto"> --}}
                                {{-- <span class="d-none d-lg-block">NiceAdmin</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('assets/img/logo-jamkrindo.png') }}" width="200"
                                            class="mt-3" alt="">
                                    </div>

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Verifikasi OTP</h5>
                                        <p class="text-center small">Silahkan Masukkan OTP yang telah di kirim ke email <strong> {{$emailAddress}} </strong> </p>
                                       <p class="text-center">Masa Berlaku OTP akan berakhir dalam : <span class="fw-bold" id="countdown"></span> <span id="alert-login" style="display: none;"><a href="{{route('login')}}"> Silahkan Login</a></span></p>
                                    </div>

                                    @if (session('alert'))
                                        <div class="alert alert-danger">
                                            {{ session('alert') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div id="alert_api" class="alert alert-danger" style="display: none;">
                                        <span id="pesan"></span>
                                    </div>
                                    <form class="row g-3 needs-validation" id="login-admin" method="POST"
                                        action="{{ route('login.verifyOtp') }}" novalidate id="login-admin">
                                        @csrf

                                        <input type="hidden" name="id_user" value="{{ encrypt($user->kd_user) }}">
                                        <div class="col-12">
                                            <label for="otp_code" class=" text-center form-label">Masukkan Kode OTP</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="otp_code" class="form-control"
                                                    id="otp_code" required>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn w-100 btn-primary login-btn"
                                                id="btn-login">
                                             Verify OTP
                                            </button>
                                        </div>

                                    </form>
                                    <div class="text-center mt-2">
                                        <p class="mb-0 text-muted" style="font-size:10pt;">Berizin dan diawasi oleh
                                            Otoritas Jasa Keuangan (OJK)</p>
                                        <img src="{{ asset('assets/img/logo-ojk.png') }}" height="90px" alt=""
                                            style="margin-top:-15px;margin-bottom:-15px;">
                                    </div>
                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                            </div>

                        </div>
                    </div>
                </div>


            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var countdownElement = document.getElementById('countdown');
            var targetTime = new Date('{{$time}}'); // Set target time from backend

            function updateCountdown() {
                var now = new Date();
                var remainingTime = Math.floor((targetTime - now) / 1000);
                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.textContent = "Expired";
                    document.getElementById('alert-login').style.display = 'inline-block';
                    return;
                }
                var hours = Math.floor(remainingTime / 3600);
                var minutes = Math.floor((remainingTime % 3600) / 60);
                var seconds = remainingTime % 60;
                countdownElement.textContent =  (minutes < 10 ? '0' : '') + minutes + "m " + (seconds < 10 ? '0' : '') + seconds + "s ";
            }

            var countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>


    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
