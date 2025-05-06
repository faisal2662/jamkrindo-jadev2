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
            <div class="col-md-12">
                <p>Keterangan : <b>Laporan DWH SP</b></p>
                <p>
                    Tanggal Periode : <b><?= date('j F Y', strtotime($start)) ?> s/d
                        <?= date('j F Y', strtotime($end)) ?></b>
                </p>
                <p>&nbsp;</p>
            </div>
        </div>
        
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Kantor Wilayah</th>
                            <th >Kantor Cabang</th>
                            <th >KBG</th>
                            <th >Suretyship</th>
                            <th >Total KBG dan Suretyship</th>
                            {{-- <th >% KBG</th>
                            <th >% Suretyship</th>
                            <th >% Total KBG dan Suretyship</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($dwh as $kantorWilayah => $wilayahData)
                            @php $rowspan = count($wilayahData); @endphp
                            @foreach ($wilayahData as $wilayahKerja => $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $rowspan }}" class="text-center">{{ $kantorWilayah }}</td>
                                    @endif
                                    <td>{{ $item->wilayah_kerja }}</td>
                                    <td>{{ $item->total_kbg }}</td>
                                    <td>{{ $item->total_suretyship }}</td>
                                    <td>{{ $item->total_kbg + $item->total_suretyship }}</td>
                                    {{-- <td>{{ $item->total_kbg }}%</td>
                                    <td>{{ $item->total_suretyship }}%</td>
                                    <td>{{ $item->total_kbg + $item->total_suretyship }}%</td> --}}
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
            <p>&nbsp;</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>window.print()</script>
</body>

</html>
