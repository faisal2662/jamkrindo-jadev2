<?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporanpelanggan.xls");
 ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan DWH SPD</title>
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
    <h4 class="mt-4">Laporan DWH SPD</h4>
    <p> Dari Tanggal : <strong>{{ $start }}</strong></p>
    <p>Sampai Tanggal : <strong>{{ $end }}</strong></p>
    <table class="table table-bordered">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
