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
                    <option value="open">Open</option>
                    <option value="close">Close</option>
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
                  <th>SESI</th>
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
                    <tr class="mt-5">
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
                    <button style="padding: 8px 30px;width:20%" type="submit" id="submitButton" class="btn btn-primary">SEND DATA</button>
                  </div>
                </form>
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
            "targets": [0, 1, 2, 3, 4, 5], // table ke 1
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
            data: 'sesi',
            name: 'sesi'
          },
          {
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
            data: 'aksi',
            name: 'aksi'
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

    $(document).on('click', '#but_skip', function(e) {
      e.preventDefault();
      var nim = $(this).data('id');
      var status = $(this).data('status');
      $.ajax({
        type: 'POST',
        url: '/skip64',
        data: {
          '_token': "{{ csrf_token() }}",
          'nim': nim,
          'status':status,
          'thWisuda': '{{$thWisuda}}',
        },
        success: function(dataa) {
          $('#example1').DataTable().ajax.reload();
        },
      });
    });

    $(document).on('click', '#but_wid', function(e) {
      e.preventDefault();
      var uid = $(this).data('id');

      $.ajax({
          type: 'POST',
          url: '/search64',
          data: {
            '_token': "{{ csrf_token() }}",
            'nim': uid,
            'wisuda': 'wisuda' + '{{$thWisuda}}',
          },
          success: function(data) {
            //console.log(data);
            // $('#myModal').modal('show');
            // //isi form
            $('#id').val(data[1].id);
            $('#nama').val(data[1].nama_mahasiswa);
            $('#jurusan').val(data[1].jurusan);
            $('#nim_r').val(data[1].nim);
            $('#sesi'). val(data[1].noKursi)
  
            id = $('#id').val();
            // $('.detail').show();
            $('#submitButton').show();
            $('#button_reset').show();
            //console.log(data[1].antrian[0].keterangan.split(","))
            var checkboxes = data[1].antrian[0].keterangan.split(",");
            for (var i = 0; i < checkboxes.length; i++) {
              $('#berkas' + checkboxes[i]).prop('checked', true);
            }
  
            $('#myModal').modal('show');
  
          },
        });
    });
    $("#form-add").submit(function(e) {
      e.preventDefault();
      var form = document.getElementById("form-add");
      var fd = new FormData(form);

      $.ajax({
        type: 'POST',
        url: '/upd_berkas',
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
          // $('#svgResult').attr("src", "/assets/image/succes.svg");
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
          // $("#svgResult").attr("src", "/assets/image/remove.svg");
          $('#linkCetak').hide();
          $('#hasil').text('Data Gagal Disimpan');
        }
      });
    });
  </script>

</body>

</html>