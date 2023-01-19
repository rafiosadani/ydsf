<?php
$status = strval($_REQUEST['status']);
require_once "config.php";
$stmt = $connection->prepare("SELECT KODEJ, NAMA FROM jungut");
$stmt->execute();
$fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo $base_url.'get_kawasan.php';
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		console.log(sessionStorage.getItem('status'));
		if (sessionStorage.getItem('status') == null || sessionStorage.getItem('status') == '') {window.location = "<?php echo $site_url ?>";}else{}
	</script>
	<title>Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.jqueryui.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script>
	<script type="text/javascript" src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body style="margin: 5%">
	<?php if($status == 'success_upload') : ?>
		<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Data berhasil Diubah
		</div>
	<?php endif ?>
	<?php if($status == 'success_email') : ?>
		<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Email berhasil Dikirim
		</div>
	<?php endif ?>
	<?php if($status == 'failed') : ?>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Error!</strong> Gagal melakukan tindakan
		</div>
	<?php endif ?>
	<div><h2>Dashboard</h2></div>
	<ul class="nav justify-content-end nav-pills">
		<li><a class="nav-link active" href="setting.php"><span class="glyphicon glyphicon-wrench"></span>  Page Setting  </li></a>
	</ul>
	<div class = "panel panel-primary">
		<div class = "panel-heading">
			<h3 class = "panel-title"><span class="glyphicon glyphicon-globe"></span>   Fitur Pencarian  </h3>
		</div>

		<div class = "panel-body">
			<div class="row">
				<div class="col-md-7">
					<form class="form-inline" style="margin-left: 2%" >
						<!-- <label for="nama"> Nama Donatur </label>
							<input type="text" id="nama" > -->
							<label for="sel">    Jungut </label>
							<select class="form-control" id="sel" style="width: 40%">
								<option value="" selected disabled hidden></option>
								<?php
								foreach ($fetch AS $key => $value) : ?>
									<option value="<?php echo $value['KODEJ']?>"><?php echo $value['KODEJ']?> -- <?php echo $value['NAMA']; ?></option>
									<?php
								endforeach;
								?>
							</select>
							<label for="sel1">   Wilayah </label>
							<select class="form-control" id="sel1" style="width: 40%">
								<option value="" selected >[SEMUA KAWASAN]</option>
							</select>


						</form>
					</div>
					<div class="col-md-2">
						<button id="btn" class="btn btn-success" style="width: 100%"><span class="glyphicon glyphicon-search"></span> Find</button>
					</div>
					<div class="col-md-2">
						<button id="btn-send" class="btn btn-info" style="width: 100%"><span class="glyphicon glyphicon-send"></span> Send Email</button>
					</div>
				</div>
			</div>
		</div>
		<div class = "panel panel-primary">
			<div class = "panel-heading">
				<h3 class = "panel-title"><span class="glyphicon glyphicon-globe"></span>   Result</h3>
			</div>

			<div class = "panel-body">
				<table id="table_id" class="table">
					<thead>
						<tr>
							<th style="width: 5%"><input type="checkbox" value="" id="checkAll"></th>
							<th>Kode</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Email</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tbody">

					</tbody>
				</table>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#table_id").DataTable();
			$("#checkAll").click(function () {
				$('input:checkbox').not(this).prop('checked', this.checked);
			});
			$("#btn-send").on('click', function() {
				var id = '';
				$.each($("#table_id tr input:checked"), function(idx, val) {
					id += $(this).parent().siblings(":first").text();
					
				});
				window.location = "<?php echo $base_url.'email.php?id=' ?>"+id;
			});
			
			$("select#sel").change(function(){
				var selected = $(this).children("option:selected").val();
				var cont = '<option value="" >[SEMUA KAWASAN]</option>';
				$.ajax({
					type  : 'GET',
					url   : '<?php echo $base_url."get_kawasan.php" ?>',
					data  : {kodej : selected},
					async : true,
					dataType : 'json',
					success : function(data){
						for (var i=0;i<data.length;i++) {
							cont += '<option value="'+data[i].kwsn+'">'+data[i].kwsn+'/'+data[i].kwsn_lm+' -- '+data[i].nm_kawasan+'</option>';
						};
						$('select#sel1').html(cont);
					}
				});
			});
			$("button#btn").click(function(){
				$("#table_id").DataTable().destroy();
				var selected = $('#sel1').children("option:selected").val();
				var cont = '';
				$.ajax({
					type  : 'GET',
					url   : '<?php echo $base_url."get_donatur.php" ?>',
					data  : {kwsn : selected},
					async : true,
					dataType : 'json',
					success : function(data){
						for (var i=0;i<data.length;i++) {
							cont += '<tr>'+
							'<td><input id="c" name="cb" type="checkbox" value=""'+data[i].noid +'"></td>'+
							'<td>'+data[i].noid +'</td>'+
							'<td>'+data[i].nama +'</td>'+
							'<td>'+data[i].alamat +'</td>'+
							'<td>'+data[i].email +'</td>'+
							'<td style="text-align:right;">'+
							'<a href="<?php echo $base_url."detail.php?id="?>'+data[i].noid+'" class="btn btn-info btn-sm item_edit">Detail</a>'+ 
							'</td>'+
							'</tr>';
						};
						$('#tbody').html(cont);
// $("#Table_id")
$('#table_id').DataTable();
}
});
			// }
			
		});
		});
	</script>
	</html>