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
					<td colspan="2" align="center">REKAP HARIAN TOTAL PER JUNGUT</td>
				</b>
			</tr>
			<tr class="tableheader">
                <td align="center">PERIODE : 
					<?php echo date('d-m-Y', strtotime($date['tanggal1']))?> s/d
					<?php echo date('d-m-Y', strtotime($date['tanggal2']))?>&nbsp;&nbsp;&nbsp;TANGGAL CETAK :
					<?php echo date('d-m-Y h:i') ?>
                </td>
			</tr>
		</table>
		<p>
			<p>
            <table width="100%" border="1" >
	<tr>
		<td rowspan="2">No.</td>
		<td rowspan="2">Kode Jungut</td>
		<td rowspan="2">Nama</td>
		<td colspan="2">Target</td>
		<td colspan="2">Tot Perolehan</td>
		<td colspan="2">Rata-Rata</td>
		<td rowspan="2">Rata2</td>	
		<td colspan="2">Keuangan</td>		
	</tr>
	<tr>
		<td>Donatur</td>
		<td >Donasi</td>
		<td>Donatur</td>
		<td >Donasi</td>
		<td>Donatur</td>
		<td >Donasi</td>
		<td>Setor</td>
		<td >Belum Setor</td>
	</tr>
    <?php $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = 0;
    foreach ($rekap as $key => $rekap) { 
        $sum1 += $rekap->t_dnt;
        $sum2 += $rekap->t_dns;
        $sum3 += $rekap->h_dnt;
        $sum4 += $rekap->h_dns;
        $sum5 += round(100*($rekap->h_dnt/$rekap->t_dnt) / $count->total ,2);
        $sum6 += round(100*($rekap->h_dns/$rekap->t_dns) / $count->total ,2);
        $sum8 += $rekap->keu_y;
        $sum9 += $rekap->keu_n;
        ?>
	    <tr>
			<td ><?php echo $key+1 ?></td>
			<td align='center'><?php echo $rekap->kodej ?></td>
			<td ><?php echo $rekap->name ?></td>
			<td align='right'><?php echo number_format($rekap->t_dnt,0,'.',',') ?></td>
			<td align='right'><?php echo number_format($rekap->t_dns,0,'.',',') ?></td>
			<td align='right'><?php echo number_format($rekap->h_dnt,0,'.',',') ?></td>
			<td align='right'><?php echo number_format($rekap->h_dns,0,'.',',') ?></td>
			<td align='right'><?php echo round(100*($rekap->h_dnt/$rekap->t_dnt),2)."%" ?></td>
			<td align='right'><?php echo round(100*($rekap->h_dns/$rekap->t_dns),2)."%" ?></td>
			<td align='right'><?php echo (((round(100*($rekap->h_dnt/$rekap->t_dnt),2))+(round(100*($rekap->h_dns/$rekap->t_dns),2))) / 2)."%"?></td>
			<td align='right'><?php echo number_format($rekap->keu_y,0,'.',',') ?></td>
			<td align='right'><?php echo number_format($rekap->keu_n,0,'.',',') ?></td>
		</tr>
    <?php } $sum7 += (($sum5)+($sum6)) / 2; ?>
         
        <tr>
			<td colspan=3>J U M L A H</td>
			<td align='right'><?php echo number_format($sum1,0,'.',',') ?></td>
			<td align='right'><?php echo number_format($sum2,0,'.',',') ?></td>			
			<td align='right'><?php echo number_format($sum3,0,'.',',') ?></td>					
			<td align='right'><?php echo number_format($sum4,0,'.',',') ?></td>						
			<td align='right'><?php echo $sum5."%" ?></td>			
			<td align='right'><?php echo $sum6."%" ?></td>		
			<td align='right'><?php echo $sum7."%" ?></td>						
			<td align='right'><?php echo number_format($sum8,0,'.',',') ?></td>		
			<td align='right'><?php echo number_format($sum9,0,'.',',') ?></td>
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