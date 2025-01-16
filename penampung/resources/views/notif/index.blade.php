@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Semua Notifikasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Semua Notifikasi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="profile">
        <div class="row bg-white p-4">
            <h5 class="card-title">Notifikasi</h5>
            <table class="table" id="notif-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tautan</th>
                        <th>Status</th>
                        <th>Keterangan</th>

                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </section>
@section('script')
    <script>
        $(document).ready(function() {
            reloadData();

        });

        function reloadData() {

            var table = new DataTable('#notif-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('notif.datatable') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'link'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'waktu'
                    },
                ]
            });

        }

        function read(event,id){
            let t =this;
            event.preventDefault();
            $.ajax({
                url: "{{ route('notif.read') }}",
                type: 'POST',

                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    if (response.status == 'success') {
                        return window.location.href = response.tautan;
                    } else {
                        alert('Gagal membaca notifikasi');
                    }
                },  error: function() {
                alert('Terjadi kesalahan pada server');

            }
            });

        }
    </script>
@stop
@endsection
