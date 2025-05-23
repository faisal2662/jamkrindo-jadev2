@extends('layouts.main')

@section('main')
<div class="pagetitle">
    <h1>User Role Management</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">User Role Management</li>
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
                                {{-- <a href="{{ route('user-manager.create') }}" class="btn btn-primary btn-sm">Tambah
                                    Data</a> --}}
                                {{-- <button type="button" class="btn btn-primary btn-sm float-end" onclick="userAdd()">
                                    Tambah Data
                                </button> --}}
                                {{-- <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                    data-bs-target="#tambah">
                                    Tambah Data
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <div id="alert" class="alert alert-success alert-dismissible fade position-absolute "
                        style="margin-left: 400px ; margin-top: -20px;" role="alert">
                        <span class="pesan text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <table class="table table-hover table-striped " id="users-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NPP</th>
                                <th>Nama</th>
                                <th>Perusahaan</th>
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
        $(document).ready(function() {
            reloadData();
        });

        function reloadData() {
            var table = new DataTable('#users-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('jade.role.datatables') }}",
                    type: 'GET'
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
                        data: 'nm_perusahaan'
                    },
                    {
                        data: 'action'
                    }
                ]
            });
        }
</script>
    
@endsection
    
@endsection