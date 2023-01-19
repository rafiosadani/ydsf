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
                    Validasi Tunai
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
                                                <label for="kodej" class="control-label">Jungut<span style="color: red;">*</span></label>
                                                <select class="form-control selectpicker" id="kodej" name="kodej" data-live-search="true">
                                                    <?php foreach($jungut as $jungut) : ?>
                                                    <option name="kodej" value="<?php echo $jungut->kodej ?>"><?php echo $jungut->kodej." - ".$jungut->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-5">
                                                <label for="date" class="control-label">Tanggal<span style="color: red">*</span></label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control daterange-btn" id="date" name="date" />
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <button id="btnsubmit" type="button" name="button" class="btn btn-block btn-success" style="margin-top: 24px;">
                                                    Submit 
                                                    <span><i class="fa fa-search"></i></span>
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
                                                <th>Action</th>
                                                <th>No Slip</th>
                                                <th>Nama Petugas</th>
                                                <th>Nominal</th>
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

	<!-- Modal -->
	<div class="modal fade" id="modalaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Print Validasi</h4>
	      </div>
	      <div class="modal-body" id="modalaction-button" >
	        <div id="templete"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	      </div>
	    </div>
	  </div>
	</div>

	<?php $this->load->view('partials/modal'); ?>
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
            var cont = "";
            $.ajax({
                type  : 'GET',
                url   : '<?php echo base_url('valtunai/getData') ?>',
                data  : {
                    kodej : kodej,
                    date : date,
                },
                async : true,
                dataType : 'json',
                success : function(data){
                    for (var i=0;i<data.length;i++) {
                        if (data[i].validasi == 'Sudah') {
                            cont += '<tr noslip="'+data[i].noslip+'"><td style="text-align:center;width:10px;"><button id="btAction" class="btn btn-success"><span class="glyphicon glyphicon-print text-light"></span></button></td>';
                        } else {
                            cont += '<tr data-noslip="'+data[i].noslip+'" data-nominal="'+data[i].nominal+'" data-kodej="'+data[i].entr_pegawai+'" id="tanda"><td style="text-align:center;width:10px;"><button id="btnAction" data-target="#modalaction" data-toggle="modal" class="btn btn-danger"><span class="glyphicon glyphicon-plus text-light"></span></td>';
                        }

                        cont += '<td>'+ data[i].noslip +'</td>'+
                        '<td>'+ data[i].name +'</td>'+
                        '<td>'+ numberFormat(data[i].nominal) +'</td>'+
                        '</tr>';
                    }
                    $("#tbody").html(cont);
                    $("#table").DataTable();
                    // $('.selectpicker').selectpicker('refresh');
                    //console.log(data);
                }
            });
        });

        $(document).on('click', 'button#btnAction', function() {
        	var _this = $(this).closest('tr');
            var noslip = $('tr#tanda').data('noslip');
            $('#modalaction-button #templete').html('<a href="<?php echo base_url('front-office/validasi-tunai/rekap-tunai/')?>'+ noslip +'" target="_blank" ><button class="btn btn-success" id="btn-cetak"> Cetak <span class="glyphicon glyphicon-print text-light"></span></button></a>');
        });

        $(document).on('click', 'button#btn-cetak', function() {
        	var noslip = $('tr#tanda').data('noslip');
        	var nominal = $('tr#tanda').data('nominal');
        	var kodej = $('tr#tanda').data('kodej');
            var cont = "";
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('valtunai/updateValInsert') ?>',
                data: {
                    noslip: noslip,
                    nominal: nominal,
                    kodej: kodej
                },
                async : true,
                dataType: 'json',
                success : function(data) {
                    $("#table").DataTable().destroy();
                    $('#divTable').show();
                    var date = $('#date').val();
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('valtunai/getDataReload') ?>',
                        data  : {
                            kodej : kodej,
                            date : date,
                        },
                        async : true,
                        dataType : 'json',
                        success : function(data2) {
                            console.log('oee lerr!');
                            console.log(data2);
                            for (var i=0;i<data2.length;i++) {
                                if (data2[i].validasi == 'Sudah') {
                                    if( noslip == data2[i].noslip ) {
                                        cont += '<tr style="background:rgb(66, 244, 238);" noslip="'+data2[i].noslip+'"><td style="text-align:center;width:10px;"><button id="btAction" class="btn btn-success"><span class="glyphicon glyphicon-print text-light"></span></button></td>';
                                    } else {
                                        cont += '<tr noslip="'+data2[i].noslip+'"><td style="text-align:center;width:10px;"><button id="btAction" class="btn btn-success"><span class="glyphicon glyphicon-print text-light"></span></button></td>';
                                    }
                                } else {
                                    cont += '<tr data-noslip="'+data2[i].noslip+'" data-nominal="'+data2[i].nominal+'" data-kodej="'+data2[i].entr_pegawai+'" id="tanda"><td style="text-align:center;width:10px;"><button id="btnAction" data-target="#modalaction" data-toggle="modal" class="btn btn-danger"><span class="glyphicon glyphicon-plus text-light"></span></td>';
                                }

                                cont += '<td>'+ data2[i].noslip +'</td>'+
                                '<td>'+ data2[i].name +'</td>'+
                                '<td>'+ numberFormat(data2[i].nominal) +'</td>'+
                                '</tr>';
                            }
                            $("#tbody").html(cont);
                            $("#table").DataTable();
                        }
                    });
                }
            }); 
            $('#modalaction').modal('hide');      	   	
        });

        $(document).on('click', 'button#btAction', function () {
        	var _this = $(this).closest('tr');
        	var noslip = $(_this).attr('noslip');
           	window.open('<?= base_url('front-office/validasi-tunai/rekap-tunai/')?>' + noslip);
        });
    }); 
</script>
</html>