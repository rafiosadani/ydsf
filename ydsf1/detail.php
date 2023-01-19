<?php

require_once "config.php";
// echo $param;
$stmt = $connection->prepare("SELECT * FROM donatur WHERE noid = ?");
$stmt->execute([$_REQUEST['id']]);
$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
$query = $connection->prepare("SELECT *,program.NM_PROGRAM FROM history_tagihan INNER JOIN program ON program.PROG = history_tagihan.prog WHERE noid = ?   ORDER BY tanggal ASC");
$query->execute([$_REQUEST['id']]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$jk['P'] = "Perempuan";
$jk['L'] = "Laki-laki";
?>
<!DOCTYPE html>
<html>
<head>
	<title>History</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.jqueryui.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script>
	<script type="text/javascript" src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<style type="text/css">
	.a{ color: white; text-decoration: none }
</style>
</head>
<body style="margin: 5%">
	<h2>Report</h2>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="<?php echo $base_url."index.php" ?>"><span class="glyphicon glyphicon-home"></span>  Home  </a></li>
			<li class="breadcrumb-item active">Report</li>
		</ol>
	</nav>
	<div class = "panel panel-primary">
		<div class = "panel-heading">
			<h3 class = "panel-title"><span class="glyphicon glyphicon-globe"></span>   Profile Donatur  </h3>
		</div>

		<div class = "panel-body">
			<table class="table">
				<tbody>
					<tr>
						<td>No id</td>
						<td>: <?php echo $fetch['noid'] ?></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: <?php echo $fetch['nama']?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>: <?php echo $fetch['alamat']?></td>
					</tr>
					<tr>
						<td>Tempat Lahir</td>
						<td>: <?php echo $fetch['tmplahir']?></td>
					</tr>
					<tr>
						<td>Tgl Lahir</td>
						<td>: <?php echo date("d F Y", strtotime($fetch['tgllahir']))?></td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>: <?php echo $jk[$fetch['sex']]?></td>
					</tr>
					<tr>
						<td>No Telepon</td>
						<td>: <?php echo $fetch['telphp']?></td>
					</tr>
					<tr>
						<td>Alamat Kantor</td>
						<td>: <?php echo $fetch['almktr']?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td>: <?php echo $fetch['email']?></td>
					</tr>
					<tr>
						
						<a class="btn btn-success" href="<?php echo $base_url."email.php?email=".$fetch['email']."&id=".$_REQUEST['id'] ?>" target="_blank" >
							<span class="glyphicon glyphicon-send"></span>  Send
						</a>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class = "panel panel-primary">
		<div class = "panel-heading">
			<h3 class = "panel-title"><span class="glyphicon glyphicon-globe"></span>   Report</h3>
		</div>

		<div class = "panel-body">
			<table id="table_id" class="table">
				<thead style="text-align: center;">
					<tr>
						<!-- <th style="width: 15%;">Tagihan yg dikirim</th> -->
						<th>No Tagihan</th>
						<th>Program</th>
						<th>Jumlah</th>
						<th>Tanggal</th>
					</tr>
				</thead>
				<tbody id="tbody" style="text-align: justify;">
					<?php 
					foreach ($result AS $key => $value) : ?>
						<tr>
							<!-- <td style="text-align: center !important;"><input type="checkbox"  value="$value['report_id']"></td> -->
							<td><?php echo $value['report_id']; ?></td>
							<td><?php echo $value['NM_PROGRAM']; ?></td>
							<td><?php echo "Rp " . number_format($value['jumlah'],2,',','.'); ?></td>
							<td><?php echo date("d F Y", strtotime(substr($value['tanggal'], 0,10))); ?></td>
						</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
<!--  -->
</html>