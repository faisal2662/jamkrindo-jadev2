@extends('layouts.main')

@section('main')
<div class="pagetitle">
    <h1>Report Customer</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Report Service IJP</li>
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
                                            <label for="periode" class="form-label">Periode Awal</label>
                                            <input type="date" class="form-control form-control-sm" id="periodeawal" name="periodeawal" value="{{ date('d-m-Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Periode Akhir</label>
                                            <input type="date" class="form-control form-control-sm" id="periodeakhir" name="periodeakhir" value="{{ date('d-m-Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="startDate" class="form-label">Wilayah</label>
                                            <select name="id_wilayah" id="id_wilayah" class="form-control form-control-sm">
                                                <option value="">-- Pilih Wilayah --</option>
                                                @foreach($wilayah as $wlyh)
                                                    <option value="{{ $wlyh['id_kanwil'] }}">{{ $wlyh['wilayah_kerja'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                            <select name="unit_kerja" id="unit_kerja" class="form-control form-control-sm">
                                                <option value="">-- Pilih Unit Kerja --</option>
                                                @foreach($unitkerja as $uker)
                                                    <option value="{{ $uker['id_kanwil'] }}">{{ $uker['kantor_wilayah'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="jenis_penerima_jaminan" class="form-label">Jenis Penerima Jaminan</label>
                                            <select name="jenis_penerima_jaminan" id="jenis_penerima_jaminan" class="form-control form-control-sm">
                                                <option value="">-- Pilih Jenis Penerima Jaminan --</option>
                                                @foreach($getJnsPenerimaJaminan as $jpj)
                                                    <option value="{{ $jpj['id_jenis_penerima_jaminan'] }}">{{ $jpj['jenis_penerima_jaminan'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="penerima_jaminan" class="form-label">Penerima Jaminan</label>
                                            <select name="penerima_jaminan" id="penerima_jaminan" class="form-control form-control-sm">
                                                <option value="">-- Pilih Penerima Jaminan --</option>
                                                @foreach($getPenerimaJaminan as $pj)
                                                    <option value="{{ $pj['id_penerima_jaminan'] }}">{{ $pj['penerima_jaminan'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="lob" class="form-label">LOB</label>
                                            <select name="lob" id="lob" class="form-control form-control-sm">
                                                <option value="">-- Pilih LOB --</option>
                                                @foreach($lob as $lob)
                                                    <option value="{{ $lob['id_lob'] }}">{{ $lob['lob'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="id_produk" class="form-label">Produk</label>
                                            <select name="id_produk" id="id_produk" class="form-control form-control-sm">
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach($getProduk as $produk)
                                                    <option value="{{ $produk['id_produk'] }}">{{ $produk['nama_produk'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="id_pola_penjaminan" class="form-label">Pola Penjaminan</label>
                                            <select name="id_pola_penjaminan" id="id_pola_penjaminan" class="form-control form-control-sm">
                                                <option value="">-- Pilih Penjaminan --</option>
                                                @foreach($polaPenjaminan as $pp)
                                                    <option value="{{ $pp['id_pola_penjaminan'] }}">{{ $pp['pola_penjaminan'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="id_jenis_kur" class="form-label">Jenis Kur</label>
                                            <select name="id_jenis_kur" id="id_jenis_kur" class="form-control form-control-sm">
                                                <option value="">-- Pilih Jenis Kur --</option>
                                                @foreach($jenisKur as $jk)
                                                    <option value="{{ $jk['id_jenis_kur'] }}">{{ $jk['jenis_kur'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="id_jenis_penjaminan" class="form-label">Jenis Penjaminan</label>
                                            <select name="id_jenis_penjaminan" id="id_jenis_penjaminan" class="form-control form-control-sm">
                                                <option value="">-- Pilih Jenis Penjaminan --</option>
                                                @foreach($jenisPenjaminan as $jp)
                                                    <option value="{{ $jp['id_jenis_penjaminan'] }}">{{ $jp['jenis_penjaminan'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button type="submit" id="btnFilter" class="btn btn-secondary btn-sm">Filter</button>
                                                <button type="button" id="btnPdf" class="btn btn-danger btn-sm" disabled><i class="bi bi-filetype-pdf"></i> PDF</button>
                                                <button type="button" id="btnExcel" class="btn btn-success btn-sm" disabled><i class="bi bi-file-earmark-excel"></i> Excel</button>
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
                                        <th>Wilayah</th>
                                        <th>Kanwil</th>
                                        <th>Jenis Penerima Jaminan</th>
                                        <th>Penerima Jaminan</th>
                                        <th>Produk</th>
                                        <th>LOB</th>
                                        <th>Jenis Penjaminan</th>
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
    
    $('#btnFilter').on('click', function(e) {
        e.preventDefault();
        var wilayah = document.getElementById('id_wilayah').value;
        var periodeawal = document.getElementById('periodeawal').value;
        var periodeakhir = document.getElementById('periodeakhir').value;
        var unit_kerja = document.getElementById('unit_kerja').value;
        var jenis_penerima_jaminan = document.getElementById('jenis_penerima_jaminan').value;
        var penerima_jaminan = document.getElementById('penerima_jaminan').value;
        var id_produk = document.getElementById('id_produk').value;
        var id_pola_penjaminan = document.getElementById('id_pola_penjaminan').value;
        var id_jenis_kur = document.getElementById('id_jenis_kur').value;
        var id_jenis_penjaminan = document.getElementById('id_jenis_penjaminan').value;
        var lob = document.getElementById('lob').value;
        console.log(wilayah);
        var table = new DataTable('#customers-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dwh.volumepenjaminan.getData') }}",
                type: 'POST',
                data:{wilayah:wilayah, unit_kerja:unit_kerja, jenis_penerima_jaminan:jenis_penerima_jaminan, periodeawal:periodeawal,periodeakhir:periodeakhir,penerima_jaminan:penerima_jaminan,id_produk:id_produk,id_pola_penjaminan:id_pola_penjaminan,id_jenis_kur:id_jenis_kur,id_jenis_penjaminan:id_jenis_penjaminan, lob:lob}
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'id_wilayah'
                },
                {
                    data: 'id_kanwil'
                },
                {
                    data: 'jenis_penerima_jaminan'
                },
                {
                    data: 'penerima_jaminan'
                },
                {
                    data: 'id_produk'
                },
                {
                    data: 'id_lob'
                },
                {
                    data: 'jenis_penjaminan'
                },
            ]
        });
        // table.ajax.url("{{ route('report.customer.pdf') }}" + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val()).load();
        $('#btnPdf').removeAttr('disabled');
        $('#btnExcel').removeAttr('disabled');
    });
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
    
        
        $('#btnPdf').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.customer.pdf") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.customer.excel") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
        });
    });
</script>
@stop
@endsection
