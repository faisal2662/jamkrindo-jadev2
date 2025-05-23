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
                    <div class="row" id="box-sync" style="display: none;">
                        <div class="col-12">
                            <div class="alert" id="box-alert"><p id="message-sync" class="text-center"></p></div>
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
                                <th>Kategori</th>
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
                    data: 'news_title'
                },
                {
                    data: 'category'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    //initial form
    $('#btn-sync').on('click', function(){
        $.ajax({
            url: "http://10.220.60.63/news-management/movingData",
            type: 'GET',
            beforeSend: function(data){
                console.log('fas')
                $('#message-sync').text('');
                if($('#box-alert').hasClass('alert-danger') || $('#box-alert').hasClass('alert-success')){
                    $('#box-alert').removeClass('alert-success')
                    $('#box-alert').removeClass('alert-danger')
                }
                $('#message-sync').text('Tunggu');
                
                $('#btn-sync').text('Loading...')
                $('#btn-sync').attr('disabled', 'true')
                $('#box-alert').addClass('alert-warning')
                $('#box-sync').show('slow');
            },
            success: function(data){
                console.log(data)
                if($('#box-alert').hasClass('alert-danger') || $('#box-alert').hasClass('alert-warning')){
                    $('#box-alert').removeClass('alert-warning')
                    $('#box-alert').removeClass('alert-danger')
                }
                $('#box-alert').addClass('alert-success')
                $('#box-sync').show('slow');
                $('#message-sync').text('Sync Berhasil');
                setTimeout(function(){
                    $('#box-sync').hide('slow');

                },7000);
                $('#btn-sync').text('Sync')
                $('#btn-sync').removeAttr('disabled')
            }, 
            error: function(data){
                console.log(data);
                if($('#box-alert').hasClass('alert-warning') || $('#box-alert').hasClass('alert-success')){
                    $('#box-alert').removeClass('alert-warning')
                    $('#box-alert').removeClass('alert-success')
                }
                $('#box-alert').addClass('alert-danger')
                $('#box-sync').show('slow');
                $('#message-sync').text('Terjadi Kesalahan');
                setTimeout(function(){
                    $('#box-sync').hide('slow');
    
                },7000)
                $('#btn-sync').text('Sync')
                $('#btn-sync').removeAttr('disabled')
            },
            // complete: function(data){
            //     $('#box-message').hide('slow');
            // }
        })
    });


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