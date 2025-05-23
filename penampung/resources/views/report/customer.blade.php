@extends('layouts.main')

@section('main')
<div class="pagetitle">
    <h1>Report Customer</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Report Customer</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form id="filterCustomer">
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="startDate" class="form-label">Tanggal Awal</label>
                                            <input type="date" class="form-control form-control-sm" id="startDate" name="startDate" value="{{ date('d-m-Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="endDate" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control form-control-sm" id="endDate" name="endDate" value="{{ date('d-m-Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button type="button" id="btnFilter" class="btn btn-secondary btn-sm">Filter</button>
                                                <button type="button" id="btnPdf" class="btn btn-danger btn-sm" disabled><i class="bi bi-filetype-pdf"></i> PDF</button>
                                                <button type="button" id="btnExcel" class="btn btn-success btn-sm" disabled><i class="bi bi-file-earmark-excel"></i> Excel</button>
                                                <button type="button" id="btnPreview" class="btn btn-light btn-sm" disabled><i class="bi bi-file-earmark-excel"></i> Preview</button>
                                                {{-- <button type="submit" id="btnFilter" class="btn btn-secondary">Filter</button> --}}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                        <div class="col-md-3">
                                        </div>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <div id="alert" class="alert alert-success alert-dismissible fade position-absolute "
                        style="margin-left: 400px ; margin-top: -20px;" role="alert">
                        <span class="pesan text-capitalize"></span>
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
                        <div class="table-responsive">
                            <table class="table datatable table-hover table-striped " id="customers-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama User Jade</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Perusahaan</th>
                                        <th>Domisili Perusahaan</th>
                                        <th>Periode Register</th>
                                        <th>Unit Kerja</th>
                                        {{-- <th>Penerbitan</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

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
        var table = new DataTable('#customers-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report.customer.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'nama_customer'
                },
                {
                    data: 'email_customer'
                },
                {
                    data: 'hp_customer'
                },
                {
                    data: 'company_name'
                },
                {
                    data: 'company_city'
                },
                {
                    data: 'register'
                },
                {
                    data: 'branch.nm_cabang'
                }
            ]
        });
    
        $('#btnFilter').on('click', function(e) {
            console.log('ok');
            e.preventDefault();
            console.log('ok');
            table.ajax.url("{{ route('report.customer.getData') }}" + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val()).load();
            $('#btnPdf').removeAttr('disabled');
            $('#btnExcel').removeAttr('disabled');
            $('#btnPreview').removeAttr('disabled');
        });
        $('#btnPdf').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.customer.pdf") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.customer.excel") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
        });
        $('#btnPreview').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.customer.preview") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
        });
    });
</script>
@stop
@endsection
