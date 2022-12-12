<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/googlefontapis/css/roboto.css">
  <link rel="stylesheet" href="assets/googlefontapis/css/material-icons.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css" rel="stylesheet" />
  <title>DAFTAR</title>
  <style>
    .form-control[readonly] {
      background-color: transparent;
      padding-top: 0px;
      padding-bottom: 0px;
    }

    td {
      padding: 0px 8px !important;
    }
  </style>
</head>
<script type="text/javascript">
  function log2() {
    $.ajax({
      type: 'POST',
      url: 'search64',
      data: {
        '_token': "{{ csrf_token() }}",
        'nim': $('#nim').val(),
      },
      success: function(dataa) {
        //console.log(data);
        $('#myModal').modal('show');
        $('#nim').val('');
        // //isi form
        $('#id').val(dataa.id);
        $('#nama').val(dataa.nama_mahasiswa);
        $('#jurusan').val(dataa.jurusan);
        $('#nim_r').val(dataa.nim);

        id = $('#id').val();
        // $('.detail').show();
        $('#submitButton').show();
        $('#button_reset').show();
        //console.log(dataa.antrian[0].keterangan.split(","))
        var checkboxes = dataa.antrian[0].keterangan.split(",");
        for (var i = 0; i < checkboxes.length; i++) {
          $('#berkas' + checkboxes[i]).prop('checked', true);
        }

      },
    });
  }
</script>

