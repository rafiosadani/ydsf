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
					<td colspan="2" align="center">REKAP LAPORAN PER PROGRAM</td>
				</b>
			</tr>
			<tr class="tableheader">
				<?php $post = $this->input->post();
					if (($post['tglhimp'] != "" && $post['tglval'] != "") || ($post['tglhimp'] == "" && $post['tglval'] != "")) : ?>
						<td align="center" colspan="2"><?php echo "PERIODE : TANGGAL KEUANGAN ".$date['date_val1']." s/d ".$date['date_val2'] ?></td>
				<?php endif; ?>
				<?php $post = $this->input->post();
					if ($post['tglhimp'] != "" && $post['tglval'] == "") : ?>
						<td align="center" colspan="2"><?php echo "PERIODE : TANGGAL PENGHIMPUNAN ".$date['date_himp1']." s/d ".$date['date_himp2'] ?></td>
				<?php endif; ?>
			</tr>
		</table>
		<p>
			<p>
				<?php if ($this->input->post('cabang') == '-') : ?>
					<table width="100%" border="1">
						<tr class="style1">
							<td rowspan="2">
								Program
							</td>
							<?php
							if($this->session->userdata('admin_grup')==TRUE){
								foreach ($this->mprogram->getCabangGrup() as $cabang) : ?>
								<td colspan="2">
									<?php echo $cabang->nm_cabang ?>
								</td>
							<?php endforeach; }else{
							
							foreach ($this->mprogram->getCabang() as $cabang) : ?>
								<td colspan="2">
									<?php echo $cabang->nm_cabang ?>
								</td>
							<?php endforeach;} ?>
								<td rowspan="2">
									Total
								</td>
						</tr>
						<tr class="style1">
							<?php if($this->session->userdata('admin_grup')==TRUE) {
							for ($x = 0;$x < count($this->mprogram->getCabangGrup()); $x++) { ?>
								<td>
									JUNGUT
								</td>
								<td>
									KANTOR
								</td>
							<?php } }else{
								for ($x = 0;$x < count($this->mprogram->getCabang()); $x++) { ?>
								<td>
									JUNGUT
								</td>
								<td>
									KANTOR
								</td>
							<?php } }?>
						</tr>
						
						<?php $sumt = 0; foreach($perProgram as $program) { 
							$sumt += $program->total ?>
								<tr class='style1'>
									<td>
										<?php echo $program->program ?>
									</td>
							<?php
								// $y = ;
								// $z=$y."_jungut";
								// $v=$y."_kantor";
								if($this->session->userdata('admin_grup') == TRUE){
									$cabang = $this->mprogram->getCabangGrup(); 
								}else{
									$cabang = $this->mprogram->getCabang(); 
								}
								for ($x = 0; $x < count($cabang); $x++) { 
									$y = $cabang[$x]->cabang.'_jungut';
									$z = $cabang[$x]->cabang.'_kantor';
									// echo $y;
							?>

								<td align=right>
									<?php echo number_format($program->$y,0,'.',',') ?>
								</td>
								<td align=right>
									<?php echo number_format($program->$z,0,'.',',') ?>
								</td>
							<?php } ?>
								<td align=right>
									<?php echo number_format($program->total,0,'.',',') ?>
								</td>
							</tr>
						<?php } ?>
							
						<tr class='style1'>
							<td>J U M L A H</td>
							<?php 
								$sumj = $sumk = 0;
								$j = array();
								if($this->session->userdata('admin_grup')==TRUE){
									$cab = $this->mprogram->getCabangGrup();
								}else{									
									$cab = $this->mprogram->getCabang();
								}
								
								for ($a = 0; $a < count($cab); $a++) {
									$j[] = [$cab[$a]->cabang.'_jungut',
									$cab[$a]->cabang.'_kantor'];
								}

								$sum = array();
								
								for ($a = 0;$a < count($cab); $a++) {
									$jungut = $j[$a][0];
									$kantor = $j[$a][1];
									for ($v = 0;$v < count($perProgram);$v++) {
										$sumj += $perProgram[$v]->$jungut;
										$sumk += $perProgram[$v]->$kantor;
									}
									$sum[] = [$sumj,$sumk];
									$sumj = 0;
									$sumk = 0;
								}
							?>

							<?php foreach ($sum as $sum ) {
								?>
								<td align=right><?php echo number_format($sum[0],0,'.',',') ?></td>
								<td align=right><?php echo number_format($sum[1],0,'.',',') ?></td>
							<?php } ?>

							<td align=right>
								<?php echo number_format($sumt,0,'.',',') ?>
							</td>
						</tr>
					</table>
				<?php endif; ?>
				<?php if ($this->input->post('cabang') != '-') : ?>
				<table width="100%" border="1">
					<tr class="style1">
						<td rowspan="2">
							Program
						</td>
						<?php 
							$cbg = "";
							$namacab = $this->mprogram->getCabang();
							for ($s = 0; $s < count($namacab);$s++) {
								if ($namacab[$s]->id_cab == $this->input->post('cabang')) {
									$cbg = $namacab[$s]->nm_cabang;
								}
							} 
						?>
						<td colspan="2">
								<?php echo $cbg ?>
						</td>
						
						<td rowspan="2">
							Total
						</td>
					</tr>
					<tr class="style1">
						<td>
							JUNGUT
						</td>
						<td>
							KANTOR
						</td>
					</tr>
					<?php
						$sum1 = $sum2 = $sum3 = 0;
						foreach ($perProgram as $program) {
						$sum1 += $program->jungut;
						$sum2 += $program->kantor;
						$sum3 += $program->total;	 
					?>
					<tr class="style1">
						<td><?php echo $program->program ?></td>
						<td align=right><?php echo number_format($program->jungut, 0, '.', ',') ?></td>
						<td align=right><?php echo number_format($program->kantor, 0, '.', ',') ?></td>
						<td align=right><?php echo number_format($program->total, 0, '.', ',') ?></td>
					</tr>
					<?php } ?>
					<tr class="style1">
						<td>J U M L A H</td>
						<td align=right><?php echo number_format($sum1, 0, '.', ',') ?></td>
						<td align=right><?php echo number_format($sum2, 0, '.', ',') ?></td>
						<td align=right><?php echo number_format($sum3, 0, '.', ',') ?></td>
					</tr>
				</table>
				<?php endif; ?>
	</div>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>