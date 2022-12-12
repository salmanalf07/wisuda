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
  <title>Dashboard Antrian</title>
</head>

<body>
  <div class="judul">
    <p>Aplikasi Antrian Wisuda @BINUS BEKASI</p>
  </div>
  <div class="container">
    <div class="wrapper-login" style="margin-top:100px">
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
                <p style="margin:0; text-align:center;font-size:12pt;color:black">{{$nam_antrian}}</p>
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

      </div>
    </div>
  </div>
  <script src="/assets/js/jquery-3.5.1.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>

  <script language="JavaScript">
    $(document).ready(function() {
      setInterval(function() {
        window.location.href = "/dashboard";
      }, 10000);
    });
  </script>
</body>

</html>