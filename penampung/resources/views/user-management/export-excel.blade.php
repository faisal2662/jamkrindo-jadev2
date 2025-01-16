<?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_admin.xls");
 ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Admin</title>
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
    <h4 class="mt-4">Laporan Admin</h4>
    <p> Dari Tanggal : <strong>{{ $start }}</strong></p>
    <p>Sampai Tanggal : <strong>{{ $end }}</strong></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>NPP</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Wilayah</th>
                <th>Cabang</th>
                <th>No. Telpon</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->npp_user }}</td>
                    <td>{{ $item->nm_user }}</td>
                    <td>{{ $item->birthday }}</td>
                    <td>{{ $item->primary_address }}</td>
                    <td>{{ $item->email }}</td>
                    {{-- <td>{{ $item->wilayah }}</td> --}}
                    @if ($item->wilayah)
                        <td>{{ $item->wilayah->nm_wilayah }}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if ($item->cabang)
                        <td>{{ $item->cabang->nm_cabang }}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ $item->primary_phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
