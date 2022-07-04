<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media screen {
            img {
                max-width: 500px;

            }

            .tanter {
                /* border: 1px solid black; */
            }

            .footer {
                margin: 1px;
                text-align: center;
            }

            p {
                font-size: 12px;
            }

            table {
                margin-left: 40px;
            }

            td {
                font-size: 12px;
                vertical-align: top;
            }

            .p2 {
                padding-top: 10px;

            }

            .bukti {

                max-width: 300px;
                text-align: center;
                margin: 0 auto;
                font-weight: bold;
                margin-bottom: 20px;
                line-height: 1.5em;

            }

            .timpa {
                display: inline-block;
                justify-content: center;
                position: relative;

            }

            .tengah {
                /* border: 1px solid red; */
                position: fixed;
                margin-top: 40px;
                margin-left: 75px;
                top: 90px;
                width: 26%;
                height: 61%;
            }

            .ttd {
                height: 50px;
                width: 100px;
                border: 1px solid red;
                margin: 0 auto
            }

            .foto {
                width: 250px;
                height: 140px;
                /* border: 1px solid black; */
                margin: 0 auto
            }

            .div-footer {
                margin-top: 15px;
                width: 50%;
                float: right
            }
        }


        .timpa {
            position: relative;
        }

        .bukti {
            max-width: 500px;
            font-weight: bold;
            font-size: 14pt;
            text-align: center;
            line-height: 1.5em;
            margin-bottom: 20px;
        }

        .tengah {
            width: 560px;
            position: fixed;
            left: 110px;
            top: 180px;
        }

        .footer {
            margin: 0px;
            text-align: center;
        }

        p {
            font-size: 12pt;
            line-height: 1.5em;
        }

        table {
            margin-left: 50px;
            margin-right: 20px;
        }

        td {
            font-size: 12pt;
            vertical-align: top;

        }

        .p2 {
            padding-top: 10px;
            padding-left: 15px;

        }

        .ttd {
            width: 150px;
            height: 100px;
            /* border: 1px solid red; */
            margin: 0 auto
        }

        .ttd img {
            height: 100px;
        }

        .foto {
            width: 300px;
            height: 190px;
            /* border: 1px solid black; */
            margin: 0 auto
        }

        .foto img {
            height: 190px;
        }

        .div-footer {
            margin-top: 25px;
            width: 50%;
            float: right;

        }

        @page {
            size: A4 portrait;
            margin: 0px;
            /* this affects the margin in the printer settings */
            border: 1px solid red;

            /* set a border for all printed pages */
        }


        .tanter {
            max-width: 800px;
            width: 100% !important;
            /* position: relative; */
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
            /* border: 1px solid red; */
        }
    </style>
</head>

<body>
    <div class="timpa">
        <img class="tanter" src="{{$pic}}" />
        <div class="tengah">
            <P class="bukti">BUKTI TANDA TERIMA DOKUMEN KELULUSAN PERIODE WISUDA 64</P>
            <div class="foto">
                <center>
                    <img src="{{$picc}}" height="140px" style="display:block;" alt="">
                </center>
            </div>
            <p class="p2">Saya, {{$nama}}, NIM: {{$data->nim}} menyatakan telah menerima dengan lengkap dokumen kelulusan yang terdiri dari: </p>
            <div>
                <table>

                    @foreach($berkas as $key => $berkass)
                    <tr>
                        <td>{{++$key}}. </td>
                        <td>{{$berkass->nam_berkas}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="div-footer">
                <p class="footer">Bekasi, {{$tanggal}} </p>
                <div class="ttd"></div>
                <p class="footer">{{$nama}}</p>
            </div>
        </div>
    </div>
</body>

</html>