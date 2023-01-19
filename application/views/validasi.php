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
                    Rekap Validasi
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Rekap Validasi</li>
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
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="kodej" class="control-label">Jungut<span style="color: red">
                                                        *</span></label>
                                                <select class="form-control selectpicker" id="kodej" name="kodej" data-live-search="true">
                                                    <?php foreach($jungut as $jungut) : ?>
                                                    <option name="kodej" value="<?php echo $jungut->kodej ?>"><?php echo $jungut->kodej." - ".$jungut->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-5">
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
                                                    <span><iclass="fa fa-search"></i></span>
                                                </button>
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
                                                <th>No Slip</th>
                                                <th>Tgl Setor</th>
                                                <th>Bank</th>
                                                <th>Jumlah</th>
                                                <th>Validasi</th>
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
<?php $this->load->view('partials/js') ?>
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

        function numberFormat(angka) {
            var rupiah = '';    
            var angkarev = angka.toString().split('').reverse().join('');
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rupiah.split('',rupiah.length-1).reverse().join('');
        }

        $("#btnsubmit").click(function() {
            $("#table").DataTable().destroy();
            $('#divTable').show();
            var kodej = $("select#kodej").children("option:selected").val();
            var date = $("#date").val();
            // console.log(date);
            var cont = "";
            $.ajax({
                type  : 'GET',
                url   : '<?php echo base_url('validasi/getData') ?>',
                data  : {
                    kodej : kodej,
                    date : date,
                },
                async : true,
                dataType : 'json',
                success : function(data){
                    for (var i=0;i<data.length;i++) {
                        cont += '<tr><td><a href="<?php echo base_url('report/validasi/rekap/')?>'+ data[i].noslip +'" target="_blank">'+ data[i].noslip +'</a></td>'+
                        '<td>'+ data[i].tgl_setor +'</td>'+
                        '<td>'+ data[i].bank +'</td>'+
                        '<td>'+ numberFormat(data[i].jumlah) +'</td>'+
                        '<td>'+ data[i].validasi +'</td>'+
                        '</tr>';
                    }
                    $("#tbody").html(cont);
                    $("#table").DataTable();
                    // $('.selectpicker').selectpicker('refresh');
                    console.log(data);
                }
            });
        });
        // $("#table").dataTable();
    }); 
</script>

</html>