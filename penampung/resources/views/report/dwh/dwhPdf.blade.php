<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelanggan</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .border-top {
            border-top: 3px solid #000;
            margin-top: 10px;
        }

        @media print {
            body {
                margin: 0;
            }

            table, th, td {
                page-break-inside: avoid;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="kop">
        <img src="{{ asset('assets/img/kop-surat.png') }}" alt="Kop Surat" style="width: 60%;">
    </div>

    <div class="border-top"></div>

    <p>Keterangan: <b>Laporan DWH SP</b></p>
    <p>Tanggal Periode: <b><?= date('j F Y', strtotime($start)) ?> s/d <?= date('j F Y', strtotime($end)) ?></b></p>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kantor Wilayah</th>
                    <th>Kantor Cabang</th>
                    <th>KBG</th>
                    <th>Suretyship</th>
                    <th>Total KBG dan Suretyship</th>
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
                    @foreach ($wilayahData as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            @if ($loop->first)
                                <td rowspan="{{ $rowspan }}">{{ preg_replace('/\d+/', '', $kantorWilayah) }}</td>
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
                    @php $rowspan = count($wilayahTerakhir); @endphp
                    @foreach ($wilayahTerakhir as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            @if ($loop->first)
                                <td rowspan="{{ $rowspan }}">{{ preg_replace('/\d+/', '', $lastWilayah) }}</td>
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
                <tr>
                    <th colspan="3">Grand Total</th>
                    <th>{{ number_format($totalKbg, 0, ',', '.') }}</th>
                    <th>{{ number_format($totalSuretyship, 0, ',', '.') }}</th>
                    <th>{{ number_format($totalKbg + $totalSuretyship, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="border-top"></div>

    <script>
        window.print();
    </script>
</body>
</html>
