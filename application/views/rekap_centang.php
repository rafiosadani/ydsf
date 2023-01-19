<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div align="center">
<!-- -->
</div>
	<div class="box-body table-responsive">
		<table width="100%" border="1">
            <tr>
                <td rowspan="2">No</td>
                <td rowspan="2">Kodej</td>
                <td rowspan="2">Nama</td>
                <td rowspan="2">Dep</td>
                <td colspan="3">Jumlah</td>
            </tr>
            <tr>
            <td>Qty</td>
            <td>Donatur</td>
            <td>Donasi</td>
            </tr>        
			<?php $totdnt=0;$totdns=0;$totqty=0; foreach($centang as $no => $centang): 
			$totqty += intval($centang->qty);
			$totdnt += intval(str_replace(',','',$centang->tot_dnt));
			$totdns += intval(str_replace(',','',$centang->jumlah));
			?>			
            <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $centang->kodej ?></td>
            <td><?php echo $centang->nama?></td>
            <td><?php echo $centang->cabang ?></td>
            <td align="right"><?php echo $centang->qty ?></td>
            <td align="right"><?php echo $centang->tot_dnt ?></td>
            <td align="right"><?php echo $centang->jumlah ?></td>
            </tr>
            <?php endforeach; ?>
			<tr>
			<td colspan="4">Total</td>
			<td align="right"><?php echo $totqty ?></td>
			<td align="right"><?php echo $totdnt ?></td>
			<td align="right"><?php echo number_format($totdns,0,',',',') ?></td>
			</tr>
                        
		</table>
	</div>
    <!-- <table width="100%" border="0">
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
							<td width="33%" align="center"> ( <?php if(isset($petugas)){echo $petugas->name ;}?> )</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table> -->



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>