<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">


	<div class="box-body table-responsive">
		<table width="100%">
			<tr class="tableheader">
				<b>
					<td colspan="2" align="center">REKAP LAPORAN PENERIMAAN TUNAI
					</td>
				</b>
			</tr>
			<tr class="tableheader">
				<b>
					<td colspan="2" align="center">Yayasan Dana Sosial Al Falah
					</td>
				</b>
			</tr>
			<tr class="tableheader">
				<td align="center">
					PERIODE :
					<?php echo date('d-m-Y', strtotime($date['tanggal1']))?> s/d
					<?php echo date('d-m-Y', strtotime($date['tanggal2']))?>&nbsp;&nbsp;&nbsp;TANGGAL CETAK :
					<?php echo date('d-m-Y H:i') ?>
				</td>
			</tr>
			<tr>
				<td>
					<p>
						<p>
							<table width="100%" border="1">
								<tr class="style1">
									<th>Nomor Validasi</th>
									<th style="text-align: center;">Petugas</th>
									<th style="text-align: center;">Jumlah</th>
								</tr>	
								<?php $sum1 = 0;
									foreach($prl as $key => $prl) {
										$sum1 += $prl->nominal;
								?>
								<tr>
									<td>
										<?php echo $prl->val_tunai . ' - ' . $prl->id_tunai ?>
									</td>
									<td>
										<?php echo $prl->name ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->nominal,0,',','.') ?>
									</td>
								<tr>
									<?php } ?>
								<tr class='style1'>
									<td colspan="2"><b>J U M L A H</b></td>
									<td align=right>
										<b><?php echo number_format($sum1,0,',','.') ?></b>
									</td>
								</tr>
							</table>
							<p><p><p>
				</td>
			</tr>
			<!-- <tr>
				<td>
					<table width="100%" border="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="33%" align="center"> Ttd. Kasir </td>
							<td width="33%" align="center"> Ttd. Manager Penghimp. </td>
							<td width="33%" align="center"> Ttd. Petugas Lapangan </td>&nbsp;
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
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="33%" align="center"> ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
							<td width="33%" align="center"> ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
							<td width="33%" align="center"> ( <?php echo $ptgs->name ?> )</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				<td>
			</tr> -->
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