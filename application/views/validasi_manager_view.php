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
                <button class="btn btn-success" style="margin-left: 15px" onclick="validasi()"><span class="glyphicon glyphicon-check text-light"></span><b>  Validasi</b></button>
                <button class="btn btn-primary" style="margin-left: 15px" onclick="laporan()"><span class="glyphicon glyphicon-list-alt text-light"></span><b>  Laporan</b></button>
                
              </div>
              <div class="form-group">
              <div class="col-sm-1">
                          <label for="jupen" class="control-label">Kasir<span style="color: red"> *</span></label></div>
            	<div class="col-sm-3">
                          <select class="form-control" name="jupen" data-live-search="true" required id="jupen">
                            <option value="">Semua Kasir</option>
                            <?php 
                            
                            foreach($petugas as $kasir) : ?>  
                              <option value="<?php echo $kasir->report_jupen ?>"><?php echo $kasir->name ?></option>
                            <?php endforeach; ?>
                          </select>
                          
                        </div>
                        
                        </div>
                        <br>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
		<center><div id="total_check">TOTAL SETORAN : 0</div></center>
<table id="donasi" class="table table-bordered table-striped table-hover display">
        <thead>
            <tr>
                	<th>Action&nbsp&nbsp<input type="checkbox" id="select_all" value="1"></th>
                      <th>Status</th>
                      <th>Jungut</th>
                      <th>No.donatur</th>
                      <th>Nama</th>
                      <th>Program</th>
                      <th>Jumlah</th>
                      <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
				<td colspan="5" class="dataTables_empty">Loading data from server</td>
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
  var rows_selected = [];

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
            	"url": "<?php echo base_url('donasi/listValidasi');?>",
            	"type": "POST"
         	},
         //Set column definition initialisation properties.
         "columns": [
              { "name": "action", "data": "report_id","orderable": false ,    "render": function ( data, type, row, meta ) {
			return "<input type='checkbox'/>";
		}},
             { "name": "status", "data": "status","orderable": true},
             { "name": "jungut", "data": "jupen","orderable": true},
             { "name": "noid", "data": "noid","orderable": true},
             { "name": "nama", "data": "nama","orderable": true},
             { "name": "program", "data": "NM_PROGRAM","orderable": true},
             { "name": "nominal", "data": "report_nominal","orderable": true},
             { "name": "petugas", "data": "petugas","orderable": true}
         ]
    	}
    	);
    	
    $( "#jupen" ).change(function() {
    	var name    = $(this).children('option:selected').text();
        if(name=="Semua Kasir")
        	name="";
  		table.search(name).draw() ;
	});
	var total=0;
$('#select_all').on('click', function(){
      // Get all rows with search applied
	var rows = table.rows({ 'search': 'applied' }).nodes();
	
      //alert( 'Rows '+table.data().count()+' are selected' );
      // Check/uncheck checkboxes for all rows in the table
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
    if(this.checked){
    total=0;
    	table.data().each( function (row) {
    		rows_selected.push(row.report_id);
    		total=total+parseInt(row.report_nominal);
    	});
    	console.log(JSON.stringify(rows_selected));
    }
    else{
    	rows_selected.length=0;
		total=0;
		}
	$('#total_check').html("TOTAL SETORAN : "+total);	    
   });
   
   
$('#donasi tbody').on('click', 'input[type="checkbox"]', function(e){
        //alert('clicked');
    var $row = $(this).closest('tr');
      // Get row data
    var data = table.row($row).data();
      // Get row ID
    var rowId = data['report_id'];
    var jumlah= data['report_nominal'];
      // Determine whether row ID is in the list of selected row IDs
    var index = $.inArray(rowId, rows_selected);
      // If checkbox is checked and row ID is not in list of selected row IDs
    if(this.checked && index === -1){
        rows_selected.push(rowId);
    	total=total+parseInt(jumlah);
      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
    }
    else if (!this.checked && index !== -1){
        rows_selected.splice(index, 1);
        total=total-jumlah;
    }
    
    $('#total_check').html("TOTAL SETORAN : "+total);
   console.log(JSON.stringify(rows_selected));
});

function validasi() {
$.ajax({
          type  : "POST",
          url   : "<?php echo base_url('donasi/saveValidasi') ?>",
          data  : {id : JSON.stringify(rows_selected)},
          dataType : 'json',
          success : function(data){
           			table.ajax.reload(null,false);
           			rows_selected.length=[];
           			total=0;
           			$('#total_check').html("TOTAL SETORAN : "+total);
            }
          });
}
function laporan() {
$.ajax({
          type  : "POST",
          url   : "<?php echo base_url('donasi/saveLaporan') ?>",
          data  : {id : JSON.stringify(rows_selected)},
          dataType : 'json',
          success : function(data){
           			table.ajax.reload(null,false);
           			rows_selected.length=[];
           			total=0;
           			$('#total_check').html("TOTAL SETORAN : "+total);
            }
          });
}
//$("#frm-select").submit();
  </script>

</body>
<?php $this->load->view('partials/js') ?>
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