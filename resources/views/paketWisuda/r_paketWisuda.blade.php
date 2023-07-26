<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
            width: 100% !important;
            white-space: nowrap !important
        }

        tr,
        th,
        td {
            border: 1pt solid black !important;

        }

        .normal {
            font-weight: normal;
        }

        .grey {
            background-color: #D9D9D9;
        }

        .top-left {
            vertical-align: top;
            text-align: left;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr class="grey">
                <th rowspan="2">No.</th>
                <th rowspan="2">NIM<br><i class="normal">Student ID</i></th>
                <th rowspan="2">Nama Mahasiswa<br><i class="normal">Student Name</i></th>
                <th rowspan="2">Keterangan<br><i class="normal">Information</i></th>
                <th rowspan="2">Jenjang Pendidikan<br><i class="normal">Education Level</i></th>
                <th rowspan="2">Program</th>
                <th rowspan="2">Ukuran Toga<br><i class="normal">Toga Size</i></th>
                <th colspan="2">Tanda Tangan<br><i class="normal">Signature</i></th>
            </tr>
            <tr class="grey">
                <th>Ganjil<br><i class="normal">Odd</i></th>
                <th>Genap<br><i class="normal">Even</i></th>
            </tr>
        </thead>
        <tbody>
            @php
            $count = 1;
            @endphp
            @foreach ($mahasiswa as $key => $row)
            @if ($key % 2 === 0)
            <tr>
                <td class="center">{{$count}}</td>
                <td class="center">{{ $row['nim'] }}</td>
                <td>{{ $row['nama_mahasiswa'] }}</td>
                <td class="center">-</td>
                <td class="center">S1 (Sarjana)</td>
                <td>{{ $row['jurusan'] }}</td>
                <td class="center">{{ $row['uToga'] }}</td>
                <td class="top-left" rowspan="2">{{ $row['bukti_pic'] }}</td>
                @if (isset($mahasiswa[$key + 1]))
                <td class="top-left" rowspan="2">{{ $mahasiswa[$key + 1]['bukti_pic'] }}</td>
                @else
                <td class="top-left" rowspan="2"></td>
                @endif
            </tr>
            @else
            <tr>
                <td class="center">{{ $count }}</td>
                <td class="center">{{ $row['nim'] }}</td>
                <td>{{ $row['nama_mahasiswa'] }}</td>
                <td class="center">-</td>
                <td class="center">S1 (Sarjana)</td>
                <td>{{ $row['jurusan'] }}</td>
                <td class="center">{{ $row['uToga'] }}</td>
            </tr>

            @endif
            @php
            $count++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>