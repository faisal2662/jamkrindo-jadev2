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
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                {{-- <a href="" class="logo d-flex align-items-center w-auto"> --}}
                                {{-- <span class="d-none d-lg-block">NiceAdmin</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    <img src="{{ asset('assets/img/logo-jamkrindo.png') }}" width="200"
                                        class="mt-3 " style="margin-left:85px;  " alt="">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Silahkan Pilih Cabang</h5>
                                        {{-- <p class="text-center small">Masukkan NPP dan Password Untuk Masuk</p> --}}
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('updateCabang') }}" novalidate id="login-admin">
                                        @csrf
                                        <div class="col-12">
                                            <input type="hidden" name="customer" value="{{ $customer }}">
                                            <label for="npp_user" class="form-label">Cabang <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <select name="cabang" id="cabang" class="form-control" required>
                                                    <option value="" disabled selected>Pilih Cabang</option>
                                                    @foreach ($cabang as $item)
                                                        <option value="{{ $item->id_cabang }}">{{ $item->nm_cabang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                 <div class="invalid-feedback validasi"  >
                                                          Cabang wajib diisi
                                                   </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 btn-login"
                                                type="submit">Lanjutkan</button>
                                        </div>
                                </div>


                                </form>
                                <div class="text-center mt-2">
                                    <p class="mb-0">Diawasi Oleh:</p>
                                    <img src="{{ asset('assets/img/logo-ojk.png') }}" height="90px" alt=""
                                        style="margin-top:-15px;">
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
        password.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length <= 8) {
                invalidPassword.style.display = 'block';
            } else {
                invalidPassword.style.display = 'none';

            }
        });

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
    <script>
        $('#login-admin').on('submit', function(e){
            if($('#cabang').val() === null){
                $('.validasi').show();
            e.preventDefault();
            }
            
        })
    </script>
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
