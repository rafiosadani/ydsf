<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div align="center">
<b>REKAP SETORAN<br>
KODE JUNGUT : <?php echo $petugas->kodej ?> &nbsp;  PERIODE : <?php echo date('d-m-Y',strtotime($date['tanggal1'])); ?> S/D  <?php echo date('d-m-Y',strtotime($date['tanggal2'])); ?>
</b>
</div>
	<div class="box-body table-responsive">
        <table width="100%" border="1">
            <tr>
                <td>No.</td>
                <td>No Slip</td>
                <td>Tanggal Setor</td>
                <td>BANK</td>
                <td>Jumlah</td>
            </tr>
            <?php $tot=0; foreach($setoran as $no => $setoran): ?>
            <tr>
                <td><?php echo $no+1 ?></td>
                <td><?php echo $setoran->noslip ?></td>
                <td><?php echo $setoran->tgl_setor ?></td>
                <td><?php echo $setoran->nama_bank.' / '.$setoran->rek ?></td>
                <td><?php  echo number_format($setoran->jumlah,0,',',',');$tot+=$setoran->jumlah; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
            <td colspan="4">TOTAL</td>
            <td><?php echo number_format($tot,0,',',','); ?></td>
            </tr>
        </table>

        <table width="100%" border="1" style="margin-top:20px;">
            <tr>
                <td>No</td>
                <td>Program</td>
                <td>Tertagih</td>
                <td>Keuangan</td>
                <td>Blm Setor</td>
                <td>Kwitansi Balik</td>
            </tr>
            <?php
            $sum1=0;
            $sum2=0;
            $sum3=0;
            $sum4=0;
            foreach($program as $no => $program): ?>
            <tr>
                <td><?php echo $no+1 ?></td>
                <td><?php echo $program->program ?></td>
                <td><?php echo number_format($program->jumlah,0,',',',');$sum1+=$program->jumlah; ?></td>
                <td><?php echo number_format($program->keuangan,0,',',',');$sum2+=$program->keuangan; ?></td>
                <td><?php echo number_format($program->belum,0,',',',');$sum3+=$program->belum; ?></td>
                <?php  foreach ($this->msetoran->getKwitansi($program->prog) as $a) {
                                         $sum4 += $a->kwitansi;                                        
										 ?>
										<td><?php echo number_format($a->kwitansi,0,',','.') ?></td>
				<?php } ?> 
            </tr>
            <?php endforeach; ?>
            <tr>
            <td colspan="2"><b> JUMLAH </b></td>
            <td><b><?php echo number_format($sum1,0,',',',') ?></b></td>
            <td><b><?php echo number_format($sum2,0,',',',') ?></b></td>
            <td><b><?php echo number_format($sum3,0,',',',') ?></b></td>
            <td><b><?php echo number_format($sum4,0,',',',') ?></b></td>
            </tr>
        </table>

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
							<td width="33%" align="center"> ( <?php echo $petugas->name ?> )</td>
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