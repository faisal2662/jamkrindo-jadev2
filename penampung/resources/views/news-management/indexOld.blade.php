@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>News</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">News</li>
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
                                @if ($role->can_create == 'Y')
                                <a href="{{ route('news-manager.create') }}" class="btn btn-sm btn-primary">Tambah
                                    Data</a>
                                @endif
                            </div>
                        </div>
                    </div>
                       @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade text-center  show  "
                                    role="alert" id="success-notification" >
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <table class="table " id="newsTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
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



@section('script')
<script>
    let news = "add";
    $(document).ready(function() {
        reloadData();
        tinymce.init({
            selector: '#deskripsi'
        });
          var $notification = $('#success-notification');
            if ($notification.length > 0) {
                // Tampilkan notifikasi
                $notification.fadeIn('slow');
                // Menghilangkan notifikasi dengan delay
                setTimeout(function() {
                    $notification.fadeOut('slow');
                }, 10000); // Delay sebelum notifikasi menghilang (dalam milidetik)
            }
    });

    function reloadData() {
        var table = new DataTable('#newsTable', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('news-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'judul_berita'
                },
                {
                    data: 'tgl_upload'
                },
                {
                    data: 'status_berita'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    //initial form


    function newsDelete(id) {
        if (confirm("Kamu yakin ingin menghapus berita ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('news-manager.index') }}/delete/" + id,
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
</script>
@stop
@endsection