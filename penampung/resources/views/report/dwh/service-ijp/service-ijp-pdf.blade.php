<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelanggan</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
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
    <h4 class="mt-4">Laporan Volume Jaminan</h4>
    
    <table class="table table-bordered">
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
            </tr>
        </thead>
        <tbody>

            @foreach ($dataPdf as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['kantor_wilayah'] }}</td>
                    <td>{{ $item['wilayah_kerja'] }}</td>
                    <td>{{ $item['jenis_penerima_jaminan'] }}</td>
		            <td>{{ $item['penerima_jaminan'] }}</td>
                    <td>{{ $item['lob'] }}</td>
                    <td>{{ $item['produk'] }}</td>
                    <td>{{ $item['jenis_penjaminan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>window.print()</script>
</body>

</html>
