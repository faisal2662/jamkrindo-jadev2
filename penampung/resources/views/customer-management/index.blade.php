@extends('layouts.main')

@section('main')
    <div class="pagetitle">
        <h1>Customer Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Customer Management</li>
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
                                        <!--<button type="button" class="btn btn-primary btn-sm float-end" onclick="customerAdd()">-->
                                        <!--    Tambah Data-->
                                        <!--</button>-->
                                        <button type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#exportPdf">
                                            <i class="bi bi-filetype-pdf"> </i> PDF
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#exportExcel">
                                            <i class="bi bi-file-earmark-excel"> </i> Excel
                                        </button>
                                        {{-- <a href="{{ route('customer-manager.excel') }}" class="btn btn-sm btn-success "><i class="bi bi-excel"></i>Excel</a> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                        <!-- Table with stripped rows -->
                        <div id="alert" class="alert alert-dismissible fade position-absolute "
                            style="margin-left: 400px ; margin-top: -20px;" role="alert">
                            <span class="pesan text-capitalize"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center show"
                                id="success-notification" role="alert">
                                {{ session('success') }} <span id="pesan"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <table class="table  table-hover table-striped " id="customers-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Customer</th>
                                    <th>Status Perubahan</th>
                                    <th>Cabang</th>
                                    <th>Email</th>
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
    <div class="modal fade" id="customerModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customerForm">
                        @csrf
                        <table class="table table-borderless">
                            <input type="hidden" name="kd_customer" id="kd_customer">
                            <tr>
                                <th>Nama Customer <span class="text-danger">*</span></th>
                                <td><input type="text" name="nama_customer" id="nama_customer" class="form-control"
                                        required></td>
                            </tr>
                            <tr>
                                <th>Nomor Telpon <span class="text-danger">*</span></th>
                                <td><input type="text" name="hp_customer" id="hp_customer" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Email Customer<span class="text-danger">*</span></th>
                                <td><input type="email" name="email_customer" id="email_customer" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <th>User ID<span class="text-danger">*</span></th>
                                <td><input type="text" name="userId" id="userId" class="form-control" required>
                                </td>
                            </tr>
                            <tr id="baris-password">
                                <th>Password<span class="text-danger">*</span></th>
                                <td><input type="password" name="password" id="password" class="form-control" required>
                                </td>
                            </tr>
                            {{-- <tr>
                                <th>Password Konfirmasi<span class="text-danger">*</span></th>
                                <td><input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </td>
                            </tr> --}}
                            <tr>
                                <th>Cabang <span class="text-danger">*</span></th>
                                <td>
                                    <select name="cabang" id="cabang" required class="form-control">
                                        <option value="" disabled selected>Pilih Cabang</option>
                                        @foreach ($branch as $item)
                                            <option value="{{ $item->kd_cabang }}">{{ $item->nm_cabang }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Customer <span class="text-danger">*</span></th>
                                <td>
                                    <select name="status_customer" id="status_customer" required class="form-control">
                                        <option value="" disabled selected>Pilih Status</option>

                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Kode Referral </th>
                                <td><input type="text" name="kode_referral" id="kode_referral" class="form-control">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah Kamu yakin ingin melakukan mengajukan hapus
                        ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Userid : <strong><span id="delete-nama-customer"></span></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-hapus" class="btn btn-danger">Ya, hapus</button>
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
                    <form action="{{ route('customer-manager.cetakPDF') }}" target="_blank" method="post">
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
                    <form action="{{ route('customer-manager.excel') }}" id="formExportExcel" target="_blank"
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
        let customer = "add";
        $(document).ready(function() {
            var $notification = $('#success-notification');

            if ($notification.length > 0) {
                // Tampilkan notifikasi
                $notification.fadeIn('slow');
                // Menghilangkan notifikasi dengan delay
                setTimeout(function() {
                    $notification.fadeOut('slow');
                }, 7000); // Delay sebelum notifikasi menghilang (dalam milidetik)
            }
            reloadData();
        });

        function reloadData(start = null, end = null) {
            var table = new DataTable('#customers-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer-manager.getData') }}",
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
                        data: 'nama_customer'
                    },

                    {
                        data: 'status_perubahan'
                    },

                    {
                        data: 'branch.nm_cabang'
                    },
                    {
                        data: 'email_customer'
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
            $('#kd_customer').val("");
            $('#nama_customer').val("");
            $('#hp_customer').val("");
            $('#email_customer').val("");
            $('#userId').val("");
            $('#password').val("");
            // $('#password_confirmation').val("");
            $('#status_customer').val("");
            $('#cabang').val("");
            $('#kode_referral').val("");
        }

        function customerAdd() {
            customer = "add";
            initialForm();
            $("#password").prop('required', true);
            $('.modal-title').text("Tambah Customer");
            $('#customerModal').modal('show');
        }

        function customerDelete(id, name) {
            // if (confirm("Kamu yakin ingin menghapus user ini?")) {
            //     $.ajax({
            //         url: "{{ route('customer-manager.index') }}/delete/" + id,
            //         type: 'GET', // Ensure you're using the correct HTTP method
            //         success: function(res) {
            //             alert("Success Delete Data");
            //             reloadData();
            //         },
            //         error: function(err) {
            //             alert("Error deleting data");
            //         }
            //     });
            // }


            $('#hapus').modal('show');
            $('#delete-nama-customer').text(name);
            console.log(id);
            $('#btn-hapus').on('click', function() {
                $.ajax({
                    url: "{{ route('customer-manager.submit_delete') }}",
                    type: 'POST', // Ensure you're using the correct HTTP method
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status == false) {
                            $('#hapus').modal('hide');
                            $('.pesan').text(res.message);
                            $('#alert').addClass('alert-danger');
                            $('#alert').addClass('show').fadeIn();
                            setTimeout(
                                function() {
                                    $('#alert').removeClass('alert-danger');
                                    $('#alert').removeClass('show').fadeOut()
                                    $('.pesan').text("");
                                }, 7000);
                            reloadData();
                        } else {
                            $('#hapus').modal('hide');
                            $('.pesan').text("Pengajuan hapus " + res.status);
                            $('#alert').addClass('alert-success');
                            $('#alert').addClass('show').fadeIn();
                            setTimeout(
                                function() {
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').removeClass('show').fadeOut()
                                    $('.pesan').text("");
                                }, 3000);
                            reloadData();
                        }
                    },
                    error: function(err) {
                        alert("Error deleting data");
                    }
                });
            });
        }

        function customerEdit(id) {
            customer = "edit";
            $.ajax({
                url: " {{ route('customer-manager.index') }}/edit/" + id,
                method: 'GET',
                success: function(res) {
                    // console.log(res)
                    $('#kd_customer').val(res.kd_customer);
                    $('#nama_customer').val(res.nama_customer);
                    $('#hp_customer').val(res.hp_customer);
                    $('#email_customer').val(res.email_customer);
                    $('#userId').val(res.userid_customer);
                    // $('select[name="cabang"] option[value="' + res.branch.kd_cabang + '"]').attr('selected',
                    //     'selected');
                    $('select[name="cabang"]').find('option[value="' + res.kd_cabang + '"]')
                        .prop(
                            'selected', true);
                    $('select[name="status_customer"]').find('option[value="' + res.status_customer + '"]')
                        .prop(
                            'selected', true);

                    $('#kode_referral').val(res.kd_referral_customer);
                    $('#password').removeAttr('required');
                    $('.modal-title').text("Edit Customer");
                    $('#customerModal').modal('show');
                }
            });
        }



        $('#customerForm').on('submit', function(e) {
            e.preventDefault();
            console.log($('#customerForm').serialize())
            if (customer == "add") {
                $.ajax({
                    url: "{{ route('customer-manager.save') }}",
                    type: "POST",
                    data: $('#customerForm').serialize(),
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
                        $('#customerModal').modal('hide');
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
                    url: "{{ route('customer-manager.index') }}/update/" + $('#kd_customer').val(),
                    type: "POST",
                    data: $('#customerForm').serialize(),
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
                        console.log(res)
                        $('#customerModal').modal('hide');
                        $('.pesan').text("Simpan " + res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        // alert(res.status);
                        reloadData();
                        $("#status_customer option:selected").each(function() {
                            $(this).removeAttr('selected');
                        });
                        $("#cabang option:selected").each(function() {
                            $(this).removeAttr('selected');
                        });
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
                url: "{{ route('customer-manager.cetakPDF') }}",
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
@stop
@endsection
