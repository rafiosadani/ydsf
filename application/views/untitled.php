<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('partials/head'); ?>
	<title>Membuat Pagination Pada CodeIgniter | MalasNgoding.com</title>
</head>
<body>
<h1>Membuat Pagination Pada CodeIgniter | MalasNgoding.com</h1>
<form method="post" action="<?php echo base_url('donatur/mainan') ?>">
	<select name="value" onchange="this.form.submit()">
		<option value="10">10</option>
		<option value="25">25</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select>
</form>
	<table border="1">
		<tr>
			<th>kawasan</th>
			<th>noid</th>
			<th>nama</th>
			<th>status</th>
			<th>alamat</th>
			<th>program</th>
			<th>besar</th>
			<th>petugas</th>						
		</tr>
		<?php 
		$no = $this->uri->segment('3') + 1;
		foreach($user as $u){ 
		?>
		<tr>
			<td><?php echo $u->kwsn ?></td>
			<td><?php echo $u->noid ?></td>
			<td><?php echo $u->nama ?></td>
			<td><?php echo $u->status ?></td>
			<td><?php echo $u->alamat ?></td>
			<td><?php echo $u->NM_PROGRAM ?></td>
			<td><?php echo $u->besar ?></td>
			<td><?php echo $u->kodejgt ?></td>
		</tr>
	<?php } ?>
	</table>
	<br/>
	<?php 
	echo $this->pagination->create_links();
	?>
</body>
</html>