<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('partials/head') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css"
        rel="stylesheet" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view('partials/header') ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('partials/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Rekap Kwitansi Gagal
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Rekap Kwitansi Gagal</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">Filter Pencarian</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <div class="row">
                                  <form action="" method="post" target="_blank">
                                      <div class="form-group">
                                          <div class="col-sm-4">
                                              <label for="kodej" class="control-label">Jungut<span style="color: red">
                                                      *</span></label>
                                              <select class="form-control selectpicker" id="kodej" name="kodej" data-live-search="true">
                                                <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
                                                <option name="kodej" value="-">SEMUA JUNGUT</option>
                                                <?php endif; ?>
                                                  <?php foreach($jungut as $jungut) : ?>
                                                  <option name="kodej" value="<?php echo $jungut->kodej."|".$jungut->name; ?>"><?php echo $jungut->kodej." - ".$jungut->name ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>

                                          <div class="col-sm-4">
                                              <label for="date" class="control-label">Tanggal<span style="color: red">
                                                      *</span></label>
                                              <div class="input-group date">
                                                  <div class="input-group-addon">
                                                      <i class="fa fa-calendar"></i>
                                                  </div>
                                                  <input type="text" class="form-control daterange-btn" id="date" name="date" />
                                              </div>
                                          </div>

                                          <div class="col-sm-2">
                                              <label for="button"> </label>
                                              <button id="btnsubmit" type="button" name="button" class="btn btn-block btn-success">
                                                  Submit
                                                  <span><i class="fa fa-search"></i></span>
                                              </button>
                                          </div>
                                          <div class="col-sm-1">
                                            <label for="cetak"></label>
                                              <button type="submit" name="btncetak" class="btn btn-block btn-info"><span class="glyphicon glyphicon-print text-light"></span></button>
                                            </div>
                                      </div>
                                      </form>
                              </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- </form> -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row (main row) -->
                <?php
                  if ($this->input->post('kodej') && $this->input->post('date')) {
                    list($jungut,$nm_jungut) = explode('|', $_POST['kodej']);
                    $tgl = $this->input->post('date');
                    header("location:".base_url()."report/gagal-kwitansi/rekap?jungut=$jungut&&tgl=$tgl&&nm=$nm_jungut");
                  }
                 ?>

                <div class="row" id="divTable" style="display:none;">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title"></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th> </th>
                                                <th>No Slip</th>
                                                <th>Program</th>
                                                <th>Belum Koreksi</th>
                                                <th>Koreksi</th>
                                                <th>Setelah Koreksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('partials/footer') ?>


    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('partials/modal') ?>

    <!-- <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script> -->
</body>
<?php $this->load->view('partials/js'); ?>
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function () {

        $("#table").DataTable();
        $(function () {
            $('.daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: moment().startOf('month'),
                    endDate: moment().endOf('month')
                },
                function (start, end) {
                    $('.daterange-btn').html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'))
                }

            )

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })
        });

        $("#btnsubmit").click(function() {
            // $("#table").DataTable();
            // $("#table").DataTable().destroy();
            tampil();
            function tampil() {
                $("#table").DataTable().destroy();
                $('#divTable').show();
                var kodej = $("select#kodej").children("option:selected").val();
                var date = $("#date").val();
                // console.log(date);
                var cont = "";
                $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('gagal_kwitansi/getData') ?>',
                    data  : {
                        kodej : kodej,
                        date : date,
                    },
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                        for (var i=0;i<data.length;i++) {
                           var jumlaha = data[i].jumlah;
                           var reverse = jumlaha.toString().split('').reverse().join(''),
                           jumlah = reverse.match(/\d{1,3}/g);
                           jumlah = jumlah.join('.').split('').reverse().join('');
                            var action = "";
                            var kwit = false;

                            var jmlha = data[i].jmlh;
                            var reverse = jmlha.toString().split('').reverse().join(''),
                            jmlh = reverse.match(/\d{1,3}/g);
                            jmlh = jmlh.join('.').split('').reverse().join('');
                             var action = "";
                             var kwit = false;

                             var jmla = (data[i].jumlah-data[i].jmlh);
                             var reverse = jmla.toString().split('').reverse().join(''),
                             jml = reverse.match(/\d{1,3}/g);
                             jml = jml.join('.').split('').reverse().join('');
                              var action = "";
                              var kwit = false;



                            cont += '<tr noslip="'+ data[i].noslip +'" nm_program="'+ data[i].nm_program +'" jumlah="'+ data[i].jumlah +'" jmlh="'+ data[i].jmlh +'" jumlah="'+ (data[i].jumlah-data[i].jmlh) +'" >'+action+
                                '<td>'+(i+1)+'</td>'+
                                '<td><a href="<?php echo base_url('report/gagal-kwitansi/validasi?noslip=')?>'+ data[i].noslip +'" target="_blank"><button class="btn btn-info"><span class="glyphicon glyphicon-print text-light"></span></button></a></td>'+
                                '<td>'+data[i].noslip+'</td>'+
                                '<td>'+data[i].nm_program+'</td>'+
                                '<td>'+jumlah+'</td>'+
                                '<td>'+jmlh+'</td>'+
                                '<td>'+jml+'</td>'+
                                '</tr>';
                        }
                        $("#tbody").html(cont);
                        $("#table").DataTable();
                        // console.log(kwit);
                    }
                });
            }

        });
    });







    // $(document).ready(function(){
    //     $("#form-val").submit(function(){
    //         $('#modal-validasi').modal('hide');
    //     });
    // });
</script>

</html>
