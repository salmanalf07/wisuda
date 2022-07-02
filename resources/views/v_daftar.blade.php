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
  <title>DAFTAR</title>
</head>
<script type="text/javascript">
  function addEvent(obj, name, func) {
    if (obj.attachEvent) {
      obj.attachEvent("on" + name, func);
    } else {
      obj.addEventListener(name, func, false);
    }
  }

  function log(data) {
    $.ajax({
      type: 'POST',
      url: '/search_nim',
      data: {
        '_token': "{{ csrf_token() }}",
        'card': data,
      },
      success: function(dataa) {
        //console.log(data);

        //isi form
        $('#nim').val(dataa.nim);

        search(dataa.nim);

      },
    });
  }

  function log2() {
    $.ajax({
      type: 'POST',
      url: '/search_nim',
      data: {
        '_token': "{{ csrf_token() }}",
        'card': $('#nim').val(),
      },
      success: function(dataa) {
        //console.log(data);

        //isi form
        $('#nim').val(dataa.nim);

        search(dataa.nim);

      },
    });
  }

  function pluginLoaded() {
    window.webcard = document.getElementById("webcard");
    //log("WebCard version " + webcard.version);
    addEvent(webcard, "cardpresent", cardPresent);
    addEvent(webcard, "cardremoved", cardRemoved);
    for (var i = 0; i < webcard.readers.length; i++) {
      var rdr = document.createElement("h3");
      //rdr.textContent = webcard.readers[i].name;
      rdr.id = webcard.readers[i].name.replace(/\s/g, "").toLowerCase();
      document.getElementById("readerList").appendChild(rdr);
    }
  }

  function cardPresent(reader) {
    document.getElementById(reader.name.replace(/\s/g, "").toLowerCase()).style.color = "green";
    setTimeout(initCard(reader), 10);
  }

  function cardRemoved(reader) {
    document.getElementById(reader.name.replace(/\s/g, "").toLowerCase()).style.color = "inherit";
  }

  function initCard(reader) {
    reader.connect(2); // 1-Exclusive, 2-Shared
    //log("ATR : " + reader.atr);
    var apdu = "FFCA000000";
    var resp = reader.transcieve(apdu);
    if (resp.substr(-4) == "9000") {
      //log("UID : " + resp.substr(0, resp.length - 4));            
      log(resp.substr(0, resp.length - 4));
    }
    reader.disconnect();
  }
</script>

<body>
  <div class="judul">
    <p>Aplikasi Antrian Wisuda @BINUS BEKASI</p>
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
              <input class="form-control" name="nim" id="nim" cols="1" rows="1" placeholder="ID CARD / NIM" autofocus />
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
              <button class="btn" onclick="log2()">Submit</button>
            </div>
          </div>
        </div>
        <div class="col-md-10 detail">
          <div class="card card-chart">
            <div class="card-header">
              DATA PENGAMBIL IJAZAH
            </div>
            <div class="card-body">
              <form role="form" id="form-add">
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
              </form>
              <div class="card-footer">
                <button id="button_reset" class="btn btn-danger">
                  Clear Data
                </button>
                <button id="submitButton" type="button" class="btn btn-primary">
                  Buat Antrian
                </button>
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
  <script src="/assets/wacom/connect-wacom.js"></script>
  <script>
    function search(dataa) {

      $.ajax({
        type: 'POST',
        url: '/search',
        data: {
          '_token': "{{ csrf_token() }}",
          'nim': dataa,
        },
        success: function(data) {
          //console.log(data);

          //isi form
          $('#id').val(data.id);
          $('#nama').val(data.nama_mahasiswa);
          $('#jurusan').val(data.jurusan);
          $('#nim_r').val(data.nim);

          id = $('#id').val();
          $('.detail').show();
          $('#submitButton').show();
          $('#button_reset').show();

        },
      });

    };

    //add data
    $('.card-footer').on('click', '#submitButton', function() {
      $.ajax({
        type: 'POST',
        url: '{{ url("create_antrian") }}',
        data: {
          '_token': "{{ csrf_token() }}",
          'nim': $('#nim_r').val(),
        },
        success: function() {
          document.getElementById("form-add").reset();
          $('#nim').val('');
          window.location.href = "/daftar";

        },
      });
    });
    //end add data

    $('#button_reset').on('click', function() {
      document.getElementById("form-add").reset();
      $('#nim').val('');
      window.location.href = "/daftar";
    });
  </script>

</body>

</html>