<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Reset Password</title>
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
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                {{-- <a href="" class="logo d-flex align-items-center w-auto"> --}}
                                {{-- <span class="d-none d-lg-block">NiceAdmin</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body justify-content-center">
                                    <img src="{{ asset('assets/img/logo-jamkrindo.png') }}" width="200"
                                        class="mt-3 ms-5" alt="">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                                        <p class="text-center small">Pulihkan kata sandi akun anda.</p>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('password.update') }}" novalidate id="login-admin">
                                        @csrf
                                        <input type="hidden" name="token" id="token" value="{{ $token }}">
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="email" required value="{{ $email ?? old('email') }}">
                                                    <span class="input-group-text "><i class="bi bi-eye-fill"
                                                        id="show" style="cursor: pointer"></i></span>
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                <div class="invalid-feedback">Please enter your email.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password"  class="form-control @error('password') is-invalid @enderror"
                                                    id="password" required>
                                                    <span class="input-group-text "><i class="bi bi-eye-fill"
                                                        id="show1" style="cursor: pointer"></i></span>
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror                                            
					                        </div>
                                            <label for="" id="label_password"
                                            class="text-danger"></label>
                                        </div>
                                        <div class="col-12">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror"
                                                    id="password_confirmation" required>
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
					                         </div>
                                             <label for="" id="label_password_confirmation"
                                             class="text-danger"></label>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <button class="btn btn-primary w-100 btn-login"
                                                type="submit">Reset Password</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        const password = document.getElementById('password');
        const password1 = document.getElementById('password_confirmation');
        const invalidPassword = $('.invalid-password');
        const show = document.getElementById('show');
        const show1 = document.getElementById('show1');
        // password.addEventListener('keyup', (e) => {
        //     const value = e.target.value;
        //     if (value.length < 8) {
        //         invalidPassword.show();
        //     } else {
        //         invalidPassword.hide()

        //     }
        // });
        // password1.addEventListener('keyup', (e) => {
        //     const value = e.target.value;
        //     if (value.length < 8) {
        //         invalidPassword.show();
        //     } else {
        //         invalidPassword.hide()

        //     }
        // });

        $('#password_confirmation').on('keyup', function() {
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();
            if (password != password_confirmation) {
                $('#label_password_confirmation').show();
                $('#label_password_confirmation').html("Password tidak sama");
                $('#label_password').show();
                $('#label_password').html("Password tidak sama");
                $('.next').css(
                    'display', 'none'
                );
            } else {
                $('#label_password').hide();
                $('#label_password_confirmation').hide();
                $('.next').css(
                    'display', 'block'
                );
            }
        });
        $('#password').on('keyup', function() {

            $('#label_password').html("");

            var InputValue = $("#password").val();
            var regex = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
            $("#passwordText").text(`Password value:- ${InputValue}`);

            console.log(InputValue);

            if (!regex.test(InputValue)) {
                $('#label_password').show();
                $('#label_password').html("Minimal 8 digit dengan kombinasi huruf, angka dan karakter spesial");
                $('.next').css(
                    'display', 'none'
                );
            } else {

                $('#label_password').hide();
                $('.next').css(
                    'display', 'block'
                );
            }

        });
        show.addEventListener('click', (e) => {
            if (password.getAttribute('type') == 'password') {
                password.setAttribute('type', 'text');
                show.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password.setAttribute('type', 'password');
            }
        })
        show1.addEventListener('click', (e) => {
            if (password1.getAttribute('type') == 'password') {
                password1.setAttribute('type', 'text');
                show1.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show1.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password1.setAttribute('type', 'password');
            }
        })
    </script>
</body>

</html>
