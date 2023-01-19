<!DOCTYPE html>
<html>
<?php $this->load->model('Mdonatur'); ?>
<head>
  <?php $this->load->view('partials/head') ?>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
          Dashboard
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Data Donatur</li>
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
                <h3 class="box-title">Data Donasi</h3>
                <a href="<?php echo base_url('data/donasi/baru') ?>"><button class="btn btn-primary" style="margin-left: 15px"><span class="glyphicon glyphicon-plus text-light"></span><b>  Baru</b></button></a>
                
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">

<table id="donasi" class="table table-bordered table-striped table-hover display">
        <thead>
            <tr>
                	<th>Print</th>
                  <th>No.donatur</th>
                  <th>Nama</th>
                  <th>Program</th>
                  <th>Jumlah</th>
                  <!--<th>Petugas</th>-->
            </tr>
        </thead>
        <tbody>
            <tr>
				<td colspan="6" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
    </table>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


  </div>
  <!-- ./wrapper -->

  <?php $this->load->view('partials/modal') ?>

  <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
    
    var table;
    table=$('#donasi').DataTable(
    	{
    		"processing": true, //Feature control the processing indicator.
        	"serverSide": false, //Feature control DataTables' server-side processing mode.
         	"order": [], //Initial no order.
         	"pagingType": "full_numbers",
		   	"paging": true,
   			"lengthMenu": [10, 25, 50, 75, 100],

         // Load data for the table's content from an Ajax source
         	"ajax": {
            	"url": "<?php echo base_url('donasi/listDonasi');?>",
            	"type": "POST"
         	},
         //Set column definition initialisation properties.
         "columns": [
              { "name": "action", "data": "report_id","orderable": false ,    "render": function ( data, type, row, meta ) {
			return "<a class='fa fa-print one'><i></i></a>&nbsp<a class='fa fa-print two'><i></i></a>";
		}},
             { "name": "noid", "data": "noid","orderable": true},
             { "name": "nama", "data": "nama","orderable": true},
             { "name": "program", "data": "NM_PROGRAM","orderable": true},
             { "name": "nominal", "data": "report_nominal","orderable": true}
             //,{ "name": "jupen", "data": "name","orderable": true}
         ]
    	}
    	);
  </script>

</body>
<?php $this->load->view('partials/js') ?>
<script>
$('#donasi tbody').on( 'click', '.one', function () {
    var index = $(this).closest('tr').index();
    var data=table.row(index).data();
    
 	window.open("http://localhost/reprint.php?jupen_alm="+data['s_almktr']+"&&jupen_tlpktr="+data['s_tlp']+"&&nama="+data['nama']+"&&alamat="+data['almktr']+"&&program="+data['NM_PROGRAM']+"&&nominal="+data['report_nominal']+"&&jupen_nama="+data['name']+"&&jupen_tlp="+data['s_petugas']+"&&jupen_terima="+data['s_terima']+"&&jupen_doa="+data['s_doa']+"&&jupen_web="+data['s_web']);
          							
} );
$('#donasi tbody').on( 'click', '.two', function () {
    var index = $(this).closest('tr').index();
    var data=table.row(index).data();
    window.open("<?= base_url('data/donasi/print/');?>?jupen_alm="+data['s_almktr']+"&&jupen_tlpktr="+data['s_tlp']+"&&noid="+data['noid']+"&&nama="+data['nama']+"&&alamat="+data['almktr']+"&&rk="+data['rk']+"&&ins_pk="+data['ins_pk']+"&&report_ket="+data['report_ket']+"&&program="+data['NM_PROGRAM']+"&&nominal="+data['report_nominal']+"&&jupen_nama="+data['name']+"&&jupen_tlp="+data['s_petugas']+"&&jupen_terima="+data['s_terima']+"&&jupen_doa="+data['s_doa']+"&&jupen_web="+data['s_web']);       							
} );
</script>
<!-- <script>
  $(function () {
    $('#donatur').DataTable()
  })
</script> -->
<!-- <script type="text/javascript">
 
 var save_method; //for save method string
 var table;

 $(document).ready(function() {
     //datatables
     table = $('#donatur').DataTable({ 
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
             "url": '',
             "type": "POST"
         },
         //Set column definition initialisation properties.
         "columns": [
             {"aaData": 0},
             {"aaData": 1},
             {"aaData": 2}
         ]

     });

 });
</script> -->
</html>