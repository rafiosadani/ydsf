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
				<td width="17%" align="left">Nama Petugas</td>
				<td width="2%">:</td>
				<td width="20%"><?php echo $petugas->name ?></td>
				<td align="left">Tanggal : <?php echo date('d F Y', strtotime($petugas->tgl_setor)) ?></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="17%">No Slip/No Kasir</td>
				<td width="2%">:</td>
				<td width="20%"><?php echo $petugas->noslip." / ".$petugas->no_kasir ?></td>
				<?php if ($petugas->NM_BANK == 'TUNAI / TITIP') : ?>
					<td width="10%" align="left"><input type="checkbox" checked> Tunai</td>
					<td><input type="checkbox">Bank</td>
				<?php endif; ?>
				<?php if ($petugas->NM_BANK != 'TUNAI / TITIP') : ?>
					<td width="10%" align="left"><input type="checkbox"> Tunai</td>
					<td><input type="checkbox" checked>Bank</td>
				<?php endif; ?>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="17%">Nama Bank/Rec</td>
				<td width="2%">:</td>
				<td><?php echo $petugas->NM_BANK." / ".$petugas->rec ?></td>
			</tr>
		</table>
		<p></p>
		<table width="100%">
			<tr>
				<td width="15%"> Nama Program</td>
				<td width="15%"> Jumlah</td>
				<?php if ($data['cek'] == 1) : ?>
					<td >Kwitansi Gagal</td>
				<?php endif; ?>
				<?php if ($data['cek'] == 0) : ?>
					<td ></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td colspan='4'>
					<hr>
				</td>
			</tr>
			<?php 
				$sum1 = $sum2 = 0;
				foreach ($jumlah as $value) {
					$sum1 += $value->jumlah 
			?>
				<tr>
					<td width="20%">
						<?php echo $value->NM_PROGRAM ?>
					</td>
					<td width="20%"><b>&nbsp;Rp. <?php echo number_format($value->jumlah,0,'.',',') ?></b></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan='4'>
					<hr>
				</td>
			</tr>
			<tr>
				<td><b> Jumlah</b></td>
				<td><b>&nbsp;Rp. <?php echo number_format($sum1,0,'.',',') ?></b></td>
				<?php if ($data['cek'] == 1) : ?>
					<td><b>&nbsp;Rp. <?php echo number_format($sum2,0,'.',',') ?></b></td>
				<?php endif; ?>
			</tr>
		</table>
		<p></p>


		<table width="100%">
			<tr>
				<td width="17%">Keterangan</td>
				<td width="5%">:</td>
				<td width="85%"><?php echo $petugas->ket ?></td>
			</tr>
		</table>
		<p></p>
		<table width="100%">
			<tr> 
				<?php $widthMenu = 100/4;?>
				<?php if ($data['cek'] == 0) : ?>
					<td width="<?php echo round($widthMenu);?>%" align="center"> Manager Penghimpunan </td>
					<td width="<?php echo round($widthMenu);?>%" align="center"> Petugas Validasi </td>
				<?php endif; ?>
				<?php if ($data['cek'] == 1) : ?>
					<td width="<?php echo round($widthMenu);?>%" align="center"> Ttd. Kasir </td>
					<td width="<?php echo round($widthMenu);?>%" align="center"> Ttd. Adm Penghimp. </td>
				<?php endif; ?>
				<td width="<?php echo round($widthMenu);?>%" align="center"> Petugas Lapangan </td>
				<td width="<?php echo round($widthMenu);?>%" align="center"> &nbsp; </td>
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
				<?php if ($data['cek'] == 0) : ?>
					<td width="<?php echo round($widthMenu);?>%" align="center">
						(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
					</td>
					<td width="<?php echo round($widthMenu);?>%" align="center">
						( <?php echo $petugas2->name ?> )
					</td>
				<?php endif; ?>
				<?php if ($data['cek'] == 1) : ?>
					<td width="<?php echo round($widthMenu);?>%" align="center">
						(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
					</td>
					<td width="<?php echo round($widthMenu);?>%" align="center">
						(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
					</td>
				<?php endif; ?>
				<td width="<?php echo round($widthMenu);?>%" align="center"> ( <?php echo $petugas->name ?> ) </td>
				<td width="<?php echo round($widthMenu);?>%" align="center"> &nbsp; </td>
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