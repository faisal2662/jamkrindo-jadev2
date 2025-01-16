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
                                            <label for="startDate" class="form-label">Bulan</label>
                                            <select name="bulan" id="bulan" class="form-control form-control-sm">
                                                <option value="">-- Pilih Bulan --</option>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tahun" class="form-label">Tahun</label>
                                            <select name="tahun" id="tahun" class="form-control form-control-sm">
                                                <option value="">-- Pilih Tahun --</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Periode</label>
                                            <input type="date" class="form-control form-control-sm" id="periode" name="periode" value="{{ date('d-m-Y') }}" required>
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
                                        <th>Periode</th>
                                        <th>Kanwil</th>
                                        <th>Produk</th>
                                        <th>LOB</th>
                                        <th>Volume Penjaminan</th>
                                        <th>Produktivitas</th>
                                        <th>Jenis Penjaminan</th>
                                        <th>Kelas</th>
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
        var bulan = document.getElementById('bulan').value;
        var tahun = document.getElementById('tahun').value;
        var periode = document.getElementById('periode').value;
        var lob = document.getElementById('lob').value;
        console.log(wilayah);
        var table = new DataTable('#customers-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dwh.volumepenjaminan.getData') }}",
                type: 'POST',
                data:{wilayah:wilayah, bulan:bulan, tahun:tahun, periode:periode, lob:lob}
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'id_wilayah'
                },
                {
                    data: 'periode'
                },
                {
                    data: 'id_kanwil'
                },
                {
                    data: 'id_produk'
                },
                {
                    data: 'id_lob'
                },
                {
                    data: 'volumen_penjaminan'
                },
                {
                    data: 'produktivitas'
                },
                {
                    data: 'jenis_penjaminan'
                },
                {
                    data: 'kelas'
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
            var wilayah = document.getElementById('id_wilayah').value;
            var bulan = document.getElementById('bulan').value;
            var tahun = document.getElementById('tahun').value;
            var periode = document.getElementById('periode').value;
            var lob = document.getElementById('lob').value;
            window.open('{{ route("dwh.volume.penjaminan.pdf") }}' + '?wilayah=' + $('#wilayah').val() + '&bulan=' + $('#bulan').val() + '&tahun=' + $('#tahun').val() + '&periode=' + $('#periode').val() + '&lob=' + $('#lob').val(), '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("dwh.volume.penjaminan.excel") }}' + '?wilayah=' + $('#wilayah').val() + '&bulan=' + $('#bulan').val() + '&tahun=' + $('#tahun').val() + '&periode=' + $('#periode').val() + '&lob=' + $('#lob').val(), '_blank');
        });
    });
</script>
@stop
@endsection
