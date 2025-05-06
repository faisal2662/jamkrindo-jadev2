<?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pelanggan.xls");
 ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan keuangan</title>
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
    <h4 class="mt-4">Laporan Pelanggan</h4> 
    <p> Dari Tanggal : <strong>{{ $start }}</strong></p>
    <p>Sampai Tanggal : <strong>{{ $end }}</strong></p>
    <table class="table table-bordered">
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
            </tr>
        </thead>
        <tbody>
            @foreach ($dataPdf as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['id_wilayah'] }}</td>
                    <td>{{ $item['periode'] }}</td>
                    <td>{{ $item['id_kanwil'] }}</td>
                    <td>{{ $item['id_produk'] }}</td>
                    <td>{{ $item['id_lob'] }}</td>
                    <td>{{ $item['volume_penjaminan'] }}</td>
                    <td>{{ $item['produktivitas'] }}</td>
                    <td>{{ $item['jenis_penjaminan'] }}</td>
                    <td>{{ $item['kelas'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
