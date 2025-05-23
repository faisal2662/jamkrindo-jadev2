<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>

</head>

<body>
    <div class="container">
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-md-12" style="border-bottom: 1px solid #000;">
                <center>
                    <img src="{{ asset('assets/img/kop-surat.png') }}" style="width: 60%;border-radius: 5px;">
                </center>
                <p>&nbsp;</p>
            </div>
            <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p>Keterangan : <b>Laporan DWH SP</b></p>
                <p>
                    Tanggal Periode : <b><?= date('j F Y', strtotime($start)) ?> s/d
                        <?= date('j F Y', strtotime($end)) ?></b>
                </p>
                <p>&nbsp;</p>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" id="btnPdf" class="btn btn-danger btn-sm"><i class="bi bi-filetype-pdf"></i> PDF</button>
                <button type="button" id="btnExcel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            </div>
        </div>
        
        @php
            $noc = 1;
        @endphp
        {{-- @foreach ($dwh as $item) --}}
            <div class="row">
                <p><span><strong>Information User</strong></span></p>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Kantor Wilayah</th>
                                <th class="text-center">Kantor Cabang</th>
                                <th class="text-center">KBG</th>
                                <th class="text-center">Suretyship</th>
                                <th class="text-center">Total KBG dan Suretyship</th>
                                {{-- <th >% KBG</th>
                                <th >% Suretyship</th>
                                <th >% Total KBG dan Suretyship</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $no = 1;
                                $lastWilayah = "Kantor Cabang Khusus";

                                $wilayahTerakhir = $dwh->pull($lastWilayah);
                                $totalKbg = 0;
                                $totalSuretyship = 0;
                            @endphp
                            @foreach ($dwh as $kantorWilayah => $wilayahData)
                                @php $rowspan = count($wilayahData); @endphp
                                @foreach ($wilayahData as $wilayahKerja => $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        @if ($loop->first)
                                            <td rowspan="{{ $rowspan }}" class="text-center align-middle">{{ preg_replace('/\d+/', '', $kantorWilayah) }}</td>
                                        @endif
                                        <td>{{ $item->wilayah_kerja }}</td>
                                        <td>{{ $item->total_kbg }}</td>
                                        <td>{{ $item->total_suretyship }}</td>
                                        <td>{{ $item->total_kbg + $item->total_suretyship }}</td>
                                    </tr>
                                    @php
                                        $totalKbg += $item->total_kbg;
                                        $totalSuretyship += $item->total_suretyship;
                                    @endphp
                                @endforeach
                            @endforeach
                            @if ($wilayahTerakhir)
                                @php
                                    $rowspan = count($wilayahData);
                                @endphp
                                @foreach ($wilayahTerakhir as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        @if ($loop->first)
                                            <td rowspan="{{ $rowspan }}" class="text-center align-middle">{{ preg_replace('/\d+/', '', $lastWilayah) }}</td>
                                        @endif
                                        <td>{{ $item->wilayah_kerja }}</td>
                                        <td>{{ $item->total_kbg }}</td>
                                        <td>{{ $item->total_suretyship }}</td>
                                        <td>{{ $item->total_kbg + $item->total_suretyship }}</td>
                                    </tr>
                                    @php
                                        $totalKbg += $item->total_kbg;
                                        $totalSuretyship += $item->total_suretyship;
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary">
                                <th colspan="3" class="text-center">Grand Total</th>
                                <th class="text-center">{{ number_format($totalKbg, 0, ',', '.') }}</th>
                                <th class="text-center">{{ number_format($totalSuretyship, 0, ',', '.') }}</th>
                                <th class="text-center">{{ number_format($totalKbg + $totalSuretyship, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
                <p>&nbsp;</p>
            </div>
            @php
                $noc++;
            @endphp
        {{-- @endforeach --}}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function collapseConversation(noc,no){
            event.preventDefault();
            var btnCollapse = document.getElementById(noc + 'btnShort_' + no);
            var shortConversation = document.getElementById(noc + 'short-conversation_' + no);
            var fullConversation = document.getElementById(noc + 'full-conversation_' + no);// Jika konten penuh disembunyikan, tampilkan konten penuh dan sembunyikan konten singkat
            // console.log(shortConversation);
            
            if (fullConversation.style.display == 'none') {
                shortConversation.style.display = 'none';
                fullConversation.style.display = 'block';
                btnCollapse.innerHTML = 'Tutup'; // Ganti teks tombol menjadi 'Tutup'
            } else {
                shortConversation.style.display = 'block';
                fullConversation.style.display = 'none';
                btnCollapse.innerHTML = 'Selengkapnya'; // Ganti teks tombol kembali
            }

        }
        $('#btnPdf').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.dwh.pdf") }}' + '?startDate=' + '{{ $start }}' + '&endDate=' + '{{ $end }}', '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            e.preventDefault();
            window.open('{{ route("report.dwh.excel") }}' + '?startDate=' + '{{ $start }}' + '&endDate=' + '{{ $end }}', '_blank');
        });
        // document.getElementById('btnShort').addEventListener('click', function() {
        // // $('#btnShort').on('click', function(){
        // });
    </script>
    {{-- <script>window.print()</script> --}}
</body>

</html>
