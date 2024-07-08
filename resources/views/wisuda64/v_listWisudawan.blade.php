<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/css/login.css">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/googlefontapis/css/roboto.css">
  <link rel="stylesheet" href="/assets/googlefontapis/css/material-icons.css">
  <!-- CSS Files -->
  <link href="/assets/css/material-dashboard.css" rel="stylesheet" />
  <!-- datatable -->
  <link href="/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <title>LIST WISUDAWAN</title>
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

<body>
  <object id="webcard" type="application/x-webcard" width="0" height="0">
    <param name="onload" value="pluginLoaded" />
  </object>
  <div class="container">
    <div class="wrapper-login" style="max-width: 100%">
      <div class="row">
        <div class="col-md-10" style="margin: 0 auto;">
          <div class="card card-chart">
            <div class="card-header card-header-" style="background-color:  #c1a1d3;color:black">
              LIST WISUDAWAN
            </div>
            <div id="readerList" hidden></div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <label for="shift">shift</label>
                  <select class="form-control" name="shift" id="shift" cols="1" rows="1">
                    <option value="#" selected>--PILIH--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="loket">Loket</label>
                  <select class="form-control" name="loket" id="loket" cols="1" rows="1">
                    <option value="#" selected>--PILIH--</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="status">Status</label>
                  <select class="form-control" name="status" id="status" cols="1" rows="1">
                    <option value="#" selected>--PILIH--</option>
                    <option value="skip">Skip</option>
                  </select>
                </div>
              </div>


            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card card-chart">
            <table id="example1" class="table tabtab">
              <thead>
                <tr>
                  <th>NIM</th>
                  <th>NO KURSI</th>
                  <th>NAMA</th>
                  <th>JURUSAN</th>
                  <th>AKSI</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>



      </div>
    </div>
  </div>
  <script src="/assets/js/jquery-3.5.1.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/libs/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="/assets/js/datatable.js"></script>

  <script>
    $(function() {

      var oTable = $('#example1').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"bottom"pi>',
        "responsive": true,
        "lengthChange": true,
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        "autoWidth": false,
        "columnDefs": [{
            "className": "text-center",
            "targets": [0, 1, 4], // table ke 1
          },
          {
            "className": "text-left",
            "targets": [2, 3], // table ke 1
          },
        ],
        ajax: {
          url: '/get_listWusudawan/{{$thWisuda}}',
          data: function(d) {
            // Retrieve dynamic parameters
            var dt_params = $('#example1').data('dt_params');
            // Add dynamic parameters to the data object sent to the server
            if (dt_params) {
              $.extend(d, dt_params);
            }
          }
        },
        columns: [{
            data: 'nim',
            name: 'nim'
          },
          {
            data: 'noKursi',
            name: 'noKursi'
          },
          {
            data: 'nama_mahasiswa',
            name: 'nama_mahasiswa'
          },
          {
            data: 'jurusan',
            name: 'jurusan'
          },
          {
            data: 'keterangan',
            name: 'keterangan'
          }
        ],
      });
    });

    $('#shift, #loket, #status').on('change', function() {

      $('#example1').data('dt_params', {
        'shift': $('#shift').val(),
        'loket': $('#loket').val(),
        'status': $('#status').val(),
      });
      $('#example1').DataTable().draw();
    });

    $('.col-12').on('click', '#clear', function() {
      $('#shift').val('#').trigger('change');
      $('#loket').val('#').trigger('change');
      $('#status').val('#').trigger('change');
      $('#example1').data('dt_params', {});
      $('#example1').DataTable().draw();
    });
  </script>

</body>

</html>