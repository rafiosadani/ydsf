<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('partials/head') ?>
    <style type="text/css">
    body{
      margin-top: -9px;
      font-family: arial;
      color: black;
    }
    table{
      margin-top: 0;
      width: 100%;
      margin: 0;
    }
    tr{
      border: 1px solid black;
      width: 100%;
      height: 18px;
    }
    td{
      border: 1px solid black;
      text-align: right;
      padding-left: 5px;
      padding-right: 5px;
    }
    span{
      padding-right: 10px;
      text-transform: uppercase;
    }
	p{
		padding-top:5px;
		font-size: 15px;
	}
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="box-body table-responsive">
		<p>
			<b>
				Rekap Perbandingan Perolehan Ramadhan Dengan RKAY 
				<?php 
				foreach ($thn as $tampil) {
					echo substr($tampil->tgl_awal,0,4);
					$thn_ini = substr($tampil->tgl_awal,0,4);
				}
				?>
				<br> 
				Pintu : <?php echo $pintu?> <br>
				Tanggal Cetak : <?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d h:i:s"); ?>
			</b>
		</p>
		<table>
			<tr>
				<td style="text-align:left;"><b>Cabang</b></td>
				<td style="text-align:left;"><b>RKAY RMD (a)</b></td>
				<td style="text-align:left;"><b>Ramadhan <?php echo $thn_ini-1?> (b)</b></td>
				<td style="text-align:left;"><b>Ramadhan <?php echo $thn_ini?> (c)</b></td>
				<td style="text-align:left;"><b>% <?php echo $thn_ini?> vs RKAY</b></td>
				<td style="text-align:left;"><b>% <?php echo $thn_ini?> vs <?php echo $thn_ini-1?></b></td>
			</tr>
			<?php
			foreach ($rekap_pintu as $tampil) {
				?>
				<tr>
					<td style="text-align:left;"><?php echo $tampil->nm_cabang?></td>
					<td><?= number_format($tampil->rkay_rmd,0,'.','.')?></td>
					<td><?= number_format($tampil->rmd_thn_llu,0,'.','.')?></td>
					<td><?= number_format($tampil->rmd_thn_ini,0,'.','.')?></td>
					<?php
					if($tampil->rkay_rmd==0 || $tampil->rmd_thn_ini==0 ){
					?>
					<td>0%</td>
					<?php
					}else{
					?>
					<td><?php echo number_format(($tampil->rmd_thn_ini/$tampil->rkay_rmd*100),2,',',',')?>%</td>
					<?}?>
					<?php
					if($tampil->rmd_thn_llu==0 || $tampil->rmd_thn_ini==0 ){
					?>
					<td>0%</td>
					<?php
					}else{
					?>
					<td><?php echo number_format(($tampil->rmd_thn_ini/$tampil->rmd_thn_llu*100),2,',',',')?>%</td>
					<?php
				}
				?>
				</tr>
				
				<?php
			}
			?>
			<tr>
				<td style="text-align:left;"><b>Total</b></td>
				<?php
				$tota = 0;
				foreach ($rekap_pintu as $tampil) {
				$tota = $tampil->rkay_rmd + $tota;	
				}
				?>
				<td><?php echo number_format($tota,0,'.','.')?></td>
				<?php
				$totb = 0;
				foreach ($rekap_pintu as $tampil) {
				$totb = $tampil->rmd_thn_llu + $totb;	
				}
				?>
				<td><?php echo number_format($totb,0,'.','.')?></td>
				<?php
				$totc = 0;
				foreach ($rekap_pintu as $tampil) {
				$totc = $tampil->rmd_thn_ini + $totc;	
				}
				?>
				<td><?php echo number_format($totc,0,'.','.')?></td>
				<?php
					if($tota==0 || $totc==0 ){
						?>
						<td>0%</td>
						<?php
						}else{
						?>
						<td><?php echo number_format(($totc/$tota*100),2,',',',')?>%</td>
						<?}?>
				
				<?php
					if($totb==0 || $totc==0 ){
						?>
						<td>0%</td>
						<?php
						}else{
						?>
						<td><?php echo number_format(($totc/$totb*100),2,',',',')?>%</td>
						<?}?>
				
			</tr>
		</table>
	</div>
  </body>
</html>
