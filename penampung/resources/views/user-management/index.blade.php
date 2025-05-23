@extends('layouts.main')

@section('main')
    <div class="pagetitle">
        <h1>Admin Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-end">
                                <div class="mb-3 float-end mt-4">
                                    @if ($role->can_create == 'Y')
                                        {{-- <a href="{{ route('user-manager.create') }}" class="btn btn-primary btn-sm">Tambah
                                    Admin</a> 
                              --}}

                                        <span> <button id="btn_sync" class="btn btn-primary btn-sm"><i
                                                    class='bx bx-sync'></i>
                                                Sync</button> <button style="display: none" id="btn_sync_load"
                                                class="btn btn-sm btn-primary" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </span>
                                        <button type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#exportPdf">
                                            <i class="bi bi-filetype-pdf"> </i> PDF
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#exportExcel">
                                            <i class="bi bi-file-earmark-excel"> </i> Excel
                                        </button>
                                    @endif
                                </div>
                                <p class="mt-3"><strong>
                                        Last sync : </strong> <span class="text-sync"></span></p>
                            </div>
                        </div>
                        {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                        <!-- Table with stripped rows -->
                        {{-- <div id="alert" class="alert alert-success alert-dismissible fade  " role="alert">
                            <span class="pesan text-center text-capitalize"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> --}}
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center show"
                                id="success-notification" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <span style="display:none;" id="alert">
                            <div class="alert text-center type-alert " role="alert">
                                <span id="message"></span>
                            </div>
                        </span>
                        <div class="result"></div>
                        <table class="table table-hover table-striped " id="users-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NPP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Wilayah</th>
                                    <th>Kantor Cabang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- modal edit --}} 
    <div class="modal fade" id="userModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        @csrf
                        <table class="table table-borderless">
                            <input type="hidden" name="id_user" id="idUser">
                            <tr>
                                <th>NPP Admin <span class="text-danger">*</span></th>
                                <td><input type="text" name="npp_user" id="nppUser" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Nama User <span class="text-danger">*</span></th>
                                <td><input type="text" name="nm_user" id="namaUser" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Email <span class="text-danger">*</span></th>
                                <td><input type="text" name="email" id="email" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Karyawan <span class="text-danger">*</span></th>
                                <td>
                                    <select name="employee_status" id="employee_status" required class="form-control">
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Non Aktif">Non Aktif</option>
                                        {{-- @foreach ($regions as $item)
                                    <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}</option>
                                    @endforeach --}}
                                    </select>
                                </td>
                                {{-- <td><input type="text" name="employee_status" id="employee_status" class="form-control"
                                    required>
                            </td> --}}
                            </tr>
                            <tr>
                                <th>Alamat <span class="text-danger">*</span></th>
                                <td><input type="text" name="primary_address" id="primary_address" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone <span class="text-danger">*</span></th>
                                <td><input type="text" name="primary_phone" id="primary_phone" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <!-- <tr>
                                    <th>Status <span class="text-danger">*</span></th>
                                    <td><input type="text" name="status" id="status" class="form-control"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Divisi <span class="text-danger">*</span></th>
                                    <td><input type="text" name="nm_perusahaan" id="namaPerusahaan" class="form-control"
                                            required>
                                    </td>
                                </tr> -->
                            <tr>
                                <th>Wilayah Perusahaan <span class="text-danger">*</span></th>
                                <td>
                                    <select name="wilayah_perusahaan" id="wilayahPerusahaan" required
                                        class="form-control">
                                        <option value="" selected>Pilih Wilayah</option>
                                        @foreach ($regions as $item)
                                            <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th id="title-password">Password<span class="text-danger">*</span></th>
                                <td><input type="password" name="password" id="password" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary w-75 btn-save">Simpan</button>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </form>
                </div>
            </div>
        </div>

    </div>


    <!-- Modal Hapus -->
    <div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah Kamu yakin ingin menghapus ini ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Ya, hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exportPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Export PDF</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user-manager.pdf') }}" target="_blank" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="start" class="form-label">Tanggal Awal <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="start" id="start" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end" class="form-label">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="end" id="end" required class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal"
                        id="showPdf">Show</button>
                    <button type="submit" class="btn btn-danger btn-export btn-sm">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exportExcel" tabindex="-1" aria-labelledby="modalLabelExcel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabelExcel">Export Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user-manager.excel') }}" id="formExportExcel" target="_blank"
                        method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="start" class="form-label">Tanggal Awal <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="start" id="start" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end" class="form-label">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="end" id="end" required class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal"
                        id="showExcel">Show</button>
                    <button type="submit" class="btn btn-danger btn-export btn-sm">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@section('script')
    <script>
        let user = "add";
        $(document).ready(function() {
            reloadData()
            var $notification = $('#success-notification');
            if ($notification.length > 0) {
                // Tampilkan notifikasi
                $notification.fadeIn('slow');
                // Menghilangkan notifikasi dengan delay
                setTimeout(function() {
                    $notification.fadeOut('slow');
                }, 7000); // Delay sebelum notifikasi menghilang (dalam milidetik)
            }
        });


        function reloadData(start = null, end = null) {
            var table = new DataTable('#users-table', {
                destroy: true,
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('user-manager.getData') }}",
                    type: 'GET',
                    data: function(d) {
                        d.startDate = start;
                        d.endDate = end;
                    }
                },
                columns: [{
                        data: 'no' 
                    },
                    {
                        data: 'npp_user'
                    },
                    {
                        data: 'nm_user'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'wilayah.nm_wilayah'
                    },
                    {
                        data: 'cabang.nm_cabang'
                    },
                    {
                        data: 'action'
                    }
                ]
            });
        }

        $('#showExcel').on('click', function() {
            let start = $('#exportExcel #start').val()
            let end = $('#exportExcel #end').val()

            reloadData(start, end)
        })


        $('#showPdf').on('click', function() {
            let start = $('#exportPdf #start').val()
            let end = $('#exportPdf #end').val()

            reloadData(start, end)
        })

        //initial form
        function initialForm() {
            $('#idUser').val("");
            $('#nppUser').val("");
            $('#namaUser').val("");
            $('#namaPerusahaan').val("");
            $('#password').val("");
            $('#wilayahPerusahaan').val("");

        }

        function userAdd() {
            user = "add";
            initialForm();

            $('.modal-title').text("Tambah Admin");
            $('#userModal').modal('show');
        }

        function userDelete(id) {
            if (confirm("Kamu yakin ingin menghapus admin ini?")) {
                $.ajax({
                    url: "{{ route('user-manager.index') }}/delete/" + id,
                    type: 'GET', // Ensure you're using the correct HTTP method
                    success: function(res) {
                        alert("Success Delete Data");
                        reloadData();
                    },
                    error: function(err) {
                        alert("Error deleting data");
                    }
                });
            }
        }

        function userEdit(id) {
            user = "edit";
            $('#wilayahPerusahaan').find('option:selected').removeAttr('selected');
            $.ajax({
                url: " {{ route('user-manager.index') }}/edit/" + id,
                method: 'GET',
                success: function(res) {
                    $('#idUser').val(res.kd_user);
                    $('#nppUser').val(res.npp_user);
                    $('#namaUser').val(res.nm_user);
                    $('#email').val(res.email);
                    $('#primary_phone').val(res.primary_phone);
                    $('#primary_address').val(res.primary_address);
                    $('#namaPerusahaan').val(res.nm_perusahaan);
                    $('#wilayahPerusahaan').val(res.wilayah_perusahaan);
                    // $('select[name="wilayahPerusahaan"] option[value="' + res.wilayah_perusahaan + '"]').attr('selected',
                    //     true);
                    //  $('#wilayahPerusahaan').find('value:'+ res.wilayah_perusahaan).attr('selected',true);
                    $('#password').removeAttr('required', true);
                    $('#title-password').text("Ubah Password");
                    $('.modal-title').text("Edit Admin");
                    $('#userModal').modal('show');
                }
            });
        }



        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            if (user == "add") {
                $.ajax({
                    url: "{{ route('user-manager.save') }}",
                    type: "POST",
                    data: $('#userForm').serialize(),
                    beforeSend: function() {
                        $('.btn-save').html("Loading...");
                        $('.btn-save').attr("disabled", "");
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
                        $('#userModal').modal('hide');
                        $('.pesan').text("Simpan " + res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        // alert(res.status);
                        reloadData();
                    },
                    complete: function() {
                        $('.btn-save').html("Save");
                        $('.btn-save').removeAttr("disabled");
                        initialForm();
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('user-manager.index') }}/edit/" + $('#idUser').val(),
                    type: "POST",
                    data: $('#userForm').serialize(),
                    beforeSend: function() {
                        $('.btn-save').html("Loading...");
                        $('.btn-save').attr("disabled", "");
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
                        $('#userModal').modal('hide');
                        $('.pesan').text("Simpan " + res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        reloadData();
                    },
                    complete: function() {
                        $('.btn-save').html("Save");
                        $('.btn-save').removeAttr("disabled");
                        initialForm();
                    }
                });
            }

        });

        $('#formExportPdf').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('user-manager.pdf') }}",
                type: "POST",
                data: $('#formExportPdf').serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    $('.btn-export').html("Loading...");
                    $('.btn-export').attr("disabled", "");
                },
                error: function(res) {
                    alert("Error");
                },
                success: function(res) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(res);
                    a.href = url;
                    a.download = 'pelanggan ' + $('#start').val() + ' to ' + $('#end').val() + '.pdf';
                    document.body.append(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    $('#exportPdf').modal('hide');

                },
                complete: function() {
                    $('.btn-export').html("Export");
                    $('.btn-export').removeAttr("disabled");
                    $('#start').val("");
                    $('#end').val("");
                }
            });

        });
    </script>

    <script>
        function getFormattedDate() {
            const date = new Date();
            const timezoneOffset = -date.getTimezoneOffset(); // Menit perbedaan dari UTC

            // Fungsi untuk menambahkan padding 0 di depan angka jika kurang dari 10
            const pad = (num) => String(num).padStart(2, '0');

            const year = date.getFullYear();
            const month = pad(date.getMonth() + 1);
            const day = pad(date.getDate());
            const hours = pad(date.getHours());
            const minutes = pad(date.getMinutes());
            const seconds = pad(date.getSeconds());

            // Menghitung offset zona waktu dalam format +0700
            const offsetHours = pad(Math.floor(timezoneOffset / 60));
            const offsetMinutes = pad(timezoneOffset % 60);
            const offsetSign = timezoneOffset >= 0 ? '+' : '-';

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds} ${offsetSign}${offsetHours}${offsetMinutes}`;
        }
        $('#btn_sync').on('click', function() {
            $('#btn_sync').hide('slow');
            $('#btn_sync_load').show('slow');
            $('#alert').css('display', 'block');
            $('.type-alert').addClass('alert-warning')
            $('#message').text('Mohon Tunggu Proses Sync, Jangan Tutup Halaman');

            fetchNextPage();
        });
        var allData = [];
        var currentPage = 1;
        var perPage = 10;
        var totalPages = 1;
        var jwtToken = null; // Variabel untuk menyimpan token JWT
        

        function fetchNextPage() {
            fetchData(currentPage).done(function(response) {
                if (!response || !response.DATA) {
                    $('#btn_sync_load').hide('slow');
                    $('#btn_sync').show('slow');
                    $('#alert').css('display', 'block');
                    $('.type-alert').addClass('alert-danger')
                    $('#message').text('Sync Gagal');
                    setTimeout(() => {
                        $('.type-alert').removeClass('alert-danger')
                        $('#message').text('');
                        $('#alert').css('display', 'none');
                    }, 5000);
                    console.error('Error fetching data');
                    return false; // Jika ada error, return false
                }

                // Gabungkan data dari halaman saat ini ke allData
                allData = allData.concat(response.DATA.DATA);

                // Hitung total halaman
                totalPages = Math.ceil(response.DATA.TOTAL / perPage);
                totalPages = totalPages - 10;

                currentPage++;

                // Jika masih ada halaman, ambil halaman berikutnya
                if (currentPage <= totalPages) {
                    
                    fetchNextPage();
                } else {
                    console.log('get berhasil');
                    sendDataInBatches(allData.length, allData);
                    // $.post("{{ route('user-manager.user-sync') }}", {
                    //     data: allData,
                    //     _token: "{{ csrf_token() }}"
                    // }, function(res) {
                    //     console.log(res)
                    //     if (res.status == 'success') {
                    //         $('#btn_sync_load').hide('slow');
                    //         $('#btn_sync').show('slow');
                    //         $('#alert').show();
                    //         $('.type-alert').addClass('alert-primary')
                    //         $('#message').text('Sync Selesai');
                    //         setTimeout(() => {
                    //             $('.type-alert').removeClass('alert-primary')
                    //             $('#message').text('');
                    //             $('#alert').hide('slow');
                    //         }, 5000);

                    //     } else {
                    //         $('#btn_sync_load').hide('slow');
                    //         $('#btn_sync').show('slow');
                    //         $('#alert').show();
                    //         $('.type-alert').addClass('alert-danger')
                    //         $('#message').text('Sync Gagal');
                    //         setTimeout(() => {
                    //             $('.type-alert').removeClass('alert-danger')
                    //             $('#message').text('');
                    //             $('#alert').hide('slow');
                    //         }, 5000);
                    //     }
                    // });

                    currentPage = 1; // Reset halaman saat ini
                    allData = [];
                    // Semua data telah diambil, lakukan sesuatu dengan allData
                    // console.log(allData);
                }
            }).fail(function() {
                console.error('Error fetching data from API');
                $('#btn_sync_load').hide('slow');
                $('#btn_sync').show('slow');
                $('#alert').css('display', 'block');
                $('.type-alert').addClass('alert-danger')
                $('#message').text('Sync Gagal');
                setTimeout(() => {
                    $('.type-alert').removeClass('alert-danger')
                    $('#message').text('');
                    $('#alert').css('display', 'none');
                }, 5000);
            });
        }

        // Fungsi untuk mengambil data dari API
        function fetchData(page) {
            // Jika token belum ada, lakukan login
            if (!jwtToken) {
                return login().then(function(token) {
                    jwtToken = token; // Simpan token setelah login
                    return makeApiRequest(page); // Lakukan permintaan API setelah login
                });
            } else {
                return makeApiRequest(page); // Jika token sudah ada, langsung lakukan permintaan API
            }
        }

        // Fungsi untuk melakukan permintaan API
        function makeApiRequest(page) {
            return $.ajax({
                url: 'https://hris-pro.jamkrindo.co.id/sf7/?qlid=HrisUser.getEmployee', // Ganti dengan URL API yang sesuai
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'Authorization': 'Bearer ' + jwtToken,

                },
                data: JSON.stringify({
                    page_number: page
                }),
                dataType: 'json'
            }).then(function(response) {
                // Mengembalikan data yang diterima dari API
                return response;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data:', textStatus, errorThrown);
                $('#btn_sync_load').hide('slow');
                $('#btn_sync').show('slow');
                $('#alert').css('display', 'block');
                $('.type-alert').addClass('alert-danger')
                $('#message').text('Sync Gagal');
                setTimeout(() => {
                    $('.type-alert').removeClass('alert-danger')
                    $('#message').text('');
                    $('#alert').css('display', 'none');
                }, 5000);
                return null; // Mengembalikan null jika terjadi kesalahan
            });
        }

        var allData = []; // Array yang berisi 1364 data
        var batchSize = 10; // Ukuran batch
        // var totalData = 1364; // Total data
        var currentBatchIndex = 0; // Indeks batch saat ini
        var j = 1;

        // Fungsi untuk mengirim data ke controller dalam batch
        function sendDataInBatches(totalData, dataFix) {
            // Fungsi untuk mengirim batch ke controller
            function sendBatchToController(batch) {
                // return $.ajax({
                //     url: 'URL_CONTROLLER', // Ganti dengan URL controller yang sesuai
                //     method: 'POST',
                //     contentType: 'application/json',
                //     data: JSON.stringify(batch), // Kirim batch data dalam format JSON
                //     dataType: 'json'
                // });
                // console.log(batch);
                return $.ajax({
                    url: "{{ route('user-manager.user-sync') }}",
                    type: "POST",
                    data: {
                        data: batch,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {

                        console.log('mengirim :' + j++)
                        // Tambahkan loader atau animasi sebelum pengiriman jika diperlukan
                    },
                    success: function(res) {
                        console.log(res);


                        if (res.status == 'success') {
                            // $('#alert').show();
                            // $('.type-alert').addClass('alert-primary');
                            // $('#message').text('Sync Selesai');
                            // setTimeout(() => {
                            //     $('.type-alert').removeClass('alert-primary');
                            //     $('#message').text('');
                            //     $('#alert').hide('slow');
                            // }, 5000);
                        } else {
                            $('#alert').css('display', 'block');
                            $('.type-alert').addClass('alert-danger');
                            $('#message').text('Sync Gagal');
                            setTimeout(() => {
                                $('.type-alert').removeClass('alert-danger');
                                $('#message').text('');
                                $('#alert').css('display', 'none');
                            }, 5000);
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        $('#btn_sync_load').hide('slow');
                        $('#btn_sync').show('slow');
                        $('#alert').css('display', 'block');
                        $('.type-alert').addClass('alert-danger');
                        $('#message').text('Sync Error');
                        setTimeout(() => {
                            $('.type-alert').removeClass('alert-danger');
                            $('#message').text('');
                            $('#alert').css('display', 'none');
                        }, 5000);
                    }
                });

            }

            // Fungsi untuk mengirim semua data dalam batch
            function processBatches() {
                if (currentBatchIndex < totalData) {
                    // Ambil batch data
                    var batch = dataFix.slice(currentBatchIndex, currentBatchIndex + batchSize);

                    // Kirim batch ke controller
                    sendBatchToController(batch).done(function(response) {
                        // console.log("Batch berhasil dikirim:", response);
                        // Update indeks batch
                        currentBatchIndex += batchSize;
                        // Proses batch berikutnya
                        processBatches();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.error("Error sending batch:", textStatus, errorThrown);
                    });
                } else {
                    // totalData = 0;
                    currentBatchIndex = 0 ;
                    console.log("Semua data telah berhasil dikirim.");
                    $('#btn_sync_load').hide('slow');
                    $('#btn_sync').show('slow');
                    $('.type-alert').removeClass('alert-warning')
                     $('#message').text('');
                    $('#alert').css('display', 'block');
                    $('.type-alert').addClass('alert-primary');
                    $('#message').text('Sync Selesai');
                    lastSync();
                    setTimeout(() => {
                        $('#alert').css('display', 'none');
                        $('.type-alert').removeClass('alert-primary');
                        $('#message').text('');
                    }, 5000);
                }
            }

            // Mulai proses pengiriman batch
            processBatches();
        }



        function lastSync() {
            $('.text-sync').text('');
            $.ajax({
                url: "{{ route('user-manager.last-sync') }}",
                method: "Get",
                contentType: 'application/json',

            }).then(function(resp) {
                console.log(resp)
                $('.text-sync').text(resp.data);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Error During login : ', textStatus, errorThrown);
            })
        }

        lastSync();
        // Fungsi login untuk mendapatkan token JWT
        function login() {
            const data = {
                USERPWD: 'FD550E1EEC33EDCA8F4A6D8318C393FD4E0E1B3A',
                // USERPWD: 'B0CF009C46FFBE549B34F241690B8AA8DCAE25A3',
                USERNAME: '90711',
                ACCNAME: "jamkrindo", 
                TIMESTAMP: getFormattedDate(),
            }
            const url =
                "https://hris-pro.jamkrindo.co.id/sf7/?ofid=sfSystem.loginUser&originapp=hris_jamkrindo";

            return $.ajax({
                url: url, // Ganti dengan URL login yang sesuai
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: 'json'
            }).then(function(response) {
                console.log(response);
                // Mengembalikan token JWT dari respons
                return response.DATA.JWT_TOKEN;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error during login:', textStatus, errorThrown);
                return null; // Mengembalikan null jika terjadi kesalahan
            });
        }

        // Mulai pengambilan data
    </script>

@stop
@endsection
