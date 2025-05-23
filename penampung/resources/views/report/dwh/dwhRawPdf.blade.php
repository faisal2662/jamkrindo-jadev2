<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan DWH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style> 
        table, 
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            font-size: 12px;
        }

        table {
            width: 100%;
        }

        .table-container {
            overflow-x: auto;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .table-container {
                overflow: visible;
            }

            img {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12" style="border-bottom: 1px solid #000;">
            <center>
                <img src="{{ asset('assets/img/kop-surat.png') }}" style="width: 60%; border-radius: 5px;">
            </center>
            <p>&nbsp;</p>
        </div>
        <div class="col-12" style="border-top: 3px solid #000; margin-top: 5px;">
            <p>&nbsp;</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p>Keterangan: <b>DATA DWH SP</b></p>
            <p>
                Tanggal Periode:
                <b><?= date('j F Y', strtotime($start)) ?> s/d <?= date('j F Y', strtotime($end)) ?></b>
            </p>
            <p>&nbsp;</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 table-container">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No Surat</th>
                        <th>No SP</th>
                        <th>Tanggal SP</th>
                        <th>Nasabah</th>
                        <th>Kantor Wilayah</th>
                        <th>Wilayah Kerja</th>
                        <th>Penerima Jaminan</th>
                        <th>LOB</th>
                        <th>Produk</th>
                        <th>NPWP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dwh as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->no_surat }}</td>
                            <td>{{ $item->nomor_sp }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->nasabah }}</td>
                            <td>{{ $item->kantor_wilayah }}</td>
                            <td>{{ $item->wilayah_kerja }}</td>
                            <td>{{ $item->penerima_jaminan }}</td>
                            <td>{{ $item->lob }}</td>
                            <td>{{ $item->produk }}</td>
                            <td>'{{ $item->npwp }}</td> <!-- quote agar tetap string -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12" style="border-top: 3px solid #000; margin-top: 5px;">
        <p>&nbsp;</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        window.print()
    </script>
</body>

</html>
