<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">


	<div class="box-body table-responsive">
		<table border=0 width="100%">
			<tr style="font-family:verdana;font-size:17px">
				<td align="center"><?php echo $data['title'] ?></td>
				<td rowspan=2></td>
			</tr>
			<tr style="font-family:arial;font-size:15px;">
				<td align="center"><?php echo $data['subtitle'] ?></td>
			</tr>
			<tr style="font-family:arial;font-size:15px;">
				<td align="center">Yayasan Dana Sosial Al-Falah</td>
			</tr>
			<p></p>
			<p></p>
			<p></p>
			<p></p>
		</table>
		<p></p>
		<p></p>
		<table width="100%">
			<tr>
				<td width="17%" align="left">Tanggal</td>
				<td width="2%" align="left">:</td>
				<td align="left"><?php echo date('d F Y', strtotime($petugas->tgl_val)) ?></td>
				<td width="17%">Nomer</td>
				<td width="2%" align="left">:</td>
				<td width="21%"align="left"><?php echo $petugas->val_tunai . ' - ' . $petugas->id_tunai; ?></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="17%" align="left">Nama Petugas</td>
				<td width="2%" colspan="2" align="left">:</td>
				<td align="left"><?php echo $petugas->name ?></td>
			</tr>
		</table>
		<p></p>
		<table width="100%">
			<tr>
				<td width="50%"><b>Nama Program</b></td>
				<td width="50%"><b>Nominal</b></td>
			</tr>
			<tr>
				<td colspan='6'>
					<hr>
				</td>
			</tr>
			<?php 
				$sum1 = $sum2 = 0;
				foreach ($jumlah as $value) {
					$sum1 += $value->jumlah 
			?>
				<tr>
					<td width="60%">
						<?php echo $value->NM_PROGRAM ?>
					</td>
					<td width="40%"><b>&nbsp;Rp. <?php echo number_format($value->jumlah,0,'.',',') ?></b></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan='6'>
					<hr>
				</td>
			</tr>
			<tr>
				<td><b> Jumlah</b></td>
				<td><b>&nbsp;Rp. <?php echo number_format($sum1,0,'.',',') ?></b></td>
			</tr>
		</table>
		<p></p>

		<table width="100%">
			<tr>
				<td width="17%"><b>Tanggal</b></td>
				<td width="2%">:</td>
				<td align="left"><b><?php echo date('d F Y'); ?></b></td>
			</tr>
		</table>
		<p></p>
		<table width="100%">
			<tr> 
				<?php $widthMenu = 100/2;?>
				<td width="<?php echo round($widthMenu);?>%" align="center"> Petugas Validasi </td>
				<td width="<?php echo round($widthMenu);?>%" align="center"> Petugas Lapangan </td>
				<!-- <td width="<?php echo round($widthMenu);?>%" align="center"> &nbsp; </td> -->
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>	
				<td width="<?php echo round($widthMenu);?>%" align="center">
					( <?php echo $petugas2->name ?> )
				</td>
				<td width="<?php echo round($widthMenu);?>%" align="center">
					 ( <?php echo $petugas->name ?> ) 
				</td>
				<!-- <td width="<?php echo round($widthMenu);?>%" align="center"> &nbsp; </td> -->
			</tr>

		</table>
	</div>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>