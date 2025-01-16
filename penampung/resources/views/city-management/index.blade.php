@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>City</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">City</li>
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
                                <button type="button" class="btn btn-primary btn-sm float-end" onclick="cityAdd()">
                                    Tambah Data
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="alert" class="alert text-center alert-success alert-dismissible fade  "
                        role="alert">
                        <span class="pesan text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table datatable table-hover table-striped" id="cities-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kota</th>
                                <th>Kab / Kota </th>
                                <th>Kode Pos</th>
                                <th>Provinsi</th>
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
<div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ubah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="cityForm">
                    @csrf
                    <table class="table table-borderless">
                        <input type="hidden" name="kd_kota" id="kd_kota">
                        <tr>
                            <th>Nama Kota <span class="text-danger" >*</span></th>
                            <td><input type="text" name="nm_kota" id="nama_kota" class="form-control" required>
                            </td>
                        </tr>
                        <tr>
                            <th>Kota/Kab <span class="text-danger" >*</span></th>
                            <td><select name="tipe" id="tipe" class="form-control" required>
                                    <option value="" disabled selected>Pilih Kota</option>
                                    <option value="KABUPATEN">Kabupaten</option>
                                    <option value="KOTA">Kota</option>
                                </select></td>
                        </tr>
                        <tr>
                            <th>Provinsi <span class="text-danger" >*</span></th>
                            <td><select name="kd_provinsi" id="provinsi" class="form-control" required>
                                    <option value="" disabled >Pilih Provinsi</option>
                                    @foreach ($provinces as $item)
                                    <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                    @endforeach
                                </select></td>
                        </tr>
                        <tr>
                            <th>Kode Pos</th>
                            <td><input type="text" name="postal_code" id="postal_code" class="form-control" >
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
    let city = "add";
    $(document).ready(function() {
        reloadData();
    });

    function reloadData() {
        var table = new DataTable('#cities-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('city-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'nm_kota'
                },
                {
                    data: 'tipe'
                },
                {
                    data: 'postal_code'
                },
                {
                    data: 'provinsi.nm_provinsi'
                },
                {
                    data: 'action'
                },
            ]
        });
    }


    //initial form
    function initialForm() {
        $('#kd_kota').val("");
        $('#nama_kota').val("");
        $('#postal_code').val("");
        $('#provinsi').val("");
        $('#tipe').val("");


    }


    function cityAdd() {
        city = "add";
        initialForm();
        $('select[name="provinsi"] option[value=" "]').attr('selected',
            'selected');
        $('.modal-title').text("Tambah Kota");
        $('#cityModal').modal('show');
    }

    function cityDelete(id) {
        if (confirm("Kamu yakin ingin menghapus user ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('city-manager.index') }}/delete/" + id,
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

    function cityEdit(id) {
        city = "edit";
        // $('select[name="provinsi"] option[value=""]').removeAttr('selected');
        $.ajax({
            url: " {{ route('city-manager.index') }}/edit/" + id,
            method: 'GET',
            success: function(res) {
                console.log(res)
                $('#kd_kota').val(res.kd_kota);
                $('#nama_kota').val(res.nm_kota);
                $('#postal_code').val(res.postal_code);
                $('#tipe').val(res.tipe);
                $('select[name="kd_provinsi"] option[value="' + res.kd_provinsi + '"]').attr('selected',
                    'selected');
                $('.modal-title').text("Edit Kota");
                $('#cityModal').modal('show');
            }
        });
    }


    $('#cityForm').on('submit', function(e) {
        e.preventDefault();

        if (city == "add") {
            $.ajax({
                url: "{{ route('city-manager.save') }}",
                type: "POST",
                data: $(this).serializeArray(),
                beforeSend: function() {
                    $('.btn-save').html("Loading...");
                    $('.btn-save').attr("disabled", "");
                },
                error: function(res) {
                    $('#cityModal').modal('hide');

                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
                    alert("Error");
                },
                success: function(res) {
                    $('#cityModal').modal('hide');
                    $('.pesan').text("Data berhasil disimpan");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
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
                url: "{{ route('city-manager.index') }}/update/" + $('#kd_kota').val(),
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
                        }, 7000);
                    alert("Error");
                },
                success: function(res) {
                    // console.log(res)
                    $('#cityModal').modal('hide');
                    $('.pesan').text("Data berhasil diubah");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
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
</script>
@stop

@endsection
