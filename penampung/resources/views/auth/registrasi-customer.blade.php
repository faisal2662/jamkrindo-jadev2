<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Registrasi</title>
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

                            {{-- <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo --> --}}

                            <div class="card mb-3">

                                <div class="card-body">
                                    <img src="{{ asset('assets/img/logo-jamkrindo.png') }}" width="200"
                                        class="mt-3 " style="margin-left:85px;  " alt="">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">REGISTRASI</h5>
                                        <p class="text-center small">Masukkan Data Diri Anda Untuk Daftar </p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible fade show" id="alert"
                                        style="display: none;" role="alert">
                                        Silahkan isi yang bertanda *
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @if (Session::has('success'))
                                        <div class="alert alert-success alert-dismissible fade text-center  show mb-4"
                                            role="alert">
                                            {{ session('success') }} <a href="{{ route('login-customer') }}"> login</a>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="row g-3 needs-validation" id="formRegis" method="POST"
                                        action="{{ route('registrasi-customer') }}">
                                        @csrf
                                        <div id="customer">
                                            <div class="col-12">
                                                <label for="nppUser" class="form-label">Nama Lengkap <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="text" name="nm_customer" class="form-control"
                                                    id="nm_user" required>
                                                <div class="invalid-feedback">Silahkan Masukkan nama lengkap</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="name" class="form-label">Username <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="text" name="userid_customer" class="form-control"
                                                    id="userId" required>
                                                <div class="invalid-feedback">Silahkan Masukkan </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="password" class="form-label">Password <span
                                                        class="me-2 text-danger">* </span></label>
                                                <div class="input-group has-validation">
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" required>
                                                    <span class="input-group-text "><i class="bi bi-eye-fill"
                                                            id="show" style="cursor: pointer"></i></span>

                                                    <div class="invalid-feedback">Please enter y our Password</div>
                                                </div>
                                                <label for="" id="label_password" class="text-danger"></label>
                                                <div class="invalid-password text-danger mt-1" style="display: none;">
                                                    Password minimal harus 8 karakter</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Konfirmasi Password <span
                                                        class="me-2 text-danger">* </span></label>
                                                <div class="input-group has-validation">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control" id="password_confirmation" required>
                                                    <span class="input-group-text "><i class="bi bi-eye-fill"
                                                            id="show1" style="cursor: pointer"></i></span>

                                                    <div class="invalid-feedback">Please enter your Password</div>
                                                </div>
                                                <label for="" id="label_password_confirmation"
                                                    class="text-danger"></label>
                                                <div class="invalid-password text-danger mt-1" style="display: none;">
                                                    Password minimal harus 8 karakter</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="name" class="form-label">Email <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="email" name="email_customer" class="form-control"
                                                    id="email" required>
                                                <div class="invalid-feedback">Silahkan Masukkan email</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="no_hp" class="form-label">No. Aktif <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="number" name="no_hp" class="form-control"
                                                    id="no_hp" required>
                                                <div class="invalid-feedback">Silahkan Masukkan no_hp</div>
                                            </div>
                                            {{-- <div class="col-12">
                                                <label for="provinsi" class="form-label">Provinsi<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="provinsi" id="provinsi" class="form-control">
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach ($province as $item)
                                                        <option value="{{ $item->kd_provinsi }}">
                                                            {{ $item->nm_provinsi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih provinsi</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="kota" class="form-label">Kota<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="kota" id="kota" class="form-control">
                                                    <option value="">Pilih Kota</option>

                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih kota</div>
                                            </div> --}}
                                            <div class="col-12">
                                                <label for="wilayah" class="form-label">Wilayah<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="wilayah" id="wilayah" class="form-control">
                                                    <option value="">Pilih wilayah</option>
                                                    @foreach ($wilayah as $item)
                                                        <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih wilayah</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="cabang" class="form-label">Cabang<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="cabang" id="cabang" required class="form-control">
                                                    <option value="">Pilih cabang</option>

                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih cabang</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="kode_referal" class="form-label">Kode Referral </label>
                                                <input type="text" name="kode_referral" class="form-control">
                                                <div class="invalid-feedback">Silahkan Masukkan kode</div>
                                            </div>
                                        </div>

                                        <div id="dataUsaha" style="display: none;">
                                            <div class="col-12">
                                                <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="text" name="nm_perusahaan" class="form-control"
                                                    id="nm_perusahaan" required>
                                                <div class="invalid-feedback">Silahkan Masukkan nama perusahaan</div>
                                            </div>
                                            {{-- <div class="col-12">
                                                <label for="npwp_perusahaan" class="form-label">NPWP Perusahaan <span
                                                        class="me-2 text-danger">* </span></label>
                                                <input type="text" name="npwp_perusahaan" class="form-control"
                                                    id="npwp_perusahaan" required>
                                                <div class="invalid-feedback">Silahkan Masukkan npwp perusahaan</div>
                                            </div> --}}
                                            <div class="col-12">
                                                <label for="provinsi_usaha" class="form-label">Provinsi<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="provinsi_usaha" id="provinsi_usaha"
                                                    class="form-control" required>
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach ($province as $item)
                                                        <option value="{{ $item->kd_provinsi }}">
                                                            {{ $item->nm_provinsi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih provinsi</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="kota_usaha" class="form-label">Kota<span
                                                        class="me-2 text-danger">* </span></label>
                                                <select name="kota_usaha" required id="kota_usaha"
                                                    class="form-control">
                                                    <option value="">Pilih Kota</option>

                                                </select>
                                                <div class="invalid-feedback">Silahkan pilih kota</div>
                                            </div>
                                            {{-- <div class="col-12 mb-2">
                                                <label for="alamat_perusahaan" required class="form-label">Alamat
                                                    Perusahaan
                                                    <span class="me-2 text-danger">* </span></label>
                                                <input type="text" name="alamat_perusahaan" class="form-control"
                                                    id="alamat_perusahaan">
                                                <div class="invalid-feedback">Silahkan Masukkan alamat perusahaan</div>
                                            </div> --}}
                                            <div class="form-check">
                                                <input class="form-check-input" id="check1" required
                                                    type="checkbox" value="">
                                                <label class="form-check-label" for="check1">
                                                    Saya menjamin dan menyatakan segenap data yang saya cantumkan pada
                                                    formulir ini adalah benar
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="check2" type="checkbox"
                                                    value="" required>
                                                <label class="form-check-label" for="check2">
                                                    Saya bersedia untuk PT Jamkrindo menggunakan segenap data yang saya
                                                    cantumkan untuk kegiatan pemasaran PT Jamkrindo
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <span id="back" style="display: none;" class="btn  btn-primary"><i
                                                    class="bi bi-arrow-left"></i> </span> <span
                                                class="btn btn-primary w-100 next ">
                                                Selanjutnya</span><button class="btn btn-primary save w-75 float-end"
                                                style="display:none;" type="submit">Daftar</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a
                                                    href="{{ route('login-customer') }}">Log in</a>
                                            </p>
                                        </div>
                                    </form>
                                    <div class="text-center mt-2">
                                        <p class="mb-0 text-muted" style="font-size:10pt;">Berizin dan diawasi oleh
                                            Otoritas Jasa Keuangan (OJK)</p>
                                        <img src="{{ asset('assets/img/logo-ojk.png') }}" height="90px"
                                            alt="" style="margin-top:-15px;margin-bottom:-15px;">
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

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>
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
        $('.next').on('click', function(e) {
            let next = false;
            $('#customer').find(':input[required]').each(function(e) {

                if ($(this).val() === '') {
                    $('#alert').hide()
                    $('#alert').show()
                } else {
                    next = true;

                }

            });

            if (next) {
                $('#customer').fadeOut(1000).hide();
                $('#dataUsaha').fadeIn().show();
                $('.next').fadeOut().hide();
                $('#back').fadeIn().show();
                $('.save').fadeIn().show();

            }
        });
        // $('.next').on('click', function(e) {
        //     e.preventDefault(); // Mencegah aksi default tombol

        //     let next = true; // Asumsikan valid
        //     $('#customer').find(':input[required]').each(function() {
        //         if ($(this).val() === '') {
        //             $('#alert').show();
        //             next = false; // Jika ada input kosong, set next menjadi false
        //             return false; // Hentikan iterasi
        //         } else {
        //             $('#alert').hide();
        //         }
        //     });

        //     if (next) {
        //         $('#customer').fadeOut();
        //             $('#dataUsaha').fadeIn();
        //         // });
        //         $('.next').fadeOut();
        //         $('#back, .save').fadeIn();
        //     }
        // });


        $('#back').on('click', function(e) {
            $('#back').fadeOut().hide();
            $('.save').fadeOut().hide();
            $('#customer').fadeIn().show();
            $('#dataUsaha').fadeOut(1000).hide();
            $('.next').fadeIn().show();

        })
    </script>
    <script>
        $('#provinsi').on('change', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#kota').empty();
                    res.forEach(function(city) {

                        $('#kota').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })
        $('#kota').on('click', function() {
            // console.log('berubah')
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataWilayah', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#wilayah').empty();

                    if (res.length == 0) {

                        $('#wilayah').append(
                            `<option value="">Belum tersedia</option>`
                        );
                    }
                    res.forEach(function(wilayah) {


                        $('#wilayah').append(
                            `<option value="${wilayah.id_kanwil}">${wilayah.nm_wilayah}</option>`
                        );


                    })
                },
                error: function(err) {
                    alert("Gagal mengambil wilayah");
                }

            })
        })
        $('#provinsi_usaha').on('change', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#kota_usaha').empty();
                    res.forEach(function(city) {

                        $('#kota_usaha').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })

        $('#wilayah').on('change', function() {
            // console.log('berubah')
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataCabang', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#cabang').empty();
                    // console.log(res)
                    if (res.length == 0) {

                        $('#cabang').append(
                            `<option value="">Belum tersedia</option>`
                        );
                    }
                    res.forEach(function(cabang) {
                        $('#cabang').append(
                            `<option value="${cabang.id_cabang}">${cabang.nm_cabang}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil cabang");
                }

            })
        })


        // $('#formRegis').on('submit', function(e) {
        //     // e.preventDefault();
        //     console.log('daftar')
        //     var formData = $(this).serializeArray();
        //     $.ajax({
        //         url: "{{ route('registrasi-customer') }}",
        //         type: "POST",
        //         data: $.param(formData),
        //         beforeSend: function() {
        //             $('.btn-save').html("Loading...");
        //             $('.btn-save').attr("disabled", "");
        //         },
        //         error: function(res) {
        //             $('#branchModal').modal('hide');

        //             $('.pesan').text(res.status);
        //             $('#alert').addClass('show').fadeIn();
        //             setTimeout(
        //                 function() {
        //                     $('#alert').removeClass('show').fadeOut()
        //                 }, 3000);
        //             alert("Error");
        //         },
        //         success: function(res) {
        //             $('#branchModal').modal('hide');
        //             $('.pesan').text("Simpan " + res.status);
        //             $('#alert').addClass('show').fadeIn();
        //             setTimeout(
        //                 function() {
        //                     $('#alert').removeClass('show').fadeOut()
        //                 }, 3000);
        //             // alert(res.status);
        //             reloadData();
        //         },
        //         complete: function() {
        //             $('.btn-save').html("Save");
        //             $('.btn-save').removeAttr("disabled");
        //             initialForm();
        //         }
        //     });

        // });
    </script>
</body>

</html>
