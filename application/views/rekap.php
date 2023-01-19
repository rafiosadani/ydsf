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
					<td colspan="2" align="center">REKAP PEROLEHAN TOTAL PER JUNGUT</td>
				</b>
			</tr>
			<tr class="tableheader">
				<td align="center">KODE JUNGUT :
					<?php echo $ptgs->kodej  ?> &nbsp;&nbsp;&nbsp;PERIODE :
					<?php echo date('d-m-Y', strtotime($date['tanggal1']))?> s/d
					<?php echo date('d-m-Y', strtotime($date['tanggal2']))?>&nbsp;&nbsp;&nbsp;TANGGAL CETAK :
					<?php echo date('d-m-Y h:i') ?>
				</td>
			</tr>
			<tr>
				<td>
					<p>
						<p>
							<table width="100%" border="1">
								<tr class="style1">
									<td rowspan="2">
										No.
									</td>
									<td rowspan="2">
										Kawasan
									</td>

									<td colspan="2">
										Target
									</td>

									<td rowspan="2">
										RK
									</td>
									<td colspan="2">
										Hasil
									</td>
									<td colspan="2">
										Gagal
									</td>
									<td colspan="2">
										Donatur Baru
									</td>
									<td colspan="2">
										Lebih
									</td>

									<td colspan="2">
										Total
									</td>
									<td colspan="2">
										%
									</td>
									<td colspan="2">
										Kwitansi Gagal
									</td>
								</tr>
								<tr class="style1">
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>
									<td>
										Donatur
									</td>
									<td>
										Donasi
									</td>

									<td>
										DNT
									</td>
									<td>
										DNS
									</td>

									<td>
										DNT
									</td>
									<td>
										DNS
									</td>
								</tr>
								<?php $sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;$sum5 = 0;$sum6 = 0;
										$sum7 = 0;$sum8 = 0;$sum9 = 0;$sum10 = 0;$sum11 = 0;$sum12 = 0;
										$sum13 = 0;$sum14 = 0;$sum15 = 0;$sum16 = 0;
									foreach($prl as $key => $prl) {
										$sum1 += $prl->Trg_dnt;
										$sum2 += $prl->trg_dns;
										$sum3 += $prl->hsl_dnt;
										$sum4 += $prl->hsl_dns;
										$sum5 += $prl->ggl_dnt;
										$sum6 += $prl->ggl_dns;
										$sum7 += $prl->br_dnt;
										$sum8 += $prl->br_dns;
										$sum9 += $prl->lb_dnt;
										$sum10 += $prl->lb_dns;
										$sum11 += $prl->ttl_dnt;
										$sum12 += $prl->ttl_dns;
										$sum15 += $prl->btl_dnt;
										$sum16 += $prl->btl_dns;
										 //echo "<pre>";
										 //print_r($count->total);
										 //echo "</pre>";return;
										//$sum14 += round(100*($prl->ttl_dns/$prl->trg_dns) / $count->total ,2);
										//$sum13 += round(100*($prl->ttl_dnt/$prl->Trg_dnt) / $count->total ,2);
								?>
								<tr>
									<td>
										<?php echo $key+1 ?>
									</td>
									<td>
										<?php echo $prl->kwsn ?>
									</td>
									<td align=right>
										<?php echo $prl->Trg_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->trg_dns,0,',','.') ?>
									</td>
									<td>
										<?php echo $prl->rk ?>
									</td>
									<td align=right>
										<?php echo $prl->hsl_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->hsl_dns,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $prl->ggl_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->ggl_dns,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $prl->br_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->br_dns,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $prl->lb_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->lb_dns,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $prl->ttl_dnt ?>
									</td>
									<td align=right>
										<?php echo number_format($prl->ttl_dns,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo round(100*($prl->ttl_dnt/$prl->Trg_dnt),2).'%' ?>
									</td>
									<td align=right>
										<?php echo round(100*($prl->ttl_dns/$prl->trg_dns),2).'%' ?>
									</td>
									<td align=right>
										<?php echo $prl->btl_dnt ?>
									</td>
									<td align=right>
										<?php echo $prl->btl_dns ?>
									</td>
								<tr>
									<?php } ?>
								<tr class='style1'>
									<td colspan=2>J U M L A H</td>
									<td align=right>
										<?php echo $sum1 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum2,0,',','.') ?>
									</td>
									<td> </td>
									<td align=right>
										<?php echo $sum3 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum4,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $sum5 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum6,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $sum7 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum8,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $sum9 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum10,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo $sum11 ?>
									</td>
									<td align=right>
										<?php echo number_format($sum12,0,',','.') ?>
									</td>
									<?php $sum13 = round(100*($sum1/$sum11),2)	?>
									<td align=right>
										<?php echo $sum13.'%' ?>
									</td>
									<?php $sum14 = round(100*($sum2/$sum12),2)	?>
									<td align=right>
										<?php echo $sum14.'%' ?>
									</td>
									<td align=right>
										<?php echo number_format($sum15,0,',','.') ?>
									</td>
									<td align=right>
										<?php echo number_format($sum16,0,',','.') ?>
									</td>
								</tr>
							</table>
							<p><p><p>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1">
						<tr class="style1">
							<td>
								No
							</td>
							<td>
								Program
							</td>
							<td>
								Tertagih
							</td>
							<td>
								Keuangan
							</td>
							<td>
								Blm Setor
							</td>
							<td>
								Kwitansi Balik
							</td>
						</tr>
						<?php 
							$sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;
							foreach ($jumlah as $key => $value) {
							$sum1 += $value->jumlah;
							$sum2 += $value->keuangan;
							$sum3 += $value->belum;
						?>
						<tr>
							<td>
								<?php echo $key+1 ?>
							</td>
							<td>
								<?php echo $value->program ?>
							</td>
							<td align=right>
								<?php echo number_format($value->jumlah,0,',','.') ?>
							</td>

							<td align=right>
								<?php echo number_format($value->keuangan,0,',','.') ?>
							</td>
							<td align=right>
								<?php echo number_format($value->belum,0,',','.') ?>
							</td>
							<td align=right>
								<table>
								<?php
									foreach ($this->mprogram->getKwitansi($value->prog) as $a) {
										 $sum4 += $a->kwitansi;
										 ?>
									<tr>
										<td><?php echo number_format($a->kwitansi,0,',','.') ?></td>
									</tr>
									<?php } ?> 
									</table>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td colspan='2'><b>J U M L A H</b></td>
							<td align=right>
								<b><?php echo number_format($sum1,0,',','.') ?></b>
							</td>
							<td align=right>
								<b><?php echo number_format($sum2,0,',','.') ?></b>
							</td>
							<td align=right>
								<b><?php echo number_format($sum3,0,',','.') ?></b>
							</td>
							<td align=right>
								<b><?php echo number_format($sum4,0,',','.') ?></b>
							</td>
						</tr>
					</table>
					<p>
						<p>
				</td>
			</tr>
			<tr>
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