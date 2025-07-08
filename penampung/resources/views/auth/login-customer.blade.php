<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

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
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <!--<div class="d-flex justify-content-center py-4">-->
                            <!--    {{-- <a href="" class="logo d-flex align-items-center w-auto"> --}}-->
                            <!--    {{-- <span class="d-none d-lg-block">NiceAdmin</span> --}}-->
                            <!--    </a>-->
                            <!--</div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                       <div class="d-flex justify-content-center py-4">
                                    <div class=" d-flex align-items-center w-auto">
                                    <img src="{{ asset('assets/img/logo-jamkrindo.png') }}"
                                         alt="">
                                        </div>
                                        </div>

                                    <div class=" pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Masuk Ke Akun</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('authenticate-customer') }}" novalidate id="login-admin">
                                        @csrf
                                        <div class="col-12">
                                            <label for="email_customer" class="form-label">Email Customer</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email_customer" class="form-control"
                                                    id="email_customer" required autofocus>
                                                <div class="invalid-feedback">Please enter your Email</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password" class="form-control"
                                                    id="password" required>
                                                <span class="input-group-text "><i class="bi bi-eye-fill" id="show"
                                                        style="cursor: pointer"></i></span>

                                                <div class="invalid-feedback">Please enter your Password</div>
                                                <div class=" invalid-feedback invalid-password text-danger mt-1"
                                                    style="display: none;">
                                                    Password minimal harus 8 karakter</div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 btn-login"
                                                type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="{{ route('registrasi')}}">Create an
                                                    account</a></p>
                                        </div>
                                    </form>
                                    <div class="text-center mt-2">
                                        <p class="mb-0 text-muted" style="font-size:10pt;">Berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK)</p>
                                        {{-- <img src="{{ asset('assets/img/logo-ojk.png') }}" height="90px"
                                            alt="" style="margin-top:-15px;margin-bottom:-15px;"> --}}
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
        const password = document.getElementById('password');
        const invalidPassword = document.getElementsByClassName('invalid-password')[0];
        const show = document.getElementById('show');
      

        show.addEventListener('click', (e) => {
            console.log(password.getAttribute('type'))
            if (password.getAttribute('type') == 'password') {
                password.setAttribute('type', 'text');
                show.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password.setAttribute('type', 'password');
            }
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script>
        $('#login-admin').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "/login",
                type: "POST",
                data: $('#login-admin').serialize(),
                beforeSend: function() {
                    $('.btn-login').html("Loading...");
                    $('.btn-login').attr("disabled", "");
                },
                error: function(res) {

                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 3000);
                    alert("Error");
                },
                success: function(res) {
                    $('#customerModal').modal('hide');
                    $('.pesan').text("Simpan " + res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 3000);
                },
                complete: function() {
                    $('.btn-login').html("Save");
                    $('.btn-login').removeAttr("disabled");
                    // initialForm();
                }
            });


        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $("#show").click(function() {
                $(this).toggleClass("fas fa-eye fas fa-eye-slash");
                var type = $(this).hasClass("fas fa-eye-slash") ? "text" : "password";
                $("#pass").attr("type", type);
            });
        });
    </script> --}}
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