<body>
  <div class="judul">
    <p>Aplikasi Antrian Wisuda BINUS@BEKASI CAMPUS</p>
  </div>
  <object id="webcard" type="application/x-webcard" width="0" height="0">
    <param name="onload" value="pluginLoaded" />
  </object>
  <div class="container">
    <div class="wrapper-login">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-chart">
            <div class="card-header card-header-" style="background-color:  #c1a1d3;color:black">
              DAFTAR ANTRIAN
            </div>
            <div id="readerList" hidden></div>
            <div class="card-body">
              <!-- <input class="form-control" id="nim" name="nim" type="text" placeholder="ID CARD / NIM" autofocus> -->
              <input class="form-control" style="font-weight:bold" name="nim" id="nim" cols="1" rows="1" placeholder="ID CARD / NIM" autofocus />
            </div>
            <div class="card-footer">
              <div class="stats">
              </div>
              <button style="margin: 0px;height:25px;padding-top:5px" class="btn" id="sub_nim" onclick="log2()">Submit</button>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card card-chart">
            <table class="table tabtab">
              <thead>
                <tr>
                  <th>NIM</th>
                  <th>NAMA</th>
                  <th>JURUSAN</th>
                  <th>AKSI</th>
                </tr>
              </thead>
              <tbody>
                @foreach($mahasiswa as $wisuda)
                <tr>
                  <th>{{$wisuda->nim}}</th>
                  <th>{{$wisuda->nama_mahasiswa}}</th>
                  <td>{{$wisuda->jurusan}}</td>
                  <td>
                    <button style="margin: 0px;height:30px;padding-top:5px" class="btn btn-danger" id="but_skip" data-id="{{$wisuda->antrian[0]->nim}}">Skip</button>
                    <div style="width:3%;display:inline-block"></div>
                    <button style="margin: 0px;height:30px;padding-top:5px" class="btn" id="but_wid" data-id="{{$wisuda->antrian[0]->nim}}">Proses</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;" class=" col-md-12 detail">
          <div class="modal-dialog" id="dialog">
            <div class="modal-content">
              <div class="card-header">
                BUKTI PENGAMBILAN BERKAS KELULUSAN
              </div>
              <div class="card-body">
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                  @csrf
                  <input class="form-control" type="text" name="id" id="id" hidden />
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="nim_r" id="nim_r" placeholder="NIM" readonly />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="jurusan" id="jurusan" placeholder="Fakultas-Jurusan" readonly />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" style="font-weight:bold" type="text" name="nama" id="nama" placeholder="Nama Mahasiswa" readonly />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="sesi" id="sesi" placeholder="" readonly />
                  </div>
                  <table style="width: 84%;">
                    <tr>
                      <td colspan="2">
                        <center>
                          <div id="my_camera"></div>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <input style="padding: 8px 30px;width:25%" class="btn btn-primary" type=button value="Take Snapshot" onClick="take_snapshot()">
                        <div style="width:5%;display:inline-block"></div>
                        <button style="padding: 8px 30px;width:25%" type="button" class="btn btn-danger" onclick="reset_cam()">Re-Take</button>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-weight: bold;">Berkas yang diterima</td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">
                        <input class="btn btn-primary" style="padding: 5px 30px;" type=button value="Check All" onclick="check_all()">
                      </td>
                    </tr>
                    <tr>
                      <?php
                      $i = 1;
                      $j = 0;
                      $k = 1;
                      ?>
                      @foreach($data as $datas)
                      @if ($j % 2 == 0 && $j != 0)
                    </tr>
                    <tr>
                      <td class="table-berkas">
                        <input id="berkas{{$k++}}" type="checkbox" name="berkas[]" value="{{$datas->id}}">&nbsp {{$i++}}. {{$datas->nam_berkas}}
                      </td>
                      @else
                      <td class="table-berkas">
                        <input id="berkas{{$k++}}" type="checkbox" name="berkas[]" value="{{$datas->id}}">&nbsp {{$i++}}. {{$datas->nam_berkas}}
                      </td>
                      @endif
                      <?php $j++ ?>
                      @endforeach
                    </tr>
                  </table>

                  <div class="card-footer">
                    <input onclick="window.location.href=window.location.href" style="padding: 8px 30px;width:20%" type="button" class="btn btn-danger" value="Clear Data">
                    <div style="width:5%;display:inline-block"></div>
                    <input style="padding: 8px 30px;width:20%" type="submit" id="submitButton" class="btn btn-primary" value="SEND DATA">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div id="ModalSucces" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;" class=" col-md-12 detail">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="card-body">
                <div>
                  <!-- <img id="svgResult" src="" alt="" width="150"> -->
                  <h2 id="hasil"></h2>
                </div>

                <!-- <div class="card-footer">
                  <button onclick="window.location.href=window.location.href" class="btn btn-danger" style="padding: 5px 30px;">
                    Close
                  </button>
                  <a id="linkCetak" href="" class="btn btn-primary" style="padding: 5px 20px;">CETAK PDF</a>

                </div> -->
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.5.1.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- Webcam.min.js -->
  <script type="text/javascript" src="assets/webcamjs/webcam.min.js"></script>

  <script>
    var input = document.getElementById("nim");
    input.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("sub_nim").click();
      }
    });
  </script>
  <script language="JavaScript">
    function b64toBlob(b64Data, contentType, sliceSize) {
      contentType = contentType || '';
      sliceSize = sliceSize || 512;

      var byteCharacters = atob(b64Data);
      var byteArrays = [];

      for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
      }

      var blob = new Blob(byteArrays, {
        type: contentType
      });
      return blob;
    }

    $("#form-add").submit(function(e) {
      e.preventDefault();
      // saveCanvas()
      var uri = $('#img').attr('src');
      // var canvas = document.getElementById("link").href;
      // appendFileAndSubmit(uri, canvas);
      appendFileAndSubmit(uri);
    });

    function appendFileAndSubmit(uri) {
      // Get the form
      var form = document.getElementById("form-add");

      var ImageURL = uri;
      // var ImageURLs = canvas;
      // Split the base64 string in data and contentType
      var block = ImageURL.split(";");
      // var blocks = ImageURLs.split(";");
      // Get the content type
      var contentType = block[0].split(":")[1]; // In this case "image/gif"
      // var contentTypes = 'png'; // In this case "image/gif"
      // get the real base64 content of the file
      var realData = block[1].split(",")[1]; // In this case "iVBORw0KGg...."
      // var realDatas = blocks[1].split(",")[1]; // In this case "iVBORw0KGg...."

      // Convert to blob
      var blob = b64toBlob(realData, contentType);
      // var ttd = b64toBlob(realDatas, contentTypes);

      // Create a FormData and append the file
      var fd = new FormData(form);
      fd.append("image", blob);
      // fd.append("ttd", ttd);

      // Submit Form and upload file
      $.ajax({
        type: 'POST',
        url: '{{ url("store_antr64") }}',
        data: fd,
        processData: false,
        contentType: false,
        success: function(data) {
          console.log(data);
          document.getElementById("form-add").reset();
          //window.location.href = "/cetak/" + data.id;
          //window.location.href = "/";
          $('#myModal').modal('hide');
          $('#ModalSucces').modal('show');
          // $('#svgResult').attr("src", "assets/image/succes.svg");
          // $('#linkCetak').attr("href", "/cetak/" + data.id);
          $('#hasil').text('Data Berhasil Disimpan');

          // window.open(
          //   '/cetak/' + data.id,
          //   '_blank' // <- This is what makes it open in a new window.
          // );

          setInterval(() => {
            // window.location.href = "wisuda64";
            location.reload();
          }, 500);

        },
        error: function() {
          document.getElementById("form-add").reset();
          $('#myModal').modal('hide');
          $('#ModalSucces').modal('show');
          // $("#svgResult").attr("src", "assets/image/remove.svg");
          $('#linkCetak').hide();
          $('#hasil').text('Data Gagal Disimpan');
        }
      });

    }

    Webcam.set({
      width: 342,
      height: 256,
      dest_width: 1024,
      dest_height: 768,
      image_format: 'jpeg',
      jpeg_quality: 100,
      force_flash: false,
      fps: 45,
      deviceId: {
        exact: 'environment'
      }
    });
    Webcam.attach('#my_camera');

    function reset_cam() {
      Webcam.reset();
      Webcam.attach('#my_camera');
    }


    function take_snapshot() {

      // take snapshot and get image data
      Webcam.snap(function(data_uri) {
        // display results in page
        document.getElementById('my_camera').innerHTML =
          '<img name="images" style="width: 342px;heigth:256px" id="img" src="' + data_uri + '"/>';
      });
    }
  </script>
  <script>
    $(document).on('click', '#but_wid', function(e) {
      e.preventDefault();
      var uid = $(this).data('id');
      search(uid);
    });

    function search(dataa) {

      $.ajax({
        type: 'POST',
        url: 'search64',
        data: {
          '_token': "{{ csrf_token() }}",
          'nim': dataa,
        },
        success: function(data) {
          //console.log(data);
          $('#myModal').modal('show');
          // //isi form
          $('#id').val(data.id);
          $('#nama').val(data.nama_mahasiswa);
          $('#jurusan').val(data.jurusan);
          $('#nim_r').val(data.nim);

          id = $('#id').val();
          // $('.detail').show();
          $('#submitButton').show();
          $('#button_reset').show();
          //console.log(data.antrian[0].keterangan.split(","))
          var checkboxes = data.antrian[0].keterangan.split(",");
          for (var i = 0; i < checkboxes.length; i++) {
            $('#berkas' + checkboxes[i]).prop('checked', true);
          }

        },
      });

    };

    $(document).on('click', '#but_skip', function(e) {
      e.preventDefault();
      var uidd = $(this).data('id');
      skip(uidd);
    });

    function skip(nim) {
      $.ajax({
        type: 'POST',
        url: 'skip64',
        data: {
          '_token': "{{ csrf_token() }}",
          'nim': nim,
        },
        success: function(dataa) {
          location.reload();
        },
      });
    }

    function check_all() {
      var checkboxes = document.getElementsByName('berkas[]');
      //console.log(checkboxes.length);
      if (document.getElementById('berkas1').checked) {
        for (var i = 1; i <= checkboxes.length; i++) {
          $('#berkas' + [i]).prop('checked', false);
        }
      } else {
        for (var i = 1; i <= checkboxes.length; i++) {
          $('#berkas' + [i]).prop('checked', true);
        }
      }
    }
  </script>

</body>

</html>