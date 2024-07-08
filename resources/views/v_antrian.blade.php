<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/googlefontapis/css/roboto.css">
  <link rel="stylesheet" href="/assets/googlefontapis/css/material-icons.css">
  <!-- CSS Files -->
  <link href="/assets/css/material-dashboard.css" rel="stylesheet" />
  <title>ANTRIAN WISUDA</title>
</head>

<body>
  <div class="judul">
    <p>Aplikasi Antrian Wisuda @BINUS BEKASI</p>
  </div>
  <div class="container">
    <div class="wrapper-login">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              Sisa Antrian
            </div>
            <div class="card-body">
              <h1 class="card-title" id="antrian_total">{{$antrian->total}}</h1>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              Antrian Saat Ini
            </div>
            <div class="card-body">
              <h1 class="card-title" id="antr_one">{{$antrian_one}}</h1>
            </div>
            <div class="card-footer">
              <div class="stats" style="width: 100%;">
                <button id="btn-pros" class="btn btn-primary">PROSES</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              Antrian Selanjutnya
            </div>
            <div class="card-body">
              <h1 class="card-title" id="antrian_two">{{$antrian_two}}</h1>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;" class=" col-md-12 detail">
          <div class="modal-dialog" id="dialog">
            <div class="modal-content">
              <div class="card-header">
                BUKTI PENGAMBIL IJAZAH
              </div>
              <div class="card-body">
                <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                  @csrf
                  <input class="form-control" type="text" name="id" id="id" hidden />
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="nim_r" id="nim_r" placeholder="NIM" />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="jurusan" id="jurusan" placeholder="Fakultas-Jurusan" />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="nama" id="nama" placeholder="Nama Mahasiswa" />
                  </div>
                  <div class="col-md-5 inline">
                    <input class="form-control" type="text" name="sesi" id="sesi" placeholder="" />
                  </div>
                  <table>
                    <tr>
                      <td>
                        <div id="my_camera" style="margin-left: 15px;"></div>
                      </td>
                      <td>
                        <h2 id="scribblePrompt" hidden>Scribble on the canvas:</h2>
                        <div style="margin-left: 33px;">
                          <!-- <textarea class="form-control" name="keterangan" id="keterangan" cols="36" rows="10" placeholder="Keterangan"></textarea> -->
                          <canvas id="myCanvas" width="320" height="240" style="border:1px solid #d3d3d3;">
                            Your browser does not support the canvas element.
                          </canvas>
                          <a id="link"></a>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><input style="padding: 5px 30px;" class="btn" type=button value="Take Snapshot" onClick="take_snapshot()">
                        <button style="padding: 5px 30px;" type="button" class="btn btn-danger" onclick="reset_cam()">Re-Take</button>
                      </td>
                      <td><button style="padding: 5px 30px;" type="button" class="btn" onclick="clearCanvas()">Clear</button></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Berkas yang diterima</td>
                    </tr>
                    <tr>
                      <td class="table-berkas" colspan="2"><input type="checkbox" name="berkas[]" value="1">&nbsp 1. Ijazah S1</td>
                    </tr>
                    <tr>
                      <td class="table-berkas" colspan="2"><input type="checkbox" name="berkas[]" value="2">&nbsp 2. Transkrip Nilai Akademik S1</td>
                    </tr>
                    <tr>
                      <td class="table-berkas" colspan="2"><input type="checkbox" name="berkas[]" value="3">&nbsp 3. Dokumen Pendukung Ijazah</td>
                    </tr>
                    <tr>
                      <td class="table-berkas" colspan="2"><input type="checkbox" name="berkas[]" value="4">&nbsp 4. Student Activity Transcript (SAT)</td>
                    </tr>
                    <tr>
                      <td class="table-berkas" colspan="2"><input type="checkbox" name="berkas[]" value="5">&nbsp 5. Kartu Alumni</td>
                    </tr>
                  </table>

                  <div class="card-footer">
                    <button onclick="window.location.href=window.location.href" class="btn btn-danger" style="padding: 5px 30px;">
                      Clear Data
                    </button>
                    <input style="padding: 5px 30px;" type="submit" id="submitButton" class="btn btn-primary" value="SEND DATA">
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
                  <img id="svgResult" src="" alt="" width="150">
                  <p id="hasil"></p>
                </div>

                <div class="card-footer">
                  <button onclick="window.location.href=window.location.href" class="btn btn-danger" style="padding: 5px 30px;">
                    Close
                  </button>
                  <a id="linkCetak" href="" class="btn btn-primary" style="padding: 5px 20px;">CETAK PDF</a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="/assets/js/jquery-3.5.1.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <!-- Webcam.min.js -->
  <script type="text/javascript" src="/assets/webcamjs/webcam.min.js"></script>
  <script src="/assets/wacom/connect-wacom.js"></script>

  <!-- Configure a few settings and attach camera -->
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
      saveCanvas()
      var uri = $('#img').attr('src');
      var canvas = document.getElementById("link").href;
      appendFileAndSubmit(uri, canvas);
    });

    function appendFileAndSubmit(uri, canvas) {
      // Get the form
      var form = document.getElementById("form-add");

      var ImageURL = uri;
      var ImageURLs = canvas;
      // Split the base64 string in data and contentType
      var block = ImageURL.split(";");
      var blocks = ImageURLs.split(";");
      // Get the content type
      var contentType = block[0].split(":")[1]; // In this case "image/gif"
      var contentTypes = 'png'; // In this case "image/gif"
      // get the real base64 content of the file
      var realData = block[1].split(",")[1]; // In this case "iVBORw0KGg...."
      var realDatas = blocks[1].split(",")[1]; // In this case "iVBORw0KGg...."

      // Convert to blob
      var blob = b64toBlob(realData, contentType);
      var ttd = b64toBlob(realDatas, contentTypes);

      // Create a FormData and append the file
      var fd = new FormData(form);
      fd.append("image", blob);
      fd.append("ttd", ttd);

      // Submit Form and upload file
      $.ajax({
        type: 'POST',
        url: '{{ url("store_antr") }}',
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
          $('#svgResult').attr("src", "/assets/image/succes.svg");
          $('#linkCetak').attr("href", "/cetak/" + data.id);
          $('#hasil').text('Data Berhasil Disimpan');

          // window.open(
          //   '/cetak/' + data.id,
          //   '_blank' // <- This is what makes it open in a new window.
          // );

          // setInterval(() => {
          //   window.location.href = "/";
          // }, 500);

        },
        error: function() {
          document.getElementById("form-add").reset();
          $('#myModal').modal('hide');
          $('#ModalSucces').modal('show');
          $("#svgResult").attr("src", "/assets/image/remove.svg");
          $('#linkCetak').hide();
          $('#hasil').text('Data Gagal Disimpan');
        }
      });

    }

    Webcam.set({
      width: 320,
      height: 240,
      dest_width: 1024,
      dest_height: 768,
      image_format: 'jpeg',
      jpeg_quality: 100,
      force_flash: false,
      fps: 45,
      deviceId: {
        exact: 'HP HD Webcam'
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
          '<img name="images" style="width: 320px;heigth:240px" id="img" src="' + data_uri + '"/>';
      });
    }

    //untuk ambil data canvas
    const canvas = document.createElement("canvas");

    function getIt() {
      canvas.width = this.width;
      canvas.height = this.height;
      //draw the image onto the canvas
      ctx.drawImage(this, 0, 0);
      //use the data uri 
      test.src = canvas.toDataURL("image/png");
    }
    //untuk ambil data canvas
  </script>

  <!-- Code to handle taking the snapshot and displaying it locally -->
  <script language="JavaScript">
    $('#btn-pros').on('click', function() {

      $.ajax({
        type: 'POST',
        url: '/search_antrian',
        data: {
          '_token': "{{ csrf_token() }}",
          'antr_one': "{{$antrian_oneid}}",
        },
        processData: false,
        contentType: false,
        success: function(data) {
          //console.log(data);
          $('#myModal').modal('show');
          //isi form
          $('#id').val(data[1].id_antrian);
          $('#nama').val(data[0].nama_mahasiswa);
          $('#jurusan').val(data[0].jurusan);
          $('#sesi').val('');
          $('#nim_r').val(data[0].nim);

          id = $('#id').val();

          $('#submitButton').show();
          $('#button_reset').show();

        },
      });
    });
  </script>
  <script language="JavaScript">
    $(document).ready(function() {
      if ($('#antrian_total').text() == 0) {
        setInterval(function() {
          // alert("HELLO");
          // $.ajax({
          //   type: 'GET',
          //   url: '/',
          //   success: function(data) {
          //     alert("Hello");
          //   },
          //   error: function() {
          //     console.log(data);
          //   }
          // });​​​​​​​​​​​​​​​
          window.location.href = "/";
        }, 10000);
      }
    });
  </script>
</body>

</html>