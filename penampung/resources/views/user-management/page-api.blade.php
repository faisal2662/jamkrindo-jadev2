@extends('layouts.main')

@section('main')
<div class="pagetitle">
    <h1>Get api Management</h1>
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
                                <a href="{{ route('user-manager.create') }}" class="btn btn-primary btn-sm">Tambah
                                    Admin</a> 
                                <!--<button type="button" class="btn btn-primary btn-sm float-end" onclick="userAdd()">-->
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
                                @endif
                               
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <div id="alert" class="alert alert-success alert-dismissible fade  "
                         role="alert">
                        <span class="pesan text-center text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
             @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center show"
                                id="success-notification" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    <div class="result"></div>
                    <table class="table table-hover table-striped " id="users-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Departement</th>
                                
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
                                <select name="wilayah_perusahaan" id="wilayahPerusahaan" required class="form-control">
                                    <option value="" selected>Pilih Wilayah</option>
                                    @foreach ($regions as $item)
                                    <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th id="title-password">Password<span class="text-danger">*</span></th>
                            <td><input type="password" name="password" id="password" class="form-control"
                                    required>
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
                    <form action="{{ route('user-manager.pdf') }}" target="_blank"
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
		    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal" id="showPdf">Show</button>
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
		    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal" id="showExcel">Show</button>
                    <button type="submit" class="btn btn-danger btn-export btn-sm">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
    let user = "add";
    $(document).ready(function() {
        // reloadData()
    //     var token = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzI0Nzc1MCwiZXhwIjoxNzI3MzM0MTUwfQ.GLcwXVsSK2HwElrxuGqxE3pX9Dd7yWWZt7b9KrRlQEw'; // Ganti dengan token Bearer kamu
    // var allData = []; // Array untuk menampung semua data dari setiap halaman
    // var currentPage = 1; // Mulai dari halaman pertama
    // var perPage = 10; // Jumlah data per halaman (sesuai limit API)
    // var totalPages; // Variabel untuk menyimpan total halaman

    // // Fungsi untuk mengambil data dari API berdasarkan halaman
    // function fetchData(page) {
    //     return $.ajax({
    //         url: 'http://172.27.1.52:5252/hris/api/user?pageNumber=' + page,
    //         type: 'GET',
    //         dataType: 'json',
    //         headers: {
    //             Authorization: 'Bearer ' + token
    //         }
    //     }); 
    // }

    // // Fungsi untuk mengambil semua data dari setiap halaman
    // function fetchAllData() {
    //     fetchData(currentPage).done(function(res) {
    //         allData = allData.concat(res.data); // Gabungkan data dari halaman saat ini ke allData
    //         totalPages = Math.ceil(res.total / perPage); // Hitung total halaman berdasarkan total data

    //         if (currentPage < totalPages) {
    //             currentPage++;
    //             fetchAllData(); // Ambil data dari halaman berikutnya
    //         } else {
    //             // Jika semua halaman sudah diambil, tampilkan data di DataTable
    //             initializeDataTable(allData);
    //         }
    //     }).fail(function(err) {
    //         console.log('Error fetching data: ', err);
    //     });
    // }

    // // Fungsi untuk menginisialisasi DataTable setelah semua data diambil
    // function initializeDataTable(data) {
    //     $('#users-table').DataTable({
    //         destroy: true, // Hapus tabel lama jika ada
    //         data: data, // Gunakan data yang telah diambil
    //         columns: [
    //             { data: 'employee_name', title: 'Employee Name' },
    //             { data: 'division_name', title: 'Division Name' },
    //             { data: 'department_name', title: 'Department Name' }
    //         ]
    //     });
    // }

    // // Panggil fungsi fetchAllData saat halaman dimuat
    // fetchAllData();
        
//             beforeSend: function (xhr) {
//     xhr.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzIzMjg4MCwiZXhwIjoxNzI3MzE5MjgwfQ.O51Vj6ld6JDeHvHdV_fdNziFan-ZXn-PNjUeibKhr_U');
// },

//             $.ajax({
//                 url: "http://172.27.1.52:5252/hris/api/user?pageNumber=20",
//                 method : 'GET',
//                 dataType : 'json',  
//                 timeout : 0,
//                 headers: {
//                         Authorization: "Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzI0Nzc1MCwiZXhwIjoxNzI3MzM0MTUwfQ.GLcwXVsSK2HwElrxuGqxE3pX9Dd7yWWZt7b9KrRlQEw",
//                     },
  
//                 error: function(err)
//                 {
//                     console.log('Error: ', err);
//                 console.log('Status: ', err.status); // Status code
//                 console.log('Response Text: ', err.responseText); // Teks respons
//                 }
//             }).done(function (response) {
//   console.log('total :'+response.total);
//   let = total = response.total
//   $('.result').empty()
  
//   response.data.forEach(function(res){

//       $('.result').append('<li>'+ res.employee_name + '|' +res.division_name + ' | ' + res.department_name +'</li>')
//   })
// });
//             var settings = {
//   "url": "http://172.27.1.52:5252/hris/api/user?page-number=19",
//   "method": "GET",
//   "timeout": 0,
//   "headers": {
//     "Authorization": "Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzI0Nzc1MCwiZXhwIjoxNzI3MzM0MTUwfQ.GLcwXVsSK2HwElrxuGqxE3pX9Dd7yWWZt7b9KrRlQEw"
//   },
// };

// $.ajax(settings).done(function (response) {
//   console.log('total :'+response.total);
//   let = total = response.total
//   $('.result').empty()
  
//   response.data.forEach(function(res){

//       $('.result').append('<li>'+ res.employee_name + '|' +res.division_name + ' | ' + res.department_name +'</li>')
//   })
// });
            $.ajax({
                url: "{{ route('user-manager.getApi') }}",
                method : 'GET',
               
                success : function(res){
                    
                        console.log(res.data.employee_name)
                       let result = decrypt(res.data.employee_name, 'jP.J#8A6VDy[QH$d');
                        console.log('result :'+result)
                },
                error: function(err)
                {
                    console.log('Error : ' + err)
                }
            })
    });


    function reloadData(start = null, end = null) {
            var table = new DataTable('#users-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "http://172.27.1.52:5252/hris/api/user",
                    type: 'GET',
                    dataType : 'json',  
                timeout : 0,
                headers: {
                        Authorization: "Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzMyMDkyMiwiZXhwIjoxNzI3NDA3MzIyfQ._xUOWgdYQzHyH2qrJzh_MlMo_3L-2PWYZlci0yQA-Q4",
                    },
                    data: function(d) {
                        d.startDate = start;
                        d.endDate = end;
                    }
                },
                columns: [{
                        data: 'employee_name'
                    },
                    {
                        data: 'division_name'
                    },
                    {
                        data: 'department_name'
                    },               
                     
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
            // console.log('{{ csrf_field() }}')
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
                // console.log(res)
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
                    console.log(res)
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
@stop
@endsection