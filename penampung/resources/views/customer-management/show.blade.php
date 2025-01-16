@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail Customer Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Customer Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="mb-2">
        <a href="{{ route('customer-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="profile">
        <div class="row bg-white p-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade text-center show" id="success-notification"
                    role="alert">
                    {{ session('success') }} <span id="pesan"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="alert alert-danger alert-dismissible fade text-center show" style="display: none;" id="notification"
                role="alert">
                <span id="pesan_notification"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Cabang</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->nama_customer }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">User ID</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->userid_customer }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->hp_customer }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->email_customer }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Cabang</div>
                    @if ($customer->branch)
                        <div class="col-lg-9 col-md-8">{{ $customer->branch->nm_cabang }}</div>
                    @else
                        <div class="col-lg-9 col-md-8"></div>
                    @endif

                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8">
                        @if ($customer->status_customer == 'Active')
                            <span class="text-bg-success badge">{{ $customer->status_customer }}</span>
                        @else
                            <span class="badge text-bg-danger ">{{ $customer->status_customer }}</span>
                        @endif
                    </div>
                </div>
                @if ($customer->foto_customer)
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Foto Customer</div>
                        <div class="col-lg-9 col-md-8">
                            <img src="{{ asset('assets/img/customer/' . $customer->foto_customer) }}" width="300px"
                                class="img-thumbnail" alt="">
                        </div>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Referral Customer</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->kd_referral_customer }}</div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->company_name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Provinsi</div>

                    <div class="col-lg-9 col-md-8">{{ $customer->company_province }}</div>

                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kota</div>

                    <div class="col-lg-9 col-md-8">{{ $customer->company_city }}</div>

                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Terms</div>
                    <div class="col-lg-9 col-md-8">{{ $customer->terms }}</div>
                </div>
                <hr style="border: 1px dashed ;">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col"><span class="label">Created By : </span> {{ $customer->created_by }} </div>
                        <div class="col"><span class="label">Updated By : </span> {{ $customer->updated_by }} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{ $customer->deleted_by }} </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="label">Created Date : </span>
                            {{ Carbon\Carbon::parse($customer->created_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Updated By : </span>
                            {{ Carbon\Carbon::parse($customer->updated_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Deleted By : </span>
                            {{ Carbon\Carbon::parse($customer->deleted_date)->translatedFormat('l, d F Y') }} </div>

                    </div>
                </div>
            </div>
        </div>

    </section> <br>
    <section class="profile">
        <div class="row bg-white p-4">
            <h5 class="card-title">Log Perubahan</h5>
            <div class="table-responsive">
                <table class="table" id="table-log" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Aprrove By</th>
                            <th>Approve Date</th>
                            <th>Disapprove By</th>
                            <th>Disapprove Date</th>

                            <th>Action</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <div class="modal fade" id="detail" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>




                <div class="modal-body" id="dis-edit">
                    <div class="row">
                        <div class="col">
                            <h5>Before</h5>
                            <ul class="list-group" id="list_before">

                            </ul>
                        </div>
                        <div class="col">
                            <h5>After</h5>
                            <ul class="list-group" id="list_after">

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <form id="myForm" action="{{ route('customer-manager.approve') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_log" id="id_log">
                        <span id="btn-aksi">
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="submitForm('reject')">Tolak</button>
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="submitForm('approve')">Setuju</button>
                        </span>
                    </form>

                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->
    <div class="modal fade" id="detail-delete" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Kamu yakin ingin melakukan hapus ? </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="dis-delete">

                    <h6> jika kamu menghapus data ini, data akan hilang</h6>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <form id="myFormDelete" action="{{ route('customer-manager.destroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_log" id="id_log_delete">
                        <input type="hidden" name="kd_customer" id="id_customer">
                        <span id="btn-aksi">
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="submitFormDelete('reject')">Tolak</button>
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="submitFormDelete('approve')">Setuju</button>
                        </span>
                    </form>

                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->
    <div class="modal fade" id="confirm" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Kamu Yakin ingin <span id="alert-confirm"></span>?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tdak</button>

                    <button type="button" class="btn btn-sm" id="btn-confirm">Ya</button>

                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->
@section('script')

    <script>
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



        function submitForm(action) {

            $('#alert-confirm').text('');
            $('#alert-confirm').text(action === 'reject' ? 'Menolak ini' : 'Menyetujui ini');

            // Menambahkan input tersembunyi ke form
            $('<input>').attr({
                type: 'hidden',
                name: 'action',
                value: action
            }).appendTo('#myForm');
            if (action === 'reject') {
                $('#btn-confirm').removeClass('btn-primary')
                $('#btn-confirm').addClass('btn-danger')
            } else {
                $('#btn-confirm').removeClass('btn-danger')
                $('#btn-confirm').addClass('btn-primary')

            }
            // Tampilkan modal konfirmasi
            $('#confirm').modal('show');

            // Ketika tombol "Ya" di modal diklik
            $('#btn-confirm').off('click').on('click', function() {
                // Kirim form setelah konfirmasi
                $('#myForm').submit();
            });
        }

        function submitFormDelete(action) {

            $('#alert-confirm').text('');
            $('#alert-confirm').text(action === 'reject' ? 'Menolak ini' : 'Menyetujui ini');

            // Menambahkan input tersembunyi ke form
            $('<input>').attr({
                type: 'hidden',
                name: 'action',
                value: action
            }).appendTo('#myFormDelete');
            if (action === 'reject') {
                $('#btn-confirm').removeClass('btn-primary')
                $('#btn-confirm').addClass('btn-danger')
            } else {
                $('#btn-confirm').removeClass('btn-danger')
                $('#btn-confirm').addClass('btn-primary')

            }
            // Tampilkan modal konfirmasi
            $('#confirm').modal('show');
            $('#detail-delete').modal('hide');

            // Ketika tombol "Ya" di modal diklik
            $('#btn-confirm').off('click').on('click', function() {
                // Kirim form setelah konfirmasi
                $('#myFormDelete').submit();

            });
        }

        function detail_log_hapus(id) {
            let userRole = false;
            let posisi = "{{ auth()->user()->position_name }}";
            let posisi_name = ["Staff", "Staf", "Manajer"];

            posisi_name.forEach(function(item) {
                if (posisi.includes(item)) {
                    userRole = true;

                }
            });
            if (userRole) {
                $('#notification').show('fadeIn')
                $('#pesan_notification').text('Kamu tidak data melakukan aktivitas ini');
                // var position = $(window).scrollTop();
                $(window).scrollTop($('page-itle'));
                setTimeout(() => {
                    $('#notification').hide('fadeOut')
                    $('#pesan_notification').text('');
                }, 10000);
                return false;
            }
            $('#id_log_delete').val(id);
            $("#id_customer").val('{{ $customer->kd_customer }}');
            $('#detail-delete').modal('show');

        }

        function detail_log(id) {
            $('#list_after').html("")
            $('#list_before').html("")
            $('#id_log').val("")
            $.ajax({
                url: "{{ route('customer-manager.get_log_detail') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
            }).done(function(data) {
                let userRole = false;
                let posisi = "{{ auth()->user()->position_name }}";
                let posisi_name = ["Pemimpin", "Manajer"];

                posisi_name.forEach(function(item) {
                    if (posisi.includes(item)) {
                        userRole = true;

                    }
                });
                $('#btn-aksi').show();

                if (data.status_change === 'Reject' || data.status_change === 'Approve' || !userRole) {
                    $('#btn-aksi').hide();
                }
                let mapping = {
                    "hp_customer": "No. Hp",
                    "kd_cabang": "Kode Cabang",
                    "nama_customer": "Nama Customer",
                    "email_customer": "Email Customer",
                    "userid_customer": "User ID Customer",
                    "status_customer": "Status Customer",
                    "company_name": "Nama Perusahaan",
                    "company_province": "Provinsi Perusahaan",
                    "company_city": "Kota Perusahaan",
                    "terms": "Terms",
                    "nm_cabang": "Nama Cabang"
                };
                $('#id_log').val(data.id);
                let before = jQuery.parseJSON(data.before_data);
                let after = jQuery.parseJSON(data.json_data);

                for (let data_after in after) {
                    if (data_after in before) {
                        if (data_after in mapping) {

                            // Gunakan nama alias dari objek mapping
                            $('#list_after').append(
                                `<li class="list-group-item"><strong>${mapping[data_after]}</strong> : ${after[data_after]}</li>`
                            );
                        }
                    }
                }
                for (let data_before in before) {
                    if (data_before in after) {
                        if (data_before in mapping) {
                            // Gunakan nama alias dari objek mapping
                            $('#list_before').append(
                                `<li class="list-group-item"><strong>${mapping[data_before]}</strong> : ${before[data_before]}</li>`
                            );
                        }
                    }
                }

                $('#detail').modal('show');
            })

        }


        function reloadData() {
            var table = new DataTable('#table-log', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer-manager.get_log') }}",
                    type: 'POST',
                    data: function(d) {
                        d.kd_customer = '{{ $customer->kd_customer }}';
                        d._token = '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'maker'
                    },
                    {
                        data: 'maker_date'
                    },
                    {
                        data: 'approve'
                    },
                    {
                        data: 'approve_date'
                    },
                    {
                        data: 'reject'
                    },
                    {
                        data: 'reject_date'
                    },
                    {
                        data: 'act'
                    }
                ]
            });
        }
    </script>
    <script>
        //             let bussiness = "add";
        //             $(document).ready(function() {
        //                 reloadData();
        //             });

        //             function reloadData() {
        //                 var baseUrl = "{{ route('customer-manager.business-manager.getDataUsaha', ['id' => ' ']) }}";
        //                 let id = $('#kd_customer').val();
        //                 var url = baseUrl.replace('/get-data-usaha/', '/get-data-usaha/' + id);

        //                 var table = new DataTable('#business-table', {
        //                     destroy: true,
        //                     processing: true,
        //                     serverSide: true,
        //                     ajax: {
        //                         url: url,
        //                         type: 'GET'
        //                     },
        //                     columns: [{
        //                             data: 'no'
        //                         },
        //                         {
        //                             data: 'nama_usaha'
        //                         },
        //                         {
        //                             data: 'npwp_usaha'
        //                         },
        //                         {
        //                             data: 'kota.nm_kota'
        //                         },
        //                         {
        //                             data: 'provinsi.nm_provinsi'
        //                         },
        //                         {
        //                             data: 'action'
        //                         }
        //                     ]
        //                 });
        //             }

        //             //initial form
        //             function initialForm() {
        //                 $('#kd_usaha').val("");
        //                 $('#nama_usaha').val("");
        //                 $('#npwp_usaha').val("");
        //                 $('#kota_usaha').val("");
        //                 $('#provinsi_usaha').val("");
        //             }


        //             function reloadKota() {
        //                 $.ajax({
        //                     url: "{{ route('getDataKotaAll') }}",
        //                     type: "GET",
        //                     success: function(res) {
        //                         $('#kota_usaha').empty();
        //                         res.forEach(function(city) {
        //                             $('#kota_usaha').append(
        //                                 `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
        //                         })
        //                     },
        //                     error: function(err) {
        //                         alert("Gagal mengambil kota");
        //                     }

        //                 })
        //             }

        //   $('#provinsi_usaha').on('change', function() {
        //                 // console.log($(this).val());
        //                 $.ajax({
        //                     url: "{{ route('customer-manager.index') }}/get-data-kota/" + $(this).val(),
        //                     type: "GET",
        //                     success: function(res) {
        //                         $('#kota_usaha').empty();
        //                         res.forEach(function(city) {
        //                             $('#kota_usaha').append(
        //                                 `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
        //                         })
        //                     },
        //                     error: function(err) {
        //                         alert("Gagal mengambil kota");
        //                     }

        //                 })
        //             })


        //             function businessAdd() {
        //                 business = "add";
        //                 initialForm();
        //                 $('.modal-title').text("Tambah Usaha");
        //                 $('#businessModal').modal('show');
        //             }

        //             function businessDelete(id) {
        //                 if (confirm("Kamu yakin ingin menghapus user ini?")) {
        //                     var baseUrl = "{{ route('customer-manager.business-manager.delete', ['id' => ' ']) }}";
        //                     var url = baseUrl.replace('/delete/', '/delete/' + id);
        //                     $.ajax({
        //                         url: url,
        //                         type: 'GET', // Ensure you're using the correct HTTP method
        //                         success: function(res) {
        //                             alert("Success Delete Data");
        //                             reloadData();
        //                         },
        //                         error: function(err) {
        //                             alert("Error deleting data");
        //                         }
        //                     });
        //                 }
        //             }

        //             function businessEdit(id) {
        //                 business = "edit";
        //                 var baseUrl = "{{ route('customer-manager.business-manager.edit', ['id' => ' ']) }}";
        //                 var url = baseUrl.replace('/edit/', '/edit/' + id);
        //                 $.ajax({
        //                     url: url,
        //                     method: 'GET',
        //                     success: function(res) {
        //                         // console.log(res)
        //                       $('#kd_usaha').val(res.kd_usaha);
        //                         $('#nama_usaha').val(res.nama_usaha);
        //                         $('#npwp_usaha').val(res.npwp_usaha);
        //                         $('#provinsi_usaha').val(res.provinsi_usaha).attr(
        //                             'selected',
        //                             'selected');
        //                         $('#kota_usaha').val(res.kota_usaha).attr(
        //                             'selected',
        //                             'selected');
        //                                      $('.modal-title').text("Edit Usaha");
        //                         $('#businessModal').modal('show');
        //                     }
        //                 });
        //             }



        //             $('#businessForm').on('submit', function(e) {
        //                 e.preventDefault();
        //                 if (business == "add") {
        //                     $.ajax({
        //                         url: "{{ route('customer-manager.business-manager.saveUsaha') }}",
        //                         type: "POST",
        //                         data: $('#businessForm').serialize(),
        //                         beforeSend: function() {
        //                             $('.btn-save').html("Loading...");
        //                             $('.btn-save').attr("disabled", "");
        //                         },
        //                         error: function(res) {

        //                             $('.pesan').text(res.status);
        //                             $('#alert').addClass('show').fadeIn();
        //                             setTimeout(
        //                                 function() {
        //                                     $('#alert').removeClass('show').fadeOut()
        //                                 }, 3000);
        //                             alert("Error");
        //                         },
        //                         success: function(res) {
        //                             $('#businessModal').modal('hide');
        //                             $('.pesan').text("Simpan " + res.status);
        //                             $('#alert').addClass('show').fadeIn();
        //                             setTimeout(
        //                                 function() {
        //                                     $('#alert').removeClass('show').fadeOut()
        //                                 }, 3000);
        //                             // alert(res.status);
        //                             reloadData();
        //                         },
        //                         complete: function() {
        //                             $('.btn-save').html("Save");
        //                             $('.btn-save').removeAttr("disabled");
        //                             initialForm();
        //                         }
        //                     });
        //                 } else {
        //                     var baseUrl = "{{ route('customer-manager.business-manager.update', ['id' => ' ']) }}";
        //                     let id = $('#kd_usaha').val();
        //                     var url = baseUrl.replace('/update/', '/update/' + id);
        //                     $.ajax({
        //                         url: url,
        //                         type: "POST",
        //                         data: $('#businessForm').serialize(),
        //                         beforeSend: function() {
        //                             $('.btn-save').html("Loading...");
        //                             $('.btn-save').attr("disabled", "");
        //                         },
        //                         error: function(res) {

        //                             $('.pesan').text(res.status);
        //                             $('#alert').addClass('show').fadeIn();
        //                             setTimeout(
        //                                 function() {
        //                                     $('#alert').removeClass('show').fadeOut()
        //                                 }, 3000);
        //                             alert("Error");
        //                         },
        //                         success: function(res) {
        //                             console.log(res)
        //                             $('#businessModal').modal('hide');
        //                             $('.pesan').text("Simpan " + res.status);
        //                             $('#alert').addClass('show').fadeIn();
        //                             setTimeout(
        //                                 function() {
        //                                     $('#alert').removeClass('show').fadeOut()
        //                                 }, 3000);
        //                             // alert(res.status);
        //                             reloadData();
        //                             reloadKota();
        //                         },
        //                         complete: function() {
        //                             $('.btn-save').html("Save");
        //                             $('.btn-save').removeAttr("disabled");
        //                             initialForm();
        //                         }
        //                     });
        //                 }

        //             });
        //
    </script>
@stop


@endsection
