@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>Province</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Province</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
</head>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col align-self-end">

                            <div class="mb-3 float-end mt-4">
                                <!-- Button trigger modal -->
                                @if ($role->can_create == 'Y')
                                <button type="button" class="btn btn-primary btn-sm float-end" onclick="provinceAdd()">
                                    Tambah Data
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="alert" class="alert alert-success  alert-dismissible fade text-center"
                       role="alert">
                        <span class="pesan text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table datatable table-hover table-striped" id="provincies-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Provinsi</th>
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


<!-- Modal -->
<div class="modal fade" id="provinceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ubah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="provinceForm">
                    @csrf
                    <table class="table table-borderless">
                        <input type="hidden" name="kd_provinsi" id="kd_provinsi">
                        <tr>
                            <th>Nama Provinsi <span class="text-danger" >*</span></th>
                            <td><input type="text" name="nm_provinsi" id="nama_provinsi" class="form-control"
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

<div class="modal fade" id="provinceDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Data Kota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form method="post" id="provinceForm">
                        @csrf
                        <table class="table table-borderless">
                            <input type="hidden" name="kd_provinsi" id="kd_provinsi">
                            <tr>
                                <th>Nama Provinsi</th>
                                <td><input type="text" name="nama_provinsi" id="nama_provinsi" class="form-control"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <th>Kode Provinsi</th>
                                <td><input type="text" name="kode_provinsi" id="kode_provinsi" class="form-control"
                                        required></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary w-75 btn-save">Simpan</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form> --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>

                        <!-- List group with active and disabled items -->
                        <ul class="list-group " id="list-kota">
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">A fourth item</li>
                        </ul><!-- End ist group with active and disabled items -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- Modal -->
<div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Kamu yakin ingin menghapus data ini?
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <div class="modal-body">
                </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">ya, hapus</button>
            </div>
        </div>
    </div>
</div>
@section('script')

<script>
    let provinsi = "add";
    $(document).ready(function() {
        reloadData();
    });



    function reloadData() {


        var table = new DataTable('#provincies-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('province-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'nm_provinsi'
                },


                {
                    data: 'action'
                }
            ]
        });
    }

    //initial form
    function initialForm() {
        $('#kd_provinsi').val("");
        $('#nama_provinsi').val("");
    }


    function provinceAdd() {
        province = "add";
        initialForm();

        $('.modal-title').text("Tambah Kota");
        $('#provinceModal').modal('show');
    }

    function provinceDelete(id) {
        if (confirm("Kamu yakin ingin menghapus user ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('province-manager.index') }}/delete/" + id,
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

    function provinceShow(id) {
        // province = "edit";

        $.ajax({
            url: " {{ route('province-manager.index') }}/get-data-kota/" + id,
            method: 'GET',
            success: function(res) {
                // console.log(res);
                let row = '';
                $('.card-title').text(res.nm_provinsi)
                res.city.forEach(function(data) {
                    // console.log(data)
                    row += `
                         <li class="list-group-item">${data.nm_kota}</li>

                        `;
                })
                $('#list-kota').html(row)
                $('#provinceDetailModal').modal('show');
            }
        });
    }

    function provinceEdit(id) {
        province = "edit";

        $.ajax({
            url: " {{ route('province-manager.index') }}/edit/" + id,
            method: 'GET',
            success: function(res) {
                // console.log(res)
                $('#kd_provinsi').val(res.kd_provinsi);
                $('#nama_provinsi').val(res.nm_provinsi);
                $('.modal-title').text("Edit Provinsi");
                $('#provinceModal').modal('show');
            }
        });
    }


    $('#provinceForm').on('submit', function(e) {
        e.preventDefault();

        if (province == "add") {
            $.ajax({
                url: "{{ route('province-manager.save') }}",
                type: "POST",
                data: $(this).serializeArray(),
                beforeSend: function() {
                    $('.btn-save').html("Loading...");
                    $('.btn-save').attr("disabled", "");
                },
                error: function(res) {
                    $('#provinceModal').modal('hide');

                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
                    alert("Error");
                },
                success: function(res) {
                    $('#provinceModal').modal('hide');
                    $('.pesan').text("Data berhasil disimpan");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 8000);
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
            // console.log($(this).serializeArray())
            $.ajax({
                url: "{{ route('province-manager.index') }}/update/" + $('#kd_provinsi').val(),
                type: "POST",
                data: $(this).serializeArray(),
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
                    // console.log(res)
                    $('#provinceModal').modal('hide');
                    $('.pesan').text("Data berhasil diubah");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 8000);
                    // alert(res.status);
                    // table.destroy();
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
</script>
@stop

@endsection
